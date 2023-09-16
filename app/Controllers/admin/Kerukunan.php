<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Kerukunan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->wijk = new \App\Models\WijkModel();
        helper("logger");
    }

    public function index()
    {
        return view('admin/wijk');
    }

    public function read()
    {
        logger('notice', '');
        return $this->respond($this->wijk->where('wijk.jemaat_id', session()->get('jemaat_id'))->findAll());
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $data->jemaat_id = session()->get('jemaat_id');
        $this->wijk->insert($data);
        $data->id = $this->wijk->getInsertID();
        logger('notice', $data);
        return $this->respond($data);
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
        $data = $this->wijk->find($id);
        if ($this->wijk->delete($id)) {
            logger('notice', $data);
            return $this->respond(true);
        } else {
            return $this->fail(false);
        }
    }
}
