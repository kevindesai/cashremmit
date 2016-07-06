@extends('layouts.admin')

@section('content')
<div class="container table table-responsive">

    <h1>
        Country Rate
        <a href="{{ url('/country/create') }}" class="btn btn-primary btn-xs" title="Add Rate"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
    </h1>
    <div class="table">
        <div class="pagination"> {!! $rate->render() !!} </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('FROM') }} </th>
                    <th> {{ trans('TO') }} </th>
                    <th> {{ trans('Rate(+/-)') }} </th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($rate as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->from }}</td>
                    <td>{{ $item->to }}</td>
                    <td>{{ $item->rate }}</td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $rate->render() !!} </div>
    </div>

</div>
@endsection
