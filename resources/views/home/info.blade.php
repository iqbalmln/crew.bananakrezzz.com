<section class="faq-section section-padding">

  <div class="container">

    <div class="row justify-content-center">

      <div class="container">
        <div class="row">

          <div class="col-12 text-center">
            <h6 class="mb-4">Data Crew Ganda, Pilih Salah Satu</h1>
          </div>

        </div>
      </div>
      @php
      $crews = session('crews') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
      @endphp

      @foreach($crews as $crew)
      <div class="col-lg-5 col-12 mb-3">
        <div class="custom-block custom-block-overlay">
          <div class="d-flex flex-column h-100">
            <a href="/add_presensi_id?id={{ $crew->id }}">
              <div class="custom-block-overlay-text d-flex">
                <div style="width: 100%; overflow-x: auto;">
                 

                  <table class="table">
                    <tbody>

                      <tr>
                        <th class="text-white">Nama</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->nama }}</td>
                      </tr>
                      <tr>
                        <th class="text-white">Asal</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->asal }}</td>
                      </tr>

                      <tr>
                        <th class="text-white">Jenis Kelamin</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->sk }}</td>
                      </tr>
                      <tr>
                        <th class="text-white">Nomor Handphone</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->hp }}</td>
                      </tr>
                      <tr>
                        <th class="text-white">Email</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->email }}</td>
                      </tr>
                      <tr>
                        <th class="text-white">PO</th>
                        <td class="text-white"></td>
                        <td class="text-white">{{ $crew->po }}</td>
                      </tr>
                    </tbody>
                  </table>


                </div>
                <span class="badge bg-finance rounded-pill ms-auto badge-lg">
                  @php
                  $jumlah = session('jumlah') ?? [];

                  @endphp
                  @php
                  $cardCount = $jumlah->where('card_id', $crew->id)->count();
                  @endphp

                  {{ $cardCount }}

                </span>

              </div>

            </a>
            <div class="section-overlay"></div>
          </div>
        </div>
      </div>
      @endforeach



    </div>
  </div>
  </div>
</section>