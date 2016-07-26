@extends('layouts.admin')
@section('header')
<h1>Transfer Rate</h1>

@endsection

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($transferrates, [
'method' => 'PATCH',
'url' => ['/admin/transferrate', $id],
'class' => 'form-horizontal',
'id'=>'myform'
]) !!}


<div class="form-group ">
    {!! Form::label('to', trans('Country'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <div class="form-control">
            <?php echo $country->country_name . "(" . $country->currency_code . ")"; ?>
            {!! Form::hidden('currency_code', $country->currency_code, ['class' => 'form-control', 'required'=>'required']) !!}
        </div>
    </div>
</div>

@include('transferrate._form')
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control save']) !!}
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
</script>
@endsection

