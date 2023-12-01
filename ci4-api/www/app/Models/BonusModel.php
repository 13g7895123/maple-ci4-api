<?php

namespace App\Models;
use CodeIgniter\Model;

class BonusModel extends Model
{
    protected $table      = 'bonus_summary';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'cate', 'status', 'amount', 'start_contact_date', 'start_implement_date', 'finish_date', 'last_update_date', 'receive_payment_date', 'tag', 'remark', 'date_time_update', 'date_time_create'];
}

?>