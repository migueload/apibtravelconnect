<?php 

class Ciudad_model extends CI_Model {
    
    function getByCountry($id_pais){
        $sql ="SELECT * FROM ciudad WHERE id_pais='$id_pais' ORDER BY nombre ASC";
        return $this->db->query($sql)->result();
    }
}