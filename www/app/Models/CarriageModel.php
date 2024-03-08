<?php

namespace App\Models;
use CodeIgniter\Model;

class CarriageModel extends Model
{
    protected $table            = 'carriage';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'product',
        'serial_number',
        'type',
        'price',
        'line',
        'surplus',
        'deadline',
        'deadline_time',
        'deadline_remark'
    ];
}

?>