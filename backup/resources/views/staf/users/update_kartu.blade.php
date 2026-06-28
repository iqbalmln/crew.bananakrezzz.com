@extends('staf.layout.main')
@section('staf')

<div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">

            <div class="card-body p-4">

                @if(session()->has('no'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal Update Kartu!</strong> Nomor kartu sudah terdaftar di sistem, coba kartu lain yang belum terdaftar oleh sistem
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('ok'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update Kartu!</strong> Nomor kartu berhasil diupdate
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <h5 class="card-title fw-semibold mb-4"> <i class="bi bi-file-check-fill"></i> Data Seluruh Kartu Aktif </h5>
                <!-- Button trigger modal -->


                <div class="container mb-3">
                    <form action="/search_kartu" method="GET">
                        <div class="input-group ">
                            <input type="text" class="form-control" value="{{ $keyword ?? '' }}" name="keyword">

                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Cari Kartu</button>
                            </div>
                            @if(!empty($keyword))
                            <div class="input-group-append">
                                <a href="/update_kartu" class="btn btn-outline-danger"><i class="bi bi-arrow-clockwise"></i> Hapus Pencarian</a>
                            </div>
                            @endif

                        </div>
                        <small>Masukan ID Kartu / NIK / Nama / PO / Biro Pemegang Kartu...</small>
                    </form>

                </div>


                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">ID Kartu</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">NIK</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Asal</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Kelamin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Handphone</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Email</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Presensi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Ditambahkan Pada</h6>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kartu_aktif->sortByDesc('created_at') as $user)
                                <tr>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->nomor}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->nik}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->nama}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->asal}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->jk}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->hp}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->email}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                        {{ $presensi->where('card_id', $user->id)->count() }}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">

                                            <button type="button" class="btn btn-sm btn-success">Aktif</button>
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">
                                            {{$user->created_at}}
                                        </p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#update{{$user->id}}">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="update{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Card</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/act.update.kartu" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Card ID</label>
                                                                <input type="text" class="form-control" value="{{$user->nomor}}" name="nomor">
                                                                <input type="hidden" class="form-control" value="{{$user->id}}" name="id">
                                                                <small id="emailHelp" class="form-text text-muted">Saat mengupdate nomor kartu maka data kartu yang nama akan di hilangkan<br> dan di pindak ke kartu yang baru</small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">NIK</label>
                                                                <input type="text" class="form-control"  value="{{$user->nik}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Nama</label>
                                                                <input type="text" class="form-control"  value="{{$user->nama}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Asal</label>
                                                                <input type="text" class="form-control"  value="{{$user->asal}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Jenis Kelamin</label>
                                                                <input type="text" class="form-control"  value="{{$user->jk}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">HP</label>
                                                                <input type="text" class="form-control"  value="{{$user->hp}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Email</label>
                                                                <input type="text" class="form-control"  value="{{$user->email}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Presensi</label>
                                                                <input type="text" class="form-control"  value="{{ $presensi->where('card_id', $user->id)->count() }}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Ditambahkan Pada</label>
                                                                <input type="text" class="form-control"  value="{{$user->created_at}}" readonly>
                                                            </div>
                                                          
                                                      
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
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




<script>
    // Mendapatkan tombol-tombol yang memiliki class btn
    const buttons = document.querySelectorAll('.btn');

    // Mendaftarkan event click pada setiap tombol
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Mendapatkan target collapse
            const target = this.getAttribute('data-target');

            // Menutup semua collapse yang bukan target yang diklik
            document.querySelectorAll('.collapse').forEach(collapse => {
                if (`#${collapse.id}` !== target) {
                    $(collapse).collapse('hide');
                }
            });
        });
    });
</script>

@endsection