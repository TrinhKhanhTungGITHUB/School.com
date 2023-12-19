@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Collect Fees
                            @if (!empty($getStudent))
                                <span style="color: blue">{{ $getStudent->name }} {{ $getStudent->last_name }}
                                </span>
                            @endif
                        </h1>
                    </div>
                    @if (!empty($getStudent))
                    <div class="col-sm-6" style="text-align: right;">
                        <button type="button" class="btn btn-primary" id='AddFees'>Add Fees</button>
                        <a href="{{ url('admin/fees_collection/collect_fees') }}" class="btn btn-secondary">Back</a>
                    </div>
                    @else
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/fees_collection/collect_fees') }}" class="btn btn-secondary"> Back</a>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4><span style="color: blue"><b>Payment Detail</b> </span></h4>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Total Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Remaining Amount</th>

                                            <th>Payment Type</th>
                                            <th>Remark</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getFees))
                                            @forelse ($getFees as $value)
                                                <tr>
                                                    <td> {{ $value->class_name }}</td>
                                                    <td> ${{ number_format($value->total_amount, 2) }}</td>
                                                    <td> ${{ number_format($value->paid_amount, 2) }}</td>
                                                    <td> ${{ number_format($value->remaining_amount, 2) }}</td>

                                                    <td> {{ $value->payment_type }}</td>
                                                    <td> {{ $value->remark }}</td>
                                                    <td> {{ $value->created_name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%">Record not found</td>
                                                </tr>
                                            @endforelse
                                        @else
                                            <tr>
                                                <td colspan="100%">Record not found</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <div style="padding: 10px;" class="d-flex justify-content-center">
                                    @if (!empty($getFees))
                                        {!! $getFees->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    @if (!empty($getStudent))
        <div class="modal fade" id="AddFeesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Fees</h5>
                        <button type="button" class="btn-close" id="closeButton" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="col-form-label">Class Name: {{ $getStudent->class_name }}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Total Amount:
                                    ${{ number_format($getStudent->amount, 2) }}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Paid Amount: ${{ number_format($paid_amount, 2) }}</label>
                            </div>

                            <div class="form-group">
                                @php
                                    $RemainingAmount = $getStudent->amount - $paid_amount;
                                @endphp

                                <label class="col-form-label">Remaning Amount: ${{ number_format($RemainingAmount, 2) }}
                                </label>

                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Amount <span style="color: red;">*</span> </label>
                                <input type="number" class="form-control" name='amount' required>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Payment Type <span style="color: red;">*</span> </label>
                                <select class= "form-control" name="payment_type" required>
                                    <option value="">Select</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label"> Remark: <span style="color: red;">*</span> </label>
                                <textarea class="form-control" name="remark" required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeModal" data-bs-dismiss="modal"
                                aria-label="Close">Close</button>
                            <button type="submit" class="btn btn-primary" id="fessForm">Submit</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $('#AddFees').click(function() {
            $('#AddFeesModal').modal('show');
        });

        // Bắt sự kiện click trên nút "Close" và dấu X
        $('#closeButton, .closeModal').click(function(e) {
            if (e.target === this) {
                $('#AddFeesModal').modal('hide');
            }
        });

        // Ngăn chặn sự kiện click từ nút "Submit" lan truyền đến modal
        $('#feesForm').click(function(e) {
            e.stopPropagation();
        });
    </script>
@endsection
