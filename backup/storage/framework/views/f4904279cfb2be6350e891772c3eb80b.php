<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo e($title); ?></title>

  <style>
    /*
    DEMO STYLE
*/


    /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */


    /* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */
  </style>
  <!-- CSS FILES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">

  <link href="src/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link href="src/css/bootstrap-icons.css" rel="stylesheet">

  <link href="src/css/templatemo-topic-listing.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!--

TemplateMo 590 topic listing

https://templatemo.com/tm-590-topic-listing

-->
</head>

<body id="top">

  <main>


    <div class="wrapper">
      <!-- Sidebar -->
      <?php echo $__env->make('home.fitur', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <!-- Page Content -->


      <div id="content">

        <button type="button" id="sidebarCollapse" class="btn btn-info" style="margin: 20px;border-radius:15px">
          <i class="fas fa-align-left"></i>
          <span><i class="bi bi-three-dots-vertical"></i> Menu </span>
        </button>| Halaman <?php echo e($title); ?>



        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
          <div class="section-overlay-top"></div>


          <div class="container">
            <div class="row">

              <div class="col-lg-8 col-12 mx-auto">

                <div style="display: flex; justify-content: center;">
                  <img src="logo.png" alt="" class="logo-home">

                </div>
                <?php if(session()->has('search') && session('search') === false): ?>
                <?php else: ?>
                <h6 class="text-center text-home ">Hallo Sobat <?php echo e($store); ?> Sikahkan Presensi</h6>
                <center>

                  <small class="text-center ">Kode Presensi Digunakan <b class="text-danger"><?php echo e($kode_hari); ?></b> Kode Presensi Berikutnya <b class="text-primary"><?php echo e($kode_hari+1); ?></b> </small>
                </center>

                <div class="custom-form mt-4 pt-2 mb-lg-0 mb-5">
                  <form method="get" role="search" action="/add_presensi">
                    <?php echo csrf_field(); ?>
                    <!-- <div class="text-center text-home mb-3">
                  <div class="form-check ">
                    <input class="form-check-input" type="checkbox" value="1" name="presensi_double">
                    <label class="form-check-label" for="flexCheckDefault">
                      Presensi Lebih Dari 1x Dihari Yang Sama
                    </label>
                  </div>
                </div> -->


                    <div class="input-group input-group-lg">

                      <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-box-arrow-in-right"></i>
                      </span>

                      <input name="nomor" type="search" class="form-control" id="nomor" placeholder="Card ID..." aria-label="Search" autofocus required>

                      <button type="submit" class="form-control"><i class="bi bi-search"></i></button>

                    </div>
                  </form>

                </div>

                <!-- Tidak ada yang ditampilkan di sini karena nilai session 'search' adalah true -->
                <?php endif; ?>
              </div>
            </div>


        </section>




        <?php if(session()->has('gagal')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4 text-danger"><i class="bi bi-file-excel"></i> Kartu Belum Terdaftar</h1>
              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('sudah_presensi')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> Kartu sudah melakukan presensi</h1>
              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('gagal_update_card')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> ID Card Sudah Digunakan</h1>
              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('gagal_update_card_max')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> Level ID Card Sudah Maksimal</h1>
              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('berhasil_presensi')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Presensi</h1>

              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('berhasil_update_crew')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Update Data Crew</h1>

              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>

        <?php if(session()->has('berhasil_update_card')): ?>
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Update Card</h1>

              </div>

            </div>
          </div>



        </section>
        <?php endif; ?>


        <?php if(session()->has('info')): ?>
        <?php echo $__env->make('home.info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <?php if(session()->has('pres')): ?>
        <?php echo $__env->make('home.presensi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        </form>

        <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </main>
  </div>
  </div>

  <!-- Load jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Load Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
      });
    });
  </script>



  <!-- JAVASCRIPT FILES -->

  <script src="src/js/jquery.min.js"></script>
  <script src="src/js/bootstrap.bundle.min.js"></script>
  <script src="src/js/jquery.sticky.js"></script>
  <script src="src/js/click-scroll.js"></script>
  <script src="src/js/custom.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html><?php /**PATH /Users/macbook/Documents/aplikasi/crew_bk/resources/views/home/home.blade.php ENDPATH**/ ?>