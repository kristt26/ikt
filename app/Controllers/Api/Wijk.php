<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\WijkModel;

class Wijk extends ResourceController
{

    // create
    public function store()
    {
        $wijk = new WijkModel();
        return $this->respond($wijk->findAll());
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
