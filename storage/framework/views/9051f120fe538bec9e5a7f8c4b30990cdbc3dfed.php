<?php $__env->startSection('content'); ?>

<h1>Create New User</h1>
<hr/>
<?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php echo Form::open(['url' => '/users', 'class' => 'form-horizontal','id'=>'myform']); ?>


<div class="form-group ">
    <?php echo Form::label('first_name', trans('First Name'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('first_name', null, ['class' => 'form-control', 'required'=>'required']); ?>

        <?php echo $errors->first('first_name', ' <span class="help-block">:message</span>'); ?>

    </div>
</div>
<div class="form-group ">
    <?php echo Form::label('last_name', trans('Last Name'), ['class' => 'col-sm-3 control-label', 'required'=>'required']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('last_name', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('last_name', ' <span class="help-block">:message</span>'); ?>

    </div>
</div>
<div class="form-group ">
    <?php echo Form::label('email', trans('Email'), ['class' => 'col-sm-3 control-label', 'required'=>'required']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('email', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('email', ' <span class="help-block">:message</span>'); ?>

    </div>
</div>
<div class="form-group ">
    <?php echo Form::label('unit_no', trans('Unit No.'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('unit_no', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('unit_no', ' <span class="help-block">:message</span>'); ?>

    </div>
</div>
<div class="form-group">
    <?php echo Form::label('building_name', trans('Building Name'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('building_name', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('building_name', ' <span class="help-block">:message</span>'); ?>

    </div>
</div>
<div class="form-group">
    <?php echo Form::label('city', trans('City'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('city', null, ['class' => 'form-control', 'required'=>'required']); ?>

        <?php echo $errors->first('city', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('region', trans('Region'), ['class' => 'col-sm-3 control-label', 'required'=>'required']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('region', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('region', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('street', trans('Street'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::textarea('street', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('street', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('post_code', trans('Post Code'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('post_code', null, ['class' => 'form-control', 'required'=>'required']); ?>

        <?php echo $errors->first('post_code', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('country', trans('Country'), ['class' => 'col-sm-3 control-label', 'required'=>'required']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('country', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('country', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('dob', trans('Date Of Birth'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::date('dob', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('dob', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('mobile_no', trans('Mobile No.'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('mobile_no', null, ['class' => 'form-control', 'data-parsley-type'=>'digits']); ?>

        <?php echo $errors->first('mobile_no', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>
<div class="form-group">
    <?php echo Form::label('landline_no', trans('Lanline No.'), ['class' => 'col-sm-3 control-label']); ?>

    <div class="col-sm-6">
        <?php echo Form::text('landline_no', null, ['class' => 'form-control']); ?>

        <?php echo $errors->first('landline_no', ' <span class="help-block">:message</span>'); ?>

        
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-3 col-sm-3">
        <?php echo Form::submit('Create', ['class' => 'btn btn-primary form-control save']); ?>

    </div>
</div>
<?php echo Form::close(); ?>



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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>