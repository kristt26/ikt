<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;

class Anggota extends BaseController
{
    use ResponseTrait;
    protected $keluarga;
    protected $anggota;
    public function __construct()
    {
        $this->keluarga = new \App\Models\KeluargaModel();
        $this->anggota = new \App\Models\AnggotaModel();
    }

    public function index()
    {
        return view('admin/anggota');
    }

    public function add($id)
    {
        return view('admin/add_anggota');
    }
    public function edit($id)
    {
        return view('admin/edit_anggota');
    }

    public function read()
    {

        $db = \Config\Database::connect();
        // $customers = $db->table('anggota_jemaat')->select('nik, nama');
        $data = $this->anggota->getAll();
        // $data['anggota'] = $this->anggota->getData($total);
        // $data['totalItem'] = $this->anggota->countAllResults();
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->add('aksi', function ($row) {
                return '<a href="anggota/edit/' . $row->id . '" class="btn btn-warning btn-sm btn-rounded btn-icon" style="padding: 6px;"><i class="mdi mdi-grease-pencil"
            data-bs-toggle="tooltip" data-bs-placement="top"
            title="Ubah data"></i></a>';
            })
            ->toJson(true);
        // $a = $item['data'];
        // ->toJson(true);

        return $item;
    }

    public function post()
    {
        $value = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $this->anggota->insert($value);
            $value->id = $this->anggota->getInsertID();
            $this->anggotaKeluarga->insert(['anggota_jemaat_id' => $value->id, 'kk_id' => $value->kk_id, 'status' => 'Aktif']);
            if (isset($value->baptis)) {
                $value->baptis->anggotakk_id = $value->id;
                $value->baptis->file = isset($value->baptis->berkas) ? $this->decode->decodebase64($value->baptis->berkas->base64) : NULL;
                $this->baptis->insert($value->baptis);
                $value->baptis->id = $this->baptis->getInsertID();
            }
            if (isset($value->sidi)) {
                $value->sidi->anggotakk_id = $value->id;
                $value->sidi->file = isset($value->sidi->berkas) ? $this->decode->decodebase64($value->sidi->berkas->base64) : NULL;
                $this->sidi->insert($value->sidi);
                $value->sidi->id = $this->sidi->getInsertID();
            }
            if (isset($value->nikah)) {
                $value->nikah->anggotakk_id = $value->id;
                $value->nikah->file = isset($value->nikah->berkas) ? $this->decode->decodebase64($value->nikah->berkas->base64) : NULL;
                $this->nikah->insert($value->nikah);
                $value->nikah->id = $this->nikah->getInsertID();
            }
            $this->conn->transCommit();
            logger('notice', $value);
            return $this->respond($value);
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail("Gagal menambah data");
        }
    }

    public function put()
    {
        $value = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $this->anggota->update($value->id, $value);
            !is_null($value->baptis) && isset($value->baptis->berkas) ? $value->baptis->file = $this->decode->decodebase64($value->baptis->berkas->base64) : false;
            !is_null($value->baptis) && isset($value->baptis->id)  ? $this->baptis->update($value->baptis->id, $value->baptis) : (!is_null($value->baptis) && !isset($value->baptis->id) ? $this->baptis->insert($value->baptis) : "");
            !is_null($value->baptis) && !isset($value->baptis->id) ? $value->baptis->id = $this->baptis->getInsertID() : false;

            !is_null($value->sidi) && isset($value->sidi->berkas) ? $value->sidi->file = $this->decode->decodebase64($value->sidi->berkas->base64) : false;
            !is_null($value->sidi) && isset($value->sidi->id)  ? $this->sidi->update($value->sidi->id, $value->sidi) : (!is_null($value->sidi) && !isset($value->sidi->id) ? $this->sidi->insert($value->sidi) : "");
            !is_null($value->sidi) && !isset($value->sidi->id) ? $value->sidi->id = $this->sidi->getInsertID() : false;

            !is_null($value->nikah) && isset($value->nikah->berkas) ? $value->nikah->file = $this->decode->decodebase64($value->nikah->berkas->base64) : false;
            !is_null($value->nikah) && isset($value->nikah->id)  ? $this->nikah->update($value->nikah->id, $value->nikah) : (!is_null($value->nikah) && !isset($value->nikah->id) ? $this->nikah->insert($value->nikah) : "");
            !is_null($value->nikah) && !isset($value->nikah->id) ? $value->nikah->id = $this->nikah->getInsertID() : false;
            $this->conn->transCommit();
            logger('notice', $value);
            return $this->respond($value);
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail("Gagal menambah data");
        }
    }

    public function delete($id)
    {
        $data = $this->anggota->first($id);
        if ($this->ksp->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }

    public function ultah()
    {
        // $data = $this->anggota->getUltahWeak();
        return view('admin/ultah');
    }

    public function getUltah()
    {
        $param = $this->request->getGet();
        $data = $this->anggota->getUltahWeak(session()->get('jemaat_id'), $param);
        foreach ($data as $key => $value) {
            $itemKK = $this->jemaatKk->getKepalaKeluarga(session()->get('jemaat_id'), $value->kk_id);
            $value->kepala_keluarga = !is_null($itemKK) ? $itemKK->nama : "";
        }
        return $this->respond($data);
    }

    public function getGolonganDarah()
    {
        $param = $this->request->getGet('darah');
        $data = $this->anggota->getGolonganDarah(session()->get('jemaat_id'), dekrip($param));
        foreach ($data as $key => $value) {
            $itemKK = $this->jemaatKk->getKepalaKeluarga(session()->get('jemaat_id'), $value->kk_id);
            $value->kepala_keluarga = !is_null($itemKK) ? $itemKK->nama : "";
        }
        return $this->respond($data);
    }

    public function getId($id = null)
    {
        $data['anggota'] = $this->anggota->asObject()->select("anggota_jemaat.*, anggota_kk.kk_id")->join("anggota_kk", "anggota_kk.anggota_jemaat_id=anggota_jemaat.id")->where("anggota_jemaat.id='$id'")->first();
        $data['kk'] = $this->kk->getDetail($data['anggota']->kk_id);
        $data['baptis'] = $this->baptis->where("anggotakk_id", $data['anggota']->id)->first();
        $data['sidi'] = $this->sidi->where("anggotakk_id", $data['anggota']->id)->first();
        $data['nikah'] = $this->nikah->where("anggotakk_id", $data['anggota']->id)->first();
        $data['kk']->anggota = $this->anggota->asObject()->select("anggota_jemaat.*")->join('anggota_kk', 'anggota_kk.anggota_jemaat_id=anggota_jemaat.id')->where('kk_id', $data['kk']->id)->first();
        return $this->respond($data);
    }

    public function layak_baptis()
    {
        $data = $this->anggota->layak_baptis(session()->get("jemaat_id"));
        return $this->respond($data);
    }

    public function getById($id)
    {
        return $this->respond($this->anggota->asObject()->getById($id));
    }
}
