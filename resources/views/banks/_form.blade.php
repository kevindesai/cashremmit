
<div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
    {!! Form::label('country_id', 'Country', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {{ Form::select('country_id', $country, null,['class' => 'form-control']) }}
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('branch') ? 'has-error' : ''}}">
    {!! Form::label('branch', 'Branch', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('branch', null, ['class' => 'form-control']) !!}
        {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('bank_code') ? 'has-error' : ''}}">
    {!! Form::label('bank_code', 'Bank Code', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('bank_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first('bank_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>
