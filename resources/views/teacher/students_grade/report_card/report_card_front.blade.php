@extends('teacher.layouts.app')
@section('title', 'Report Card')
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
        font-size: 0.5rem;
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
        <a href="{{ route('teacher.report_card_front', $student->id) }}?id={{request()->query('id')}}" class="px-5 py-1 bg-green-800 text-white rounded">Front page</a>
        <a href="{{ route('teacher.report_card_back', $student->id) }}?id={{request()->query('id')}}"  class="px-5 py-1 bg-purple-800 text-white rounded">Back page</a>
    </div>
    <div style="min-width: 100vw; min-height: 100vh" class="flex items-start justify-start border p-2" id="report_card">
        <!-- first column -->
        <div class="p-5" style="width: 50%;">
            <!-- Attendance Table -->
            <div class="mb-8">
                <h3 class="font-bold mb-4">REPORT OF ATTENDANCE</h3>
                <table class="w-full border-collapse border border-gray-400">
                    <thead>
                        <tr>
                            <th class="border border-gray-400"></th>
                            <th class="border border-gray-400">Aug</th>
                            <th class="border border-gray-400">Sept</th>
                            <th class="border border-gray-400">Oct</th>
                            <th class="border border-gray-400">Nov</th>
                            <th class="border border-gray-400">Dec</th>
                            <th class="border border-gray-400">Jan</th>
                            <th class="border border-gray-400">Feb</th>
                            <th class="border border-gray-400">Mar</th>
                            <th class="border border-gray-400">Apr</th>
                            <th class="border border-gray-400">Jun</th>
                            <th class="border border-gray-400">July</th>
                            <th class="border border-gray-400">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-400 text-center">No. of school days</td>
                            @for ($i = 0; $i < 12; $i++)
                                <td class="border border-gray-400 text-center">
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="border border-gray-400 text-center">No. of days present</td>
                            @for ($i = 0; $i < 12; $i++)
                                <td class="border border-gray-400 text-center">
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <td class="border border-gray-400 text-center">No. of days absent</td>
                            @for ($i = 0; $i < 12; $i++)
                                <td class="border border-gray-400 p-2">
                                </td>
                                @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Parent's/Guardian's Signature -->
            <div class="mb-8">
                <h3 class="font-bold mb-4">PARENT'S/GUARDIAN'S SIGNATURE</h3>
                <div class="space-y-4">
                    <div>
                        1ST QUARTER: <span class="ml-2  font-semibold">________________________________</span>
                    </div>
                    <div>
                        2ND QUARTER: <span class="ml-2  font-semibold">________________________________</span>
                    </div>
                    <div>
                        3RD QUARTER: <span class="ml-2  font-semibold">________________________________</span>
                    </div>
                    <div>
                        4TH QUARTER: <span class="ml-2  font-semibold">________________________________</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- 2nd column -->
        <div class="p-5">
            <!-- Header Section -->
            <div class="flex items-center justify-center gap-6 mb-8">
                <div class="w-20 h-20">
                    <img src="{{ asset('images/philtech-logo-transparent.webp') }}" alt="School Logo" class="w-full h-full object-contain">
                </div>

                <div class="text-center">
                    <h1 class="font-bold">Republic of Philippines</h1>
                    <h2 class="font-bold">DEPARTMENT OF EDUCATION</h2>
                    <p class="text-sm">Region IV-A CALABARZON</p>
                </div>

                <div class="w-20 h-20">
                    <img src="{{ asset('images/deped-logo.webp') }}" alt="DepEd Logo" class="w-full h-full object-contain">
                </div>

            </div>

            <!-- Student Information Form -->
            <div class="mb-8">
                <div class="grid grid-cols-1 gap-4">
                    <div class="border-b border-gray-400">
                        Name: <span class="ml-2  font-semibold">{{ $student->name }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-b border-gray-400">
                            Age: <span class="ml-2  font-semibold">{{ (int)date('Y') - (int)explode('-', $student->birthdate)[0] }}</span>
                        </div>
                        <div class="border-b border-gray-400">
                            Sex: <span class="ml-2  font-semibold">{{ $student->gender }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-b border-gray-400">
                            Grade: <span class="ml-2  font-semibold">{{ $student->grade }}</span>
                        </div>
                        <div class="border-b border-gray-400">
                            Section: <span class="ml-2  font-semibold">{{ $student->section }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-b border-gray-400">
                            School Year: <span class="ml-2  font-semibold">{{ $student->sy ?? '2024 - 2025' }}</span>
                        </div>
                        <div class="border-b border-gray-400">
                            LRN: <span class="ml-2  font-semibold">{{ $student->lrn ?? "N/A" }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Parent Letter -->
            <div class="mb-8">
                <p class="mb-2">Dear Parent,</p>
                <p class="mb-4">This report card shows the ability and progress your child has made in the different learning areas as well as his/her core values.</p>
                <p>The school welcomes you should you desire to know more about your child's progress.</p>
            </div>

            <!-- Signatures -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div class="text-center font-semibold">
                    <div class="border-b border-gray-400 mb-1 font-semibold" contenteditable="true"></div>
                    <div>School Administrator</div>
                </div>
                <div class="text-center font-semibold">
                    <div class="border-b border-gray-400 mb-1 uppercase" contenteditable="true">{{ $user->name }}</div>
                    <div>Teacher</div>
                </div>
            </div>

            <!-- Certificate of Transfer -->
            <div class="mb-8">
                <h3 class="font-bold mb-4 text-center">Certificate of Transfer</h3>
                <div class="grid grid-cols-2 gap-4 mb-4 font-semibold">
                    <div>
                        Admitted to Grade: <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                    <div>
                        Section: <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="mb-4 font-semibold">
                    Eligibility for admission to Grade: <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
                <p class="mb-4 font-semibold">Approved:</p>
                <div class="grid grid-cols-2 gap-8 font-semibold">
                    <div class="text-center">
                        <div class="border-b border-gray-400 mb-1" contenteditable=""></div>
                        <div>School Administrator</div>
                    </div>
                    <div class="text-center">
                        <div class="border-b border-gray-400 mb-1 uppercase" contenteditable="">{{ $user->name }}</div>
                        <div>Teacher</div>
                    </div>
                </div>
            </div>

            <!-- Cancellation Section -->
            <div class="font-semibold">
                <h3 class="font-bold mb-4 text-center">Cancellation of Eligibility to Transfer</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        Admitted in: <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                    <div>
                        Date: <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div class="text-center mt-4">
                <span class="ml-2 border-b border-gray-400" contenteditable="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <div>School Administrator</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection