<?php namespace App\Models;

use CodeIgniter\Model;

class Inscricao extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'inscricao';
    protected $primaryKey = 'inscricao';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'pessoa', 
        'evento', 
        'data_inscricao', 
        'forma_pagamento', 
        'data_pagamento', 
        'link_boleto', 
        'code_transaction', 
        'status', 
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'pessoa'            => 'required|is_natural', 
        'evento'            => 'required|is_natural', 
        'data_inscricao'    => 'required|min_length[2]|valid_date', 
        'forma_pagamento'   => 'required|max_length[15]', 
        // 'data_pagamento'    => 'valid_date', 
        'link_boleto'       => 'max_length[250]', 
        'code_transaction'  => 'max_length[50]', 
        'status'            => 'required|max_length[15]', 
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}