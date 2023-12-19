@extends('layouts.app')

@section('content')


    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Collect Fees Report</h1>
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
                                <h4><span style="color: blue"><b>Search Collect Fees Report</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Student ID<span style="color: red"></span></label>
                                            <input type="number" class="form-control" name="student_id"
                                                placeholder="Enter Student ID" value="{{ Request::get('student_id') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Student Name<span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="student_name"
                                                placeholder="Enter Student Name" value="{{ Request::get('student_name') }}">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="">Student Last Name<span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="student_last_name"
                                                placeholder="Enter Student Last Name"
                                                value="{{ Request::get('student_last_name') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Class Name<span style="color: red"></span></label>
                                            <select class="form-control getClass" name="class_id" id="getClass">
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }} value="{{ $class->id }}">
                                                        {{ $class->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Start Created Date<span style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('start_created_date') }}" name="start_created_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">End Created Date<span style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('end_created_date') }}" name="end_created_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Payment Type<span style="color: red"></span></label>
                                            <select class="form-control" name="payment_type">
                                                <option value="">Select Type</option>
                                                <option {{ Request::get('payment_type') == 'Cash' ? 'selected' : '' }}
                                                    value="Cash">Cash</option>
                                                <option {{ Request::get('payment_type') == 'Cheque' ? 'selected' : '' }}
                                                    value="Cheque">Cheque</option>
                                                <option {{ (Request::get('payment_type') == 'Paypal') ? 'selected' : '' }}
                                                    value="Paypal">Paypal</option>
                                                <option {{ (Request::get('payment_type') == 'Stripe') ? 'selected' : '' }}
                                                    value="Stripe">Stripe</option>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a
                                                    href="{{ url('admin/fees_collection/collect_fees_report') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header row">
                                <h4 class="col-md-11"><span style="color: blue"><b>Collect Fees Report</b> </span></h4>
                                <form style="float: right;" method="post"  action="{{ url('admin/fees_collection/export_collect_fees_report')}}" class="col-md-1">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{Request::get('student_id')}}" name="student_id" >
                                    <input type="hidden" value="{{Request::get('student_name')}}" name="student_name" >
                                    <input type="hidden" value="{{Request::get('student_last_name')}}" name="student_last_name" >
                                    <input type="hidden" value="{{Request::get('class_id')}}" name="class_id" >
                                    <input type="hidden" value="{{Request::get('start_created_date')}}" name="start_created_date" >
                                    <input type="hidden" value="{{Request::get('end_created_date')}}" name="end_created_date" >
                                    <input type="hidden" value="{{Request::get('payment_type')}}" name="payment_type" >
                                    <button type="submit" class="btn btn-primary ">Export Excel</button>
                                </form>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Class Name</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Remaining Amount</th>

                                            <th>Payment Type</th>
                                            <th>Remark</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getRecord))
                                            @forelse ($getRecord as $value)
                                                <tr>
                                                    <td> {{ $value->id }}</td>
                                                    <td> {{ $value->student_id }}</td>
                                                    <td> {{ $value->student_name_first }} {{ $value->student_name_last }}
                                                    </td>
                                                    <td> {{ $value->class_name }}</td>
                                                    <td> ${{ number_format($value->total_amount, 2) }}</td>
                                                    <td> ${{ number_format($value->paid_amount, 2) }}</td>
                                                    <td> ${{ number_format($value->remaining_amount, 2) }}</td>

                                                    <td> {{ $value->payment_type }}</td>
                                                    <td> {{ $value->remark }}</td>
                                                    <td> {{ $value->created_name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%">Record not found</td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="100%">Record not found</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                    @if (!empty($getRecord))
                                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

