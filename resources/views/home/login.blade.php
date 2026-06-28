<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Presensi Crew Banana Krezzz</title>

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

            <div style="display: flex; justify-content: center;">
              <img src="logo.png" alt="" class="logo-home">

            </div>
            <h6 class="text-center text-home "> Sikahkan Login</h6>


          </div>

        </div>
      </div>


    </section>

    <section class="faq-section section-padding">

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-3 col-12 mb-0">
            @if (session()->has('gagal'))
            <div class="col-lg-12 col-12 mb-0">

              <div class="row justify-content-center">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Login Gagal, Username/Password Salah
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
            @endif
            @if (session()->has('logout'))
            <div class="col-lg-12 col-12 mb-0">

              <div class="row justify-content-center">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Berhasil Logout
                  <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
            @endif
            <div class="custom-block custom-block-overlay-login">
              <div class="d-flex flex-column h-50">

                <div class="custom-block-overlay-text">
                  <div>


                    <form class="col-lg-12 col-12" action="/auth" method="post">
                      @csrf
                      <div class="form-group">
                        <!-- <label for="exampleInputEmail1">Username</label> -->
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Username">
                      </div>
                      <div class="form-group mt-3">
                        <!-- <label for="exampleInputPassword1">Password</label> -->
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      </div>
                      
                      <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3 w-100">
                          <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                      </div>
                      <a href="" class="mt-5"> </a>
                    </form>


                  </div>

                </div>


                <div class="section-overlay"></div>
              </div>
            </div>

          </div>

        </div>
      </div>
      </div>
    </section>



  </main>

  <footer class="site-footer section-padding ">
    <div class="container" style="margin-top: 7%;">
      <div class="row">

        <div class="col-lg-5 col-12 mb-4 pb-2 mt-5">
          <a class="navbar-brand mb-2" href="index.html">
            <img src="logo.png" width="60px">
            <span>Banana Krezzz</span>
            <p class="copyright-text mt-lg-5 mt-0">
              Raya Solo - Tawangmangu, Gedangan, Salam,<br> Kec. Karangpandan, Kabupaten Karanganyar, Jawa Tengah 57791
            </p>
          </a>
        </div>




        <div class="col-lg-3 col-md-12 col-12 mt-0 mt-lg-0 ms-auto">

          <p class="copyright-text mt-lg-5 mt-0">Copyright © 2023 Banana Krezzz. All rights reserved.

          </p>

        </div>

      </div>
    </div>
  </footer>


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