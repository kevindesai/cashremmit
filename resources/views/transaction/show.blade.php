@extends('layouts.admin')
@section('header')
<h1>From {{ $transaction->username }} to {{ $transaction->receipentname }} </h1>

@endsection

@section('content')
<div class="container">

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
                <tr><th> {{ trans('From') }} </th>
                    <td> {{ $transaction->username }} </td>
                </tr>
                <tr><th> {{ trans('To(Benif)') }} </th>
                    <td> {{ $transaction->receipentname }} </td>
                </tr>
                <tr><th> {{ trans('Transaction By') }} </th>
                    <td> {{ $transaction->transaction_by }} </td>
                </tr>
                @foreach($transactionData as $key=>$item)
                <tr><th> {{ trans($key) }} </th>
                    <td> {{ $item }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection