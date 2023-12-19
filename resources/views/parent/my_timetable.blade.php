@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> My Class Timetable (  {{ $getClass->name}} - {{ $getSubject->name }}) <span style="color: :blue"> {{$getStudent->name}}  {{$getStudent->last_name}}</span></h1>
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
                                    <h4>
                                       <span style="color: blue">{{ $getClass->name}} - {{ $getSubject->name }}</span>
                                    </h4>
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
                                            @foreach ($getRecord as $valueW)
                                                <tr>
                                                    <td> {{$valueW['week_name']}}</td>
                                                    <td> {{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}</td>
                                                    <td> {{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}</td>
                                                    <td> {{$valueW['room_number']}}</td>

                                                </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

