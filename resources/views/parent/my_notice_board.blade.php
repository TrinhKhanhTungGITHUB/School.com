@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Notice Board</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"><span>Search Notice Board</span></h3>
                        </div>
                        <form action="" method="GET">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ Request::get('title') }}" placeholder="Enter Title">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Notice Date From</label>
                                        <input type="date" class="form-control" name="notice_date_from"
                                            value="{{ Request::get('notice_date_from') }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">Notice Date To</label>
                                        <input type="date" class="form-control" name="notice_date_to"
                                            value="{{ Request::get('notice_date_to') }}">
                                    </div>

                                    <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                        <button class="btn btn-primary" type="submit">Search </button>
                                        <div class="ml-1"> <a href="{{ url('parent/my_notice_board') }}"
                                                class="btn btn-success">Reset</a> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="row">

                    @foreach ($getRecord as $value)
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-body p-0">
                                    <div class="mailbox-read-info">
                                        <h5><b>{{ $value->title }}</b></h5>
                                        <h6 style="margin-top: 10px;">  {{ date('d-m-Y', strtotime($value->notice_date))}}
                                        </h6>
                                    </div>
                                    <div class="mailbox-read-message">
                                            {!! $value->message !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
                <div style="padding: 10px;" class="d-flex justify-content-center">
                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
