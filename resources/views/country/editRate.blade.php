@extends('layouts.admin')

@section('header')
<h1>Manage Rate</h1>

@endsection


@section('content')

<hr/>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{!! Form::model($currency, [
'method' => 'PATCH',
'url' => ['/admin/country', $currency->id],
'class' => 'form-horizontal',
'id'=>'myform'
]) !!}

@include('country._rateForm')

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit('Update', ['class' => 'btn btn-primary form-control save']) !!}
    </div>
</div>
{!! Form::close() !!}

@endsection

@section('script')
<script>
    window.ParsleyConfig = {
        successClass: 'has-success'
        , errorClass: 'has-error'
        , errorElem: '<span></span>'
        , errorsWrapper: '<span class="help-block"></span>'
        , errorTemplate: "<div></div>"
        , classHandler: function (el) {
            return el.$element.closest(".form-group");
        }
    };
    $(document).ready(function () {
        $('.save').click(function (e) {
            e.preventDefault();
            var form = $('#myform').parsley();
            form.validate();
            if (form.isValid()) {
                $('#myform').submit();
            }
        });
    });
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
