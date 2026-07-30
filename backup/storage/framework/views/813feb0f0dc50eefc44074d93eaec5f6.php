<?php $__env->startSection('staf'); ?>

<div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">

            <div class="card-body p-4">
                <?php if(session()->has('user.add')): ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> User Ditambahkan
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>
                <?php if(session()->has('user.update')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update!</strong> User Diupdate
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <h5 class="card-title fw-semibold mb-4"> <i class="ti ti-user"></i> Data Marketing <?php echo e($store); ?></h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahuser1">
                    <i class="bi bi-person-add"></i> Tambah User
                </button>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">HP</h6>
                                </th>
                             
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Bergabung Pada</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->nama); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->hp); ?>

                                    </p>
                                </td>
                               
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->created_at); ?>

                                    </p>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detailuser<?php echo e($user->id); ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>

                            </tr>


                            <!-- Detail -->
                            <div class="modal fade" id="detailuser<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="detailuser<?php echo e($user->id); ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahuser">Detail User</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/marketing.update">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nama</label>
                                                    <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" value="<?php echo e($user->nama); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Nomor HP</label>
                                                    <input type="text" class="form-control" name="hp" value="<?php echo e($user->hp); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Lokasi</label>
                                                    <select class="form-select" aria-label="Default select example" name="store_id" required>
                                                        <?php $__currentLoopData = $lokasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($user->store_id==$lok->id): ?>
                                                        <option value="<?php echo e($lok->id); ?>"> <?php echo e($lok->nama); ?></option>
                                                        <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $__currentLoopData = $lokasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($lok->id); ?>"> <?php echo e($lok->nama); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                            <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ADD -->
<div class="modal fade" id="tambahuser1" tabindex="-1" role="dialog" aria-labelledby="tambahuser1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahuser">Tambah User</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="/marketing.add">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" placeholder="Nama User" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nomor HP</label>
                        <input type="text" class="form-control" name="hp" placeholder="Nomor HP" required>
                    </div>
                   


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staf.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u1567367/public_html/crew.bananakrezzz.com/resources/views/staf/users/marketing.blade.php ENDPATH**/ ?>