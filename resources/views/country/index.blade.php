@extends('layouts.admin')

@section('content')
<div class="container table table-responsive">

    <h1>Country</h1>
    <div class="table">
        
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('Country Name') }} </th>
                    <th> {{ trans('Country Code') }} </th>
                    <th> {{ trans('Currency Name') }} </th>
                    <th>{{ trans('Currency Code') }}</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($country as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->country_name }}</td>
                    <td>{{ $item->country_code }}</td>
                    <td>{{ $item->currency_name }}</td>
                    <td>{{ $item->currency_code }}</td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $country->render() !!} </div>
    </div>

</div>
@endsection
