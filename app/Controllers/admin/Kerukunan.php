<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Kerukunan extends BaseController
{
    use ResponseTrait;
    protected $kerukunan;
    public function __construct()
    {
        $this->kerukunan = new \App\Models\KerukunanModel();
    }

    public function index()
    {
        return view('admin/kerukunan');
    }

    public function read()
    {
        return $this->respond($this->kerukunan->findAll());
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $this->kerukunan->insert($data);
        $data->id = $this->kerukunan->getInsertID();
        return $this->respond($data);
    }

    public function put()
    {
        $data = $this->request->getJSON();
        $this->kerukunan->update($data->id, $data);
        return $this->respond($data);
    }

    public function delete($id)
    {
        if ($this->kerukunan->delete($id)) {
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
