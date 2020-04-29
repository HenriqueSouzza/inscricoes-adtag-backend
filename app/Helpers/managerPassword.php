<?php

namespace App\Helpers;

use CodeIgniter\Controller;

class ManagerPassword extends Controller
{
    /**
     * Método para criptografar uma senha
     */
    public function encrypter($senha)
    {
        /**
         * Nesse caso, queremos aumentar o custo padrão do BCRYPT para 12.
         * Observe que também mudamos para BCRYPT, que sempre terá 60 caracteres.
         */
        $options = [
            'cost' => 12,
        ];

        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        return $senhaHash;
    }

    /**
     * 
     */
    public function verify($senha, $senhaDigitada)
    {
        $options = [
            'cost' => 12,
        ];

        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        
        if(password_verify($senhaDigitada, $senha)){
            return true;
        }else{
            return false;
        }

    }
}