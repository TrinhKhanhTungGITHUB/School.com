@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $header_title }}</h1>
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
                                    {{-- <h4 style="color: blue"><b>Paypal</b></h4>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Paypal Business Email</label>
                                            <input type="email" class="form-control" name="paypal_email"
                                                @if (!empty($getRecord)) value="{{ $getRecord->paypal_email }}"
                                            @else value="" @endif
                                                required placeholder="Enter Paypal Business Email">
                                            @if ($errors->has('email'))
                                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr> --}}
                                    <h4 style="color: blue"><b>Stripe</b></h4>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Stripe Public Key</label>
                                            <input type="text" class="form-control" name="stripe_key"
                                                value=" {{ $getRecord->stripe_key }}">
                                            @if ($errors->has('stripe_key'))
                                                <p class="text-danger">{{ $errors->first('stripe_key') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Stripe Secret Key</label>
                                            <input type="text" class="form-control" name="stripe_secret"
                                                value=" {{ $getRecord->stripe_secret }}">
                                            @if ($errors->has('stripe_secret'))
                                                <p class="text-danger">{{ $errors->first('stripe_secret') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 style="color: blue"><b>Image</b></h4>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Favicon Icon</label>
                                            <div>
                                                @if (!empty($getRecord->getFavicon()))
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img src=" {{ $getRecord->getFavicon() }}"
                                                            style="width: auto; height:100px;">
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img src="{{ asset(env('UPLOAD_PATH') . '/profile/' . 'no_avatar.jpg') }}"
                                                            alt="Profile Pic" style="width: auto; height: 100px;">
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="">Update Favicon Icon</label>
                                            <input type="file" class="form-control" name="favicon_icon">
                                            @if ($errors->has('favicon_icon'))
                                                <p class="text-danger">{{ $errors->first('favicon_icon') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Logo</label>
                                            <div>
                                                @if (!empty($getRecord->getLogo()))
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img src=" {{ $getRecord->getLogo() }}"
                                                            style="width: auto; height:100px;">
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <img src="{{ asset(env('UPLOAD_PATH') . '/profile/' . 'no_avatar.jpg') }}"
                                                            alt="Profile Pic" style="width: auto; height: 100px;">
                                                    </div>
                                                @endif
                                            </div>
                                            <label for=""> Update Logo</label>
                                            <input type="file" class="form-control" name="logo">
                                            @if ($errors->has('logo'))
                                                <p class="text-danger">{{ $errors->first('logo') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="form-group">
                                        <label for="">School Name</label>
                                        <input type="text" class="form-control" name="school_name"
                                            value=" {{ $getRecord->school_name }}">
                                        @if ($errors->has('school_name'))
                                            <p class="text-danger">{{ $errors->first('school_name') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Exam description</label>
                                        <textarea class="form-control" name="exam_description" id="">
                                        {{ $getRecord->exam_description }}
                                    </textarea>
                                        @if ($errors->has('exam_description'))
                                            <p class="text-danger">{{ $errors->first('exam_description') }}</p>
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
