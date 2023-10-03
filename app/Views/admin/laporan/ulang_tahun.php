<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="row" ng-controller="anggotaUltahController" ng-init="init()">
    <div class="col-md-12">
        <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(tanggal, jenis, wijk.id)" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</button>
        <div class="d-flex justify-content-start mb-3">
            <div class="col-md-4">
                <div class="input-group input-group-sm mb-3">
                    <input type="text" class="col-md-3 form-control form-control-sm" id="tanggal" ng-model="tanggal" placeholder="Tanggal" aria-describedby="textHelp" ng-change="setDate(tanggal, jenis, wijk.id)">
                    <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-calendar-check"></i></span>
                </div>
            </div>
            <div class="col-4" style="margin-left: 12px;">
                <select class="form-select form-select-sm" ng-model="jenis" ng-change="setDate(tanggal, jenis, wijk.id)" aria-label="Default select example">
                    <option value="" disabled>---Jenis Ulang Tahun---</option>
                    <option value="1">Kelahiran</option>
                    <option value="2">Pernikahan</option>
                </select>
            </div>
            <div class="col-4" style="margin-left: 12px;">
                <select class="form-select form-select-sm" ng-options="item as item.wijk for item in wijks" ng-model="wijk" ng-change="setDate(tanggal, jenis, wijk.id)" aria-label="Default select example">
                    <option value="" disabled>---Pilih WIJK---</option>
                </select>
            </div>
        </div>
        <div class="table-responsive" ng-show="datas.length>0">
            <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered" width="99%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>WIJK</th>
                        <th>KSP</th>
                        <th>Kode KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Nama Jemaat</th>
                        <th>{{jenis=='1' ? 'Tanggal Lahir' : 'Tanggal Nikah'}}</th>
                        <th>{{jenis=='1' ? 'Umur' : 'Umur Pernikahan'}}</th>
                        <th>Jenis Kelamin</th>
                        <th>Hubungan Keluarga</th>
                        <th>Unsur</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in datas">
                        <td>{{$index+1}}</td>
                        <td>{{item.wijk}}</td>
                        <td>{{item.ksp}}</td>
                        <td>{{item.kode_kk}}</td>
                        <td>{{item.kepala_keluarga}}</td>
                        <td>{{item.nama}}</td>
                        <td>{{jenis=='1' ? item.tanggal_lahir: item.tanggal_nikah | date: 'dd MMMM yyyy'}}</td>
                        <td>{{item.umur}}</td>
                        <td>{{item.sex}}</td>
                        <td>{{item.hubungan_keluarga}}</td>
                        <td>{{item.unsur}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/set.js') ?>"></script>
<?= $this->endSection() ?>