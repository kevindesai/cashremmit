@extends('layouts.admin')
@section('header')
<h1>Change Password </h1>

@endsection
@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model([
'method' => 'PATCH',
'url' => ['/admin/password'],
'class' => 'form-horizontal',
'id'=>'myform'
]) !!}
<div class="form-group ">
    {!! Form::label('password', trans('New Password'), ['class' => 'col-sm-4 control-label', 'required'=>'required']) !!}
    <div class="col-sm-6">
        <input type="password" name="password" class="form-control" placeholder="New Password">
        {!! $errors->first('password', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group ">
    {!! Form::label('confirmed', trans('Re-Password'), ['class' => 'col-sm-4 control-label', 'required'=>'required']) !!}
    <div class="col-sm-6 ">
        <input type="password" name="confirmed" class="form-control" placeholder="Re-Password">
        {!! $errors->first('confirmed', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-3">
        {!! Form::submit('Change', ['class' => 'btn btn-primary form-control save']) !!}
    </div>
</div>
{!! Form::close() !!}

@endsection

