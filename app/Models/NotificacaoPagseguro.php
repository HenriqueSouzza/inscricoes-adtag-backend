<?php namespace App\Models;

use CodeIgniter\Model;

class NotificacaoPagseguro extends Model
{
    protected $DBGroup = "default"; 

    protected $table      = 'notificacao_pagseguro';
    protected $primaryKey = 'notificacao';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'notificationCode', 
        'notificationType', 
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
        'notificationCode'  => 'required|max_length[50]', 
        'notificationType'  => 'required|max_length[50]', 
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}