<?php

namespace App\Models;
use CodeIgniter\Model;

class GiftBuyerModel extends Model
{
    protected $table            = 'gift_buyer';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['buyer_name', 'discount'];
}

?>