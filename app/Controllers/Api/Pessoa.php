<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\Pessoa as PessoaModel;
use App\Helpers\Authentication;
use App\Helpers\ManagerPassword;
use \Firebase\JWT\JWT;

class Pessoa extends Controller
{

    use ResponseTrait;

    protected $pessoa;
    protected $authorization;
    protected $senha;
    protected $email;

    public function __construct()
    {
        $this->pessoa = new PessoaModel;
        $this->authorization = new Authentication;
        $this->senha = new ManagerPassword;
        $this->email = \Config\Services::email();
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

        $senhaWithHash = $data['senha'];

        $data['senha'] = $this->senha->encrypter($data['senha']);

        $resultInsert = $this->pessoa->insert($data);

        if($this->pessoa->errors()): 
            return $this->fail($this->pessoa->errors());
        endif;

        if(!$resultInsert):
            return $this->failServerError();
        endif;

        $this->email->setFrom('henriquehps1997@hotmail.com', 'Henrique Souza');
        $this->email->setTo($data['email']);

        $this->email->setSubject('Bem vindo ao nosso portal UNIDOS');
        $this->email->setMessage('Olá ! <br> 
                                    Seja bem ao nosso portal, agora você pode acessá-lo com seu usuário e senha: 
                                    <br> Usuario: <strong> '. $data['cpf'] . '</strong>
                                    <br> Senha: <strong> '. $senhaWithHash . '</strong>
                                ');
        $this->email->setHeader('From', 'henriquetsi10@hotmail.com');

        $this->email->send();

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

        if(isset($data['senha'])):
            $data['senha'] = $this->senha->encrypter($data['senha']);
        endif;

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

    public function resetPassword()
    {
        $data = $this->request->getJSON(true); 

        $pessoa = $this->pessoa->where(['cpf'=> $data['cpf'], 'data_nascimento' => $data['data_nascimento']])->findAll();
        
        if(!$pessoa):

            return $this->failUnauthorized('Error Unauthorized');

        endif;

        $cpf_temp = substr($data['cpf'], -8, 4);
        $date_temp = date('d');
        $password = strrev('!'. $cpf_temp . '@' . $date_temp);

        unset($data['cpf']);

        $this->pessoa->setUpdateRules($data);

        $data['senha'] = $this->senha->encrypter($password);
        
        if($this->pessoa->errors()){
            return $this->fail($this->pessoa->errors());
        }
        
        $updated = $this->pessoa->update($pessoa[0]['pessoa'], $data);

        if($updated === false){
            return $this->failServerError();
        }

        $this->email->setFrom('henriquehps1997@hotmail.com', 'Henrique Souza');
        $this->email->setTo($data['email']);

        $this->email->setSubject('Recuperação de senha portal UNIDOS');
        $this->email->setMessage('Olá ! <br> 
                                    Recebemos sua solicitação agora sua nova senha é: <br> 
                                    <h2>'. $password . '</h2>
                                ');
        $this->email->setHeader('From', 'henriquetsi10@hotmail.com');

        // $header = "From: henriquetsi10@hotmail.com";
        // var_dump(mail('emanoelfalcao62@gmail.com','teste','teste', $header));die();

        if(!$this->email->send()){

            return $this->failServerError();
            
        };
        
        return $this->respond($pessoa);
    }

}