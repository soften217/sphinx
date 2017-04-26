@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>

                <div class="panel-body">
                     <?php
                      $questions = DB::table('questions')->where('id', '<=', '100')->get();
              
                              foreach ($questions as $question) {
                                    $course = $question->course;
                                    $type = $question->type;
                                    $id = $question->id;
                                
                                    echo '<a href="/formquestion">'.$course.'-'.$type.'-'.$id.'</a><br>';
                              }
                  ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
