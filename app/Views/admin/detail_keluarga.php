<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Detail Keluarga </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Keluarga</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="detailKeluargaController">
    <div class="text-center">
        <h3 style="color: black;"><strong>Detail Data</strong></h3>
    </div>
    <div class="accordion mb-5" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4>Data Keluarga</h4>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="col-lg-12">
                        <div class="table-responsive  mb-2">
                            <table width="99%">
                                <tr style="height:35px">
                                    <td width=" 30%">Nomor</td>
                                    <td width="1%">:</td>
                                    <td>{{model.nomor}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Wilayah</td>
                                    <td width="1%">:</td>
                                    <td>{{model.wilayah}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kerukunan</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kerukunan}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Telepon/HP</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kontak}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Status Tinggal</td>
                                    <td width="1%">:</td>
                                    <td>{{model.status_tinggal}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Alamat</td>
                                    <td width="1%">:</td>
                                    <td>{{model.alamat}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h4>Anggota Keluarga</h4>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="table-responsive  mb-2">
                        <table class="table table-sm table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Hubungan Keluarga</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Golongan Darah</th>
                                    <th>Agama</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in model.anggota">
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <button ng-if="$index!=0" class="btn btn-info btn-sm" style="margin-right: 10px;" ng-click="pecah(item)">Pecah
                                            Keluarga</button>
                                    </td>
                                    <td>{{item.nik}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.hubungan_keluarga}}</td>
                                    <td>{{item.tempat_lahir}}</td>
                                    <td>{{item.tanggal_lahir}}</td>
                                    <td>{{item.gender}}</td>
                                    <td>{{item.golongan_darah}}</td>
                                    <td>{{item.agama}}</td>
                                    <td>{{item.pendidikan_terakhir}}</td>
                                    <td>{{item.pekerjaan}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12" class="btnbox-center">
        <button class="btn btn-primary btn-sm" onclick="history.back()">
            <span class="mdi mdi-arrow-left-bold"></span> Back
        </button>
    </div>
</div>
<?= $this->endSection() ?>