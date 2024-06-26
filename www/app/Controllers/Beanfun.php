<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BeanfunModel;

class Beanfun extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $beanfun = new BeanfunModel;

        $result['success'] = true;
        $result['data'] = $beanfun->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $beanfun = new BeanfunModel;
        $data = [
           'account' => $this->request->getJsonVar('account'),
           'email' => $this->request->getJsonVar('email') . '@gmail.com',
           'phone' => $this->request->getJsonVar('phone'),
           'phone_owner' => $this->request->getJsonVar('phone_owner'),
        ];
        $beanfun->insert($data);
        $insert_id = $beanfun->getInsertID();

        if ($insert_id > 0){
            $result['success'] = true;
            $result['msg'] = 'Data Recorded Successfully!';
            $result['data'] = $beanfun->find($insert_id);

            return $this->respond($result, 200);
        }else{
            $result['success'] = false;
            $result['msg'] = 'Data Recorded Error';

            return $this->fail($result , 409);
        }
    }
}
