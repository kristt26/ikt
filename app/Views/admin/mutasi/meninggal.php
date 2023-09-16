<?= $this->extend('admin/mutasi/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <a href="<?= base_url("laporan/meninggal_excel") ?>" class="btn btn-primary btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-file-excel-box"></i> Export</a>
    <!-- <a href="<?= base_url("laporan/print?item=") . $url ?>" class="btn btn-info btn-sm mb-2" id="myButton" target="_blank"><i class="mdi mdi-printer"></i> Cetak</a> -->
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped table-bordered" id="meninggal" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>WIJK/KSP</th>
                    <th>Kode KK</th>
                    <th>NIK</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Meninggal</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur Saat <br> Meninggal</th>
                    <th>Penyebab</th>
                    <th>Unsur</th>
                    <th>Suku</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url() ?>/assets/js/set.js"></script>
<?= $this->endSection() ?>