<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title>{{$title}}</title>

  <!-- CSS FILES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">

  <link href="src/css/bootstrap.min.css" rel="stylesheet">

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
      @include('home.fitur')

      <!-- Page Content -->


      <div id="content">

        <button type="button" id="sidebarCollapse" class="btn btn-info" style="margin: 20px;border-radius:15px">
          <i class="fas fa-align-left"></i>
          <span><i class="bi bi-three-dots-vertical"></i> Menu</span>
        </button>| Halaman {{ $title }}



        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
          <div class="section-overlay-top"></div>


          <div class="container">
            <div class="row">

              <div class="col-lg-8 col-12 mx-auto">

                <div style="display: flex; justify-content: center;">
                  <img src="logo.png" alt="" class="logo-home">

                </div>
                <h6 class="text-center text-home ">Cari Card</h6>
                <center>

                  <a href="/presensi" class="text-center text-home "><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                </center>

                <form method="get" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search" action="/cari_kartu_act">



                  <div class="input-group input-group-lg">

                    <span class="input-group-text" id="basic-addon1">
                      <i class="bi bi-search"></i>
                    </span>
                    <input name="nama" type="search" class="form-control" id="nama" placeholder="Tulis nama Crew / Nomor Kartu / NIK ..." value="{{ isset($nama) ? $nama : '' }}" aria-label="Search" autofocus required>

                    <!-- <input name="nama" type="search" class="form-control" id="nama" placeholder="Tulis nama Crew..." value="" aria-label="Search" autofocus required> -->
                    <button type="submit" class="form-control"><i class="bi bi-search"></i></button>

                  </div>
                </form>

              </div>

            </div>


        </section>


        @if (session()->has('sudah_regis'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-0 text-danger"><i class="bi bi-info-circle"></i> Kartu sudah terdaftar</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('berhasil_regis'))
        <section class="explore-section section-padding" id="section_2">
          <div class="container">
            <div class="row">

              <div class="col-12 text-center">
                <h6 class="mb-4"><i class="bi bi-check-circle"></i> Kartu Berhasil Terdaftar</h1>
              </div>

            </div>
          </div>



        </section>
        @endif

        @if (session()->has('hasil'))
        <section class="faq-section section-padding">

          <div class="container">

            <div class="row justify-content-center">



              @foreach($cards as $crew)

              <div class="col-lg-4 col-12 mb-3">
                <a href="/detail_card?nomor={{$crew->nomor}}">
                  <div class="custom-block custom-block-overlay">
                    <div class="d-flex flex-column h-100">

                      <div class="custom-block-overlay-text d-flex">
                        <div>


                          <table class="table">
                            <tbody>
                              <tr>
                                <th class="text-white">ID</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->nomor }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">NIK</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->nik }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">Nama</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->nama }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">Asal</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->asal }}</td>
                              </tr>

                              <tr>
                                <th class="text-white">Jenis Kelamin</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->jk }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">Nomor Handphone</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->hp }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">Email</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->email }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">PO</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->po }}</td>
                              </tr>
                              <tr>
                                <th class="text-white">Ditambahkan Pada</th>
                                <td class="text-white"></td>
                                <td class="text-white">{{ $crew->creatd_at }}</td>
                              </tr>


                            </tbody>

                          </table>

                        </div>
                        @php
                        $lastTgl = null;
                        @endphp

                        @foreach($presensis as $pren)
                        @if($crew->id == $pren->card_id)
                        @php
                        $lastTgl = $pren->tgl;
                        @endphp
                        @endif
                        @endforeach

                        @if(!is_null($lastTgl))
                        <small class="text-primary">*Terakhir melakukan presensi pada {{ $lastTgl }}</small>
                        @else
                        <small class="text-danger">*Belum melakukan presensi</small>
                        @endif


                        </small>
                </a>
              </div>


              <div class="section-overlay"></div>
            </div>
          </div>
      </div>

      @endforeach

    </div>
    </div>
    </section>


    @endif




    @include('layout.footer')

    </div>
    </div>
  </main>

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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>