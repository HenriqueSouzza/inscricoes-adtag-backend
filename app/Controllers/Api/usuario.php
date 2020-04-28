<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Pessoa as PessoaModel;
use App\helpers\Authentication;
use \Firebase\JWT\JWT;

class Usuario extends Controller
{

    use ResponseTrait;

    protected $pessoa;
    protected $authorization;

    public function __construct()
    {
        $this->pessoa = new PessoaModel;
        $this->authorization = new Authentication;
    }

    public function authenticate()
    {

        $data = $this->request->getJSON(true);

        if(!$data['cpf'] || !$data['senha']):

            return $this->failNotFound('Error Not found');

        endif;

        if(!$this->pessoa->where('cpf', $data['cpf'])->findAll()):

            return $this->failNotFound('Error Not found');

        endif;

        $pessoa = $this->pessoa->where('cpf', $data['cpf'])->findAll();

        if(($pessoa[0]['cpf'] == $data['cpf']) && ($pessoa[0]['senha'] == $data['senha'])):

            $Token = $this->authorization->generateToken($pessoa[0]['pessoa'], $pessoa[0]['cpf']);

            return $this->respond(['token' => $Token]);

        else:

            return $this->failUnauthorized('Error Unauthorized');

        endif;

    }

}