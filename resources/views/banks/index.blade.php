@extends('layouts.admin')

@section('content')
<div class="">

    <h1>Banks <a href="{{ url('/admin/banks/create') }}" class="btn btn-primary btn-xs" title="Add New bank"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th> Country </th><th> Name </th><th> Branch </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($banks as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->country->country_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->branch }}</td>
                    <td>
                        <a href="{{ url('/admin/banks/' . $item->id) }}" class="btn btn-success btn-xs" title="View bank"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="{{ url('/admin/banks/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit bank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/banks', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete bank" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete bank',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));!!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $banks->render() !!} </div>
    </div>

</div>
@endsection
