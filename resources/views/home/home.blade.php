<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{$title}}</title>
<style>
        #warning {
            color: red;
            display: none;
        }
    </style>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  var $jq = jQuery.noConflict();  // $jq bisa digunakan sebagai alias untuk jQuery
</script>
</head>

<body id="top">

  <main>


    <div class="wrapper">
      <!-- Sidebar -->
      @include('home.fitur')

      <!-- Page Content -->


      <div id="content">

        <button type="button" id="sidebarCollapse" class="btn btn-info" style="margin: 20px;border-radius:15px">
          <i class="fas fa-align-left"></i>
          <span><i class="bi bi-three-dots-vertical"></i> Menu </span>
        </button>| Halaman {{ $title }}


        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
          <div class="section-overlay-top"></div>


          <div class="container">
            <div class="row">

              <div class="col-lg-8 col-12 mx-auto">

                <div style="display: flex; justify-content: center;">
                  <img src="logo.png" alt="" class="logo-home">

                </div>
                @if (session()->has('search') && session('search') === false)
                @else
                <h6 class="text-center text-home ">Hallo Sobat {{ $store }} Sikahkan Presensi</h6>
                <center>

                  <small class="text-center ">Kode Presensi Digunakan <b class="text-danger">{{$kode_hari}}</b> Kode Presensi Berikutnya <b class="text-primary">{{$kode_hari+1}}</b> </small>
                  <br>
                  <p id="warning">Input hanya boleh dari Card Reader RFID!</p>
                </center>

    <div style="display: flex; justify-content: center;">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm mt-3" data-toggle="modal" data-target="#pmanual">
  <i class="bi bi-person-vcard"></i> Presensi Manual
</button>
</div>


<!-- Modal -->
<div class="modal fade" id="pmanual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Presensi Manual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <!-- Info password salah -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="infogagal" style="display:none;">
          <strong>Password Salah!</strong> Passwordmu salah, silahkan coba lagi.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Form input password -->
        <div id="inputpasswordm"> 
          <div class="form-group">
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <button type="button" class="btn btn-primary" id="submitPassword">Submit</button>
        </div>

        <!-- Form presensi manual -->
       <form id="formpresensim" style="display:none;" action="/add_presensi" enctype="multipart/form-data" method="post">
           @csrf
          <div class="form-group">
            <label for="exampleInputKTP">Masukan Nomor KTP Crew</label>
            <input type="number" class="form-control" id="exampleInputKTP" placeholder="Nomor KTP Crew" reqired>
            <input type="hidden" id="exampleNoCard" name="nomor" placeholder="Nomor Card" />

            <div id="dataCrewList" style="display:none; margin-top:20px;">
              <h5>Data Crew Ditemukan:</h5>
              <ul id="crewResults" class="list-group"></ul> <!-- List untuk menampilkan hasil pencarian -->
            </div>

            <label class="mt-3">Tanggal absen</label>
            <input type="date" class="form-control" name="tgl" reqired>

            <label class="mt-3">Jumlah total pembelian</label>
            <input type="number" class="form-control" name="belanja" reqired>
            
            <label class="mt-3">Bukti absen</label>
            <input type="file" class="form-control" name="image" reqired>
          </div>
          <button type="submit" class="btn btn-primary" id="btnPresensi" style="display:none;">Presensi</button>
        </form>


<script>

$jq(document).ready(function() {
  $jq('#exampleInputKTP').on('input', function() {
    let ktp = $jq(this).val();

    if (ktp.length > 5) {
      $jq.ajax({
        url: '/cari_cardm',
        type: 'GET',
        data: {
          ktp: ktp
        },
        success: function(response) {
          if (response.success && response.data.length > 0) {
            $jq('#dataCrewList').show();
            $jq('#crewResults').empty(); // Kosongkan list sebelum mengisi ulang

            // Iterasi hasil dan tambahkan item ke dalam ul sebagai li
            $jq.each(response.data, function(index, crew) {
              $jq('#crewResults').append(
                `<li class="list-group-item list-group-item-action" data-ktp="${crew.nik}" data-nomor="${crew.nomor}">${crew.nama} - ${crew.jk} - ${crew.asal}</li>`
              );
            });

            // Event listener untuk setiap li agar bisa diklik
            $jq('#crewResults li').on('click', function() {
              let selectedKTP = $jq(this).data('ktp');   // Ambil nomor KTP dari atribut data-ktp
              let selectedNomor = $jq(this).data('nomor'); // Ambil nomor dari atribut data-nomor
              
              // Update input dengan nomor KTP dan nomor kartu
              $jq('#exampleInputKTP').val(selectedKTP);  // Mengisi input KTP
              $jq('#exampleNoCard').val(selectedNomor);  // Mengisi input nomor kartu
              
              $jq('#crewResults').empty();  // Kosongkan list setelah dipilih
              $jq('#dataCrewList').hide();  // Sembunyikan list
              
               document.getElementById('btnPresensi').style.display = 'block';
            });

          } else {
            $jq('#dataCrewList').hide();
            $jq('#crewResults').empty();
            alert('Data tidak ditemukan');
          }
        },
        error: function() {
          alert('Terjadi kesalahan dalam mencari data.');
        }
      });
    } else {
      $jq('#dataCrewList').hide();
      $jq('#crewResults').empty();
    }
  });
});


  </script>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
