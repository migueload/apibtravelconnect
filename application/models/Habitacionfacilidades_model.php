<?php 

class Habitacionfacilidades_model extends CI_Model {
    
    function getAll(){       
        $sql ="SELECT * FROM habitacion_facilidades ORDER BY descripcion DESC";
        return $this->db->query($sql)->result();
    }

    function saveOne($data){
        $this->db->insert('facilidades_hab',$data);
    }
}