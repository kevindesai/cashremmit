@extends('layouts.admin')
@section('header')
<h1>{{ $user->first_name }}</h1>

@endsection

@section('content')
<div class="container">

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
<!--                <tr>
                    <th>ID.</th><td>{{ $user->id }}</td>
                </tr>-->
                <tr><th> {{ trans('First Name') }} </th><td> {{ $user->first_name }} </td></tr><tr><th> {{ trans('Last Name') }} </th><td> {{ $user->last_name }} </td></tr><tr><th> {{ trans('Unit No.') }} </th><td> {{ $user->unit_no }} </td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="{{ url('users/' . $user->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['users', $user->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                        'type' => 'submit',
                        'class' => 'btn btn-danger btn-xs',
                        'title' => 'Delete User',
                        'onclick'=>'return confirm("Confirm delete?")'
                        ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection