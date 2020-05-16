<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
// use App\models\Congregacao as CongregacaoModel;
use App\helpers\Authentication;
use App\helpers\PagSeguro;
use \PagSeguro\Domains\Requests\DirectPayment\Boleto;

class Inscricao extends Controller
{

    use ResponseTrait;

    // protected $congregacao;

    protected $authorization;

    protected $pagSeguro;

    public function __construct()
    {
        // $this->congregacao = new CongregacaoModel;
        $this->authorization = new Authentication;

        $pagSeguroConfig = new PagSeguro('production');

        $pagSeguroConfig->openSession();

        // $boleto = new Boleto;

        // $boleto->setSender()->setName('João Comprador');
        // $boleto->setSender()->setEmail('email@comprador.com.br');

        // $boleto->setSender()->setPhone()->withParameters(
        //     11,
        //     56273440
        // );

        // $boleto->setSender()->setDocument()->withParameters(
        //     'CPF',
        //     'insira um numero de CPF valido'
        // );

        // $boleto->setSender()->setHash('3dc25e8a7cb3fd3104e77ae5ad0e7df04621caa33e300b27aeeb9ea1adf1a24f');

        // $boleto->setSender()->setIp('127.0.0.0');

        // // Set shipping information for this payment request
        // $boleto->setShipping()->setAddress()->withParameters(
        //     'Av. Brig. Faria Lima',
        //     '1384',
        //     'Jardim Paulistano',
        //     '01452002',
        //     'São Paulo',
        //     'SP',
        //     'BRA',
        //     'apto. 114'
        // );

        // var_dump($configure->getAccountCredentials());die();
    }   

    public function index()
    {
        // $congregacao = $this->congregacao->findAll();
        
        // return $this->respond($congregacao);
    }

    /**
     * 
     */
    public function show($id)
    {
        // $authorization = $this->request->getHeader('Authorization'); 

        // //Verifica se está passando algum token
        // if(!$authorization):

        //     return $this->failNotFound('Error Not found');

        // endif;

        // //valida o token
        // $validateToken = $this->authorization->validateToken($authorization->getValue());

        // //caso o token não for válido, retorna uma erro para o usuário
        // if(!$validateToken):

        //     return $this->failUnauthorized('Error Unauthorized');

        // endif;

        // $congregacao = $this->congregacao->find($id);

        // if(!$congregacao):
        //     return $this->failNotFound('Error Not found');
        // endif;

        // return $this->respond($congregacao);

    }

    /**
     * 
     */
    public function create()
    {
        $data = $this->request->getJSON(true); 

        var_dump($this->pagseguro);die();
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