@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Notice Board</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/communicate/notice_board/list') }}" class="btn btn-primary"> Back </a>
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
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="title" required
                                            value="{{ $getRecord->title }}" placeholder="Enter Title">
                                        @if ($errors->has('title'))
                                            <p class="text-danger">{{ $errors->first('title') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Notice Date</label>
                                        <input type="date" class="form-control" name="notice_date"
                                            value="{{ $getRecord->notice_date }}">
                                        @if ($errors->has('notice_date'))
                                            <p class="text-danger">{{ $errors->first('notice_date') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Publish Date</label>
                                        <input type="date" class="form-control" name="publish_date" required
                                            value="{{ $getRecord->publish_date }}">
                                        @if ($errors->has('publish_date'))
                                            <p class="text-danger">{{ $errors->first('publish_date') }}</p>
                                        @endif
                                    </div>

                                    @php
                                        $message_to_student = $getRecord->getMessageToSingle($getRecord->id, 3);
                                        $message_to_parent = $getRecord->getMessageToSingle($getRecord->id, 4);
                                        $message_to_teacher = $getRecord->getMessageToSingle($getRecord->id, 2);
                                    @endphp

                                    <div class="form-group">
                                        <label style="display: block;">Message To</label>
                                        <label style="margin-right: 50px;">
                                            <input type="checkbox" value="3" name="message_to[]" {{!empty($message_to_student) ? 'checked' : ''}} > Student
                                        </label>
                                        <label style="margin-right: 50px;">
                                            <input type="checkbox" value="4" name="message_to[]" {{!empty($message_to_parent) ? 'checked' : ''}}> Parent
                                        </label>
                                        <label>
                                            <input type="checkbox" value="2" name="message_to[]" {{!empty($message_to_teacher) ? 'checked' : ''}}> Teacher
                                        </label>

                                        @if ($errors->has('message_to'))
                                            <p class="text-danger">{{ $errors->first('message_to') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Message</label>
                                        <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                                            {{$getRecord->message}}
                                          </textarea>
                                        @if ($errors->has('message'))
                                            <p class="text-danger">{{ $errors->first('message') }}</p>
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

@section('script')
    <script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            $('#compose-textarea').summernote({
                height: 200
            });
        });
    </script>
@endsection
