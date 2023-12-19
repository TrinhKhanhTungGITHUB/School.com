@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> {{ $header_title }}
                            (Total : {{ $getRecord->total() }})
                        </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                            <a href="{{ url('admin/communicate/notice_board/add') }}" class="btn btn-primary"> Add New Notice
                                Board </a>
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
                                            <div class="form-group col-md-2">
                                                <label for="">Title</label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ Request::get('title') }}" placeholder="Enter Title">
                                                @if ($errors->has('title'))
                                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="">Notice Date From</label>
                                                <input type="date" class="form-control" name="notice_date_from"
                                                    value="{{ Request::get('notice_date_from') }}">
                                                @if ($errors->has('notice_date_from'))
                                                    <p class="text-danger">{{ $errors->first('notice_date_from') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Notice Date To</label>
                                                <input type="date" class="form-control" name="notice_date_to"
                                                    value="{{ Request::get('notice_date_to') }}">
                                                @if ($errors->has('notice_date_to'))
                                                    <p class="text-danger">{{ $errors->first('notice_date_to') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Publish Date From</label>
                                                <input type="date" class="form-control" name="publish_date_from"
                                                    value="{{ Request::get('publish_date_from') }}">
                                                @if ($errors->has('publish_date_from'))
                                                    <p class="text-danger">{{ $errors->first('publish_date_from') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Publish Date To</label>
                                                <input type="date" class="form-control" name="publish_date_to"
                                                    value="{{ Request::get('publish_date_to') }}">
                                                @if ($errors->has('publish_date_to'))
                                                    <p class="text-danger">{{ $errors->first('publish_date_to') }}</p>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="">Message To</label>
                                                <select name="message_to" class="form-control">
                                                    <option value="">Select</option>
                                                    <option {{ Request::get('message_to') == 2 ? 'selected' : '' }}
                                                        value="2">Teacher</option>
                                                    <option {{ Request::get('message_to') == 3 ? 'selected' : '' }}
                                                        value="3">Student</option>
                                                    <option {{ Request::get('message_to') == 4 ? 'selected' : '' }}
                                                        value="4">Parent</option>
                                                </select>
                                                @if ($errors->has('message_to'))
                                                    <p class="text-danger">{{ $errors->first('message_to') }}</p>
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
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="title_sort">
                                                    <option value="">Select Arrange Title</option>
                                                    <option value="asc"
                                                        {{ Request::get('title_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('title_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('title_sort'))
                                                    <p class="text-danger">{{ $errors->first('title_sort') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="notice_date_sort">
                                                    <option value="">Select Arrange Notice Date </option>
                                                    <option value="asc"
                                                        {{ Request::get('notice_date_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('notice_date_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('notice_date_sort'))
                                                    <p class="text-danger">{{ $errors->first('notice_date_sort') }}</p>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="publish_date_sort">
                                                    <option value="">Select Arrange Publish Date </option>
                                                    <option value="asc"
                                                        {{ Request::get('publish_date_sort') == 'asc' ? 'selected' : '' }}>ASC
                                                    </option>
                                                    <option value="desc"
                                                        {{ Request::get('publish_date_sort') == 'desc' ? 'selected' : '' }}>DESC
                                                    </option>
                                                </select>
                                                @if ($errors->has('publish_date_sort'))
                                                    <p class="text-danger">{{ $errors->first('publish_date_sort') }}</p>
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
                                                <a href="{{ url('admin/communicate/notice_board/list') }}"
                                                    class="btn btn-success">Reset</a>

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
                                            <th>Title</th>
                                            <th>Notice Date</th>
                                            <th>Publish Date</th>
                                            <th>Message To</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getRecord as $value)
                                            <tr>
                                                <td> {{ $value->id }}</td>
                                                <td> {{ $value->title }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->notice_date)) }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->publish_date)) }}</td>
                                                <td>
                                                    @foreach ($value->getMessage as $message)
                                                        @if ($message->message_to == 2)
                                                            <div>Teacher</div>
                                                        @elseif ($message->message_to == 3)
                                                            <div>Student</div>
                                                        @elseif ($message->message_to == 4)
                                                            <div>Parent</div>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td> {{ $value->created_by_name }}</td>
                                                <td> {{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                                <td>
                                                    <a href="{{ url('admin/communicate/notice_board/edit/' . $value->id) }}"
                                                        class="btn btn-primary ">Edit</a>
                                                    <a href="{{ url('admin/communicate/notice_board/delete/' . $value->id) }}"
                                                        class="btn btn-danger" onclick="return confirmDelete();">Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%"> Record not found. </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if ($getRecord->total() > 0)
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Notice Date</th>
                                            <th>Publish Date</th>
                                            <th>Message To</th>
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
            return confirm('Are you sure you want to delete this notice board?');
        }
    </script>
@endsection
