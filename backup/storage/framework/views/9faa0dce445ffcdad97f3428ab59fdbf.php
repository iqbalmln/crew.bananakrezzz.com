<section class="faq-section section-padding">

  <div class="container">

    <div class="row justify-content-center">

      <div class="container">
        <div class="row">

          <div class="col-12 text-center">
            <h6 class="mb-4">Data Crew Ganda, Pilih Salah Satu</h1>
          </div>

        </div>
      </div>
      <?php
      $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
      ?>

      <?php $__currentLoopData = $crews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crew): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-lg-5 col-12 mb-3">
        <div class="custom-block custom-block-overlay">
          <div class="d-flex flex-column h-100">
            <a href="/add_presensi_id?id=<?php echo e($crew->id); ?>">
              <div class="custom-block-overlay-text d-flex">
                <div>
                  <h5 class="text-white mb-2">
                    <?php
                    $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                    ?>

                    <?php $__currentLoopData = $level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($card->nama); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </h5>

                  <table class="table">
                    <tbody>

                      <tr>
                        <th class="text-white">Nama</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->nama); ?></td>
                      </tr>
                      <tr>
                        <th class="text-white">Asal</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->asal); ?></td>
                      </tr>

                      <tr>
                        <th class="text-white">Jenis Kelamin</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->sk); ?></td>
                      </tr>
                      <tr>
                        <th class="text-white">Nomor Handphone</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->hp); ?></td>
                      </tr>
                      <tr>
                        <th class="text-white">Email</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->email); ?></td>
                      </tr>
                      <tr>
                        <th class="text-white">PO</th>
                        <td class="text-white"></td>
                        <td class="text-white"><?php echo e($crew->po); ?></td>
                      </tr>
                    </tbody>
                  </table>


                </div>
                <span class="badge bg-finance rounded-pill ms-auto badge-lg">
                  <?php
                  $jumlah = session('jumlah') ?? [];

                  ?>
                  <?php
                  $cardCount = $jumlah->where('card_id', $crew->id)->count();
                  ?>

                  <?php echo e($cardCount); ?>


                </span>

              </div>

            </a>
            <div class="section-overlay"></div>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



    </div>
  </div>
  </div>
</section><?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/home/info.blade.php ENDPATH**/ ?>