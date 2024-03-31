<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class FrenzyFire extends BaseController
{
    use ResponseTrait;
    private $db;
    private $frenzy_totem_list_builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->frenzy_totem_list_builder = $this->db->table('frenzy_totem_list');
    }

    function test(){
        $builder = $this->db->table('frenzy_totem_list');
        $query = $builder->get();

        $this->response->noCache();
        $this->response->setContentType('application/json');
        return $this->response->setJSON($query);
    }
}