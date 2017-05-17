@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <table>
            <tr>
            <td style="width:50px">
              <button onclick="goBack()"><<</button>
              </td>
              <td>
              Go back to Group Page
              </td>
            </tr>
          </table>
           <br>
            <div class="panel panel-default">
                <div class="panel-heading">Your grade is {{$correctAnswerCount}}</div>

                <div class="panel-body">
                     <table>
                       <tr>
                       <th width="50px">No.</th>
                       <th width= "200px">Correct Answer</th>
                       <th width= "200px">Your Answer</th>
                       <th width= "100px">Is Correct?</th>
                       </tr>
                       
                       <?php
                       
                       $count=1;
                       
                       foreach($arrayAnswerChecker as $arrayCheck)
                       {
                         echo '<tr>';
                         echo '<td>' . $count . '</td>';
                         echo '<td>' . $arrayAnswerChecker[$count]["correctAnswer"] . '</td>';
                         echo '<td>' . $arrayAnswerChecker[$count]["yourAnswer"] . '</td>';
                         
                         if($arrayAnswerChecker[$count]["isCorrect"]=="true")
                         {
                           echo '<td>YES</td>';
                         }
                         else if($arrayAnswerChecker[$count]["isCorrect"]=="SUBJECTIVE")
                         {
                           echo '<td>To be checked</td>';
                         }
                         else
                         {
                           echo '<td>NO</td>';
                         }
                         
                         echo '</tr>';
                         
                         $count++;
                       }
                       
                       ?>
                       
                  </table>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function goBack() {
                      window.location.href = "/group/{{$group_id}}";
                  }
</script>
@endsection
