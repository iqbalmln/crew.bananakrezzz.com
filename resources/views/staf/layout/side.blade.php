<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="/staf" class="text-nowrap logo-img">
        <img src="logo.png" width="120" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">

        <li class="sidebar-item">
          <a class="sidebar-link" href="/admin" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Home</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/kartu" aria-expanded="false">
            <span>
              <i class="bi bi-file-check-fill"></i>
            </span>
            <span class="hide-menu">Kartu</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/update_kartu" aria-expanded="false">
            <span>
            <i class="bi bi-file-arrow-up-fill"></i>
            </span>
            <span class="hide-menu">Update Kartu</span>
          </a>
        </li>
        @cannot('master')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/presensi_kartu" aria-expanded="false">
            <span>
              <i class="bi bi-person-badge"></i>
            </span>
            <span class="hide-menu">Presensi Crew</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/klaim_presensi" aria-expanded="false">
            <span>
              <i class="bi bi-dropbox"></i>
            </span>
            <span class="hide-menu">Klaim Presensi</span>
          </a>
        </li>
        @endcan
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Users</span>
        </li>

        <!-- <li class="sidebar-item">
              <a class="sidebar-link" href="/crew" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Data Crew</span>
              </a>
            </li> -->
        @can('master')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/master.users" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">Pengguna</span>
          </a>
        </li>
        @endcan
        @cannot('master')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/users" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">Pengguna</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/marketing" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">Marketing</span>
          </a>
        </li>

        <hr>
        <center>

          <button type="button" class="btn btn-outline-primary "  data-toggle="modal" data-target="#dlaporan">Download Laporan Crew</button>
        </center>

        @endcan

        @can('master')
        <hr>
        <li class="sidebar-item">
          <a class="sidebar-link" href="/setting" aria-expanded="false">
            <span>
              <i class="bi bi-gear"></i>
            </span>
            <span class="hide-menu">Setting</span>
          </a>
        </li>

        @endcan
        <!-- <li class="sidebar-item">
              <a class="sidebar-link" href="/laporan" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Laporan</span>
              </a>
            </li> -->

      </ul>

    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>