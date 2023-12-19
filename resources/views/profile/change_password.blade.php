@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password </h1>
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
              <form action="" method="POST">
                {{csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" class="form-control" name="old_password" required value="{{ old('old_password') }}" placeholder="Enter Old Password">
                    @if($errors->has('old_password'))<p class="text-danger">{{ $errors->first('old_password') }}</p> @endif
                </div>

                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="new_password" required value="{{ old('new_password') }}" placeholder="Enter New Password">
                    @if($errors->has('new_password'))<p class="text-danger">{{ $errors->first('new_password') }}</p> @endif
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
