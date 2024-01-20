<?php 
class Auth extends RestApi_Controller {
    function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }

        $this->load->library('Api_auth');
        $this->load->model('auth_model');

    }

    
    function register(){
        $data = json_decode(file_get_contents("php://input"));
        $username= $data->username;
        $password=$data->password;
        $nivel=$data->nivel;

        if( ($username=='') || ($password=='') ){ 
             $responseData = array(
                'status'=>false,
                'message' => 'Todos los campos son requeridos',
                'data'=> []
             );
             return $this->response($responseData,200);
        }else{
             $data  = array(
                'username'=>$username,
                'password'=>sha1($password),
                'nivel'=>$nivel
             );
             $this->auth_model->registerUser($data);
             $responseData = array(
                'status'=>true,
                'message' => 'Registro exitoso!',
                'data'=> []
             );
             return $this->response($responseData,200);
        }
    }

    function login() {
        
        $data = json_decode(file_get_contents("php://input"));
        $username= $data->username;
        $password=$data->password;

        if( ($username=='') || ($password=='') ){ 
             $responseData = array(
                'status'=>false,
                'message' => 'Usuario y password son requiridos',
                'data'=> []
             );
            return $this->response($responseData);
        }else{

             $data = array('username'=>$username,'password'=>sha1($password));
             $loginStatus = $this->auth_model->checkLogin($data);
             if($loginStatus != false) {
                  $userId = $loginStatus->id;
                  $nivel = $loginStatus->nivel;
                  $id_hotel = $loginStatus->id_hotel;
                  $bearerToken = $this->api_auth->generateToken($userId);
                  $responseData = array(
                    'status'=> true,
                    'id'=>$userId,
                    'username'=>$username,
                    'nivel'=>$nivel,
                    'id_hotel'=>$id_hotel,
                    'message' => 'Login Satisfactorio',
                    'token'=> $bearerToken,
                 );
                 return $this->response($responseData,200);
             }else {
                $responseData = array(
                    'status'=>false,
                    'message' => 'Credenciales Invalidas',
                    'data'=> []
                 );
                 return $this->response($responseData);
             }
           
        }
    }


}
