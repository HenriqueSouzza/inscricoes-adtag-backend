<?php namespace App\Models;

use CodeIgniter\Model;

class Evento extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'evento';
    protected $primaryKey = 'evento';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nome_evento', 
        'data', 
        'vagas', 
        'hora', 
        'valor', 
        'status', 
        'cep',
        'estado',
        'cidade',
        'endereco',
        'numero',
        'complemento',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'nome_evento'       => 'required|min_length[5]', 
        'data'              => 'required|valid_date', 
        'hora'              => '',//'required|is_natural', 
        'vagas'             => 'required|is_natural', 
        'valor'             => 'decimal',//'required|is_natural', 
        'status'            => 'required|max_length[1]|is_natural', 
        'cep'               => '',//'required|is_natural', 
        'endereco'          => '',//'required|min_length[5]', 
        'estado'            => '',//'required|min_length[5]', 
        'cidade'            => '',//'required|min_length[5]', 
        'numero'            => '',//'required|is_natural|min_length[5]', 
        'complemento'       => '',//'required|is_natural|min_length[5]', 
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}