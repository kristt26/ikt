<?= $this->extend('admin/laporan/index') ?>
<?= $this->section('laporan') ?>
<div class="col-md-12" ng-controller="laporanController">
    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-primary btn-sm mb-2" id="printBaptis" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</a>
            <a class="btn btn-info btn-sm mb-2" id="cetakBaptis" target="_blank"><i class="mdi mdi-printer"></i> Cetak</a>
        </div>

        <div class="col-md-6">
            <div class="form-group row" style="margin-bottom: 0rem !important; margin-top: -0.5rem !important; margin-left: 0.5rem !important;">
                <div class="col-sm-6">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" onchange="setValue()" name="statusBaptis" id="membershipRadios1" value="sudah"> Sudah Baptis </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" onchange="setValue()" name="statusBaptis" id="membershipRadios2" value="belum"> Belum Baptis </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-6">
        <select class="form-select" id="wijk" onchange="setValue()" ng-model="wijk" ng-change="setView(wijk)" aria-label="Default select example">
            <option value="">---Pilih WIJK---</option>
            <option ng-repeat="item in wijks" value="{{item.id}}">{{item.wijk}}</option>
        </select>
    </div>
    <div class="d-flex justify-content-start mb-1">

    </div>
    <div class="border-bottom mb-3"></div>
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped table-bordered" id="layakBaptis">
            <thead>
                <tr>
                    <th>No</th>
                    <th>WIJK</th>
                    <th>KSP</th>
                    <th>Kode KK</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Gol. Darah</th>
                    <th>Status Perkawinan</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Suku</th>
                    <th>Unsur</th>
                    <th>Status Domisili</th>
                    <th>Baptis</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- <div id="container" style="width:100%; height:400px;"></div>
<script src="https://code.highcharts.com/highcharts.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url() ?>/assets/js/set.js"></script>
<?= $this->endSection() ?>