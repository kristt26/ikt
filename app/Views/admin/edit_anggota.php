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
                                <input type="text" class="form-control form-control-sm" ng-model="datas.nomor" readonly>
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
                                <label for="gender">Jenis Kelamin &nbsp;</label>
                                <span style="color: red;" ng-show="signupform.gender.$dirty && signupform.gender.$invalid">
                                    <small class="" ng-show="signupform.gender.$error.required">
                                        Wajib*
                                    </small>
                                </span>
                                <select name="gender" id="gender" ui-select2 class="form-control form-control-sm select2" data-placeholder="Jenis Kelamin" ng-model="model.gender" required>
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
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

                    </div>
                    <div class="row">
                        <div class="col">
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
                    </div>
                    <div class="d-flex justify-content-between mb-5">
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