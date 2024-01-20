<?php 

class Pais_model extends CI_Model {
    
    function getAll(){
        $sql ="SELECT * FROM pais ORDER BY nombre ASC";
        return $this->db->query($sql)->result();
    }
}