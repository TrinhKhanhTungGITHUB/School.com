@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Marks Grade (Total : {{ $getRecord->total() }}) </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/examinations/marks_grade/add') }}" class="btn btn-primary"> Add New Marks Grade</a>
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
                                <h4 style="color: blue"><span><b>Marks Grade List </b></span></h4>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Grade Name</th>
                                            <th>Percent From</th>
                                            <th>Percent To</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->name }}</td>
                                                <td> {{ $value->percent_from }}</td>
                                                <td> {{ $value->percent_to }}</td>
                                                <td> {{ $value->created_name }}</td>
                                                <td> {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ url('admin/examinations/marks_grade/edit/'.$value->id) }}"
                                                        class="btn btn-primary ">Edit</a>
                                                    <a href="{{ url('admin/examinations/marks_grade/delete/' . $value->id) }}"
                                                        class="btn btn-danger" onclick="return confirmDelete();">Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this marks grade?');
        }
    </script>
@endsection
