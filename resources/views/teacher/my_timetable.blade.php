@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (!empty($getClass) && !empty($getSubject))
                            <h1> My Timetable ( {{ $getClass->name }} - {{ $getSubject->name }})</h1>

                        @else
                            <h1> My Timetable </h1>
                        @endif
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('teacher/my_class_subject?class_id='. Request::segment(4). '&subject_id='.Request::segment(5)) }}" class="btn btn-primary"> Back</a>
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
                                <h3 class="card-title">
                                    <h4>
                                        @if (!empty($getClass) && !empty($getSubject))
                                            <span style="color: blue"><b>{{ $getClass->name }} -
                                                    {{ $getSubject->name }}</b></span>
                                        @else
                                            <span style="color: blue"><b>My Class Subject Timetable</b></span>
                                        @endif
                                    </h4>


                                </h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($getRecord) && count($getRecord) > 0)
                                            @foreach ($getRecord as $valueW)
                                                <tr>
                                                    <td>{{ $valueW['week_name'] }}</td>
                                                    <td>{{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}
                                                    </td>
                                                    <td>{{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}
                                                    </td>
                                                    <td>{{ $valueW['room_number'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%" style="color: red">Record Not Found</td>
                                            </tr>
                                        @endif

                                        {{-- @foreach ($getRecord as $valueW)
                                            <tr>
                                                <td> {{ $valueW['week_name'] }}</td>
                                                <td> {{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}
                                                </td>
                                                <td> {{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}
                                                </td>
                                                <td> {{ $valueW['room_number'] }}</td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

@endsection
