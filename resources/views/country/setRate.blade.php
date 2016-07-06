@extends('layouts.admin')

@section('content')

<h1>Manage Rate</h1>
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

{!! Form::open(['url' => 'country', 'class' => 'form-horizontal','id'=>'myform']) !!}


<div class="form-group ">
    {!! Form::label('from', trans('From'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {{ Form::select('from', $country, null,['class' => 'form-control']) }}
        {!! $errors->first('first_name', ' <span class="help-block">:message</span>') !!}
    </div>
</div>


<div class="form-group ">
    {!! Form::label('to', trans('To'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {{ Form::select('to', $country, null,['class' => 'form-control']) }}
        {!! $errors->first('first_name', ' <span class="help-block">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('rate', trans('Rate.'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('rate', null, ['class' => 'form-control']) !!}
        {!! $errors->first('rate', ' <span class="help-block">:message</span>') !!}
        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit('Create', ['class' => 'btn btn-primary form-control save']) !!}
    </div>
</div>
{!! Form::close() !!}


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
