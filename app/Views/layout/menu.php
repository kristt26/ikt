<nav class="sidebar sidebar-offcanvas sidebar-fixed" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="<?= base_url('temp') ?>/assets/images/faces/account.png" alt="profile">
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?= session()->get('level') ?></span>
                    <span class="text-secondary text-small"><?= session()->get('lembaga') ?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <?php if (session()->get('level') == 'Admin') : ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <span class="menu-title">Master Data </span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('kerukunan') ?>">Kerukunan</a>
                        </li>
                        <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('ksp') ?>">KSP</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('manajemen_user') ?>">Manajemen User</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('persyaratan') ?>">Persyaratan</a></li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#administrasi-jemaat" aria-expanded="false" aria-controls="administrasi-jemaat">
                    <span class="menu-title">Administrasi</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-view-list menu-icon"></i>
                </a>
                <div class="collapse" id="administrasi-jemaat">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('keluarga') ?>">Keluarga</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('anggota') ?>">Anggota IKT</a></li>
                        <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('mutasi') ?>">Mutasi Jemaat</a></li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#pelayanan" aria-expanded="false" aria-controls="pelayanan">
                    <span class="menu-title">Pelayanan<sup ng-if="menuLayanan > 0"><span class="badge bg-danger" style="border-radius: 1.125rem; padding: 0.3rem !important;">{{menuLayanan}}</span></sup></span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-webhook menu-icon"></i>
                </a>
                <div class="collapse" id="pelayanan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('manajemen_baptis') ?>">Baptis
                                <sup ng-if="(layanan.baptis) > 0"><span class="badge bg-warning" style="border-radius: 1.125rem; padding: 0.3rem !important;">{{layanan.baptis}}</span></sup>
                            </a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('manajemen_sidi') ?>">Sidi
                                <sup ng-if="(layanan.sidi) > 0"><span class="badge bg-warning" style="border-radius: 1.125rem; padding: 0.3rem !important;">{{layanan.sidi}}</span></sup>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('manajemen_nikah') ?>">Nikah
                                <sup ng-if="(layanan.nikah) > 0"><span class="badge bg-warning" style="border-radius: 1.125rem; padding: 0.3rem !important;">{{layanan.nikah}}</span></sup>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('laporan') ?>">
                    <span class="menu-title">Laporan</span>
                    <i class="mdi mdi-file-chart menu-icon"></i>
                </a>
            </li> 
            <!-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#cetak" aria-expanded="false" aria-controls="cetak">
                <span class="menu-title">Cetak </span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-printer menu-icon"></i>
            </a>
            <div class="collapse" id="cetak">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('wijk') ?>">Keluarga</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('ksp') ?>">KSP</a></li>
                </ul>
            </div>
        </li> -->
        <?php endif; ?>
        <?php if (session()->get('level') == 'Administrator') : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('gereja') ?>">
                    <span class="menu-title">Manajemen Gereja</span>
                    <i class="mdi mdi-church menu-icon"></i>
                </a>
            </li>
        <?php endif; ?>
        <?php if (session()->get('level') == 'Jemaat') : ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#jemaatLayanan" aria-expanded="false" aria-controls="jemaatLayanan">
                    <span class="menu-title">Layanan </span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-database menu-icon"></i>
                </a>
                <div class="collapse" id="jemaatLayanan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_baptis') ?>">Baptis</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_sidi') ?>">SIDI</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('layanan_nikah') ?>">Nikah</a></li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</nav>