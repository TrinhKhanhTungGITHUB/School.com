@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> My Account</h1>
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
                            <form action="" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Profile Pic  <span style="color: red"></span> </label>
                                            @if($getRecord->profile_pic)

                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="{{ asset(env('UPLOAD_PATH').'/profile/parent/'. $getRecord->profile_pic) }}" alt="Profile Pic" width="300" height="300" >
                                            </div>
                                            @else
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img src="{{ asset(env('UPLOAD_PATH').'/profile/'. 'no_avatar.jpg') }}" alt="Profile Pic" width="300" height="300" >
                                                </div>
                                            @endif
                                            <label for="">Update Avatar</label>
                                            <input type="file" class="form-control" name="profile_pic">
                                            @if ($errors->has('profile_pic'))
                                                <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">First Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ $getRecord->name }}" placeholder="Enter First Name">
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" required
                                                value="{{ $getRecord->last_name }}" placeholder="Enter Last Name">
                                            @if ($errors->has('last_name'))
                                                <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Gender <span style="color: red">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ $getRecord->gender == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="Female" {{ $getRecord->gender == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Other" {{ $getRecord->gender == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                                @if ($errors->has('gender'))
                                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Occupation<span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="occupation"
                                                value="{{ $getRecord->occupation }}" placeholder="Enter Occupation">
                                            @if ($errors->has('occupation'))
                                                <p class="text-danger">{{ $errors->first('occupation') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="">Mobile Number  <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="mobile_number"
                                                value="{{ $getRecord->mobile_number }}" placeholder="Enter Mobile Number">
                                            @if ($errors->has('mobile_number'))
                                                <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Address<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="address" required
                                                value="{{ $getRecord->address }}" placeholder="Enter address">
                                            @if ($errors->has('address'))
                                                <p class="text-danger">{{ $errors->first('address') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Email address <span style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $getRecord->email }}" required placeholder="Enter email">
                                            @if ($errors->has('email'))
                                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
