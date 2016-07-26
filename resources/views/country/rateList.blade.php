@extends('layouts.admin')

@section('header')
<h1>
    Country Rate
    <a href="{{ url('/admin/country/create') }}" class="btn btn-primary btn-xs" title="Add Rate"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
</h1>
@endsection


@section('content')
<div class="container table table-responsive">
    <div class="col-md-6">

    </div>
    <div class="col-md-6">
        <div class="col-md-4">
            {{ Form::select('from', $country, null,['class' => 'form-control fromVal']) }}
        </div>
        <div class="col-md-4">
            {{ Form::select('to', $country, null,['class' => 'form-control toVal']) }}
        </div>
        <div class="col-md-4">
            <span id="convertedValue" class="form-control">0.00</span>
        </div>

    </div>
    <div class="table">
        <div class="pagination"> {!! $rate->render() !!} </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> {{ trans('FROM') }} </th>
                    <th> {{ trans('TO') }} </th>
                    <th> {{ trans('Rate(+/-)') }} </th>
                    <th> Action</th>
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
                    <td>
                        <a href="{{ url('/admin/country/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/admin/country', $item->id],
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
        <div class="pagination"> {!! $rate->render() !!} </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $('.fromVal').change();
    });
    $('.fromVal,.toVal').change(function () {
        var ajaxdata = {};
        ajaxdata['from'] = $('.fromVal').val();
        ajaxdata['to'] = $('.toVal').val();
        ajaxdata['amount'] = '1';
        ajaxdata['web'] = '1';
        $.ajax({
            type: "POST",
            url: "{{ url('/api/v1/currency/convert') }}",
            data: ajaxdata,
            dataType: 'json',
            success: function (data) {
                $('#convertedValue').html(data.converted);
            }
        });
    });

</script>

@endsection
