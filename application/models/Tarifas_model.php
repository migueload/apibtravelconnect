<?php 

class Tarifas_model extends CI_Model {

   function saveManual($data){
          $this->db->insert('tarifa',$data);
   }  

   function saveDinamica($data){
          $this->db->insert('tarifa_dinamica',$data);
   }



   function saveTMPManual($data){
          $this->db->insert('tmp_tarifa',$data);
   }

   function getAllTMPManual($username){       
        $sql ="SELECT * FROM tmp_tarifa WHERE id_usuario='$username'";
        return $this->db->query($sql)->result();
   }

    function delTMPManual($id){       
        $sql ="DELETE FROM tmp_tarifa WHERE id='$id'";
        return $this->db->query($sql);
   }

   function delManual($id){       
        $sql ="DELETE FROM tarifa WHERE id='$id'";
        return $this->db->query($sql);
   }

    function delAllTMPManual($id){       
        $sql ="DELETE FROM tmp_tarifa WHERE id_usuario='$id'";
        return $this->db->query($sql);
   }


   function saveTMPDinamica($data){
   		$this->db->insert('tmp_tarifa_dinamica',$data);
   }

   function getAllTMPDinamica($username){       
        $sql ="SELECT * FROM tmp_tarifa_dinamica WHERE id_usuario='$username'";
        return $this->db->query($sql)->result();
   }

   function delTMPDinamica($id){       
        $sql ="DELETE FROM tmp_tarifa_dinamica WHERE id='$id'";
        return $this->db->query($sql);
   }

   function delDinamica($id){       
        $sql ="DELETE FROM tarifa_dinamica WHERE id='$id'";
        return $this->db->query($sql);
   }

    function delAllTMPDinamica($id){       
        $sql ="DELETE FROM tmp_tarifa_dinamica WHERE id_usuario='$id'";
        return $this->db->query($sql);
   }

   function getManualByHotel($id){
        $sql ="SELECT * FROM tarifa WHERE id_hotel='$id'";
        return $this->db->query($sql)->result();
   }

    function getDinamicaByHotel($id){
        $sql ="SELECT * FROM tarifa_dinamica WHERE id_hotel='$id'";
        return $this->db->query($sql)->result();
   }

}
