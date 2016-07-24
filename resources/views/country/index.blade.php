@extends('layouts.admin')

@section('content')
<div class="container table table-responsive">

    <h1>Country</h1>
    <form>

        <div class="col-md-2 pull-right">
            <a href="{{ url('/admin/country') }}" class="btn btn-primary pull-right">Reset</a>
        </div>
        <div class="col-md-3 pull-right">
            <input type="text" name="search" placeholder="search" value="<?php echo $searchTerm; ?>" class="form-control">
        </div>
    </form>
    <div class="table">

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('Country Name') }} </th>
                    <th> {{ trans('Country Code') }} </th>
                    <th> {{ trans('Currency Name') }} </th>
                    <th>{{ trans('Currency Code') }}</th>
                    <th>{{ trans('Transfer Rate') }}</th>
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
                    <td>
                        <a href="{{ url('/admin/transferrate/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Transfer Rate">
                            Transfer Rate</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $country->appends(['search' => $searchTerm])->render() !!} </div>
    </div>

</div>
@endsection
