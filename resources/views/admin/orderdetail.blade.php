@extends('adminlte::page')

@section('content_header')
    <h1>Order</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-secondary">Order No {{ $order->orderid }}</div>
    <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('order_edit') }}" novalidate>
    @csrf
    <input type="hidden" name="id" value="{{ $order->id }}">
    <div class="card-body">
        <div class="row">
            <div class="col col-md-6">
                <dl class="param param-feature">
                    <dt>Date</dt>
                    <dd>{{ $order->created_at }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Item Count</dt>
                    <dd>{{ $order->item_count }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Amount</dt>
                    <dd>RM{{ $order->total }}</dd>
                </dl>
            </div>
            <div class="col col-md-6">
                <dl class="param param-feature">
                    <dt>Name</dt>
                    <dd>{{ $order->name }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Email</dt>
                    <dd>{{ $order->email }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Phone</dt>
                    <dd>{{ $order->phone }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Student Id</dt>
                    <dd>{{ $order->studentid }}</dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="status">Status</label>
                    <select class="custom-select" id="status" name="status">
                        @foreach($statusOptions as $s)
                        <option value="{{ $s }}" {{ $order->status == $s ? "selected": ""}}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="payment_channel">Payment Channel</label>
                    <select class="custom-select" id="payment_channel" name="payment_channel">
                        @foreach($paymentChannels as $s)
                        <option value="{{ $s }}" {{ $order->payment_channel == $s ? "selected": ""}}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="payment_transactionid">Payment Transaction ID</label>
                    <input class="form-control" type="text" id="payment_transactionid" name="payment_transactionid" value="{{ $order->payment_transactionid }}" placeholder="">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <div class="float-right">
        <a href="{{ route('order_list') }}" class="btn btn-default">List</a>
        </div>
    </div>
    </form>
</div>

<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Require Booking</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>

    $(function () {
        
        var table = $('#order-table').DataTable({
            //dom: "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>>",
            //dom: 'Bft',
            //dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            //buttons: [
            //        'csv', 'print',
            //],
            //ajax: "{{ route('order_detail', ['orderId' => $order->id]) }}",
            ajax: {
                'url':"{{ route('order_detail', ['orderId' => $order->id]) }}",
                'type': 'POST',
                'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            //order: [[0, 'desc']],
            //pageLength: 25,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name', searchable: false, orderable: false},
                {data: 'description', name: 'description', searchable: false, orderable: false},
                {data: 'price', name: 'price', orderable: false, searchable: false},
                {data: 'qty', name: 'qty', orderable: false, searchable: false},
                {data: 'a_booking', name: 'a_booking', orderable: false, searchable: false},
            ]
        });
        //table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
      });
        
</script>
@stop