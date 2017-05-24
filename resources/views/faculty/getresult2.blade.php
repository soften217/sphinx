@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
<!--           <table>
            <tr>
            <td style="width:50px">
              <button onclick="goBack()"><<</button>
              </td>
              <td>
              Go back to Group Page
              </td>
            </tr>
          </table> -->
           <br>
            <div class="panel panel-default">
                <div class="panel-heading">Exam/Quiz Results of STUDENT for EXAM</div>

                <div class="panel-body">
                   <form class="form-horizontal" role="form" method="POST" action="{{ url('/updategrades') }}">
                     <table>
                       <tr>
                       <th width="5%">No.</th>
                       <th width="30%">Questions</th>
                       <th width= "20%">Correct Answer</th>
                       <th width= "30%">Your Answer</th>
                       <th width= "5%">Is Correct?</th>
                       <th width= "10%">Points Earned</th>
                       </tr>
                       
                       <?php
                       
                       if(empty($questionsArray))
                       {
                         echo 'hello';
                       }
                       
                       $count=0;
                       
                      foreach($questionsArray as $question){
                        echo $question->content;
                      }
                       
                       ?>
                       <tr><td>
                      <input type="submit" value="Update Grades">
                        </td></tr>
                       
                  </table>
                  </form>
                </div>
            </div>
        </div>
    </div>

@endsection
