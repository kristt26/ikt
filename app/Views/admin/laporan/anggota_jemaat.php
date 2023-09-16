<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="col-md-12" ng-controller="laporanAnggotaJemaatController">
    <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(wijk, ksp, unsur)" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</button>
    <div class="d-flex justify-content-start mb-1">
        <div class="col-3">
            <select class="form-select" ng-options="item as item.wijk for item in wijks" ng-model="wijk" ng-change="viewData(wijk, ksp, unsur)" aria-label="Default select example">
                <option value="">---Pilih WIJK---</option>
            </select>
        </div>
        <div class="col-3" style="margin-left: 12px;" ng-show="wijk">
            <select class="form-select" ng-options="item as item.ksp for item in wijk.ksps" ng-model="ksp" ng-change="viewData(wijk, ksp, unsur)" aria-label="Default select example">
                <option value="">---Pilih KSP---</option>
            </select>
        </div>
        <div class="col-3" style="margin-left: 12px;">
            <select class="form-select" ng-options="item as item for item in unsurs" ng-model="unsur" ng-change="viewData(wijk, ksp, unsur)" aria-label="Default select example" style="margin-left: 12px;">
                <option value="">---Pilih Unsur---</option>
            </select>
        </div>
    </div>
    <div class="border-bottom mb-3"></div>
    <div class="table-responsive">
        <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode KK</th>
                    <th>Unsur</th>
                    <th>Nama Jemaat</th>
                    <th>Kepala Keluarga</th>
                    <th>Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Gol. Darah</th>
                    <th>Status Perkawinan</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Suku</th>
                    <th>Status Domisili</th>
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