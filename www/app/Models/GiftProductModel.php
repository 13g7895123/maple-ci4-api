<?php

namespace App\Models;
use CodeIgniter\Model;

class GiftProductModel extends Model
{
    protected $table            = 'gift_product';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'price'];
}

?>