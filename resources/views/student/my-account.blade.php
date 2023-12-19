@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Account</h1>
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
                                        <div class="form-group col-md-12">
                                            <label for="">Profile Pic  <span style="color: red"></span> </label>
                                            @if($getRecord->profile_pic)

                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="{{ asset(env('UPLOAD_PATH').'/profile/student/'. $getRecord->profile_pic) }}" alt="Profile Pic" width="300" height="300" >
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
                                        <div class="form-group col-md-4">
                                            <label for="">First Name <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ $getRecord->name }}" placeholder="Enter First Name">
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Last Name<span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="last_name" required
                                                value="{{ $getRecord->last_name }}" placeholder="Enter Last Name">
                                            @if ($errors->has('last_name'))
                                                <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Date of Birth <span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="date_of_birth" required
                                                value="{{ $getRecord->date_of_birth }}" placeholder="Date of Birth">
                                            @if ($errors->has('date_of_birth'))
                                                <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
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

                                        <div class="form-group col-md-4">
                                            <label for="">Height (cm)  <span style="color: red"></span> </label>
                                            <input type="number" class="form-control" name="height"
                                                value="{{ $getRecord->height }}" placeholder="Enter Height">
                                            @if ($errors->has('height'))
                                                <p class="text-danger">{{ $errors->first('height') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Weight (kg)  <span style="color: red"></span> </label>
                                            <input type="number" class="form-control" name="weight"
                                                value="{{ $getRecord->weight }}" placeholder="Enter Weight">
                                            @if ($errors->has('weight'))
                                                <p class="text-danger">{{ $errors->first('weight') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Caste <span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="caste"
                                                value="{{ $getRecord->caste }}" placeholder="Enter Caste">
                                            @if ($errors->has('caste'))
                                                <p class="text-danger">{{ $errors->first('caste') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Religion <span style="color: red"></span></label>
                                            <input type="text" class="form-control" name="religion"
                                                value="{{ $getRecord->religion }}" placeholder="Enter Religion">
                                            @if ($errors->has('religion'))
                                                <p class="text-danger">{{ $errors->first('religion') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Blood Group  <span style="color: red"></span> </label>
                                            <input type="text" class="form-control" name="blood_group"
                                                value="{{ $getRecord->blood_group }}" placeholder="Enter Blood Group">
                                            @if ($errors->has('blood_group'))
                                                <p class="text-danger">{{ $errors->first('blood_group') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Email address <span style="color: red">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $getRecord->email }}" required placeholder="Enter email">
                                            @if ($errors->has('email'))
                                                <p class="text-danger">{{ $errors->first('email') }}</p>
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
                                    </div>

                                </div>


                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
