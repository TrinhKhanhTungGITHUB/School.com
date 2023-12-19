@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> My Attendance <span style="color: blue"></span>
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
                                <h4><span style="color: blue"><b>Search Attendance</b> </span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="">Subject Name <span style="color: red"></span></label>
                                            <select class="form-control getSubject" name="subject_id" >
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
                                            <label for="">Start Attendance Date<span style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('start_attendance_date') }}" name="start_attendance_date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">End Attendance Date<span style="color: red"></span></label>
                                            <input type="date" class="form-control" data-time=""
                                                value="{{ Request::get('end_attendance_date') }}" name="end_attendance_date">
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

                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('student/my_attendance') }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue"><b>Attendance List</b> </span></h4>
                            </div>

                            <div class="card-body p-0" style="overflow: auto">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Subject Name</th>
                                            <th>Attendance Type</th>
                                            <th>Attendance Date</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getRecord))
                                            @forelse ($getRecord as $value)
                                                <tr>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

