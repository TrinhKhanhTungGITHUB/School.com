@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Exam Timetable
                            <span style="color: blue;">
                                @if (!empty($getStudent))
                                    ({{ $getStudent->name }} {{ $getStudent->last_name }})
                                @endif
                            </span>
                        </h1>
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
                                <h5><span style="color: blue"><b>Search My Timetable</b></span></h5>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Exam Name <span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="exam_id" required>
                                                <option value="">Select Exam</option>
                                                @if (!empty($getExam))
                                                    @foreach ($getExam as $exam)
                                                        <option value="{{ $exam->exam_id }}"
                                                            {{ Request::get('exam_id') == $exam->exam_id ? 'selected' : '' }}>
                                                            {{ $exam->exam_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                <a href="{{ url('parent/my_student/exam_timetable/' . $student_id) }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!empty($getRecord))
                            @if ($getRecord->count() > 0)
                                <div class="card">
                                    <div class="card-header">
                                        <h4><span style="color: blue"><b>{{ $getExamName->exam_name }}</b> </span></h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped" style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>Day</th>
                                                    <th>Exam date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Room Number</th>
                                                    <th>Full Marks</th>
                                                    <th>Passing Marks</th>
                                                </tr>
                                            </thead>
                                            @foreach ($getRecord as $value)
                                                <tbody>

                                                    <tr>
                                                        <td> {{ $value->subject_name }}</td>
                                                        <td> {{ date('l', strtotime($value->exam_date)) }}</td>
                                                        <td> {{ date('d-m-Y', strtotime($value->exam_date)) }}</td>
                                                        <td> {{ date('h:i A', strtotime($value->start_time)) }}</td>
                                                        <td> {{ date('h:i A', strtotime($value->end_time)) }}</td>
                                                        <td> {{ $value->room_number }}</td>
                                                        <td> {{ $value->full_marks }}</td>
                                                        <td> {{ $value->passing_marks }}</td>
                                                    </tr>

                                                </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                </div>
        </section>
    </div>
@endsection
