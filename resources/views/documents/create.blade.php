@extends('layouts.admin')

@section('header')
<h1>Create New document</h1>

@endsection


@section('content')
<div class="">

    <hr/>

    {!! Form::open(['url' => 'admin/documents', 'class' => 'form-horizontal']) !!}

    @include('documents._form')
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
@endsection