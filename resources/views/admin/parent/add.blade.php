@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Parent</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/parent/list') }}" class="btn btn-primary"> Back </a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form action="" method="POST" enctype='multipart/form-data' >
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
                                            <label for="">Occupation  <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="occupation"
                                                value="{{ old('occupation') }}" placeholder="Enter Occupation">
                                            @if ($errors->has('occupation'))
                                                <p class="text-danger">{{ $errors->first('occupation') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Address  <span style="color: red">*</span> </label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ old('address') }}" placeholder="Enter Address">
                                            @if ($errors->has('address'))
                                                <p class="text-danger">{{ $errors->first('address') }}</p>
                                            @endif
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="">Mobile Number  <span style="color: red">*</span> </label>
                                            <input type="text" class="form-control" name="mobile_number" required
                                                value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number">
                                            @if ($errors->has('mobile_number'))
                                                <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Profile Pic  <span style="color: red"></span> </label>
                                            <input type="file" class="form-control" name="profile_pic">
                                            @if ($errors->has('profile_pic'))
                                                <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Status <span style="color: red">*</span> </label>
                                            <select class="form-control" name="status" id="" required>
                                                <option value="">Select Status</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>In Active</option>
                                            </select>
                                        </div>

                                    </div>

                                    <hr/>


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
                                <!-- /.card-body -->

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Submit</button>
                                </div>
                            </form>
                        </div>


                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
