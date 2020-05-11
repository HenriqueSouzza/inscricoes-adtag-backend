<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Evento as EventoModel;
use App\helpers\Authentication;

class Evento extends Controller
{
    use ResponseTrait;

    protected $evento;
    protected $authorization;

    public function __construct()
    {
        $this->evento = new EventoModel;
        $this->authorization = new Authentication;
    }

    public function index()
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

        $evento = $this->evento->findAll();
        
        return $this->respond($evento);
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

        $evento = $this->evento->find($id);

        if(!$evento):
            return $this->failNotFound('Error Not found');
        endif;

        return $this->respond($evento);
    }

}