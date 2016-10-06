@extends('layouts.admin')

@section('header')

<h1>Transactions</h1>
@endsection
@section('content')
<div class="loader"></div>
<div class="container table table-responsive">
    <form>

        <div class="col-md-2 pull-right">
            <a href="{{ url('/admin/transaction') }}" class="btn btn-primary pull-right">Reset</a>
        </div>
        <div class="col-md-3 pull-right">
            <input type="text" name="search" placeholder="TXT No." value="<?php echo $searchTerm; ?>" class="form-control">
        </div>
    </form>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> 
                        {{ trans('User') }} 
                    </th>
                    <th> 
                        {{ trans('Recipiant') }} 
                    </th>
                    <th> {{ trans('Amount') }} </th>
                    <th>{{ trans('Currency Code') }}</th>
                    <th> {{ trans('Status') }} </th>
                    <th> {{ trans('Doc Status') }} </th>
                    <th class="col-md-2"> {{ trans('Ref No') }} </th>
                    <th> {{ trans('Date') }} </th>
                    <th> 
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($transaction as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->username }}
                    </td>
                    <td>{{ $item->receipentname }}
                    </td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->currency_code }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <?php
                        if ($item->user->is_verified == '1') {
                            ?>
                            <span class="label label-green">Verified</span>
                            <?php
                        } else {
                            ?>
                            <span class="label label-danger">Not Verified</span>
                            <?php
                        }
                        ?>

                    </td>
                    <td>{{ sprintf('%010d', $item->id) }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <?php
                            if(($item->user->is_verified == '1' && Auth::user()->user_type=="sub") || Auth::user()->user_type == 'admin'){ ?>
                               <a href="{{ url('/admin/transactions/' . $item->id) }}" class="btn btn-success btn-xs" title="View User"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a> 
                          <?php  }
                        ?>
                        
                        <?php
                        if ($item->status == 'success' && $item->switch_status != 'success' && $item->user->is_verified == '1') {
                            ?>
                            <a href="javascript:;" class="transfer label label-primary" data-id="<?php echo $item->id; ?>">Process Payment</a>
                            <?php
                        }
                        if ($item->user->is_verified != '1' && $item->switch_status != 'success') {
                            ?>
                            <a href="javascript:;" class="label label-orange" >Doc. Pending</a>
                            <?php
                        }
                        if ($item->switch_status == 'success') {
                            ?>
                            <span class="label label-green">Payment Completed</span>
                            <?php
                        }
                        ?>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $transaction->render() !!} </div>
    </div>

</div>
@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('.transfer').click(function (e) {
            e.preventDefault();
            if (confirm('Are you sure ?')) {
                var id = $(this).attr('data-id');

                $('.se-pre-con').show();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/admin/makeTransaction') }}" + "/" + id,
                    dataType: 'json',
                    success: function (data) {
                        alert(data.message);
                        $('.se-pre-con').hide();
                        if (data.status != '-1') {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection