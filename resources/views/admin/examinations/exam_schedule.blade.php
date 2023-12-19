@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> {{ $header_title }} </h1>
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
                                <h5><span style="color: blue"><b>Search Exam Schedule</b></span></h5>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="">Exam Name <span style="color: red">*</span></label>
                                            <select class="form-control" name="exam_id" required>
                                                <option value="">Select Exam</option>
                                                @foreach ($getExam as $exam)
                                                    <option value="{{ $exam->id }}"
                                                        {{ Request::get('exam_id') == $exam->id ? 'selected' : '' }}>
                                                        {{ $exam->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Class Name<span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="class_id" required>
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                <a href="{{ url('admin/examinations/exam_schedule') }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!empty($getRecord))
                            <form action="{{ url('admin/examinations/exam_schedule_insert') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                                <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><span style="color: blue"><b>Exam Schedule </b></span></h5>
                                    </div>

                                    <div class="card-body p-0">
                                        <table class="table table-striped" style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Room Number</th>
                                                    <th>Full Marks</th>
                                                    <th>Passing Marks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($getRecord as $value)
                                                    <tr>
                                                        <td> {{ $value['subject_name'] }}
                                                            <input type="hidden" class="form-control"
                                                                value="{{ $value['subject_id'] }}"
                                                                name="schedule[{{ $i }}][subject_id]">
                                                        </td>
                                                        <td>
                                                            <input type="date" class="form-control"
                                                                value="{{ $value['exam_date'] }}"
                                                                name="schedule[{{ $i }}][exam_date]">
                                                        </td>
                                                        <td>
                                                            <input type="time" class="form-control"
                                                                value="{{ $value['start_time'] }}"
                                                                name="schedule[{{ $i }}][start_time]">
                                                        </td>
                                                        <td>
                                                            <input type="time" class="form-control"
                                                                value="{{ $value['end_time'] }}"
                                                                name="schedule[{{ $i }}][end_time]">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $value['room_number'] }}"
                                                                name="schedule[{{ $i }}][room_number]">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                value="{{ $value['full_marks'] }}"
                                                                name="schedule[{{ $i }}][full_marks]">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                value="{{ $value['passing_marks'] }}"
                                                                name="schedule[{{ $i }}][passing_marks]">
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="card-footer d-flex justify-content-center">
                                            <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')

@endsection
