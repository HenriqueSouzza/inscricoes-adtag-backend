<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Pessoa as PessoaModel;

class Pessoa extends Controller
{

    use ResponseTrait;

    protected $pessoa;

    public function __construct()
    {
        $this->pessoa = new PessoaModel;
    }

    public function index()
    {
        $pessoa = $this->pessoa->paginate();

        return $this->respond($pessoa);
    }

    /**
     * Método para apresentar uma pessoa específica
     */
    public function show($id)
    {
        $pessoa = $this->pessoa->find($id);

        if(!$pessoa):
            return $this->failNotFound('Error Not found');
        endif;

        return $this->respond($pessoa);
    }
    
    /**
     * Método para criar uma pessoa
     */
    public function create()
    {
        $data = $this->request->getPost(); 

        $id = $this->pessoa->insert($data);

        if($this->pessoa->errors()): 
            return $this->fail($this->pessoa->errors());
        endif;

        if($id === false):
            return $this->failServerError();
        endif;

        $pessoa = $this->pessoa->find($id);

        return $this->respondCreated($pessoa);
    }

    /**
     * 
     */
    public function update($id)
    {
        $data = $this->request->getRawInput();

        $this->pessoa->setUpdateRules($data);

        $updated = $this->pessoa->update($id, $data);

        if($this->pessoa->errors()){
            return $this->fail($this->pessoa->errors());
        }

        if($updated === false){
            return $this->failServerError();
        }

        $pessoa = $this->pessoa->find($id);

        return $this->respond($pessoa);
    }

    /**
     * 
     */
    public function delete($id)
    {
        $pessoa = $this->pessoa->select('pessoa')->find($id);

        if(!$pessoa):
            return $this->failNotFound('Error Not found');
        endif;

        if($this->pessoa->delete($id)):
            return $this->respondDeleted('deleted success');
        else:
            return $this->failServerError();
        endif;
        
    }
}