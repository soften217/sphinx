@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>

                <div class="panel-body">
                      <table>
                      <tr>
                       <th width=20%>Course </th>  
                        <th width=20%>Type</th> 
                         <th width=10%>ID</th> 
                        <th width=25%>Edit</th>
                        <th width=25%>Delete</th>
                      </tr>
                        
                    
                     <?php
                      $questions = DB::table('questions')->where('isArchived', '!=', '1')->get();
              
                  
                              foreach ($questions as $question) {
                                    $course = $question->course;
                                    $type = $question->type;
                                    $id = $question->id;
                  
                                    echo '<tr> 
                                    <td> '.$course .' </td>
                                    <td> '.$type .' </td>
                                    <td> '.$id .' </td>
                                    <td><a href="/editquestion/' .$id. '">EDIT</a></td>
                                    <td><a href="/editquestion/' .$id. '/delete">DELETE</a></td>
                                    </tr>';
                              }
                  ?>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
