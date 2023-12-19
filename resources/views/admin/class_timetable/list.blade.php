@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> {{ $header_title }}</h1>
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
                                <h4><span style="color: blue"><b>Search Class Timetable</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label for="">Class Name<span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="class_id"
                                             required
                                             >
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Subject Name <span style="color: red">*</span></label>
                                            <select class="form-control getSubject" name="subject_id"

                                             >
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

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/class_timetable/list') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!empty(Request::get('class_id')) && !empty(Request::get('subject_id')) && !empty($week))
                            <form action="{{ url('admin/class_timetable/add') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-header">
                                        <h4><span style="color: blue"><b>Class Timetable  </b></span>
                                            @if (!empty($getClassSubject))
                                              -  {{$getClassSubject->class_name}} - {{$getClassSubject->subject_name}}
                                            @endif
                                   </h4>
                                    </div>

                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                                            <input type="hidden" name="subject_id"
                                                value="{{ Request::get('subject_id') }}">
                                            <thead>
                                                <tr>
                                                    <th>Week</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Room Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($week as $value)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden"
                                                                name="timetable[{{ $i }}][week_id]"
                                                                value="{{ $value['week_id'] }}">
                                                            {{ $value['week_name'] }}
                                                        </td>
                                                        <td>
                                                            <input type="time"
                                                                name="timetable[{{ $i }}][start_time]"
                                                                class="form-control" value="{{ $value['start_time'] }}">
                                                        </td>
                                                        <td>
                                                            <input type="time"
                                                                name="timetable[{{ $i }}][end_time]"
                                                                class="form-control" value="{{ $value['end_time'] }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" style="width: 200px"
                                                                name="timetable[{{ $i }}][room_number]"
                                                                value="{{ $value['room_number'] }}" class="form-control">
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="card-footer d-flex justify-content-center">
                                            <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
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
