@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> My Timetable</h1>
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
                                            <label for="">Subject Name<span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="subject_id" required>
                                                <option value="">Select Subject</option>
                                                @foreach ($getSubject as $subject)
                                                    <option value="{{ $subject->subject_id }}"
                                                        {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                                        {{ $subject->subject_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                <a href="{{ url('student/my_timetable') }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!empty($getRecord))
                            @foreach ($getRecord as $value)
                                <div class="card">
                                    <div class="card-header">
                                        <h4><span style="color: blue">{{$getClass->name}} - {{ $value['name'] }}  </span></h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Week</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Room Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($value['week'] as $valueW)
                                                    <tr>
                                                        <td> {{ $valueW['week_name'] }}</td>
                                                        <td> {{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}
                                                        </td>
                                                        <td> {{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}
                                                        </td>
                                                        <td> {{ $valueW['room_number'] }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
        </section>
    </div>
@endsection
