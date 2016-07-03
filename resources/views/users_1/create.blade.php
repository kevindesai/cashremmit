@extends('layouts.admin')

@section('content')
<div class="container">

    <h1>Create New User</h1>
    <hr/>

    {!! Form::open(['url' => '/users', 'class' => 'form-horizontal']) !!}

    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
        {!! Form::label('first_name', trans('users.first_name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
        {!! Form::label('last_name', trans('users.last_name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('unit_no') ? 'has-error' : ''}}">
        {!! Form::label('unit_no', trans('users.unit_no'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('unit_no', null, ['class' => 'form-control']) !!}
            {!! $errors->first('unit_no', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('building_name') ? 'has-error' : ''}}">
        {!! Form::label('building_name', trans('users.building_name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('building_name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('building_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
        {!! Form::label('city', trans('users.city'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('city', null, ['class' => 'form-control']) !!}
            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('region') ? 'has-error' : ''}}">
        {!! Form::label('region', trans('users.region'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('region', null, ['class' => 'form-control']) !!}
            {!! $errors->first('region', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('street') ? 'has-error' : ''}}">
        {!! Form::label('street', trans('users.street'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('street', null, ['class' => 'form-control']) !!}
            {!! $errors->first('street', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('post_code') ? 'has-error' : ''}}">
        {!! Form::label('post_code', trans('users.post_code'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('post_code', null, ['class' => 'form-control']) !!}
            {!! $errors->first('post_code', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('country') ? 'has-error' : ''}}">
        {!! Form::label('country', trans('users.country'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('country', null, ['class' => 'form-control']) !!}
            {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('dob') ? 'has-error' : ''}}">
        {!! Form::label('dob', trans('users.dob'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('dob', null, ['class' => 'form-control']) !!}
            {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('mobile_no') ? 'has-error' : ''}}">
        {!! Form::label('mobile_no', trans('users.mobile_no'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('mobile_no', null, ['class' => 'form-control']) !!}
            {!! $errors->first('mobile_no', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('landline_no') ? 'has-error' : ''}}">
        {!! Form::label('landline_no', trans('users.landline_no'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('landline_no', null, ['class' => 'form-control']) !!}
            {!! $errors->first('landline_no', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

</div>
<script>
    window.ParsleyConfig = {
    	  successClass: 'has-success'
		, errorClass: 'has-error'
		, errorElem: '<span></span>'
		, errorsWrapper: '<span class="help-block"></span>'
		, errorTemplate: "<div></div>"
		, classHandler: function(el) {
    		return el.$element.closest(".form-group");
		}
	};
    $(document).ready(function(){
        //$('#myform').parsley().validate();
        $('.save').click(function(e){
            $('#myform').parsley().validate();
        });
    });
</script>
@endsection