
<div class="form-group ">
    {!! Form::label('to', trans('Country'), ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <div class="form-control">
            <?php echo $country->country_name; ?>
            {!! Form::hidden('currency_code', $country->currency_code, ['class' => 'form-control', 'required'=>'required']) !!}
        </div>
    </div>
</div>
<div class="container table table-responsive">
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th> {{ trans('From') }} </th>
                    <th> {{ trans('To') }} </th>
                    <th> {{ trans('Rate')." (" . $country->currency_code.")" }} </th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($transferrates as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>
                        {!! Form::text('from[]', $item->from, ['class' => 'form-control', 'required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::text('to[]', $item->to, ['class' => 'form-control', 'required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::text('rate[]', $item->rate, ['class' => 'form-control', 'required'=>'required']) !!}
                    </td>
                </tr>
                @endforeach
                <?php
                if ($x < 4) {
                    for ($i = $x; $i < 4; $i++) {
                        ?>
                        <tr>
                            <td>
                                {!! Form::text('from[]', null, ['class' => 'form-control', 'required'=>'required']) !!}
                            </td>
                            <td>
                                {!! Form::text('to[]', null, ['class' => 'form-control', 'required'=>'required']) !!}
                            </td>
                            <td>
                                {!! Form::text('rate[]', null, ['class' => 'form-control', 'required'=>'required']) !!}
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>