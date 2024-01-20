<?php 

class Imagen extends RestApi_Controller {
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
         $this->load->model('Imagen_model');
        if($this->api_auth->isNotAuthenticated()){
            $err = array(
                'status'=>false,
                'message'=>'unauthorized',
                'data'=>[]
            );
            $this->response($err);
        }
    }

    function getById(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id_hotel;
        $result = $this->Imagen_model->getById($id);
        $this->response($result,200);
    }

     function delete(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->Imagen_model->delete($id);
        $this->response($result,200);
    }

     function save(){
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $this->Imagen_model->save($data);
        $this->response($result,200);
    }

}
