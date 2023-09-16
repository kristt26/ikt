<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Data extends BaseController
{
    use ResponseTrait;
    public function __construct() {
        $this->kk = new \App\Models\KkModel();
        $this->jemaat = new \App\Models\JemaatKKModel();
    }
    public function index()
    {
        // $kk = $this->kk->query("SELECT
        //     `kk`.`id` AS kk_id,
        //     `kk`.`ksp_id`,
        //     `wijk`.`jemaat_id`,
        //     'Aktif' AS `status`
        // FROM
        //     `kk`
        //     LEFT JOIN `ksp` ON `kk`.`ksp_id` = `ksp`.`id`
        //     LEFT JOIN `wijk` ON `ksp`.`wijk_id` = `wijk`.`id`
        //     LEFT JOIN `jemaat` ON `wijk`.`jemaat_id` = `jemaat`.`id`")->getResultArray();
        // $result = $this->jemaat->insertBatch($kk);
        // return $this->respond($result);
    }
}