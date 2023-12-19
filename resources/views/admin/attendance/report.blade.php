@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Attendance Report
                            <span style="color: blue">
                                @if (!empty($getRecord))
                                    (Total: {{ $getRecord->total() }} )
                                @endif
                            </span>
                        </h1>
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
                                <h4><span style="color: blue"><b>Search Attendance Report</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Class Name<span style="color: red">*</span></label>
                                            <select class="form-control getClass" name="class_id" id="getClass" required>
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

                                        <div class="form-group col-md-3">
                                            <label for="">Subject Name <span style="color: red">*</span></label>
                                            <select class="form-control getSubject" name="subject_id" required>
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

                                        <div class="form-group col-md-3">
                                            <label for="">Start Attendance Date<span
                                                    style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('start_attendance_date') }}"
                                                name="start_attendance_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">End Attendance Date<span
                                                    style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('end_attendance_date') }}"
                                                name="end_attendance_date">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Student ID<span style="color: red"></span></label>
                                            <input type="number" class="form-control" name="student_id"
                                                placeholder="Enter Student ID" value="{{ Request::get('student_id') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Student Name<span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="student_name"
                                                placeholder="Enter Student Name"
                                                value="{{ Request::get('student_name') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Student Last Name<span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="student_last_name"
                                                placeholder="Enter Student Last Name"
                                                value="{{ Request::get('student_last_name') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Attendance Type<span style="color: red"></span></label>
                                            <select class="form-control getType" name="attendance_type">
                                                <option value="">Select Type</option>
                                                <option {{ Request::get('attendance_type') == 1 ? 'selected' : '' }}
                                                    value="1">Present</option>
                                                <option {{ Request::get('attendance_type') == 2 ? 'selected' : '' }}
                                                    value="2">Late</option>
                                                <option {{ Request::get('attendance_type') == 3 ? 'selected' : '' }}
                                                    value="3">Absent</option>
                                                <option {{ Request::get('attendance_type') == 4 ? 'selected' : '' }}
                                                    value="4">Half Day</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group d-flex align-items-end justify-content-center">
                                        <button class="btn btn-primary" type="submit">Search </button>
                                        <div class="ml-1"> <a href="{{ url('admin/attendance/report') }}"
                                                class="btn btn-success">Reset</a> </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!empty($getRecord))
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title"><span
                                            style="color: blue; font-size: 24px; font-weight: bold;">Attendance List</span>
                                    </h2>
                                    <form method="POST" action="{{ url('admin/attendance/report_export_excel') }}"
                                        style="float: right;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="student_id" value="{{ Request::get('student_id') }}">
                                        <input type="hidden" name="student_name"
                                            value="{{ Request::get('student_name') }}">
                                        <input type="hidden" name="student_last_name"
                                            value="{{ Request::get('student_last_name') }}">
                                        <input type="hidden" name="subject_id"
                                            value="{{ Request::get('subject_id') }}">
                                        <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                                        <input type="hidden" name="start_attendance_date"
                                            value="{{ Request::get('start_attendance_date') }}">
                                        <input type="hidden" name="end_attendance_date"
                                            value="{{ Request::get('end_attendance_date') }}">
                                        <input type="hidden" name="attendance_type"
                                            value="{{ Request::get('attendance_type') }}">

                                        <button class="btn btn-primary">Export Excel</button>
                                    </form>
                                </div>

                                <div class="card-body p-0" style="overflow: auto">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Student Name</th>
                                                <th>Class Name</th>
                                                <th>Subject Name</th>
                                                <th>Attendance Type</th>
                                                <th>Attendance Date</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($getRecord))
                                                @forelse ($getRecord as $value)
                                                    <tr>
                                                        <td> {{ $value->student_id }}</td>
                                                        <td> {{ $value->student_name }} {{ $value->student_last_name }}
                                                        </td>
                                                        <td> {{ $value->class_name }}</td>
                                                        <td> {{ $value->subject_name }}</td>
                                                        <td>
                                                            @if ($value->attendance_type == 1)
                                                                Present
                                                            @elseif ($value->attendance_type == 2)
                                                                Late
                                                            @elseif ($value->attendance_type == 3)
                                                                Absent
                                                            @elseif ($value->attendance_type == 4)
                                                                Half Day
                                                            @endif
                                                        </td>
                                                        <td> {{ date('d-m-Y', strtotime($value->attendance_date)) }}</td>
                                                        <td> {{ $value->created_name }}</td>
                                                        <td> {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%">Record not found</td>
                                                    </tr>
                                                @endforelse
                                            @else
                                                <tr>
                                                    <td colspan="100%">Record not found</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                    @if (!empty($getRecord))
                                        <div style="padding: 10px;" class="d-flex justify-content-center">
                                            {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                        </div>
                                    @endif
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
        var inputClassName = document.querySelector('.getClass');
        var inputSubjectName = document.querySelector('.getSubject');
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
