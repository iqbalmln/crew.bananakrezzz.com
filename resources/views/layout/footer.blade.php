
<footer class="site-footer section-padding ">
    <div class="container" style="margin-top: 300px;">
      <div class="row">

        <div class="col-lg-5 col-12 mb-4 pb-2">
          <div class="navbar-brand mb-2">
            <img src="logo.png" width="60px">
            <span>{{$store}}</span>
            <p class="copyright-text mt-lg-5 mt-0">
             {{$alamat}}
            </p>
          </div>
        </div>


       

        <div class="col-lg-3 col-md-12 col-12 mt-0 mt-lg-0 ms-auto">

          <p class="copyright-text mt-lg-5 mt-0">Copyright © 2023 Banana Krezzz. All rights reserved.
         | Support By : PINE
      

          </p>

        </div>

      </div>
    </div>
  </footer>

  <!-- Button trigger modal -->
  <!-- Modal -->
  <div class="modal fade" id="regis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Registrasi Kartu</h5>

        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Card ID</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Card ID">
              <small id="emailHelp" class="form-text text-muted">Masukan ID Card dan akan otomatis terdaftar</small>
              <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h5 class="card-title text-primary"><i class="bi bi-check-circle"></i> Kartu Berhasil Terdaftar</h5>
                  <p class="card-text">Card Id 023402348230 Berhasil Terdaftar dan Siap Diguakan</p>

                  <h5 class="card-title text-danger"><i class="bi bi-file-excel"></i> Kartu Sudah Terdaftar</h5>
                  <p class="card-text">Card Id 023402348230 Sudah Terdaftar </p>

                </div>
              </div>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Ubah Username/Password Login</h5>

        </div>
        <div class="modal-body">
          <p class="text-danger"><i class="bi bi-info-circle"></i> Untuk sekarang kamu hanya bisa mengubah username dan password dihalaman admin, silahkan menghubungi admin</p>
          <!-- <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>

          </form> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  </div>