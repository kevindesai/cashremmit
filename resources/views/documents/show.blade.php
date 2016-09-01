@extends('layouts.admin')

@section('header')
<h1>{{ $documents->name }}
    <a href="{{ url('/admin/banks/' . $documents->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit documents"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
    {!! Form::open([
    'method'=>'DELETE',
    'url' => ['banks', $documents->id],
    'style' => 'display:inline'
    ]) !!}
    {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
    'type' => 'submit',
    'class' => 'btn btn-danger btn-xs',
    'title' => 'Delete document',
    'onclick'=>'return confirm("Confirm delete?")'
    ));!!}
    {!! Form::close() !!}
</h1>
@endsection


@section('content')
<div class="">


    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr><th> Country </th><td> {{ $documents->country->country_name }} </td></tr><tr><th> Name </th><td> {{ $documents->name }} </td></tr><tr><th> Branch </th><td> {{ $documents->branch }} </td></tr>

                <tr>
                    <th>document Code</th><td>{{ $documents->bank_code }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
