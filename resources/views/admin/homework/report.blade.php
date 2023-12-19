@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1> Homework Report List </h1>
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
                                <h3 class="card-title"><span>Search Homework Report</span></h3>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-2">
                                            <label for="">Student First Name </label>
                                            <input type="text" class="form-control" value="{{ Request::get('first_name') }}"
                                            name="first_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Student Last Name </label>
                                            <input type="text" class="form-control" value="{{ Request::get('last_name') }}"
                                            name="last_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Class Name </label>
                                            <input type="text" class="form-control" value="{{ Request::get('class_name') }}"
                                            name="class_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Subject Name </label>
                                            <input type="text" class="form-control" value="{{ Request::get('subject_name') }}"
                                            name="subject_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Homework Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_homework_date') }}"
                                                 name="from_homework_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To Homework Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_homework_date') }}"
                                                 name="to_homework_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Submission Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_submission_date') }}"
                                                 name="from_submission_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To submission Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_submission_date') }}"
                                                 name="to_submission_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Submitted Created Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_created_date') }}"
                                                 name="from_created_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To Submitted Created Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_created_date') }}"
                                                 name="to_created_date">
                                        </div>


                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/homework/homework_report') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><span>Homework Report List </span></h3>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Homework Date</th>
                                            <th>Submission Date</th>
                                            <th>Document</th>
                                            <th>Description</th>
                                            <th>Created Date</th>

                                            <th>Submitted Document</th>
                                            <th>Submitted Description</th>
                                            <th>Submitted Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td> {{ $value->first_name }} {{ $value->last_name}}</td>
                                                <td> {{ $value->class_name }}</td>
                                                <td> {{ $value->subject_name }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->getHomework->homework_date)) }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->getHomework->submission_date)) }}</td>
                                                <td>
                                                   @if (!empty($value->getHomework->getDocument()))
                                                    <a href="{{ $value->getHomework->getDocument() }}" class="btn btn-secondary" download="">
                                                        Download
                                                    </a>
                                                   @else
                                                        No Document
                                                   @endif
                                                </td>
                                                <td> {!!$value->getHomework->description !!}</td>

                                                <td> {{ date('d-m-Y', strtotime($value->getHomework->created_at)) }}</td>

                                                <td>
                                                   @if (!empty($value->getDocument()))
                                                    <a href="{{ $value->getDocument() }}" class="btn btn-secondary" download="">
                                                        Download
                                                    </a>
                                                   @else
                                                        No Document
                                                   @endif
                                                </td>
                                                <td> {!!$value->description !!}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%"> Record not found. </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

