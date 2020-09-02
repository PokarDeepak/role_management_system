@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Enquiry</h2>
            </div>
            <div class="pull-right">
                @can('enquiry-create')
                <a class="btn btn-success" href="{{ route('enquiries.create') }}"> Create New Enquiry</a>
                <a href="{{ URL::to('downloadEnquiry/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Description</th>
            <th>User</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($enquiries as $enquiry)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $enquiry->title }}</td>
	        <td>{{ $enquiry->description }}</td>
            <td>{{ $enquiry->getUsers->name }}</td>
	        <td>
                <form action="{{ route('enquiries.destroy',$enquiry->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('enquiries.show',$enquiry->id) }}">Show</a>
                    @can('enquiry-edit')
                    <a class="btn btn-primary" href="{{ route('enquiries.edit',$enquiry->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('enquiry-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $enquiries->links() !!}


@endsection