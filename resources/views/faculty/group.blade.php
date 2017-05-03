@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$id}}</div>

                <div class="panel-body">
                    This is a sample FACULTY Group page.
                    <br><br><br><br><br>
                    JOIN CODE: <b><u>{{$code}}</u></b>.
                </div>
                <div class="panel-body" style="text-align:right">
                    
                  <?php
                    echo '<a href="/archive/'.$id.'"><i class="fa fa-btn fa-trash"></i>Archive this group</a>';
                  ?>
                </div>
            </div>
          
        </div>
                
    </div>
  
</div>
@endsection
