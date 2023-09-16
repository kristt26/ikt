<?= $this->extend('layout/layout1') ?>

<?= $this->section('content') ?>

<div class="page-header">

    <h3 class="page-title"> Data Keluarga </h3>

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="#">Home</a></li>

            <li class="breadcrumb-item active" aria-current="page">Anggota Jemaat</li>

        </ol>

    </nav>

</div>

<div class="row">

    <ui-view></ui-view>

</div>

<?= $this->endSection() ?>