<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Wilayah extends BaseController
{
    use ResponseTrait;
    protected $wilayah;
    public function __construct()
    {
        $this->wilayah = new \App\Models\WilayahModel();
    }

    public function index()
    {
        return view('admin/wilayah');
    }

    public function read()
    {
        return $this->respond($this->wilayah->findAll());
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $this->wilayah->insert($data);
        $data->id = $this->wilayah->getInsertID();
        return $this->respond($data);
    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->wilayah->update($data->id, $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        if ($this->wilayah->delete($id)) {
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
