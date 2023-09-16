<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('temp') ?>/assets/images/favicon.ico" />
    <title>Document</title>
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
    <link href="<?= base_url('temp') ?>/assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url('temp') ?>/assets/css/report.css" rel="stylesheet" />
</head>

<body>
    <div class="container" ng-controller="detailKeluargaController" id="cetak">
        <div class="col-12">
            <table>
                <tr>
                    <td class="text-center" style="font-size:16px"><strong>GEREJA KRISTEN INJILI DI TANAH PAPUA <br> DAFTAR JEMAAT <?= strtoupper($setStatus) ?> BAPTIS
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 mb-3">
            <table class="border thick" width="99%">
                <thead>
                    <tr class="border thick">
                        <th class="text-center">No</th>
                        <th class="text-center">WIJK</th>
                        <th class="text-center">KSP</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Tanggal Lahir</th>
                        <th class="text-center">Umur</th>
                        <th class="text-center">Status Hub. <br>Dalam<br>Keluarga</th>
                        <th class="text-center">Pekerjaan</th>
                        <th class="text-center">Nama Ayah</th>
                        <th class="text-center">Intra</th>
                        <?php if ($setStatus == 'sudah') : ?>
                            <th class="text-center">Tanggal Baptis</th>
                            <th class="text-center">Tempat Baptis</th>
                            <th class="text-center">Nama Pendeta</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anggota as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value['wijk'] ?></td>
                            <td><?= $value['ksp'] ?></td>
                            <td><?= $value['kode_kk'] ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['sex'] ?></td>
                            <td><?= $value['tanggal_lahir'] ?></td>
                            <td><?= $value['umur'] ?></td>
                            <td><?= $value['hubungan_keluarga'] ?></td>
                            <td><?= $value['pekerjaan'] ?></td>
                            <td><?= $value['nama_ayah'] ?></td>
                            <td><?= $value['unsur'] ?></td>
                            <?php if ($setStatus == 'sudah') : ?>
                                <td><?= $value['tanggal_baptis'] ?></td>
                                <td><?= $value['tempat_baptis'] ?></td>
                                <td><?= $value['pendeta'] ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        function fnBrowserDetect() {

            let userAgent = navigator.userAgent;
            let browserName;

            if (userAgent.match(/chrome|chromium|crios/i)) {
                browserName = "chrome";
            } else if (userAgent.match(/firefox|fxios/i)) {
                browserName = "firefox";
            } else if (userAgent.match(/safari/i)) {
                browserName = "safari";
            } else if (userAgent.match(/opr\//i)) {
                browserName = "opera";
            } else if (userAgent.match(/edg/i)) {
                browserName = "edge";
            } else {
                browserName = "No browser detection";
            }

            return browserName;
        }
        printJS({
            printable: 'cetak',
            type: 'html',
            css: ["<?= base_url('temp') ?>/assets/css/style.css",
                "<?= base_url('temp') ?>/assets/css/report.css"
            ]
        })
        if (navigator.userAgent.toLowerCase().indexOf(fnBrowserDetect()) > -1) { // Chrome Browser Detected?
            window.PPClose = false; // Clear Close Flag
            window.PPClose = true; // Set Close Flag to OK.
        }
        window.onfocus = function() {
            window.close();
        }
        window.onfocusin = function() {
            window.close();
        }
        window.onfocusout = function() {
            window.close();
        }
        window.onblur = function() {
            window.close();
        }
    </script>
</body>

</html>