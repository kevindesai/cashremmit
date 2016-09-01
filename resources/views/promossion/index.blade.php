@extends('layouts.admin')

@section('header')
<h1>Promossion <a href="{{ url('/admin/promossion/create') }}" class="btn btn-primary btn-xs" title="Add New "><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>

@endsection
@section('content')
<div class="container table table-responsive">

    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> {{ trans('Code') }} </th><th> {{ trans('Discount') }} </th><th> {{ trans('Is Enable') }} </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($promossion as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->code }}</td><td>{{ $item->discount }}</td><td>{{ $item->is_enable }}</td>

                    <td>
                        <a href="{{ url('/admin/promossion/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/admin/promossion', $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete" />', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'title' => 'Delete ',
                        'onclick'=>'return confirm("Confirm delete?")'
                        ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $promossion->render() !!} </div>
    </div>

</div>
@endsection
