@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Class & Subject </h1>
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
                                <h4><span style="color: blue"><b>Settting</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Search</h5>
                                        </div>
                                        <div class="row col-md-4">
                                            <div class="form-group col-md-6">
                                                <label for="">Class Name <span style="color: red"></span></label>
                                                <select class="form-control getClass" name="class_id">
                                                    <option value="">Select Class</option>
                                                    @if (!empty($getClass))
                                                        @foreach ($getClass as $class)
                                                            <option value="{{ $class->class_id }}"
                                                                {{ Request::get('class_id') == $class->class_id ? 'selected' : '' }}>
                                                                {{ $class->class_name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('class'))
                                                    <p class="text-danger">{{ $errors->first('class') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Subject Name<span style="color: red"></span></label>
                                                <select class="form-control getSubject" name="subject_id"> >
                                                    <option value="">Select Subject</option>
                                                    @if (!empty($getSubject))
                                                        @foreach ($getSubject as $subject)
                                                            <option value="{{ $subject->subject_id }}"
                                                                {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                                                                {{ $subject->subject_name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('class'))
                                                    <p class="text-danger">{{ $errors->first('class') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Paginate</h5>
                                        </div>

                                        <div class="row col-md-2">
                                            <div class="form-group col-md-6">
                                                <label for="">Paginate <span style="color: red"></span></label>
                                                <input type="number" class="form-control" name="paginate"
                                                    @if (!empty(Request::get('paginate'))) value="{{ Request::get('paginate') }}"
                                             @else value="10" @endif
                                                    placeholder="Enter Number">
                                                @if ($errors->has('paginate'))
                                                    <p class="text-danger">{{ $errors->first('paginate') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                <a href="{{ url('teacher/my_class_subject') }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        @if (!empty($getRecord))
                            <div class="card">
                                <div class="card-header">
                                    <h4><span style="color: blue"><b> {{ $header_title }}</b></span></h4>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Class Name</th>
                                                <th>Subject Name </th>
                                                <th>Subject Type </th>
                                                <th>My Class Timetable</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $stt = 0;
                                            @endphp
                                            @foreach ($getRecord as $value)
                                                @php
                                                    $stt += 1;
                                                @endphp
                                                <tr>
                                                    {{-- <td> {{ $value->class_id }}</td> --}}
                                                    <td> {{ $stt }}</td>
                                                    <td> {{ $value->class_name }}</td>
                                                    <td> {{ $value->subject_name }}</td>
                                                    <td> {{ $value->subject_type }}</td>
                                                    <td>
                                                        @php
                                                            $classSubject = $value->getMyTimeTable($value->class_id, $value->subject_id);
                                                        @endphp
                                                        @if (!empty($classSubject))
                                                            {{ date('h:i A', strtotime($classSubject->start_time)) }} to
                                                            {{ date('h:i A', strtotime($classSubject->end_time)) }}
                                                            <br />
                                                            Room number: {{ $classSubject->room_number }}
                                                        @endif

                                                    </td>
                                                    <td> {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>

                                                    <td>
                                                        <a href="{{ url('teacher/my_class_subject/class_timetable/' . $value->class_id . '/' . $value->subject_id) }}"
                                                            class="btn btn-primary">
                                                            My Class Timetable
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        @if ($getRecord->total() > 0)
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Class Name</th>
                                                    <th>Subject Name </th>
                                                    <th>Subject Type </th>
                                                    <th>My Class Timetable</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                    <div style="padding: 10px;" class="d-flex justify-content-center">
                                        @if (!empty($getRecord))
                                            {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.getClass').change(function() {
            var class_id = $(this).val();
            $.ajax({
                url: " {{ url('teacher/class_timetable/get_subject') }}",
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
