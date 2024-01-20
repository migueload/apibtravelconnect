<?php 

class Facilidades_model extends CI_Model {
    
    function getHabitacion($id_hotel){       
        $sql ="SELECT (SELECT hab.id FROM habitacion_facilidades hab WHERE f.id_facilidad=hab.id) as id, (SELECT hab.descripcion FROM habitacion_facilidades hab WHERE f.id_facilidad=hab.id) as descripcion FROM facilidades_hab f WHERE f.id_hotel='$id_hotel'";
        return $this->db->query($sql)->result();
    }

    function getHotel($id_hotel){       
        $sql ="SELECT (SELECT hot.id FROM hotel_facilidades hot WHERE f.id_facilidad=hot.id) as id, (SELECT hot.descripcion FROM hotel_facilidades hot WHERE f.id_facilidad=hot.id) as descripcion FROM facilidades_hot f WHERE f.id_hotel='$id_hotel'";
        return $this->db->query($sql)->result();
    }

     function hotelGetAll(){       
        $sql ="SELECT * FROM hotel_facilidades ORDER BY id ASC";
        return $this->db->query($sql)->result();
    }

    function habitacionesGetAll(){       
        $sql ="SELECT * FROM habitacion_facilidades ORDER BY id ASC";
        return $this->db->query($sql)->result();
    }
}