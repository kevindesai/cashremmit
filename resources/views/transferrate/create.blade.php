@extends('layouts.admin')

@section('content')

<h1>Manage Transfer Rate</h1>
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

{!! Form::open(['url' => '/admin/transferrate', 'class' => 'form-horizontal','id'=>'myform']) !!}
@include('transferrate._form')

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        {!! Form::submit('Create', ['class' => 'btn btn-primary form-control save']) !!}
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
             if(form.isValid()){
                 $('#myform').submit();
             }
        });
    });
</script>
@endsection
