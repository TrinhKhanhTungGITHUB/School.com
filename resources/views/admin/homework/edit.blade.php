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
                        <h1>Edit New Homework</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/homework/homework') }}" class="btn btn-primary"> Back </a>
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
                                        <label for="">Class Name <span style="color: red">*</span></label>
                                        <select class="form-control getClass" name="class_id" required>
                                            <option value="">Select Class</option>
                                            @foreach ($getClass as $class)
                                                <option {{$getRecord->class_id == $class->id ? 'selected' :''}}
                                                    value="{{ $class->id }}"> {{ $class->name }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('class_id'))
                                            <p class="text-danger">{{ $errors->first('class_id') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Subject Name <span style="color: red">*</span></label>
                                        <select class="form-control getSubject" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                            @if (!empty($getSubject))
                                            @foreach ($getSubject as $subject)
                                                <option {{$getRecord->subject_id == $subject->id ? 'selected' :''}}
                                                    value="{{ $subject->subject_id }}"> {{ $subject->subject_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                        </select>
                                        @if ($errors->has('subject_id'))
                                            <p class="text-danger">{{ $errors->first('subject_id') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Homework Date<span style="color: red">*</span></label>
                                        <input type="date" class="form-control" name="homework_date" required
                                            value="{{$getRecord->homework_date}}">
                                        @if ($errors->has('homework_date'))
                                            <p class="text-danger">{{ $errors->first('homework_date') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Submission Date <span style="color: red">*</span></label>
                                        <input type="date" class="form-control" name="submission_date" required
                                            value="{{ $getRecord->submission_date }}">
                                        @if ($errors->has('submission_date'))
                                            <p class="text-danger">{{ $errors->first('submission_date') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Document</label>
                                        <input type="file" class="form-control" name="document_file">
                                        @if (!empty($getRecord->getDocument()))
                                        <a href="{{ $getRecord->getDocument() }}" class="btn btn-secondary" download="">
                                            Download
                                        </a>
                                       @else
                                            No Document
                                       @endif
                                        @if ($errors->has('document_file'))
                                            <p class="text-danger">{{ $errors->first('document_file') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Description <span style="color: red">*</span></label>
                                        <textarea id="compose-textarea" name="description" class="form-control" style="height: 300px">
                                            {{ $getRecord->description }}
                                          </textarea>
                                        @if ($errors->has('description'))
                                            <p class="text-danger">{{ $errors->first('description') }}</p>
                                        @endif
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

@section('script')
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">
        $('.getClass').change(function() {
            var class_id = $(this).val();
            $.ajax({
                url: " {{ url('admin/class_timetable/get_subject') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_id,
                },
                dataType: "json",
                success: function(response) {
                    $('.getSubject').html(response.html);
                },
            });
        });
        $(function() {
            console.log(123);
            $('#compose-textarea').summernote({
                height: 200
            });

        });
    </script>
@endsection
