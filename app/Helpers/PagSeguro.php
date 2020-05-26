<?php

namespace App\Helpers;

use CodeIgniter\Controller;
use \PagSeguro\Configuration\Configure;
use \PagSeguro\Services\Session;
use \PagSeguro\Domains\Requests\DirectPayment\Boleto;
use \PagSeguro\Domains\Requests\DirectPayment\CreditCard;
use \PagSeguro\Domains\Requests\DirectPayment\OnlineDebit;

class PagSeguro extends Controller{

    // private $env = "production";
    
    private $email_production = "henriquetsi10@gmail.com"; //email pagseguro
    private $token_production = "0c2adbb5-4c88-4a8f-992b-675f351e7b008d74be174a64821a9fa0aaf9ee128362a6ad-cf6e-406e-8863-65c9c9b33903"; // token ambiente producao 
    private $app_id_production = "your_production_application_id"; // id app producao
    private $app_key_production = "your_production_application_key"; // app key producao
    
    private $email_sandbox = "henriquetsi10@gmail.com"; //email pagseguro
    private $token_sandbox = "PUB0B779955D27A463CA13E6CFFF53E9D1A"; // token ambiente sandbox
    private $app_id_sandbox = "app1442330723"; // id app sandbox
    private $app_key_sandbox = "1EA8A182F3F32E3BB4239F977374329B";// app key sandbox

    private $charset = "UTF-8"; // charset default utf8
    private $log_active = true; //false para não habilitar log e true para habilitar log
    private $log_location = "C:\Apache24\htdocs\unidos-adtag-backend\app\logs\pagseguro\pagseguro.log"; // caminho do log

    private $config;
    private $session;
    private $boleto;
    private $creditCard;
    private $onlineDebit;

    /**
     * 
     */
    public function __construct($env = 'sandbox')
    {

        $this->config = new Configure;

        $this->session = new Session;

        $this->boleto = new Boleto;

        $this->creditCard = new CreditCard;

        $this->onlineDebit = new onlineDebit;

        if($env == 'production'):
            $this->config->setAccountCredentials($this->email_production, $this->token_production);
            $this->config->setApplicationCredentials($this->app_id_production, $this->app_key_production);
        else:
            $this->config->setAccountCredentials($this->email_sandbox, $this->token_sandbox);
            $this->config->setApplicationCredentials($this->app_id_sandbox, $this->app_key_sandbox);
        endif;

        $this->config->setEnvironment($env);

        $this->config->setCharset($this->charset);

        $this->config->setLog($this->log_active, $this->log_location);

        //limite máximos de parcela do cartão de crédito para cada valor
        // $parcela = $this->installmentMax(140.00, 3);
    }

    /**
     * Iniciar sessão com a pagseguro
     */
    public function openSession()
    {
        $result = $this->session->create($this->config->getAccountCredentials());

        if($result):

           return $result->getResult();

        endif;

        return $result;
    }

