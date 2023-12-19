@extends('layouts.app')
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Submit My Homework</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('student/my_homework') }}" class="btn btn-primary"> Back </a>
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
                            <form action="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Document<span style="color: red">*</span></label>
                                        <input type="file" class="form-control" name="document_file"
                                            value="{{ old('document_file') }}" placeholder="Enter Subject" required>
                                        @if ($errors->has('document_file'))
                                            <p class="text-danger">{{ $errors->first('document_file') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Description <span style="color: red">*</span></label>
                                        <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px">
                                            {{ old('description') }}
                                          </textarea>
                                        @if ($errors->has('description'))
                                            <p class="text-danger">{{ $errors->first('description') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2" onclick="return confirmSubmit()";>Submit</button>
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
    <script>
        function confirmSubmit() {
            return confirm('You will not be able to edit your work.Are you sure you want to submit homework?');
        }
    </script>
@endsection

@section('script')
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            console.log(123);
            $('#compose-textarea').summernote({
                height: 200
            });

        });
    </script>
@endsection
