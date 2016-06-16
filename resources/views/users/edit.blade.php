@extends('layouts.admin')

@section('content')
<div class="container">

    <h1>Edit User {{ $user->id }}</h1>

    {!! Form::model($user, [
        'method' => 'PATCH',
        'url' => ['/admin/users', $user->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : ''}}">
                {!! Form::label('firstname', trans('users.firstname'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('firstname', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('lastname') ? 'has-error' : ''}}">
                {!! Form::label('lastname', trans('users.lastname'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('lastname', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! Form::label('email', trans('users.email'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('email', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('pasword') ? 'has-error' : ''}}">
                {!! Form::label('pasword', trans('users.pasword'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::password('pasword', ['class' => 'form-control']) !!}
                    {!! $errors->first('pasword', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
                {!! Form::label('contact', trans('users.contact'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('contact', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
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
@endsection