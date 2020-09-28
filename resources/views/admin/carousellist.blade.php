@extends('adminlte::page')  

@section('content_header')
    <h1>Carousel</h1>
@stop

@section('content')
<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Enable</th>
                <th>&nbsp;</th>
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
        //dom: 'Bft',
        //dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        processing: true,
        serverSide: true,
        buttons: [
            //'csv', 'print',
            {
            text: ' New ',
            action: function(e, dt, node, config) {
                window.location.href = "/admin/carousel/add";
            }
            },
        ],
        //ajax: "{{ route('order_list') }}",
        ajax: {
            'url':'{{ route('carousel_list') }}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        searching: false,
        order: [[0, 'desc']],
        pageLength: 25,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'title', name: 'title', orderable: false, searchable: false},
            {data: 'description', name: 'description', orderable: false, searchable: false},
            {data: 'active', name: 'active', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false,searchable: false},
        ]
    });
    //table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  });
    
    </script>
@stop