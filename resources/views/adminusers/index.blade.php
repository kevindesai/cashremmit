@extends('layouts.admin')
@section('header')
<h1>Admin Users <a href="{{ url('/admin/adminusers/create') }}" class="btn btn-primary btn-xs" title="Add New User"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>

@endsection
@section('content')
<div class="container table table-responsive">

    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('Name') }} </th>
                    <th> {{ trans('Email') }} </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($users as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ url('/admin/adminusers/' . $item->id) }}" class="btn btn-success btn-xs" title="View User"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/adminusers/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        <?php
                        if($item->user_type == 'sub'){
                        ?>
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/admin/adminusers', $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'title' => 'Delete User',
                        'onclick'=>'return confirm("Confirm delete?")'
                        ));!!}
                        {!! Form::close() !!}
                        <?php } ?>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $users->render() !!} </div>
    </div>

</div>
@endsection
