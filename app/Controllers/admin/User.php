<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;
use Firebase\JWT\JWT;

class User extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->users = new \App\Models\UserModel();
        $this->anggota = new \App\Models\AnggotaKKModel();
        $this->userRole = new \App\Models\UserRoleModel();
        $this->jemaatKK = new \App\Models\JemaatKKModel();
        $this->conn = \Config\Database::connect();
        $this->decode = new \App\Libraries\Decode();
        helper('logger');
    }

    public function index()
    {
        return view('admin/manajemen_user');
    }

    public function read()
    {
        $data['anggota'] = $this->users->getJemaat(session()->get("jemaat_id"))->getResult();
        $data['data'] = $this->jemaatKK->getUserJemaat(session()->get("jemaat_id"))->get()->getResult();
        logger('notice', '');
        return $this->respond($data);
    }

    public function getData()
    {
        $data = $this->jemaatKK->getUserJemaat(session()->get("jemaat_id"));
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->add('aksi', function ($row) {
                return '<button id="edit" onclick="myFunction(' . $row->id . ')" class="btn btn-warning btn-sm btn-rounded btn-icon" style="padding: 6px;" data-target="' . $row->id . '" ng-click="edit()"><i class="mdi mdi-grease-pencil"></i></button>';
            })
            ->toJson(true);
        return $item;
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $data->status = "0";
        $data->password = password_hash($data->pin, PASSWORD_DEFAULT);
        try {
            $this->conn->transBegin();
            $this->users->insert($data);
            $data->id = $this->users->getInsertID();
            $this->userRole->insert(['roles_id' => '4', 'users_id' => $data->id]);
            $this->anggota->update($data->anggota_jemaat_id, ['users_id' => $data->id]);
            if ($this->conn->transStatus()) {
                $data->exp = time() + (60 * 60);
                $data->tokenconfirm = JWT::encode((array)$data, TOKENJWT, 'HS256');
                $this->decode->sendMail(view('admin/mail', (array)$data), $data->email);
                $this->conn->transCommit();
                logger('notice', $data);
                return $this->respond($data);
            } else {
                $this->conn->transRollback();
                return $this->fail("Gagal menambah data");
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->wijk->update($data->id, $data);
        logger('notice', $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        $data = $this->users->find($id);
        if ($this->wijk->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
