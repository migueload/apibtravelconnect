<?php 

class Auth_model extends CI_Model {
   
    function registerUser($data){
        $this->db->insert('usuario',$data);
    }

    function checkLogin($data){
        $this->db->where($data);
        $query = $this->db->get('usuario');
        if($query->num_rows()==1){
            return $query->row();
        }else {
            return false;
        }
    }

}