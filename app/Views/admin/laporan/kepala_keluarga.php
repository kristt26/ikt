<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="col-md-12" ng-controller="laporanKepalaKeluargaController">
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(wijk, ksp, statusCetak)"><i class="mdi mdi-printer"></i> Print</button>
            <button ng-if="statusCetak=='kepala'" class="btn btn-info btn-sm mb-2" id="myButton" ng-click="export(wijk, ksp, statusCetak)"><i class="mdi mdi-file"></i> Export</button>
        </div>

        <div class="col-md-10">
            <div class="form-group row" style="margin-bottom: 0rem !important; margin-top: -0.5rem !important; margin-left: 0.5rem !important;">
                <div class="d-flex justify-content-end">
                    <!-- <label class="col-sm-3 col-form-label">Model Data</label> -->
                    <div class="col-sm-5">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" ng-model="statusCetak" id="membershipRadios1" value="kepala"> Hanya Kepala Keluarga </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="status" ng-model="statusCetak" id="membershipRadios2" value="anggota"> Dengan Anggota </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- <button class="btn btn-primary btn-sm mb-2" id="myButton" ng-click="cetak(wijk, ksp)"><i class="mdi mdi-file-excel-box"></i> Export</button> -->
    
    <div class="border-bottom mb-3"></div>
    <div class="table-responsive">
        <table datatable="ng" dt-options="dtOptions" class="table table-sm table-hover table-striped table-bordered" width="99%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Keluarga</th>
                    <th>Nama</th>
                    <th>Wilayah</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Status Tinggal</th>
                    <th>Kerukunan</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in datas track by item.id">
                    <td>{{$index+1}}</td>
                    <td>{{item.nomor}}</td>
                    <td>{{item.nama}}</td>
                    <td>{{item.wilayah}}</td>
                    <td>{{item.kontak}}</td>
                    <td>{{item.alamat}}</td>
                    <td>{{item.status_tinggal}}</td>
                    <td>{{item.kerukunan}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>