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
                <a href="javascript:deleteRecord({{ $id }})" class="btn btn-default">Delete</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
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