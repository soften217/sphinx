<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Create Group</div>

                <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/addgroup')); ?>">
                       <?php echo e(csrf_field()); ?>

                      <table style="border-collapse: separate; border-spacing: 10px;">
                      
                        <tr><td>Course:<br>
                         &emsp;<input type="text" name="course" value="">
                        </td></tr>
                        
                        <tr><td>Section:<br>
                          &emsp;<input type="text" name="section" value="">
                         </td></tr>
                        
                        <tr><td>Starting School Year:<br>
                          &emsp; <input type="number" name="year" value="2016" min=2016 style="width: 5em">
                          </td></tr>
                      
                        <tr><td>Term:<br>
                         &emsp; <input type="number" name="term" value="1" min=1 max=3>
                          </td></tr>
                      
                        <tr><td>
                          Schedule<br>
                       <table style="border-collapse: separate; border-spacing: 10px;">
                         <tr>
                           <td>
                                  Day:<br>
                              <select name="day">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                              </select>
                           </td>
                            <td>
                                  Time:<br>
                              <select name="time">
                                <option value="07:30AM-11:00AM">07:30AM-11:00AM</option>
                                <option value="11:00AM-02:30PM">11:00AM-02:30PM</option>
                                <option value="02:30PM-06:00PM">02:30PM-06:00PM</option>
                                <option value="06:00PM-09:30PM">06:00PM-09:30PM</option>
                              </select>
                           </td>
                         </tr>
                       </table>
                          </td></tr>
                      
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>