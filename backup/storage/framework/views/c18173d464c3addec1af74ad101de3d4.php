<section class="explore-section section-padding" id="section_2">

  <div class="container">

    <div class="row">

      <div class="col-5">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">


            <div class="custom-block custom-block-overlay" style=" pointer-events: none;">
              <div class="d-flex flex-column h-100">
                <div class="custom-block-overlay-text " style="width: 100%;">
                  <div>
                    <!-- <h5 class="text-white mb-2">
                      <?php
                      $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                      ?>

                      <?php $__currentLoopData = $level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php echo e($card->nama); ?>

                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </h5> -->

                    <table class="table">
                      <tbody>

                        <?php
                        $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                        ?>

                        <?php $__currentLoopData = $crews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crew): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <th class="">Card ID</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->nomor); ?></td>
                        </tr>
                        <tr>
                          <th class="">NIK</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->nik); ?></td>
                        </tr>

                        <tr>
                          <th class="">Nama</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->nama); ?></td>
                        </tr>
                        <tr>
                          <th class="">Asal</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->asal); ?></td>
                        </tr>

                        <tr>
                          <th class="">Jenis Kelamin</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->jk); ?></td>
                        </tr>
                        <tr>
                          <th class="">Nomor Handphone</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->hp); ?></td>
                        </tr>
                        <tr>
                          <th class="">Email</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->email); ?></td>
                        </tr>
                        <tr>
                          <th class="">PO</th>
                          <td class=""></td>
                          <td class=""><?php echo e($crew->po); ?></td>
                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>


                  </div>


                </div>

                </a>
                <div class="section-overlay"></div>
              </div>
            </div>
          </div>
          <br>
          <button type="button" style="pointer-events: auto;border-radius:10px;" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit">
            Edit Informasi Crew
          </button>
          <!-- <button type="button" style="pointer-events: auto;border-radius:10px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reward">
            <i class="bi bi-file-arrow-up"></i> Upgrade Kartu
          </button> -->
          <div class="card mt-3" style="border-radius: 20px;">
            <div class="card-header bg-success">
              <label class="text-white text-center"><i class="bi bi-dropbox"></i> Klaim Reward</label>
            </div>
            <div class="card-body ">
              <h6 class="card-title"><i class="bi bi-clock-history"></i> Riwayat Klaim Reward</h6>

              <table class="table table-striped" style="font-size: 10px;">
                <thead>
                  <tr>
                    <th scope="col">Tgl</th>
                    <th scope="col">Presensi</th>
                    <th scope="col">Lokasi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $rewards = session('rewards') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                  ?>

                  <?php $__currentLoopData = $rewards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($reward->tgl); ?></td>
                    <td><?php echo e($reward->presensi); ?></td>
                    <td><?php echo e($reward->lokasi); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>

              <small class="card-text">Total presensi card saat ini adalah <?php echo e(session('presensi_reward')); ?>, minimal presensi harus <?php echo e(session('min_presensi')); ?> agar bisa melakukan klaim </small>

              <?php if(session('presensi_reward')>=session('min_presensi')): ?>
              <!-- Button trigger modal -->
              <center>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#klaim">
                  Klaim
                </button>
              </center>
              <!-- Modal -->
              <div class="modal fade" id="klaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Klaim Reward</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Berikut adalah presensi yang akan diklaim</p>
                      <table class="table table-striped" style="font-size: 15px;">
                        <thead>
                          <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Tanggal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $presensis_klaim = session('presensis_klaim') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                          ?>

                          <?php $__currentLoopData = $presensis_klaim; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $presensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($presensi->waktu); ?></td>
                            <td><?php echo e($presensi->tgl); ?></td>
                          </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                      </table>
                      <small class="text-danger">*Presensi yang sudah diklaim tidak bisa dikembakikan lagi</small>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <form method="get" action="/klaim_reward">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="card_id" value="<?php echo e($presensi->card_id); ?>">
                        <button type="submit" class="btn btn-primary">Klaim</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>


            </div>
          </div>
          <div class="card mt-3" style="border-radius: 20px;">
            <div class="card-header bg-info">
              <label class="text-white text-center">INFORMASI</label>
            </div>
            <div class="card-body ">
              <h6 class="card-title"><i class="bi bi-bookmark-star"></i> Total Kedatangan Keseluruhan</h6>
              <p class="card-text">Adalah total keseluruhan kedatangan crew</p>
              <h6 class="card-title"><i class="bi bi-bookmark-star"></i> Total Presensi Card</h6>
              <p class="card-text">Adalah total presensi yang melebihi ketentuan total belanja per presensi, presensi ini <label class="text-primary">DAPAT</label> ditukarkan dengan reward sesuai ketentuan yang berlaku</p>

              <h6 class="card-title"><i class="bi bi-bookmark-star"></i> Total Presensi Crew</h6>
              <p class="card-text">Adalah total presensi pemilik kartu, presensi ini <label class="text-danger">TIDAK</label> dapat ditukarkan dengan reward</p>

            </div>
          </div>
        </div>

      </div>
      <div class="col-7">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">



            <div class="d-flex shadow-lg" style="background-image: linear-gradient(40deg, #FEFF86 40%, #C58940 100%);border-radius:20px;">



              <div class="custom-block" style="width: 100%;">
                <div class="card-body">
                  <center>
                    <h5 class="card-title ">Informasi Kehadiran </h5>
                  </center>
                  <div class="row ">
                    <div class="col-sm-4">
                      <div class="" style="border-radius:50px;">
                        <div class="card-body">
                          <center>
                            <small class="card-text">Total Keseluruhan</small><br>
                            <a href="#" class="btn btn-warning"><?php echo e(session('jumlah')); ?></a>
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="" style="border-radius:50px;">
                        <div class="card-body">
                          <center>
                            <small class="card-text">Presensi Card</small><br>
                            <a href="#" class="btn btn-primary"><?php echo e(session('total_card')); ?></a>
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="card-body">
                        <center>
                          <small class="card-text">Presensi Crew</small><br>
                          <a href="#" class="btn btn-danger"><?php echo e(session('total_crew')); ?></a>
                        </center>
                      </div>
                    </div>
                  </div>
                  <table class="table table-striped" style="font-size: 13px;">
                    <thead>
                      <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $presensis = session('presensis') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                      ?>

                      <?php $__currentLoopData = $presensis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crew): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($index + 1); ?></th>
                        <td><?php echo e($crew->waktu); ?></td>
                        <td><?php echo e($crew->tgl); ?></td>
                        <td>
                          <?php
                          $stores = session('stores') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                          ?>
                          <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($crew->store_id==$store->id): ?>
                          <small><?php echo e($store->nama); ?></small>
                          <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                          <?php if($crew->status==''): ?>
                          <smal>Validasi Informasi</smal>
                          <?php if($crew->status==''): ?>
                          <button type="button" class="btn btn-info" style="border-radius: 50px;" data-toggle="modal" data-target="#total_belanja<?php echo e($crew->id); ?>"><i class="bi bi-arrow-repeat"></i> </button>

                          <!-- Modal -->
                          <div class="modal fade" id="total_belanja<?php echo e($crew->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Total Belanja</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="/add_belanja" method="post">
                                  <?php echo csrf_field(); ?>

                                  <div class="modal-body">
                                    <div class="form-group">
                                      <p><i class="bi bi-clock"></i> <?php echo e($crew->waktu); ?><br>
                                        <i class="bi bi-calendar-check"></i> <?php echo e($crew->tgl); ?>

                                      </p>
                                      <input type="number" name="belanja" class="form-control" placeholder="Masukan Total Belanja">
                                      <input type="hidden" name="presensi_id" value="<?php echo e($crew->id); ?>">
                                      <input type="hidden" name="card_id" value="<?php echo e($crew->card_id); ?>">
                                      <small id="emailHelp" class="form-text text-muted">Hanya masukan angka dan tanpa titik</small>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>

                          <?php endif; ?>
                          <?php endif; ?>
                          <?php if($crew->status==1): ?>
                          <small class="text-danger">Presensi Crew</small>
                          <?php endif; ?>
                          <?php if($crew->status==2): ?>
                          <small class="text-primary"> Presensi Card
                            <?php if($crew->reward==true): ?>
                            <span class="badge badge-success">Klaim</span>

                            <?php endif; ?>
                          </small>
                          <?php endif; ?>

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
      </div>
