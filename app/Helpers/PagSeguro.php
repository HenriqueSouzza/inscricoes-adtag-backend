<?php

namespace App\Helpers;

use CodeIgniter\Controller;
use \PagSeguro\Configuration\Configure;
use \PagSeguro\Services\Session;
use \PagSeguro\Domains\Requests\DirectPayment\Boleto;

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

    /**
     * 
     */
    public function __construct($env = 'sandbox')
    {

        $this->config = new Configure;

        $this->session = new Session;

        $this->boleto = new Boleto;

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
    public function generateBoleto()
    {
        $this->boleto->setMode('DEFAULT');

        //Seleciona a moeda
        $this->boleto->setCurrency("BRL");

        //Para qual produto que o boleto será emitido
        $this->boleto->addItems()->withParameters('0001', 'Inscrição Acamp unidos', 1, 140.00);

        //Seleciona o nome do solicitante
        $this->boleto->setSender()->setName('João Comprador');

        //Seleciona o email do solicitante
        $this->boleto->setSender()->setEmail('juniorfransisco1@gmail.com');

        //defina um código pra esse boleto, pra ser identificado mais rápido futuramente
        // $boleto->setReference("LIBPHP000001-boleto");

        //Defina um valor extra para esse boleto
        $this->boleto->setExtraAmount(11.5);
        
        //Informe o contato do solicitante
        $this->boleto->setSender()->setPhone()->withParameters(61, 985308219);
        
        //Informe o cpf do solicitante, obs: cpf válido
        $this->boleto->setSender()->setDocument()->withParameters('CPF', '58885319017');
        
        //
        $this->boleto->setSender()->setHash("60ed3ce797f9681d8d412b49997633015b6231f52093e05cdff06b386df4afbe");
        
        //Ip de onde veio a solicitação
        // $this->boleto->setSender()->setIp('127.0.0.0');

        //Preenche o endereço do do solicitante 
        $this->boleto->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        $result = $this->boleto->register($this->config->getAccountCredentials());

        return $result;
    }

    public function paymentCardCredit()
    {
        
    }
}   