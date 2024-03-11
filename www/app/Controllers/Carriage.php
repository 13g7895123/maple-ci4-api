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

    /* 建立單筆資料(買/賣) 
     * @param int $type     類別(買or賣)
     * @param int $price    價格
     */
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

    /* 待售清單 */
    function for_sell_list(){
        $carriage_data = $this->carriage->findAll();
        $result = array();
        $temp = array();
        // $result_count = 0;
        foreach ($carriage_data as $cd_val){
            $data = $this->carriage
                ->where('serial_number', $cd_val['serial_number'])
                ->where('type', 1)
                ->first();
            if (empty($data)){
                $result_data = [
                    'serial_number' => $cd_val['serial_number'],
                    'price' =>$cd_val['price']
                ];
                $temp['data'][] = $result_data;
                // $result_count ++;
            }
        }
        $result['count'] = count($temp['data']);
        $result['data'] = $temp['data'];
        return $this->respond($result, 200);
    }

    /* 修正商品沒有更新到資料 */
    function fix_data(){
        $carriage_data = $this->carriage->findAll();
        foreach ($carriage_data as $cd_val){
            $update_data = ['product' => '白剪'];
            $this->carriage->update($cd_val['id'], $update_data);
        }
        // $result['type'] = gettype($carriage_data);
        // $result['data'] = $carriage_data;
        $result['success'] = true;
        // echo $carriage_data;
        return $this->respond($result, 200);
    }
}
