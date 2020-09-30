@extends('adminlte::page')

@section('content_header')
    <h1>Product</h1>
@stop

@php
 $id = 0;
 $name = "";
 $description = "";
 $long_description = "";
 $image = "";
 $image_big = "";
 $price = 0.00;
 $rrp_price = 0.00;
 $available = 0;
 $booking = 0;
 $schedule_id = 0;
 $category_id = 1;
 $order = 0;
 $selfcollect = 0;
 $delivery = 0;

 $edit = false;
 if($product !== null) {
    $id = $product->id;
    $name = $product->name;
    $description = $product->description;
    $long_description = $product->long_description;
    $image = $product->image;
    $image_big = $product->image_big;
    $price = $product->price;
    $rrp_price = $product->rrp_price;
    $available = $product->available;
    $booking = $product->booking;
    $schedule_id = $product->schedule_id;
    $category_id = $product->category_id;
    $order = $product->order;
    $selfcollect = $product->selfcollect;
    $delivery = $product->delivery;

    $edit = true;
 }   
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Detail</h3>
            </div>
            <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('product_add') }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="card-body">
                <div class="form-group row">
                    <label for="category_id">Category</label>
                    <select class="custom-select" id="category_id" name="category_id">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $category_id ? "selected": "" }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="order">Order</label>
                    <input type="number" class="form-control" id="order" name="order" placeholder="" value="{{ $order }}">
                </div>
                <div class="form-group row">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $name }}" required>
                    <div class="invalid-feedback">
                        Require product name
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Product short description" value="{{ $description }}" required>
                    <div class="invalid-feedback">
                        Require short description
                    </div>
                </div>
                <div class="form-group row">
                    <label for="long_description">Full Description</label>
                    <textarea class="form-control" id="long_description" name="long_description" placeholder="Product full description">{{ $long_description }}</textarea>
                </div>
                <div class="form-group row">
                    <label for="image">Image URL</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="Get image URL from Media Manager (350x200)" value="{{ $image }}" required>
                    <div class="invalid-feedback">
                        Image URL required. e.g. https://to-image
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image_big">Big Image URL</label>
                    <input type="text" class="form-control" id="image_big" name="image_big" placeholder="Get image URL from Media Manager (1110x350)" value="{{ $image_big }}" required>
                    <div class="invalid-feedback">
                        Image URL required. e.g. https://to-image
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price">Price RM</label>
                    <input type="text" class="form-control" id="price" name="price" value="{{ $price }}" placeholder="0.00" required>
                    <div class="invalid-feedback">
                        Selling price RMx.xx
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rrp_price">RRP RM</label>
                    <input type="text" class="form-control" id="rrp_price" name="rrp_price" value="{{ $rrp_price }}" placeholder="0.00">
                </div>
                <div class="form-group row">
                    <label for="schedule_id">Booking Schedule</label>
                    <select class="custom-select" id="schedule_id" name="schedule_id">
                        <option value="0">No Booking Required</option>
                        @foreach($schedules as $schedule) 
                        <option value="{{ $schedule->id }}" {{ $schedule_id == $schedule->id ? "selected":""}}>{{ $schedule->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selfcollect" id="selfcollect" {{ $selfcollect ? "checked":""}}><label for="selfcollect" class="form-check-label">Self Collect Available</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delivery" id="delivery" {{ $delivery ? "checked": ""}}><label for="delivery" class="form-check-label">Delivery Available</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="">Delivery Cost</label>
                </div>
                @foreach($deliveryCostName as $d => $v) 
                <div class="form-group row">
                    <div class="form-check">
                    <label class="form-check-label" for="{{ $d }}">{{ $d }}</label>
                    <input class="form-control" type="number" step="0.01" value="{{ $productDeliveryCost[$d] }}" name="p-{{ $d }}">
                    </div>
                </div>
                @endforeach
                
                <div class="form-group row">
                    <label for="available">Enable</label>
                    <select class="custom-select" id="available" name="available">
                        <option value="1" {{ $available ? "selected": ""}}>Yes</option>
                        <option value="0" {{ $available ? "": "selected"}}>No</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <div class="float-right">
                <a href="{{ route('product_list') }}" class="btn btn-default">List</a>
                @if($edit)
                    <a href="javascript:deleteRecord({{ $id }})" class="btn btn-default">Delete</a>
                @endif
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>

(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();

$(document).ready(function() {
  $('#long_description').summernote();
});

function deleteRecord(id) {
        if(confirm('Delete this record?')) {
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = '{{ route("product_delete") }}';
        data = { text: 'delete', _token: $('meta[name="csrf-token"]').attr('content'), id: id}
        for (var name in data) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = data[name];
            form.appendChild(input);
        }
        form.submit();
    }
}

</script>
@stop