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

                <h5 class="card-title fw-semibold mb-4"> <i class="ti ti-user"></i> Data Pengguna {{$store}}</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahuser1">
                    <i class="bi bi-person-add"></i> Tambah User
                </button>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">HP</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Username</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Level</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Lokasi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Bergabung Pada</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->nama}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->hp}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->username}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->level}}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($stores as $toko)
                                        @if($user->store_id==$toko->id)
                                        {{$toko->nama}}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        {{$user->created_at}}
                                    </p>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detailuser{{$user->id}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>

                            </tr>


                            <!-- Detail -->
                            <div class="modal fade" id="detailuser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="detailuser{{$user->id}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahuser">Detail User</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/master.users.update">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nama</label>
                                                    <input type="text" class="form-control" name="nama" aria-describedby="emailHelp" value="{{ $user->nama }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Nomor HP</label>
                                                    <input type="text" class="form-control" name="hp" value="{{ $user->hp }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Level</label>
                                                    <select class="form-select" aria-label="Default select example" name="level" required>

                                                        <option value="{{ $user->level }}">{{ $user->level }}</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="staf">Staf</option>
                                                        <option value="master">Master</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Lokasi</label>
                                                    <select class="form-select" aria-label="Default select example" name="store_id" required>

                                                        <option value="{{ $user->store_id }}"> @foreach($stores as $toko)
                                                            @if($user->store_id==$toko->id)
                                                            {{$toko->nama}}
                                                            @endif
                                                            @endforeach
                                                        </option>
                                                        @foreach($stores as $toko)
                                                        <option value=" {{$toko->id}}"> {{$toko->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Username</label>
                                                    <input type="text" class="form-control  @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" readonly>
                                                    <small id="emailHelp" class="form-text text-muted">Username Tidak Bisa Diedit</small>

                                                    @error('username')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="text" class="form-control" name="password">
                                                    <small id="emailHelp" class="form-text text-muted">Password Tidak Ditampilkan Demi Kerahasiaan Autentikasi Login </small>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                            <option value="master" selected>Admin Master</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Lokasi</label>
                        <select class="form-select" aria-label="Default select example" name="store_id" required>

                            <option value="{{ $user->store_id }}"> @foreach($stores as $toko)
                                @if($user->store_id==$toko->id)
                                {{$toko->nama}}
                                @endif
                                @endforeach
                            </option>
                            @foreach($stores as $toko)
                            <option value=" {{$toko->id}}"> {{$toko->nama}}</option>
                            @endforeach
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