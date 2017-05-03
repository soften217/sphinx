<?php $__env->startSection('content'); ?>

<!DOCTYPE html>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>


        <div class="container">
            <div class="content">
                <div class="title"><?php echo e($notify); ?></div>
                <a href="<?php echo e(URL::previous()); ?>">Go Back</a>
            </div>
        </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>