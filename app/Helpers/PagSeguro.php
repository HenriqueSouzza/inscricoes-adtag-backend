<?php

namespace App\Helpers;

use CodeIgniter\Controller;
use \PagSeguro\Configuration\Configure;
use \PagSeguro\Services\Session;

class PagSeguro extends Controller{

    // private $env = "production";
    private $email = "your_pagseguro_email"; //email pagseguro
    private $token_production = "your_production_token"; // token ambiente producao 
    private $token_sandbox = "your_sandbox_token"; // token ambiente sandbox
    private $app_id_production = "your_production_application_id"; // id app producao
    private $app_id_sandbox = "your_sandbox_application_id"; // id app sandbox
    private $app_key_production = "your_production_application_key"; // app key producao
    private $app_key_sandbox = "your_sandbox_application_key";// app key sandbox
    private $charset = "UTF-8"; // charset default utf8
    private $log_active = true; //false para não habilitar log e true para habilitar log
    private $log_location = "C:\Apache24\htdocs\unidos-adtag-backend\app\logs\pagseguro\pagseguro.log"; // caminho do log

    private $config;
    private $session;

    /**
     * 
     */
    public function __construct($env = 'sandbox')
    {

        $this->config = new Configure;
        $this->session = new Session;

        if($env == 'production'):
            $this->config->setAccountCredentials($this->email, $this->token_production);
            $this->config->setApplicationCredentials($this->app_id_production, $this->app_key_production);
        else:
            $this->config->setAccountCredentials($this->email, $this->token_sandbox);
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

        return $result;
    }

}   