<?php

namespace App\Models;
use CodeIgniter\Model;

class BonusModel extends Model
{
    protected $table      = 'game_currency';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type',
        'amount_maple',
        'amount_ntd',
        'convert_to_ntd',
        'paytype'
    ];
}

?>