<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    use ResponseTrait;
    protected $user;
    public function __construct()
    {
        $this->user = new \App\Models\UserModel();
        // helper('logger');
    }
    public function index()
    {
        // logger('access', null);
        if (session()->get('is_Login') == true) {
            return redirect()->to(base_url());
        } else {
            $data = $this->user->countAllResults();
            if ($data == 0) {
                $this->user->insert(['username' => 'Administrator', 'password' => password_hash('Administrator#1', PASSWORD_DEFAULT)]);
            }
            return view('sign-in');
        }
    }

    public function check()
    {
        try {
            $data = $this->request->getJSON();
            $query = $this->user->where(['username' => $data->username])->first();
            if ($query != '') {
                    if (password_verify($data->password, $query['password'])) {
                        if ($query['deleted_at'] == NULL) {
                            $session = [
                                'uid'         => $query['id'],
                                'username'  => $query['username'],
                                'level'  => 'Admin',
                                'is_Login'  => TRUE
                            ];
                            session()->set($session);
                            return $this->respond($query);
                        } else {
                            return $this->failUnauthorized("Akun sudah di hapus");
                        }
                    } else {
                        return $this->failUnauthorized("Password salah");
                    }
            
            } else {
                return $this->failNotFound('Akun tidak terdaftar');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function logout()
    {
        // logger('logout', session()->get(), 'logout');
        session()->destroy();
        unset($_COOKIE['purple-free-banner']);
        // setcookie('purple-free-banner', null, -1, '/');
        return redirect()->to(base_url('login'));
    }

    public function check_session()
    {
        return $this->respond(session()->get('is_Login') == FALSE ? 0 : 1);
    }

    public function change_password()
    {
        $param = $this->request->getJSON();
        $data = $this->user->find(session()->get("uid"));
        if (password_verify($param->passwordLama, $data['password']) == false) {
            return $this->fail("Password lama salah");
        } else {
            $this->user->update(session()->get("uid"), ['password' => password_hash($param->passwordBaru, PASSWORD_DEFAULT)]);
            return $this->respond("Update password berhasil");
        }
    }

    public function confirm()
    {
        try {
            JWT::$leeway = 3600;
            $token = $this->request->getGet('token');
            $decoded = JWT::decode($token, new Key(TOKENJWT, 'HS256'));
            $item = $this->user->where("id", $decoded->id)->first();
            if ($item['status'] == '0') {
                $this->user->save(['id' => $decoded->id, 'status' => '2']);
                return view("thanks");
            } else {
                return view("thanks");
            }
        } catch (\Exception $e) {
            $this->respond(['message' => $e->getMessage()]);
            //  echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
