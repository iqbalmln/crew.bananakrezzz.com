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

                <h5 class="card-title fw-semibold mb-4">Klaim Presensi {{ $store }} </h5>


                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Klaim Pada</h6>
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
                                    <h6 class="fw-semibold mb-0">Jumlah Presensi</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                      
                            @foreach($klaim_presensis->sortByDesc('created_at') as $klaim)
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$klaim->tgl}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($klaim->card_id==$card->id)
                                        {{ $card->nomor }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($klaim->card_id==$card->id)
                                        {{ $card->nik }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($klaim->card_id==$card->id)
                                        {{ $card->nama }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($klaim->card_id==$card->id)
                                        {{ $card->asal }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($klaim->card_id==$card->id)
                                        {{ $card->jk }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{ $klaim->presensi }}
                                    </p>
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