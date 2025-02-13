@extends('teacher.layouts.app')

@section('title', 'Grading')

@section('content')


@php
 $subj = $SubjectModel::where('subject', request()->query('subject'))->first();
 
 
 $percentage_filters = [
    'Core Subject' => [
        'written_work' => '25%',
        'performance_task' => '50%',
        'quarterly_assessment' => '25%',
    ],
    
    'Applied Subject' => [
        'written_work' => '35%',
        'performance_task' => '45%',
        'quarterly_assessment' => '20%',
    ],
    
    'Specialized Subject' => [
        'written_work' => '20%',
        'performance_task' => '60%',
        'quarterly_assessment' => '20%',
    ],
 ];
@endphp

<div class="p-4 overflow-x-auto">
    <div class="flex gap-3 items-center justify-start">
        <div class="flex items-center justify-start gap-2">
            <span>Region: </span>
            <p class="border p-1 bg-white border-slate-500">
                {{ $gradingHeaders->region ?? 'IV - A' }}
            </p>
        </div>
        <div>
            <div class="flex items-center justify-start gap-2">
                <span>Division: </span>
                <p class="border p-1 bg-white border-slate-500">
                    {{ $gradingHeaders->division ?? '2nd' }}
                </p>
            </div>
        </div>
    </div>

    <div class="flex gap-3 items-center justify-between mt-2">
        <div class="flex items-center justify-start gap-2">
            <span>School name: </span>
            <p class="border p-1 bg-white border-slate-500">
                {{ $gradingHeaders->school_name ?? 'Philippine Technological Institute of Science Arts and Trade Inc' }}
            </p>
        </div>
        <div class="flex items-center justify-start gap-2">
            <span>School ID: </span>
            <p class="border p-1 bg-white border-slate-500">
                {{ $gradingHeaders->school_id ?? '405210' }}
            </p>
        </div>

        <div class="flex items-center justify-start gap-2">
            <span>School Year: </span>
            <select name="school_year p-1" id="school_year">
                <option value="{{ $gradingHeaders->year ?? '2023-2024' }}">{{ $gradingHeaders->year ?? '2023-2024' }}</option>
            </select>
        </div>
    </div>

    <!-- table -->
    <table class="w-full bg-white mt-4">
        <tr class="border">
            <td class="border p-2" rowspan="3">
                <select name="semester" id="semester" class="border mb-2 w-52 p-0 px-10">
                    <option value="" selected disabled class="hidden">-- Semester --</option>
                    <option {{ request('semester') == 'First Semester' ? 'selected' : '' }} value="First Semester">First Semester</option>
                    <option {{ request('semester') == 'Second Semester' ? 'selected' : '' }} value="Second Semester">Second Semester</option>
                </select>
                <select name="quarter" id="quarter" class="border w-52 p-0 px-10">
                    <option value="" selected disabled class="hidden">-- Quarter --</option>
                    <option {{ request('quarter') == 'First Quarter' ? 'selected' : '' }} value="First Quarter">First Quarter</option>
                    <option {{ request('quarter') == 'Second Quarter' ? 'selected' : '' }} value="Second Quarter">Second Quarter</option>
                    <option {{ request('quarter') == 'Third Quarter' ? 'selected' : '' }} value="Third Quarter">Third Quarter</option>
                    <option {{ request('quarter') == 'Fourth Quarter' ? 'selected' : '' }} value="Fourth Quarter">Fourth Quarter</option>
                </select>
            </td>
            <td class="border p-2" colspan="13">
                Grade, Strand & Section:
                <div class="inline">
                    <div class="flex items-center justify-start">
                        <select class="py-1 text-sm" name="grade" id="grade">
                            <option value="" disabled class="hidden" selected>-- Grade --</option>
                            @foreach($grades as $grade)
                            <option value="{{ $grade }}" {{ request('grade') == $grade ? 'selected' : '' }}>
                                Grade {{ $grade }}
                            </option>
                            @endforeach
                        </select>


                        <select class="py-1 text-sm" name="strand" id="strand">
                            <option value="" disabled class="hidden" selected>-- Strand --</option>
                            @foreach($strands as $strand)
                            <option value="{{ $strand }}" {{ request('strand') == $strand ? 'selected' : '' }}>
                                {{ $strand }}
                            </option>
                            @endforeach
                        </select>

                        <select class="py-1 text-sm" name="section" id="section">
                            <option value="" disabled class="hidden" selected>-- Section --</option>
                            @foreach($sections as $section)
                            <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>
                                {{ $section }}
                            </option>
                            @endforeach
                        </select>

                    </div>

                </div>

                <script>
                    $(document).ready(function() {
                        function updateQueryString(param, value, resetSection = false) {
                            var currentUrl = new URL(window.location.href);
                            if (resetSection) {
                                currentUrl.searchParams.delete('section');
                            }
                            if (value) {
                                currentUrl.searchParams.set(param, value);
                            } else {
                                currentUrl.searchParams.delete(param);
                            }
                            window.location.href = currentUrl.href;
                        }

                        $('#grade').on('change', function() {
                            var gradeValue = $(this).val();
                            updateQueryString('grade', gradeValue);
                        });

                        $('#strand').on('change', function() {
                            var strandValue = $(this).val();
                            updateQueryString('strand', strandValue, true);
                        });

                        $('#section').on('change', function() {
                            var sectionValue = $(this).val();
                            updateQueryString('section', sectionValue);
                        });

                        $('#semester').on('change', function() {
                            var semesterValue = $(this).val();
                            updateQueryString('semester', semesterValue);
                        });
                        $('#quarter').on('change', function() {
                            var quarterValue = $(this).val();
                            updateQueryString('quarter', quarterValue);
                        });
                        $('#subject').on('change', function() {
                            var subjectValue = $(this).val();
                            updateQueryString('subject', subjectValue);
                        });
                        $('#track').on('change', function() {
                            var trackValue = $(this).val();
                            updateQueryString('track', trackValue);
                        });
                    });
                </script>

            </td>
            <td class="border p-2" colspan="13">
                <div class="flex items-center justify-between">
                    <span>Teacher:</span>
                    <span class="font-bold">{{ $user->name }}</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span>Subject:</span>
                    <select name="subject" id="subject" class="border mb-2 w-52 p-0 px-10">
                    <option value="" selected disabled class="hidden">-- Subject --</option>
                    @foreach ($subjects as $subject)
                        <option {{ request('subject') == $subject->subject ? 'selected' : '' }} value="{{ $subject->subject }}">{{ $subject->subject }}</option>
                    @endforeach
                </select>
                </div>
                <div class="flex items-center justify-between">
                    <span>Track:</span>
                    <select name="track" id="track" class="border mb-2 w-52 p-0 px-10">
                        <option value="" selected disabled class="hidden">-- Track --</option>
                        


                    @if ($subj)
                     <option selected value="{{ $subj->subject_track }}">{{ $subj->subject_track }}</option>
                    @endif
                        
                        <!--- <option {{ request('track') == 'Core Subject' ? 'selected' : '' }} value="Core Subject">Core Subject</option>
                        <option {{ request('track') == 'Applied Subject' ? 'selected' : '' }} value="Applied Subject">Applied Subject</option>
                       
                        <option {{ request('track') == 'Specialized Subject' ? 'selected' : '' }} value="Specialized Subject">Specialized Subject</option> --->
                    </select>
                </div>
            </td>
            
            <td class="border p-2 text-center" colspan="3" rowspan="3">
                Quarterly Assessment <br> (<span   id="custom_quarterly_assessment_percentage"> {{ $percentage_filters[$subj->subject_track ?? '']['quarterly_assessment'] ?? '25%' }} </span> )
            </td>
            <td class="border p-2 text-center" rowspan="4">
                Initial Grade
            </td>
            <td class="border p-2 text-center" rowspan="4">
                Quarterly Grade
            </td>
        </tr>

        <tr class="border">
            <td class="border p-2" colspan="13">WRITTEN WORK (<span   id="custom_written_percentage"> {{ $percentage_filters[$subj->subject_track ?? '']['written_work'] ?? '25%' }} </span>)  </td>
            <td class="border p-2" colspan="13">PERFORMANCE TASK (<span  id="custom_performance_task_percentage"> {{ $percentage_filters[$subj->subject_track ?? '']['performance_task'] ?? '50%' }} </span> )</td>
        </tr>

        <tr class="border">
            <td class="border p-2" colspan="26"></td>
        </tr>

        <tr class="border">
            <td class="border p-2">Learner's Name</td>
            @for ($i = 1; $i <= 10; $i++)
                <td class="border p-2">{{ $i }}</td>
                
                @endfor
                <td class="border p-2">Total</td>
                <td class="border p-2">PS</td>
                <td class="border p-2">WS</td>

                @for ($i = 1; $i <= 10; $i++)
                    <td class="border p-2">{{ $i }}</td>
                    @endfor
                    <td class="border p-2">Total</td>
                    <td class="border p-2">PS</td>
                    <td class="border p-2">WS</td>
                    <td class="border p-2">1</td>
                    <td class="border p-2">PS</td>
                    <td class="border p-2">WS</td>
        </tr>



        <tr class="border">
            <td class="border p-2 bg-slate-50 text-sm">Highest Possible Score</td>
            @for ($i = 1; $i <= 10; $i++)
                <!-- Min: 5, highest: 10 -->
                <td data-id_written="{{ $i }}" id="highest_possible_score" data-cell-number="{{ $i }}" class="border p-1 cursor-pointer" contenteditable="true">
                    {{ $highestPossibleScores['highest_possible_written_' . $i] ?? '' }}
                </td>
                @endfor
                <td class="border p-2" id="highest_possible_written_total"></td>
                <td class="border p-1 cursor-pointer" contenteditable="true">100.00</td>
                <td class="border p-1 cursor-pointer" id="highest_possible_ws">
                    {{ $percentage_filters[$subj->subject_track ?? '']['written_work'] ?? '25%' }}
                </td>

                @for ($i = 1; $i <= 10; $i++)
                    <!-- Min: 5, highest: 10 -->
                    <td data-id_task="{{ $i }}" id="performance_task_highest_possible_score" data-cell-number="{{ $i }}" class="border p-1 cursor-pointer">
                        {{ $highestPossibleScores['highest_possible_task_' . $i] ?? '' }}
                    </td>
                    @endfor


                    <td class="border p-2" id="highest_possible_task_total"></td>
                    <td class="border p-2" contenteditable="true">100.00</td>
                    <td class="border p-2" id="highest_possible_task">{{ $percentage_filters[$subj->subject_track ?? '']['performance_task'] ?? '25%' }}</td>
                    <td class="border p-1 cursor-pointer" data-id_quarterly="1" id="quarterly_assessment_total" data-cell-number="1" contenteditable="true">
                        {{ $quarterlyAssessmentScore['quarterly_assessment_total'] ?? '100' }}
                    </td>
                    <td class="border p-2" contenteditable="true">100.00</td>
                    <td class="border p-2 id="highest_possible_quart">{{ $percentage_filters[$subj->subject_track ?? '']['quarterly_assessment'] ?? '25%' }}</td>
                    <td class="border p-2"></td>
                    <td class="border p-2"></td>
        </tr>


        <tr class="border">
            <td class="border p-2 bg-slate-100">Male</td>
            @for ($j=0; $j < 31; $j++)
                <td class="border p-2 py-4">
                </td>
                @endfor
        </tr>
        <!-- ======================================== -->
        <!-- =========== for male students ========== -->
        <!-- ======================================== -->
        @foreach ($allMaleStudents as $student)
        <tr>
            <td class="border p-2">
                {{ $student->account->name }}
            </td>

            {{-- Display written work grades --}}
            @php
            $totalWrittenGrade = 0; // Initialize the total written work grade
            $studentGrade = $studentGrades->where('student_id', $student->account->id)->first();
            @endphp

            @for ($i = 1; $i <= 10; $i++)
                @php
                $writtenGrade=$studentGrade ? $studentGrade['written_' . $i] : 0;
                $totalWrittenGrade +=$writtenGrade; // Accumulate total
                @endphp
                <td data-for="written_work" data-cell="{{ $i }}" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                {{ $writtenGrade }}
                </td>
                @endfor

                {{-- Display total written work grade --}}
                <td class="border p-2" data-for="written_work_total">
                    {{ $totalWrittenGrade }}
                </td>

                {{-- Display placeholders for PS and WS columns --}}
                <td class="border p-2" data-for="written_work_ps">{{ $studentGrade['written_ps'] ?? '0.00' }}</td>
                <td class="border p-2" data-for="written_work_ws">{{ $studentGrade['written_ws'] ?? '0.00' }}</td>

                {{-- Display performance task grades --}}
                @php
                $totalTaskGrade = 0; // Initialize the total task grade
                @endphp

                @for ($i = 1; $i <= 10; $i++)
                    @php
                    $taskGrade=$studentGrade ? $studentGrade['task_' . $i] : 0;
                    $totalTaskGrade +=$taskGrade; // Accumulate total
                    @endphp
                    <td data-for="performance_task" data-cell="{{ $i }}" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                    {{ $taskGrade }}
                    </td>
                    @endfor

                    <td class="border p-2" data-for="performance_task_total">{{ $totalTaskGrade }}</td>
                    <td class="border p-2" data-for="performance_task_ps">{{ $studentGrade['task_ps'] ?? '0.00' }}</td>
                    <td class="border p-2" data-for="performance_task_ws">{{ $studentGrade['task_ws'] ?? '0.00' }}</td>

                    @php
                    $quarterAssessmentScore=$studentGrade ? $studentGrade['quart_1'] : 0;
                    @endphp

                    {{-- <td class="border p-1 cursor-pointer" contenteditable="true"></td> --}}
                    <td data-for="quarterly_assessment" data-cell="11" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                        {{ $quarterAssessmentScore }}
                    <td class="border p-2" data-for="quarterly_assessment_ps">{{ $studentGrade['quart_ps'] ?? '0.00' }}</td>
                    <td class="border p-2" data-for="quarterly_assessment_ws">{{ $studentGrade['quart_ws'] ?? '0.00' }}</td>
                    <td class="border p-2" data-for="initial_grade">{{ $studentGrade['initial_grade'] ?? '0.00' }}</td>
                    <td class="border p-2" data-for="quarterly_grade">{{ $studentGrade['quarterly_grade'] ?? '0.00' }}</td>
        </tr>
        @endforeach

        <!-- per row -->
        @for ($i = 0; $i < 3; $i++)
            <!-- per cell -->
            <tr>
                @for ($j=0; $j < 32; $j++)
                    <td class="border p-2 py-4">
                    </td>
                    @endfor
            </tr>
            @endfor





            <tr class="border">
                <td class="border p-2 bg-slate-100">Female</td>
                @for ($j=0; $j < 31; $j++)
                    <td class="border p-2 py-4">
                    </td>
                    @endfor
            </tr>

            <!-- ========================================== -->
            <!-- =========== for female students ========== -->
            <!-- ========================================== -->
            @foreach ($allFemaleStudents as $student)
            <tr>
                <td class="border p-2">
                    {{ $student->account->name }}
                </td>

                {{-- Display written work grades --}}
                @php
                $totalWrittenGrade = 0;
                $studentGrade = $studentGrades->where('student_id', $student->account->id)->first();
                @endphp

                @for ($i = 1; $i <= 10; $i++)
                    @php
                    $writtenGrade=$studentGrade ? $studentGrade['written_' . $i] : 0;
                    $totalWrittenGrade +=$writtenGrade;
                    @endphp
                    <td data-for="written_work" data-cell="{{ $i }}" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                    {{ $writtenGrade }}
                    </td>
                    @endfor

                    {{-- Display total written work grade --}}
                    <td class="border p-2" data-for="written_work_total">
                        {{ $totalWrittenGrade }}
                    </td>

                    {{-- Display placeholders for PS and WS columns --}}
                    <td class="border p-2" data-for="written_work_ps">{{ $studentGrade['written_ps'] ?? '0.00' }}</td>
                    <td class="border p-2" data-for="written_work_ws">{{ $studentGrade['written_ws'] ?? '0.00' }}</td>

                    {{-- Display performance task grades --}}
                    @php
                    $totalTaskGrade = 0;
                    @endphp

                    @for ($i = 1; $i <= 10; $i++)
                        @php
                        $taskGrade=$studentGrade ? $studentGrade['task_' . $i] : 0;
                        $totalTaskGrade +=$taskGrade;
                        @endphp
                        <td data-for="performance_task" data-cell="{{ $i }}" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                        {{ $taskGrade }}
                        </td>
                        @endfor

                        <td class="border p-2" data-for="performance_task_total">{{ $totalTaskGrade }}</td>
                        <td class="border p-2" data-for="performance_task_ps">{{ $studentGrade['task_ps'] ?? '0.00' }}</td>
                        <td class="border p-2" data-for="performance_task_ws">{{ $studentGrade['task_ws'] ?? '0.00' }}</td>

                        @php
                        $quarterAssessmentScore=$studentGrade ? $studentGrade['quart_1'] : 0;
                        @endphp

                        {{-- <td class="border p-1 cursor-pointer" contenteditable="true"></td> --}}
                        <td data-for="quarterly_assessment" data-cell="11" data-user-id="{{ $student->account->id }}" class="border p-1 cursor-pointer" contenteditable="true">
                            {{ $quarterAssessmentScore }}
                        <td class="border p-2" data-for="quarterly_assessment_ps">{{ $studentGrade['quart_ps'] ?? '0.00' }}</td>
                        <td class="border p-2" data-for="quarterly_assessment_ws">{{ $studentGrade['quart_ws'] ?? '0.00' }}</td>
                        <td class="border p-2" data-for="initial_grade">{{ $studentGrade['initial_grade'] ?? '0.00' }}</td>
                        <td class="border p-2" data-for="quarterly_grade">{{ $studentGrade['quarterly_grade'] ?? '0.00' }}</td>
            </tr>
            @endforeach

            <!-- per row -->
            @for ($i = 0; $i < 3; $i++)
                <!-- per cell -->
                <tr>
                    @for ($j=0; $j < 32; $j++)
                        <td class="border p-2 py-4">
                        </td>
                        @endfor
                </tr>
                @endfor

    </table>
    <!-- table -->
