<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="col-md-12" ng-controller="laporanController">
    <a href="<?= base_url()?>/laporan/" class="btn btn-primary btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</button>
    <div class="border-bottom mb-3"></div>
    <div class="table-responsive">
        <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Gol. Darah</th>
                    <th>Agama</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in datas track by item.id">
                    <td>{{$index+1}}</td>
                    <td>{{item.kode_kk}}</td>
                    <td>{{item.unsur}}</td>
                    <td>{{item.nama}}</td>
                    <td>{{item.kepala}}</td>
                    <td>{{item.tanggal_lahir}}</td>
                    <td>{{item.umur}}</td>
                    <td>{{item.sex}}</td>
                    <td>{{item.golongan_darah}}</td>
                    <td>{{item.status_kawin}}</td>
                    <td>{{item.hubungan_keluarga}}</td>
                    <td>{{item.pendidikan_terakhir}}</td>
                    <td>{{item.pekerjaan}}</td>
                    <td>{{item.nama_ayah}}</td>
                    <td>{{item.nama_ibu}}</td>
                    <td>{{item.suku}}</td>
                    <td>{{item.status_domisili}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>