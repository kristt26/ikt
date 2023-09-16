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
                                    <td width=" 30%">WIJK</td>
                                    <td width="1%">:</td>
                                    <td>{{model.wijk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">KSP</td>
                                    <td width="1%">:</td>
                                    <td>{{model.ksp}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">No. KK</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kode KK</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kode_kk}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Telepon</td>
                                    <td width="1%">:</td>
                                    <td>{{model.telepon}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">handphone</td>
                                    <td width="1%">:</td>
                                    <td>{{model.hp}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Alamat</td>
                                    <td width="1%">:</td>
                                    <td>{{model.alamat}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Provinsi</td>
                                    <td width="1%">:</td>
                                    <td>{{model.provinsi}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kabupaten</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kabupaten}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Distrik</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kecamatan}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kelurahan</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kelurahan}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Kode Pos</td>
                                    <td width="1%">:</td>
                                    <td>{{model.kode_pos}}</td>
                                </tr>
                                <tr style="height:35px">
                                    <td width="30%">Lingkungan</td>
                                    <td width="1%">:</td>
                                    <td>{{model.lingkungan}}</td>
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
                                    <th>Golongan Darah</th>
                                    <th>Agama</th>
                                    <th>Pendidikan</th>
                                    <th>Gelar</th>
                                    <th>Pekerjaan</th>
                                    <th>Asal Gereja</th>
                                    <th>Nama Ayah</th>
                                    <th>Nama Ibu</th>
                                    <th>Suku</th>
                                    <th>Domisili</th>
                                    <th>Baptis</th>
                                    <th>SIDI</th>
                                    <th>Nikah</th>
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
                                    <td>{{item.golongan_darah}}</td>
                                    <td>{{item.agama}}</td>
                                    <td>{{item.pendidikan_terakhir}}</td>
                                    <td>{{item.gelar_terakhir}}</td>
                                    <td>{{item.pekerjaan}}</td>
                                    <td>{{item.asal_gereja}}</td>
                                    <td>{{item.nama_ayah}}</td>
                                    <td>{{item.nama_ibu}}</td>
                                    <td>{{item.suku}}</td>
                                    <td>{{item.status_domisili}}</td>
                                    <td ng-if="item.baptis.file == NULL" ng-class="{'bg-success': item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL, 'bg-danger': !item.baptis || (item.baptis && (item.baptis.tanggal_baptis==null || item.baptis.nama_gereja==null))}">
                                        {{item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL?'Sudah':'Belum'}}
                                    </td>
                                    <td ng-if="item.baptis.file != NULL" ng-class="{'bg-success': item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL, 'bg-danger': !item.baptis || (item.baptis && (item.baptis.tanggal_baptis==null || item.baptis.nama_gereja==null))}">
                                        <a href="<?= base_url("assets/berkas") ?>/{{item.baptis.file}}" style="color:black" target="_blank">{{item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL?'Sudah':'Belum'}}</a>
                                    </td>
                                    <td ng-if="item.sidi.file == NULL" ng-class="{'bg-success': item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja, 'bg-danger': !item.sidi || item.sidi && (!item.sidi.tanggal_sidi || !item.sidi.nama_gereja)}">
                                        {{item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja?'Sudah':'Belum'}}
                                    </td>
                                    <td ng-if="item.sidi.file != NULL" ng-class="{'bg-success': item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja, 'bg-danger': !item.sidi || item.sidi && (!item.sidi.tanggal_sidi || !item.sidi.nama_gereja)}">
                                        <a href="<?= base_url("assets/berkas") ?>/{{item.sidi.file}}" style="color:black" target="_blank">{{item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja?'Sudah':'Belum'}}</a>
                                    </td>
                                    <td ng-if="item.nikah.file == null" ng-class="{'bg-success': item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja, 'bg-danger': !item.nikah || (!item.nikah.tanggal_nikah || !item.nikah.nama_gereja)}">
                                        {{item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja?'Sudah':'Belum'}}
                                    </td>
                                    <td ng-if="item.nikah.file != null" ng-class="{'bg-success': item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja, 'bg-danger': !item.nikah || (!item.nikah.tanggal_nikah || !item.nikah.nama_gereja)}">
                                        <a href="<?= base_url("assets/berkas") ?>/{{item.nikah.file}}" style="color:black" target="_blank">{{item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja?'Sudah':'Belum'}}</a>
                                    </td>
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