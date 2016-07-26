@extends('layouts.admin')


@section('header')
<h1>Transfer Rate <a href="{{ url('/admin/transferrate/create') }}" class="btn btn-primary btn-xs" title="Add New "><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
@endsection

@section('content')
<div class="container table table-responsive">

    <div class="table">
        <form>

            <div class="col-md-2 pull-right">
                <a href="{{ url('/admin/transferrate') }}" class="btn btn-primary pull-right">Reset</a>
            </div>
            <div class="col-md-3 pull-right">
                <input type="text" name="search" placeholder="search" value="<?php echo $searchTerm; ?>" class="form-control">
            </div>
        </form>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('Country') }} </th>
                    <th> {{ trans('From') }} </th>
                    <th> {{ trans('To') }} </th>
                    <th> {{ trans('Rate') }} </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($transferrate as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->country->country_name }}</td>
                    <td>{{ $item->from }} ({{ $item->currency_code }})</td>
                    <td>{{ $item->to }} ({{ $item->currency_code }})</td>
                    <td>{{ $item->rate }} ({{ $item->currency_code }})</td>

                    <td>
                        <a href="{{ url('/admin/transferrate/' . $item->country_id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $transferrate->appends(['search' => $searchTerm])->render() !!} </div>
    </div>

</div>
@endsection
