<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\{Spreadsheet, Writer\Xlsx};
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\QrGenerate;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\SubjectModel;
use App\Models\History;

class ExportController extends Controller
{


    /**
     * Exports class history data to an Excel file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse The Excel file response.
     */
    public function exportClassHistory()
    {
        $user = Auth::user();

        // Simplified query
        $qrHistory = QrGenerate::where('teacher_id', $user->id)
            ->whereIn('id', function ($query) use ($user) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('qr_generates')
                    ->where('teacher_id', $user->id)
                    ->groupBy(
                        DB::raw('DATE(created_at)'),
                        'subject_id'
                    );
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Get subject details for each QR code
        foreach ($qrHistory as $history) {
            $history->subjectDetails = SubjectModel::where('id', $history->subject_id)->where('teacher_id', Auth::id())->first();
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Day');
        $sheet->setCellValue('C1', 'Subject');
        $sheet->setCellValue('D1', 'Teacher');
        $sheet->setCellValue('E1', 'Class Time');

        // Populate data
        $row = 2;
        foreach ($qrHistory as $history) {
            $sheet->setCellValue('A' . $row, $history->created_at->format('Y-m-d'));
            $sheet->setCellValue('B' . $row, $history->subjectDetails->day ?? 'N/A');
            $sheet->setCellValue('C' . $row, $history->subjectDetails->subject ?? 'N/A');
            $sheet->setCellValue('D' . $row, $user->name ?? 'N/A');
            $sheet->setCellValue('E' . $row, $history->subjectDetails->time ?? 'N/A');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'class_history_for_' . $user->name . '_' . uniqid() . '.xlsx';

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');



        History::create(
            [
                'user_id' => $user->id,
                'position' => $user->role,
                'history' => "Exported class history",
                'description' => null
            ]
        );

        return $response;
    }
}
