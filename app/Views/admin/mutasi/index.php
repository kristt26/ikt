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
                <div class="d-flex justify-content-between">
                    <?php if ($title != 'Add') : ?>
                        <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                            <?php foreach ($lists as $key => $list) : ?>
                                <li class="nav-item" role="presentation">
                                    <a href="<?= base_url("mutasi?item=") . $list['url'] ?>" class="nav-link <?= $url == $list['url'] ? 'active' : '' ?>" style="padding: 0.25rem 0.5rem;" data-bs-target="#<?= $list['url'] ?>" role="tab" aria-controls="<?= $list['url'] ?>" aria-selected="true"><?= $list['text'] ?>
                                        <?php if ($list['text'] == 'Pengajuan' && $item > 0) : ?>
                                            <sup><span class="badge bg-danger" style="border-radius: 1.125rem; padding: 0.3rem !important;"><?= $item ?></span></sup>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="border-bottom-2 mb-4"></div>
                    <?php endif; ?>
                    <?php if ($title == 'Pindah' || $title == 'Meninggal') : ?>
                        <a href="<?= base_url("mutasi?item=") . $add ?>" class="btn btn-primary btn-sm mb-2" id="myButton"><i class="mdi mdi-plus-circle"></i> Tambah</a>
                    <?php endif; ?>
                </div>
                <div class="border-bottom-2 mb-4"></div>
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <?= $this->renderSection('item') ?>
                    </div>
                </div>
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