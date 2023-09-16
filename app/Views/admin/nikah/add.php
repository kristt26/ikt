<?= $this->extend('admin/nikah/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <div class="d-flex justify-content-between border-bottom-2 mb-3">
        <h4 class=""><strong>PENDAFTARAN NIKAH</strong></h4>
        <button class="btn btn-secondary btn-sm" style="color: black;" onclick="history.back()">
            <span class="mdi mdi-arrow-left-bold"></span> Kembali
        </button>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="keluarga">Anggota Jemaat</label>
            <select name="jemaat" id="jemaat" class="form-control form-control-sm js-example-basic-single" ng-model="jemaat" required ng-change="setPin(jemaat)">
                <option value=""></option>
            </select>
        </div>
    </div>
    <form name="signupform" class="forms-sample" ng-submit="save()">
        <div ng-if="model">
            <div class="row">
                <div class="col">
                    <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Biodata Jemaat</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir &nbsp;</label>
                        <input type="text" class="form-control form-control-sm" name="tempat_lahir" id="tempat_lahir" ng-model="model.anggotas.tempat_lahir" placeholder="Tempat Lahir" disabled>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir &nbsp;</label>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-calendar-check"></i></span>
                            <input type="text" class="form-control form-control-sm" name="tanggal_lahir" id="tanggal_lahir" ng-model="model.anggotas.tanggal_lahir" disabled>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="sex">Jenis Kelamin &nbsp;</label>
                        <input type="text" class="form-control form-control-sm" name="sex" id="sex" ng-model="model.anggotas.sex" disabled>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="hubungan">Hubungan keluarga &nbsp;</label>
                        <input type="text" class="form-control form-control-sm" name="hubungan_keluarga" id="hubungan_keluarga" ng-model="model.anggotas.hubungan_keluarga" disabled>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="alamat">Hubungan keluarga</label>
                        <textarea class="form-control form-control-sm" name="alamat" id="alamat" ng-model="model.anggotas.alamat" disabled rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Orang Tua</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="nama_ayah">Nama Ayah &nbsp;</label>
                        <input type="text" class="form-control form-control-sm" name="nama_ayah" id="nama_ayah" ng-model="model.anggotas.nama_ayah" disabled>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="nama_ibu">Nama ibu &nbsp;</label>
                        <input type="text" class="form-control form-control-sm" name="nama_ibu" id="nama_ibu" ng-model="model.anggotas.nama_ibu" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4 style="background-color: #b66dff; padding: 0.5rem 0.4rem;">Persyaratan</h4>
                </div>
            </div>
            <div class="row">
                <div class="col" ng-repeat="item in model.persyaratans">
                    <div class="form-group">
                        <label for="{{item.set}}">{{item.nama}};</label>
                        <input type="file" class="form-control form-control-sm" name="{{item.set}}" accept="image/*, application/pdf" id="{{item.set}}" maxsize="500" required ng-model="item.file" base-sixty-four-input>
                        <span style="color: red;" ng-show="signupform.{{item.set}}.$dirty && signupform.{{item.set}}.$invalid">
                            <small class="" ng-show="signupform.{{item.set}}.$error.maxsize">
                                Files must not exceed 500 KB
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" ng-disabled=signupform.$invalid class="btn btn-gradient-primary me-2 btn-sm">Simpan</button>
            <button type="reset" class="btn btn-dark btn-sm">Clear</button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?= $this->endSection() ?>