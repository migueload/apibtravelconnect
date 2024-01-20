<?php
class Habitacionfacilidades extends RestApi_Controller {
    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        $this->load->model('habitacionfacilidades_model');
    }

    function getAll(){
        $result = $this->habitacionfacilidades_model->getAll();
        $this->response($result,200);
    }


}