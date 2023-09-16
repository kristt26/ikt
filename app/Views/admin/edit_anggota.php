<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Add Anggota Keluarga</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('keluarga') ?>">Keluarga</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="editAnggotaController">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form ng-submit="save()">
                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Keluarga</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nomor KK &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" ng-model="datas.kode_kk" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama Kepala Keluarga &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" ng-model="kepalaKeluarga.nama" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Data Diri -->

                    <div class="row">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Diri</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nik">Nomor NIK &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nik.$dirty && signupform.nik.$invalid">
                                    <small class="" ng-show="signupform.nik.$error.required">
                                        Wajib*
                                    </small>
                                    <small class="" ng-show="signupform.nik.$error.minlength">
                                        minimal 16 karakter
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="nik" id="nik" ng-model="model.nik" placeholder="No Induk Kependudukan" ng-minlength=16 maxlength=16 required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nama">Nama &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nama.$dirty && signupform.nama.$invalid">
                                    <small class="" ng-show="signupform.nama.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" ng-model="model.nama" placeholder="Nama sesuai KTP" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="hubungan">Hubungan keluarga &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.hubungan.$dirty && signupform.hubungan.$invalid">
                                    <small class="" ng-show="signupform.hubungan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="hubungan" id="hubungan" ui-select2 class="form-control form-control-sm select2" data-placeholder="Hubungan Keluarga" ng-options="item as item for item in hubungan" ng-model="model.hubungan_keluarga" required>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status_kawin">Status Perkawinan &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.status_kawin.$dirty && signupform.status_kawin.$invalid">
                                    <small class="" ng-show="signupform.status_kawin.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="status_kawin" id="status_kawin" ui-select2 class="form-control form-control-sm select2" data-placeholder="Status Perkawinan" ng-model="model.status_kawin" required>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="unsur">Unsur &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.unsur.$dirty && signupform.unsur.$invalid">
                                    <small class="" ng-show="signupform.status_kawin.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="unsur" id="unsur" ui-select2 class="form-control form-control-sm select2" data-placeholder="Unsur" ng-model="model.unsur" required>
                                    <option value="PAR">PAR</option>
                                    <option value="PAM">PAM</option>
                                    <option value="PW">PW</option>
                                    <option value="PKB">PKB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.tempat_lahir.$dirty && signupform.tempat_lahir.$invalid">
                                    <small class="" ng-show="signupform.tempat_lahir.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="tempat_lahir" id="tempat_lahir" ng-model="model.tempat_lahir" placeholder="Tempat Lahir" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.tanggal_lahir.$dirty && signupform.tanggal_lahir.$invalid">
                                    <small class="" ng-show="signupform.tanggal_lahir.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="date" class="form-control form-control-sm" name="tanggal_lahir" id="tanggal_lahir" ng-model="model.tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="sex">Jenis Kelamin &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.sex.$dirty && signupform.sex.$invalid">
                                    <small class="" ng-show="signupform.sex.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="sex" id="sex" ui-select2 class="form-control form-control-sm select2" data-placeholder="Jenis Kelamin" ng-model="model.sex" required>
                                    <option value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option value="PEREMPUAN">PEREMPUAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="golongan_darah">Golongan Darah &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.golongan_darah.$dirty && signupform.golongan_darah.$invalid">
                                    <small class="" ng-show="signupform.golongan_darah.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="golongan_darah" id="golongan_darah" ui-select2 class="form-control form-control-sm select2" data-placeholder="Golongan darah" ng-options="item as item for item in golonganDarah track by item" ng-model="model.golongan_darah" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="agama">Agama &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.agama.$dirty && signupform.agama.$invalid">
                                    <small class="" ng-show="signupform.agama.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="agama" id="agama" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pilih Agama--" ng-options="item as item for item in agama" ng-model="model.agama" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="pendidikan">Pendidikan Terakhir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.pendidikan.$dirty && signupform.pendidikan.$invalid">
                                    <small class="" ng-show="signupform.pendidikan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="pendidikan" id="pendidikan" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pendidikan terakhir--" ng-options="item as item for item in pendidikan" ng-model="model.pendidikan_terakhir" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gelar_terakhir">Gelar Terakhir &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.gelar_terakhir.$dirty && signupform.gelar_terakhir.$invalid">
                                    <small class="" ng-show="signupform.gelar_terakhir.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="gelar_terakhir" id="gelar_terakhir" ng-model="model.gelar_terakhir" placeholder="Gelar Terakhir" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.pekerjaan.$dirty && signupform.pekerjaan.$invalid">
                                    <small class="" ng-show="signupform.pekerjaan.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="pekerjaan" id="pekerjaan" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pekerjaan--" ng-options="item as item for item in pekerjaan" ng-model="model.pekerjaan" required>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="gereja_asal">Asal gereja &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.gereja_asal.$dirty && signupform.gereja_asal.$invalid">
                                    <small class="" ng-show="signupform.gereja_asal.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="gereja_asal" id="gereja_asal" ng-model="model.asal_gereja" placeholder="Asal Gereja" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_ayah">Nama Ayah &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nama_ayah.$dirty && signupform.nama_ayah.$invalid">
                                    <small class="" ng-show="signupform.nama_ayah.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="nama_ayah" id="nama_ayah" ng-model="model.nama_ayah" placeholder="Nama ayah" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_ibu">Nama ibu &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nama_ibu.$dirty && signupform.nama_ibu.$invalid">
                                    <small class="" ng-show="signupform.nama_ibu.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="nama_ibu" id="nama_ibu" ng-model="model.nama_ibu" placeholder="Nama ibu" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="suku">Asal Suku &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.suku.$dirty && signupform.suku.$invalid">
                                    <small class="" ng-show="signupform.suku.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <input type="text" class="form-control form-control-sm" name="suku" id="suku" ng-model="model.suku" placeholder="Suku asal" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status_domisili">Status Domisili &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.status_domisili.$dirty && signupform.status_domisili.$invalid">
                                    <small class="" ng-show="signupform.status_domisili.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="status_domisili" id="status_domisili" ui-select2 class="form-control form-control-sm select2" data-placeholder="Status domisili" ng-model="model.status_domisili" required>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Tidak Tetap">Tidak Tetap</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nikah_gereja">Nikah Gereja &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.nikah_gereja.$dirty && signupform.nikah_gereja.$invalid">
                                    <small class="" ng-show="signupform.nikah_gereja.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="nikah_gereja" ng-model="model.nikah_gereja" id="nikah_gereja" ui-select2 class="form-control form-control-sm select2" data-placeholder="Status domisili" required>
                                    <option value="0">Belum</option>
                                    <option value="1">Sudah</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="disabilitas">Disabilitas &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.disabilitas.$dirty && signupform.disabilitas.$invalid">
                                    <small class="" ng-show="signupform.disabilitas.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="disabilitas" ng-model="model.disabilitas" id="disabilitas" ui-select2 class="form-control form-control-sm select2" data-placeholder="Status domisili" required>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status_narkoba">Status Narkoba &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.status_narkoba.$dirty && signupform.status_narkoba.$invalid">
                                    <small class="" ng-show="signupform.status_narkoba.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="status_narkoba" ng-model="model.status_narkoba" id="status_narkoba" ui-select2 class="form-control form-control-sm select2" data-placeholder="Status domisili" required>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Baptis -->
                    <div class="row mt-4" style="padding: 0rem 1rem;">
                        <div class="col text-center" style="background-color:yellow;">
                            <label for=" status_domisili">Jika <strong>SUDAH</strong> Baptis, SIDI dan Nikah wajib
                                mengisi nama gereja dan tanggal pelaksanaannya</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Baptis</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tempar_baptis">Nama Gereja &nbsp;</label>

                                <input type="text" class="form-control form-control-sm" name="tempar_baptis" id="tempar_baptis" ng-model="baptis.nama_gereja" placeholder="Gereja tempat baptis">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tanggal_baptis">Tanggal Baptis &nbsp;</label>

                                <input type="date" class="form-control form-control-sm" name="tanggal_baptis" id="tanggal_baptis" ng-model="baptis.tanggal_baptis">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="berkas_baptis">Surat Baptis;</label>
                                <input type="file" class="form-control form-control-sm" name="berkas_baptis" accept="image/*, application/pdf" id="berkas_baptis" ng-model="baptis.berkas" base-sixty-four-input>

                            </div>
                        </div>
                    </div>
                    <!-- SIDI -->
                    <div class="row mt-2">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Sidi</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tempar_sidi">Tempat SIDI &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" name="tempar_sidi" id="tempar_sidi" ng-model="sidi.nama_gereja" placeholder="Gereja tempat SIDI">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tanggal_sidi">Tanggal SIDI &nbsp;</label>

                                <input type="date" class="form-control form-control-sm" name="tanggal_sidi" id="tanggal_sidi" ng-model="sidi.tanggal_sidi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="berkas_sidi">Surat SIDI;</label>
                                <input type="file" class="form-control form-control-sm" name="berkas_sidi" accept="image/*, application/pdf" id="berkas_sidi" ng-model="sidi.berkas" base-sixty-four-input>

                            </div>
                        </div>
                    </div>
                    <!-- Nikah -->
                    <div class="row mt-2" ng-if="model.status_kawin && model.status_kawin == 'Kawin'">
                        <div class="col">
                            <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Data Nikah</h4>
                        </div>
                    </div>
                    <div class="row" ng-if="model.status_kawin && model.status_kawin == 'Kawin'">
                        <div class="col">
                            <div class="form-group">
                                <label for="tempar_nikah">Tempat Nikah &nbsp;</label>
                                <input type="text" class="form-control form-control-sm" name="tempar_nikah" id="tempar_nikah" ng-model="nikah.nama_gereja" placeholder="Gereja tempat SIDI">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tanggal_nikah">Tanggal Nikah &nbsp;</label>
                                <input type="date" class="form-control form-control-sm" name="tanggal_nikah" id="tanggal_nikah" ng-model="nikah.tanggal_nikah">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="berkas_nikah">Surat Nikah;</label>
                                <input type="file" class="form-control form-control-sm" name="berkas_nikah" accept="image/*, application/pdf" id="berkas_nikah" ng-model="nikah.berkas" base-sixty-four-input>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
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
</div>
<?= $this->endSection() ?>