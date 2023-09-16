<?= $this->extend('jemaat/baptis/index') ?>
<?= $this->section('item') ?>
<div class="col-md-12">
    <a href="<?= base_url("laporan/excel?item=") . $url ?>" target="_blank" class="btn btn-primary btn-sm mb-2" id="myButton"><i class="mdi mdi-file-excel-box"></i> Export</a>
    <a href="<?= base_url("laporan/print?item=") . $url ?>" target="_blank" class="btn btn-info btn-sm mb-2" id="myButton"><i class="mdi mdi-printer"></i> Print</a>
    <div class="table-responsive">
        <table class="table table-sm table-hover table-striped table-bordered" id="layakSidi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>WIJK</th>
                    <th>KSP</th>
                    <th>Kode KK</th>
                    <th>Nama Jemaat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Gol. Darah</th>
                    <th>Status Perkawinan</th>
                    <th>Hubungan Keluarga</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>Suku</th>
                    <th>Unsur</th>
                    <th>Status Domisili</th>
                    <th>Sidi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>