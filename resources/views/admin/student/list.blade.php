@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            {{ $header_title }}
                            (Total : {{ $getRecord->total() }})
                        </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        @if ($header_title == 'Student List')
                            <a href="{{ url('admin/student/add') }}" class="btn btn-primary"> Add New Student</a>
                            <a href="{{ url('admin/student/trash_bin') }}" class="btn btn-warning">Trash Bin</a>
                        @else
                            <a href="{{ url('admin/student/list') }}" class="btn btn-primary"> Back</a>
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
                                <h4><span style="color: blue"><b>Settting</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Search</h5>
                                        </div>
                                        <div class="row col-md-11">
                                            <div class="form-group col-md-2">
                                                <label for="">First Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ Request::get('name') }}" placeholder="Enter Name">
                                                @if ($errors->has('name'))
                                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for=""> Last Name</label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ Request::get('last_name') }}" placeholder="Enter Last Name">
                                                @if ($errors->has('last_name'))
                                                    <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Gender <span style="color: red"></span></label>
                                                <select class="form-control" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        {{ Request::get('gender') == 'Male' ? 'selected' : '' }}>Male
                                                    </option>
                                                    <option value="Female"
                                                        {{ Request::get('gender') == 'Female' ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="Other"
                                                        {{ Request::get('gender') == 'Other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Date of Birth <span style="color: red"></span></label>
                                                <input type="date" class="form-control" name="date_of_birth"
                                                    value="{{ Request::get('date_of_birth') }}"
                                                    placeholder="Date of Birth">
                                                @if ($errors->has('date_of_birth'))
                                                    <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Class <span style="color: red"></span></label>
                                                <select class="form-control" name="class">
                                                    <option value="">Select Class</option>
                                                    @foreach ($getClass as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ Request::get('class') == $class->id ? 'selected' : '' }}>
                                                            {{ $class->name }} </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('class'))
                                                    <p class="text-danger">{{ $errors->first('class') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Admission Number</label>
                                                <input type="number" class="form-control" name="admission_number"
                                                    value="{{ Request::get('admission_number') }}"
                                                    placeholder="Enter Admission Number">
                                                @if ($errors->has('admission_number'))
                                                    <p class="text-danger">{{ $errors->first('admission_number') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Roll Number </label>
                                                <input type="number" class="form-control" name="roll_number"
                                                    value="{{ Request::get('roll_number') }}"
                                                    placeholder="Enter Roll Number">
                                                @if ($errors->has('roll_number'))
                                                    <p class="text-danger">{{ $errors->first('roll_number') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Email address</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ Request::get('email') }}" placeholder="Enter email">
                                                @if ($errors->has('email'))
                                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Mobile</label>
                                                <input type="number" class="form-control" name="mobile"
                                                    value="{{ Request::get('mobile') }}" placeholder="Enter mobile">
                                                @if ($errors->has('mobile'))
                                                    <p class="text-danger">{{ $errors->first('mobile') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Admission Date</label>
                                                <input type="date" class="form-control" name="admission_date"
                                                    value="{{ Request::get('admission_date') }}">
                                                @if ($errors->has('admission_date'))
                                                    <p class="text-danger">{{ $errors->first('admission_date') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Height</label>
                                                <input type="number" class="form-control" name="height"
                                                    value="{{ Request::get('height') }}" placeholder="Enter height">
                                                @if ($errors->has('height'))
                                                    <p class="text-danger">{{ $errors->first('height') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Weight</label>
                                                <input type="number" class="form-control" name="weight"
                                                    value="{{ Request::get('weight') }}" placeholder="Enter weight">
                                                @if ($errors->has('weight'))
                                                    <p class="text-danger">{{ $errors->first('weight') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Caste</label>
                                                <input type="text" class="form-control" name="caste"
                                                    value="{{ Request::get('caste') }}" placeholder="Enter caste">
                                                @if ($errors->has('caste'))
                                                    <p class="text-danger">{{ $errors->first('caste') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Religion</label>
                                                <input type="text" class="form-control" name="religion"
                                                    value="{{ Request::get('religion') }}" placeholder="Enter religion">
                                                @if ($errors->has('religion'))
                                                    <p class="text-danger">{{ $errors->first('religion') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Blood group</label>
                                                <input type="text" class="form-control" name="blood_group"
                                                    value="{{ Request::get('blood_group') }}"
                                                    placeholder="Enter Blood group">
                                                @if ($errors->has('blood_group'))
                                                    <p class="text-danger">{{ $errors->first('blood_group') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Created Date</label>
                                                <input type="date" class="form-control" name="created_date"
                                                    value="{{ Request::get('created_date') }}">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Status <span style="color: red"></span> </label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select Status</option>
                                                    <option value="100"
                                                        {{ Request::get('status') == '100' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="1"
                                                        {{ Request::get('status') == '1' ? 'selected' : '' }}>In Active
                                                    </option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Arrange</h5>
                                        </div>
                                        <div class="row col-md-11">
                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="name_sort">
                                                    <option value="">Select Arrange Name</option>
                                                    <option value="asc"
                                                        {{ Request::get('name_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('name_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('name_sort'))
                                                    <p class="text-danger">{{ $errors->first('name_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="last_name_sort">
                                                    <option value="">Select Arrange Last Name</option>
                                                    <option value="asc"
                                                        {{ Request::get('last_name_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('last_name_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('last_name_sort'))
                                                    <p class="text-danger">{{ $errors->first('last_name_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="date_of_birth_sort">
                                                    <option value="">Select Arrange Date Of Birth</option>
                                                    <option value="asc"
                                                        {{ Request::get('date_of_birth_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('date_of_birth_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('date_of_birth_sort'))
                                                    <p class="text-danger">{{ $errors->first('date_of_birth_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="admission_number_sort">
                                                    <option value="">Arrange Admission Number</option>
                                                    <option value="asc"
                                                        {{ Request::get('admission_number_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('admission_number_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('admission_number_sort'))
                                                    <p class="text-danger">{{ $errors->first('admission_number_sort') }}
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="email_sort">
                                                    <option value="">Select Arrange Email</option>
                                                    <option value="asc"
                                                        {{ Request::get('email_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('email_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('email_sort'))
                                                    <p class="text-danger">{{ $errors->first('email_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <select class="form-control" name="admission_date_sort">
                                                    <option value="">Arrange Admission Date</option>
                                                    <option value="asc"
                                                        {{ Request::get('admission_date_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('admission_date_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('admission_date_sort'))
                                                    <p class="text-danger">{{ $errors->first('admission_date_sort') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Paginate</h5>
                                        </div>

                                        <div class="row col-md-6">
                                            <div class="form-group col-md-6">
                                                <input type="number" class="form-control" name="paginate"
                                                    @if (!empty(Request::get('paginate'))) value="{{ Request::get('paginate') }}"
                                                 @else value="10" @endif
                                                    placeholder="Enter Number">
                                                @if ($errors->has('paginate'))
                                                    <p class="text-danger">{{ $errors->first('paginate') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-5 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                @if ($header_title == 'Student List')
                                                    <a href="{{ url('admin/student/list') }}"
                                                        class="btn btn-success">Reset</a>
                                                @else
                                                    <a href="{{ url('admin/student/trash_bin') }}"
                                                        class="btn btn-success">Reset</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        @if ($getRecord->total() > 0)
                            <div class="card">
                                <div class="card-header row">
                                    <div class="col-md-8">
                                        <h4><span style="color: blue"><b> {{ $header_title }}</b></span></h4>
                                    </div>
                                    @if ($header_title == 'Student List')
                                        <div class="col-md-4">
                                            <form action="{{ url('admin/student/export_excel') }}" method="post"
                                                style="float: right;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="name" value="{{ Request::get('name') }}">
                                                <input type="hidden" name="last_name"
                                                    value="{{ Request::get('last_name') }}">
                                                <input type="hidden" name="email"
                                                    value="{{ Request::get('email') }}">
                                                <input type="hidden" name="admission_number"
                                                    value="{{ Request::get('admission_number') }}">
                                                <input type="hidden" name="roll_number"
                                                    value="{{ Request::get('roll_number') }}">
                                                <input type="hidden" name="gender"
                                                    value="{{ Request::get('gender') }}">
                                                <input type="hidden" name="class"
                                                    value="{{ Request::get('class') }}">
                                                <input type="hidden" name="caste"
                                                    value="{{ Request::get('caste') }}">
                                                <input type="hidden" name="religion"
                                                    value="{{ Request::get('religion') }}">
                                                <input type="hidden" name="mobile"
                                                    value="{{ Request::get('mobile') }}">
                                                <input type="hidden" name="blood_group"
                                                    value="{{ Request::get('blood_group') }}">
                                                <input type="hidden" name="status"
                                                    value="{{ Request::get('status') }}">
                                                <input type="hidden" name="admission_date"
                                                    value="{{ Request::get('admission_date') }}">
                                                <input type="hidden" name="created_date"
                                                    value="{{ Request::get('created_date') }}">
                                                <button class="btn btn-primary">Export Excel</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body p-0" style="overflow: auto">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Avatar</th>
                                                <th>Name</th>
                                                <th>Parent Name</th>
                                                <th>Gender</th>
                                                <th>Date of Birth</th>
                                                <th>Class Name</th>
                                                <th>Admission Number</th>
                                                <th>Roll Number</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Admission Date</th>
                                                <th>Status</th>
                                                <th>Height</th>
                                                <th>Weight</th>
                                                <th>Caste</th>
                                                <th>Religion</th>
                                                <th>Blood Group</th>
                                                <th>Created Date</th>
                                                <th>Action </th>
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
                                                    <td style="min-width: 150px"> {{ $value->name }}
                                                        {{ $value->last_name }}
                                                    </td>
                                                    <td>{{ $value->parent_name }} {{ $value->parent_last_name }}</td>
                                                    <td> {{ $value->gender }}</td>
                                                    <td style="min-width: 100px">
                                                        {{ date('d-m-Y', strtotime($value->date_of_birth)) }}</td>
                                                    <td style="min-width: 80px"> {{ $value->class_name }}</td>
                                                    <td> {{ $value->admission_number }}</td>
                                                    <td> {{ $value->roll_number }}</td>

                                                    <td> {{ $value->email }}</td>
                                                    <td> {{ $value->mobile_number }}</td>

                                                    <td style="min-width: 100px">
                                                        {{ date('d-m-Y', strtotime($value->admission_date)) }}</td>
                                                    <td> {{ $value->status == 0 ? 'Active' : 'In Active' }}</td>
                                                    <td> {{ $value->height }}</td>

                                                    <td> {{ $value->weight }}</td>

                                                    <td> {{ $value->caste }}</td>
                                                    <td> {{ $value->religion }}</td>

                                                    <td> {{ $value->blood_group }}</td>

                                                    <td style="min-width: 180px">
                                                        {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                    <td style="min-width: 200px">
                                                        @if ($header_title == 'Student List')
                                                            <a href="{{ url('admin/student/edit/' . $value->id) }}"
                                                                class="btn btn-primary btn-sm">Edit</a>
                                                            <a href="{{ url('admin/student/show/' . $value->id) }}"
                                                                class="btn btn-warning btn-sm ">View</a>
                                                            <a href="{{ url('admin/student/delete/' . $value->id) }}"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirmDelete();">Delete
                                                            </a>
                                                        @else
                                                            <a href="{{ url('admin/student/restore/' . $value->id) }}"
                                                                class="btn btn-primary btn-sm">Restore</a>
                                                            {{-- <a href="{{ url('admin/student/remove/' . $value->id) }}"
                                                    class="btn btn-danger btn-sm" onclick="return confirmDelete();">Remove
                                                </a> --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @if ($getRecord->total() > 0)
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Avatar</th>
                                                    <th>Name</th>
                                                    <th>Parent Name</th>
                                                    <th>Gender</th>
                                                    <th>Date of Birth</th>
                                                    <th>Class Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Roll Number</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Admission Date</th>
                                                    <th>Status</th>
                                                    <th>Height</th>
                                                    <th>Weight</th>
                                                    <th>Caste</th>
                                                    <th>Religion</th>
                                                    <th>Blood Group</th>
                                                    <th>Created Date</th>
                                                    <th>Action </th>
                                                </tr>
                                            </tfoot>
                                        @endif

                                    </table>
                                    <div style="padding: 10px;" class="d-flex justify-content-center">
                                        {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
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
            return confirm('Are you sure you want to delete this account student ?');
        }
    </script>
@endsection
