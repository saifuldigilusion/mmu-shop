@extends('adminlte::page')

@section('content_header')
    <h1>Change Password</h1>
@stop

@php

@endphp

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('change_password') }}" novalidate>
            @csrf
            <div class="card-body">
                @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                <div class="form-group row">
                    <label for="current">Current Password</label>
                    <input type="password" class="form-control pwds" id="current" name="current" required>
                    <div class="invalid-feedback">
                        Current password required
                    </div>
                </div>
                <div class="form-group row">
                    <label for="new">New Password</label>
                    <input type="password" class="form-control pwds" id="new" name="new" required>
                    <div class="invalid-feedback">
                        New password required
                    </div>
                </div>
                <div class="form-group row">
                    <label for="new2">Confirm New Password</label>
                    <input type="password" class="form-control pwds" id="new2" name="new2" required>
                    <div class="invalid-feedback" id="cPwdInvalid">
                        Not match
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
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

$(document).ready(function() {
    // Check if passwords match
    $('#new, #new2').on('keyup', function() {
        if ($('#new').val() != '' && $('#new2').val() != '' && $('#new').val() == $('#new2').val()) {
            $("#submitBtn").attr("disabled", false);
            $('#cPwdInvalid').hide();
            $('.pwds').removeClass('is-invalid')
        } else {
            $("#submitBtn").attr("disabled", true);
            $('#cPwdInvalid').show();
            $('#cPwdInvalid').html('Not Matching').css('color', 'red');
            $('.pwds').addClass('is-invalid')
        }
    });
    let currForm1 = document.getElementById('form');
    // Validate on submit:
    currForm1.addEventListener('submit', function(event) {
        if (currForm1.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        currForm1.classList.add('was-validated');
    }, false);
    // Validate on input:
    currForm1.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener(('input'), () => {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid')
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid')
                input.classList.add('is-invalid');
            }
            var is_valid = $('.form-control').length === $('.form-control.is-valid').length;
            $("#submitBtn").attr("disabled", !is_valid);
        });
    });
});

</script>
@stop