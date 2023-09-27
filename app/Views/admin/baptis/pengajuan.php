<?= $this->extend('admin/baptis/index') ?>
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
<div class="modal fade zoom-in" id="modalPersyaratan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionPendaftaran">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingBiodata">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#biodata" aria-expanded="true" aria-controls="biodata">
                                Biodata
                            </button>
                        </h2>
                        <div id="biodata" class="accordion-collapse collapse show" aria-labelledby="headingBiodata" data-bs-parent="#accordionPendaftaran">
                            <div class="accordion-body">
                                <table width="99%">
                                    <tr style="height:35px">
                                        <td width="30%">Kode KK</td>
                                        <td width="1%">:</td>
                                        <td>{{model.kode_kk}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Pendaftaran</td>
                                        <td width="1%">:</td>
                                        <td>{{model.kepala}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Nama Peserta Baptis</td>
                                        <td width="1%">:</td>
                                        <td>{{model.nama}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Tanggal Lahir</td>
                                        <td width="1%">:</td>
                                        <td>{{model.tanggal_lahir}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Jenis Kelamin</td>
                                        <td width="1%">:</td>
                                        <td>{{model.sex}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Hubungan Keluarga</td>
                                        <td width="1%">:</td>
                                        <td>{{model.hubungan_keluarga}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Nama Ayah</td>
                                        <td width="1%">:</td>
                                        <td>{{model.nama_ayah}}</td>
                                    </tr>
                                    <tr style="height:35px">
                                        <td width="30%">Nama Ibu</td>
                                        <td width="1%">:</td>
                                        <td>{{model.nama_ibu}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h2 class="accordion-header" id="headingBerkas">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#berkas" aria-expanded="true" aria-controls="biodata">
                                Berkas
                            </button>
                        </h2>
                        <div id="berkas" class="accordion-collapse collapse" aria-labelledby="headingBerkas" data-bs-parent="#accordionPendaftaran">
                            <div class="accordion-body">
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
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" ng-click="model.status='1';save()">Setujui</button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#pesanTolak" ng-click="model.status='3'">Tolak</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade zoom-in" id="pesanTolak" tabindex="-1" aria-labelledby="pesanLabel" aria-hidden="true">
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