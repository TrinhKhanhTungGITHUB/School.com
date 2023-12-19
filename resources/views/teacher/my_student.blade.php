@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Student List (Total : {{ $getRecord->total() }})</h1>
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
                                                <label for="">Email address</label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ Request::get('email') }}" placeholder="Enter email">
                                                @if ($errors->has('email'))
                                                    <p class="text-danger">{{ $errors->first('email') }}</p>
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
                                                <a href="{{ url('teacher/my_student') }}"
                                                    class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        @if (($getRecord->count()>0))
                            <div class="card">
                                <div class="card-header">
                                    <h4><span style="color: blue"><b> {{ $header_title }}</b></span></h4>
                                </div>
                                <div class="card-body p-0" style="overflow: auto">
                                    <table class="table table-striped" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Avatar</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Date of Birth</th>
                                                <th>Class Name</th>
                                                <th>Admission Number</th>
                                                <th>Roll Number</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Admission Date</th>
                                                <th>Height</th>
                                                <th>Weight</th>
                                                <th>Caste</th>
                                                <th>Religion</th>
                                                <th>Blood Group</th>
                                                <th>Created Date</th>
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
                                                    <td> {{ $value->height }}</td>

                                                    <td> {{ $value->weight }}</td>

                                                    <td> {{ $value->caste }}</td>
                                                    <td> {{ $value->religion }}</td>

                                                    <td> {{ $value->blood_group }}</td>

                                                    <td style="min-width: 180px">
                                                        {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @if ($getRecord->total() > 0)
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Avatar</th>
                                                    <th>Name</th>
                                                    <th>Gender</th>
                                                    <th>Date of Birth</th>
                                                    <th>Class Name</th>
                                                    <th>Admission Number</th>
                                                    <th>Roll Number</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Admission Date</th>
                                                    <th>Height</th>
                                                    <th>Weight</th>
                                                    <th>Caste</th>
                                                    <th>Religion</th>
                                                    <th>Blood Group</th>
                                                    <th>Created Date</th>
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
    </div>
    </section>
    </div>
@endsection
