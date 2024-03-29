<?php namespace App\Models;

use CodeIgniter\Model;

class Congregacao extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'congregacao';
    protected $primaryKey = 'congregacao';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'regiao', 
        'nome_congregacao', 
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'regiao'            => 'required|is_natural', 
        'nome_congregacao'  => 'required|min_length[2]', 
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}