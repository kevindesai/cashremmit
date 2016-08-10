@extends('layouts.admin')

@section('header')

<h1>Transactions</h1>
@endsection


@section('content')
<div class="container table table-responsive">
    <div class="table">

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> 
                        {{ trans('User') }} 
                    </th>
                    <th> {{ trans('Amount') }} </th>/
                    <th>{{ trans('Currency Code') }}</th>
                    <th> {{ trans('Status') }} </th>
                    <th> {{ trans('Date') }} </th>
                    

                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($transaction as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->user->first_name . " ". $item->user->last_name }}
                    </td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->currency_code }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $transaction->render() !!} </div>
    </div>

</div>
@endsection
