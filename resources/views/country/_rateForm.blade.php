<div class="form-group ">
    {!! Form::label('from', trans('From'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {{ Form::select('from', $country, null,['class' => 'form-control fromVal']) }}
        {!! $errors->first('first_name', ' <span class="help-block">:message</span>') !!}
    </div>
</div>


<div class="form-group ">
    {!! Form::label('to', trans('To'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {{ Form::select('to', $country, null,['class' => 'form-control toVal']) }}
        {!! $errors->first('first_name', ' <span class="help-block">:message</span>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('rate', trans('Rate.'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('rate', null, ['class' => 'form-control']) !!}
        {!! $errors->first('rate', ' <span class="help-block">:message</span>') !!}

    </div>
    <div class="col-md-3">
        <span id="convertedValue" class="form-control">0.00</span>
    </div>
</div>
