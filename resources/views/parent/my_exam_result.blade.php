@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Exam Result <span style="color: blue;">({{ $getStudent->name }} {{ $getStudent->last_name }}
                                )</span></h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><span style="color: blue"><b>Search My Exam Result</b></span></h5>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Exam Name <span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="exam_id" required>
                                                <option value="">Select Exam</option>
                                                @foreach ($getExam as $exam)
                                                    <option value="{{ $exam->exam_id }}"
                                                        {{ Request::get('exam_id') == $exam->exam_id ? 'selected' : '' }}>
                                                        {{ $exam->exam_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                <a href="{{ url('parent/my_student/exam_result/'.$student_id) }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!empty($getRecord))
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <h4 class="col-md-11"><span style="color: blue">{{ $getExamName->exam_name }}
                                            </span>
                                        </h4>
                                        <a class="btn btn-primary btn-sm col-md-1" style="float: right;" target="_blank"
                                            href="{{ url('student/my_exam_result/print?exam_id=' . $getExamName->exam_id . '&student_id=' . Auth::user()->id) }}">Print</a>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>Class Work</th>
                                                <th>Test Work</th>
                                                <th>Home Work</th>
                                                <th>Exam</th>
                                                <th>Total Score</th>
                                                <th>Passing Marks</th>
                                                <th>Full Marks</th>
                                                <th>Result</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getRecord as $value)
                                                @php
                                                    $total_score = 0;
                                                    $full_marks = 0;
                                                    $result_validation = 0;
                                                @endphp
                                                @foreach ($value['subject'] as $exam)
                                                    @php
                                                        $total_score += $exam['total_score'];
                                                        $full_marks += $exam['full_marks'];
                                                    @endphp
                                                    <tr>
                                                        <td style="width: 200px;">{{ $exam['subject_name'] }}</td>
                                                        <td>{{ $exam['class_work'] }}</td>
                                                        <td>{{ $exam['test_work'] }}</td>
                                                        <td>{{ $exam['home_work'] }}</td>
                                                        <td>{{ $exam['exam'] }}</td>
                                                        <td>{{ $exam['total_score'] }}</td>
                                                        <td>{{ $exam['passing_marks'] }}</td>
                                                        <td>{{ $exam['full_marks'] }}</td>
                                                        <td>
                                                            @if ($exam['total_score'] >= $exam['passing_marks'])
                                                                <span style="color: green; font-weight: bold">Pass</span>
                                                            @else
                                                                @php
                                                                    $result_validation = 1;
                                                                @endphp
                                                                <span style="color: red; font-weight: bold">Fail</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Grand Total:
                                                            {{ $total_score }}/{{ $full_marks }}</b>
                                                    </td>
                                                    <td colspan="2">
                                                        @php
                                                            $percentage = ($total_score * 100) / $full_marks;
                                                            $getGrade = App\Models\MarksGradeModel::getGrade($percentage);
                                                        @endphp
                                                        <b>Percentage: {{ round($percentage, 2) }}%</b>
                                                    </td>
                                                    <td colspan="2">
                                                        <b>Grade: {{ $getGrade }}</b>
                                                    </td>
                                                    <td colspan="3">
                                                        <b>
                                                            Result:
                                                            @if ($result_validation == 0)
                                                                <span style="color: green; font-weight: bold">Pass</span>
                                                            @else
                                                                <span style="color: red; font-weight: bold">Fail</span>
                                                            @endif
                                                        </b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
