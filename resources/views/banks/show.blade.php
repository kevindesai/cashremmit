@extends('layouts.admin')

@section('content')
<div class="">

    <h1>{{ $bank->name }}
        <a href="{{ url('banks/' . $bank->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit bank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['banks', $bank->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'title' => 'Delete bank',
                    'onclick'=>'return confirm("Confirm delete?")'
            ));!!}
        {!! Form::close() !!}
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr><th> Country </th><td> {{ $bank->country->country_name }} </td></tr><tr><th> Name </th><td> {{ $bank->name }} </td></tr><tr><th> Branch </th><td> {{ $bank->branch }} </td></tr>
                
                <tr>
                    <th>Bank Code</th><td>{{ $bank->bank_code }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
