@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Subject</h1>
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
                                <h4 ><span style="color: blue"><b>My Subject</b> </span></h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Subject Type</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value )
                                        <tr>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->subject_name}}</td>
                                            <td>{{$value->subject_type}}</td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
