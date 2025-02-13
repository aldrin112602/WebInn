@extends('teacher.layouts.app')
@section('title', 'Report Card Back')
@section('content')
    <style>
        body {
            font-size: 0.85rem;
            background-color: white;
        }

        h1,
        h2,
        h3 {
            font-size: 1rem;
        }

        .p-8 {
            padding: 1rem;
        }

        table {
            font-size: 0.75rem;
        }

        th,
        td {
            padding: 0.5rem;
        }

        .space-y-4>* {
            margin-bottom: 0.5rem;
        }

        @media print {
            #report_card {
                width: 100%;
                height: auto;
                position: absolute;
                background-color: white;
                font-size: 0.75rem;
                top: 0;
                left: 0;
                z-index: 200;
            }

            .border {
                border-color: black !important;
            }
        }
    </style>

    <div class=" mx-auto p-8 bg-white overflow-auto">
        <div class="flex my-3 gap-3">
            <button onclick="window.print()" class="px-5 py-1 bg-blue-800 text-white rounded">Print Report Card</button>
            |
            <a href="{{ route('teacher.report_card_front', $student->id) }}?id={{ request()->query('id') }}"
                class="px-5 py-1 bg-green-800 text-white rounded">Front page</a>
            <a href="{{ route('teacher.report_card_back', $student->id) }}?id={{ request()->query('id') }}"
                class="px-5 py-1 bg-purple-800 text-white rounded">Back page</a>
        </div>
        <div class="mx-auto p-8 bg-white border flex items-start justify-start gap-2" id="report_card">
            <!-- <div class="w-1/2">
                <div class="mb-8">
                    <h3 class="font-bold mb-4">1ST SEMESTER</h3>
                    <table class="w-full border-collapse border border-gray-400 mb-8">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                                <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                            </tr>
                            <tr>

                                <th class="border border-gray-400 p-2 w-16 text-center">1</th>
                                <th class="border border-gray-400 p-2 w-16 text-center">2</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades['First Semester_First Quarter'] as $firstQuarter)
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->subject }}</td>
                                    <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->quarterly_grade }}
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center">
                                        {{ optional($grades['First Semester_Second Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center">
                                        {{ ($firstQuarter->quarterly_grade +
                                            optional($grades['First Semester_Second Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade) /
                                            2 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-8">
                    <h3 class="font-bold mb-4">2ND SEMESTER</h3>
                    <table class="w-full border-collapse border border-gray-400 mb-8">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                                <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                            </tr>
                            <tr>

                                <th class="border border-gray-400 p-2 w-16 text-center">3</th>
                                <th class="border border-gray-400 p-2 w-16 text-center">4</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grades['Second Semester_Third Quarter'] as $thirdQuarter)
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">{{ $thirdQuarter->subject }}</td>
                                    <td class="border border-gray-400 p-2 text-center">{{ $thirdQuarter->quarterly_grade }}
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center">
                                        {{ optional($grades['Second Semester_Fourth Quarter']->firstWhere('subject', $thirdQuarter->subject))->quarterly_grade ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center">
                                        {{ ($thirdQuarter->quarterly_grade +
                                            optional($grades['Second Semester_Fourth Quarter']->firstWhere('subject', $thirdQuarter->subject))->quarterly_grade) /
                                            2 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> -->
            
            <div class="w-1/2">
    <!-- 1ST SEMESTER -->
    <div class="mb-8">
        <h3 class="font-bold mb-4">1ST SEMESTER</h3>
        <table class="w-full border-collapse border border-gray-400 mb-8">
            <thead>
                <tr>
                    <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                    <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                    <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                </tr>
                <tr>
                    <th class="border border-gray-400 p-2 w-16 text-center">1</th>
                    <th class="border border-gray-400 p-2 w-16 text-center">2</th>
                </tr>
            </thead>
            <tbody>
                @php $totalFirstSemesterGrades = 0; $firstSemesterCount = 0; @endphp
                @foreach ($grades['First Semester_First Quarter'] as $firstQuarter)
                    @php
                        $secondQuarterGrade = optional($grades['First Semester_Second Quarter']->firstWhere('subject', $firstQuarter->subject))->quarterly_grade ?? 0;
                        $semesterFinalGrade = ($firstQuarter->quarterly_grade + $secondQuarterGrade) / 2;
                        $totalFirstSemesterGrades += $semesterFinalGrade;
                        $firstSemesterCount++;
                    @endphp
                    <tr>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->subject }}</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $firstQuarter->quarterly_grade }}</td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ $secondQuarterGrade ?: 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ number_format($semesterFinalGrade, 2) }}
                        </td>
                    </tr>
                @endforeach
                <!-- General Average Row -->
                <tr>
                    <td colspan="3" class="border border-gray-400 p-2 font-bold text-right">General Average for 1ST Semester</td>
                    <td class="border border-gray-400 p-2 font-bold text-center">
                        {{ $firstSemesterCount > 0 ? number_format($totalFirstSemesterGrades / $firstSemesterCount, 2) : 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 2ND SEMESTER -->
    <div class="mb-8">
        <h3 class="font-bold mb-4">2ND SEMESTER</h3>
        <table class="w-full border-collapse border border-gray-400 mb-8">
            <thead>
                <tr>
                    <th rowspan="2" class="border border-gray-400 p-2 w-1/2">Subjects</th>
                    <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                    <th rowspan="2" class="border border-gray-400 p-2">Semester Final Grade</th>
                </tr>
                <tr>
                    <th class="border border-gray-400 p-2 w-16 text-center">3</th>
                    <th class="border border-gray-400 p-2 w-16 text-center">4</th>
                </tr>
            </thead>
            <tbody>
                @php $totalSecondSemesterGrades = 0; $secondSemesterCount = 0; @endphp
                @foreach ($grades['Second Semester_Third Quarter'] as $thirdQuarter)
                    @php
                        $fourthQuarterGrade = optional($grades['Second Semester_Fourth Quarter']->firstWhere('subject', $thirdQuarter->subject))->quarterly_grade ?? 0;
                        $semesterFinalGrade = ($thirdQuarter->quarterly_grade + $fourthQuarterGrade) / 2;
                        $totalSecondSemesterGrades += $semesterFinalGrade;
                        $secondSemesterCount++;
                    @endphp
                    <tr>
                        <td class="border border-gray-400 p-2 text-center">{{ $thirdQuarter->subject }}</td>
                        <td class="border border-gray-400 p-2 text-center">{{ $thirdQuarter->quarterly_grade }}</td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ $fourthQuarterGrade ?: 'N/A' }}
                        </td>
                        <td class="border border-gray-400 p-2 text-center">
                            {{ number_format($semesterFinalGrade, 2) }}
                        </td>
                    </tr>
                @endforeach
                <!-- General Average Row -->
                <tr>
                    <td colspan="3" class="border border-gray-400 p-2 font-bold text-right">General Average for 2ND Semester</td>
                    <td class="border border-gray-400 p-2 font-bold text-center">
                        {{ $secondSemesterCount > 0 ? number_format($totalSecondSemesterGrades / $secondSemesterCount, 2) : 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
            
            


            <div class="w-1/2">
                <!-- Core Values Section -->
                <div class="mb-8">
                    <div class="mt-10">
                        <!-- Left side: Core Values -->
                        <table class="w-full border-collapse border border-gray-400">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="border border-gray-400 p-2">CORE VALUES</th>
                                    <th rowspan="2" class="border border-gray-400 p-2">BEHAVIORAL STATEMENT</th>
                                    <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                                    <th colspan="2" class="border border-gray-400 p-2 text-center">Quarter</th>
                                </tr>
                                <tr>
                                    <td class="border text-center border-gray-400 p-2">1</td>
                                    <td class="border text-center border-gray-400 p-2">2</td>
                                    <td class="border text-center border-gray-400 p-2">3</td>
                                    <td class="border text-center border-gray-400 p-2">4</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">1. MAKADIYOS</td>
                                    <td class="border border-gray-400 p-2" style="font-size: smaller;"
                                        contenteditable="true">
                                        Expresses one's spiritual beliefs while respecting spiritual beliefs of others<br>
                                        Shows adherence to ethical principles by upholding truth
                                    </td>
                                    <td class="border border-gray-400 p-2 w-12"></td>
                                    <td class="border border-gray-400 p-2 w-12"></td>
                                    <td class="border border-gray-400 p-2 w-12"></td>
                                    <td class="border border-gray-400 p-2 w-12"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">2. MAKATAO</td>
                                    <td class="border border-gray-400 p-2" style="font-size: smaller;"
                                        contenteditable="true">
                                        Is sensitive to individual, social and cultural differences<br>
                                        Demonstrates contributions towards solidarity
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">3. MAKAKALIKASAN</td>
                                    <td class="border border-gray-400 p-2" style="font-size: smaller;"
                                        contenteditable="true">
                                        Cares for the environment and utilizes resources wisely, judiciously, and
                                        economically
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center">4. MAKABANSA</td>
                                    <td class="border border-gray-400 p-2" style="font-size: smaller;"
                                        contenteditable="true">
                                        Demonstrates pride in being a Filipino; exercises the rights and responsibilities of
                                        a Filipino citizen
                                    </td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                    <td class="border border-gray-400 p-2 text-center"></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- Footer Legends -->
                <div class="grid grid-cols-2 gap-8">
                    <!-- Markings -->
                    <div>
                        <h4 class="font-bold mb-2" style="font-size: smaller;">Markings</h4>
                        <div class="space-y-1 text-sm">
                            <div style="font-size: smaller;">AO</div>
                            <div style="font-size: smaller;">SO</div>
                            <div style="font-size: smaller;">RO</div>
                            <div style="font-size: smaller;">NO</div>
                        </div>
                    </div>

                    <!-- Observed Values -->
                    <div style="font-size: smaller;">
                        <h4 class="font-bold mb-2" style="font-size: smaller;">Observed Values</h4>
                        <div class="space-y-1 text-sm">
                            <div style="font-size: smaller;">Non-Numerical</div>
                            <div style="font-size: smaller;">Always Observed</div>
                            <div style="font-size: smaller;">Sometimes Observed</div>
                            <div style="font-size: smaller;">Rarely Observed</div>
                            <div style="font-size: smaller;">Not Observed</div>
                        </div>
                    </div>

                    <!-- Grading Scale -->
                    <div class="w-full">
                        <h4 class="font-bold mb-2" style="font-size: smaller;">Learner Progress and Achievement</h4>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div style="font-size: smaller;">Descriptors</div>
                            <div style="font-size: smaller;">Grading Scale</div>
                            <div style="font-size: smaller;">Remarks</div>
                        </div>
                        <div class="space-y-1 text-sm">
                            <div class="grid grid-cols-3 gap-4">
                                <div style="font-size: smaller;">Outstanding</div>
                                <div style="font-size: smaller;">90 - 100</div>
                                <div style="font-size: smaller;">Passed</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div style="font-size: smaller;">Very Satisfactory</div>
                                <div style="font-size: smaller;">85 - 89</div>
                                <div style="font-size: smaller;">Passed</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div style="font-size: smaller;">Satisfactory</div>
                                <div style="font-size: smaller;">80 - 84</div>
                                <div style="font-size: smaller;">Passed</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div style="font-size: smaller;">Fairly Satisfactory</div>
                                <div style="font-size: smaller;">75 - 79</div>
                                <div style="font-size: smaller;">Passed</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div style="font-size: smaller;">Did Not Meet Expectations</div>
                                <div style="font-size: smaller;">Below 75</div>
                                <div style="font-size: smaller;">Failed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
