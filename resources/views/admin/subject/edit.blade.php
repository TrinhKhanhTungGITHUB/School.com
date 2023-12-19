@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Subject</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/subject/list') }}" class="btn btn-primary"> Back </a>
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
                                        <label for="">Name<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $getRecord->name }}" required placeholder="Enter Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Subject Type<span style="color: red">*</span></label>
                                        <select class="form-control" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="Theory" {{ $getRecord->type == 'Theory' ? 'selected' : '' }}>Theory
                                            </option>
                                            <option value="Practical" {{ $getRecord->type == 'Practical' ? 'selected' : '' }}>
                                                Practical</option>
                                            @if ($errors->has('type'))
                                                <p class="text-danger">{{ $errors->first('type') }}</p>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Status<span style="color: red">*</span></label>
                                        <select class="form-control" name="status" id="">
                                            <option value="0" {{ $getRecord->status == 0 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="1" {{ $getRecord->status == 1 ? 'selected' : '' }}>In Active
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Update</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
