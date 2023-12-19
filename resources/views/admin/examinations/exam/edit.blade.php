@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Exam</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/examinations/exam/list') }}" class="btn btn-primary"> Back </a>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $getRecord->name }}" required placeholder="Enter Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Note <span style="color: red"></span> </label>
                                        <textarea name="note" class="form-control" rows="2" required placeholder="Note Exam">{{$getRecord->note}}</textarea>
                                        @if ($errors->has('note'))
                                            <p class="text-danger">{{ $errors->first('note') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label for="">Status <span style="color: red"></span> </label>
                                        <select class="form-control" name="status" id="" required>
                                            <option value="">Select Status</option>
                                            <option value="0" {{ $getRecord->status == '0' ? 'selected' : '' }}>Active</option>
                                            <option value="1" {{ $getRecord->status == '1' ? 'selected' : '' }}>In Active</option>
                                        </select>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Update</button>
                                </div>
                            </form>
                        </div>


                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
