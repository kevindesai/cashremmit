@extends('layouts.admin')

@section('header')

<h1>Country Flags</h1>
@endsection


@section('content')

<div class="container">

	@if(Session::has('flagsave_message'))
		<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('flagsave_message') }}</p>
	@endif

	{!! Form::open(array('url'=>'admin/uploadflag','method'=>'POST', 'files'=>true)) !!}
	<div class="form-group">
		<label for="code">Select Code :</label>
		<select class="form-control" name="currency_code">
			<option value="">Please Select Code</option>
			@for ($i = 0; $i < count($code); $i++)
			<option value="{{ $code[$i]->currency_code }}">{{ $code[$i]->currency_code }}</option>
			@endfor
		</select>
    </div>	
	
	<div class="form-group">
		{!! Form::label('image', 'Select image:') !!}
		{!! Form::file('image') !!}
	</div>
	
	<div class="form-group">
		{!! Form::submit('Submit') !!}
	</div>
	
	{!! Form::close() !!} 

</div>
@endsection
