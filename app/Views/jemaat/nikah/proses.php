<?= $this->extend('jemaat/nikah/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Kode KK</th>
                    <th>Nama Pendaftar</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Hubungan Keluarga</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in datas">
                    <td>{{$index+1}}</td>
                    <td class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu" style="background-color: #f2f2f2">
                            <button class="btn btn-info btn-sm btn-rounded btn-icon" style="margin-right: 10px; margin-left: 5px;" ng-click="formTambah(item.id)"><i class="mdi mdi-file-multiple" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Anggota Keluarga"></i></button>
                            <button class="btn btn-success btn-sm btn-rounded btn-icon" style="margin-right: 10px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat detail" ng-click="detailData(item)"><i class="mdi mdi-playlist-check"></i></button>
                        </ul>
                        <div class="btn-group">
                        </div>
                    </td>
                    <td>{{item.kode_kk}}</td>
                    <td>{{item.kepala}}</td>
                    <td>{{item.nama}}</td>
                    <td>{{item.tanggal_lahir | date:'d MMMM yyyy'}}</td>
                    <td>{{item.sex}}</td>
                    <td>{{item.hubungan_keluarga}}</td>
                    <td>{{item.nama_ayah}}</td>
                    <td>{{item.nama_ibu}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>