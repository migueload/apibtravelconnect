<?php 

class Imagen_model extends CI_Model {

	 function save($data){
        $this->db->insert('hotel_imagenes',$data);
    }

    function getById($id){
       $sql ="SELECT * FROM hotel_imagenes WHERE hotel_imagenes.id_hotel='$id'";
       return $this->db->query($sql)->result();
   }

    function delete($id){
       $sql ="DELETE FROM hotel_imagenes WHERE id='$id'";
       return $this->db->query($sql);
   }
    
}


