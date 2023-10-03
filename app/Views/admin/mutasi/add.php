<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
<div class="page-header">
    <h3 class="page-title"> Pindah Jemaat</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pindah Jemaat</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="pindahJemaatController">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-start mb-3">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Jenis Anggota</label>
                            <select class="form-select form-select-sm" id="jenisAnggota" ng-model="jenisAnggota" onchange="clear()" ng-change="model.jenisAnggota = jenisAnggota; clear(); " aria-label="Default select example">
                                <option value="" disabled selected>---Pilih Jenis Anggota---</option>
                                <option value="1">Pribadi</option>
                                <option value="2">Keluarga</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5" style="margin-left: 12px;">
                        <div class="form-group" id="pilihJemaat"></div>
                    </div>
                    <div class="col-sm-3 set-hide-page" id="statusMutasi" style="margin-left: 14px;">
                        <div class="form-group">
                            <label>Status Mutasi</label>
                            <select class="form-select form-select-sm" id="jenisAnggota" ng-model="statusMutasi" onchange="showData()" ng-change="jenisAnggota == '1' ? model.status_pindah=statusMutasi : ''" aria-label="Default select example">
                                <option value="" disabled>---Pilih Status Mutasi---</option>
                                <option value="1">Pindah</option>
                                <option value="2">Meninggal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <form class="set-hide-page" ng-submit="save(model)" id="form">
                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Diri</h4>
                        </div>
                    </div>
                    <div ng-show="jenisAnggota=='2'">
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
                                                    <tr style="height:35px">
                                                        <td width="30%">Telepon</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.telepon}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">handphone</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.hp}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Alamat</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.alamat}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Provinsi</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.provinsi}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Kabupaten</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.kabupaten}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Distrik</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.kecamatan}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Kelurahan</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.kelurahan}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Kode Pos</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.kode_pos}}</td>
                                                    </tr>
                                                    <tr style="height:35px">
                                                        <td width="30%">Lingkungan</td>
                                                        <td width="1%">:</td>
                                                        <td>{{keluarga.lingkungan}}</td>
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
                                                        <th>NIK</th>
                                                        <th>Nama</th>
                                                        <th>Hubungan Keluarga</th>
                                                        <th>Tempat Lahir</th>
                                                        <th>Tanggal Lahir</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Golongan Darah</th>
                                                        <th>Agama</th>
                                                        <th>Pendidikan</th>
                                                        <th>Gelar</th>
                                                        <th>Pekerjaan</th>
                                                        <th>Asal Gereja</th>
                                                        <th>Nama Ayah</th>
                                                        <th>Nama Ibu</th>
                                                        <th>Suku</th>
                                                        <th>Unsur</th>
                                                        <th>Domisili</th>
                                                        <th>Baptis</th>
                                                        <th>SIDI</th>
                                                        <th>Nikah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="item in keluarga.anggota">
                                                        <td>{{$index+1}}</td>
                                                        <td>{{item.nik}}</td>
                                                        <td>{{item.nama}}</td>
                                                        <td>{{item.hubungan_keluarga}}</td>
                                                        <td>{{item.tempat_lahir}}</td>
                                                        <td>{{item.tanggal_lahir}}</td>
                                                        <td>{{item.sex}}</td>
                                                        <td>{{item.golongan_darah}}</td>
                                                        <td>{{item.agama}}</td>
                                                        <td>{{item.pendidikan_terakhir}}</td>
                                                        <td>{{item.gelar_terakhir}}</td>
                                                        <td>{{item.pekerjaan}}</td>
                                                        <td>{{item.asal_gereja}}</td>
                                                        <td>{{item.nama_ayah}}</td>
                                                        <td>{{item.nama_ibu}}</td>
                                                        <td>{{item.suku}}</td>
                                                        <td>{{item.unsur}}</td>
                                                        <td>{{item.status_domisili}}</td>
                                                        <td ng-class="{'bg-success': item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL, 'bg-danger': !item.baptis || (item.baptis && (item.baptis.tanggal_baptis==null || item.baptis.nama_gereja==null))}">
                                                            {{item.baptis && item.baptis.tanggal_baptis!=NULL && item.baptis.nama_gereja!=NULL?'Sudah':'Belum'}}
                                                        </td>
                                                        <td ng-class="{'bg-success': item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja, 'bg-danger': !item.sidi || item.sidi && (!item.sidi.tanggal_sidi || !item.sidi.nama_gereja)}">
                                                            {{item.sidi && item.sidi.tanggal_sidi && item.sidi.nama_gereja?'Sudah':'Belum'}}
                                                        </td>
                                                        <td ng-class="{'bg-success': item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja, 'bg-danger': !item.nikah || (!item.nikah.tanggal_nikah && !item.nikah.nama_gereja)}">
                                                            {{item.nikah && item.nikah.tanggal_nikah && item.nikah.nama_gereja?'Sudah':'Belum'}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div ng-show="jenisAnggota=='1'">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik">Nomor NIK &nbsp;</label>
                                    <input type="text" class="form-control form-control-sm" readonly ng-model="jemaat.nik" placeholder="No Induk Kependudukan">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama">Nama &nbsp;</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="nama" id="nama" ng-model="jemaat.nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nik">WIJK/KSP</label>
                                    <input type="text" class="form-control form-control-sm" readonly ng-model="jemaat.wijk_ksp" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="unsur">Unsur</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="unsur" id="unsur" ng-model="jemaat.unsur">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hubungan_keluarga">Hubungan Keluarga</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="hubungan_keluarga" id="hubungan_keluarga" ng-model="jemaat.hubungan_keluarga">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="asal_gereja">Asal Gereja</label>
                                    <input type="text" class="form-control form-control-sm" readonly name="asal_gereja" id="asal_gereja" ng-model="jemaat.asal_gereja">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">{{statusMutasi=='2' ? 'Data Meninggal':'Data Mutasi'}}</h4>
                        </div>
                    </div>
                    <div ng-if="!statusMutasi || statusMutasi =='1'">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_mutasi">Jenis Mutasi</label>
                                    <select class="form-select form-select-sm" id="jenis_mutasi" ng-model="jenis_mutasi" aria-label="Default select example" required>
                                        <option value="" disabled>---Pilih Jenis Mutasi---</option>
                                        <option value="1">Pindah Gereja</option>
                                        <option value="2">Pindah Agama</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_pindah">Tanggal Pindah</label>
                                    <input type="date" class="form-control form-control-sm" name="tanggal_pindah" id="tanggal_pindah" ng-model="model.tanggal_pindah" placeholder="Nama sesuai KTP" required>
                                </div>
                            </div>
                            <div class="col-md-5" ng-show="jenis_mutasi == '1'">
                                <div class="form-group">
                                    <label for="tujuan">Tujuan</label>
                                    <div class="input-group mb-3">
                                        <select class="form-select form-select-sm" id="tujuan" ng-model="itemGereja" aria-label="Default select example">
                                        </select>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addGereja"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alasan_mutasi">Alasan Mutasi</label>
                                    <textarea class="form-control form-control-sm" name="alasan_mutasi" id="alasan_mutasi" ng-model="model.alasan_pindah" placeholder="Alasan Pindah" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div ng-if="statusMutasi =='2'">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="umur">Umur</label>
                                    <input type="number" disabled class="form-control form-control-sm" name="umur" id="umur" ng-model="model.umur" placeholder="Umur saat meninggal" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tanggal_meninggal">Tanggal Meninggal</label>
                                    <input type="datetime-local" class="form-control form-control-sm" name="tanggal_meninggal" id="tanggal_meninggal" ng-change="hitungUmur(jemaat.tanggal_lahir)" ng-model="model.tanggal_meninggal" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="penyebab">Penyebab Meninggal</label>
                                    <textarea class="form-control form-control-sm" name="penyebab" id="penyebab" ng-model="model.penyebab" placeholder="Penyebab Meninggal" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Diri -->
                    <div class="d-flex justify-content-between mb-3">
                        <a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left-bold"></span> Batal
                        </a>
                        <button type="submit" ng-class="{'btn btn-success': !statusEdit, 'btn btn-warning': statusEdit}">
                            <span class="mdi mdi-plus-circle"></span> {{model.id ? 'Ubah' : 'Tambah'}}
                        </button>
                    </div>
                </form>
                <!-- Data KK -->
            </div>
        </div>
    </div>
    <div class="modal fade zoom-in" id="addGereja" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Gereja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form ng-submit="saveGereja(modelGereja)">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label form-label-sm">Nama</label>
                            <input type="text" class="form-control form-control-sm" ng-model="modelGereja.nama" placeholder="Nama Gereja" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-sm">Kontak</label>
                            <input type="text" class="form-control form-control-sm" ng-model="modelGereja.kontak" placeholder="Kontak" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-sm">Alamat</label>
                            <textarea class="form-control form-control-sm" rows="3" ng-model="modelGereja.alamat" placeholder="Alamat Gereja"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function view() {
        if ($('#jenisAnggota').find(":selected").val() == "1") {
            document.querySelector("#statusMutasi").classList.remove('set-hide-page');
        } else {
            document.querySelector("#form").classList.remove('set-hide-page');
        }
    }
    function showData() {
        document.querySelector("#form").classList.remove('set-hide-page');
    }
</script>
<?= $this->endSection() ?>