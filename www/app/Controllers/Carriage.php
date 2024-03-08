<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CarriageModel;

class Carriage extends BaseController
{
    use ResponseTrait;

    private $carriage;

    public function __construct()
    {
        $this->carriage = new CarriageModel;
    }

    public function index()
    {
        $result['success'] = true;
        $result['data'] = $this->carriage->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        /* 資料處理 */
        $serial_number_str = $this->request->getJsonVar('serialNumber');

        if (strpos($serial_number_str, "\n") !== false) {   /* 判斷是否多筆資料 */
            $serial_number_data = explode("\n", $serial_number_str);
            $is_insert_success = true;
            foreach ($serial_number_data as $key => $serial_number){
                $insert_resulst = $this->single_data($serial_number);
                if ($insert_resulst == false){
                    $is_insert_success = false;
                }
            }
            if ($is_insert_success){
                $result['success'] = true;
                $result['type'] = 'muilty insert';
                $result['msg'] = 'Data Recorded Successfully!';
    
                return $this->respond($result, 200);
            }else{
                $result['success'] = false;
                $result['type'] = 'muilty insert';
                $result['msg'] = 'Data Recorded Error';

                return $this->fail($result , 409);
            }
        }else{              /* 單筆資料 */
            $insert_resulst = $this->single_data($serial_number_str);

            if ($insert_resulst){
                $result['success'] = true;
                $result['type'] = 'single insert';
                $result['msg'] = 'Data Recorded Successfully!';
    
                return $this->respond($result, 200);
            }else{
                $result['success'] = false;
                $result['type'] = 'single insert';
                $result['msg'] = 'Data Recorded Error';

                return $this->fail($result , 409);
            }            
        }
    }

    function single_data($serial_number){
        $type = $this->request->getJsonVar('type');
        $price = $this->request->getJsonVar('price');

        /* 計算盈餘 */
        if ($type == 0){
            $surplus = '';
        }else{
            $carriage_data = $this->carriage
            ->where('serial_number', $serial_number)
            ->where('type', 0)
            ->first();
            
            if (!empty($carriage_data)){
                $buying_price = $carriage_data['price'];
                $surplus = $price - $buying_price;
            }
        }

        $data = [
            'product'       => $this->request->getJsonVar('product'),
            'serial_number' => $serial_number,
            'type'          => $type,
            'price'         => $this->request->getJsonVar('price'),
            'line'          => $this->request->getJsonVar('line'),
            'surplus'       => $surplus,
            'deadline'      => empty($this->request->getJsonVar('deadline')) ? '' : $this->request->getJsonVar('deadline'),
            'deadline_time' => empty($this->request->getJsonVar('deadline_time')) ? '' : $this->request->getJsonVar('deadline_time'),
            'remark'        => $this->request->getJsonVar('remark')
        ];
        $this->carriage->insert($data);
        $insert_id = $this->carriage->getInsertID();

        if ($insert_id > 0){
            return True;
        }else{
            return false;
        }
    }
}