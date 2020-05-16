<?php

namespace App\Helpers;

use CodeIgniter\Controller;
use \PagSeguro\Configuration\Configure;

class PagSeguro extends Controller{

    private $env = "production";
    private $email = "your_pagseguro_email";
    private $token_production = "your_production_token";
    private $token_sandbox = "your_sandbox_token";
    private $app_id_production = "your_production_application_id";
    private $app_id_sandbox = "your_sandbox_application_id";
    private $app_key_production = "your_production_application_key";
    private $app_key_sandbox = "your_sandbox_application_key";
    private $charset = "UTF-8";
    private $log_active = true;
    private $log_location = "../logs/pagseguro";

    /**
     * 
     */
    public function __construct()
    {

        $config = new Configure();

        if($env == 'production'):
            $config->setAccountCredentials($email, $token_production);
            $config->setApplicationCredentials($app_id_production, $app_key_production);
        else:
            $config->setAccountCredentials($email, $token_sandbox);
            $config->setApplicationCredentials($app_id_sandbox, $app_key_sandbox);
        endif;

        $config->setEnvironment($env);

        $config->setCharset($charset);

        $config->setLog($log_active, $log_location);

    }

    /**
     * Iniciar sessão com a pagseguro
     */
    public function openSession(){

    }

}   