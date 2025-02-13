<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Support\Facades\Auth};
use App\Models\{Admin\SubjectModel, History, TeacherGradeHandle, Student\StudentAccount, StudentSubject};

class SubjectController extends Controller
{
    public function index()
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $allSubjects = SubjectModel::where('teacher_id', $user->id)->get();
            // $allStudentsCount = $this->countStudents();
            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
            return view('teacher.subject.index', ['user' => $user, 'allSubjects' => $allSubjects, "allStudentsCount" => 0, "handleSubjects" => $handleSubjects]);
        }

        return redirect()->route('teacher.login');
    }




    public function viewStudentSubjects($id)
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $student = StudentAccount::with('subjects.teacherAccount')->findOrFail($id);
            $subjects = SubjectModel::with('teacherAccount')->paginate(10);
            $handleSubjects = TeacherGradeHandle::where('teacher_id', $id)->get();

            return view('teacher.students.subject.view', [
                'user' => $user,
                'student' => $student,
                'subjects' => $subjects,
                'handleSubjects' => $handleSubjects
            ]);
        }

        return redirect()->route('teacher.login');
    }

    public function subjectList()
    {

        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $id = request()->query('id');

            if (!$id || !TeacherGradeHandle::find($id)) {
                return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
            }

            $subject_list = SubjectModel::where('teacher_id', $user->id)->where('grade_handle_id', $id)->paginate(100);

            $grade_handle = TeacherGradeHandle::find($id);
            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
            

            return view('teacher.subject.subject_list', [
                'user' => $user,
                'subject_list' => $subject_list,
                'id' => $id,
                'grade_handle' => $grade_handle,
                'handleSubjects' => $handleSubjects
            ]);
        }

        return redirect()->route('teacher.login');
    }




    public function countStudents()
    {
        $user = Auth::guard('teacher')->user();
        $subject = SubjectModel::where('teacher_id', $user->id)->first();
        $students = $subject->students()->count();
        return $students;
    }


    public function viewCreateSubject()
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $id = request()->query('id');

            if (!$id || !TeacherGradeHandle::find($id)) {
                return redirect()->route('teacher.dashboard')->with('error', 'Invalid grade handle ID');
            }

            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

            return view('teacher.subject.create', ['user' => $user, 'id' => $id, 'handleSubjects' => $handleSubjects]);
        }

        return redirect()->route('teacher.login');
    }




    public function deleteStudentSubject($student_id, $subject_id)
    {
        if (Auth::guard('teacher')->check()) {
            $student = StudentAccount::findOrFail($student_id);

            // Retrieve the subject details
            $subject = SubjectModel::findOrFail($subject_id);

            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Deleted a subject $subject->name from $student->name's account",
                    'description' => "Subject deleted: " . $subject->name
                ]
            );

            $student->subjects()->detach($subject_id);

            return redirect()->route('teacher.view.subjects', $student_id)->with('success', 'Subject deleted successfully');
        }

        return redirect()->route('teacher.login');
    }





    public function addSubject(Request $request)
    {
        $request->validate([
            'subject' => 'required|exists:subject_models,id',
            // 'subject_track' => 'required',
            'student_id' => 'required|exists:student_accounts,id',
        ]);

        $student = StudentAccount::find($request->student_id);
        $subject = SubjectModel::find($request->subject);

        if ($student && $subject) {
            if (!StudentSubject::where('student_id', $student->id)
                ->where('subject_id', $subject->id)->exists()) {
                $auth_user = Auth::user();
                $newStudentSubject = new StudentSubject([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    // 'subject_track' => $subject->subject_track,
                    'teacher_id' => $auth_user->id,
                    'grade_handle_id' => $request->query('id')
                ]);
                $newStudentSubject->save();

                History::create([
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Added the subject $subject->name to $student->name's account",
                    'description' => null
                ]);
            } else {
                return redirect()->back()->with('error', 'Subject already added to the student.');
            }

            return redirect()->back()->with('success', 'Subject added successfully!');
        }

        return redirect()->back()->with('error', 'Error adding subject.');
    }




    public function createSubject(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'day' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'subject_track' => 'required'
        ]);


        $auth_user = Auth::user();

        $time_start_12hr = $this->convertTo12HourFormat($request->time_start);
        $time_end_12hr = $this->convertTo12HourFormat($request->time_end);


        $subject = new SubjectModel([
            'subject' => $request->subject,
            'day' => $request->day,
            'teacher_id' => $auth_user->id,
            'subject_track' => $request->subject_track,
            'grade_handle_id' => $request->_id,
            'time' => $time_start_12hr . ' - ' . $time_end_12hr
        ]);
        $subject->save();


        // check if the student_id is set
        if (request()->query('student_id')) {
            $newStudentSubject = new StudentSubject([
                'student_id' => request()->query('student_id'),
                'subject_id' => $subject->id,
                'teacher_id' => $auth_user->id,
                'grade_handle_id' => $request->_id
            ]);
            $newStudentSubject->save();
            return redirect()->route('teacher.view.subjects', ['id' => request()->query('student_id')]);
        }


        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Created a subject",
                'description' => "Subject created: " . $subject->name
            ]
        );


        return redirect()->route('teacher.subject_list', ['id' => $request->_id])->with('success', 'Subject created successfully');
    }

    // Helper function
    public function convertTo12HourFormat($time)
    {
        $hours = intval(explode(':', $time)[0]);
        $minutes = explode(':', $time)[1];
        $period = $hours >= 12 ? 'PM' : 'AM';

        $hours = $hours % 12;
        $hours = $hours ? $hours : 12;

        return sprintf('%02d:%02d %s', $hours, $minutes, $period);
    }



    public function deleteSubject(Request $request, $id)
    {
        if (Auth::guard('teacher')->check()) {
            $subject = SubjectModel::findOrFail($id);

            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Deleted a subject $subject->name",
                    'description' => "Subject deleted: " . $subject->name
                ]
            );


            $subject->delete();

            return redirect()->route('teacher.subject_list', ['id' => $request->id])->with('success', 'Subject deleted successfully');
        }



        return redirect()->route('teacher.login');
    }



    public function deleteSelectedSubjects(Request $request)
    {
        $ids = $request->input('selected_ids');
        $idsArray = explode(',', $ids);

        SubjectModel::whereIn('id', $idsArray)->delete();
        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Deleted all selected subjects",
                'description' => "Deleted ids: $ids"
            ]
        );

        return redirect()->route('teacher.subject_list', ['id' => $request->id])->with('success', 'Selected row' . (count($idsArray) == 1 ? '' : 's') . ' have been deleted!');
    }



    public function viewEditSubject($id)
    {
        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            $subject = SubjectModel::findOrFail($id);
            $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();

            return view('teacher.subject.edit', ['user' => $user, 'subject' => $subject, 'handleSubjects' => $handleSubjects]);
        }

        return redirect()->route('teacher.login');
    }


    public function updateSubject(Request $request, $id)
    {
        if (Auth::guard('teacher')->check()) {
            $subject = SubjectModel::findOrFail($id);

            $request->validate([
                'subject' => 'required',
                'time' => 'required',
                'day' => 'required',
                'subject_track' => 'required'
            ]);

            $subject->update([
                'subject' => $request->subject,
                'subject_track' => $request->subject_track,
                'time' => $request->time,
                'day' => $request->day,
            ]);

            $subject->save();


            $auth_user = Auth::user();
            History::create(
                [
                    'user_id' => $auth_user->id,
                    'position' => $auth_user->role,
                    'history' => "Updated a subject $subject->name",
                    'description' => "Subject updated: " . $subject->name
                ]
            );

            return redirect()->route('teacher.subject_list', ['id' => request()->query('id')])->with('success', 'Subject updated successfully');
        }

        return redirect()->route('teacher.login');
    }
}
