<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="row" ng-controller="golonganDarahController" ng-init="init()">
    <div class="col-md-12">
        <div class="d-flex justify-content-start mb-3">
            <div class="">
                <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(darah)" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</button>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" ng-model="darah" aria-label="Default select example" style="margin-left: 12px;" ng-change="setDate(darah)">
                    <option value="" selected disabled>---Golongan Darah---</option>
                    <option ng-repeat="item in golonganDarah" value="{{item}}">{{item}}</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered" width="99%">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>TTL</th>
                    <th>Gol. Darah</th>
                    <th>Agama</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in datas">
                        <td>{{$index+1}}</td>
                        <td>{{item.nik}}</td>
                        <td>{{item.nama}}</td>
                        <td>{{item.gender}}</td>
                        <td>{{item.tempat_lahir + ', ' + item.tanggal_lahir}}</td>
                        <td>{{item.golongan_darah}}</td>
                        <td>{{item.agama}}</td>
                        <td>{{item.hubungan_keluarga}}</td>
                        <td>{{item.pendidikan_terakhir}}</td>
                        <td>{{item.pekerjaan}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/set.js') ?>"></script>
<?= $this->endSection() ?>