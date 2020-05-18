<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\NotificacaoPagseguro as notificacao;
use App\helpers\Authentication;
use App\helpers\PagSeguro;

class NotificacaoPagseguro extends Controller
{

    use ResponseTrait;

    protected $notificacaoPagseguro;

    public function __construct()
    {
        $this->notificacaoPagseguro = new notificacao;
    }

    /**
     * 
     */
    public function index()
    {
        return $this->failForbidden('Método indisponível');
    }

    /**
     * 
     */
    public function show($id)
    {
        return $this->failForbidden('Método indisponível');
    }

    public function create()
    {
        $email = $this->request->getServer('PHP_AUTH_USER');
        $senha = $this->request->getServer('PHP_AUTH_PW');

        $emailPermitido = "notificacao-pagseguro@gmail.com";
        $senhaPermitida = "pagseguro@2020!";

        if($email != $emailPermitido || $senha != $senhaPermitida):

            return $this->failUnauthorized('Dados incorretos');

        endif;

        $data = $this->request->getPost();

        $resultInsert = $this->notificacaoPagseguro->insert($data);

        if($this->notificacaoPagseguro->errors()): 
            return $this->fail($this->notificacaoPagseguro->errors());
        endif;

        if(!$resultInsert):
            return $this->failServerError();
        endif;

        $notificao = $this->notificacaoPagseguro->find($resultInsert);

        return $this->respondCreated("created success");

    }

    /**
     * 
     */
    public function update($id)
    {
        return $this->failForbidden('Método indisponível');
    }

    public function delete($id)
    {
        return $this->failForbidden('Método indisponível');
    }

}