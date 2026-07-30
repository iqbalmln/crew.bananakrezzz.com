@extends('staf.layout.main')
@section('staf')

<div class="row">

    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">

            <div class="card-body p-4">
                
                @if(session()->has('hapus_kartu'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Berhasil Menghapus Kartu!</strong> Kartu Dihapus
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <h5 class="card-title fw-semibold mb-4"> <i class="bi bi-file-check-fill"></i> Data Seluruh Kartu Dari Semua Toko</h5>
                <!-- Button trigger modal -->

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#aktif" aria-expanded="false" aria-controls="aktif">
                    Kartu Dalam Transaksi ({{ $kartu_aktif->count() }})
                </button>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#pasif" aria-expanded="false" aria-controls="pasif">
                    Kartu Belum Digunakan ({{ $kartu_pasif->count() }})
                </button>



                <div class="collapse" id="aktif">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle table-home">
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
                                            <h6 class="fw-semibold mb-0">PO</h6>
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
                                    @foreach($kartu_aktif as $user)
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
                                                {{$user->po}}
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

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="pasif">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle table-home">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">ID Kartu</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Ditambahkan Pada</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kartu_pasif as $user)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{$user->nomor}}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                            <small  class="btn btn-sm btn-danger">Non Aktif</small>
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{$user->created_at}}
                                            </p>
                                        </td>
                                        <td>
                                            <a href="/hapus.kartu?id={{$user->id}}" class="btn btn-danger btn-sm" >
                                            <i class="bi bi-trash3"></i>
                                            </a>
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