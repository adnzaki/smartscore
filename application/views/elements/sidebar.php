<div id="aside" class="app-aside modal fade nav-dropdown">
  <!-- fluid app aside -->
  <div class="left navside dark dk" layout="column">
    <div class="navbar no-radius">
      <!-- brand -->
      <a class="navbar-brand">
          <div ui-include="'{img}logo.svg'"></div>
          <img src="{img}logo.png" alt="." class="hide">
          <span class="hidden-folded inline">Pengguna</span>
      </a>
      <!-- / brand -->
    </div>
    <div flex class="hide-scroll">
        <nav class="scroll nav-light">

            <ul class="nav" ui-nav>
              <li class="nav-header hidden-folded">
                <small class="text-muted">Master</small>
              </li>

              <li>
                <a href="javascript:void(0)">
                  <span class="nav-icon">
                    <i class="material-icons">home
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Beranda</span>
                </a>
              </li>

              <li @click="loadSiswa">
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">people
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Siswa</span>
                </a>
              </li>

              <li @click="siswa.showDaftarSiswa = !siswa.showDaftarSiswa">
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">person
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Guru</span>
                </a>
              </li>

              <li>
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">airplay
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Rombel</span>
                </a>
              </li>

              <li>
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">book
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Pelajaran</span>
                </a>
              </li>

              <li class="nav-header hidden-folded">
                <small class="text-muted">Pengolahan Nilai</small>
              </li>
              <li>
                <a>
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon">
                    <i class="material-icons">assignment
                      <span ui-include="'../assets/images/i_4.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Komponen</span>
                </a>
                <ul class="nav-sub nav-mega nav-mega-3">
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Spiritual</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Sosial</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Pengetahuan</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Ketarampilan</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">KKM</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a>
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon">
                    <i class="material-icons">assessment
                      <span ui-include="'../assets/images/i_4.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Ulangan</span>
                </a>
                <ul class="nav-sub nav-mega nav-mega-3">
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Harian</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">PTS</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">PAS</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a>
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon">
                    <i class="material-icons">description
                      <span ui-include="'../assets/images/i_4.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Laporan</span>
                </a>
                <ul class="nav-sub nav-mega nav-mega-3">
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Mapel</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Tugas</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Ulangan Harian</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">PTS</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">PAS</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Rapor</span>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-header hidden-folded">
                <small class="text-muted">Referensi</small>
              </li>
              <li>
                <a>
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon">
                    <i class="material-icons">library_books
                      <span ui-include="'../assets/images/i_4.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Kompetensi Inti</span>
                </a>
                <ul class="nav-sub nav-mega nav-mega-3">
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Spiritual</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Sosial</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Pengetahuan</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" >
                      <span class="nav-text">Ketarampilan</span>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Pengaturan -->
              <li class="nav-header hidden-folded">
                <small class="text-muted">Pengaturan</small>
              </li>
              <li>
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">settings_applications
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Aplikasi</span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">account_circle
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text">Pengguna</span>
                </a>
              </li>
              <li class="ss-logout-btn">
                <a href="javascript:void(0)" >
                  <span class="nav-icon">
                    <i class="material-icons">exit_to_app
                      <span ui-include="'../assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                  <span class="nav-text ss-white-text">Keluar</span>
                </a>
              </li>
              <!-- #END Pengaturan -->

            </ul>
        </nav>
    </div>


  </div>
</div>