</div>

<div class="flex items-center justify-end p-5 gap-3">

    <button id="submitBtn" type="submit" class="px-5 py-3 bg-blue-800 text-white rounded">Save changes</button>
</div>
<script>
    $(document).ready(function() {
        const percentToDecimal = (percentStr) => {
            const dec = parseFloat(percentStr) / 100
            return dec;
        };

        console.log(percentToDecimal('25%'))
        var t = new URLSearchParams(location.search);
        $('[data-for="written_work"], [data-for="performance_task"]').on("input", function() {
            var t = $(this).data("cell"),
                e = parseFloat($('#highest_possible_score[data-cell-number="' + t + '"]').text());
            parseFloat($(this).text()) > e && (alert("Score cannot be higher than the highest possible score (" + e + ")"), $(this).text(""))
        }), $("#submitBtn").click(function() {
            let e = {},
                s = !0,
                r = !0;
            for (let a = 1; a <= 10; a++) {
                let i = $(`td[data-id_written="${a}"]`).text().trim();
                e["highest_possible_written_" + a] = i, ("" === i || isNaN(i)) && (s = !1, r = !1)
            }
            for (let n = 1; n <= 10; n++) {
                let o = $(`td[data-id_task="${n}"]`).text().trim();
                e["highest_possible_task_" + n] = o, ("" === o || isNaN(o)) && (s = !1, r = !1)
            }
            if (!s) {
                alert("All fields in highest possible scores are required.");
                return
            }
            if (!r) {
                alert("Please enter valid numbers in all fields.");
                return
            }
            var d = [];
            $("tr").each(function () {
                var e = $(this).find("td[data-user-id]").data("user-id");
                if (e) {
                    var grade = t.get("grade") || null;
                    var strand = t.get("strand") || null;
                    var section = t.get("section") || null;
                    var subject = t.get("subject") || null;
                    var semester = t.get("semester") || null;
                    var quarter = t.get("quarter") || null;
                    var track = $('#track').val() || null;

                    // Default grade_handle_id to null
                    var grade_handle_id = null;

                    // Fetch grade_handle_id dynamically
                    if (grade && strand && section) {
                        $.ajax({
                            url: '{{ route("get.grade.id") }}',
                            method: "GET",
                            data: { grade: grade, strand: strand, section: section },
                            async: false, // Synchronous request to wait for response
                            success: function (response) {
                                console.log(response.id);
                                grade_handle_id = response.id; // Assign the fetched ID
                            },
                            error: function (error) {
                                console.error("Error fetching grade_handle_id:", error);
                            },
                        });
                    }

                    var s = {
                        student_id: e,
                        grade,
                        strand,
                        section,
                        semester,
                        quarter,
                        track,
                        subject,
                        grade_handle_id, // Use the dynamically fetched ID
                        written_scores: {},
                        task_scores: {},
                        written_total: parseFloat(
                            $(this).find('td[data-for="written_work_total"]').text().trim()
                        ) || 0,
                        written_ps: parseFloat(
                            $(this).find('td[data-for="written_work_ps"]').text()
                        ) || 0,
                        written_ws: parseFloat(
                            $(this).find('td[data-for="written_work_ws"]').text()
                        ) || 0,

                        task_total: parseFloat(
                            $(this).find('td[data-for="performance_task_total"]').text()
                        ) || 0,
                        task_ps: parseFloat(
                            $(this).find('td[data-for="performance_task_ps"]').text()
                        ) || 0,
                        task_ws: parseFloat(
                            $(this).find('td[data-for="performance_task_ws"]').text()
                        ) || 0,

                        quarter_total: parseFloat(
                            $(this).find('td[data-for="quarterly_assessment"]').text()
                        ) || 0,
                        quart_ps: parseFloat(
                            $(this).find('td[data-for="quarterly_assessment_ps"]').text()
                        ) || 0,
                        quart_ws: parseFloat(
                            $(this).find('td[data-for="quarterly_assessment_ws"]').text()
                        ) || 0,

                        initial_grade: parseFloat(
                            $(this).find('td[data-for="initial_grade"]').text()
                        ) || 0,
                        quarterly_grade: parseFloat(
                            $(this).find('td[data-for="quarterly_grade"]').text()
                        ) || 0,
                    };

                    $(this)
                        .find('td[data-for="written_work"]')
                        .each(function () {
                            var t = $(this).data("cell");
                            s.written_scores["written_" + t] = parseFloat($(this).text()) || null;
                        });
                    $(this)
                        .find('td[data-for="performance_task"]')
                        .each(function () {
                            var t = $(this).data("cell");
                            s.task_scores["task_" + t] = parseFloat($(this).text()) || null;
                        });

                    d.push(s);
                }
            });

            console.log(d);

            // Send AJAX request with the updated data
            $.ajax({
                url: '{{ route("teacher.addHighestPossibleScore") }}',
                type: "POST",
                data: JSON.stringify({
                    ...e,
                    studentScores: d,
                }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (t) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Changes saved successfully!",
                    });
                    console.log("Success:", t);
                },
                error: function (t) {
                    console.error("Error:", t);
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "There was a problem saving the changes. Please try again.",
                    });
                },
            });

        }), $("td#highest_possible_score, td#performance_task_highest_possible_score").each(function() {
            $(this).on("blur", function(t) {
                var e;
                let s, r;
                e = this, r = parseInt(s = $(e).text().trim()), s && (isNaN(r) || r < 5 || r > 10 ? (alert("The highest possible score must be between 5 and 10."), $(e).text("").addClass("border border-red-500").focus()) : $(e).removeClass("border-red-500"))
            })
        });
        let e = [];
        $('td[contenteditable="true"]').each((t, s) => {
            s.hasAttribute("data-user-id") && e.push(s)
        }), e.forEach(t => {
            t.addEventListener("input", function(t) {
                (function t(e) {
                    let s = e.getAttribute("data-user-id"),
                        r = e.getAttribute("data-for"),
                        a = 0,
                        i = 0;


                    $(`td[data-user-id="${s}"][data-for="${r}"]`).each((t, e) => {
                        a += parseInt(e.textContent) || 0
                    });

                    console.log(`td[data-for="${r}_total"]`)

                    // Declare variables outside the if-else blocks
                    let written_percentageScore = 0;
                    let written_weightedScore = 0;
                    let performance_percentageScore = 0;
                    let performance_weightedScore = 0;
                    let quarterly_percentageScore = 0;
                    let quarterly_weightedScore = 0;
                    let initialGrade = 0;
                    let quarterlyGrade = 0;

                    $(e).closest("tr").find(`td[data-for="${r}_total"]`).text(a);

                    // written work
                    // Calculate and store scores in data attributes
                    if (r.trim() === 'written_work') {
                        written_percentageScore = (a / parseFloat($('#highest_possible_written_total').text().trim())) * 100;
                        written_weightedScore = written_percentageScore * percentToDecimal($('#highest_possible_ws').text().trim());
                        // Store the weighted score in a data attribute
                        $(e).closest("tr").attr('data-written-weighted-score', written_weightedScore);
                        $(e).closest("tr").find('td[data-for="written_work_ps"]').text(written_percentageScore.toFixed(2));
                        $(e).closest("tr").find('td[data-for="written_work_ws"]').text(written_weightedScore.toFixed(2));
                    } else if (r.trim() === 'performance_task') {
                        performance_percentageScore = (a / parseFloat($('#highest_possible_task_total').text().trim())) * 100;
                        performance_weightedScore = performance_percentageScore * percentToDecimal($('#highest_possible_task').text().trim());
                        // Store the weighted score in a data attribute
                        $(e).closest("tr").attr('data-performance-weighted-score', performance_weightedScore);
                        $(e).closest("tr").find('td[data-for="performance_task_ps"]').text(performance_percentageScore.toFixed(2));
                        $(e).closest("tr").find('td[data-for="performance_task_ws"]').text(performance_weightedScore.toFixed(2));
                    } else if (r.trim() === 'quarterly_assessment') {
                            quarterly_percentageScore = (a / parseFloat($('#quarterly_assessment_total').text().trim())) * 100;
                            quarterly_weightedScore = quarterly_percentageScore * percentToDecimal($('#highest_possible_quart').text().trim());
                            $(e).closest("tr").attr('data-quarterly-weighted-score', quarterly_weightedScore);

                            // Retrieve stored scores
                            written_weightedScore = parseFloat($(e).closest("tr").attr('data-written-weighted-score')) || 0;
                            performance_weightedScore = parseFloat($(e).closest("tr").attr('data-performance-weighted-score')) || 0;

                            // Calculate grades
                            initialGrade = written_weightedScore + performance_weightedScore + quarterly_weightedScore;
                            quarterlyGrade = transmuteGrade(initialGrade); // Use the transmutation function

                            // Update table
                            $(e).closest("tr").find('td[data-for="quarterly_assessment_ps"]').text(quarterly_percentageScore.toFixed(2));
                            $(e).closest("tr").find('td[data-for="quarterly_assessment_ws"]').text(quarterly_weightedScore.toFixed(2));
                            $(e).closest("tr").find('td[data-for="initial_grade"]').text(initialGrade.toFixed(2));
                            $(e).closest("tr").find('td[data-for="quarterly_grade"]').text(quarterlyGrade);
                    }

                })(this)
            })
        }) // window.addEventListener("beforeunload", function(t) {})
    });

    
