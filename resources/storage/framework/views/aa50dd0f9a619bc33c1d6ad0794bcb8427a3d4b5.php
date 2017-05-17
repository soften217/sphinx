<?php echo Form::open([]); ?>


    <?php echo Form::text('name', @$name); ?>


    <?php echo Form::password('password'); ?>


    <?php echo Form::submit('Send'); ?>


    <?php echo Form::close(); ?>