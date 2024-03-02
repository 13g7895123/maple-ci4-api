<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BeanfunModel;
use App\Models\MapleAccountModel;

class MapleAccount extends BaseController
{
    use ResponseTrait;

    private $maple_account;
    private $beanfun_account;

    public function __construct()
    {
        $this->maple_account = new MapleAccountModel;
        $this->beanfun_account = new BeanfunModel;
    }

    public function index()
    {
        $result['success'] = true;
        $result['data'] = $this->maple_account->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $maple_account = new MapleAccountModel;
        $bf_account =  $this->request->getJsonVar('bf_account');
        $bf_id = $this->beanfun_account
            ->where('account', $bf_account)
            ->find('id');
        return $this->respond($bf_id, 200);
        $data = [
           'beanfun_id' => $bf_id,
           'name' => $this->request->getJsonVar('name'),
           'role' => $this->request->getJsonVar('role')
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
