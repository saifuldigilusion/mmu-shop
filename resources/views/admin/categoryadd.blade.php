@extends('adminlte::page')

@section('content_header')
    <h1>Category</h1>
@stop

@php
 $id = 0;
 $name = "";

 $edit = false;
 if($category !== null) {
    $id = $category->id;
    $name = $category->name;

    $edit = true;
 }   
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Category Detail</h3>
            </div>
            <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('category_add') }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="card-body">
                <div class="form-group row">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Category name" value="{{ $name }}" required>
                    <div class="invalid-feedback">
                        Please insert category name
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <div class="float-right">
                <a href="{{ route('category_list') }}" class="btn btn-default">List</a>
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
        form.action = '{{ route("category_delete") }}';
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