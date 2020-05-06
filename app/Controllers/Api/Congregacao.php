<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Congregacao as PessoaModel;
use App\helpers\Authentication;
use \Firebase\JWT\JWT;

class Congregacao extends Controller
{

    use ResponseTrait;

    protected $congregacao;
    protected $authorization;

    public function __construct()
    {
        $this->congregacao = new PessoaModel;
        $this->authorization = new Authentication;
    }

}