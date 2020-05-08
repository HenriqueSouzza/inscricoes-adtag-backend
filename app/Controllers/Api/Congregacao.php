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
        $congregacao = $this->congregacao->findAll();
        
        return $this->respond($congregacao);
    }

    /**
     * 
     */
    public function show($id)
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):

            return $this->failNotFound('Error Not found');

        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

        $congregacao = $this->congregacao->find($id);

        if(!$pessoa):
            return $this->failNotFound('Error Not found');
        endif;

        return $this->respond($congregacao);

    }

    /**
     * 
     */
    public function create()
    {

    }

    /**
     * 
     */
    public function update($id)
    {

    }

    /**
     * 
     */
    public function delete($id)
    {

    }
}