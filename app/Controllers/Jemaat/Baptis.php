<?php

namespace App\Controllers\Jemaat;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Baptis extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->ksp = new \App\Models\KspModel();
        $this->wijk = new \App\Models\WijkModel();
        $this->anggota = new \App\Models\AnggotaKKModel();
        $this->pendaftaran = new \App\Models\PendaftaranModel();
        $this->pendaftaranDetail = new \App\Models\PendaftaranDetailModel();
        $this->kelengkapan = new \App\Models\KelengkapanModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
        helper("find");
    }
    public function index()
    {
        $list['lists'] = [
            ["url" => enkrip("pengajuan"), "text" => "Pengajuan"],
            ["url" => enkrip("proses"), "text" => "Proses"],
            ["url" => enkrip("selesai"), "text" => "Selesai"],
        ];
        $setItem = $this->request->getGet("item");
        if (is_null($setItem)) {
            $url = base_url('layanan_baptis') . '?item=' . enkrip("pengajuan");
            return redirect()->to($url);
        } else if (dekrip($setItem) == "pengajuan") {
            $list['title'] = "Pengajuan";
            $list['url'] = enkrip("pengajuan");
            $list['add'] = enkrip("add");
            return view('jemaat/baptis/pengajuan', $list);
        } else if (dekrip($setItem) == "proses") {
            $list['title'] = "Proses";
            $list['url'] = enkrip("proses");
            return view('jemaat/baptis/proses', $list);
        } else if (dekrip($setItem) == "selesai") {
            $list['title'] = "Selesai";
            $list['url'] = enkrip("selesai");
            return view('jemaat/baptis/selesai', $list);
        } else if (dekrip($setItem) == "add") {
            $list['title'] = "Add";
            $list['url'] = enkrip("proses");
            return view('jemaat/baptis/add', $list);
        } else if (dekrip($setItem) == "edit") {
            $list['title'] = "Add";
            $list['url'] = enkrip("proses");
            return view('jemaat/baptis/edit', $list);
        }
    }
    public function getPengajuan()
    {
        $data = $this->pendaftaran->getPengajuanByUser("1");
        return $this->respond($data);
    }

    public function getProses()
    {
        $data = $this->pendaftaran->getProsesByUser("1");
        return $this->respond($data);
    }

    public function getSelesai()
    {
        $data = $this->pendaftaran->getSelesaiByUser("1");
        return $this->respond($data);
    }

    public function add()
    {
        return $this->respond($this->anggota->getBelumByKK("1"));
    }

    public function edit()
    {
        return $this->respond($this->pendaftaran->getById("1", $this->request->getGet('set')));
    }

    public function post()
    {
        $item = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $this->pendaftaran->insert(['jemaat_kk_id' => $item->jemaat_kk_id, 'layanan_id' => $item->layanan_id, 'status' => $item->status]);
            $item->anggotas->pendaftaran_id = $this->pendaftaran->getInsertID();
            $this->pendaftaranDetail->insert($item->anggotas);
            foreach ($item->persyaratans as $key => $value) {
                $data = [
                    'persyaratan_id' => $value->id,
                    'pendaftaran_id' => $item->anggotas->pendaftaran_id,
                    'berkas' => $this->decode->decodebase64($value->file->base64)
                ];
                $this->kelengkapan->insert($data);
                // return $this->respond($data);
            }
            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                return $this->respondCreated(true);
            } else {
                $this->conn->transRollback();
                $this->fail("Error");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $item = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $this->pendaftaran->update($item->id, ['jemaat_kk_id' => $item->jemaat_kk_id, 'layanan_id' => $item->layanan_id, 'status' => $item->status]);
            foreach ($item->persyaratans as $key => $value) {
                if (isset($value->file)) {
                    if (unlink('assets/berkas/' . $value->berkas)) {
                        $value->berkas = $this->decode->decodebase64($value->file->base64);
                    } else {
                        throw new \Exception("Gagal mengubah data", 1);
                    }
                }
                $this->kelengkapan->update($value->id, $value);
            }
            if ($this->conn->transStatus()) {
                $this->conn->transCommit();
                return $this->respondCreated(true);
            } else {
                $this->conn->transRollback();
                $this->fail("Error");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }
}
