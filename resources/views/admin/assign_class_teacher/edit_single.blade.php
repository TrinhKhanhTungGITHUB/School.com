@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Assign Class Teacher</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/assign_class_teacher/list') }}" class="btn btn-primary"> Back </a>
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
                                        <label for="">Class Name<span style="color: red">*</span></label>
                                        <select class="form-control" name="class_id" required>
                                            <option value="">Select Class</option>
                                            @foreach ($getClass as $class )
                                                <option value="{{ $class->id }}" {{ $getRecord->class_id == $class->id  ? 'selected' :'' }}> {{ $class->name }} </option>
                                            @endforeach
                                            @if($errors->has('class_id'))<p class="text-danger">{{ $errors->first('class_id') }}</p> @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Teacher Name<span style="color: red">*</span></label>
                                        <select class="form-control" name="teacher_id" required>
                                            <option value="">Select Teacher</option>
                                            @foreach ($getTeacher as $teacher )
                                                <option value="{{ $teacher->id }}" {{ $getRecord->teacher_id == $teacher->id  ? 'selected' :'' }}> {{ $teacher->name }} {{ $teacher->last_name }}</option>
                                            @endforeach
                                            @if($errors->has('teacher_id'))<p class="text-danger">{{ $errors->first('teacher_id') }}</p> @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Status<span style="color: red">*</span></label>
                                        <select class="form-control" name="status" id="">
                                            <option {{ ($getRecord->status == 0) ? 'selected' :'' }} value="0">Active</option>
                                            <option {{ ($getRecord->status == 1) ? 'selected' :'' }} value="1">In Active</option>
                                        </select>
                                        @if($errors->has('status'))<p class="text-danger">{{ $errors->first('status') }}</p> @endif
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
