@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>

                <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('/formquestion') }}">
                       {{ csrf_field() }}
                      <table style="border-collapse: separate; border-spacing: 10px;">
                        
                        <tr>
                          <td style="width:200px">Course</td>
                      <td><select name = "course">
                      
                        <?php
                      $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
              
                      foreach ($user_groups as $user_group) {
                            $groups = DB::table('groups')->where('id', '=', $user_group->group_id)->get();
              
                              foreach ($groups as $group) {
                                    $course = $group->course;
                                    $isArchived = $group->isArchived;
                                
                                    if($isArchived==0)
                                    {
                                      echo '<option value="'.$course.'">'.$course.'</option>';
                                    }
                              }
                      }
                       ?>
                        
                      </select></td>
                        </tr>
                        
                        <tr><td>Type</td>
                         <td>
                            <input type="radio" name="type" value="SUBJECTIVE" onclick="displaySelectedRadio(this)" checked> Subjective &emsp;&emsp;
                            <input type="radio" name="type" value="OBJECTIVE" onclick="displaySelectedRadio(this)"> Objective 
                           </select>  
                         </td>
                        </tr>
                  
                  <tr>
                    <td style="width:200px">
                      <div id="dispSelectedRadioName" style="display:none;">
                        <span>Subtype</span>
                        </div>
                    </td>
                     <td>
                      <div id="dispSelectedRadio" style="display:none;">
                        <span><select name= "subtype">
                          <option value = "identification">Identification</option>
<!--                           <option value = "multipleChoice">Multiple Choice</option> -->
                          </select>
                        </span>
   <!--                           <br/>
                        <span># of choices</span>
                        <span><input type="number" name = "choiceCount" value='1' min="1" max="10"></input></span> -->
                         <br/>
                      </div>
                      
                    </td>
                  </tr>
                  <tr>
                    <td>Question</td>
                    <td><textarea name = "content" rows="6" cols="80" placeholder="Enter your question here." required></textarea>
                    </td>
                  </tr>
                  
                   <tr>
                     <td style="width:200px">
                    <div id="dispAnswerName" style="display:none;">
                    <span>Answer</span>
                    </div>
                  </td>
                  <td>
                    <div id="dispAnswer" style="display:none;">
                      <span><input type="text" name = "answer"></input></span>
                    </div>
                  </td>
                  </tr>
  
                  <script>
                    function displaySelectedRadio(id) {
                      //  To validate, check first if subjective is ticked true. If subjective != true && objective == true, then pass the values inside the dispSelectedRadio.div
                      // BUT if subjective == true and the inputs inside the div have values, DO NOT PASS.
                      
                      console.log(id.value);
                      if(id.value == 'OBJECTIVE')
                        {
                          document.getElementById("dispSelectedRadioName").style.display = "block";
                          document.getElementById("dispSelectedRadio").style.display = "block";
                          document.getElementById("dispAnswerName").style.display = "block";
                          document.getElementById("dispAnswer").style.display = "block";
                         
                        }
                      else
                        {
                          document.getElementById("dispSelectedRadioName").style.display = "none";
                           document.getElementById("dispSelectedRadio").style.display = "none";
                          document.getElementById("dispAnswerName").style.display = "none";
                           document.getElementById("dispAnswer").style.display = "none";
                        }
                       
                    }
                  </script>
                    <tr>
                      <td><br><br></td>
          
                    </tr>
                      <tr><td>
                      <input type="submit" value="Submit">
                        </td></tr>
                      </table>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
