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
                <div class="panel-heading">Viewing Exam ID number {{$id}}</div>

                <div class="panel-body">
                     <table>
                       <tr>
                       <th width="50px">No.</th>
                       <th width= "600px">Question</th>
                       <th width= "200px">Answer</th>
                       </tr>
                       
                       <?php
                       
                       $count=1;
                       
                       foreach($arrayQuestions as $arrayQuestion)
                       {
                         echo '<tr>';
                         echo '<td>' . $count . '</td>';
                         echo '<td>' . $arrayQuestions[$count-1]["content"] . '</td>';
                         echo '<td>' . $arrayQuestions[$count-1]["answer"] . '</td>';
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
                      window.history.back();
                  }
</script>
@endsection
