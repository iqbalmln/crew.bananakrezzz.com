<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registrasi Kartu Crew Banana Krezzz</title>

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




    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
      <div class="section-overlay-top"></div>


      <div class="container">
        <div class="row">

          <div class="col-lg-8 col-12 mx-auto">

            <h6 class="text-center text-home mt-5">Selemat Datang Marketing {{ Auth::user()->nama }}</h6>
            <center>

              <a href="/logout" class="text-center text-home "><i class="bi bi-arrow-left-circle"></i> Logout</a>
            </center>



            <p class="text-center text-home mt-5"> Informasi Absensi Crew</p>
            <!-- <div class="text-left">
              <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Filter
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Data Hari Ini</a>
                  <a class="dropdown-item" href="#">Data Minggu Ini</a>
                  <a class="dropdown-item" href="#">Data Bulan Ini</a>
                </div>
              </div>
            </div> -->
            <small class="text-home"><i class="bi bi-info-circle"></i> Data Diurutkan berdasarkan yang terbaru</small>

            <table class="table table-striped text-home">
              <thead>
                <tr>
                  <th scope="col">Card ID</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Waktu</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">PO</th>
                  <th scope="col">Fee</th>
                </tr>
              </thead> 
              <tbody>

                @foreach($presensis as $pres)


                <tr>
                  <td scope="row">
                    <button type="button" class="text-black" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                      @foreach($cards as $card)
                      @if($pres->card_id == $card->id)
                      {{ $card->nomor }}
                      @endif
                      @endforeach
                    </button>
                  </td>
                  <td scope="row">
                    <button type="button" class="text-black" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                      @foreach($cards as $card)
                      @if($pres->card_id == $card->id)
                      {{ $card->nama }}
                      @endif
                      @endforeach
                    </button>
                  </td>
                  <td scope="row">
                    <button type="button" class="text-black" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                      {{ $pres->waktu }}
                    </button>
                  </td>
                  <td>
                    <button type="button" class=" text-black" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                      {{ $pres->tgl }}
                    </button>
                  </td>
                  <td>
                    <button type="button" class="  text-black" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                      @foreach($cards as $card)
                      @if($pres->card_id == $card->id)
                      {{ $card->po }}
                      @endif
                      @endforeach

                    </button>
                  </td>
                  <td><span class=" badge rounded-pill bg-primary">

                      <button type="button" class="  text-white" data-toggle="modal" data-target="#exampleModalCenter{{ $pres->id }}" style="border: 0;background:none">
                        Rp. {{ $pres->fee }}
                      </button>
                    </span> </td>
                </tr>
                @endforeach

              </tbody>
            </table>



          </div>

        </div>
      </div>


    </section>


  </main>

  <footer class="site-footer section-padding ">
    <div class="container" style="margin-top: 300px;">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
          <h6 class="site-footer-title mb-3">Fitur</h6>

          <p class="text-white d-flex mb-1">


            <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#pass">
              Username/Password Login
            </button>

          </p>



        </div>
        <div class="col-lg-5 col-12 mb-4 pb-2">
          <a class="navbar-brand mb-2" href="index.html">
            <img src="logo.png" width="60px">
            <span>Banana Krezzz</span>
            <p class="copyright-text mt-lg-5 mt-0">
              Copyright © 2023 Banana Krezzz
            </p>
          </a>
        </div>




        <div class="col-lg-3 col-md-12 col-12 mt-0 mt-lg-0 ms-auto">

          <p class="copyright-text mt-lg-5 mt-0">

          </p>

        </div>

      </div>
    </div>
  </footer>

  <!-- Modal -->
  <div class="modal fade" id="pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Ubah Username/Password Login</h5>

        </div>
        <div class="modal-body">
          <p class="text-danger"><i class="bi bi-info-circle"></i> Untuk sekarang kamu hanya bisa mengubah username dan password dihalaman admin, silahkan menghubungi admin</p>
          <!-- <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>

          </form> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  </div>

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