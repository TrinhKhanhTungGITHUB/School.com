@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Teacher</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/teacher/list') }}" class="btn btn-primary"> Back </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">First Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ old('name') }}" placeholder="Enter First Name">
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" required
                                                value="{{ old('last_name') }}" placeholder="Enter Last Name">
                                            @if ($errors->has('last_name'))
                                                <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
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

                                        <div class="form-group col-md-4">
                                            <label for="">Date of Birth <span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="date_of_birth" required
                                                value="{{ old('date_of_birth') }}" placeholder="Date of Birth">
                                            @if ($errors->has('date_of_birth'))
                                                <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Date of Joining <span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="admission_date" required
                                                value="{{ old('admission_date') }}">
                                            @if ($errors->has('admission_date'))
                                                <p class="text-danger">{{ $errors->first('admission_date') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Mobile Number <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="mobile_number"
                                                value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number">
                                            @if ($errors->has('mobile_number'))
                                                <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Marital Status <span style="color: red">*</span></label>
                                            <select class="form-control" name="marital_status" required>
                                                <option value="">Select status</option>
                                                <option value="Single"
                                                    {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single
                                                </option>
                                                <option value="Marry"
                                                    {{ old('marital_status') == 'Marry' ? 'selected' : '' }}>
                                                    Marry</option>
                                                <option value="Other"
                                                    {{ old('marital_status') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                                @if ($errors->has('marital_status'))
                                                    <p class="text-danger">{{ $errors->first('marital_status') }}</p>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Profile Pic <span style="color: red"></span> </label>
                                            <input type="file" class="form-control" name="profile_pic">
                                            @if ($errors->has('profile_pic'))
                                                <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
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
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Current Address <span style="color: red">*</span>
                                            </label>
                                            <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                                            @if ($errors->has('address'))
                                                <p class="text-danger">{{ $errors->first('address') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Permanent Address <span style="color: red"></span>
                                            </label>
                                            <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address') }}</textarea>
                                            @if ($errors->has('permanent_address'))
                                                <p class="text-danger">{{ $errors->first('permanent_address') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Qualification <span style="color: red"></span> </label>
                                            <textarea name="qualification" class="form-control" rows="2">{{ old('qualification') }}</textarea>
                                            @if ($errors->has('qualification'))
                                                <p class="text-danger">{{ $errors->first('qualification') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Word Experience <span style="color: red"></span>
                                            </label>
                                            <textarea name="work_experience" class="form-control" rows="2">{{ old('work_experience') }}</textarea>
                                            @if ($errors->has('work_experience'))
                                                <p class="text-danger">{{ $errors->first('work_experience') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Note <span style="color: red"></span> </label>
                                            <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                                            @if ($errors->has('note'))
                                                <p class="text-danger">{{ $errors->first('note') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Email address <span style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required placeholder="Enter email">
                                            @if ($errors->has('email'))
                                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Password <span style="color: red">*</span></label>
                                            <input type="password" class="form-control" name="password" required
                                                placeholder=" Enter Password">
                                            @if ($errors->has('password'))
                                                <p class="text-danger">{{ $errors->first('password') }}</p>
                                            @endif
                                        </div>
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
