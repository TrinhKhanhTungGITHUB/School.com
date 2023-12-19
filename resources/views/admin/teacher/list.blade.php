@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $header_title }}
                            (Total : {{ $getRecord->total() }})
                        </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        @if ($header_title == 'Teacher List')
                            <a href="{{ url('admin/teacher/add') }}" class="btn btn-primary"> Add New Teacher</a>
                            <a href="{{ url('admin/teacher/trash_bin') }}" class="btn btn-warning"> Trash Bin</a>
                        @else
                            <a href="{{ url('admin/teacher/list') }}" class="btn btn-primary"> Back</a>
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
                                                <label for="">Email address</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ Request::get('email') }}" placeholder="Enter email">
                                                @if ($errors->has('email'))
                                                    <p class="text-danger">{{ $errors->first('email') }}</p>
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
                                                <label for="">Mobile Number </label>
                                                <input type="number" class="form-control" name="mobile"
                                                    value="{{ Request::get('mobile') }}" placeholder="Enter mobile">
                                                @if ($errors->has('mobile'))
                                                    <p class="text-danger">{{ $errors->first('mobile') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Marital Status</label>
                                                <input type="text" class="form-control" name="marital_status"
                                                    value="{{ Request::get('marital_status') }}"
                                                    placeholder="Enter marital status">
                                                @if ($errors->has('marital_status'))
                                                    <p class="text-danger">{{ $errors->first('marital_status') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Curent address</label>
                                                <input type="text" class="form-control" name="curent_address"
                                                    value="{{ Request::get('curent_address') }}"
                                                    placeholder="Enter curent address">
                                                @if ($errors->has('curent_address'))
                                                    <p class="text-danger">{{ $errors->first('curent_address') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Date of Joining <span
                                                        style="color: red"></span></label>
                                                <input type="date" class="form-control" name="date_of_joining"
                                                    value="{{ Request::get('date_of_joining') }}">
                                                @if ($errors->has('date_of_joining'))
                                                    <p class="text-danger">{{ $errors->first('date_of_joining') }}</p>
                                                @endif
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

                                            <div class="form-group col-md-2">
                                                <label for="">Created Date</label>
                                                <input type="date" class="form-control" name="created_date"
                                                    value="{{ Request::get('created_date') }}">
                                                @if ($errors->has('created_date'))
                                                    <p class="text-danger">{{ $errors->first('created_date') }}</p>
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

                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="date_of_join_sort">
                                                    <option value="">Select Arrange Date of Joining</option>
                                                    <option value="asc"
                                                        {{ Request::get('date_of_join_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('date_of_join_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('date_of_join_sort'))
                                                    <p class="text-danger">{{ $errors->first('date_of_join_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="created_date_sort">
                                                    <option value="">Select Arrange Created Date</option>
                                                    <option value="asc"
                                                        {{ Request::get('created_date_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('created_date_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('created_date_sort'))
                                                    <p class="text-danger">{{ $errors->first('created_date_sort') }}</p>
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
                                                @if ($header_title == 'Teacher List')
                                                    <a href="{{ url('admin/teacher/list') }}"
                                                        class="btn btn-success">Reset</a>
                                                @else
                                                    <a href="{{ url('admin/teacher/trash_bin') }}"
                                                        class="btn btn-success">Reset</a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                            </form>
                        </div>
                    </div>

                    @if ($getRecord->total() > 0)
                        <div class="card">
                            <div class="card-header row">
                                <div class="col-md-8">
                                    <h4><span style="color: blue"><b> {{ $header_title }}</b></span></h4>
                                </div>
                                @if ($header_title == 'Teacher List')
                                    <div class="col-md-4">
                                        <form action="{{ url('admin/teacher/export_excel') }}" method="post"
                                            style="float: right;">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="name" value="{{ Request::get('name') }}">
                                            <input type="hidden" name="last_name"
                                                value="{{ Request::get('last_name') }}">
                                            <input type="hidden" name="email" value="{{ Request::get('email') }}">
                                            <input type="hidden" name="gender" value="{{ Request::get('gender') }}">
                                            <input type="hidden" name="class" value="{{ Request::get('class') }}">
                                            <input type="hidden" name="caste" value="{{ Request::get('caste') }}">
                                            <input type="hidden" name="mobile" value="{{ Request::get('mobile') }}">
                                            <input type="hidden" name="curent_address" value="{{ Request::get('curent_address') }}">
                                            <input type="hidden" name="date_of_joining" value="{{ Request::get('date_of_joining') }}">
                                            <input type="hidden" name="blood_group"
                                                value="{{ Request::get('blood_group') }}">
                                            <input type="hidden" name="status" value="{{ Request::get('status') }}">
                                            <input type="hidden" name="created_date"
                                                value="{{ Request::get('created_date') }}">
                                            <button class="btn btn-primary">Export Excel</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body p-0" style="overflow: auto;">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Teacher Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Date of Joining</th>
                                            <th>Mobile Number</th>
                                            <th>Marital Status</th>
                                            <th>Current Address</th>
                                            <th>Permanent Address</th>
                                            <th>Qualification</th>
                                            <th>Work Experience</th>
                                            <th>Note</th>
                                            <th>Status</th>
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
                                                <td style="min-width: 150px"> {{ $value->name }} {{ $value->last_name }}
                                                </td>
                                                <td> {{ $value->email }}</td>
                                                <td> {{ $value->gender }}</td>
                                                <td style="min-width: 100px">
                                                    @if (!empty($value->date_of_birth))
                                                        {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                                    @endif
                                                </td>

                                                <td style="min-width: 100px">
                                                    @if (!empty($value->admission_date))
                                                        {{ date('d-m-Y', strtotime($value->admission_date)) }}
                                                    @endif
                                                </td>
                                                <td> {{ $value->mobile_number }}</td>
                                                <td> {{ $value->marital_status }}</td>
                                                <td> {{ $value->address }}</td>

                                                <td> {{ $value->permanent_address }}</td>
                                                <td> {{ $value->qualification }}</td>
                                                <td> {{ $value->work_experience }}</td>
                                                <td> {{ $value->note }}</td>
                                                <td> {{ $value->status == 0 ? 'Active' : 'Inactive' }}</td>

                                                <td style="min-width: 180px">
                                                    {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                <td style="min-width: 200px">
                                                    @if ($header_title == 'Teacher List')
                                                        <a href="{{ url('admin/teacher/edit/' . $value->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="{{ url('admin/teacher/delete/' . $value->id) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirmDelete();">Delete
                                                        </a>
                                                    @else
                                                        <a href="{{ url('admin/teacher/restore/' . $value->id) }}"
                                                            class="btn btn-primary btn-sm">Restore</a>
                                                        {{-- <a href="{{ url('admin/teacher/remove/' . $value->id) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirmDelete();">Remove
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
                                                <th>Teacher Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Date of Birth</th>
                                                <th>Date of Joining</th>
                                                <th>Mobile Number</th>
                                                <th>Marital Status</th>
                                                <th>Current Address</th>
                                                <th>Permanent Address</th>
                                                <th>Qualification</th>
                                                <th>Work Experience</th>
                                                <th>Note</th>
                                                <th>Status</th>
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
            return confirm('Are you sure you want to delete this account teacher?');
        }
    </script>
@endsection
