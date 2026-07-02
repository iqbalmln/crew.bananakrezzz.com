<section class="faq-section section-padding">

  <div class="container">

    <div class="row justify-content-center">



      <div class="col-lg-5 col-12 mb-3">
        <div class="custom-block custom-block-overlay">
          <div class="d-flex flex-column h-100">

            <div class="custom-block-overlay-text d-flex">
              <div>
               

                <table class="table">
                  <tbody>
                    <?php
                    $cards = session('cards') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                    ?>

                    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <th class="text-white">ID</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->nomor); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">NIK</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->nik); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">Nama</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->nama); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">Asal</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->asal); ?></td>
                    </tr>

                    <tr>
                      <th class="text-white">Jenis Kelamin</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->jk); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">Nomor Handphone</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->hp); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">Email</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->email); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">PO</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->po); ?></td>
                    </tr>
                    <tr>
                      <th class="text-white">Ditambahkan Pada</th>
                      <td class="text-white"></td>
                      <td class="text-white"><?php echo e($card->created_at); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </tbody>
                </table>


              </div>


            </div>


            <div class="section-overlay"></div>
          </div>
        </div>
      </div>


    </div>
  </div>
</section><?php /**PATH /home/u1567367/public_html/crew.bananakrezzz.com/resources/views/card/info.blade.php ENDPATH**/ ?>