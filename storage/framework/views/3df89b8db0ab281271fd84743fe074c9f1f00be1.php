<?php $__env->startSection('content'); ?>
<div class="container table table-responsive">

    <h1>Users <a href="<?php echo e(url('/users/create')); ?>" class="btn btn-primary btn-xs" title="Add New User"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th> <?php echo e(trans('Firdt Name')); ?> </th><th> <?php echo e(trans('Last Name')); ?> </th><th> <?php echo e(trans('Unit No')); ?> </th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php /* */$x=0;/* */ ?>
            <?php foreach($users as $item): ?>
                <?php /* */$x++;/* */ ?>
                <tr>
                    <td><?php echo e($x); ?></td>
                    <td><?php echo e($item->first_name); ?></td><td><?php echo e($item->last_name); ?></td><td><?php echo e($item->unit_no); ?></td>
                    <td>
                        <a href="<?php echo e(url('/users/' . $item->id)); ?>" class="btn btn-success btn-xs" title="View User"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                        <a href="<?php echo e(url('/users/' . $item->id . '/edit')); ?>" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                        <?php echo Form::open([
                            'method'=>'DELETE',
                            'url' => ['/users', $item->id],
                            'style' => 'display:inline'
                        ]); ?>

                            <?php echo Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete User',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ));; ?>

                        <?php echo Form::close(); ?>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination"> <?php echo $users->render(); ?> </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>