</section>


<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Crew</h5>

      </div>
      <div class="modal-body">
        <form method="post" action="/cerew_update">
          <?php echo csrf_field(); ?>
          <?php
          $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
          ?>

          <?php $__currentLoopData = $crews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crew): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Card ID</label>
            <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo e($crew->nomor); ?>" disabled>
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Card Level</label>
            <input type="text" class="form-control" id="exampleInputEmail1" value="  <?php
                      $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                      ?>

                      <?php $__currentLoopData = $level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php echo e($card->nama); ?>

                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" disabled>
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">NIK</label>
            <input type="text" class="form-control" name="nik" value="<?php echo e($crew->nik); ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" name="nama" value="<?php echo e($crew->nama); ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Asal</label>
            <input type="text" class="form-control" name="asal" value="<?php echo e($crew->asal); ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Jenis Kelamin</label>
            <input type="text" class="form-control" name="jk" value="<?php echo e($crew->jk); ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Nomor Handphone</label>
            <input type="text" class="form-control" name="hp" value="<?php echo e($crew->hp); ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" name="email" value="<?php echo e($crew->email); ?>">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">PO</label>
            <input type="text" class="form-control" name="po" value="<?php echo e($crew->po); ?>">
          </div>
          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Marketing</label>
            <select class="form-select" aria-label="Default select example" name="user_id">
              <?php
              $marketing = session('marketing') ?? [];
              
              ?>
              <?php $__currentLoopData = $marketing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option selected value="<?php echo e($mark->id); ?>">
                <?php echo e($mark->nama); ?>

              </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <option value="">Pilih Marketing</option>
              <?php
                $marketings = session('marketings') ?? [];
                ?>
                <?php $__currentLoopData = $marketings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
              <option value="<?php echo e($mark->id); ?>"><?php echo e($mark->nama); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div> -->
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


      </div>
      <div class="modal-footer">
        <input type="hidden" name="id_card" value="<?php echo e($crew->id); ?>">
        <input type="hidden" name="nomor" value="<?php echo e($crew->nomor); ?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upgrade Kartu</h5>

      </div>
      <div class="modal-body">
        <form method="post" action="/card_update">
          <?php echo csrf_field(); ?>
          <div class="" style="width: 100%;">
            <div class="card-body">

              <p class="card-text">Level Kartu Saat Ini Adalah
                <?php
                $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                ?>

                <?php $__currentLoopData = $level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($card->nama); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </p>

              <div class="form-group">

                <input type="text" class="form-control" name="nomor" placeholder="ID Card Baru" required>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">

        <input type="hidden" name="id_card" value="<?php echo e($crew->id); ?>">
        <input type="hidden" name="id_card_old" value="<?php echo e($crew->id); ?>">
        <input type="hidden" name="level" value="<?php echo e($crew->level); ?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upgrade Kartu</button>
      </div>
      </form>
    </div>
  </div>
</div><?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views//home/presensi.blade.php ENDPATH**/ ?>