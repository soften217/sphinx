@extends('layouts.app')

@section('content')

<style>
.headcol {
 position: relative; /*  absolute */
	width: 20%;
  }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{$id}}</div>

                <div class="panel-body">
                  
                  List of Students Enrolled in this Group: <br><br>
                 
                  <?php
                  $countlist = 1;
                  
                  echo '<table width="100%" style="padding:15px; text-align:left; display: block; overflow-x: auto; align: right;"><tr>';
                  echo '<th class="headcol" rowspan="2" style="padding:15px; text-align:left; border: 1px solid black;"> Student Name </th>';
									
									echo '<th style="padding:15px; text-align:center; border: 1px solid black;" class="headcol" colspan="'.count($exams).'"> Exam/Quiz Grades</th></tr>';
                  
                  $arranged_exam = array();
                  
									echo '<tr>';
                  foreach($exams as $exam)
                  {
                    echo '<th style="text-align:center; border: 1px solid black;"> '. $exam->name .' </th>';
                  }
                  echo '</tr>';
                  
                  if(count($members)==1){
                      echo '<td style="padding:15px; text-align:left; border: 1px solid black;">';
                      echo 'There are no students enrolled in this group.';
                      echo '</td>';
                    
                    foreach($exams as $exam)
                    {
                      echo '<td style="padding:15px; text-align:left; border: 1px solid black;"></td>';
                    }
                      echo '</tr>';
                  }
                  else
                  {
                
                  
                      for($var = 0; $var < count($members); $var++)
                      {
                        echo '<tr id="list">';

                        if($members[$var]['isFaculty'] != 1)
                        {
                          echo '<td class="headcol" style="padding:15px; text-align:left; border: 1px solid black;">';
                          echo $countlist . '. ';
                          echo $members[$var]['name'];
                          echo '</td>';

                          $exam_users = DB::table('exam_user')->where('user_id', '=', $members[$var]['id'])->get();

                          if((empty($exam_users)))
                          {
                            foreach($exams as $exam)
                            {
                              echo '<td style="padding:10px; text-align:center; border: 1px solid black;"> NA </td>'; 
                            }

                          }
                          else
                          {
                            foreach($exams as $exam)
                            {
                              $found = false;
                              foreach($exam_users as $exam_user)
                              {

                                    if($exam->id == $exam_user->exam_id)
                                    {
                                      echo '<td style="padding:10px; text-align:center; border: 1px solid black;">'; 
																			
																			if($exam->totalSubjPts != 0 && $exam_user->toBeChecked != 0)
																			{
																				echo '<a href="/getstudentresult/'.$exam_user->user_id.'/'.$exam->id.'">';
																				echo '??';
																			}
																			else
																			{
																				if($exam->totalSubjPts == 0)
																				{
																					echo '<a href="/getstudentresult/'.$exam_user->user_id.'/'.$exam->id.'">';
																					echo $exam_user->obj_score;
																				}
																				else
																				{
																					echo '<a href="/getstudentresult/'.$exam_user->user_id.'/'.$exam->id.'">';
																					echo ($exam_user->obj_score+$exam_user->subj_score);
																				}
																				
																			}
																			
																			if($exam->totalSubjPts == 0)
																			{
																				echo '/'. $exam->totalObjPts;
																			}
																			else if($exam->totalObjPts == 0)
																			{
																				echo '/'. $exam->totalSubjPts;
																				if($exam_user->toBeChecked != 0) 
																				{
																					echo '</a> &nbsp&nbsp<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
																				}
																				else
																				{
																					echo '</a> &nbsp&nbsp<i class="fa fa-check" aria-hidden="true"></i>';
																				}
																			}
																			else
																			{
																				echo '/'. ($exam->totalObjPts+$exam->totalSubjPts);
																				if($exam_user->toBeChecked != 0) 
																				{
																					echo '</a> &nbsp&nbsp<i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
																				}
																				else
																				{
																					echo '</a> &nbsp&nbsp<i class="fa fa-check" aria-hidden="true"></i>';
																				}
																			}
																			
																			echo '</td>'; 
                                      $found = true;
                                    }
                              }
                              if($found == false)
                              {
                                echo '<td style="padding:15px; text-align:center; border: 1px solid black;"> NA </td>'; 
                              }
                              else {
                                $found = false;
                              }

                                }
                              }
                          $countlist++;
                          echo '</tr>';
                        }
                      }
                  }
                  echo '</table>';
                  ?>
                    <br><br><br><br><br>
                    JOIN CODE: <b><u>{{$code}}</u></b>.
                </div>
                <div class="panel-body" style="text-align:right">
                  
                  <script>
                    function deletearchive()
                    {
                                      swal({
                    title: "Delete this Group?",
                    text: "This group will no longer be accessible once deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                  },
                  function(){
                    window.location = "/archive/{{$id}}";
                  });  
                    }
                    
                  </script>
                  <button onclick="deletearchive()" value="DELETE"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">List of Exams/Quizzes for this group</div>

                <div class="panel-body">
                    <table style="width: 100%; text-align: center" >
                      <tr id="list" style="text-align: center;">
                        <th style="text-align: center;" width=15%>Name</th>
                        <th style="text-align: center;" width=20%> Topic</th>
                        <th style="text-align: center;" width=15%> Duration</th>
                        <th style="text-align: center;" width=20%> Date</th>
                        <th style="text-align: center;" width=10%>View</th>
                        <th style="text-align: center;" width=10%>Delete</th>

                      </tr>
 
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                  
                              foreach ($exams as $exam) {
                                
                                if($exam->isArchived==0)
                                {
                                  $exam_id = $exam->id;
                                  
                                  if($exam->duration < 60000) {
                                    $duration = round(($exam->duration / 1000), 2) ; 
                                    $time = 'Seconds';
                                  }
                                  else if($exam->duration < 3600000){
                                  $duration = round(($exam->duration / 60000), 2) ; 
                                  $time = 'Minutes';
                                  } else {
                                  $duration = round(($exam->duration / 3600000), 2) ; 
                                  $time = 'Hours';
                                  }
                                  
                                  $availabledate = $exam->schedule;
                                  $topic = $exam->topic;
																	$name = $exam->name;
																	
                                    echo '<tr id="list" style="align: justify;"> 
                                    <td> '.$name .' </td>';
                                   	echo '<td> '.$topic.'</td>';
                                    echo '<td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td align="center"><a href="/viewexam/'.$id.'/'.$exam_id.'"><i class="fa fa-search" aria-hidden="true"></i></a></td>
                                    <td align="center"><a href="javascript:void(0)" onclick="confirmDelete('.$exam_id.');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                    </tr>';
                                }
                              }
                  ?>
                   </table>
                </div>
              
              <div class="panel-body">
                  <script>
                    function createQuiz()
                    {
                                      swal({
                    title: "Go to Exam Creation Window?",
                    text: "If yes, you will be redirected to a new page.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                  },
                  function(){
                    window.location = "/createquiz/{{$id}}";
                  });  
                    }
                  </script>
                
								<script>
                    function confirmDelete(exam_id_pass)
                    {
                                      swal({
                    title: "Delete this Exam/Quiz?",
                    text: "This exam will no longer appear in your group exam list once it is deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                                       
                  },
                  function(){
                       window.location = "/deleteexam/{{$id}}/"+exam_id_pass;              
                  });  
                    }
                  </script>
                  
                  <button onclick="createQuiz()" value="CREATE">Create New Questionnaire</button>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
