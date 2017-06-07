@extends('layouts.app')

@section('content')

<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 150px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 40%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>
              
              <script type="text/javascript">

               function changeFunc() {
                var selectBox = document.getElementById("course");
                var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                 
                window.location = "/questionbank/"+selectedValue+"/cmpID";
               }

              </script>

                <div class="panel-body">
                  Please select a course: &nbsp; &nbsp;
                    <select name = "course" id = "course" onchange="changeFunc();">
                      
                        <?php
                      $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
                      
                      $coursesList = array();
                      
                      foreach ($user_groups as $user_group) {
                            $groups = DB::table('groups')->where('id', '=', $user_group->group_id)->get();
              
                              foreach ($groups as $group) {
                                    $done=false;
                                    $course = $group->course;
                                    $isArchived = $group->isArchived;
                                    
                                    foreach($coursesList as $courseList)
                                    {
                                      if($course==$courseList)
                                      {
                                        $done=true;
                                      }
                                    }
                                    if($isArchived==0 && $done==false)
                                    {
                                      if($course==$courseQ)
                                      {
                                        echo '<option value="'.$course.'" selected>'.$course.'</option>';
                                      }
                                      else
                                      {
                                        echo '<option value="'.$course.'">'.$course.'</option>';
                                      }
                                    }
                                    $coursesList[]=$course;
                              }
                      }
                       ?>
                        
                      </select>
                  <br><br>
                      <table>
                      <tr>
<!--                        <th width=10%>Course <a href="/questionbank/cmpCourse" class="fa fa-sort" aria-hidden="true"></a></th>   -->
                        <th width=1%>Preview</th> 
                        <th width=1%>ID <a href="/questionbank/{{$courseQ}}/cmpID" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=15%>Topic <a href="/questionbank/{{$courseQ}}/cmpTopic" class="fa fa-sort" aria-hidden="true"></a></th> 
                        <th width=10%>Type <a href="/questionbank/{{$courseQ}}/cmpType" class="fa fa-sort" aria-hidden="true"></a></th> 
                        <th width=10%>Subtype <a href="/questionbank/{{$courseQ}}/cmpSubType" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=10%>Created by <a href="/questionbank/{{$courseQ}}/cmpCreator" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=10%>D-Index <a href="/questionbank/{{$courseQ}}/cmpCreator" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=10%>D-Level <a href="/questionbank/{{$courseQ}}/cmpCreator" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=10%>Taken<br>Count <a href="/questionbank/{{$courseQ}}/cmpCreator" class="fa fa-sort" aria-hidden="true"></a></th>
                        <th width=4%>Edit</th>
                        <th width=4%>Delete</th>
                      </tr>
                        
                    
                     <?php
                        function cmpCourse($a, $b)
                        {
                            return strcmp($a->course, $b->course);
                        }
                        
                        function cmpType($a, $b)
                        {
                            return strcmp($a->type, $b->type);
                        }
                        
                        function cmpSubType($a, $b)
                        {
                            return strcmp($a->subtype, $b->subtype);
                        }
                        
                         function cmpID($a, $b)
                        {
                            return $a->id - $b->id;
                        }
                        
                        function cmpTopic($a, $b)
                        {
                            return strcmp($a->topic, $b->topic);
                        }
                        
                        function cmpCreator($a, $b)
                        {
                            return strcmp($a->creator_id, $b->creator_id);
                        }
                        
                        
                      $questions = DB::table('questions')->where('isArchived', '!=', '1')->where('course', '=', $courseQ)->get();
                        
                        usort($questions, $sortBy);
                        
                              foreach ($questions as $question) {
//                                     $course = $question->course;
                                    $type = $question->type;
                                    $subtype = $question->subtype;
                                    $id = $question->id;
                                    $topic = $question->topic;
                                    $content = $question->content;
                                    $creator_id = $question->creator_id;
                                    $takenCount = $question->takenCount;
                                    $dis_index = $question->dis_index;
                                    $dif_level = $question->dif_level;
                                    
                                    $creator = DB::table('users')->where('id', '=', $creator_id)->first();
                  
                                    echo '<tr id="list">
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" > <a title="'.$content.'" id-number="'.$id .'" class="btn btn-default" href="javascript:void(0)" onclick="previewQuestion(this.getAttribute(\'title\'), this.getAttribute(\'id-number\'));"><i class="fa fa-search" aria-hidden="true"></i></a> </td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" > '.$id .' </td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;"> <span id="topic" title="'.$content.'">'.$topic .'</span> </td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" > '.$type .' </td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" >'.$subtype .'</td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" >'.$creator->name .'</td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" >'.$dis_index .'</td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" >'.$dif_level .'</td>
                                    <td style="border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;" >'.$takenCount .'</td>
                                    <td style="border: 1px solid gray;" ><ul><li><a style="text-decoration: none;" href="/editquestion/' .$id. '">EDIT</a></li></ul></td>
                                    <td style="border: 1px solid gray;" ><ul><li><a style="text-decoration: none;" href="javascript:void(0)" onclick="confirmDelete('.$id.');">DELETE</a></li></ul></td>
                                    </tr>';
                              }
                  ?>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 id="previewHeader">Question Preview</h2>
    </div>
    <div class="modal-body">
      <p id="questionContent">Some text in the Modal Body</p>
    </div>
<!--     <div class="modal-footer">
      <h3>Preview</h3>
    </div> -->
  </div>
</div>

<script type="text/javascript">
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function() {
//     modal.style.display = "block";
// }

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script type="text/javascript">
function previewQuestion(qcontent, idnumber)
  {
    document.getElementById('previewHeader').innerHTML = "Question #" + idnumber + " Preview";
    document.getElementById('questionContent').innerHTML = qcontent;
    modal.style.display = "block";
  }
</script>

<script>
                    function confirmDelete(q_id)
                    {
                                      swal({
                    title: "Delete this Question?",
                    text: "If yes, this question will be removed from the Question Bank.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                                       
                  },
                  function(){
                       window.location = "/editquestion/"+q_id+"/delete";   
                                        
                  });  
                    }
                  </script>
@endsection