</script>


<!-- highest possible score event for getting total  -->
<script>

    function transmuteGrade(initialGrade) {
        if (initialGrade === 100) return 100;
        if (initialGrade >= 98.40) return 99;
        if (initialGrade >= 96.80) return 98;
        if (initialGrade >= 95.20) return 97;
        if (initialGrade >= 93.60) return 96;
        if (initialGrade >= 92.00) return 95;
        if (initialGrade >= 90.40) return 94;
        if (initialGrade >= 88.80) return 93;
        if (initialGrade >= 87.20) return 92;
        if (initialGrade >= 85.60) return 91;
        if (initialGrade >= 84.00) return 90;
        if (initialGrade >= 82.40) return 89;
        if (initialGrade >= 80.80) return 88;
        if (initialGrade >= 79.20) return 87;
        if (initialGrade >= 77.60) return 86;
        if (initialGrade >= 76.00) return 85;
        if (initialGrade >= 74.40) return 84;
        if (initialGrade >= 72.80) return 83;
        if (initialGrade >= 71.20) return 82;
        if (initialGrade >= 69.60) return 81;
        if (initialGrade >= 68.00) return 80;
        if (initialGrade >= 66.40) return 79;
        if (initialGrade >= 64.80) return 78;
        if (initialGrade >= 63.20) return 77;
        if (initialGrade >= 61.60) return 76;
        if (initialGrade >= 60.00) return 75;
        if (initialGrade >= 56.00) return 74;
        if (initialGrade >= 52.00) return 73;
        if (initialGrade >= 48.00) return 72;
        if (initialGrade >= 44.00) return 71;
        if (initialGrade >= 40.00) return 70;
        if (initialGrade >= 36.00) return 69;
        if (initialGrade >= 32.00) return 68;
        if (initialGrade >= 28.00) return 67;
        if (initialGrade >= 24.00) return 66;
        if (initialGrade >= 20.00) return 65;
        if (initialGrade >= 16.00) return 64;
        if (initialGrade >= 12.00) return 63;
        if (initialGrade >= 8.00) return 62;
        if (initialGrade >= 4.00) return 61;
        return 60; // For grades below 4.00
    }

    $(document).ready(function() {

        // Function to calculate total for written work
        function calculateTotalWritten() {
            let totalWritten = 0;

            // Loop through all written work grades to calculate the total
            $('[id="highest_possible_score"]').each(function() {
                let value = $(this).text().trim();
                let number = parseFloat(value);
                if (!isNaN(number)) {
                    totalWritten += number;
                }
            });

            // Update the total written work score in the table
            $('#highest_possible_written_total').text(totalWritten);

        }

        // Function to calculate total for performance tasks
        function calculateTotalTask() {
            let totalTask = 0;

            // Loop through all performance task scores to calculate the total
            $('[id="performance_task_highest_possible_score"]').each(function() {
                let value = $(this).text().trim();
                let number = parseFloat(value);
                if (!isNaN(number)) {
                    totalTask += number;
                }
            });

            // Update the total task score in the table
            $('#highest_possible_task_total').text(totalTask);
        }

        // Event listener to recalculate written work total and scores when input changes
        $(document).on('input', '[id="highest_possible_score"]', function() {
            calculateTotalWritten();
        });

        // Event listener to recalculate task total when input changes
        $(document).on('input', '[id="performance_task_highest_possible_score"]', function() {
            calculateTotalTask();
        });

        // Initial calculation on page load
        calculateTotalWritten();
        calculateTotalTask();
    });
</script>
<!-- highest possible score event for getting total  -->



<!-- Prencvent input non-numeric -->
<script>
  document.addEventListener("input", function (event) {
    if (event.target.hasAttribute("contenteditable") && event.target.getAttribute("contenteditable") === "true") {
      event.target.textContent = event.target.textContent.replace(/[^0-9]/g, "");
    }
  });
</script>


@endsection