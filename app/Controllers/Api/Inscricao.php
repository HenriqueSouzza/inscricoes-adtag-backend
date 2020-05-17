<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
// use App\models\Congregacao as CongregacaoModel;
use App\helpers\Authentication;
use App\helpers\PagSeguro;

class Inscricao extends Controller
{

    use ResponseTrait;

    // protected $congregacao;

    protected $authorization;

    protected $pagSeguroConfig;

    public function __construct()
    {
        // $this->congregacao = new CongregacaoModel;
        $this->authorization = new Authentication;

        $this->pagSeguroConfig = new PagSeguro('production');
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
        // $authorization = $this->request->getHeader('Authorization'); 

        // //Verifica se está passando algum token
        // if(!$authorization):

        //     return $this->failNotFound('Error Not found');

        // endif;

        $data = $this->request->getJSON(true); 

        //inicia uma sessão no pagseguro
        $sessionPagSeguro = $this->pagSeguroConfig->openSession();

        //Gerar boleto
        // $generateBoleto = $this->pagSeguroConfig->generateBoleto();
        
        //pagamento via cartão de crédito
        $paymentCreditCard = $this->pagSeguroConfig->paymentCreditCard();
        
        var_dump($paymentCreditCard);die();
        die();
        // var_dump($generateBoleto->getCode(),$generateBoleto->getPaymentLink(), $generateBoleto);die();
        
        // var_dump($response, $generateBoleto->getCode(),$generateBoleto->getPaymentLink(), $generateBoleto);die();
        
        
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