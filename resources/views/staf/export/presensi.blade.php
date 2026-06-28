<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<h2>Laporan Presensi {{$store}}</h2>
<p>Data diambil dari tanggal {{$start_date}} sampai {{$end_date}}</p>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID CARD</th>
            <th scope="col">TANGGAL</th>
            <th scope="col">PO</th>
            <th scope="col">BIRO</th>
            <th scope="col">JUMLAH BUS</th>
            <th scope="col">TOTAL BELANJA</th>
            <th scope="col">MARKETING</th>
            <th scope="col">KETERANGAN</th>
            <th scope="col">KODE HARI</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensis->sortBy('created_at') as $presensi)
        <tr>
            <td>
                @foreach($cards as $card)
                @if($card->id == $presensi->card_id)
                {{ $card->nomor }}
                @endif
                @endforeach
            </td>
            <td>{{ $presensi->tgl }}</td>
            <td>{{ $presensi->po }}</td>
            <td>{{ $presensi->biro }}</td>
            <td>{{ $presensi->bus }}</td>
            <td>{{ $presensi->belanja }}</td>
            <td>
                @foreach($marketings as $m)
                @if($m->id == $presensi->marketing_id)
                {{ $m->nama }}
                @endif
                @endforeach
            </td>
            <td>{{ $presensi->ket }}</td>
            <td>{{ $presensi->kode_hari }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
