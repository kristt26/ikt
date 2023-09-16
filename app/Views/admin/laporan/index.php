<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Laporan </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-2 grid-margin">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Laporan</h4>
            </div>
            <div class="card-body" style="padding-left: 0.2rem; padding-right: 0rem;">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" role="tablist" aria-orientation="vertical">
                        <?php foreach ($lists as $key => $list) : ?>
                            <a href="<?= base_url("laporan?item=") . $list['url'] ?>" style="padding: 0.4rem 0.2rem !important; font-size: 13px !important;" class="nav-link <?= $url == $list['url'] ? 'active' : '' ?>" id="<?= $list['url'] ?>" data-bs-target="#<?= $list['url'] ?>" role="tab" aria-controls="<?= $list['url'] ?>" aria-selected="true"><?= $list['text'] ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan <?= $title ?></h4>
            </div>
            <div class="card-body">
                <?= $this->renderSection('laporan') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>