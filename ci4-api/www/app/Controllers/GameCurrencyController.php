<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\GameCurrencyModel;

class GameCurrency extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $game_currency = new GameCurrencyModel;

        $result['success'] = true;
        $result['data'] = $game_currency->findAll();

        return $this->respond($result, 200);
    }

    public function create()
    {
        $game_currency = new GameCurrencyModel;
        $data = [
           'name' => $this->request->getVar('name'),
           'cate' => $this->request->getVar('cate'),
           'amount' => $this->request->getVar('amount'),
           'status' => $this->request->getVar('status'),
           'start_contact_date' => $this->request->getVar('start_contact_date'),
        ];
        $game_currency->insert($data);
        $game_currency_id = $game_currency->getInsertID();

        if ($game_currency_id > 0){
            $result['success'] = true;
            $result['msg'] = 'game_currency Recorded Successfully!';
            $result['data'] = $game_currency->find($game_currency_id);

            return $this->respond($result, 200);
        }else{
            $result['success'] = false;
            $result['msg'] = 'Insert data error';

            return $this->fail($result , 409);
        }
    }
}
