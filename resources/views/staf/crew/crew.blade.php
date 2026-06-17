@extends('staf.layout.main')
@section('staf')

<div class="row">
   
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4"> <i class="ti ti-users"></i> Data Crew</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Card Id</h6>
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
                                    <h6 class="fw-semibold mb-0">Level</h6>
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
                                        @foreach($cards as $card)
                                        @if($pres->card_id == $card->id)
                                        {{ $card->po }}
                                        @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary rounded-3 fw-semibold"> @php
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
                                            @endforeach</span>
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

@endsection