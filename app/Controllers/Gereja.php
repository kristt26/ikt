<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Gereja extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->gereja = new \App\Models\GerejaModel();
        $this->jemaat = new \App\Models\JemaatModel();
        $this->conn = \Config\Database::connect();
    }

    public function read()
    {
        return $this->respond($this->gereja->select("gereja.*, gereja.nama AS text")->like("nama", $this->request->getVar('q'))->findAll());
    }

    public function post()
    {
        $params = $this->request->getJSON();
        $this->gereja->insert($params);
        return $this->respond(true);
    }
}
