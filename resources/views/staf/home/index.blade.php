@extends('staf.layout.main')
@section('staf')

<div class="row">
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Kartu</h5>
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="fw-semibold mb-3">{{ $jml_cards }} Kartu Terdaftar</h4>
                        <div class="d-flex align-items-center">
                            <div class="me-8">
                                <i class="bi bi-person-badge text-primary"></i>
                                <span class="fs-2">{{ $card_presensi }} Kartu Dalam Transaksi </span><br>
                                <i class="bi bi-file-minus text-black"></i>
                                <span class="fs-2"> {{ $card_presensi_no }} Kartu Belum Gunakan</span><br>
                                <small class="text-danger">*Data kartu keseluruhan</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/kartu" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>
    @cannot('master')
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Presensi Hari Ini</h5>
                <div class="d-flex align-items-center">
                    <div class="me-8">
                        <i class="bi bi-file-check-fill text-primary"></i>
                        <span class="fs-2">{{ $transaksi_now }} Crew Melakukan Presensi Hari Ini</span>
                    </div>
                </div>
                <a href="/presensi_kartu" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Klaim Presensi</h5>
                <div class="d-flex align-items-center">
                    <div class="me-8">
                        <i class="bi bi-dropbox text-primary"></i>
                        <span class="fs-2">{{ $klaim_presensi }} Crew Melakukan Klaim Presensi Hari Ini</span>
                    </div>

                </div>
                <a href="/klaim_presensi" class="btn btn-primary mt-3">Selengkapnya</a>
            </div>
        </div>
    </div>

    @endcannot
    <div class="col-sm-3">
        <div class="card" style="background-color: gold;">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <div class="d-flex align-items-center">
                    @cannot('master')
                    <div class="me-8">
                        <i class="bi bi-person-fill text-primary"></i>
                        <span class="fs-2">{{ $users }} Karyawan aktif</span><br>
                        <i class="bi bi-person-fill text-primary"></i>
                        <span class="fs-2">{{ $marketing }} Marketng aktif</span>
                    </div>
                    @endcannot

                </div>
                @cannot('master')
                <a href="/users" class="btn btn-primary mt-3">Selengkapnya</a>
                @endcannot
                @can('master')
                <a href="/master.users" class="btn btn-primary mt-3">Selengkapnya</a>
                @endcan
            </div>
        </div>
    </div>

</div>


<div class="row">
    @php
    use Carbon\Carbon;
    $today = Carbon::now();
    $formattedDate = $today->format('l, d F Y');
    @endphp

@cannot('master')
    <div class="col-lg-12 d-flex align-items-stretch mb-5">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Presensi Hari Ini "{{ $formattedDate }}" di {{ $store }}
                </h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle table-home">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Card Id</h6>
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
                                    <h6 class="fw-semibold mb-0">Nomor Handphone</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">PO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">BIRO</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Belanja</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Marketing</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Keterangan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Kode</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensis as $pres)
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->nomor }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->nik }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->nama }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->asal }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->jk }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->hp }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->email }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        {{ $pres->po }}

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        {{ $pres->biro }}

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        {{ $pres->belanja }}

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        @foreach($mars as $mar)
                                        @if($pres->marketing_id == $mar->id)
                                        {{ $mar->nama }}
                                        @endif
                                        @endforeach

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        {{ $pres->ket }}

                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">

                                        {{ $pres->kode_hari }}

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
@endcannot

@endsection