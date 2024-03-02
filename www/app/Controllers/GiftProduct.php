<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\GiftProductModel;

class GiftProduct extends BaseController
{
    use ResponseTrait;

    private $gift_product;

    public function __construct()
    {
        $this->gift_product = new GiftProductModel;
    }

    public function index()
    {
        $result['success'] = true;
        $result['data'] = $this->gift_product->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $data = [
           'name' => $this->request->getJsonVar('name'),
           'price' => $this->request->getJsonVar('price')
        ];
        $this->gift_product->insert($data);
        $insert_id = $this->gift_product->getInsertID();

        if ($insert_id > 0){
            $result['success'] = true;
            $result['msg'] = 'Data Recorded Successfully!';
            $result['data'] = $this->gift_product->find($insert_id);

            return $this->respond($result, 200);
        }else{
            $result['success'] = false;
            $result['msg'] = 'Data Recorded Error';

            return $this->fail($result , 409);
        }
    }
}
