@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Marks Grade</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/examinations/marks_grade') }}" class="btn btn-primary"> Back </a>
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
                                        <label for="">Grade Name <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="name" required
                                            value="{{ old('name') }}" placeholder="Enter Grade Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Percent From<span style="color: red">*</span></label>
                                        <input type="number" class="form-control" name="percent_from" required
                                            value="{{ old('percent_from') }}" placeholder="Enter Percent From">
                                        @if ($errors->has('percent_from'))
                                            <p class="text-danger">{{ $errors->first('percent_from') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Percent To<span style="color: red">*</span></label>
                                        <input type="number" class="form-control" name="percent_to" required
                                            value="{{ old('percent_to') }}" placeholder="Enter Percent To">
                                        @if ($errors->has('percent_to'))
                                            <p class="text-danger">{{ $errors->first('percent_to') }}</p>
                                        @endif
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
