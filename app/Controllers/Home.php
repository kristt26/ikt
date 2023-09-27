<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KeluargaModel;
use App\Models\KerukunanModel;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;
    protected $keluarga;
    protected $anggota;
    protected $kerukunan;
    protected $conn;
    public function __construct()
    {
        $this->conn = \Config\Database::connect();
        $this->keluarga = new KeluargaModel();
        $this->anggota = new AnggotaModel();
        $this->kerukunan = new KerukunanModel();
    }
    public function index()
    {
        if ((!session()->get('is_Login'))) {
            return redirect()->to(base_url('/login?#'));
            exit();
        } else {
            $data = $this->conn->query("SELECT (SELECT COUNT(*) FROM keluarga WHERE deleted_at is null) as keluarga, 
            (SELECT COUNT(*) FROM anggota WHERE deleted_at is null) as anggota,
            (SELECT COUNT(*) FROM kerukunan) as kerukunan")->getRowArray();
            return view('home', $data);
        } 
        // if (session()->get('level') == 'Admin') {
        //     $jiwas = $this->jiwa->getAll()->get()->getResult();
        //     $kks = $this->kk->getAll();
        //     $data['total_jiwa'] = 0;
        //     $data['total_kk'] = 0;
        //     $data['total_belum_baptis'] = 0;
        //     $data['total_baptis'] = 0;
        //     $data['total_belum_sidi'] = 0;
        //     $data['total_sidi'] = 0;
        //     $data['total_belum_nikah'] = 0;
        //     $data['total_nikah'] = 0;
        //     $data['total_pkb'] = 0;
        //     $data['total_pw'] = 0;
        //     $data['total_pam'] = 0;
        //     $data['total_par'] = 0;
        //     $data['total_janda'] = 0;
        //     $data['total_duda'] = 0;
        //     $wijks = $this->wijk->asObject()->where('jemaat_id', session()->get('jemaat_id'))->findAll();
        //     foreach ($wijks as $wijk) {
        //         $wijk->jumlah_jiwa = 0;
        //         $wijk->jumlah_kk = 0;
        //         $wijk->jumlah_belum_baptis = 0;
        //         $wijk->jumlah_baptis = 0;
        //         $wijk->jumlah_belum_sidi = 0;
        //         $wijk->jumlah_sidi = 0;
        //         $wijk->jumlah_belum_nikah = 0;
        //         $wijk->jumlah_nikah = 0;
        //         $wijk->jumlah_pkb = 0;
        //         $wijk->jumlah_pw = 0;
        //         $wijk->jumlah_pam = 0;
        //         $wijk->jumlah_par = 0;
        //         $wijk->jumlah_janda = 0;
        //         $wijk->jumlah_duda = 0;
        //         foreach ($jiwas as $key => $jiwa) {
        //             if ($jiwa->wijk_id == $wijk->id) {
        //                 $wijk->jumlah_jiwa += 1;
        //                 if ($jiwa->tanggal_baptis == null || $jiwa->tempat_baptis == null) {
        //                     $wijk->jumlah_belum_baptis += 1;
        //                 }
        //                 if ($jiwa->tanggal_baptis != null && $jiwa->tempat_baptis != null) {
        //                     $wijk->jumlah_baptis += 1;
        //                 }
        //                 if ($jiwa->tanggal_sidi == null || $jiwa->tempat_sidi == null) {
        //                     $wijk->jumlah_belum_sidi += 1;
        //                 }
        //                 if ($jiwa->tanggal_sidi != null && $jiwa->tempat_sidi != null) {
        //                     $wijk->jumlah_sidi += 1;
        //                 }
        //                 if (($jiwa->tanggal_nikah == null || $jiwa->tempat_nikah == null)) {
        //                     $wijk->jumlah_belum_nikah += 1;
        //                 }
        //                 if ($jiwa->tanggal_nikah != null && $jiwa->tempat_nikah != null  && $jiwa->status_kawin == 'Kawin') {
        //                     $wijk->jumlah_nikah += 1;
        //                 }
        //                 if ($jiwa->unsur == 'PKB') {
        //                     $wijk->jumlah_pkb += 1;
        //                 }
        //                 if ($jiwa->unsur == 'PW') {
        //                     $wijk->jumlah_pw += 1;
        //                 }
        //                 if ($jiwa->unsur == 'PAM') {
        //                     $wijk->jumlah_pam += 1;
        //                 }
        //                 if ($jiwa->unsur == 'PAR') {
        //                     $wijk->jumlah_par += 1;
        //                 }
        //                 if ($jiwa->status_kawin == 'Janda') {
        //                     $wijk->jumlah_janda += 1;
        //                 }
        //                 if ($jiwa->status_kawin == 'Duda') {
        //                     $wijk->jumlah_duda += 1;
        //                 }
        //             }
        //         }
        //         foreach ($kks as $key => $kk) {
        //             if ($kk->wijk_id == $wijk->id) {
        //                 $wijk->jumlah_kk += 1;
        //             }
        //         }
        //         $data['total_jiwa'] +=  $wijk->jumlah_jiwa;
        //         $data['total_kk'] += $wijk->jumlah_kk;
        //         $data['total_belum_baptis'] += $wijk->jumlah_belum_baptis;
        //         $data['total_baptis'] += $wijk->jumlah_baptis;
        //         $data['total_belum_sidi'] += $wijk->jumlah_belum_sidi;
        //         $data['total_sidi'] += $wijk->jumlah_sidi;
        //         $data['total_belum_nikah'] += $wijk->jumlah_belum_nikah;
        //         $data['total_nikah'] += $wijk->jumlah_nikah;
        //         $data['total_pkb'] += $wijk->jumlah_pkb;
        //         $data['total_pw'] += $wijk->jumlah_pw;
        //         $data['total_pam'] += $wijk->jumlah_pam;
        //         $data['total_par'] += $wijk->jumlah_par;
        //         $data['total_janda'] += $wijk->jumlah_janda;
        //         $data['total_duda'] += $wijk->jumlah_duda;
        //     }
        //     $jemaat_id = session()->get("jemaat_id");
        //     $data['wijks'] = $wijks;
        //     $data['birt_week'] = $this->conn->query("SELECT
        //         `anggota_jemaat`.*,
        //         `kk`.`kode_kk`,
        //         `kk`.`lingkungan`,
        //         `kk`.`kelurahan`,
        //         `ksp`.`ksp`,
        //         `ksp`.`wijk_id`,
        //         `wijk`.`wijk`,
        //         `baptis`.`nama_gereja` AS `tempat_baptis`,
        //         `baptis`.`tanggal_baptis`,
        //         `baptis`.`file` AS `file_baptis`,
        //         `sidi`.`nama_gereja` AS `tempat_sidi`,
        //         `sidi`.`tanggal_sidi`,
        //         `sidi`.`file` AS `file_sidi`,
        //         `nikah`.`nama_gereja` AS `tempat_nikah`,
        //         `nikah`.`tanggal_nikah`,
        //         `nikah`.`file` AS `file_nikah`,
        //         `anggota_kk`.`status`
        //     FROM
        //         `anggota_jemaat`
        //         LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`
        //         LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`
        //         LEFT JOIN `sidi` ON `sidi`.`anggotakk_id` = `anggota_jemaat`.`id`
        //         LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        //     `anggota_jemaat`.`id`
        //         LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
        //         LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
        //         LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
        //         LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        //     WHERE
        //         `wijk`.`jemaat_id` = '$jemaat_id' AND
        //         YearWeek(Concat(Year(Now()), '-', Month(`anggota_jemaat`.`tanggal_lahir`),
        //     '-', Day(`anggota_jemaat`.`tanggal_lahir`))) = YearWeek(Now())+1
        //     ORDER BY
        //         `kk`.`kode_kk`,
        //         `anggota_jemaat`.`id`")->getNumRows();
        //     return view('home', $data);
        // } else if (session()->get('level') == 'Jemaat') {
        //     return view('jemaat/index');
        // } else if (session()->get('level') == 'Administrator') {
        //     return view('administrator/index');
        // }
    }
    // public function read()
    // {
    //     $jiwas = $this->jiwa->getAll();
    //     $kks = $this->kk->getAll();
    //     $data['total_jiwa'] = 0;
    //     $data['total_kk'] = 0;
    //     $data['total_belum_baptis'] = 0;
    //     $data['total_baptis'] = 0;
    //     $data['total_belum_sidi'] = 0;
    //     $data['total_sidi'] = 0;
    //     $data['total_belum_nikah'] = 0;
    //     $data['total_nikah'] = 0;
    //     $data['total_pkb'] = 0;
    //     $data['total_pw'] = 0;
    //     $data['total_pam'] = 0;
    //     $data['total_par'] = 0;
    //     $wijks = $this->wijk->asObject()->findAll();
    //     foreach ($wijks as $wijk) {
    //         $wijk->jumlah_jiwa = 0;
    //         $wijk->jumlah_kk = 0;
    //         $wijk->jumlah_belum_baptis = 0;
    //         $wijk->jumlah_baptis = 0;
    //         $wijk->jumlah_belum_sidi = 0;
    //         $wijk->jumlah_sidi = 0;
    //         $wijk->jumlah_belum_nikah = 0;
    //         $wijk->jumlah_nikah = 0;
    //         $wijk->jumlah_pkb = 0;
    //         $wijk->jumlah_pw = 0;
    //         $wijk->jumlah_pam = 0;
    //         $wijk->jumlah_par = 0;
    //         foreach ($jiwas as $key => $jiwa) {
    //             if ($jiwa->wijk_id == $wijk->id) {
    //                 $wijk->jumlah_jiwa += 1;
    //                 if ($jiwa->tanggal_baptis == null && $jiwa->tempat_baptis == null) {
    //                     $wijk->jumlah_belum_baptis += 1;
    //                 }
    //                 if ($jiwa->tanggal_baptis != null && $jiwa->tempat_baptis != null) {
    //                     $wijk->jumlah_baptis += 1;
    //                 }
    //                 if ($jiwa->tanggal_sidi == null && $jiwa->tempat_sidi == null) {
    //                     $wijk->jumlah_belum_sidi += 1;
    //                 }
    //                 if ($jiwa->tanggal_sidi != null && $jiwa->tempat_sidi != null) {
    //                     $wijk->jumlah_sidi += 1;
    //                 }
    //                 if ($jiwa->tanggal_nikah == null && $jiwa->tempat_nikah == null) {
    //                     $wijk->jumlah_belum_nikah += 1;
    //                 }
    //                 if ($jiwa->tanggal_nikah != null && $jiwa->tempat_nikah != null) {
    //                     $wijk->jumlah_nikah += 1;
    //                 }
    //                 if ($jiwa->unsur == 'PKB') {
    //                     $wijk->jumlah_pkb += 1;
    //                 }
    //                 if ($jiwa->unsur == 'PW') {
    //                     $wijk->jumlah_pw += 1;
    //                 }
    //                 if ($jiwa->unsur == 'PAM') {
    //                     $wijk->jumlah_pam += 1;
    //                 }
    //                 if ($jiwa->unsur == 'PAR') {
    //                     $wijk->jumlah_par += 1;
    //                 }
    //             }
    //         }
    //         foreach ($kks as $key => $kk) {
    //             if ($kk->wijk_id == $wijk->id) {
    //                 $wijk->jumlah_kk += 1;
    //             }
    //         }
    //         $data['total_jiwa'] +=  $wijk->jumlah_jiwa;
    //         $data['total_kk'] += $wijk->jumlah_kk;
    //         $data['total_belum_baptis'] += $wijk->jumlah_belum_baptis;
    //         $data['total_baptis'] += $wijk->jumlah_baptis;
    //         $data['total_belum_sidi'] += $wijk->jumlah_belum_sidi;
    //         $data['total_sidi'] += $wijk->jumlah_sidi;
    //         $data['total_belum_nikah'] += $wijk->jumlah_belum_nikah;
    //         $data['total_nikah'] += $wijk->jumlah_nikah;
    //         $data['total_pkb'] += $wijk->jumlah_pkb;
    //         $data['total_pw'] += $wijk->jumlah_pw;
    //         $data['total_pam'] += $wijk->jumlah_pam;
    //         $data['total_par'] += $wijk->jumlah_par;

    //         // $wijk->jumlah_jiwa = $this->jiwa->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('wijk_id', $wijk->id)->countAllResults();
    //         // $wijk->jumlah_kk = $this->kk->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('wijk_id', $wijk->id)->countAllResults();
    //         // $wijk->jumlah_belum_baptis = $this->jiwa->join('baptis', 'anggotakk.id=baptis.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_baptis IS NULL AND nama_gereja IS NULL AND wijk_id='$wijk->id'")->countAllResults();
    //         // $wijk->jumlah_baptis = $this->jiwa->join('baptis', 'anggotakk.id=baptis.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_baptis IS NOT NULL AND nama_gereja IS NOT NULL")->countAllResults();
    //         // $wijk->jumlah_belum_sidi = $this->jiwa->join('sidi', 'anggotakk.id=sidi.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_sidi IS NULL AND nama_gereja IS NULL AND wijk_id='$wijk->id'")->countAllResults();
    //         // $wijk->jumlah_sidi = $this->jiwa->join('sidi', 'anggotakk.id=sidi.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_sidi IS NOT NULL AND nama_gereja IS NOT NULL")->countAllResults();
    //         // $wijk->jumlah_belum_nikah = $this->jiwa->join('nikah', 'anggotakk.id=nikah.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_nikah IS NULL AND nama_gereja IS NULL AND wijk_id='$wijk->id'")->countAllResults();
    //         // $wijk->jumlah_nikah = $this->jiwa->join('nikah', 'anggotakk.id=nikah.anggotakk_id')->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where("tanggal_nikah IS NOT NULL AND nama_gereja IS NOT NULL")->countAllResults();
    //         // $wijk->jumlah_pkb = $this->jiwa->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('unsur', 'PKB')->where('wijk_id', $wijk->id)->countAllResults();
    //         // $wijk->jumlah_pw = $this->jiwa->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('unsur', 'PW')->where('wijk_id', $wijk->id)->countAllResults();
    //         // $wijk->jumlah_pam = $this->jiwa->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('unsur', 'PAM')->where('wijk_id', $wijk->id)->countAllResults();
    //         // $wijk->jumlah_par = $this->jiwa->join('kk', 'kk.id=anggotakk.kk_id')->join('ksp', 'ksp.id=kk.ksp_id')->join('wijk', 'wijk.id=ksp.wijk_id')->where('wijk.jemaat_id', session()->get('jemaat_id'))->where('unsur', 'PAR')->where('wijk_id', $wijk->id)->countAllResults();
    //     }
    //     $data['wijks'] = $wijks;

    //     return $this->respond($data);
    // }

    // public function cekKK()
    // {
    //     $kk = $this->conn->query("SELECT
    //     kk.id,
    //     kk.kode_kk
    //   FROM
    //     jemaat_kk
    //     LEFT JOIN kk ON jemaat_kk.kk_id = kk.id")->getResult();
    //     foreach ($kk as $key => $value) {
    //         $item = $this->jiwa->join('anggota_kk', 'anggota_kk.anggota_jemaat_id=anggota_jemaat.id')->where("kk_id", $value->id)->first();
    //         $value->kk = !is_null($item) ? $item['hubungan_keluarga'] : "Kosong";
    //     }
    //     return $this->respond($kk);
    // }

    // public function getLayanan()
    // {
    //     $pendaftaran = new \App\Models\PendaftaranModel();
    //     $data = [
    //         "baptis" => count($pendaftaran->getPengajuanAll("1")),
    //         "sidi" => count($pendaftaran->getPengajuanAll("2")),
    //         "nikah" => count($pendaftaran->getPengajuanAll("3")),
    //     ];
    //     return $this->respond($data);
    // }
}
