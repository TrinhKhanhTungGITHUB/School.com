@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> {{ $header_title }}
                            (Total : {{ $getRecord->total() }})</h1>
                    </div>

                    <div class="col-sm-6" style="text-align: right;">
                        @if ($header_title == 'Subject List')
                            <a href="{{ url('admin/subject/add') }}" class="btn btn-primary"> Add New Subject</a>
                            <a href="{{ url('admin/subject/trash_bin') }}" class="btn btn-warning">Trash Bin</a>
                        @else
                            <a href="{{ url('admin/subject/list') }}" class="btn btn-primary">Back</a>
                        @endif
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
                                <h4><span style="color: blue"><b>Settting</b></span></h4>
                            </div>
                            <form action="" method="GET">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Search</h5>
                                        </div>
                                        <div class="row col-md-11">
                                            <div class="form-group col-md-3">
                                                <label for="">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ Request::get('name') }}" placeholder="Enter Name">
                                                @if ($errors->has('name'))
                                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="">Subject Type</label>
                                                <select class="form-control" name="type">
                                                    <option value="">Select Type</option>
                                                    <option value="Theory"
                                                        {{ Request::get('type') == 'Theory' ? 'selected' : '' }}>Theory
                                                    </option>
                                                    <option value="Practical"
                                                        {{ Request::get('type') == 'Practical' ? 'selected' : '' }}>
                                                        Practical
                                                    </option>
                                                    @if ($errors->has('type'))
                                                        <p class="text-danger">{{ $errors->first('type') }}</p>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="">Status <span style="color: red"></span> </label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select Status</option>
                                                    <option value=100
                                                        {{ Request::get('status') == '100' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value=1 {{ Request::get('status') == '1' ? 'selected' : '' }}>
                                                        In Active
                                                    </option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="">Date</label>
                                                <input type="date" class="form-control" name="date"
                                                    value="{{ Request::get('date') }}" placeholder="Enter email">
                                                @if ($errors->has('date'))
                                                    <p class="text-danger">{{ $errors->first('date') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Arrange</h5>
                                        </div>
                                        <div class="row col-md-11">
                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="name_sort">
                                                    <option value="">Select Arrange Name</option>
                                                    <option value="asc"
                                                        {{ Request::get('name_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('name_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('name_sort'))
                                                    <p class="text-danger">{{ $errors->first('name_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="subject_type_sort">
                                                    <option value="">Select Arrange Subject Type</option>
                                                    <option value="asc"
                                                        {{ Request::get('subject_type_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('subject_type_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('subject_type_sort'))
                                                    <p class="text-danger">{{ $errors->first('subject_type_sort') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <select class="form-control" name="date_sort">
                                                    <option value="">Select Arrange Date</option>
                                                    <option value="asc"
                                                        {{ Request::get('date_sort') == 'asc' ? 'selected' : '' }}>
                                                        ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('date_sort') == 'desc' ? 'selected' : '' }}>
                                                        DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('date_sort'))
                                                    <p class="text-danger">{{ $errors->first('date_sort') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-1" style="margin: auto;">
                                            <h5 style="color: rgb(255, 4, 142)">Paginate</h5>
                                        </div>

                                        <div class="row col-md-6">
                                            <div class="form-group col-md-6">
                                                <input type="number" class="form-control" name="paginate"
                                                    @if (!empty(Request::get('paginate'))) value="{{ Request::get('paginate') }}"
                                                 @else value="10" @endif
                                                    placeholder="Enter Number">
                                                @if ($errors->has('paginate'))
                                                    <p class="text-danger">{{ $errors->first('paginate') }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group col-md-5 d-flex align-items-end justify-content-center">
                                            <button class="btn btn-primary" type="submit">Search </button>
                                            <div class="ml-1">
                                                @if ($header_title == 'Subject List')
                                                    <a href="{{ url('admin/subject/list') }}"
                                                        class="btn btn-success">Reset</a>
                                                @else
                                                    <a href="{{ url('admin/subject/trash_bin') }}"
                                                        class="btn btn-success">Reset</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue"><b> {{ $header_title }}</b></span></h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Subject Type</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td> {{ $value->name }}</td>
                                                <td> {{ $value->type }}</td>
                                                <td>
                                                    {{ $value->status == 0 ? 'Active' : 'In Active' }}
                                                </td>
                                                <td> {{ $value->created_by_name }}</td>
                                                <td> {{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                                <td>
                                                    @if ($header_title == 'Subject List')
                                                    <a href="{{ url('admin/subject/edit/' . $value->id) }}"
                                                        class="btn btn-primary ">Edit</a>
                                                    <a href="{{ url('admin/subject/delete/' . $value->id) }}"
                                                        class="btn btn-danger "
                                                        onclick="return confirmDelete();">Delete</a>
                                                    @else
                                                    <a href="{{ url('admin/subject/restore/' . $value->id) }}"
                                                        class="btn btn-primary ">Restore</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @if ($getRecord->total() > 0)
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Subject Type</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Action </th>
                                        </tr>
                                    </tfoot>
                                    @endif
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
            return confirm('Are you sure you want to delete this subject?');
        }
    </script>
@endsection
