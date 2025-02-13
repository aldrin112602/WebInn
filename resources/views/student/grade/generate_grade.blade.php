@extends('student.layouts.app')

@section('title', 'Generated Grade')

@section('content')
<br><br><br>
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <img src="{{ asset('WebInn img/WebInn img/admin ark logo.jpg') }}" alt="Logo" class="mx-auto h-16 mb-4">
        <h1 class="text-lg font-bold">Philippine Technological Institute of Science Arts and Trade Inc.</h1>
        <p class="text-sm">SUMMARY OF GRADES</p>
        <p class="text-sm">1st Semester, 2023-2024</p>
    </div>

    <!-- Student Info -->
    <div class="mb-8">
        <p><span class="font-semibold">Student ID:</span> {{ $user->id_number }}</p>
        <p><span class="font-semibold">Student Name:</span> {{ $user->name }}</p>
        <p><span class="font-semibold">Grade:</span> {{ $user->grade }} - {{ $user->section }}</p>
        <p><span class="font-semibold">Strand:</span> {{ $user->strand }}</p>
    </div>

    <!-- Grades Table -->
    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2 text-left">Subject</th>
                <th class="border border-gray-300 px-4 py-2">Unit</th>
                <th class="border border-gray-300 px-4 py-2">Grade</th>
                <th class="border border-gray-300 px-4 py-2">Remark</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Reading and Writing</td>
                <td class="border border-gray-300 px-4 py-2 text-center">5.00</td>
                <td class="border border-gray-300 px-4 py-2 text-center">94</td>
                <td class="border border-gray-300 px-4 py-2 text-center">Passed</td>
            </tr>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Statistic and Probability</td>
                <td class="border border-gray-300 px-4 py-2 text-center">2.00</td>
                <td class="border border-gray-300 px-4 py-2 text-center">90</td>
                <td class="border border-gray-300 px-4 py-2 text-center">Passed</td>
            </tr>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Java</td>
                <td class="border border-gray-300 px-4 py-2 text-center">5.00</td>
                <td class="border border-gray-300 px-4 py-2 text-center">88</td>
                <td class="border border-gray-300 px-4 py-2 text-center">Passed</td>
            </tr>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Practical Research 1</td>
                <td class="border border-gray-300 px-4 py-2 text-center">5.00</td>
                <td class="border border-gray-300 px-4 py-2 text-center">88</td>
                <td class="border border-gray-300 px-4 py-2 text-center">Passed</td>
            </tr>
            <tr>
                <td class="border border-gray-300 px-4 py-2">Gen Math</td>
                <td class="border border-gray-300 px-4 py-2 text-center">3.00</td>
                <td class="border border-gray-300 px-4 py-2 text-center">99</td>
                <td class="border border-gray-300 px-4 py-2 text-center">Passed</td>
            </tr>
        </tbody>
    </table>
    
</div>
<br><br><br>
@endsection
