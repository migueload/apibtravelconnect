<?php
class Facilidades extends RestApi_Controller {
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
        $this->load->model('facilidades_model');
        $this->load->model('hotelfacilidades_model');
        $this->load->model('habitacionfacilidades_model');

        if($this->api_auth->isNotAuthenticated()){
            $err = array(
                'status'=>false,
                'message'=>'unauthorized',
                'data'=>[]
            );
            $this->response($err);
        }
    }

    function getHabitacion(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id_hotel;
        $result = $this->facilidades_model->getHabitacion($id);
        $this->response($result,200);
    }

    function getHotel(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id_hotel;
        $result = $this->facilidades_model->getHotel($id);
        $this->response($result,200);
    }

     function hotelGetAll(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->facilidades_model->hotelGetAll();
        $this->response($result,200);
    }

     function habitacionesGetAll(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->facilidades_model->habitacionesGetAll();
        $this->response($result,200);
    }

     function saveOneFacilidadHotel(){
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $this->hotelfacilidades_model->saveOne($data);
        $this->response($result,200);
    }

     function saveOneFacilidadHabitacion(){
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $this->habitacionfacilidades_model->saveOne($data);
        $this->response($result,200);
    }

 
}