<?php 

class Hotel extends RestApi_Controller {
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
         $this->load->model('hotel_model');
        if($this->api_auth->isNotAuthenticated()){
            $err = array(
                'status'=>false,
                'message'=>'unauthorized',
                'data'=>[]
            );
            $this->response($err);
        }
    }

    function getAllAdmin(){
        $result = $this->hotel_model->getAllAdmin();
        $this->response($result,200);
    }

    function getAll(){
        $result = $this->hotel_model->getAll();
        $this->response($result,200);
    }

    function getById(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->hotel_model->getById($id);
        $this->response($result,200);
    }

    function saveOne(){
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $this->hotel_model->saveOne($data);
        $this->response($result,200);
    }

    function save(){
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $this->hotel_model->save($data);
        $this->response($result,200);
    }


     function edit(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->hotel_model->edit($data);
        $this->response($data,200);
    }

    function delete(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->hotel_model->delete($data->id);
        $this->response($data,200);
    }

    //*** Consultas Api REST de App ***

    function getHotelApp(){
        /**
         * Parametros de Busqueda Pais, Ciudad, Adultos, desde , hasta, edades de niños 
         */
      $data = json_decode(file_get_contents("php://input"));  
      $result = $this->hotel_model->getHotelApp($data);
      $this->response($result,200);
    }

     function getHotelAppById(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->hotel_model->getHotelAppById($id);
        $this->response($result,200);
    }

   

}
