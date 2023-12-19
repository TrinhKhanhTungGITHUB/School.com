@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Student Homework - <span style="color:blue;">{{$getStudent->name}} {{$getStudent->last_name}}</span></h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('parent/my_student') }}" class="btn btn-primary"> Back </a>
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
                                <h4><span style="color: blue"><b> Search Student Homework </b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Subject Name <span style="color: red">*</span></label>
                                            <select class="form-control getSubject" id="getSubject" name="subject_id"
                                                >
                                                <option value="">Select Subject</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option value="{{ $subject->subject_id }}"
                                                            {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}
                                                            >
                                                            {{ $subject->subject_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">From Homework Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_homework_date') }}"
                                                 name="from_homework_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">To Homework Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_homework_date') }}"
                                                 name="to_homework_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">From Submission Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_submission_date') }}"
                                                 name="from_submission_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">To submission Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_submission_date') }}"
                                                 name="to_submission_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">From Created Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_created_date') }}"
                                                 name="from_created_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">To Created Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_created_date') }}"
                                                 name="to_created_date">
                                        </div>


                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('parent/my_student/homework/'.$getStudent->id) }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue"><b>Student Homework List </b></span></h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            <th>Homework Date</th>
                                            <th>Submission Date</th>
                                            <th>Document</th>
                                            <th>Description</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td> {{ $value->class_name }}</td>
                                                <td> {{ $value->subject_name }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->homework_date)) }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->submission_date)) }}</td>
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
                                                <td> {{ $value->created_by_name }}</td>
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
@section('script')
    <script type="text/javascript">
    </script>
@endsection
