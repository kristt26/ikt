<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Decode;
use App\Models\UserModel;

class Email extends BaseController
{
    public function index()
    {
        $item = [
            'nama' => "ajaklsdjfakl",
            'email' => "kljaksldjlak",
            'username' => "ajdkljaslkf",
            'password' => "akljfdkla"
        ];
        return view('mail', $item);
    }

    public function sendEmail()
    {
        $user = new UserModel();
        $user->update("2", ['password' => password_hash("admin", PASSWORD_DEFAULT)]);
    }

    public function testing()
    {
        $jemaatKK = new \App\Models\AnggotaKeluargaModel();
        $data = $jemaatKK->where('anggota_jemaat_id', 1208)->first();
        dd($data);
    }
}