    /**
     * gerar boleto bancario
     */
    public function generateBoleto($data)
    {
        $this->boleto->setMode('DEFAULT');

        //Seleciona a moeda
        $this->boleto->setCurrency("BRL");

        foreach($data['items'] as $key => $value):
            //Para qual produto que o boleto será emitido
            $this->boleto->addItems()->withParameters($value['id'], $value['description'], $value['quantity'], $value['amount']);
        endforeach;

        //Seleciona o nome do solicitante
        $this->boleto->setSender()->setName($data['sender']['name']);
        
        //Seleciona o email do solicitante
        $this->boleto->setSender()->setEmail($data['sender']['email']);
        
        //defina um código pra esse boleto, pra ser identificado mais rápido futuramente
        $this->boleto->setReference($data['reference']);
        
        //Defina um valor extra para esse boleto
        // $this->boleto->setExtraAmount(11.5);
        
        //Informe o contato do solicitante
        $this->boleto->setSender()->setPhone()->withParameters($data['sender']['phone']['areaCode'], $data['sender']['phone']['number']);
        
        // var_dump($this->boleto);die();

        //Informe o cpf do solicitante, obs: cpf válido
        $this->boleto->setSender()->setDocument()->withParameters($data['sender']['document']['type'], $data['sender']['document']['value']);
        
        //Defina o hash que deve ser solicitado no front, na lib da pagseguro
        $this->boleto->setSender()->setHash($data['sender']['hash']);
        
        //Ip do solicitante da requisição
        // $this->boleto->setSender()->setIp('127.0.0.0');

        //Habilita se tem frete ou não, caso false não tem frete, caso true tem frete
        $this->boleto->setShipping()->setAddressRequired()->withParameters($data['shipping']['addressRequired']);

        // Informações de endereço de entrega caso tenha frete
        $this->boleto->setShipping()->setAddress()->withParameters(
            $data['shipping']['street'],
            $data['shipping']['number'],
            $data['shipping']['district'],
            $data['shipping']['postalCode'],
            $data['shipping']['city'],
            $data['shipping']['state'],
            $data['shipping']['country'],
            $data['shipping']['complement']
        );

        $result = $this->boleto->register($this->config->getAccountCredentials());

        return $result;
    }

    /**
     * Definir o numero máximo de parcela do cartão de crédito
     */
    public function installmentMax($valorTotal, $parcelaMax){

        $options = [
            'amount' => $valorTotal, //Required
            // 'card_brand' => 'visa', //Optional
            'max_installment_no_interest' => $parcelaMax //Optional
        ];

        $result = \PagSeguro\Services\Installment::create($this->config->getAccountCredentials(), $options);
    
        return $result->getInstallments();
    }

    /**
     * Para pagamento via cartão de crédito
     */
    public function paymentCreditCard($data)
    {
        //Defina a forma de pagamento
        $this->creditCard->setMode('DEFAULT');

        //E-mail do remetente 
        $this->creditCard->setReceiverEmail($this->email_production);

        //Defina um código pra essa transacao, pra ser identificado mais rápido futuramente
        // $this->creditCard->setReference("LIBPHP000001");

        // Defina o tipo da moeda
        $this->creditCard->setCurrency("BRL");

        foreach($data['items'] as $key => $value):
            //Para qual produto que o boleto será emitido
            $this->creditCard->addItems()->withParameters($value['id'], $value['description'], $value['quantity'], $value['amount']);
        endforeach;

        //Seleciona o nome do solicitante
        $this->creditCard->setSender()->setName($data['sender']['name']);
    
        //Seleciona o email do solicitante
        $this->creditCard->setSender()->setEmail($data['sender']['email']);

        //Informe o contato do solicitante
        $this->creditCard->setSender()->setPhone()->withParameters($data['sender']['phone']['areaCode'], $data['sender']['phone']['number']);
    
        //Informe o cpf do solicitante, obs: cpf válido
        $this->creditCard->setSender()->setDocument()->withParameters($data['sender']['document']['type'], $data['sender']['document']['value']);
        
        //Defina o hash que deve ser solicitado no front, na lib da pagseguro
        $this->creditCard->setSender()->setHash($data['sender']['hash']);

        //Ip do solicitante da requisição
        // $this->creditCard->setSender()->setIp('127.0.0.0');
        
        //Habilita se tem frete ou não, caso false não tem frete, caso true tem frete
        $this->creditCard->setShipping()->setAddressRequired()->withParameters($data['shipping']['addressRequired']);

        // Informações de endereço de entrega caso tenha frete
        $this->creditCard->setShipping()->setAddress()->withParameters(
                $data['shipping']['street'],
                $data['shipping']['number'],
                $data['shipping']['district'],
                $data['shipping']['postalCode'],
                $data['shipping']['city'],
                $data['shipping']['state'],
                $data['shipping']['country'],
                $data['shipping']['complement'],
        );

        //Informações de cobrança do cartão de crédito
        $this->creditCard->setBilling()->setAddress()->withParameters(
            $data['billing']['street'],
            $data['billing']['number'],
            $data['billing']['district'],
            $data['billing']['postalCode'],
            $data['billing']['city'],
            $data['billing']['state'],
            $data['billing']['country'],
            $data['billing']['complement']
        );

        // Token do cartão de crédito
        $this->creditCard->setToken($data['creditCard']['token']);

        // Defina a quantidade de parcela e o valor (could be obtained using the Installments service, that have an example here in \public\getInstallments.php)
        $this->creditCard->setInstallment()->withParameters($data['creditCard']['installment']['quantity'], $data['creditCard']['installment']['installmentAmount']);

        // Data de nascimento do dono do cartão de crédito
        $this->creditCard->setHolder()->setBirthdate($data['creditCard']['holder']['birthDate']);

        // Nome do dono do cartão de crédito, igual ao que está no cartão de crédito
        $this->creditCard->setHolder()->setName($data['creditCard']['holder']['name']);

        // Telefone do dono do cartão de crédito
        $this->creditCard->setHolder()->setPhone()->withParameters($data['creditCard']['holder']['phone']['areaCode'], $data['creditCard']['holder']['phone']['number']);

        // Informar o cpf do dono do cartão de crédito
        $this->creditCard->setHolder()->setDocument()->withParameters($data['creditCard']['holder']['document']['type'], $data['creditCard']['holder']['document']['value']);

        $result = $this->creditCard->register($this->config->getAccountCredentials());

        return $result;
    }

