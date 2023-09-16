<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'anggota';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'gender', 'golongan_darah', 'status_kawin', 'agama', 'hubungan_keluarga', 'pendidikan_terakhir', 'pekerjaan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function getAll()
    {
        $builder = $this->builder();
        // $builder->select("id, nik,
        // tempat_lahir,
        // nama,
        // nama as text,
        // tanggal_lahir,
        // gender,
        // golongan_darah,
        // status_kawin,
        // agama,
        // hubungan_keluarga,
        // pendidikan_terakhir,
        // pekerjaan");
        // dd($builder->getCompiledSelect());
        // $builder->orderBy('kk.kode_kk, anggota_jemaat.id');

        // return $this->paginate($total, 'group1', 2);
        return $builder;
    }

    public function getById($id)
    {
        $builder = $this->builder();
        $builder->select("
        anggota_jemaat.id,
        anggota_jemaat.users_id,
        anggota_jemaat.nik,
        anggota_jemaat.no_anggota,
        anggota_jemaat.tempat_lahir,
        anggota_jemaat.nama,
        anggota_jemaat`.`nama` as text,
        `anggota_jemaat`.`tanggal_lahir`,
        `anggota_jemaat`.`sex`,
        `anggota_jemaat`.`golongan_darah`,
        `anggota_jemaat`.`status_kawin`,
        `anggota_jemaat`.`agama`,
        `anggota_jemaat`.`hubungan_keluarga`,
        `anggota_jemaat`.`pendidikan_terakhir`,
        `anggota_jemaat`.`gelar_terakhir`,
        `anggota_jemaat`.`pekerjaan`,
        `anggota_jemaat`.`asal_gereja`,
        `anggota_jemaat`.`nama_ayah`,
        `anggota_jemaat`.`nama_ibu`,
        `anggota_jemaat`.`suku`,
        `anggota_jemaat`.`status_domisili`,
        `anggota_jemaat`.`unsur`,
        `kk`.`kode_kk`,
        `kk`.`lingkungan`,
        `kk`.`kelurahan`,
        `ksp`.`ksp`,
        `ksp`.`wijk_id`,
        `wijk`.`wijk`,
        `anggota_kk`.`status`,
        anggota_kk.id AS jemaat_kk_id,
        `jemaat_kk`.`ksp_id`");
        $builder->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT");
        $builder->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT");
        $builder->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT");
        $builder->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT");
        $builder->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT");
        $builder->where("`anggota_jemaat`.`id`='$id'");
        // dd($builder->getCompiledSelect());
        // $builder->orderBy('kk.kode_kk, anggota_jemaat.id');

        // return $this->paginate($total, 'group1', 2);
        return $builder->get()->getRow();
    }

    public function getData($total)
    {
        $jemaat_id = session()->get('jemaat_id');
        $builder = $this->builder();
        $builder->select("
        `anggota_jemaat`.*,
        `kk`.`kode_kk`,
        `kk`.`lingkungan`,
        `kk`.`kelurahan`,
        `ksp`.`ksp`,
        `ksp`.`wijk_id`,
        `wijk`.`wijk`,
        `baptis`.`nama_gereja` AS `tempat_baptis`,
        `baptis`.`tanggal_baptis`,
        `baptis`.`file` AS `file_baptis`,
        `sidi`.`nama_gereja` AS `tempat_sidi`,
        `sidi`.`tanggal_sidi`,
        `sidi`.`file` AS `file_sidi`,
        `nikah`.`nama_gereja` AS `tempat_nikah`,
        `nikah`.`tanggal_nikah`,
        `nikah`.`file` AS `file_nikah`,
        `anggota_kk`.`status`,
        `jemaat_kk`.`ksp_id`");
        $builder->join("baptis", "`baptis`.`anggotakk_id` = `anggota_jemaat`.`id`", "LEFT");
        $builder->join("nikah", "`nikah`.`anggotakk_id` = `anggota_jemaat`.`id`", "LEFT");
        $builder->join("sidi", "`sidi`.`anggotakk_id` = `anggota_jemaat`.`id`", "LEFT");
        $builder->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT");
        $builder->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT");
        $builder->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT");
        $builder->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT");
        $builder->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT");
        $builder->where("jemaat_kk.jemaat_id='$jemaat_id' AND anggota_jemaat.deleted_at IS NULL ORDER BY kk.kode_kk, anggota_jemaat.id");
        $builder->limit($total);

        return $this->builder->get()->getResult();
    }

    public function getUltahWeak($jemaat_id, $param)
    {
        $start = $param['start'];
        $end = $param['end'];
        $wijk_id = $param['wijk_id'];
        if ($param['jenis'] == '1') {
            $stringWhere = "DATE_FORMAT(tanggal_lahir, '%m-%d') >= DATE_FORMAT('$start', '%m-%d') AND DATE_FORMAT(tanggal_lahir, '%m-%d') <= DATE_FORMAT('$end', '%m-%d') AND `wijk`.`jemaat_id` = '$jemaat_id' AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL";
            $stringUmur = "timestampdiff(year,tanggal_lahir,curdate())+1 as umur";
        } else {
            $stringWhere = "DATE_FORMAT(tanggal_nikah, '%m-%d') >= DATE_FORMAT('$start', '%m-%d') AND DATE_FORMAT(tanggal_nikah, '%m-%d') <= DATE_FORMAT('$end', '%m-%d') AND `wijk`.`jemaat_id` = '$jemaat_id' AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL";
            $stringUmur = "timestampdiff(year,tanggal_nikah,curdate())+1 as umur";
        }

        $data = $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `nikah`.`file` AS `file_nikah`,
            `anggota_kk`.`status`,
            $stringUmur,
            jemaat_kk.kk_id,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `anggota_jemaat`
            LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE $stringWhere AND anggota_kk.status='Aktif'
        ORDER BY
            `kk`.`kode_kk`,
            `anggota_jemaat`.`id`")->getResult();
        return $data;
        // ((MONTH(tanggal_lahir)>=MONTH('$start') AND DAY(tanggal_lahir)>= DAY('$start')) AND (MONTH(tanggal_lahir)<=MONTH('$end') AND DAY(tanggal_lahir)<= DAY('$end'))) AND `wijk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL
        //     `wijk`.`jemaat_id` = '$jemaat_id' AND
        //     YearWeek(Concat(Year(Now()), '-', Month(`anggota_jemaat`.`tanggal_lahir`),
        // '-', Day(`anggota_jemaat`.`tanggal_lahir`))) = YearWeek(Now())+1
    }

    public function getGolonganDarah($jemaat_id, $param)
    {
        $data = $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`file` AS `file_sidi`,
            `nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `nikah`.`file` AS `file_nikah`,
            `anggota_kk`.`status`,
            timestampdiff(year,tanggal_lahir,curdate())+1 as umur,
            jemaat_kk.kk_id
        FROM
            `anggota_jemaat`
            LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `sidi` ON `sidi`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE
        golongan_darah = '" . $param . "' AND `jemaat_kk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL
        ORDER BY
            `kk`.`kode_kk`,
            `anggota_jemaat`.`id`")->getResult();
        return $data;
        // ((MONTH(tanggal_lahir)>=MONTH('$start') AND DAY(tanggal_lahir)>= DAY('$start')) AND (MONTH(tanggal_lahir)<=MONTH('$end') AND DAY(tanggal_lahir)<= DAY('$end'))) AND `wijk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL
        //     `wijk`.`jemaat_id` = '$jemaat_id' AND
        //     YearWeek(Concat(Year(Now()), '-', Month(`anggota_jemaat`.`tanggal_lahir`),
        // '-', Day(`anggota_jemaat`.`tanggal_lahir`))) = YearWeek(Now())+1
    }

    public function layak_baptis($jemaat_id, $wijk_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`, `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `anggota_kk`.`status`,
            `anggota_kk`.`kk_id`,
            `jemaat_kk`.`ksp_id`, timestampdiff(year,tanggal_lahir,curdate()) as umur")
            ->join("baptis", "baptis.anggotakk_id=anggota_jemaat.id", "LEFT")
            ->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND (nama_gereja IS NULL OR tanggal_baptis IS NULL) AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL");
    }

    public function sudah_baptis($jemaat_id, $wijk_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`, `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `baptis`.`pendeta`,
            `anggota_kk`.`status`,
            `anggota_kk`.`kk_id`,
            `jemaat_kk`.`ksp_id`, timestampdiff(year,tanggal_lahir,curdate()) as umur")
            ->join("baptis", "baptis.anggotakk_id=anggota_jemaat.id", "LEFT")
            ->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND (nama_gereja IS NOT NULL AND tanggal_baptis IS NOT NULL) AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL");
    }

    public function layak_sidi($jemaat_id, $wijk_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`, `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`pendeta`,
            `sidi`.`file` AS `file_sidi`,
            `anggota_kk`.`status`,
            `anggota_kk`.`kk_id`,
            `jemaat_kk`.`ksp_id`, timestampdiff(year,tanggal_lahir,curdate()) as umur")
            ->join("sidi", "sidi.anggotakk_id=anggota_jemaat.id", "LEFT")
            ->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND (nama_gereja IS NULL OR tanggal_sidi IS NULL) AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL");
        // ->where("timestampdiff(year,tanggal_lahir,curdate())>='17' AND status_kawin='BELUM KAWIN' AND jemaat_kk.jemaat_id='$jemaat_id' AND (nama_gereja IS NULL OR tanggal_sidi IS NULL)");
    }

    public function sudah_sidi($jemaat_id, $wijk_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`, `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`pendeta`,
            `sidi`.`file` AS `file_sidi`,
            `anggota_kk`.`status`,
            `anggota_kk`.`kk_id`,
            `jemaat_kk`.`ksp_id`, timestampdiff(year,tanggal_lahir,curdate()) as umur")
            ->join("sidi", "sidi.anggotakk_id=anggota_jemaat.id", "LEFT")
            ->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->where("jemaat_kk.jemaat_id='$jemaat_id' AND (nama_gereja IS NOT NULL AND tanggal_sidi IS NOT NULL) AND ksp.wijk_id='$wijk_id' AND anggota_jemaat.deleted_at IS NULL");
    }

    public function lansia($jemaat_id)
    {
        return $this->builder($this->table)
            ->select("`anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`, `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `anggota_kk`.`status`,
            `anggota_kk`.`kk_id`,
            `jemaat_kk`.`ksp_id`, timestampdiff(year,tanggal_lahir,curdate()) as umur,
            (select getKepala(anggota_kk.kk_id)) as kepala")
            ->join("baptis", "baptis.anggotakk_id=anggota_jemaat.id", "LEFT")
            ->join("anggota_kk", "`anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`", "LEFT")
            ->join("kk", "`kk`.`id` = `anggota_kk`.`kk_id`", "LEFT")
            ->join("jemaat_kk", "`kk`.`id` = `jemaat_kk`.`kk_id`", "LEFT")
            ->join("ksp", "`jemaat_kk`.`ksp_id` = `ksp`.`id`", "LEFT")
            ->join("wijk", "`ksp`.`wijk_id` = `wijk`.`id`", "LEFT")
            ->join('meninggal', "meninggal.anggota_kk_id=anggota_kk.id", "LEFT")
            ->where("timestampdiff(year,tanggal_lahir,curdate())>='65' AND jemaat_kk.jemaat_id='$jemaat_id' AND meninggal.id IS NULL AND anggota_jemaat.deleted_at IS NULL")
            ->orderBy('wijk');
    }


    public function unsur($jemaat_id, $param)
    {
        $start = $param['wijk_id'];
        $end = $param['unsur'];
        $data = $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`file` AS `file_sidi`,
            `nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `nikah`.`file` AS `file_nikah`,
            `anggota_kk`.`status`,
            jemaat_kk.kk_id,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `anggota_jemaat`
            LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `sidi` ON `sidi`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE
        DATE_FORMAT(tanggal_lahir, '%m-%d') >= DATE_FORMAT('$start', '%m-%d') AND DATE_FORMAT(tanggal_lahir, '%m-%d') <= DATE_FORMAT('$end', '%m-%d') AND `wijk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL
        ORDER BY
            `kk`.`kode_kk`,
            `anggota_jemaat`.`id`")->getResult();
        return $data;
    }

    public function disabilitas($jemaat_id)
    {
        $data = $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`file` AS `file_sidi`,
            `nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `nikah`.`file` AS `file_nikah`,
            `anggota_kk`.`status`,
            jemaat_kk.kk_id,
            (select getKepala(anggota_kk.kk_id)) as kepala
        FROM
            `anggota_jemaat`
            LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `sidi` ON `sidi`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE
        `wijk`.`jemaat_id` = '$jemaat_id' AND disabilitas='0' AND anggota_jemaat.deleted_at IS NULL
        ORDER BY
            `kk`.`kode_kk`,
            `anggota_jemaat`.`id`")->getResult();
        return $data;
    }

    public function LaporanAnggotaJemaat($jemaat_id = null, $wijk = null, $ksp_id = null, $unsur = null)
    {
        $where = !is_null($wijk) && is_null($ksp_id) && is_null($unsur) ? " AND ksp.wijk_id='" . $wijk . "'" : (!is_null($unsur) && !is_null($ksp_id) ? " AND ksp_id='" . $ksp_id . "' AND unsur='" . $unsur . "'" : (!is_null($wijk) && is_null($ksp_id) && !is_null($unsur) ? " AND ksp.wijk_id='" . $wijk . "' AND unsur='" . $unsur . "'" : (!is_null($ksp_id) || is_null($unsur) ? " AND ksp_id='" . $ksp_id . "'" : (is_null($wijk) && is_null($ksp_id) || !is_null($unsur) ? " AND unsur='" . $unsur . "'" : ""))));
        $data =  $this->db->query("SELECT
            `anggota_jemaat`.*,
            `kk`.`kode_kk`,
            `ksp`.`ksp`,
            `wijk`.`wijk`,
            (select getKepala(anggota_kk.kk_id)) as kepala,
            timestampdiff(year,tanggal_lahir,curdate()) as umur
        FROM
            `anggota_jemaat`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `kk` ON `anggota_kk`.`kk_id` = `kk`.`id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE anggota_kk.status='Aktif' AND jemaat_kk.jemaat_id = '$jemaat_id' $where order by kode_kk, anggota_jemaat.id asc");
        return $data->getResult();
    }

    public function getBelumBaptis($q)
    {
        $jemaat_id = session()->get('jemaat_id');
        $data = $this->db->query("SELECT
            `anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nama` as text,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `kk`.`alamat`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,
            `anggota_kk`.`status`,
            timestampdiff(year,tanggal_lahir,curdate())+1 as umur,
            jemaat_kk.kk_id,
            jemaat_kk.id as jemaat_kk_id
        FROM
            `anggota_jemaat`
            LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
            LEFT JOIN `pendaftaran_detail` ON `anggota_jemaat`.`id` = `pendaftaran_detail`.`anggota_jemaat_id`
        WHERE
        `jemaat_kk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL AND (`baptis`.`nama_gereja` IS NULL OR `baptis`.`tanggal_baptis` IS NULL) AND pendaftaran_detail.id IS NULL AND `anggota_jemaat`.`nama` LIKE '%" . $q . "%'
        LIMIT 10")->getResult();
        return $data;
    }

    public function getBelumByKK($layanan_id)
    {
        if ($layanan_id == "1") {
            $string = "`baptis`.`nama_gereja` AS `tempat_baptis`,
            `baptis`.`tanggal_baptis`,
            `baptis`.`file` AS `file_baptis`,";
            $join = "LEFT JOIN `baptis` ON `baptis`.`anggotakk_id` = `anggota_jemaat`.`id`";
            $where = "AND (`baptis`.`nama_gereja` IS NULL OR `baptis`.`tanggal_baptis` IS NULL)";
        } else if ($layanan_id == "2") {
            $string = "`sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`,
            `sidi`.`file` AS `file_sidi`,";
            $join = "LEFT JOIN `sidi` ON `sidi`.`anggotakk_id` = `anggota_jemaat`.`id`";
            $where = "AND (`sidi`.`nama_gereja` IS NULL OR `sidi`.`tanggal_sidi` IS NULL)";
        } else {
            $string = "`nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `nikah`.`file` AS `file_nikah`,";
            $join = "LEFT JOIN `nikah` ON `nikah`.`anggotakk_id` = `anggota_jemaat`.`id`";
            $where = "AND (`nikah`.`nama_gereja` IS NULL OR `nikah`.`tanggal_nikah` IS NULL)";
        }
        helper('find');
        $uid = session()->get('uid');
        $dataUser = $this->db->query("SELECT
            `anggota_kk`.`kk_id`,
            `anggota_jemaat`.`nama`
        FROM
            `users`
            LEFT JOIN `anggota_jemaat` ON `users`.`id` = `anggota_jemaat`.`users_id`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
        WHERE users.id='$uid'")->getRow();
        $anggotas = $this->db->query("SELECT
            `anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nama` as text,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `kk`.`alamat`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            $string
            `anggota_kk`.`status`,
            timestampdiff(year,tanggal_lahir,curdate())+1 as umur,
            jemaat_kk.kk_id,
            jemaat_kk.id as jemaat_kk_id
        FROM
            `anggota_jemaat`
            $join
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` =
        `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE anggota_jemaat.deleted_at IS NULL $where AND `kk`.`id` = '$dataUser->kk_id'")->getResult();

        $daftars = $this->db->query("SELECT
                `anggota_jemaat`.`id`
            FROM
                `pendaftaran`
                LEFT JOIN `jemaat_kk` ON `jemaat_kk`.`id` = `pendaftaran`.`jemaat_kk_id`
                LEFT JOIN `pendaftaran_detail` ON `pendaftaran`.`id` =
            `pendaftaran_detail`.`pendaftaran_id`
                LEFT JOIN `anggota_jemaat` ON `pendaftaran_detail`.`anggota_jemaat_id` =
            `anggota_jemaat`.`id`
            WHERE kk_id='$dataUser->kk_id' AND layanan_id='$layanan_id'")->getResult();
        $data = [];
        if (count($daftars) == 0) {
            return $anggotas;
        } else {
            foreach ($anggotas as $key => $anggota) {
                if (!find_item($daftars, $anggota->id)) {
                    array_push($anggota);
                }
            }
            return $data;
        }
    }

    public function getByKK($kk_id)
    {
        return $this->db->query("SELECT
            `anggota_jemaat`.*,
            `baptis`.`nama_gereja` AS tempat_baptis,
            `baptis`.`tanggal_baptis`,
            `nikah`.`nama_gereja` AS `tempat_nikah`,
            `nikah`.`tanggal_nikah`,
            `sidi`.`nama_gereja` AS `tempat_sidi`,
            `sidi`.`tanggal_sidi`
        FROM
            `anggota_jemaat`
            LEFT JOIN `anggota_kk`
        ON `anggota_jemaat`.`id` = `anggota_kk`.`anggota_jemaat_id`
            LEFT JOIN `baptis` ON `anggota_jemaat`.`id` = `baptis`.`anggotakk_id`
            LEFT JOIN `sidi` ON `anggota_jemaat`.`id` = `sidi`.`anggotakk_id`
            LEFT JOIN `nikah` ON `anggota_jemaat`.`id` = `nikah`.`anggotakk_id`
        WHERE anggota_kk.status='Aktif' AND kk_id = '$kk_id'")->getResultArray();
    }

    public function getJemaatAktif($q)
    {
        $jemaat_id = session()->get('jemaat_id');
        $data = $this->db->query("SELECT
            `anggota_jemaat`.`id`,
            `anggota_jemaat`.`users_id`,
            `anggota_jemaat`.`nik`,
            `anggota_jemaat`.`no_anggota`,
            `anggota_jemaat`.`tempat_lahir`,
            `anggota_jemaat`.`nama`,
            `anggota_jemaat`.`nama` as text,
            `anggota_jemaat`.`tanggal_lahir`,
            `anggota_jemaat`.`sex`,
            `anggota_jemaat`.`golongan_darah`,
            `anggota_jemaat`.`status_kawin`,
            `anggota_jemaat`.`agama`,
            `anggota_jemaat`.`hubungan_keluarga`,
            `anggota_jemaat`.`pendidikan_terakhir`,
            `anggota_jemaat`.`gelar_terakhir`,
            `anggota_jemaat`.`pekerjaan`,
            `anggota_jemaat`.`asal_gereja`,
            `anggota_jemaat`.`nama_ayah`,
            `anggota_jemaat`.`nama_ibu`,
            `anggota_jemaat`.`suku`,
            `anggota_jemaat`.`status_domisili`,
            `anggota_jemaat`.`unsur`,
            `kk`.`kode_kk`,
            `kk`.`lingkungan`,
            `kk`.`kelurahan`,
            `kk`.`alamat`,
            `ksp`.`ksp`,
            `ksp`.`wijk_id`,
            `wijk`.`wijk`,
            `anggota_kk`.`status`,
            `anggota_kk`.`id` AS anggota_kk_id,
            timestampdiff(year,tanggal_lahir,curdate())+1 as umur,
            jemaat_kk.kk_id,
            jemaat_kk.id as jemaat_kk_id
        FROM
            `anggota_jemaat`
            LEFT JOIN `anggota_kk` ON `anggota_kk`.`anggota_jemaat_id` = `anggota_jemaat`.`id`
            LEFT JOIN `kk` ON `kk`.`id` = `anggota_kk`.`kk_id`
            LEFT JOIN `jemaat_kk` ON `kk`.`id` = `jemaat_kk`.`kk_id`
            LEFT JOIN `ksp` ON `jemaat_kk`.`ksp_id` = `ksp`.`id`
            LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        WHERE
        `jemaat_kk`.`jemaat_id` = '$jemaat_id' AND anggota_jemaat.deleted_at IS NULL AND anggota_kk.status='Aktif' AND `anggota_jemaat`.`nama` LIKE '%" . $q . "%'
        LIMIT 10")->getResult();
        return $data;
    }
}
