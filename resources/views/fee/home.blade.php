<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Fee Crew Banana Krezzz</title>

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
            <h6 class="text-center text-home ">Atur Fee Crew</h6>
            <center>

              <a href="/presensi" class="text-center text-home "><i class="bi bi-arrow-left-circle"></i> Kembali</a>


              @if (session()->has('berhasil'))
              <div class="alert alert-primary alert-dismissible fade show mt-3 mb-3" role="alert">
                <strong>Berhasil Update Fee!</strong><br> Informasi fee crew bisa diakses oleh marketing yang bersangkutan
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              @endif
            </center>
            <form action="/fee.filter" method="get">
            @csrf
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <div class="dropdown">
                  <button class="btn btn-secondary btn-sm dropdown-toggle" style="border-radius: 40px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/fee.filter?filter=minggu">Data Minggu Ini</a>
                    <a class="dropdown-item" href="/fee.filter?filter=bulan">Data Bulan Ini</a>
                    <a class="dropdown-item" href="/fee">Hapus Filter</a>
                  </div>
                </div>
              </div>
               
              
              <input name="nomor" type="search" class="form-control" style="margin-left:20px"  placeholder="Cari Dengan Card ID..." aria-label="Search" autofocus required>
              <input name="filter" type="hidden" value="search">
              <div class="input-group-append">
                <button type="submit" class="form-control"><i class="bi bi-search"></i></button>
              </div>
            </div>
          </form>


            <small class="text-home "><i class="bi bi-info-circle"></i> {{ $info }}</small>


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


  @include('layout.footer')
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

<!-- Modal -->
@foreach($presensis as $pres)
<div class="modal fade" id="exampleModalCenter{{ $pres->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Crew</h5>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">


              <div class="custom-block custom-block-overlay">
                <div class="d-flex flex-column h-100">
                  <div class="custom-block-overlay-text " style="width: 100%; pointer-events: none;">
                    <div>
                      <h5 class="text-white mb-2">
                        @php
                        $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                        @endphp

                        @foreach($levels as $level)

                        @foreach($cards as $card)
                        @if($pres->card_id == $card->id)
                        @if($card->level == $level->id)
                        {{ $level->nama }}
                        @endif
                        @endif
                        @endforeach
                        @endforeach
                      </h5>

                      <table class="table">
                        <tbody>

                          <tr>
                            <th class="">Card ID</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->nomor }}
                              @endif
                              @endforeach
                            </td>
                          </tr>

                          <tr>
                            <th class="">Nama</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->nama }}
                              @endif
                              @endforeach
                            </td>
                          </tr>
                          <tr>
                            <th class="">Asal</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->asal }}
                              @endif
                              @endforeach
                            </td>
                          </tr>

                          <tr>
                            <th class="">Jenis Kelamin</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->jk }}
                              @endif
                              @endforeach
                            </td>
                          </tr>
                          <tr>
                            <th class="">Nomor Handphone</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->hp }}
                              @endif
                              @endforeach
                            </td>
                          </tr>
                          <tr>
                            <th class="">Email</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->email }}
                              @endif
                              @endforeach
                            </td>
                          </tr>
                          <tr>
                            <th class="">PO</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @if($pres->card_id == $card->id)
                              {{ $card->po }}
                              @endif
                              @endforeach
                            </td>
                          </tr>
                          <tr>
                            <th class="">Marketing</th>
                            <td class=""></td>
                            <td class="">
                              @foreach($cards as $card)
                              @foreach($users as $user)
                              @if($pres->card_id == $card->id)
                              @if($card->user_id == $user->id)
                              {{ $user->nama }}
                              @endif
                              @endif
                              @endforeach
                              @endforeach
                            </td>
                          </tr>

                        </tbody>
                      </table>


                    </div>


                  </div>

                  </a>
                  <div class="section-overlay"></div>
                </div>
              </div>
            </div>
            <form action="/fee_update" method="POST">
              @csrf
              <div class="form-group mt-3">
                <input type="number" class="form-control" id="fee" name="fee" aria-describedby="emailHelp" placeholder="Fee Crew" required>
                <small id="emailHelp" class="form-text text-muted">Fee crew harus sesuai dengan jumlah uang yang diterima crew, data fee bisa diakses oleh crew dan marketing</small>
              </div>


          </div>

        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="presensi_id" value="{{ $pres->id }}">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach

</html>