    public function paymentDebitOnline($data)
    {
        // Set the Payment Mode for this payment request
        $this->onlineDebit->setMode('DEFAULT');

        // Set bank for this payment request
        $this->onlineDebit->setBankName($data['bank']['name']);

        //Defina a forma de pagamento
        $this->onlineDebit->setMode('DEFAULT');

        //E-mail do remetente 
        $this->onlineDebit->setReceiverEmail($this->email_production);

        //Defina um código pra essa transacao, pra ser identificado mais rápido futuramente
        // $this->onlineDebit->setReference("LIBPHP000001");

        // Defina o tipo da moeda
        $this->onlineDebit->setCurrency("BRL");

        foreach($data['items'] as $key => $value):
            //Para qual produto que o boleto será emitido
            $this->onlineDebit->addItems()->withParameters($value['id'], $value['description'], $value['quantity'], $value['amount']);
        endforeach;

        //Seleciona o nome do solicitante
        $this->onlineDebit->setSender()->setName($data['sender']['name']);
        
        //Seleciona o email do solicitante
        $this->onlineDebit->setSender()->setEmail($data['sender']['email']);
        
        //set extra amount
        // $this->onlineDebit->setExtraAmount(11.5);

        //Informe o contato do solicitante
        $this->onlineDebit->setSender()->setPhone()->withParameters($data['sender']['phone']['areaCode'], $data['sender']['phone']['number']);
        
        //Informe o cpf do solicitante, obs: cpf válido
        $this->onlineDebit->setSender()->setDocument()->withParameters($data['sender']['document']['type'], $data['sender']['document']['value']);
        
        //Defina o hash que deve ser solicitado no front, na lib da pagseguro
        $this->onlineDebit->setSender()->setHash($data['sender']['hash']);

        //
        // $this->onlineDebit->setSender()->setIp('127.0.0.0');

        //Habilita se tem frete ou não, caso false não tem frete, caso true tem frete
        $this->onlineDebit->setShipping()->setAddressRequired()->withParameters($data['shipping']['addressRequired']);

        // Informações de endereço de entrega caso tenha frete, caso não tenha o endereço será da igreja 
        $this->onlineDebit->setShipping()->setAddress()->withParameters(
            $data['shipping']['street'],
            $data['shipping']['number'],
            $data['shipping']['district'],
            $data['shipping']['postalCode'],
            $data['shipping']['city'],
            $data['shipping']['state'],
            $data['shipping']['country'],
            $data['shipping']['complement']
        );

        $result = $this->onlineDebit->register($this->config->getAccountCredentials());

        return $result;
    }
}   