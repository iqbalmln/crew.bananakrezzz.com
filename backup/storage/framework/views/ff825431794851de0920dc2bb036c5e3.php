<?php $__env->startSection('staf'); ?>

<div class="row">
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Kartu</h5>
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="fw-semibold mb-3"><?php echo e($jml_cards); ?> Kartu Terdaftar</h4>
                        <div class="d-flex align-items-center">
                            <div class="me-8">
                                <i class="bi bi-person-badge text-primary"></i>
                                <span class="fs-2"><?php echo e($card_presensi); ?> Kartu Dalam Transaksi </span><br>
                                <i class="bi bi-file-minus text-black"></i>
                                <span class="fs-2"> <?php echo e($card_presensi_no); ?> Kartu Belum Gunakan</span><br>
                                <small class="text-danger">*Data kartu keseluruhan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/kartu" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('master')): ?>
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Presensi Hari Ini</h5>
                <div class="d-flex align-items-center">
                    <div class="me-8">
                        <i class="bi bi-file-check-fill text-primary"></i>
                        <span class="fs-2"><?php echo e($transaksi_now); ?> Crew Melakukan Presensi Hari Ini</span>
                    </div>
                </div>
                <a href="/presensi_kartu" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Klaim Presensi</h5>
                <div class="d-flex align-items-center">
                    <div class="me-8">
                        <i class="bi bi-dropbox text-primary"></i>
                        <span class="fs-2"><?php echo e($klaim_presensi); ?> Crew Melakukan Klaim Presensi Hari Ini</span>
                    </div>

                </div>
                <a href="/klaim_presensi" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>

    <?php endif; ?>
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <div class="d-flex align-items-center">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('master')): ?>
                    <div class="me-8">
                        <i class="bi bi-person-fill text-primary"></i>
                        <span class="fs-2"><?php echo e($users); ?> Karyawan aktif</span><br>
                        <i class="bi bi-person-fill text-primary"></i>
                        <span class="fs-2"><?php echo e($marketing); ?> Marketng aktif</span>
                    </div>
                    <?php endif; ?>

                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('master')): ?>
                <a href="/users" class="btn btn-primary mt-3">Selengkapnya</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('master')): ?>
                <a href="/master.users" class="btn btn-primary mt-3">Selengkapnya</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <?php
    use Carbon\Carbon;
    $today = Carbon::now();
    $formattedDate = $today->format('l, d F Y');
    ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('master')): ?>
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Presensi Hari Ini "<?php echo e($formattedDate); ?>" di <?php echo e($store); ?>

                </h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Card Id</h6>
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
                                    <h6 class="fw-semibold mb-0">Nomor Handphone</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">PO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">BIRO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Belanja</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Marketing</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Keterangan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kode</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $presensis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pres): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->nomor); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->nik); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->nama); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->asal); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->jk); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->hp); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->card_id == $card->id): ?>
                                        <?php echo e($card->email); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php echo e($pres->po); ?>


                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php echo e($pres->biro); ?>


                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php echo e($pres->belanja); ?>


                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php $__currentLoopData = $mars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($pres->marketing_id == $mar->id): ?>
                                        <?php echo e($mar->nama); ?>

                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php echo e($pres->ket); ?>


                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        <?php echo e($pres->kode_hari); ?>


                                    </p>
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
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('staf.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/staf/home/index.blade.php ENDPATH**/ ?>