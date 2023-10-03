<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="row" ng-controller="unsurController" ng-init="init()">
    <div class="col-md-12">
        <div class="d-flex justify-content-start">
            <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(ksp)" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</button>
            <div class="col-3">
                <select class="form-select" ng-options="item as item.wijk for item in wijks" ng-model="wijk" aria-label="Default select example" style="margin-left: 12px;">
                    <option value="">---Pilih WIJK---</option>
                </select>
            </div>
            <div class="col-3" style="margin-left: 12px;">
                <select class="form-select" ng-options="item as item for item in unsurs" ng-model="unsur" ng-change="viewData(wijk, unsur)" aria-label="Default select example" style="margin-left: 12px;">
                    <option value="">---Pilih Unsur---</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered" width="99%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>WIJK</th>
                        <th>KSP</th>
                        <th>Kode KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Nama Jemaat</th>
                        <th>Tanggal Lahir</th>
                        <th>Umur</th>
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
                        <td>{{item.tanggal_lahir | date: 'dd MMMM yyyy'}}</td>
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