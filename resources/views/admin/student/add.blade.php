@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Student</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/student/list') }}" class="btn btn-primary"> Back </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="POST" enctype='multipart/form-data'>
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">First Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ old('name') }}" placeholder="Enter First Name">
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" required
                                                value="{{ old('last_name') }}" placeholder="Enter Last Name">
                                            @if ($errors->has('last_name'))
                                                <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Admission Number<span style="color: red">*</span></label>
                                            <input type="number" class="form-control" name="admission_number" required
                                                value="{{ old('admission_number') }}" placeholder="Enter Admission Number">
                                            @if ($errors->has('admission_number'))
                                                <p class="text-danger">{{ $errors->first('admission_number') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Roll Number<span style="color: red"></span></label>
                                            <input type="number" class="form-control" name="roll_number"
                                                value="{{ old('roll_number') }}" placeholder="Enter Roll Number">
                                            @if ($errors->has('roll_number'))
                                                <p class="text-danger">{{ $errors->first('roll_number') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Class <span style="color: red">*</span></label>
                                            <select class="form-control" name="class_id" required>
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }} </option>
                                                @endforeach
                                                @if ($errors->has('class_id'))
                                                    <p class="text-danger">{{ $errors->first('class_id') }}</p>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Gender <span style="color: red">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                                @if ($errors->has('gender'))
                                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Date of Birth <span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="date_of_birth" required
                                                value="{{ old('date_of_birth') }}" placeholder="Date of Birth">
                                            @if ($errors->has('date_of_birth'))
                                                <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Caste <span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="caste"
                                                value="{{ old('caste') }}" placeholder="Enter Caste">
                                            @if ($errors->has('caste'))
                                                <p class="text-danger">{{ $errors->first('caste') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Religion <span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="religion"
                                                value="{{ old('religion') }}" placeholder="Enter Religion">
                                            @if ($errors->has('religion'))
                                                <p class="text-danger">{{ $errors->first('religion') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Mobile Number <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="mobile_number"
                                                value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number">
                                            @if ($errors->has('mobile_number'))
                                                <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Admission Date <span style="color: red">*</span>
                                            </label>
                                            <input type="date" class="form-control" name="admission_date"
                                                value="{{ old('admission_date') }}" placeholder="Enter Admission Date">
                                            @if ($errors->has('admission_date'))
                                                <p class="text-danger">{{ $errors->first('admission_date') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Profile Pic <span style="color: red"></span> </label>
                                            <input type="file" class="form-control" name="profile_pic">
                                            @if ($errors->has('profile_pic'))
                                                <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Blood Group <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="blood_group"
                                                value="{{ old('blood_group') }}" placeholder="Enter Blood Group">
                                            @if ($errors->has('blood_group'))
                                                <p class="text-danger">{{ $errors->first('blood_group') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Height (cm) <span style="color: red"></span> </label>
                                            <input type="number" class="form-control" name="height"
                                                value="{{ old('height') }}" placeholder="Enter Height">
                                            @if ($errors->has('height'))
                                                <p class="text-danger">{{ $errors->first('height') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Weight (kg) <span style="color: red"></span> </label>
                                            <input type="number" class="form-control" name="weight"
                                                value="{{ old('weight') }}" placeholder="Enter Weight">
                                            @if ($errors->has('weight'))
                                                <p class="text-danger">{{ $errors->first('weight') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Status <span style="color: red">*</span> </label>
                                            <select class="form-control" name="status" id="" required>
                                                <option value="">Select Status</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>In
                                                    Active</option>
                                            </select>
                                        </div>

                                    </div>
                                    <hr />

                                    <div class="form-group">
                                        <label for="">Email address <span style="color: red">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" required placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password <span style="color: red">*</span></label>
                                        <input type="password" class="form-control" name="password" required
                                            placeholder=" Enter Password">
                                        @if ($errors->has('password'))
                                            <p class="text-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
