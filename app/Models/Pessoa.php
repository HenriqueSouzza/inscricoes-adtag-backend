<?php namespace App\Models;

use CodeIgniter\Model;

class Pessoa extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'pessoa';
    protected $primaryKey = 'pessoa';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nome_compl', 
        'cpf', 
        'email', 
        'telefone', 
        'data_nascimento', 
        'sexo', 
        'congregacao',
        'senha'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'nome_compl'        => 'required|min_length[5]', 
        'cpf'               => 'required|is_natural|is_unique[pessoa.cpf]', 
        'email'             => 'required|valid_email|is_unique[pessoa.email]', 
        'telefone'          => 'required|is_natural', 
        'data_nascimento'   => 'required|valid_date', 
        'sexo'              => 'required|max_length[1]|alpha', 
        'congregacao'       => 'required|is_natural',
        'senha'             => 'required|min_length[3]'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Set validation Rules
     */
    public function setUpdateRules($data)
    {
        $rules = [];

        if(isset($data['nome_compl'])):
            $rules['nome_compl'] = 'required|min_length[5]';
        endif;
        
        if(isset($data['cpf'])):
            $rules['cpf'] = 'required|is_natural|is_unique[pessoa.cpf]';
        endif;

        if(isset($data['email'])):
            $rules['email'] = 'required|valid_email';
        endif;

        if(isset($data['telefone'])):
            $rules['telefone'] = 'required|is_natural';
        endif;

        if(isset($data['data_nascimento'])):
            $rules['data_nascimento'] = 'required|valid_date';
        endif;

        if(isset($data['sexo'])):
            $rules['sexo'] = 'required|max_length[1]|alpha';
        endif;

        if(isset($data['congregacao'])):
            $rules['congregacao'] = 'required|is_natural';
        endif;

        if(isset($data['senha'])):
            $rules['senha'] = 'required|min_length[3]';
        endif;

        $this->validationRules = $rules;

    }

}