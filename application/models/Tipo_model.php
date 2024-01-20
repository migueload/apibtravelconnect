<?php 

class Tipo_model extends CI_Model {
    
    function getAll(){
        $sql ="SELECT * FROM tipo WHERE status=1 ORDER BY id ASC";
        return $this->db->query($sql)->result();
    }
}