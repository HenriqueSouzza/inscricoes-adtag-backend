<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\models\Pessoa as PessoaModel;
use App\helpers\Authentication;
use App\helpers\ManagerPassword;
use \Firebase\JWT\JWT;

class Pessoa extends Controller
{

    use ResponseTrait;

    protected $pessoa;
    protected $authorization;
    protected $senha;

    public function __construct()
    {
        $this->pessoa = new PessoaModel;
        $this->authorization = new Authentication;
        $this->senha = new ManagerPassword;
    }

    public function index()
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):

            return $this->failNotFound('Error Not found');

        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

        $pessoa = $this->pessoa->paginate();
        
        return $this->respond($pessoa);

    }

    /**
     * Método para apresentar uma pessoa específica
     */
    public function show($id)
    {

        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):

            return $this->failNotFound('Error Not found');

        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

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
        $data = $this->request->getJSON(true); 

        $data['senha'] = $this->senha->encrypt($data['senha']);

        $resultInsert = $this->pessoa->insert($data);

        if($this->pessoa->errors()): 
            return $this->fail($this->pessoa->errors());
        endif;

        if($resultInsert === false):
            return $this->failServerError();
        endif;

        $pessoa = $this->pessoa->find($resultInsert);

        return $this->respondCreated($pessoa);
    }

    /**
     * 
     */
    public function update($id)
    {
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):

            return $this->failNotFound('Error Not found');

        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

        $data = $this->request->getJSON(true);

        $this->pessoa->setUpdateRules($data);

        $data['senha'] = $this->senha->encrypt($data['senha']);

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
        $authorization = $this->request->getHeader('Authorization'); 

        //Verifica se está passando algum token
        if(!$authorization):

            return $this->failNotFound('Error Not found');

        endif;

        //valida o token
        $validateToken = $this->authorization->validateToken($authorization->getValue());

        //caso o token não for válido, retorna uma erro para o usuário
        if(!$validateToken):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

        $pessoa = $this->pessoa->select('pessoa')->find($id);

        if(!$pessoa):

            return $this->failNotFound('Error Not found');

        endif;

        if(!$this->pessoa->delete($id)):
            
            return $this->failServerError();

        endif;
        
        return $this->respondDeleted('deleted success');
        
    }
}