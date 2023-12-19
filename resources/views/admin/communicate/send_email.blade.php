@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('public/plugins/select2/css/select2.min.css') }}">
    <style type="text/css">
        .select2-container .select2-container--single
        {
            height: 40px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Send Email</h1>
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
                                        <label for="">Subject</label>
                                        <input type="text" class="form-control" name="subject" required
                                            value="{{ old('subject') }}" placeholder="Enter Subject">
                                        @if ($errors->has('subject'))
                                            <p class="text-danger">{{ $errors->first('subject') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>User (Student / Parent / Teacher)</label>
                                        <select name="user_id" class="form-control select2" style="width: 100%;">
                                            <option value="">Select</option>
                                        </select>
                                        @if ($errors->has('user_id'))
                                        <p class="text-danger">{{ $errors->first('user_id') }}</p>
                                    @endif
                                    </div>

                                    <div class="form-group">
                                        <label style="display: block;">Message To</label>
                                        <label style="margin-right: 50px;">
                                            <input type="checkbox" value="3" name="message_to[]"> Student
                                        </label>
                                        <label style="margin-right: 50px;">
                                            <input type="checkbox" value="4" name="message_to[]"> Parent
                                        </label>
                                        <label>
                                            <input type="checkbox" value="2" name="message_to[]"> Teacher
                                        </label>

                                        @if ($errors->has('message_to'))
                                            <p class="text-danger">{{ $errors->first('message_to') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Message</label>
                                        <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                                            {{ old('message') }}
                                          </textarea>
                                        @if ($errors->has('message'))
                                            <p class="text-danger">{{ $errors->first('message') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Send Email</button>
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
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            $('.select2').select2({

                ajax: {
                    url: '{{ url('admin/communicate/search_user')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function(data){
                        return {
                            search: data.term,
                        };
                    },
                    processResults: function(response){
                        return {
                            results:response
                        };
                    },
                }
            });

            console.log(123);
            $('#compose-textarea').summernote({
                height: 200
            });

        });
    </script>
@endsection
