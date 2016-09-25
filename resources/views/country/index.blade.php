@extends('layouts.admin')

@section('header')

<h1>Country</h1>
@endsection


@section('content')
<div class="container table table-responsive">

    <form>

        <div class="col-md-2 pull-right">
            <a href="{{ url('/admin/country') }}" class="btn btn-primary pull-right">Reset</a>
        </div>
        <div class="col-md-3 pull-right">
            <input type="text" name="search" placeholder="search" value="<?php echo $searchTerm; ?>" class="form-control">
        </div>
    </form>
    <div class="table">

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> 
                        {{ trans('Country Name') }} 


                    </th>
                    <th> {{ trans('Country Code') }} </th>
                    <th> {{ trans('Currency Name') }} </th>
                    <th>{{ trans('Currency Code') }}</th>
                    <th>{{ trans('Status') }}</th>

                </tr>
            </thead>
            <tbody>
                {{-- */$x=0;/* --}}
                @foreach($country as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->country_name }}
                        <img src="{{ $item->logo24 }}" height="32px" width="32px" alt="{{ $item->country_code }}" />
                    </td>
                    <td>{{ $item->country_code }}</td>
                    <td>{{ $item->currency_name }}</td>
                    <td>{{ $item->currency_code }}</td>
                    <td>
                        <?php
                        if ($item->status) {
                            ?>
                            <a href="javascript:;" class="btn-sm btn-primary change" data-id="{{ $item->id }}" data-status="0">Active</a>    
                            <?php
                        } else {
                            ?>
                            <a href="javascript:;" class="btn-sm btn-danger-alt change" data-id="{{ $item->id }}" data-status="1">Inactive</a>    
                            <?php
                        }
                        ?>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $country->appends(['search' => $searchTerm])->render() !!} </div>
    </div>

</div>
@endsection



@section('script')
<script>
    $(document).ready(function () {
        $('.change').click(function (e) {
            e.preventDefault();
            if (confirm('Are you sure ?')) {
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');

                $('.se-pre-con').show();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/admin/changeCountryStatus') }}" + "/" + id + "/" + status,
                    dataType: 'json',
                    success: function (data) {
                        alert(data.message);
                        $('.se-pre-con').hide();
                        if (data.status == '1') {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection