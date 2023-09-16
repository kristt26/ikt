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
        <?php foreach ($kk as $key1 => $keluarga) :
            if (count($keluarga['anggota']) > 0) :
        ?>

                <div class="page-break">
                    <div class="col-12">
                        <table>
                            <tr>
                                <td class="text-center" style="font-size:16px"><strong>GEREJA KRISTEN INJILI DI TANAH PAPUA <br>
                                        KLASIS
                                        <?= strtoupper($keluarga['klasis']) ?></strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-5">
                                <table width="99%">
                                    <tr style="height:20px">
                                        <td width="30%">No. Keluarga</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['kode_kk'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Provinsi</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['provinsi'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Kabupaten</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['kabupaten'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Kepala Keluarga</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['anggota'][0]['nama'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td class="align-top" width="30%">Alamat</td>
                                        <td class="align-top" width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['alamat'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Kode Pos</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['kode_pos'] ?></td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-4">
                                <table width="99%">
                                    <tr style="height:20px">
                                        <td width="30%">Distrik/Kel/Kamp</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['kecamatan'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Klasis</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['klasis'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Lingkungan</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['lingkungan'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Jemaat</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['jemaat'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">WIJK/KSP</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= $keluarga['wijk'] . "/" . $keluarga['ksp'] ?></td>
                                    </tr>
                                    <tr style="height:20px">
                                        <td width="30%">Telepon/Hp</td>
                                        <td width="1%">:</td>
                                        <td>&nbsp<?= ($keluarga['telepon'] != "-" ? $keluarga['telepon'] : "") . ($keluarga['telepon'] != "-" && $keluarga['hp'] != "-" ? "/" : "") . ($keluarga['hp'] != "-" ? $keluarga['hp'] : "") ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <table class="border thick" width="99%">
                            <thead>
                                <tr class="border thick">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Lengkap</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Tempat Lahir</th>
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th class="text-center">Golongan<br>Darah</th>
                                    <th class="text-center">Agama</th>
                                    <th class="text-center">Status<br>Baptis</th>
                                    <th class="text-center">Status<br>Sidi</th>
                                    <th class="text-center">Status<br>Nikah</th>
                                    <th class="text-center">Tanggal<br>Nikah</th>
                                    <th class="text-center">Tempat<br>Nikah</th>
                                </tr>
                                <tr class="border thick">
                                    <th class="text-center">1</th>
                                    <th class="text-center">2</th>
                                    <th class="text-center">3</th>
                                    <th class="text-center">4</th>
                                    <th class="text-center">5</th>
                                    <th class="text-center">6</th>
                                    <th class="text-center">7</th>
                                    <th class="text-center">8</th>
                                    <th class="text-center">9</th>
                                    <th class="text-center">10</th>
                                    <th class="text-center">11</th>
                                    <th class="text-center">12</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($keluarga['anggota'] as $key => $value) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['nama'] ?></td>
                                        <td><?= $value['sex'] ?></td>
                                        <td><?= $value['tempat_lahir'] ?></td>
                                        <td><?= $value['tanggal_lahir'] ?></td>
                                        <td><?= $value['golongan_darah'] ?></td>
                                        <td><?= $value['agama'] ?></td>
                                        <td>
                                            <?= $value['tanggal_baptis'] != NULL && $value['tempat_baptis'] != NULL ? "Sudah" : "Belum" ?>
                                        </td>
                                        <td>
                                            <?= $value['tanggal_sidi'] != NULL && $value['tempat_sidi'] != NULL ? "Sudah" : "Belum" ?>
                                        </td>
                                        <td>
                                            <?= $value['tanggal_nikah'] != NULL && $value['tempat_nikah'] != NULL ? "Sudah" : "Belum" ?>
                                        </td>
                                        <td>
                                            <?= $value['tanggal_nikah'] ? $value['tanggal_nikah'] : "" ?>
                                        </td>
                                        <td>
                                            <?= $value['tempat_nikah'] ? $value['tempat_nikah'] : "" ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                for ($i = 1; $i <= (10 - count($keluarga['anggota'])); $i++) : ?>
                                    <tr>
                                        <td><?= $i + count($keluarga['anggota']) ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="border thick" width="99%">
                            <thead>
                                <tr class="border thick">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Status Hub. <br>Dalam<br>Keluarga</th>
                                    <th class="text-center">Pendidikan<br>Terakhir</th>
                                    <th class="text-center">Gelar<br>Terakhir</th>
                                    <th class="text-center">Pekerjaan</th>
                                    <th class="text-center">Asal Gereja </th>
                                    <th class="text-center">Nama Ibu</th>
                                    <th class="text-center">Nama Ayah</th>
                                    <th class="text-center">Suku</th>
                                    <th class="text-center">Intra</th>
                                    <th class="text-center">Status<br>Domisili</th>
                                </tr>
                                <tr class="border thick">
                                    <th class="text-center">13</th>
                                    <th class="text-center">14</th>
                                    <th class="text-center">15</th>
                                    <th class="text-center">16</th>
                                    <th class="text-center">17</th>
                                    <th class="text-center">18</th>
                                    <th class="text-center">19</th>
                                    <th class="text-center">20</th>
                                    <th class="text-center">21</th>
                                    <th class="text-center">22</th>
                                    <th class="text-center">23</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($keluarga['anggota'] as $key => $value) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['hubungan_keluarga'] ?></td>
                                        <td><?= $value['pendidikan_terakhir'] ?></td>
                                        <td><?= $value['gelar_terakhir'] ?></td>
                                        <td><?= $value['pekerjaan'] ?></td>
                                        <td><?= $value['asal_gereja'] ?></td>
                                        <td><?= $value['nama_ibu'] ?></td>
                                        <td><?= $value['nama_ayah'] ?></td>
                                        <td><?= $value['suku'] ?></td>
                                        <td><?= $value['unsur'] ?></td>
                                        <td><?= $value['status_domisili'] ?></td>

                                    <?php endforeach;
                                for ($i = 1; $i <= (10 - count($keluarga['anggota'])); $i++) : ?>
                                    <tr>
                                        <td><?= $i + count($keluarga['anggota']) ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        printJS({
            printable: 'cetak',
            type: 'html',
            css: ["<?= base_url('temp') ?>/assets/css/style.css",
                "<?= base_url('temp') ?>/assets/css/report.css"
            ]
        })
        window.onfocus = function() {
            // window.close();
        }
    </script>
</body>

</html>