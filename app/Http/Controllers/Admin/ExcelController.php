<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\{Spreadsheet, Writer\Xlsx};
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\{
    Student\StudentAccount,
    Admin\AdminAccount,
    Teacher\TeacherAccount,
    Guidance\GuidanceAccount,
    Admin\SubjectModel,
    History
};

class ExcelController extends Controller
{
    public function exportAdminList()
    {
        $admins = AdminAccount::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Gender');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Position');
        $sheet->setCellValue('G1', 'Role');
        $sheet->setCellValue('H1', 'Address');
        $sheet->setCellValue('I1', 'Phone Number');

        // Populate data
        $row = 2;
        foreach ($admins as $admin) {
            $sheet->setCellValue('A' . $row, $admin->id_number);
            $sheet->setCellValue('B' . $row, $admin->name);
            $sheet->setCellValue('C' . $row, $admin->gender);
            $sheet->setCellValue('D' . $row, $admin->username);
            $sheet->setCellValue('E' . $row, $admin->email);
            $sheet->setCellValue('F' . $row, $admin->position);
            $sheet->setCellValue('G' . $row, $admin->role);
            $sheet->setCellValue('H' . $row, $admin->address);
            $sheet->setCellValue('I' . $row, $admin->phone_number);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'admin_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported admin list",
                'description' => null
            ]
        );

        return $response;
    }

    public function exportStudentList()
    {
        $students = StudentAccount::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Gender');
        $sheet->setCellValue('D1', 'Strand');
        $sheet->setCellValue('E1', 'Grade');
        $sheet->setCellValue('F1', 'Parent\'s Contact Number');
        $sheet->setCellValue('G1', 'Username');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Role');
        $sheet->setCellValue('J1', 'Phone Number');
        $sheet->setCellValue('K1', 'Address');
        $sheet->setCellValue('L1', 'Section');

        // Populate data
        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student->id_number);
            $sheet->setCellValue('B' . $row, $student->name);
            $sheet->setCellValue('C' . $row, $student->gender);
            $sheet->setCellValue('D' . $row, $student->strand);
            $sheet->setCellValue('E' . $row, $student->grade);
            $sheet->setCellValue('F' . $row, $student->parents_contact_number);
            $sheet->setCellValue('G' . $row, $student->username);
            $sheet->setCellValue('H' . $row, $student->email);
            $sheet->setCellValue('I' . $row, $student->role);
            $sheet->setCellValue('J' . $row, $student->phone_number);
            $sheet->setCellValue('K' . $row, $student->address);
            $sheet->setCellValue('L' . $row, $student->section);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'student_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported student list",
                'description' => null
            ]
        );

        return $response;
    }

    public function teacherExportStudentList()
    {
        $students = StudentAccount::whereHas('handles', function ($query) {
            $query->where('teacher_id', Auth::id());
        })->get();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Gender');
        $sheet->setCellValue('D1', 'Strand');
        $sheet->setCellValue('E1', 'Grade');
        $sheet->setCellValue('F1', 'Parent\'s Contact Number');
        $sheet->setCellValue('G1', 'Username');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Role');
        $sheet->setCellValue('J1', 'Phone Number');
        $sheet->setCellValue('K1', 'Address');
        $sheet->setCellValue('L1', 'Section');

        // Populate data
        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student->id_number);
            $sheet->setCellValue('B' . $row, $student->name);
            $sheet->setCellValue('C' . $row, $student->gender);
            $sheet->setCellValue('D' . $row, $student->strand);
            $sheet->setCellValue('E' . $row, $student->grade);
            $sheet->setCellValue('F' . $row, $student->parents_contact_number);
            $sheet->setCellValue('G' . $row, $student->username);
            $sheet->setCellValue('H' . $row, $student->email);
            $sheet->setCellValue('I' . $row, $student->role);
            $sheet->setCellValue('J' . $row, $student->phone_number);
            $sheet->setCellValue('K' . $row, $student->address);
            $sheet->setCellValue('L' . $row, $student->section);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'student_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported student list",
                'description' => null
            ]
        );

        return $response;
    }

    public function exportGuidanceList()
    {
        $guidances = GuidanceAccount::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Gender');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Position');
        $sheet->setCellValue('G1', 'Role');
        $sheet->setCellValue('H1', 'Phone Number');
        $sheet->setCellValue('I1', 'Address');

        // Populate data
        $row = 2;
        foreach ($guidances as $guidance) {
            $sheet->setCellValue('A' . $row, $guidance->id_number);
            $sheet->setCellValue('B' . $row, $guidance->name);
            $sheet->setCellValue('C' . $row, $guidance->gender);
            $sheet->setCellValue('D' . $row, $guidance->username);
            $sheet->setCellValue('E' . $row, $guidance->email);
            $sheet->setCellValue('F' . $row, $guidance->position);
            $sheet->setCellValue('G' . $row, $guidance->role);
            $sheet->setCellValue('H' . $row, $guidance->phone_number);
            $sheet->setCellValue('I' . $row, $guidance->address);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'guidance_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported guindance list",
                'description' => null
            ]
        );
        return $response;
    }

    public function exportTeacherList()
    {
        $teachers = TeacherAccount::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'ID Number');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Gender');
        $sheet->setCellValue('D1', 'Role');
        $sheet->setCellValue('E1', 'Position');
        $sheet->setCellValue('F1', 'Grade Handle');
        $sheet->setCellValue('G1', 'Username');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Phone Number');
        $sheet->setCellValue('J1', 'Address');

        // Populate data
        $row = 2;
        foreach ($teachers as $teacher) {
            $sheet->setCellValue('A' . $row, $teacher->id_number);
            $sheet->setCellValue('B' . $row, $teacher->name);
            $sheet->setCellValue('C' . $row, $teacher->gender);
            $sheet->setCellValue('D' . $row, $teacher->role);
            $sheet->setCellValue('E' . $row, $teacher->position);
            $sheet->setCellValue('F' . $row, $teacher->grade_handle);
            $sheet->setCellValue('G' . $row, $teacher->username);
            $sheet->setCellValue('H' . $row, $teacher->email);
            $sheet->setCellValue('I' . $row, $teacher->phone_number);
            $sheet->setCellValue('J' . $row, $teacher->address);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'teacher_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');


        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported teacher list",
                'description' => null
            ]
        );

        return $response;
    }


    public function exportSubjectList()
    {
        $subjects = SubjectModel::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Subject');
        $sheet->setCellValue('B1', 'Teacher');
        $sheet->setCellValue('C1', 'Time');
        $sheet->setCellValue('D1', 'Created at');
        $sheet->setCellValue('E1', 'Updated at');

        // Populate data
        $row = 2;
        foreach ($subjects as $subject) {
            $teacher = TeacherAccount::where('id', $subject->teacher_id)->first();
            $sheet->setCellValue('A' . $row, $subject->subject);
            $sheet->setCellValue('B' . $row, $teacher->name);
            $sheet->setCellValue('C' . $row, $subject->time);
            $sheet->setCellValue('D' . $row, $subject->created_at);
            $sheet->setCellValue('E' . $row, $subject->updated_at);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'subject_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');


        $auth_user = Auth::user();
        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported subject list",
                'description' => null
            ]
        );


        return $response;
    }




    public function exportTeacherSubjectList()
    {
        $auth_user = Auth::user();
        $subjects = SubjectModel::where('teacher_id', (request()->query('teacher_id') ?request()->query('teacher_id') : $auth_user->id));

        $name = (request()->query('teacher_id') ? TeacherAccount::where('id', request()->query('teacher_id'))->first()->name : $auth_user->name);

        if(request()->query('grade_handle_id')) {
            $subjects = $subjects->where('grade_handle_id', request()->query('grade_handle_id'));
        }
        $subjects = $subjects->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Subject');
        $sheet->setCellValue('B1', 'Teacher');
        $sheet->setCellValue('C1', 'Time');
        $sheet->setCellValue('D1', 'Day');
        $sheet->setCellValue('E1', 'Created_at');

        // Populate data
        $row = 2;
        foreach ($subjects as $subject) {
            $sheet->setCellValue('A' . $row, $subject->subject);
            $sheet->setCellValue('B' . $row, $name);
            $sheet->setCellValue('C' . $row, $subject->time);
            $sheet->setCellValue('D' . $row, $subject->day);
            $sheet->setCellValue('E' . $row, $subject->created_at);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'teacher_subject_list_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');



        History::create(
            [
                'user_id' => $auth_user->id,
                'position' => $auth_user->role,
                'history' => "Exported subject list",
                'description' => null
            ]
        );


        return $response;
    }
}
