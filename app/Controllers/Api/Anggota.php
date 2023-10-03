<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AnggotaKKModel;

class Anggota extends ResourceController
{

    // create
    public function store()
    {
        $anggota = new AnggotaKKModel();
        return $this->respond($anggota->findAll());
    }
    public function create()
    {
    }
    // single user
    public function show($id = null)
    {
    }
    // update
    public function update($id = null)
    {
    }
    // delete
    public function delete($id = null)
    {
    }
}
