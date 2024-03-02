<?php

namespace App\Models;
use CodeIgniter\Model;

class MapleAccountModel extends Model
{
    protected $table            = 'maple_account';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'beanfun_id', 'role'];
}

?>