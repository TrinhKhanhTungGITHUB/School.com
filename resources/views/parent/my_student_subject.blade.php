@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Student Subject <span style="color: blue">
                                @if (!empty($getUser))
                                    ({{ $getUser->name }} {{ $getUser->last_name }})
                                @endif
                            </span></h1>
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
                                <h3 class="card-title"><span>My Student Subject </span></h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Subject Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getRecord))
                                            @foreach ($getRecord as $value)
                                                <tr>
                                                    <td>{{ $value->id }}</td>
                                                    <td>{{ $value->subject_name }}</td>
                                                    <td>{{ $value->subject_type }}</td>
                                                    <td>
                                                        <a href="{{ url('parent/my_student/subject/class_timetable/' . $value->class_id . '/' . $value->subject_id . '/' . $getUser->id) }}"
                                                            class="btn btn-primary">
                                                            My Class Timetable
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="100%" style="color: red">Record Not Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
