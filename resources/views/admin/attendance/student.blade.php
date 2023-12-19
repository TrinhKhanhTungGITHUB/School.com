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
                                <h4><span style="color: blue"><b>Search Student Attendance</b></span></h4>
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
                                                        <option value="{{ $class->id }}" {{-- {{ Request::get('class_id') == $class->id ? 'selected' : '' }} --}}>
                                                            {{ $class->name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Subject Name <span style="color: red">*</span></label>
                                            <select class="form-control getSubject" id="getSubject" name="subject_id"
                                                required>
                                                <option value="">Select Subject</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option value="{{ $subject->subject_id }}" {{-- {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }} --}}>
                                                            {{ $subject->subject_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Attendance Date<span style="color: red">*</span></label>
                                            <input type="date" class="form-control getAttendanceDate" data-time=""
                                                {{-- value="{{ Request::get('attendance_date') }}" --}} required name="attendance_date">
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/attendance/student') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')) && !empty(Request::get('subject_id')))
                            <div class="card">
                                <div class="card-header">
                                    <h4><span style="color: blue"><b>Student List</b></span></h4>
                                </div>

                                <div class="card-body p-0" style="overflow: auto">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Student Name</th>
                                                <th>Class Name</th>
                                                <th>Subject Name</th>
                                                <th>Attendance Date</th>
                                                <th>Attendance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($getStudent) && !empty($getStudent->count()))
                                                @foreach ($getStudent as $value)
                                                    @php
                                                        $attendance_type = '';
                                                        $getAttendance = $value->getAttendance($value->id, Request::get('class_id'), Request::get('attendance_date'), Request::get('subject_id'));

                                                        if (!empty($getAttendance)) {
                                                            $attendance_type = $getAttendance->attendance_type;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ $value->name }} {{ $value->last_name }}</td>
                                                        <td>{{ $value->class_name }}</td>
                                                        <td>{{ $value->subject_name }}</td>
                                                        <td>{{ Request::get('attendance_date') }}</td>
                                                        <td>
                                                            <label style="margin-right: 10px;" for="">
                                                                <input type="radio"
                                                                    {{ $attendance_type == '1' ? 'checked' : '' }}
                                                                    id="{{ $value->id }}" class="SaveAttendance"
                                                                    name="attendance{{ $value->id }}" value="1"
                                                                    data-class_id="{{ Request::get('class_id') }}"
                                                                    data-subject_id="{{ Request::get('subject_id') }}"
                                                                    data-attendance_date="{{ Request::get('attendance_date') }}">Present
                                                            </label>
                                                            <label style="margin-right: 10px;" for="">
                                                                <input type="radio"
                                                                    {{ $attendance_type == '2' ? 'checked' : '' }}
                                                                    id="{{ $value->id }}" class="SaveAttendance"
                                                                    name="attendance{{ $value->id }}" value="2"
                                                                    data-class_id="{{ Request::get('class_id') }}"
                                                                    data-subject_id="{{ Request::get('subject_id') }}"
                                                                    data-attendance_date="{{ Request::get('attendance_date') }}">Late
                                                            </label>
                                                            <label style="margin-right: 10px;" for="">
                                                                <input type="radio"
                                                                    {{ $attendance_type == '3' ? 'checked' : '' }}
                                                                    id="{{ $value->id }}" class="SaveAttendance"
                                                                    name="attendance{{ $value->id }}" value="3"
                                                                    data-class_id="{{ Request::get('class_id') }}"
                                                                    data-subject_id="{{ Request::get('subject_id') }}"
                                                                    data-attendance_date="{{ Request::get('attendance_date') }}">Absent
                                                            </label>
                                                            <label style="margin-right: 10px;" for="">
                                                                <input type="radio"
                                                                    {{ $attendance_type == '4' ? 'checked' : '' }}
                                                                    id="{{ $value->id }}" class="SaveAttendance"
                                                                    name="attendance{{ $value->id }}" value="4"
                                                                    data-class_id="{{ Request::get('class_id') }}"
                                                                    data-subject_id="{{ Request::get('subject_id') }}"
                                                                    data-attendance_date="{{ Request::get('attendance_date') }}">Haft
                                                                Day
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div style="padding: 10px;" class="d-flex justify-content-center" id="pagination">
                                        {!! $getStudent->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
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
        var inputAttendanceDate = document.querySelector('.getAttendanceDate');
        var inputClassName = document.querySelector('.getClass');
        var inputSubjectName = document.querySelector('.getSubject');
        $('.getClass').change(function() {
            var class_id = $(this).val();
            inputAttendanceDate.value = "";
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

        $('.getSubject').change(function() {
            var subject_id = $(this).val();
            var class_id = $('.getClass').val();

            inputAttendanceDate.value = "";
            $.ajax({
                url: " {{ url('admin/attendance/attendance_date') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_id,
                    subject_id: subject_id,
                },
                dataType: "json",
                success: function(response) {
                    if (response.message == 1)
                        inputAttendanceDate.setAttribute('data-time', JSON.stringify(response.data));
                    else {
                        toastr.warning(
                            'There is no timetable for this subject for that class. Please select again',
                            'Message');
                        // inputClassName.value = "";
                        inputSubjectName.value = "";
                    }
                },
            });
        });

        $('.getAttendanceDate').change(function() {
            var class_id = $('.getClass').val();
            var subject_id = $('.getSubject').val();
            var attendance_date = $(this).val();
            var dataTime = $(this).attr('data-time');

            console.log(class_id, subject_id, attendance_date, dataTime);
            $.ajax({
                url: " {{ url('admin/attendance/attendance_date_submit') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_id,
                    subject_id: subject_id,
                    attendance_date: attendance_date,
                    dataTime: dataTime,
                },
                dataType: "json",
                success: function(response) {
                    if (response.message == 1)
                    {
                        toastr.warning('That day there was no such subject. Please select again',
                            'Message');
                    }
                    else if(response.message == 2)
                    {
                        toastr.warning('The date you selected is greater than the current date. Please select again',
                            'Message');
                    }
                    document.querySelector('.getAttendanceDate').value = "";
                },

            });
        });

        $('.SaveAttendance').change(function(e) {
            var student_id = $(this).attr('id');
            var attendance_type = $(this).val();
            var class_id = $(this).attr('data-class_id');
            var subject_id = $(this).attr('data-subject_id');
            var attendance_date = $(this).attr('data-attendance_date');

            console.log(student_id, attendance_type, class_id, subject_id, attendance_date);

            $.ajax({
                type: "POST",
                url: "{{ url('admin/attendance/student/save') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    student_id: student_id,
                    attendance_type: attendance_type,
                    class_id: class_id,
                    subject_id: subject_id,
                    attendance_date: attendance_date,
                },
                dataType: "json",
                success: function(data) {
                    toastr.warning(data.message, 'Message');
                }
            });
        });
    </script>
@endsection
