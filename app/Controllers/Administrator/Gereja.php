<?php

namespace App\Controllers\Administrator;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Gereja extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->jemaat = new \App\Models\JemaatModel();
        $this->user = new \App\Models\UserModel();
        $this->userrole = new \App\Models\UserRoleModel();
        $this->sek = new \App\Models\SekretarisModel();
        $this->decode = new \App\Libraries\Decode();
        $this->conn = \Config\Database::connect();
    }

    public function index()
    {
        return view('administrator/gereja');
    }

    public function read()
    {
        $data = $this->jemaat->select("jemaat.id, jemaat.klasis_id, jemaat.jemaat, sekretaris.nama, users.username, users.email")->join("sekretaris", "sekretaris.jemaat_id=jemaat.id")->join("users", "users.id = sekretaris.users_id")->findAll();
        return $this->respond($data);
    }

    public function post()
    {
        try {
            $data = $this->request->getJSON();
            $password = $this->decode->random_strings(10);
            $data->password = password_hash($password, PASSWORD_DEFAULT);
            $cek = $this->user->where('username', $data->username)->orWhere('email', $data->email)->countAllResults();
            if ($cek == 0) {
                $this->conn->transBegin();
                $this->user->insert($data);
                $users_id = $this->user->getInsertID();
                $this->jemaat->insert(['klasis_id' => session()->get('klasis_id'), 'jemaat' => $data->jemaat]);
                $data->id = $this->jemaat->getInsertID();
                $this->userrole->insert(['users_id' => $users_id, 'roles_id' => '2']);
                $this->sek->insert(['jemaat_id' => $data->id, 'users_id' => $users_id, 'nama' => $data->nama]);
                if ($this->conn->transStatus()) {
                    $this->conn->transCommit();
                    $item = [
                        'nama' => $data->nama,
                        'email' => $data->email,
                        'username' => $data->username,
                        'password' => $password,
                        'id' => $data->id,
                        'klasis_id' => session()->get('klasis_id'),
                        'jemaat' => $data->jemaat

                    ];
                    if ($this->decode->sendMail(view('mail', $item), $data->email)) {
                        return $this->respondCreated($item);
                    } else {
                        throw new \Exception("Gagal kirim pesan", 1);
                    }
                } else {
                    $this->conn->transRollback();
                    return $this->fail(true);
                }
            } else {
                return $this->failValidationError("Username telah terdaftar");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->ksp->update($data->id, $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        if ($this->ksp->delete($id)) {
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
