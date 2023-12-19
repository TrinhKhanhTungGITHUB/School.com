@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Collect Fees </h1>
                    </div>

                    <div class="col-sm-6" style="text-align: right;">
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
                                <h3><span style="color: blue"><b>Search Collect Fees Student</b></span></h3>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="">Class Name</label>
                                            <select class="form-control" name="class_id" id="">
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                        value="{{ $class->id }} "> {{ $class->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Student ID</label>
                                            <input type="number" class="form-control" name="student_id"
                                                value="{{ Request::get('student_id') }}" placeholder="Enter Student ID">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Student First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                value="{{ Request::get('first_name') }}" placeholder="Enter First Name">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="">Student Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ Request::get('last_name') }}" placeholder="Enter Last Name">
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/fees_collection/collect_fees') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3><span style="color: blue"><b>Student List</b> </span></h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Class Name</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Remaining Amount</th>
                                            <th>Created Date</th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getRecord))
                                            @forelse ($getRecord as $value)
                                                @php
                                                    $paid_amount = $value->getPaidAmount($value->id, $value->class_id);

                                                    $remainingAmount = $value->amount - $paid_amount;
                                                @endphp
                                                <tr>
                                                    <td> {{ $value->id }}</td>
                                                    <td> {{ $value->name }} {{ $value->last_name }}</td>
                                                    <td> {{ $value->class_name }}</td>
                                                    <td> ${{ number_format($value->amount, 2) }}</td>
                                                    <td> ${{ number_format($paid_amount, 2) }}</td>
                                                    <td> ${{ number_format($remainingAmount, 2) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/fees_collection/collect_fees/add_fees/' . $value->id) }}"
                                                            class="btn btn-success">Collect Fees</a>
                                                    </td>
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
