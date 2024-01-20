<?php 
class Usuarios extends RestApi_Controller {
    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        
        $this->load->library('api_auth');
         $this->load->model('usuarios_model');
        if($this->api_auth->isNotAuthenticated()){
            $err = array(
                'status'=>false,
                'message'=>'unauthorized',
                'data'=>[]
            );
            $this->response($err);
        }
    }

    function getAll(){
        $result = $this->usuarios_model->getAll();
        $this->response($result,200);
    }

     function getAllAdmin(){
        $result = $this->usuarios_model->getAllAdmin();
        $this->response($result,200);
    }

    function getById(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->usuarios_model->getById($id);
        $this->response($result,200);
    }

    function getByUsername(){
        $data = json_decode(file_get_contents("php://input"));
        $username=$data->username;
        $result = $this->usuarios_model->getByUsername($username);
        $this->response($result,200);
    }

    function save(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->usuarios_model->save($data);
        $this->response($data,200);
    }

     function edit(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->usuarios_model->edit($data);
        $this->response($data,200);
    }

    function delete(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->usuarios_model->delete($data->id);
        $this->response($data,200);
    }



}
