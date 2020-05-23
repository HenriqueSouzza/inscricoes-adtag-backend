<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Header;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{

    public function before(RequestInterface $request)
    {
        $request->setHeader('Access-Control-Allow-Origin', '*');
        $request->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $request->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization, Origin');
        // var_dump($request->getMethod());
        // var_dump($request->getHeaders());
        // die();
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        
    }

}