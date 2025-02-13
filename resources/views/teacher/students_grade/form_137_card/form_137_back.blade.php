@extends('teacher.layouts.app')
@section('title', 'Form 137')
@section('content')
<style>
    table * {
        font-size: 11px;
    }


    @media print {
        #form_137 {
            width: 100vw !important;
            margin: 0 auto;
            min-height: 100vh;
            top: 0;
            left: 0;
            position: absolute;
            background-color: white;
        }
    }
</style>
<div class="mx-auto p-4 bg-white overflow-auto">
    <div class="flex my-3 gap-3">
        <button onclick="window.print()" class="px-5 py-1 bg-blue-800 text-white rounded">Print Form 137</button>
        |
        <a href="{{ route('teacher.form_137_front', $student->id) }}?id={{request()->query('id')}}" class="px-5 py-1 bg-green-800 text-white rounded">Front page</a>
        <a href="{{ route('teacher.form_137_back', $student->id) }}?id={{request()->query('id')}}" class="px-5 py-1 bg-purple-800 text-white rounded">Back page</a>
    </div>

    <div id="form_137" class="border p-8">
        <div class=" pt-4 mt-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">School:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="Philippine Technological Institute of Science Arts and Trade Inc" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">School ID:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="405210" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Track/Strand:</label>
                    @php
                    $strands = [
                    'ICT' => 'Information and Communication Technology'
                    ]
                    @endphp
                    <input style="font-size: 14px; display: inline-block !important;" value="{{ $strands[$student->strand] }}" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Grade and Section:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="Grade {{ $student->grade }} / Section {{ $student->section }}" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">SY:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="2024 - 2025" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Sem:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="First Semester" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
            </div>
        </div>

        <div class="my-8">
            <table class="w-full border-collapse border border-gray-400 mb-8">
                <thead>
                    <tr>
                        <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Indicate if Subject is CORE, APPLIED
                            or SPECIALIZED</th>
                        <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                        <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                        <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                        <th rowspan="2" class="border border-gray-400 p-2">Action Taken</th>
                    </tr>
                    <tr>

                        <th class="border border-gray-400 p-2 w-16 text-center">1</th>
                        <th class="border border-gray-400 p-2 w-16 text-center">2</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades['First Semester_First Quarter'] as $firstQuarter)
                    <tr>
                        <td class="border border-gray-400 p-2 text-center" contenteditable="">Core</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->subject }}</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->quarterly_grade }}</td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ optional($grades['First Semester_Second Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade ?? 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{
                        ($firstQuarter->quarterly_grade +
                        optional($grades['First Semester_Second Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade) / 2
                    }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable="true"></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="bg-gray-200 p-2 text-right">General Average for the semester: </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ $grades['First Semester_First Quarter']->average('quarterly_grade')?? 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Remarks:</label>
                <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Prepared By:</label>
                    <div>
                        <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                        <small class="block text-center">Signature of Adviser over Printed Name</small>
                    </div>
                </div>
                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Certified True and Correct:</label>
                    <div>
                        <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                        <small class="block text-center">Signature of Authorized Person over Printed Name, Designation</small>
                    </div>
                </div>

                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Date Checked (MMM/DD/YYYYY):</label>
                    <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                    <small class="block text-center">
                </div>

            </div>
        </div>

        <div class="mt-4">
            <span class="font-semibold" style="font-size: 14px;">Remedial Classes: Conducted From (MM/DD/YYYY): <input style="font-size: 14px; display: inline !important; width: 200px;" type="date" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                to (MM/DD/YYYY): <input style="font-size: 14px; display: inline !important; width: 200px;" type="date" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </span>
        </div>


        <div class="mt-4">
            <table class="w-full border-collapse border border-gray-400 mb-8">
                <thead>
                    <tr>
                        <th class="border border-gray-400 p-2">Indicate if Subject is CORE, APPLIED or SPECIALIZED</th>
                        <th class="border border-gray-400 p-2">Subjects</th>
                        <th class="border border-gray-400 p-2">Semister Final Grade</th>
                        <th class="border border-gray-400 p-2">Remedial Class Mark</th>
                        <th class="border border-gray-400 p-2">Recomputed Final Grade</th>
                        <th class="border border-gray-400 p-2">Action Taken</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    for($i = 0; $i < 6; $i++) {
                        @endphp
                        <tr>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        </tr>
                        @php
                        }
                        @endphp

                </tbody>
            </table>
        </div>


        <div class="border-t pt-4 mt-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">School:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="Philippine Technological Institute of Science Arts and Trade Inc" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">School ID:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="405210" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Track/Strand:</label>
                    @php
                    $strands = [
                    'ICT' => 'Information and Communication Technology'
                    ]
                    @endphp
                    <input style="font-size: 14px; display: inline-block !important;" value="{{ $strands[$student->strand] }}" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Grade and Section:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="Grade {{ $student->grade }} / Section {{ $student->section }}" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">SY:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="2024 - 2025" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
                <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold" style="font-size: 11px;">Sem:</label>
                    <input style="font-size: 14px; display: inline-block !important;" value="Second Semester" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                </div>
            </div>
        </div>




        <div class="my-8">
            <table class="w-full border-collapse border border-gray-400 mb-8">
                <thead>
                    <tr>
                        <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Indicate if Subject is CORE, APPLIED
                            or SPECIALIZED</th>
                        <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                        <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                        <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                        <th rowspan="2" class="border border-gray-400 p-2">Action Taken</th>
                    </tr>
                    <tr>

                        <th class="border border-gray-400 p-2 w-16 text-center">1</th>
                        <th class="border border-gray-400 p-2 w-16 text-center">2</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades['Second Semester_Third Quarter'] as $firstQuarter)
                    <tr>
                        <td class="border border-gray-400 p-2 text-center" contenteditable="">Core</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->subject }}</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->quarterly_grade }}</td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ optional($grades['Second Semester_Third Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade ?? 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{
                        ($firstQuarter->quarterly_grade +
                        optional($grades['Second Semester_Fourth Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade) / 2
                    }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable="true"></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="bg-gray-200 p-2 text-right">General Average for the semester: </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ $grades['Second Semester_Third Quarter']->average('quarterly_grade')?? 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Remarks:</label>
                <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Prepared By:</label>
                    <div>
                        <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                        <small class="block text-center">Signature of Adviser over Printed Name</small>
                    </div>
                </div>
                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Certified True and Correct:</label>
                    <div>
                        <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                        <small class="block text-center">Signature of Authorized Person over Printed Name, Designation</small>
                    </div>
                </div>

                <div>
                    <label class="font-semibold block" style="font-size: 11px;">Date Checked (MMM/DD/YYYYY):</label>
                    <input style="font-size: 14px; display: inline-block !important;" type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                    <small class="block text-center">
                </div>

            </div>
        </div>

        <div class="mt-4">
            <span class="font-semibold" style="font-size: 14px;">Remedial Classes: Conducted From (MM/DD/YYYY): <input style="font-size: 14px; display: inline !important; width: 200px;" type="date" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                to (MM/DD/YYYY): <input style="font-size: 14px; display: inline !important; width: 200px;" type="date" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </span>
        </div>


        <div class="mt-4">
            <table class="w-full border-collapse border border-gray-400 mb-8">
                <thead>
                    <tr>
                        <th class="border border-gray-400 p-2">Indicate if Subject is CORE, APPLIED or SPECIALIZED</th>
                        <th class="border border-gray-400 p-2">Subjects</th>
                        <th class="border border-gray-400 p-2">Semister Final Grade</th>
                        <th class="border border-gray-400 p-2">Remedial Class Mark</th>
                        <th class="border border-gray-400 p-2">Recomputed Final Grade</th>
                        <th class="border border-gray-400 p-2">Action Taken</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    for($i = 0; $i < 6; $i++) {
                        @endphp
                        <tr>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        <td class="border border-gray-400 p-2 text-center" contenteditable=""></td>
                        </tr>
                        @php
                        }
                        @endphp

                </tbody>
            </table>
        </div>




        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Name of Teacher/Adviser: </label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" value="{{ $user->name }}" type="text" class="w-full border-0 border-b border-gray-300 uppercase focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Signature:</label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" readonly type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Track/Strand Accomplished: </label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" type="text" class="w-full border-0 border-b border-gray-300 uppercase focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">SHS General Average:</label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" readonly type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Awards/Honors Received: </label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" type="text" class="w-full border-0 border-b border-gray-300 uppercase focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
            <div class="flex items-center justify-start gap-2">
                <label class="font-semibold" style="font-size: 11px;">Date of SHS Graduation (MM/DD/YYYY):</label>
                <input style="font-size: 14px; display: inline-block !important; width: 300px" readonly type="text" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
            </div>
        </div>


        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <label class="font-semibold block" style="font-size: 11px;">Certified By:</label>
                <div>
                    <input style="font-size: 14px; display: inline-block !important;" type="text" value="{{ $user->name }}" class="w-full uppercase border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                    <p class="block text-center">Signature of Adviser over Printed Name</p>
                </div>
            </div>
            <div class="mt-4">
                <input style="font-size: 14px; display: inline-block !important;" type="date" class="w-full text-center border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                <p class="block text-center">Date</p>
            </div>
        </div>

        <div class="mt-4 text-left">
            <h3 class="text-lg font-semibold">Note:</h3>
            <p class="text-sm">
                This permanent record or a photocopy of this permanent record that bears the seal of the school and the original signature in ink of the School Head shall be considered valid for all legal purposes. Any erasure or alteration made on this copy should be validated by the School Head.
                If the student transfers to another school, the originating school should produce one (1) certified true copy of this permanent record for safekeeping. The receiving school shall continue filling up the original form.
                Upon graduation, the school from which the student graduated should keep the original form and produce one (1) certified true copy for the Division Office.
            </p>



            <p class="text-sm my-2">
                <strong class="text-lg font-semibold">Remark:</strong>
                (Please indicate the purpose for which this permanent record will be used)
            </p>




            <div class="flex items-center justify-start gap-2">
                    <label class="font-semibold block" style="font-size: 11px;">Date Issued (MMM/DD/YYYYY):</label>
                    <input style="font-size: 14px; display: inline-block !important; width: 200px" type="date" class="w-full border-0 border-b border-gray-300 focus:outline-none focus:ring-0 focus:border-blue-600 p-1">
                    <small class="block text-center">
                </div>
        </div>





    </div>
</div>
@endsection