@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>View Student</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href=" {{ url('admin/student/edit/'. $id)}}" class="btn btn-warning"> Update </a>
                        <a href=" {{ url('admin/student/list')}}" class="btn btn-primary"> Back </a>
                    </div

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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-12 text-center">
                                            <label for="">Profile Pic</label>
                                            @if($getRecord->profile_pic)
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="{{ asset(env('UPLOAD_PATH').'/profile/student/'. $getRecord->profile_pic) }}" alt="Profile Pic" width="300" height="300" >
                                            </div>
                                            @else
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img src="{{ asset(env('UPLOAD_PATH').'/profile/'. 'no_avatar.jpg') }}" alt="Profile Pic" width="300" height="300" >
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">First Name <span style="color: red"></span></label>
                                        <input type="text" readonly class="form-control" name="name" required
                                            value="{{ $getRecord->name }}" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Last Name<span style="color: red"></span></label>
                                        <input type="text" readonly class="form-control" name="last_name" required
                                            value="{{ $getRecord->last_name}}" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Date of Birth <span style="color: red"></span></label>
                                        <input type="date" readonly class="form-control" name="date_of_birth" required
                                            value="{{$getRecord->date_of_birth}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Gender <span style="color: red"></span></label>
                                        <input type="text" readonly class="form-control" name="gender" required
                                        value="{{ $getRecord->gender}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Height (cm)  <span style="color: red"></span> </label>
                                        <input type="number" readonly class="form-control" name="height"
                                            value="{{ $getRecord->height}}" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Weight (kg)  <span style="color: red"></span> </label>
                                        <input type="number" readonly class="form-control" name="weight"
                                            value="{{ $getRecord->weight}}" >
                                    </div>
                                </div>
                                <hr>
                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label for="">Class <span style="color: red"></span></label>
                                        <input type="text" readonly value="{{$getRecord->getClassSingle($getRecord->class_id)->name}}" class="form-control" name="class_id" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Admission Number<span style="color: red">*</span></label>
                                        <input type="number" readonly class="form-control" name="admission_number" required
                                            value="{{ $getRecord->admission_number}}" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Roll Number<span style="color: red"></span></label>
                                        <input type="number" readonly class="form-control" name="roll_number" required
                                            value="{{ $getRecord->roll_number}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Caste <span style="color: red"></span></label>
                                        <input type="text" readonly class="form-control" name="caste"
                                            value="{{ $getRecord->caste}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Religion <span style="color: red"></span></label>
                                        <input type="text" readonly class="form-control" name="religion"
                                            value="{{ $getRecord->religion}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Blood Group  <span style="color: red"></span> </label>
                                        <input type="text" readonly class="form-control" name="blood_group"
                                            value="{{ $getRecord->blood_group}}">
                                    </div>
                                </div>

                                <hr/>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Email address <span style="color: red"></span></label>
                                        <input type="email" class="form-control" name="email" readonly
                                            value="{{ $getRecord->email}}" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Mobile Number  <span style="color: red"></span> </label>
                                        <input type="text" readonly class="form-control" name="mobile_number"
                                            value="{{ $getRecord->mobile_number}}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Status <span style="color: red"></span> </label>
                                        <input type="text" readonly class="form-control" name="status"
                                        value="{{ $getRecord->status == 0 ? 'Active' : 'Inactive' }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="">Admission Date  <span style="color: red"></span> </label>
                                        <input type="date" readonly class="form-control" name="admission_date"
                                            value="{{ $getRecord->admission_date}}">
                                    </div>
                                </div>




                            </div>
                            <!-- /.card-body -->
                        </div>


                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <style>
        img.img-fluid {
    max-width: 100%; /* Điều chỉnh kích thước tối đa theo nhu cầu */
    height: auto; /* Giữ tỷ lệ khung hình */
        }
    </style>
@endsection
