@extends('staf.layout.main')
@section('staf')

<div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">

            <div class="card-body p-4">
                @if(session()->has('user.add'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> User Ditambahkan
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('user.update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update!</strong> User Diupdate
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('berhasil_update_crew'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update!</strong> Presensi Diupdate
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('berhasil_update_status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Update!</strong> Approve Absensi
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold mb-4">Data Presensi Crew {{ $store }}</h5>
                    <form action="/presensi_kartu" method="get">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <small class="form-text text-muted">Start Date</small>
                                <input type="date" class="form-control" name="start_date" placeholder="Enter start date" value="{{ request()->input('start_date') }}" required>
                            </div>
                            <div class="col-md-5">
                                <small class="form-text text-muted">End Date</small>
                                <input type="date" class="form-control" name="end_date" placeholder="Enter end date" value="{{ request()->input('end_date') }}" required>
                            </div>
                            <div class="col-md-1 mt-3">
                                <input type="hidden" name="filter" value="1">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i></button>
                            </div>
                        </div>
                        @if(request()->input('filter') == 1)
                        <a href="/presensi_kartu" class="form-text text-primary">Hapus filter</a>
                        @endif
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle table-home">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Presensi Pada</h6>
                                </th>
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
                                    <h6 class="fw-semibold mb-0">PO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Bus</h6>
                                </th>

                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total Belanja</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Marketing</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Ket</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kode</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Gambar</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status Approve</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status Reward</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($users->sortByDesc('created_at') as $user)
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->waktu}} - {{$user->tgl}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($user->card_id==$card->id)
                                        {{ $card->nomor }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($user->card_id==$card->id)
                                        {{ $card->nik }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($user->card_id==$card->id)
                                        {{ $card->nama }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($user->card_id==$card->id)
                                        {{ $card->asal }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($user->card_id==$card->id)
                                        {{ $card->jk }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{ $user->po }}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->bus}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <!-- Button trigger modal -->

                                    @if($user->belanja!="")
                                    Rp. {{ number_format($user->belanja)}}
                                    @else
                                    Atur Total Belanja
                                    @endif


                                </td>
                                <td class="border-bottom-0">
                                    <!-- Button trigger modal -->

                                    @if($user->marketing_id!="")
                                    @foreach($marketings as $marketing)
                                    @if($user->marketing_id==$marketing->id)
                                    {{ $marketing->nama }}
                                    @endif
                                    @endforeach
                                    @else
                                    Pilih Marketing
                                    @endif


                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->ket}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->kode_hari}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    @if($user->image == null)
                                        <p class="mb-0 fw-normal">Tidak ada</p>
                                    @else
                                        <a href="/image_presensi/{{ $user->image }}" target="_blank">Lihat</a>
                                    @endif
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{ $user->status_approve == 0 ? 'Not Approve' : 'Approved' }}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @if($user->reward == 0)
                                            <span class="badge bg-warning">Belum Klaim</span>
                                        @else
                                            <span class="badge bg-success">Sudah Klaim</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#up.info{{$user->id}}">
                                            Update
                                        </button>
                                        <?php if ($user->status_approve == 0): ?>
                                            <br>
                                            <a href="/approve_presence/{{ $user->id }}" class="btn btn-sm btn-success mt-1"onclick="return confirm('Yakin approve absensi?')">
                                                Approve
                                            </a>
                                        <?php endif ?>
                                    </p>
                                    <!-- Modal -->
                                    <div class="modal fade" id="up.info{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Informasi Presensi</h5>
                                                </div>
                                                <form action="/update.belanja" method="post">
                                                    @csrf


                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">PO</label>
                                                            <input type="text" name="po" class="form-control" value=" {{$user->po}}">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Bus</label>
                                                            <input type="text" name="bus" class="form-control" value=" {{$user->bus}}">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Total Belanja</label>
                                                            <input type="number" name="belanja" class="form-control" value="{{$user->belanja}}">
                                                            <small class="text-danger">*Masukan hanya angka tanpa titik atau simbol lainya</small>
                                                            <input type="hidden" name="presensi_id" class="form-control" value=" {{$user->id}}">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <select class="form-select" aria-label="Default select example" name="marketing">
                                                                @if($user->marketing_id!="")
                                                                @foreach($marketings as $marketing)
                                                                @if($user->marketing_id==$marketing->id)
                                                                <option value="{{ $marketing->id }}">
                                                                    {{ $marketing->nama }}
                                                                </option>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <option value="">
                                                                    Pilih Marketing
                                                                </option>
                                                                @endif
                                                                @foreach($marketings as $marketing)
                                                                @if($user->marketing_id==$marketing->id)
                                                                {{ $marketing->nama }}
                                                                @endif
                                                                @endforeach
                                                                @foreach($marketings as $marketing)
                                                                <option value=" {{ $marketing->id }}"> {{ $marketing->nama }}
                                                                </option>
                                                                @endforeach
                                                                <option value=""> Hapus Marketing
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="exampleInputPassword1">Keterangan</label>
                                                            <input type="text" name="ket" class="form-control" value=" {{$user->ket}}">
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



<!-- ADD -->
<div class="modal fade" id="tambahuser1" tabindex="-1" role="dialog" aria-labelledby="tambahuser1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahuser">Tambah User</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="/users.add">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" placeholder="Nama User" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nomor HP</label>
                        <input type="text" class="form-control" name="hp" placeholder="Nomor HP" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Level</label>
                        <select class="form-select" aria-label="Default select example" name="level" required>

                            <option value="admin">Admin</option>
                            <option value="staf" selected>Staf</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Username</label>
                        <input type="text" class="form-control  @error('username') is-invalid @enderror" name="username" placeholder="Username" required>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="text" class="form-control" name="password" placeholder="Password" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection