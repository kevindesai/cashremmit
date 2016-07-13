@extends('layouts.admin')

@section('content')
<div class="">

    <h1>Edit bank ({{ $bank->name }})</h1>

    {!! Form::model($bank, [
        'method' => 'PATCH',
        'url' => ['/admin/banks', $bank->id],
        'class' => 'form-horizontal'
    ]) !!}
    @include('banks._form')
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