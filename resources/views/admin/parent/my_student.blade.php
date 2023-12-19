@extends('layouts.app')

@section('content')



    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $header_title }} ({{ $getParent->name }} {{ $getParent->last_name }}) </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/parent/list') }}" class="btn btn-primary"> Back</a>
                        <a href="{{ url('admin/parent/trash_bin') }}" class="btn btn-warning"> Trash Bin</a>
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
                                <h4><span style="color: blue">Search Student</span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-md-2">
                                            <label for="">Student ID</label>
                                            <input type="text" class="form-control" name="id"
                                                value="{{ Request::get('id') }}" placeholder="Enter ID">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">First Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ Request::get('name') }}" placeholder="Enter Name">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                value="{{ Request::get('last_name') }}" placeholder="Enter Last Name">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="">Email address</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ Request::get('email') }}" placeholder="Enter email">
                                        </div>

                                        <div class="form-group col-md-2 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1"> <a href="{{ url('admin/parent/my-student/' . $parent_id) }}"
                                                    class="btn btn-success">Reset</a> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!empty($getSearchStudent))
                            <div class="card">
                                <div class="card-header">
                                    <h4><span style="color: blue">Student List </span></h4>
                                </div>
                                <div class="card-body p-0 ">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile Pic</th>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>Parent Name</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getSearchStudent as $value)
                                                <tr>
                                                    <td> {{ $value->id }}</td>
                                                    <td>
                                                        @if (!empty($value->getProfile()))
                                                            <img src="{{ $value->getProfile() }}"
                                                                style="height: 50px; width: 50px; border-radius: 50px;"
                                                                alt="Avatar {{ $value->id }}">
                                                        @else
                                                            <img src=" {{ asset(env('UPLOAD_PATH') . '/profile/' . 'no_avatar.jpg') }}"
                                                                style="height: 50px; width: 50px; border-radius: 50px;"
                                                                alt="Avatar {{ $value->id }}">
                                                        @endif
                                                    </td>
                                                    <td style="min-width: 150px"> {{ $value->name }}
                                                        {{ $value->last_name }}</td>
                                                    <td> {{ $value->email }}</td>
                                                    <td> {{ $value->parent_name }} </td>
                                                    <td style="min-width: 180 px">
                                                        {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                    <td style="min-width: 200 px">
                                                        @if (!empty($value->parent_name))
                                                            <a href="{{ url('admin/parent/assign_student_parent/' . $value->id . '/' . $parent_id) }}"
                                                                class="btn btn-primary btn-sm  "
                                                                onclick="return confirmAdd();">Add Student to Parent</a>
                                                        @else
                                                            <a href="{{ url('admin/parent/assign_student_parent/' . $value->id . '/' . $parent_id) }}"
                                                                class="btn btn-primary btn-sm ">Add Student to Parent</a>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div style="padding: 10px;" class="d-flex justify-content-center" id="pagination">
                                        {!! $getSearchStudent->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (($getRecord->count()) >0)
                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue">Parent Student List </span></h4>
                            </div>
                            <div class="card-body p-0 ">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Profile Pic</th>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Parent Name</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td>
                                                    @if (!empty($value->getProfile()))
                                                        <img src="{{ $value->getProfile() }}"
                                                            style="height: 50px; width: 50px; border-radius: 50px;"
                                                            alt="Avatar {{ $value->id }}">
                                                    @else
                                                        <img src=" {{ asset(env('UPLOAD_PATH') . '/profile/' . 'no_avatar.jpg') }}"
                                                            style="height: 50px; width: 50px; border-radius: 50px;"
                                                            alt="Avatar {{ $value->id }}">
                                                    @endif
                                                </td>
                                                <td style="min-width: 150px"> {{ $value->name }} {{ $value->last_name }}
                                                </td>
                                                <td> {{ $value->email }}</td>
                                                <td> {{ $value->parent_name }} </td>
                                                <td style="min-width: 180 px">
                                                    {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                <td style="min-width: 200 px">
                                                    <a href="{{ url('admin/parent/assign_student_parent_delete/' . $value->id) }}"
                                                        class="btn btn-danger btn-sm "
                                                        onclick="return confirmDelete();">Delete Student to Parent</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this student?');
        }
    </script>
    <script>
        function confirmAdd() {
            return confirm('Warning!. This student already has a parent. Continue ?');
        }
    </script>
@endsection
