<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crew Banana Krezzz</title>
  <link rel="shortcut icon" type="image/png" href="logo.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.min.css" />
  <style>
    label[for="dt-length-0"] {
      display:none;
    } 
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('staf.layout.side')
    <!--  Sidebar End -->
    <!--  Main wrapper -->

    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">

          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <p>{{$store}}</p>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <button data-toggle="modal" data-target="#exampleModal" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Edit Username/Password</p>
                    </button>


                    <a href="/admin" class="btn btn-outline-primary mx-3 mt-2 d-block">Home</a>
                    <a href="/kartu" class="btn btn-outline-primary mx-3 mt-2 d-block">Kartu</a>
                    @cannot('master')

                    <a href="/presensi_kartu" class="btn btn-outline-primary mx-3 mt-2 d-block">Presensi</a>
                    <a href="/klaim_presensi" class="btn btn-outline-primary mx-3 mt-2 d-block">Klaim</a>
                    <a href="/users" class="btn btn-outline-primary mx-3 mt-2 d-block">Pengguna</a>
                    <a href="/marketing" class="btn btn-outline-primary mx-3 mt-2 d-block">Marketing</a>
                    @endcan
                    @can('master')
                    <a href="/master.users" class="btn btn-outline-primary mx-3 mt-2 d-block">Pengguna</a>
                    <a href="/setting" class="btn btn-outline-primary mx-3 mt-2 d-block">Setting</a>
                    @endcan

                    <a href="/logout" class="btn btn-outline-primary mx-3 mt-4 d-block">Logout</a>

                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->

        @yield('staf')



        <!-- edit profile -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Uername/Password</h5>

              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username">

                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>

                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <footer style="position: fixed; bottom: 0; width: 100%;">
          <div class="py-6 px-6">
            <p class="mb-0 fs-0">Copyright Banana Krezzz 2023</p>
          </div>
        </footer>

      </div>
    </div>
  </div>





  <!-- Modal -->
  <div class="modal fade" id="dlaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodwnload Laporan</h5>

        </div>
        <div class="modal-body">
          <!-- Formulir -->
          <form method="GET" action="{{ url('/download_presensi') }}" id="downloadForm">
            @csrf
            <div class="form-group">
              <label for="start_date">Start Date:</label>
              <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
              <label for="end_date">End Date:</label>
              <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="1" name="alternatif">
              <label class="form-check-label" for="flexCheckDefault">
                Link Alternatif
              </label><br>
              <small class="text-danger">*Gunakan link alternatif jika tidak bisa mendownload laporan atau ada anomali data saat download laporan</small>
            </div>
           

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Download Laporan</button>
          </form>
        </div>
      </div>
    </div>
  </div>


<!-- JavaScript -->
<script>
      document.getElementById('downloadForm').addEventListener('submit', function (event) {
        // Mendapatkan nilai start_date dan end_date
        var startDateValue = document.getElementById('start_date').value;
        var endDateValue = document.getElementById('end_date').value;

        // Validasi bahwa start_date dan end_date tidak boleh sama
        if (startDateValue === endDateValue) {
            alert('Start Date dan End Date tidak boleh sama.');
            event.preventDefault(); // Mencegah formulir disubmit jika validasi tidak lolos
            return;
        }

        // Mengecek apakah checkbox alternatif dicentang
        var isAlternatifChecked = document.querySelector('input[name="alternatif"]').checked;

        // Mengubah nilai action URL formulir berdasarkan kondisi checkbox
        var actionUrl = isAlternatifChecked ? "{{ url('/dpresensi') }}" : "{{ url('/download_presensi') }}";

        // Menetapkan nilai action URL formulir
        this.action = actionUrl;

        // (Opsional) Menampilkan nilai di console untuk pemeriksaan
        console.log('Start Date:', startDateValue);
        console.log('End Date:', endDateValue);
        console.log('Is Alternatif Checked:', isAlternatifChecked);

        // Continue with the form submission
    });
</script>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function(){
      $(".table-home").dataTable({
        "ordering": false
      })
    })
  </script>
</body>

</html>