<?= $this->extend('admin/sidi/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <!-- <a href="<?= base_url("laporan/excel?item=") . $url ?>" target="_blank" class="btn btn-primary btn-sm mb-2" id="myButton"><i class="mdi mdi-file-excel-box"></i> Export</a> -->
    <!-- <a href="<?= base_url("laporan/print?item=") . $url ?>" target="_blank" class="btn btn-info btn-sm mb-2" id="myButton"><i class="mdi mdi-printer"></i> Print</a> -->
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
                        <button class="btn btn-info btn-sm btn-rounded btn-icon" style="margin-right: 10px; margin-left: 5px;" ng-click="showPersyaratan(item)" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat persyaratan"><i class="mdi mdi-playlist-check"></i></button>
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
<div class="modal fade zoom-in" id="pesan" tabindex="-1" aria-labelledby="pesanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pesanLabel">Tinggal Pesan</h5>
                <button type="button" class="btn-close" ng-click="hideFile()"></button>
            </div>
            <form ng-submit="save()">
                <div class="modal-body">
                    <div class="mb-3">
                        <textarea class="form-control" ng-model="model.pesan" rows="3" placeholder="Tinggalkan alasan penolakan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Setujui</button>
                    <button type="button" class="btn btn-secondary btn-sm" ng-click="hideFile()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade zoom-in" id="modalFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div ng-if="setItem.set=='pdf'">
                    <button id="prev">Previous</button>
                    <button id="next">Next</button>
                    &nbsp; &nbsp;
                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                </div>
                <button type="button" class="btn btn-lg" ng-click="download()"><i class="mdi mdi-download"></i></button>
                <button type="button" class="btn-close" ng-click="hideFile()"></button>
            </div>
            <canvas ng-if="setItem.set=='pdf'" id="the-canvas"></canvas>
            <img ng-src="{{setItem.url}}" ng-if="setItem.set!='pdf'" class="img-responsive " width="100%" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" ng-click="hideFile()">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>/assets/libs/pdfjs/pdf.js"></script>
<?= $this->endSection() ?>