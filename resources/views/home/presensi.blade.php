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
                    <h5 class="text-black mb-2">
                    Informasi Crew
                    </h5>

                    <table class="table">
                      <tbody>
                        @php
                        $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                        @endphp

                        @foreach($crews as $crew)
                        <tr>
                          <th class="">Card ID</th>
                          <td class=""></td>
                          <td class="">{{ $crew->nomor }}</td>
                        </tr>
                        <tr>
                          <th class="">NIK</th>
                          <td class=""></td>
                          <td class="">{{ $crew->nik }}</td>
                        </tr>

                        <tr>
                          <th class="">Nama</th>
                          <td class=""></td>
                          <td class="">{{ $crew->nama }}</td>
                        </tr>
                        <tr>
                          <th class="">Asal</th>
                          <td class=""></td>
                          <td class="">{{ $crew->asal }}</td>
                        </tr>

                        <tr>
                          <th class="">Jenis Kelamin</th>
                          <td class=""></td>
                          <td class="">{{ $crew->jk }}</td>
                        </tr>
                        <tr>
                          <th class="">Nomor Handphone</th>
                          <td class=""></td>
                          <td class="">{{ $crew->hp }}</td>
                        </tr>
                        <tr>
                          <th class="">Email</th>
                          <td class=""></td>
                          <td class="">{{ $crew->email }}</td>
                        </tr>


                        @endforeach
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
                  @php
                  $rewards = session('rewards') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                  @endphp

                  @foreach($rewards as $index => $reward)
                  <tr>
                    <td>{{ $reward->tgl }}</td>
                    <td>{{ $reward->presensi }}</td>
                    <td>{{ $reward->lokasi }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <small class="card-text">Total presensi card saat ini adalah {{ session('presensi_reward') }}, minimal presensi harus {{ session('min_presensi') }} agar bisa melakukan klaim </small>

              @if(session('presensi_reward')>=session('min_presensi'))
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
                          <form method="get" action="/klaim_reward">

                            @php
                            $presensis_klaim = session('presensis_klaim') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                            @endphp

                            @foreach($presensis_klaim as $index => $presensi)
                            <input type="hidden" name="card_id" value="{{ $presensi->card_id }}">
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>{{ $presensi->waktu }}</td>
                              <td>{{ $presensi->tgl }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <small class="text-danger">*Presensi yang sudah diklaim tidak bisa dikembakikan lagi</small>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                      <button type="submit" class="btn btn-primary">Klaim</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endif


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
                <div class="card-body" style="width: 100%; overflow-x: auto;">
                  <center>
                    <h5 class="card-title ">Informasi Kehadiran </h5>
                  </center>
                  <div class="row ">
                    <div class="col-sm-4">
                      <div class="" style="border-radius:50px;">
                        <div class="card-body">
                          <center>
                            <small class="card-text">Total Keseluruhan</small><br>
                            <a href="#" class="btn btn-warning">{{ session('jumlah') }}</a>
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="" style="border-radius:50px;">
                        <div class="card-body">
                          <center>
                            <small class="card-text">Presensi Card</small><br>
                            <a href="#" class="btn btn-primary">{{ session('total_card') }}</a>
                          </center>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="card-body">
                        <center>
                          <small class="card-text">Presensi Crew</small><br>
                          <a href="#" class="btn btn-danger">{{ session('total_crew') }}</a>
                        </center>
                      </div>
                    </div>
                  </div>
                  <table class="table table-striped" style="font-size: 13px;">
                    <thead>
                      <tr>

                        <th scope="col">Waktu</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">PO</th>
                        <th scope="col">Biro</th>
                        <th scope="col">Bus</th>
                        <th scope="col">Belanja</th>
                        <th scope="col">Ket</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $presensis = session('presensis') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                      @endphp

                      @foreach($presensis as $index => $crew)
                      <tr>

                        <td>{{ $crew->waktu }}</td>
                        <td>{{ $crew->tgl }}</td>
                        <td>
                          @php
                          $stores = session('stores') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                          @endphp
                          @foreach($stores as $index => $store)
                          @if($crew->store_id==$store->id)
                          <small>{{ $store->nama }}</small>
                          @endif
                          @endforeach
                        </td>
                        <td>{{ $crew->po }}</td>
                        <td>{{ $crew->biro }}</td>
                        <td>{{ $crew->bus }}</td>
                        <td>{{ number_format($crew->belanja) }}</td>

                        <td>{{ $crew->ket }}</td>
                        <td>
                          @if($crew->status=='')
                          <smal>Validasi Informasi</smal>
                          @endif
                          @if($crew->status==1)
                          <small class="text-danger">Presensi Crew</small>
                          @endif
                          @if($crew->status==2)
                          <small class="text-primary"> Presensi Card
                            @if($crew->reward==true)
                            <span class="badge badge-success">Klaim</span>

                            @endif
                          </small>
                          @endif

                        </td>
                        <td>


                          <button type="button" class="btn btn-info" style="border-radius: 50px;" data-toggle="modal" data-target="#total_belanja{{ $crew->id }}"><i class="bi bi-arrow-repeat"></i> </button>

                          <!-- Modal -->
                          <div class="modal fade" id="total_belanja{{ $crew->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Validasi Informasi</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="/add_belanja" method="post">
                                  @csrf

                                  <div class="modal-body">
                                    <div class="form-group">
                                      <h6 class="text-center ">Kode Presensi Digunakan <b class="text-danger">{{$kode_hari}}</b> Kode Presensi Berikutnya <b class="text-primary">{{$kode_hari+1}}</b> </h6><br>

                                      <p><i class="bi bi-clock"></i> {{ $crew->waktu }}<br>
                                        <i class="bi bi-calendar-check"></i> {{ $crew->tgl }}
                                      </p>
                                      <label>Kode Presensi</label>
                                      <input type="number" name="kode_hari" class="form-control" placeholder="Masukan Kode Presensi" value="{{ $crew->kode_hari }}" required>
                                      @if($crew->kode_hari && $crew->created_at->format('Y-m-d') === now()->format('Y-m-d'))
                                      <div class="card card-body mt-1">
                                        Presensi hari ini yang mengunakan kode presensi {{ $crew->kode_hari }}
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th scope="col">Waktu</th>
                                              <th scope="col">PO</th>
                                              <th scope="col">Biro</th>
                                              <th scope="col">Bus</th>
                                              <th scope="col">Belanja</th>
                                              <th scope="col">Ket</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <form method="get" action="/klaim_reward">


                                              @foreach($presensi_hari as $hariItem)
                                              @if($hariItem->kode_hari === $crew->kode_hari)
                                             
                                              <tr>
                                                <td>{{ $hariItem->waktu }} - {{ $hariItem->tgl }}</td>
                                                <td>{{ $hariItem->po }}</td>
                                                <td>{{ $hariItem->biro }}</td>
                                                <td>{{ $hariItem->bus }}</td>
                                                <td>Rp. {{ $hariItem->belanja }}</td>
                                                <td>{{ $hariItem->ket }}</td>
                                              </tr>
                                              @endif
                                              @endforeach



                                          </tbody>
                                        </table>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="1" name="sinkron">
                                          <label class="form-check-label" for="flexCheckDefault">
                                            Sinkronkan Informasi Crew
                                          </label>
                                        </div>
                                        <input type="hidden" name="kode_hari" value="{{ $crew->kode_hari }}">
                                      </div>
                                      @endif

                                     
                                      <label>PO Bus</label>
                                      <input type="text" name="po" class="form-control" placeholder="Masukan PO Bus" value="{{ $crew->po }}" required>
                                      <label>Biro Bus</label>
                                      <input type="text" name="biro" class="form-control" placeholder="Masukan Biro " value="{{ $crew->biro }}" required>
                                      <label>Jumlah Bus</label>
                                      <input type="text" name="bus" class="form-control" placeholder="Masukan Jumlah Bus" value="{{ $crew->bus }}" required>
                                      <label>Total Belanja</label>
                                      <input type="number" name="belanja" class="form-control" placeholder="Masukan Total Belanja" value="{{ $crew->belanja }}">
                                      <small id="emailHelp" class="form-text text-muted">Hanya masukan angka dan tanpa titik/koma</small>
                                      <label>Keterangan</label>
                                      <input type="text" name="ket" class="form-control" placeholder="Masukan Keterangan" value="{{ $crew->ket }}" required>
                                      <input type="hidden" name="presensi_id" value="{{ $crew->id }}">
                                      <input type="hidden" name="card_id" value="{{ $crew->card_id }}">

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




                        </td>
                      </tr>

                      @endforeach

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
          @csrf
          @php
          $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
          @endphp

          @foreach($crews as $crew)
          <div class="form-group">
            <label for="exampleInputEmail1">Card ID</label>
            <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $crew->nomor }}" disabled>
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Card Level</label>
            <input type="text" class="form-control" id="exampleInputEmail1" value="  @php
                      $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                      @endphp

                      @foreach($level as $card)
                      {{ $card->nama }}
                      @endforeach" disabled>
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">NIK</label>
            <input type="text" class="form-control" name="nik" value="{{ $crew->nik }}" required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ $crew->nama }}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Asal</label>
            <input type="text" class="form-control" name="asal" value="{{ $crew->asal }}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Jenis Kelamin</label>
            <input type="text" class="form-control" name="jk" value="{{ $crew->jk }}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Nomor Handphone</label>
            <input type="text" class="form-control" name="hp" value="{{ $crew->hp }}" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" name="email" value="{{ $crew->email }}">
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Marketing</label>
            <select class="form-select" aria-label="Default select example" name="user_id">
              @php
              $marketing = session('marketing') ?? [];
              
              @endphp
              @foreach($marketing as $mark)
              <option selected value="{{ $mark->id }}">
                {{ $mark->nama }}
              </option>
              @endforeach
              <option value="">Pilih Marketing</option>
              @php
                $marketings = session('marketings') ?? [];
                @endphp
                @foreach($marketings as $mark)
                
              <option value="{{ $mark->id }}">{{ $mark->nama }}</option>
              @endforeach
            </select>
          </div> -->
          @endforeach


      </div>
      <div class="modal-footer">
        <input type="hidden" name="id_card" value="{{ $crew->id }}">
        <input type="hidden" name="nomor" value="{{ $crew->nomor }}">
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
          @csrf
          <div class="" style="width: 100%;">
            <div class="card-body">

              <p class="card-text">Level Kartu Saat Ini Adalah
                @php
                $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                @endphp

                @foreach($level as $card)
                {{ $card->nama }}
                @endforeach
              </p>

              <div class="form-group">

                <input type="text" class="form-control" name="nomor" placeholder="ID Card Baru" required>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">

        <input type="hidden" name="id_card" value="{{ $crew->id }}">
        <input type="hidden" name="id_card_old" value="{{ $crew->id }}">
        <input type="hidden" name="level" value="{{ $crew->level }}">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upgrade Kartu</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Add these script tags to include Bootstrap JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>