<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Help</div>

                <div class="panel-body">
                    <form method="post" action="./help">
                      <table>
                          <?php echo e(csrf_field()); ?>

                        <col width="20%">
                      <col width="80">
                        <tr>
                          <td>To: </td>
                          <td><input id='to' name='to' type='email' /></td>
                        </tr>
                        <tr>
                          <td>Subject: </td>
                          <td><input id='subject' name='subject' type='text' /></td>
                        </tr>
                        <tr>
                          <td> Message </td>
                          <td><input id='message' name="message" cols="50" rows="10"></input></td>
                        </tr>
                        
                      </table>
                        <button type="submit" value="Submit">Submit</button>
                      
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>