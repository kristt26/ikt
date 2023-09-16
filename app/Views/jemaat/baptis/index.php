<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Layanan Baptis </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <?php if ($title != 'Add') : ?>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Baptis</li>
            <?php endif; ?>
            <?php if ($title == 'Add') : ?>
                <li class="breadcrumb-item"><a href="<?= base_url("layanan_baptis?item=") . $url ?>">Manajemen Baptis</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftarkan</li>
            <?php endif; ?>
        </ol>
    </nav>
</div>
<div class="row" ng-controller="layananBaptisController">
    <div class="col-md-12  mb-3">
        <div class="card">
            <div class="card-body" style="padding-top: 2rem; padding-bottom: 0.5rem;">
                <?php if ($title != 'Add') : ?>
                    <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                        <?php foreach ($lists as $key => $list) : ?>
                            <li class="nav-item" role="presentation">
                                <a href="<?= base_url("layanan_baptis?item=") . $list['url'] ?>" class="nav-link <?= $url == $list['url'] ? 'active' : '' ?>" style="padding: 0.25rem 0.5rem;" data-bs-target="#<?= $list['url'] ?>" role="tab" aria-controls="<?= $list['url'] ?>" aria-selected="true"><?= $list['text'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="border-bottom-2 mb-4"></div>
                <?php endif; ?>
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <?= $this->renderSection('item') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>