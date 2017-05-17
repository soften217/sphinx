<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Join Group</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/addgroup')); ?>">
                       <?php echo e(csrf_field()); ?>

                       
                      PLEASE ENTER JOIN CODE:<br>
                      <input type="text" name="code" value="">
                      <br><br>
                      <input type="submit" value="Submit">
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD




=======
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>