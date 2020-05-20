<?php

namespace App\Helpers;

use CodeIgniter\Controller;
use \Firebase\JWT\JWT;
use App\models\Pessoa as PessoaModel;

class Authentication extends Controller
{

    Protected $key;
    Protected $algoritmo;
    protected $pessoa;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->key = 'JWT_SECRET';
        $this->algoritmo = 'HS256';
        $this->pessoa = new PessoaModel;
    }

    /**
     * 
     */
    public function generateToken($pessoa, $email)
    {

        //Header Token
        $header = [
            'typ' => 'JWT',
            'alg' => $this->algoritmo
        ];

        //Payload - Content
        $payload = [
            'iat'  => time(),
            // 'exp' => time() + 3600,
            'uid' => 1,
            'data' => [ 
                'pessoa' => $pessoa, 
                'cpf' => $email
            ],
        ];

        $jwt = JWT::encode($payload, $this->key);

        return $jwt;
    }

    /**
     * 
     */
    public function validateToken($jwt)
    {

        if(count(explode('.', $jwt)) != 3):

            return false;

        endif;
        
        JWT::$leeway = 60; // $leeway in seconds

        $decoded = JWT::decode($jwt, $this->key, array($this->algoritmo));

        if(!$this->pessoa->where('cpf', $decoded->data->cpf)->findAll()):
            
            return false;

        endif;

        return $decoded;

    }
}