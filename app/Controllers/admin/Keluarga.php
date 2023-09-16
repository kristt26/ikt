<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Decode;
use CodeIgniter\API\ResponseTrait;

class Keluarga extends BaseController
{
    use ResponseTrait;
    protected $keluarga;
    protected $anggota;
    protected $anggotaKK;
    protected $kerukunan;
    protected $wilayah;
    protected $conn;
    protected $decode;
    public function __construct()
    {
        $this->keluarga = new \App\Models\KeluargaModel();
        $this->anggota = new \App\Models\AnggotaModel();
        $this->anggotaKK = new \App\Models\AnggotaKeluargaModel();
        $this->kerukunan = new \App\Models\KerukunanModel();
        $this->wilayah = new \App\Models\WilayahModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
    }

    public function index()
    {
        return view('admin/pendataan');
    }

    public function read()
    {
        $data['dup'] = $this->conn->query("SELECT keluarga.nomor 
            FROM keluarga
            INNER JOIN (SELECT nomor
                        FROM   keluarga
                        GROUP  BY nomor
                        HAVING COUNT(id) > 1) dup
                    ON keluarga.nomor = dup.nomor
            ")->getResult();
        $data['keluarga'] = $this->keluarga->findAll();
        $data['wilayah'] = $this->wilayah->findAll();
        $data['kerukunan'] = $this->kerukunan->findAll();
        return $this->respond($data);
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $data->id = $this->decode->uid();
        try {
            $this->conn->transBegin();
            $this->keluarga->insert($data);
            $data->id = $this->keluarga->getInsertID();
            foreach ($data->anggota as $key => $value) {
                $value->id = $this->decode->uid();
                $this->anggota->insert($value);
                $this->anggotaKK->insert(['keluarga_id' => $data->id, 'anggota_id' => $value->id]);
            }
            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                return $this->respond($data);
            } else {
                throw new \Exception("Proses gagal", 1);
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
            // return $this->fail("Gagal menambah data");
        }
    }

    // public function put()
    // {
    //     $data = $this->request->getJSON();
    //     try {
    //         $this->conn->transBegin();
    //         $this->kk->update($data->id, $data);
    //         $this->jemaatKK->update($data->jemaat_kk_id, ['kk_id' => $data->id, 'ksp_id' => $data->ksp_id]);
    //         $dataAnggota = $this->anggota->asObject()->select("anggota_jemaat.*, anggota_kk.status")->join("anggota_kk", "anggota_kk.anggota_jemaat_id=anggota_jemaat.id")->where("anggota_kk.kk_id", $data->id)->findAll();
    //         foreach ($dataAnggota as $keyAnggota => $anggota) {
    //             if (find_item($data->anggota, $anggota->id) == false && $anggota->status == 'Aktif') {
    //                 $this->anggota->delete($anggota->id);
    //                 $this->anggotaKeluarga->where("anggota_jemaat_id", $anggota->id)->delete();
    //                 $this->baptis->where("anggotakk_id", $anggota->id)->delete();
    //                 $this->sidi->where("anggotakk_id", $anggota->id)->delete();
    //                 $this->nikah->where("anggotakk_id", $anggota->id)->delete();
    //             }
    //         }
    //         foreach ($data->anggota as $key => $value) {
    //             if (isset($value->id)) {
    //                 $this->anggota->update($value->id, $value);
    //             } else {
    //                 $this->anggota->insert($value);
    //                 $value->id = $this->anggota->getInsertID();
    //                 $this->anggotaKeluarga->insert(["anggota_jemaat_id" => $value->id, "status" => "Aktif", "kk_id" => $data->id]);
    //                 $value->baptis->anggotakk_id = $value->id;
    //                 $value->sidi->anggotakk_id = $value->id;
    //                 $value->nikah->anggotakk_id = $value->id;
    //             }
    //             !is_null($value->baptis) && isset($value->baptis->berkas) ? $value->baptis->file = $this->decode->decodebase64($value->baptis->berkas->base64) : false;
    //             !is_null($value->baptis) && isset($value->baptis->id)  ? $this->baptis->update($value->baptis->id, $value->baptis) : (!is_null($value->baptis) && !isset($value->baptis->id) ? $this->baptis->insert($value->baptis) : "");
    //             !is_null($value->baptis) && !isset($value->baptis->id) ? $value->baptis->id = $this->baptis->getInsertID() : false;

    //             !is_null($value->sidi) && isset($value->sidi->berkas) ? $value->sidi->file = $this->decode->decodebase64($value->sidi->berkas->base64) : false;
    //             !is_null($value->sidi) && isset($value->sidi->id)  ? $this->sidi->update($value->sidi->id, $value->sidi) : (!is_null($value->sidi) && !isset($value->sidi->id) ? $this->sidi->insert($value->sidi) : "");
    //             !is_null($value->sidi) && !isset($value->sidi->id) ? $value->sidi->id = $this->sidi->getInsertID() : false;

    //             !is_null($value->nikah) && isset($value->nikah->berkas) ? $value->nikah->file = $this->decode->decodebase64($value->nikah->berkas->base64) : false;
    //             !is_null($value->nikah) && isset($value->nikah->id)  ? $this->nikah->update($value->nikah->id, $value->nikah) : (!is_null($value->nikah) && !isset($value->nikah->id) ? $this->nikah->insert($value->nikah) : "");
    //             !is_null($value->nikah) && !isset($value->nikah->id) ? $value->nikah->id = $this->nikah->getInsertID() : false;
    //         }
    //         $this->conn->transCommit();
    //         logger('notice', $data);
    //         return $this->respond($data);
    //     } catch (\Throwable $th) {
    //         $this->conn->transRollback();
    //         return $this->fail($th->getMessage());
    //     }
    // }

    // public function delete($id)
    // {
    //     try {
    //         $this->conn->transBegin();
    //         $anggotakk = $this->anggotaKeluarga->asObject()->where('kk_id', $id)->findAll();
    //         $data = $this->kk->first($id);
    //         $this->kk->delete($id);
    //         foreach ($anggotakk as $key => $anggota) {
    //             $this->anggota->delete($anggota->anggota_jemaat_id);
    //         }
    //         if ($this->conn->transStatus()) {
    //             $this->conn->transCommit();
    //             logger('notice', $data);
    //             return $this->respond(true);
    //         } else {
    //             $this->conn->transRollback();
    //             return $this->fail("Gagal Hapus");
    //         }
    //     } catch (\Throwable $th) {
    //         $this->conn->transRollback();
    //         return $this->fail("Gagal Hapus");
    //     }
    // }

    // public function detail($id)
    // {
    //     return view('admin/detail_keluarga');
    // }

    // public function getDetail($id)
    // {
    //     $data = $this->kk->getDetail($id);
    //     $data->anggota = $this->anggota->asObject()->select("anggota_jemaat.*, anggota_kk.id as anggota_kk_id")->join('anggota_kk', 'anggota_kk.anggota_jemaat_id=anggota_jemaat.id')->where('kk_id', $data->id)->where('status', 'Aktif')->findAll();
    //     foreach ($data->anggota as $key => $anggota) {
    //         $anggota->baptis = $this->baptis->WHERE('anggotakk_id', $anggota->id)->first();
    //         $anggota->sidi = $this->sidi->WHERE('anggotakk_id', $anggota->id)->first();
    //         $anggota->nikah = $this->nikah->WHERE('anggotakk_id', $anggota->id)->first();
    //     }
    //     return $this->respond($data);
    // }

    // public function getById($id)
    // {
    //     $data = $this->kk->getDetail($id);
    //     $data->anggota = $this->anggota->asObject()->getById($id);
    //     foreach ($data->anggota as $key => $anggota) {
    //         $anggota->baptis = $this->baptis->WHERE('anggotakk_id', $anggota->id)->first();
    //         $anggota->sidi = $this->sidi->WHERE('anggotakk_id', $anggota->id)->first();
    //         $anggota->nikah = $this->nikah->WHERE('anggotakk_id', $anggota->id)->first();
    //     }
    //     return $this->respond($data);
    // }

    public function cetak($id)
    {
        $data = $this->keluarga->select("keluarga.*, wilayah.wilayah, kerukunan.kerukunan")
        ->join('wilayah', 'wilayah.id=keluarga.wilayah_id','left')
        ->join('kerukunan', 'kerukunan.id=keluarga.kerukunan_id','left')
        ->where('keluarga.id', $id)->first();
        $data['anggota'] = $this->anggotaKK->select('anggota.*')
            ->join('anggota', 'anggota.id=anggota_keluarga.anggota_id')
            ->where('keluarga_id', $id)->findAll();
        return view('admin/cetak_kk', $data);
    }

    // public function cetak_all()
    // {
    //     $param = $this->request->getGet();
    //     $data = $this->kk->laporanKeluarga(isset($param['wijk_id']) ? dekrip($param['wijk_id']) : NULL, isset($param['ksp_id']) ? dekrip($param['ksp_id']) : NULL);
    //     foreach ($data as $keyKel => $kel) {
    //         $data[$keyKel]['anggota'] = $this->anggota->getByKK($kel['id']);
    //     }
    //     $set['kk'] = $data;
    //     return view('admin/cetak_all_kk', $set);
    // }

    // public function pecah()
    // {
    //     $data = $this->request->getJSON();
    //     try {
    //         $this->conn->transBegin();
    //         $this->kk->insert($data);
    //         $data->id = $this->kk->getInsertID();
    //         $this->jemaatKK->insert(['jemaat_id' => session()->get('jemaat_id'), 'ksp_id' => $data->ksp_id, 'kk_id' => $data->id, 'status' => 'Aktif']);
    //         $jemaat_kk_id = $this->jemaatKK->getInsertID();
    //         foreach ($data->anggota as $key => $value) {
    //             if ($value->hubungan_keluarga == "KEPALA KELUARGA") {
    //                 $this->anggota->update($value->id, $value);
    //                 $this->anggotaKeluarga->where("anggota_jemaat_id", $value->id)->delete();
    //                 $this->anggotaKeluarga->insert(['anggota_jemaat_id' => $value->id, 'kk_id' => $data->id, 'status' => 'Aktif']);
    //             } else {
    //                 $value->kk_id = $data->id;
    //                 $this->anggota->insert($value);
    //                 $value->id = $this->anggota->getInsertID();
    //                 $this->anggotaKeluarga->insert(['anggota_jemaat_id' => $value->id, 'kk_id' => $data->id, 'status' => 'Aktif']);
    //                 $value->baptis->anggotakk_id = $value->id;
    //                 $value->sidi->anggotakk_id = $value->id;
    //                 $value->nikah->anggotakk_id = $value->id;

    //                 $value->baptis->file = isset($value->baptis->berkas) ? $this->decode->decodebase64($value->baptis->berkas->base64) : null;
    //                 $this->baptis->insert($value->baptis);
    //                 $value->baptis->id = $this->baptis->getInsertID();

    //                 $value->sidi->file = isset($value->sidi->berkas) ? $this->decode->decodebase64($value->sidi->berkas->base64) : null;
    //                 $this->sidi->insert($value->sidi);
    //                 $value->sidi->id = $this->sidi->getInsertID();

    //                 $value->nikah->file = isset($value->nikah->berkas) ? $this->decode->decodebase64($value->nikah->berkas->base64) : null;
    //                 $this->nikah->insert($value->nikah);
    //                 $value->nikah->id = $this->nikah->getInsertID();
    //             }
    //         }
    //         if ($this->conn->transStatus()) {
    //             $this->conn->transCommit();
    //             return $this->respond($this->jemaatKK->getById($jemaat_kk_id));
    //         } else {
    //             $this->conn->transRollback();
    //             return $this->fail(false);
    //         }
    //     } catch (\Throwable $th) {
    //         $this->conn->transRollback();
    //         return $this->fail($th->getMessage());
    //     }
    // }
}