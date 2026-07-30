<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<h2>Laporan Presensi <?php echo e($store); ?></h2>
<p>Data diambil dari tanggal <?php echo e($start_date); ?> sampai <?php echo e($end_date); ?></p>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID CARD</th>
            <th scope="col">TANGGAL</th>
            <th scope="col">PO</th>
            <th scope="col">BIRO</th>
            <th scope="col">JUMLAH BUS</th>
            <th scope="col">TOTAL BELANJA</th>
            <th scope="col">MARKETING</th>
            <th scope="col">KETERANGAN</th>
            <th scope="col">KODE HARI</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $presensis->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td>
                <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($card->id == $presensi->card_id): ?>
                <?php echo e($card->nomor); ?>

                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td><?php echo e($presensi->tgl); ?></td>
            <td><?php echo e($presensi->po); ?></td>
            <td><?php echo e($presensi->biro); ?></td>
            <td><?php echo e($presensi->bus); ?></td>
            <td><?php echo e($presensi->belanja); ?></td>
            <td>
                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($m->id == $presensi->marketing_id): ?>
                <?php echo e($m->nama); ?>

                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td><?php echo e($presensi->ket); ?></td>
            <td><?php echo e($presensi->kode_hari); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/staf/export/presensi.blade.php ENDPATH**/ ?>