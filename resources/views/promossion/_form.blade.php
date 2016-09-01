
<div class="form-group ">
    {!! Form::label('code', trans('Code'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('code', null, ['class' => 'form-control', 'required'=>'required']) !!}
        {!! $errors->first('code', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group ">
    {!! Form::label('discount', trans('Discount'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('discount', null, ['class' => 'form-control', 'required'=>'required']) !!}
        {!! $errors->first('discount', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group ">
    {!! Form::label('is_enable', trans('Is Enable'), ['class' => 'col-sm-3 control-label', 'required'=>'required']) !!}
    <div class="col-sm-6">
        {{ Form::checkbox('is_enable','1',null) }}

        {!! $errors->first('is_enable', ' <span class="help-block">:message</span>') !!}
    </div>
</div>
