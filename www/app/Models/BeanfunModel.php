<?php

namespace App\Models;
use CodeIgniter\Model;

class BeanfunModel extends Model
{
    protected $table      = 'beanfun_account';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account', 'email', 'phone', 'phone_owner'];
}

?>