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
                <?php if(session()->has('berhasil_update_crew')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update!</strong> Presensi Diupdate
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-4">Data Presensi Crew <?php echo e($store); ?></h5>
                    <form action="/presensi_kartu" method="get">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <small class="form-text text-muted">Start Date</small>
                                <input type="date" class="form-control" name="start_date" placeholder="Enter start date" value="<?php echo e(request()->input('start_date')); ?>" required>
                            </div>
                            <div class="col-md-5">
                                <small class="form-text text-muted">End Date</small>
                                <input type="date" class="form-control" name="end_date" placeholder="Enter end date" value="<?php echo e(request()->input('end_date')); ?>" required>
                            </div>
                            <div class="col-md-1 mt-3">
                                <input type="hidden" name="filter" value="1">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i></button>
                            </div>
                        </div>
                        <?php if(request()->input('filter') == 1): ?>
                        <a href="/presensi_kartu" class="form-text text-primary">Hapus filter</a>
                        <?php endif; ?>
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Presensi Pada</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">ID Kartu</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">NIK</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Asal</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Jenis Kelamin</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">PO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Bus</h6>
                                </th>

                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total Belanja</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Marketing</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Ket</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kode</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $users->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->waktu); ?> - <?php echo e($user->tgl); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->card_id==$card->id): ?>
                                        <?php echo e($card->nomor); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->card_id==$card->id): ?>
                                        <?php echo e($card->nik); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->card_id==$card->id): ?>
                                        <?php echo e($card->nama); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->card_id==$card->id): ?>
                                        <?php echo e($card->asal); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user->card_id==$card->id): ?>
                                        <?php echo e($card->jk); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->po); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->bus); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <!-- Button trigger modal -->

                                    <?php if($user->belanja!=""): ?>
                                    Rp. <?php echo e(number_format($user->belanja)); ?>

                                    <?php else: ?>
                                    Atur Total Belanja
                                    <?php endif; ?>


                                </td>
                                <td class="border-bottom-0">
                                    <!-- Button trigger modal -->

                                    <?php if($user->marketing_id!=""): ?>
                                    <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marketing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($user->marketing_id==$marketing->id): ?>
                                    <?php echo e($marketing->nama); ?>

                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    Pilih Marketing
                                    <?php endif; ?>


                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->ket); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php echo e($user->kode_hari); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#up.info<?php echo e($user->id); ?>">
                                            Update
                                        </button>
                                    </p>
                                    <!-- Modal -->
                                    <div class="modal fade" id="up.info<?php echo e($user->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Informasi Presensi</h5>
                                                </div>
                                                <form action="/update.belanja" method="post">
                                                    <?php echo csrf_field(); ?>


                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">PO</label>
                                                            <input type="text" name="po" class="form-control" value=" <?php echo e($user->po); ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Bus</label>
                                                            <input type="text" name="bus" class="form-control" value=" <?php echo e($user->bus); ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Total Belanja</label>
                                                            <input type="number" name="belanja" class="form-control" value="<?php echo e($user->belanja); ?>">
                                                            <small class="text-danger">*Masukan hanya angka tanpa titik atau simbol lainya</small>
                                                            <input type="hidden" name="presensi_id" class="form-control" value=" <?php echo e($user->id); ?>">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <select class="form-select" aria-label="Default select example" name="marketing">
                                                                <?php if($user->marketing_id!=""): ?>
                                                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marketing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($user->marketing_id==$marketing->id): ?>
                                                                <option value="<?php echo e($marketing->id); ?>">
                                                                    <?php echo e($marketing->nama); ?>

                                                                </option>
                                                                <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>
                                                                <option value="">
                                                                    Pilih Marketing
                                                                </option>
                                                                <?php endif; ?>
                                                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marketing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($user->marketing_id==$marketing->id): ?>
                                                                <?php echo e($marketing->nama); ?>

                                                                <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marketing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value=" <?php echo e($marketing->id); ?>"> <?php echo e($marketing->nama); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <option value=""> Hapus Marketing
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Keterangan</label>
                                                            <input type="text" name="ket" class="form-control" value=" <?php echo e($user->ket); ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                            </tr>
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
                <form method="post" action="/users.add">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" placeholder="Nama User" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nomor HP</label>
                        <input type="text" class="form-control" name="hp" placeholder="Nomor HP" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Level</label>
                        <select class="form-select" aria-label="Default select example" name="level" required>

                            <option value="admin">Admin</option>
                            <option value="staf" selected>Staf</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Username</label>
                        <input type="text" class="form-control  <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" placeholder="Username" required>
                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="text" class="form-control" name="password" placeholder="Password" required>
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
<?php echo $__env->make('staf.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/staf/users/presensi.blade.php ENDPATH**/ ?>