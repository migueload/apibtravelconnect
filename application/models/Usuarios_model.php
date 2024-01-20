<?php 

class Usuarios_model extends CI_Model {
    
    function getAll(){
        $sql ="SELECT usuario.*, hotel.nombre as nombre_hotel FROM hotel, usuario WHERE usuario.id_hotel=hotel.id  ORDER BY id desc";
        return $this->db->query($sql)->result();
    }

    function getAllAdmin(){
        $sql ="SELECT * from usuario WHERE usuario.nivel=0 ORDER BY id desc";
        return $this->db->query($sql)->result();
    }
    
    function getById($id){
       $sql ="SELECT * FROM usuario WHERE id='$id'";
       return $this->db->query($sql)->result()[0];
   }

   function getByUsername($username){
       $sql ="SELECT * FROM usuario WHERE username='$username'";
       return $this->db->query($sql)->result()[0];
   }

   function save($data){
    $this->db->insert('usuario',$data);
   }

   function edit($data){
    $this->db->where('id',$data->id);
    $this->db->update('usuario',$data);
   }

    function delete($id){
      $sql ="DELETE FROM usuario WHERE id='$id'";
      $this->db->query($sql);
   }

  



}