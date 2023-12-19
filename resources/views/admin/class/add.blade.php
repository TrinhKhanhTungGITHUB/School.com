@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Class</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/class/list') }}" class="btn btn-primary"> Back </a>
                    </div>

                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Class Name</label>
                                        <input type="text" class="form-control" name="name" required
                                            value="{{ old('name') }}" placeholder="Enter Class Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Amount ($)</label>
                                        <input type="number" class="form-control" name="amount" required
                                            value="{{ old('amount') }}" placeholder="Enter Amount">
                                        @if ($errors->has('amount'))
                                            <p class="text-danger">{{ $errors->first('amount') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="0">Active</option>
                                            <option value="1">In Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
