<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\GiftBuyerModel;

class GiftBuyer extends BaseController
{
    use ResponseTrait;

    private $gift_buyer;

    public function __construct()
    {
        $this->gift_buyer = new GiftBuyerModel;
    }

    public function index()
    {
        $result['success'] = true;
        $result['data'] = $this->gift_buyer->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $data = [
           'buyer_name' => $this->request->getJsonVar('name'),
           'discount' => $this->request->getJsonVar('discount')
        ];
        $this->gift_buyer->insert($data);
        $insert_id = $this->gift_buyer->getInsertID();

        if ($insert_id > 0){
            $result['success'] = true;
            $result['msg'] = 'Data Recorded Successfully!';
            $result['data'] = $this->gift_buyer->find($insert_id);

            return $this->respond($result, 200);
        }else{
            $result['success'] = false;
            $result['msg'] = 'Data Recorded Error';

            return $this->fail($result , 409);
        }
    }
}
