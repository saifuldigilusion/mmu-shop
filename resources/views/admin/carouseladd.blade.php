@extends('adminlte::page')

@section('content_header')
    <h1>Carousel</h1>
@stop

@php
 $id = 0;
 $image = "";
 $title = "";
 $description = "";
 $active = 0;

 $edit = false;
 if($carousel !== null) {
    $id = $carousel->id;
    $image = $carousel->image;
    $title = $carousel->title;
    $description = $carousel->description;
    $active = $carousel->active;

    $edit = true;
 }   
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Carousel Detail</h3>
            </div>
            <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('carousel_add') }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="card-body">
                <div class="form-group row">
                    <label for="image">Image URL</label>
                    <input type="text" class="form-control" id="image" name="image" placeholder="Get image URL from Media Manager" value="{{ $image }}" required>
                    <div class="invalid-feedback">
                        Image URL required. e.g. https://to-image
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $title }}" placeholder="Insert title">
                </div>
                <div class="form-group row">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $description }}" placeholder="Insert description">
                </div>
                <div class="form-group row">
                    <label for="active">Enable</label>
                    <select class="custom-select" id="active" name="active">
                        <option value="1" {{ $active ? "selected": ""}}>Yes</option>
                        <option value="0" {{ $active ? "": "selected"}}>No</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <div class="float-right">
                <a href="{{ route('carousel_list') }}" class="btn btn-default">List</a>
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
        form.action = '{{ route("carousel_delete") }}';
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