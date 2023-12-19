@extends('layouts.app')

@section('content')



    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Student </h1>
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
                                <h3><span style="color: blue"><b>My Student List</b></span></h3>
                            </div>
                            <div class="card-body p-0 " style="overflow: auto" >
                                <table class="table table-striped" style="text-align: center" >
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Class Name</th>
                                            <th>Admission Number</th>
                                            <th>Roll Number</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Admission Date</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>Caste</th>
                                            <th>Religion</th>
                                            <th>Blood Group</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                        <tr>
                                            <td>
                                                @if (!empty($value->getProfile()))
                                                <img src="{{ $value->getProfile()}}" style="height: 50px; width: 50px; border-radius: 50px;" alt="Avatar {{$value->id }}">
                                                @else
                                                <img src=" {{ asset(env('UPLOAD_PATH').'/profile/'. 'no_avatar.jpg') }}"
                                                    style="height: 50px; width: 50px; border-radius: 50px;" alt="Avatar {{$value->id }}">
                                                @endif
                                            </td>
                                            <td style="min-width: 150px"> {{ $value->name }}  {{$value->last_name}}</td>
                                            <td> {{ $value->gender}}</td>
                                            <td style="min-width: 100px"> {{ date('d-m-Y', strtotime($value->date_of_birth)) }}</td>
                                            <td style="min-width: 80px"> {{ $value->class_name}}</td>
                                            <td> {{ $value->admission_number}}</td>
                                            <td> {{ $value->roll_number}}</td>

                                            <td> {{ $value->email }}</td>
                                            <td> {{ $value->mobile_number}}</td>

                                            <td style="min-width: 100px"> {{ date('d-m-Y', strtotime($value->admission_date)) }}</td>
                                            <td> {{ $value->height}}</td>

                                            <td> {{ $value->weight}}</td>

                                            <td> {{ $value->caste}}</td>
                                            <td> {{ $value->religion}}</td>

                                            <td> {{ $value->blood_group}}</td>

                                            <td style="min-width: 180px"> {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                            <td style="min-width: 450px;">
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-success btn-sm text-truncate" href="{{url('parent/my_student/subject/'.$value->id)}}">Subject</a>
                                                    <a class="btn btn-primary btn-sm text-truncate" href="{{url('parent/my_student/exam_timetable/'.$value->id)}}">Exam Timetable</a>
                                                    <a class="btn btn-secondary btn-sm text-truncate" href="{{url('parent/my_student/exam_result/'.$value->id)}}">Exam Result</a>
                                                    <a class="btn btn-warning btn-sm text-truncate" href="{{url('parent/my_student/calendar/'.$value->id)}}">Calendar</a>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-info btn-sm text-truncate" href="{{url('parent/my_student/attendance/'.$value->id)}}">Attendance</a>
                                                    <a class="btn btn-dark btn-sm text-truncate" href="{{url('parent/my_student/homework/'.$value->id)}}">Homework</a>
                                                    <a class="btn btn-success btn-sm text-truncate" href="{{url('parent/my_student/submitted_homework/'.$value->id)}}">Submitted Homework</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
