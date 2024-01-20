<?php
class Tarifas extends RestApi_Controller {
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
         $this->load->model('Tarifas_model');
        if($this->api_auth->isNotAuthenticated()){
            $err = array(
                'status'=>false,
                'message'=>'unauthorized',
                'data'=>[]
            );
            $this->response($err);
        }
    }


     function saveManual(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->Tarifas_model->saveManual($data);
        $this->response($result,200);
    }


     function getAllManual(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->username;
        $result = $this->Tarifas_model->getAllManual($id);
        $this->response($result,200);
    }



    function saveTMPManual(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->Tarifas_model->saveTMPManual($data);
        $this->response($result,200);
    }


     function getAllTMPManual(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->username;
        $result = $this->Tarifas_model->getAllTMPManual($id);
        $this->response($result,200);
    }


    function delTMPManual(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->Tarifas_model->delTMPManual($id);
        $this->response($result,200);
    }

     function delManual(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->Tarifas_model->delManual($id);
        $this->response($result,200);
    }

    function delAllTMPManual(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->username;
        $result = $this->Tarifas_model->delAllTMPManual($id);
        $this->response($result,200);
    }

     function saveDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->Tarifas_model->saveDinamica($data);
        $this->response($result,200);
    }


    function saveTMPDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $result = $this->Tarifas_model->saveTMPDinamica($data);
        $this->response($result,200);
    }

     function getAllTMPDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->username;
        $result = $this->Tarifas_model->getAllTMPDinamica($id);
        $this->response($result,200);
    }

     function delTMPDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->Tarifas_model->delTMPDinamica($id);
        $this->response($result,200);
    }

    function delDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id;
        $result = $this->Tarifas_model->delDinamica($id);
        $this->response($result,200);
    }

    function delAllTMPDinamica(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->username;
        $result = $this->Tarifas_model->delAllTMPDinamica($id);
        $this->response($result,200);
    }


    function getManualByHotel(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id_hotel;
        $result = $this->Tarifas_model->getManualByHotel($id);
        $this->response($result,200);
    }

    function getDinamicaByHotel(){
        $data = json_decode(file_get_contents("php://input"));
        $id=$data->id_hotel;
        $result = $this->Tarifas_model->getDinamicaByHotel($id);
        $this->response($result,200);
    }
}