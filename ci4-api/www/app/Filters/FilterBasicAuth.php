<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Codeigniter\API\ResponseTrait;
use Config\Services;
use Exception;


class FilterBasicAuth implements FilterInterface
{

    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {          
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            header("HTTP/1.1 200 OK");
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Headers: authorization, content-type, timeout');
            --YOU CAN ADD OR REMOVE HEADERS BASED ON YOUR NEEDS--
            die();
        }    
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}