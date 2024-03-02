<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BeanfunModel;
use App\Models\MapleAccountModel;

class MapleAccount extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $maple_account = new MapleAccountModel;

        $result['success'] = true;
        $result['data'] = $maple_account->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $maple_account = new MapleAccountModel;
        $data = [
           'name' => $this->request->getJsonVar('account'),
           'email' => $this->request->getJsonVar('email'),
           'phone' => $this->request->getJsonVar('phone'),
           'phone_owner' => $this->request->getJsonVar('phone_owner'),
        ];
        $maple_account->insert($data);
        $insert_id = $maple_account->getInsertID();

        if ($insert_id > 0){
            $result['success'] = true;
            $result['msg'] = 'Data Recorded Successfully!';
            $result['data'] = $maple_account->find($insert_id);

            return $this->respond($result, 200);
        }else{
            $result['success'] = false;
            $result['msg'] = 'Data Recorded Error';

            return $this->fail($result , 409);
        }
    }
}
