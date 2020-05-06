<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Congregacao as CongregacaoModel;
use App\helpers\Authentication;
use \Firebase\JWT\JWT;

class Congregacao extends Controller
{

    use ResponseTrait;

    protected $congregacao;
    protected $authorization;

    public function __construct()
    {
        $this->congregacao = new CongregacaoModel;
        $this->authorization = new Authentication;
    }

    public function index()
    {

    }

    public function show($id)
    {

    }

    public function create()
    {

    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}