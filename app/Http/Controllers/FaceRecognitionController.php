<?php

namespace App\Http\Controllers;

use App\Models\Student\StudentAccount;
use App\Models\Admin\FaceRecognitionKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FaceRecognitionController extends Controller
{
    // view pattern blade
    public function viewPattern()
    {
        if (Session::get('authenticated_user')) {
            return redirect()->route('face.recognition');
        }

        return view('pattern_authentication');
    }

    public function setPattern()
    {
        $pattern = FaceRecognitionKey::first();

        return view('admin.face_recognition.set_pattern_auth', [
            'pattern' => $pattern,
            'user' => Auth::user()
        ]);
    }



    // pattern methods
    public function createPattern(Request $request)
    {
        $request->validate([
            'pattern' => 'required|string',
            'image' => 'required|string',
        ]);

        $image = $request->input('image');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $decodedImage = base64_decode($image);

        $destinationPath = public_path('storage/pattern_images');
        $imageName = 'pattern' . time() . '.png';

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filePath = $destinationPath . '/' . $imageName;
        file_put_contents($filePath, $decodedImage);

        $relativePath = 'pattern_images/' . $imageName;

        $existingPattern = FaceRecognitionKey::first();
        if ($existingPattern) {

            $existingPattern->update([
                'pattern' => $request->pattern,
                'image_path' => $relativePath,
                'updated_by_admin_id' => Auth::id(),
            ]);
            return response()->json([
                'message' => 'Pattern updated successfully!',
                'data' => $existingPattern,
                'success' => true,
            ]);
        } else {

            $patternKey = FaceRecognitionKey::create([
                'pattern' => $request->pattern,
                'image_path' => $relativePath,
                'created_by_admin_id' => Auth::id(),
            ]);
            return response()->json([
                'message' => 'Pattern created successfully!',
                'data' => $patternKey,
                'success' => true,
            ]);
        }
    }



    // pattern validation
    public function validatePattern(Request $request)
    {
        $request->validate([
            'pattern' => 'required|string',
        ]);

        $patternKey = FaceRecognitionKey::first();

        if (Hash::check($request->pattern, $patternKey->pattern)) {

            // Pattern matches
            Session::put('authenticated_user', true);

            return response()->json(['message' => 'Pattern validated successfully!', 'success' => true]);
        } else {
            // Pattern doesn't match
            return response()->json(['message' => 'Invalid pattern.', 'success' => false], 403);
        }
    }





    public function showFaceRecognition()
    {
        if (!Session::get('authenticated_user')) {
            return redirect()->route('face.recognition.pattern_auth');
        }

        return view('face_recognition');
    }

    public function getStudentLabels()
    {
        $students = StudentAccount::all();
        $labels = $students->map(function ($student) {
            return $student->name;
        });

        return response()->json($labels);
    }

    public function getStudentInfo($label)
    {
        $student = StudentAccount::where('name', $label)->first();

        if ($student) {
            return response()->json([
                'id' => $student->id,
                'name' => $student->name,
                'strand' => $student->strand,
                'gender' => $student->gender,
                'id_number' => $student->id_number,
                'parents_contact_number' => $student->parents_contact_number,
            ]);
        } else {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}
