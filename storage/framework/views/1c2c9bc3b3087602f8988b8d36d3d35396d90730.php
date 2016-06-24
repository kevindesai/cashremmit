<?php $__env->startSection('content'); ?>
<div class="container">

    <h1><?php echo e($user->first_name); ?></h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
<!--                <tr>
                    <th>ID.</th><td><?php echo e($user->id); ?></td>
                </tr>-->
                <tr><th> <?php echo e(trans('First Name')); ?> </th><td> <?php echo e($user->first_name); ?> </td></tr><tr><th> <?php echo e(trans('Last Name')); ?> </th><td> <?php echo e($user->last_name); ?> </td></tr><tr><th> <?php echo e(trans('Unit No.')); ?> </th><td> <?php echo e($user->unit_no); ?> </td></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <a href="<?php echo e(url('users/' . $user->id . '/edit')); ?>" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        <?php echo Form::open([
                            'method'=>'DELETE',
                            'url' => ['users', $user->id],
                            'style' => 'display:inline'
                        ]); ?>

                            <?php echo Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete User',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));; ?>

                        <?php echo Form::close(); ?>

                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>