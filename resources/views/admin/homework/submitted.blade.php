@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Submitted Homework </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/homework/homework') }}" class="btn btn-primary"> Back </a>
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
                                <h4><span style="color: blue"><b>Search Submitted Homework</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="">Student First Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Student First Name"
                                                 value="{{ Request::get('first_name') }}"
                                                 name="first_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Student Last Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Student last Name"
                                                 value="{{ Request::get('last_name') }}"
                                                 name="last_name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Created Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('from_created_date') }}"
                                                 name="from_created_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To Created Date</label>
                                            <input type="date" class="form-control" data-time=""
                                                 value="{{ Request::get('to_created_date') }}"
                                                 name="to_created_date">
                                        </div>


                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/homework/homework/submitted/'.$homework_id) }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue"><b>Homework List </b></span></h4>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Document</th>
                                            <th>Description</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td> {{ $value->first_name}} {{$value->last_name}}</td>
                                                <td>
                                                   @if (!empty($value->getDocument()))
                                                    <a href="{{ $value->getDocument() }}" class="btn btn-secondary" download="">
                                                        Download
                                                    </a>
                                                   @else
                                                        No Document
                                                   @endif
                                                </td>
                                                <td> {{ $value->description }}</td>
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
