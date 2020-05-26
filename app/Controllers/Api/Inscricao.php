<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Inscricao as InscricaoModel;
use App\models\Evento as EventoModel;
use App\models\Pessoa as PessoaModel;
use App\helpers\Authentication;
use App\helpers\PagSeguro;

class Inscricao extends Controller
{

    use ResponseTrait;

    protected $inscricao;
    
    protected $evento;

    protected $pessoa;

    protected $authorization;

    protected $pagSeguroConfig;

    public function __construct()
    {
        $this->inscricao = new InscricaoModel;
        $this->evento = new EventoModel;
        $this->pessoa = new PessoaModel;
        
        $this->authorization = new Authentication;
        $this->pagSeguroConfig = new PagSeguro('production');
    }   

    public function index()
    {

        var_dump($this->pagSeguroConfig->notificationTransaction('4FD773BC-E5D7-4541-951E-29111EA9039A'));
        die();

        // $authorization = $this->request->getHeader('Authorization'); 

        // //Verifica se está passando algum token
        // if(!$authorization):

        //     return $this->failUnauthorized('Acesso não permitido para o seu usuário');

        // endif;

        // $inscricao = $this->inscricao->findAll();
        
        // return $this->respond($inscricao);
    }

    /**
     * 
     */
    public function show($id)
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):
            return $this->failNotFound('Erro na autenticação');
        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):
            return $this->failUnauthorized('Acesso não permitido para o seu usuário');
        endif;

        $inscricao = $this->inscricao->find($id);

        if(!$inscricao):
            return $this->failNotFound('Nenhum registro encontrado');
        endif;

        return $this->respond($inscricao);
    }

    /**
     * 
     */
    public function create()
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):
            return $this->failUnauthorized('Erro na autenticação');
        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):
            return $this->failUnauthorized('Acesso não permitido para o seu usuário');
        endif;

        $data = $this->request->getJSON(true); 

        if(!$data):
            return $this->failNotFound('Dados enviados incorretos');
        endif;

        if($data['method'] == 'BOLETO'):
            // Gerar boleto
            $transacao = $this->pagSeguroConfig->generateBoleto($data);
        endif;

        if($data['method'] == 'ONLINE_DEBIT'):
            // Pagamento no cartao débito
            $transacao = $this->pagSeguroConfig->paymentDebitOnline($data);
        endif;

        if($data['method'] == 'CREDIT_CARD'):
            // Pagamento no cartao de crédito
            $transacao = $this->pagSeguroConfig->paymentCreditCard($data);
        endif;

        $pessoa = $this->pessoa->where('cpf', $data['sender']['document']['value'])->findAll();
        
        $dadosInscricao = [
            'pessoa'            => $pessoa[0]['pessoa'],
            'evento'            => $data['items'][0]['id'],
            'data_inscricao'    => date('Y-m-d'),
            'forma_pagamento'   => $data['method'],
            'code_transaction'  => $transacao->getCode(),
            'link_boleto'       => ($data['method'] == 'CREDIT_CARD' ? null : $transacao->getPaymentLink()),
            'status'            => 'PI'
        ];

        $inscricao = $this->inscricao->insert($dadosInscricao);

        if($this->inscricao->errors()): 
            return $this->fail($this->inscricao->errors('Erro ao tentar salvar os dados'));
        endif;

        if(!$inscricao):
            return $this->failServerError('Erro ao tentar salvar os dados');
        endif;

        return $this->respondCreated(['message' =>'Inscrição realizada']);
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

    /**
     * Método para iniciar retorna um id sessao do pagseguro para o cliente  
     */
    public function dadosInscricao()
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):
            return $this->failUnauthorized('Erro na autenticação');
        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):
            return $this->failUnauthorized('Acesso não permitido para o seu usuário');
        endif;

        $data = $this->request->getJSON(true); 

        $dataPermited = ['env', 'idPessoa', 'idEvento'];

        if(count(array_diff($dataPermited, array_keys($data))) > 0):

            return $this->failNotFound('Dados enviados incorretos');

        endif;

        //verifica se o usuario está cadastrado no evento
        $inscricao = $this->inscricao->where('pessoa', $data['idPessoa'])->where('evento', $data['idEvento'])->findAll();

        //gera uma sessao para ele preencher os dados de pagamento
        $sessionPagSeguro = $this->pagSeguroConfig->openSession($data['env']);

        //busca os dados da pessoa
        $pessoa = $this->pessoa->find($data['idPessoa']);

        unset($pessoa['senha']);

        //buscar os dados do evento
        $evento = $this->evento->find($data['idEvento']);

        $result = [
            'sessionId' => $sessionPagSeguro,
            'pessoa'    => $pessoa,
            'evento'    => $evento,
            'inscricao' => $inscricao
        ];

        return $this->respond($result);
    }
}