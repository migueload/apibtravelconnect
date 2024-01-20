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
        $this->load->model('hotel_model');
        
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

}
