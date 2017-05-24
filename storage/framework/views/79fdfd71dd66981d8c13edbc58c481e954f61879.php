<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>

                <div class="panel-body">
<<<<<<< HEAD
                      <table>
                      <tr>
                       <th width=10%>Course <a href="/questionbank/cmpCourse" class="fa fa-sort" aria-hidden="true"></a></th>  
                        <th width=30%>Topic <a href="/questionbank/cmpTopic" class="fa fa-sort" aria-hidden="true"></a></th> 
                        <th width=11%>Type <a href="/questionbank/cmpType" class="fa fa-sort" aria-hidden="true"></a></th> 
                        <th width=15%>Subtype <a href="/questionbank/cmpSubType" class="fa fa-sort" aria-hidden="true"></a></th>
                         <th width=7%>ID <a href="/questionbank/cmpID" class="fa fa-sort" aria-hidden="true"></a></th> 
                        <th width=8%>Edit</th>
                        <th width=8%>Delete</th>
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
                        
                        
                      $questions = DB::table('questions')->where('isArchived', '!=', '1')->get();
                        
                        usort($questions, $sortBy);
                              
                              foreach ($questions as $question) {
                                    $course = $question->course;
                                    $type = $question->type;
                                    $subtype = $question->subtype;
                                    $id = $question->id;
                                    $topic = $question->topic;
                                    $content = $question->content;
                  
                                    echo '<tr> 
                                    <td title="'.$content.'"> '.$course .' </td>
                                    <td> '.$topic .' </td>
                                    <td> '.$type .' </td>
                                    <td> '.$subtype .' </td>
                                    <td> '.$id .' </td>
                                    <td><a href="/editquestion/' .$id. '">EDIT</a></td>
                                    <td><a href="/editquestion/' .$id. '/delete">DELETE</a></td>
                                    </tr>';
                              }
                  ?>
                   </table>
=======
                     <?php
                      $questions = DB::table('questions')->where('id', '<=', '100')->get();
              
                              foreach ($questions as $question) {
                                    $course = $question->course;
                                    $type = $question->type;
                                    $id = $question->id;
                                
                                    echo '<a href="/formquestion">'.$course.'-'.$type.'-'.$id.'</a><br>';
                              }
                  ?>
>>>>>>> b8dbc83003d74bbcad6f42be6a4a3550a5946e15
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>