// Password yang benar
{{-- const correctPassword = "11011"; --}}
const correctPassword = "123";

// Event listener untuk tombol submit password
document.getElementById('submitPassword').addEventListener('click', function() {
  const inputPassword = document.getElementById('exampleInputPassword1').value;

  if (inputPassword === correctPassword) {
    // Jika password benar, tampilkan form presensi manual dan sembunyikan form password
    document.getElementById('inputpasswordm').style.display = 'none';
    document.getElementById('formpresensim').style.display = 'block';
    document.getElementById('infogagal').style.display = 'none'; // Sembunyikan alert jika ada
  } else {
    // Jika password salah, tampilkan pesan gagal
    document.getElementById('infogagal').style.display = 'block';
  }
});

// Event listener untuk saat modal dibuka, reset tampilan
$('#pmanual').on('shown.bs.modal', function () {
  document.getElementById('inputpasswordm').style.display = 'block';
  document.getElementById('formpresensim').style.display = 'none';
  document.getElementById('infogagal').style.display = 'none';
});
</script>











                <div class="custom-form mt-4 pt-2 mb-lg-0 mb-5">
                  <form method="post" role="search" action="/add_presensi">
                    @csrf
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
                      <!--<input name="nomor" type="search" class="form-control" id="nomor" placeholder="Card ID..." aria-label="Search" autocomplete="off" autofocus required>-->
                      <!--<input name="nomor" type="search" class="form-control" id="nomor" placeholder="Card ID..." aria-label="Search" autocomplete="off" autofocus required>-->
        

<input name="nomor" type="search" class="form-control" id="nomor" placeholder="Card ID..." aria-label="Search" autofocus required>

<script>
  const inputField = document.getElementById('nomor');

  let inputTime = 0; // Waktu ketika input dimasukkan
  let inputContent = ''; // Konten input yang dimasukkan
  const threshold = 50; // Ambang batas waktu input dalam ms

  inputField.addEventListener('keydown', function (event) {
    const currentTime = new Date().getTime();

    // Jika waktu antara karakter yang dimasukkan terlalu lambat, anggap input berasal dari keyboard
    if (currentTime - inputTime > threshold) {
      inputContent = ''; // Reset jika input berasal dari keyboard
    }

    inputTime = currentTime;
    inputContent += event.key;

    // Jika inputnya bukan angka, cegah input
    if (isNaN(event.key) && event.key !== 'Backspace') {
      event.preventDefault();
    }
  });

  inputField.addEventListener('input', function () {
    // Periksa apakah input valid setelah dimasukkan
    if (inputContent.length > 0 && inputContent !== inputField.value) {
      alert('Input hanya bisa dari card reader!');
      inputField.value = ''; // Reset input
    }
  });
</script>


                      <button type="submit" class="form-control"><i class="bi bi-search"></i></button>

                    </div>
                  </form>

                </div>

                <!-- Tidak ada yang ditampilkan di sini karena nilai session 'search' adalah true -->
                @endif
              </div>
            </div>


        </section>




        @if (session()->has('gagal'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4 text-danger"><i class="bi bi-file-excel"></i> Kartu Belum Terdaftar</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('sudah_presensi'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> Kartu sudah melakukan presensi</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('gagal_update_card'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> ID Card Sudah Digunakan</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('gagal_update_card_max'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> Level ID Card Sudah Maksimal</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('berhasil_presensi'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Presensi</h1>

              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('berhasil_update_crew'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Update Data Crew</h1>

              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('berhasil_update_card'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Berhasil Update Card</h1>

              </div>

            </div>
          </div>



        </section>
        @endif


        @if (session()->has('info'))
        @include('home.info')
        @endif
        @if (session()->has('pres'))
        @include('home.presensi')
        @endif

        </form>

        @include('layout.footer')
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
  <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html>