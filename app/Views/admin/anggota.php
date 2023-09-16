<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <h3 class="page-title"> Data Anggota Jemaat </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Anggota Jemaat</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped table-bordered" id="table" width = "100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Gol. Darah</th>
                                    <th>Agama</th>
                                    <th>Hubungan Keluarga</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            // data: $scope.datas,
            ajax: '/anggota/read',
            order: [],
            columnDefs: [{
                targets: '_all',
                orderable: true
            }],
            scrollX: true,
            columns: [{
                    data: 'no'
                },
                {
                    data: 'aksi',
                    searchable: false,
                    ordering: false
                },
                {
                    data: 'nik',
                },
                {
                    data: 'nama'
                },
                {
                    data: 'gender'
                },
                {
                    data: 'tempat_lahir'
                },
                {
                    data: 'tanggal_lahir',
                    render: function(data, type, row) {
                        if (type === "sort" || type === "type") {
                            return data;
                        }
                        return moment(data).format("DD MMMM YYYY");
                    }
                },
                {
                    data: 'golongan_darah'
                },
                {
                    data: 'agama'
                },
                {
                    data: 'hubungan_keluarga'
                },
                {
                    data: 'pendidikan_terakhir'
                },
                {
                    data: 'pekerjaan'
                }
            ],
        }).columns.adjust();
    });
</script>
<?= $this->endSection() ?>