
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
    {!! Form::label('branch', 'Attributes', ['class' => 'col-sm-3 control-label']) !!}

    <div class="col-sm-6">
        <?php
        $attrs = [];
        $validations = [
            'alpha_num' => 'alpha_num',
            'text' => 'text',
            'numaric' => 'numaric',
        ];
        if (isset($bank)) {

            $attrs = json_decode($bank->attributes, true);
            if (is_array($attrs)) {
                foreach ($attrs as $k => $val) {
                    ?>
                    <div class="atr">
                        <div class="col-md-5">
                            <input type="text" name="attr[]" value="<?php echo $val['name']; ?>" class="form-control"  >
                        </div>
                        <div class="col-md-5">
                            {{ Form::select('validation[]', $validations, $val['validation'],['class' => 'form-control']) }}
                            <!--<input type="text" name="validation[]" value="<?php echo $val['validation']; ?>" class="form-control" required="required" >-->
                        </div>
                        <?php
                        if ($k != '0') {
                            ?>
                            <a class="remove col-md-2 btn btn-danger" href="#" onclick="$(this).parent().slideUp(function () {
                                                    $(this).remove()
                                                });
                                                return false">remove</a>
                               <?php
                           }
                           ?>

                    </div>
                    <?php
                }
            }
        }
        if (!count($attrs) || !isset($bank)) {
            ?>
            <div class="atr">
                <div class="col-md-5">
                    <input type="text" name="attr[]" class="form-control" >
                </div>
                <div class="col-md-5">
                    {{ Form::select('validation[]', $validations, null,['class' => 'form-control']) }}
                </div>
            </div>
            <?php
        }
        ?>

    </div>
    <p><a href="#" class="copy btn btn-primary" rel=".atr">Add MOre</a></p>
</div>

<script>
    var removeLink = '<a class="remove col-md-2 btn btn-danger" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">remove</a>';
    $(document).ready(function () {
        $('a.copy').relCopy({append: removeLink});
    });

</script>