<?php namespace App\Models;

use CodeIgniter\Model;

class Congregacao extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'inscricao';
    protected $primaryKey = 'inscricao';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'inscricao', 
        'pessoa', 
        'evento', 
        'data_inscricao', 
        'forma_pagamento', 
        'data_pagamento', 
        'status', 
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'inscricao'         => 'required|is_natural', 
        'pessoa'            => 'required|is_natural', 
        'evento'            => 'required|is_natural', 
        'data_inscricao'    => 'required|min_length[2]', 
        'forma_pagamento'   => 'required|max_length[15]', 
        'data_pagamento'    => 'required', 
        'status'            => 'required|max_length[15]', 
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}