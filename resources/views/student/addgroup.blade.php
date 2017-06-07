@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Join Group</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/addgroup') }}">
                       {{ csrf_field() }}

                      PLEASE ENTER JOIN CODE:<br>
                      <input type="text" name="code" value="" class="form-control">
                      <br><br>
                      <input type="submit" value="Submit" class="form-control">
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
