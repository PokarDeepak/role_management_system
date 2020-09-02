@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Enquiry</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('enquiries.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('enquiries.store') }}" method="POST">
    	@csrf


         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Title:</strong>
		            <input type="text" name="title" class="form-control" placeholder="Title">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea id="charNum" class="form-control" style="height:150px" maxlength="120" name="description" placeholder="Description"></textarea>
                    <!-- <span>Character Count: </span><span id="charCount">0</span><span> /120</span> -->
		        </div>
		    </div>
            @if(auth()->user()->roles()->first()->name == App\User::ADMIN_VAL)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Assign:</strong>
                    <select class="form-control" name="user_id">
                        <option>Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @else
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            @endif
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>

        <script>
          // function countChar(val) {
          //   var len = val.value.length;
          //   console.log(len);
          //   $("#charCount").text(len);
          //   if (len >= 120) {
          //       alert("You have entered max Character");
          //   }
          // };
        </script>
    </form>

@endsection