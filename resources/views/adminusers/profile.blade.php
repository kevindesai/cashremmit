@extends('layouts.admin')
@section('header')
<h1>{{ $user->name }}</h1>

@endsection
@section('content')

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <tbody>
            <tr>
                <th> {{ trans('Name') }} </th>
                <td> {{ $user->name }} </td>
            </tr>
            <tr>
                <th> {{ trans('Email') }} </th>
                <td> {{ $user->email }} </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <a href="{{ url('/admin/profile/edit') }}" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>

                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection