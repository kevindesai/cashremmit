@extends('layouts.admin')
@section('header')
<h1>Create New User</h1>

@endsection
@section('content')

<hr/>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{!! Form::open(['url' => '/admin/adminusers', 'class' => 'form-horizontal','id'=>'myform']) !!}

<div class="form-group ">
    {!! Form::label('name', trans('Name'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control', 'required'=>'required']) !!}
        {!! $errors->first('name', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group ">
    {!! Form::label('email', trans('Email'), ['class' => 'col-sm-3 control-label', 'required'=>'required']) !!}
    <div class="col-sm-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group ">
    {!! Form::label('email', trans('Password'), ['class' => 'col-sm-3 control-label', 'required'=>'required']) !!}
    <div class="col-sm-6">
        {!! Form::password('password', null, ['class' => 'form-control']) !!}
        {!! $errors->first('password', ' <span class="help-block">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit('Create', ['class' => 'btn btn-primary form-control save']) !!}
    </div>
</div>
{!! Form::close() !!}

@endsection

@section('script')
<script>
    window.ParsleyConfig = {
        successClass: 'has-success'
        , errorClass: 'has-error'
        , errorElem: '<span></span>'
        , errorsWrapper: '<span class="help-block"></span>'
        , errorTemplate: "<div></div>"
        , classHandler: function (el) {
            return el.$element.closest(".form-group");
        }
    };
    $(document).ready(function () {
        $('.save').click(function (e) {
            e.preventDefault();
            var form = $('#myform').parsley();
            form.validate();
            if (form.isValid()) {
                $('#myform').submit();
            }
        });
    });
</script>
@endsection