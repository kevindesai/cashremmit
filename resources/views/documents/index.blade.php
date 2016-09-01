@extends('layouts.admin')

@section('header')
<h1>Documents <a href="{{ url('/admin/documents/create') }}" class="btn btn-primary btn-xs" title="Add New document"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>

@endsection

@section('content')
<div class="">

    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> Country </th><th> Name </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($documents as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->country->country_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ url('/admin/documents/' . $item->id) }}" class="btn btn-success btn-xs" title="View documents"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/documents/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit documents"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/admin/documents', $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete document" />', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'title' => 'Delete document',
                        'onclick'=>'return confirm("Confirm delete?")'
                        ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $documents->render() !!} </div>
    </div>

</div>
@endsection
