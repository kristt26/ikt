<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;
    protected $wijk;
    protected $jiwa;
    protected $kk;
    protected $conn;
    public function __construct()
    {
        $this->conn = \Config\Database::connect();
    }
    public function index()
    {
        if ((!session()->get('is_Login'))) {
            return redirect()->to(base_url('/login?#'));
            exit();
        } 
        else return view('home');
    }
}
