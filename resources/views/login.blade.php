@extends('layouts.app')

@section('content')

{{ Form::open(array('url' => 'login')) }}
<h1>Login</h1>


<div class="form-group ">
    {!! Form::label('email', null, ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group ">
    {!! Form::label('password', null, ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::password('password', null, ['class' => 'form-control']) !!}
    </div>
</div>



<p>{{ Form::submit('Submit!') }}</p>
{{ Form::close() }}
@endsection