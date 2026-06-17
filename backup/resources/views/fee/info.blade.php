<section class="faq-section section-padding">

  <div class="container">

    <div class="row justify-content-center">



      <div class="col-lg-5 col-12 mb-3">
        <div class="custom-block custom-block-overlay">
          <div class="d-flex flex-column h-100">

            <div class="custom-block-overlay-text d-flex">
              <div>
                <h5 class="text-white mb-2"> 
                @php
                    $level = session('level') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                    @endphp

                    @foreach($level as $card)
                    {{ $card->nama }}
                    @endforeach
                </h5>

                <table class="table">
                  <tbody>
                    @php
                    $cards = session('cards') ?? []; // Jika session 'crews' null, gunakan array kosong sebagai fallback
                    @endphp

                    @foreach($cards as $card)
                    <tr>
                      <th class="text-white">Nama</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->nama }}</td>
                    </tr>
                    <tr>
                      <th class="text-white">Asal</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->asal }}</td>
                    </tr>

                    <tr>
                      <th class="text-white">Jenis Kelamin</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->jk }}</td>
                    </tr>
                    <tr>
                      <th class="text-white">Nomor Handphone</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->hp }}</td>
                    </tr>
                    <tr>
                      <th class="text-white">Email</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->email }}</td>
                    </tr>
                    <tr>
                      <th class="text-white">PO</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->po }}</td>
                    </tr>
                    <tr>
                      <th class="text-white">Ditambahkan Pada</th>
                      <td class="text-white"></td>
                      <td class="text-white">{{ $card->created_at }}</td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>


              </div>


            </div>


            <div class="section-overlay"></div>
          </div>
        </div>
      </div>


    </div>
  </div>
  </div>
</section>