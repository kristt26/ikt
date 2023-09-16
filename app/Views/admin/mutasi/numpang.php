<?= $this->extend('admin/mutasi/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <!-- <a href="<?= base_url("laporan/pindah_excel") ?>" class="btn btn-primary btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</a> -->
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data KK Asal</h4>
                <div class="col-md-5" style="margin-left: 12px;" id="pindah">
                    <div class="form-group" id="pilihJemaat"></div>
                </div>
                <div class="card" ng-if="keluarga">
                    <div class="card-body">
                        <div class="table-responsive  mb-2">
                            <table width="99%">
                                <tr style="height:35px">
                                    <td width=" 30%">WIJK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluarga.wijk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">KSP</td>
                                    <td width="1%">:</td>
                                    <td>{{keluarga.ksp}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">No. KK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluarga.kk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kode KK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluarga.kode_kk}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive  mb-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="1%">
                                            <input type="checkbox" class="form-check-input" ng-model="setValue" ng-change="set(setValue)">
                                            <!-- <div class="form-check">
                                                <label class="form-check-label">
                                                </label>
                                            </div> -->
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Hubungan Keluarga</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in keluarga.anggota" ng-class="{'bg-info': item.set}">
                                        <td>
                                            <input type="checkbox" id="itemSet{{$index}}" class="form-check-input" ng-model="item.set" ng-change="checkSet()">
                                        </td>
                                        <td>{{item.nik}}</td>
                                        <td>{{item.nama}}</td>
                                        <td>{{item.hubungan_keluarga}}</td>
                                        <td>{{item.tempat_lahir}}</td>
                                        <td>{{item.tanggal_lahir}}</td>
                                        <td>{{item.sex}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 200px;" ng-hide="!keluarga">
                <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data KK Tujuan</h4>
                <div ng-class="{'col-md-5': keluarga}" style="margin-left: 12px;" id="kkTujuan">
                    <div class="form-group" id="pilihKKTujuan"></div>
                </div>
                <div class="card" ng-if="keluargaTujuan">
                    <div class="card-body">
                        <div class="table-responsive  mb-2">
                            <table width="99%">
                                <tr style="height:35px">
                                    <td width=" 30%">WIJK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluargaTujuan.wijk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">KSP</td>
                                    <td width="1%">:</td>
                                    <td>{{keluargaTujuan.ksp}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">No. KK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluargaTujuan.kk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kode KK</td>
                                    <td width="1%">:</td>
                                    <td>{{keluargaTujuan.kode_kk}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive  mb-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th width="20%">Hubungan Keluarga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in keluargaTujuan.anggotaBaru">
                                        <td>{{item.nik}}</td>
                                        <td>{{item.nama}}</td>
                                        <td>{{item.tempat_lahir}}</td>
                                        <td>{{item.tanggal_lahir}}</td>
                                        <td>{{item.sex}}</td>
                                        <td>
                                            <div class="form-group">
                                                <select name="hubungan{{$index}}" id="hubungan{{$index}}" ui-select2 class="form-control form-control-sm" data-placeholder="Hubungan Keluarga" ng-options="item as item for item in hubungan" ng-model="item.hubungan_keluarga" required>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-info btn-sm" ng-click="pindahKK()"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="<?= base_url() ?>/assets/js/set.js"></script> -->
<?= $this->endSection() ?>