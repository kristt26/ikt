<?= $this->extend('jemaat/nikah/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <a href="<?= base_url("layanan_nikah?item=") . $add ?>" class="btn btn-primary btn-sm mb-2" id="myButton"><i class="mdi mdi-plus-circle"></i> Daftarkan</a>
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>status</th>
                    <th>Kode KK</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Hubungan Keluarga</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="item in datas" ng-class="{'bg-danger': item.status=='3'}">
                    <td>{{$index+1}}</td>
                    <td class="d-flex justify-content-between">
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu" style="background-color: #f2f2f2">
                            <button class="btn btn-info btn-sm btn-rounded btn-icon" style="margin-right: 10px; margin-left: 5px;" ng-click="showPersyaratan(item)"><i class="mdi mdi-file-multiple" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat persyaratan"></i></button>
                            <button ng-show="item.status=='3'" class="btn btn-warning btn-sm btn-rounded btn-icon" style="margin-right: 10px; margin-left: 5px;" ng-click="edit(item.id)"><i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah data"></i></button>
                        </ul>
                        <div class="btn-group">
                        </div>
                    </td>
                    <td>{{item.status=='0' ? 'Proses Validasi' : 'Ditolak'}}</td>
                    <td>{{item.kode_kk}}</td>
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
<div class="modal fade zoom-in" id="modalPersyaratan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div ng-if="persyaratan" class="col-2 text-center" ng-repeat="item in persyaratan">
                        <a href="javascript:void();" ng-click="showFile(item)">
                            <img src="<?= base_url() ?>/temp/assets/images/{{item.set == 'pdf' ? 'pdf.png' : 'pictures.png'}}" style="background-color: transparent;border-radius: 0.75rem;border: 1px solid #7597b9;" class="img-thumbnail" alt="..." width="100%">
                        </a>
                        <div class="card-block">
                            <h6>{{item.nama}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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