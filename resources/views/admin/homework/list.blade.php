@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Homework </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        @if ($header_title == 'Homework')
                            <a href="{{ url('admin/homework/homework/add') }}" class="btn btn-primary"> Add New Homework </a>
                            <a href="{{ url('admin/homework/homework/trash_bin') }}" class="btn btn-warning"> Trash Bin</a>
                        @else
                        <a href="{{ url('admin/homework/homework') }}" class="btn btn-primary">Back</a>
                        @endif

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
                                @if ($header_title =="Homework")
                                    <h4><span style="color: blue"><b>Search Homework</b></span></h4>
                                @else
                                <h4><span style="color: blue"><b>Search Homework Trash bin</b></span></h4>
                                @endif
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="">Class Name<span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="class_id" id="getClass">
                                                <option value="">Select Class</option>
                                                @if (!empty($getClass))
                                                    @foreach ($getClass as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>
                                                            {{ $class->name }} </option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Subject Name <span style="color: red">*</span></label>
                                            <select class="form-control getSubject" id="getSubject" name="subject_id">
                                                <option value="">Select Subject</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option value="{{ $subject->subject_id }}"
                                                            {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                                            {{ $subject->subject_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Homework Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('from_homework_date') }}" name="from_homework_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To Homework Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('to_homework_date') }}" name="to_homework_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Submission Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('from_submission_date') }}"
                                                name="from_submission_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To submission Date<span
                                                    style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('to_submission_date') }}" name="to_submission_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">From Created Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('from_created_date') }}" name="from_created_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">To Created Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('to_created_date') }}" name="to_created_date">
                                        </div>


                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/homework/homework') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- @include('_message') --}}
                        @if ($getRecord->count() > 0)
                            <div class="card">
                                @if ($header_title == "Homework")
                                <div class="card-header">
                                    <h4><span style="color: blue"><b>Homework List</b> </span></h4>
                                </div>
                                @else
                                <div class="card-header">
                                    <h4><span style="color: blue"><b>Homework Trash Bin List</b> </span></h4>
                                </div>
                                @endif
                                <div class="card-body p-0">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Class</th>
                                                <th>Subject</th>
                                                <th>Homework Date</th>
                                                <th>Submission Date</th>
                                                <th>Document</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($getRecord as $value)
                                                <tr>
                                                    <td> {{ $value->id }}</td>
                                                    <td> {{ $value->class_name }}</td>
                                                    <td> {{ $value->subject_name }}</td>
                                                    <td> {{ date('d-m-Y', strtotime($value->homework_date)) }}</td>
                                                    <td> {{ date('d-m-Y', strtotime($value->submission_date)) }}</td>
                                                    <td>
                                                        @if (!empty($value->getDocument()))
                                                            <a href="{{ $value->getDocument() }}" class="btn btn-secondary"
                                                                download="">
                                                                Download
                                                            </a>
                                                        @else
                                                            No Document
                                                        @endif
                                                    </td>
                                                    <td> {{ $value->created_by_name }}</td>
                                                    <td> {{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                    <td>
                                                        @if ($header_title == "Homework")
                                                        <a href="{{ url('admin/homework/homework/edit/' . $value->id) }}"
                                                            class="btn btn-primary ">Edit</a>
                                                        <a href="{{ url('admin/homework/homework/delete/' . $value->id) }}"
                                                            class="btn btn-danger"
                                                            onclick="return confirmDelete();">Delete
                                                        </a>
                                                        <a href="{{ url('admin/homework/homework/submitted/' . $value->id) }}"
                                                            class="btn btn-success"> Submiitted Homework
                                                        </a>
                                                        @else
                                                        <a href="{{ url('admin/homework/homework/restore/' . $value->id) }}"
                                                            class="btn btn-primary ">Restore</a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%"> Record not found. </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div style="padding: 10px;" class="d-flex justify-content-center">
                                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                    </div>
                                </div>
                        @endif

                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this homework?');
        }
    </script>
@endsection
@section('script')
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
    </script>
@endsection
