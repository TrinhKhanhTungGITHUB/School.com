{{-- @extends('layouts.app')

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
                            <form action="" method="POST">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $getRecord->name }}" required placeholder="Enter Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $getRecord->email }}" required
                                            placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
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
@endsection --}}

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
                            <form action="" method="POST"  enctype='multipart/form-data'>
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Profile Pic  <span style="color: red"></span> </label>
                                            @if($getRecord->profile_pic)

                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="{{ asset(env('UPLOAD_PATH').'/profile/admin/'. $getRecord->profile_pic) }}" alt="Profile Pic" width="300" height="300" >
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

                                    <div class="form-group">
                                        <label for="">Name<span style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $getRecord->name }}" required placeholder="Enter Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email address<span style="color: red">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $getRecord->email }}" required
                                            placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                    <button type="submit" class="btn btn-primary mx-2">Update</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
