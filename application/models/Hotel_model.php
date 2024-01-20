<?php 

class Hotel_model extends CI_Model {
    
    
    function getAllAdmin(){
        $sqlH ="SELECT h.*, 
        (SELECT pais.nombre FROM pais WHERE pais.id=h.id_pais) as pais, 
        (SELECT ciudad.nombre FROM ciudad WHERE ciudad.id=h.id_ciudad) as ciudad 
        FROM hotel h WHERE h.status=1 ORDER BY h.nombre DESC";
        $responseHotel=$this->db->query($sqlH)->result();
        return $responseHotel;
    }



    function getAll(){
        $sqlH ="SELECT h.*, 
        (SELECT pais.nombre FROM pais WHERE pais.id=h.id_pais) as pais, 
        (SELECT ciudad.nombre FROM ciudad WHERE ciudad.id=h.id_ciudad) as ciudad 
        FROM hotel h WHERE h.status=1 ORDER BY h.nombre DESC";

        $responseHotel=$this->db->query($sqlH)->result();
        $result=array();
        $resultImagenes=array();

        foreach($responseHotel as $rowHot){
            
            $sqlImagenes="SELECT * FROM hotel_imagenes IMG WHERE IMG.id_hotel='$rowHot->id'";
            $resultImagenes=$this->db->query($sqlImagenes)->result();
            
            $item=array(
                    'hotel'=>$rowHot,
                    'imagenes'=>$resultImagenes
                );
            array_push($result, $item);
                
        }
        return $result;

    }

    function getById($id){
       $sql ="SELECT hotel.*,
       (SELECT pais.nombre FROM pais WHERE hotel.id_pais=pais.id) AS pais, 
       (SELECT ciudad.nombre FROM ciudad WHERE hotel.id_ciudad=ciudad.id) AS ciudad 
       FROM hotel WHERE hotel.id='$id'";
       return $this->db->query($sql)->result()[0];
   }

   function getLastId(){
        $sql="SELECT MAX(id) AS id FROM hotel ORDER BY id desc";
        $codigo=$this->db->query($sql)->result()[0]->id;
        return $codigo; 
   }

   function saveOne($data){
        $this->db->insert('hotel',$data);
        return $this->getLastId();
    }

   function save($data){
        foreach ($data['hotel'] as $hotel) {
           if ( ($hotel['nombre']!="") && ($hotel['categoria']!="") && ($hotel['direccion']!="") && ($hotel['hentrada']!="") && ($hotel['hsalida']!="") && ($hotel['emailreservas']!="") ){
               $datos['nombre']=$hotel['nombre'];
               $datos['categoria']=$hotel['categoria'];
               $datos['direccion']=$hotel['direccion'];
               $datos['id_pais']=$hotel['id_pais'];
               $datos['id_ciudad']=$hotel['id_ciudad'];
               $datos['codigopostal']=$hotel['codigopostal'];
               $datos['telefono']=$hotel['telefono'];
               $datos['fax']=$hotel['fax'];
               $datos['emailreservas']=$hotel['emailreservas'];
               $datos['emailpublico']=$hotel['emailpublico'];
               $datos['hentrada']=$hotel['hentrada'];
               $datos['hsalida']=$hotel['hsalida'];
               $datos['descripcion_hotel']=$hotel['descripcion_hotel'];
               $datos['habitacion']=$hotel['habitacion'];
               $datos['restaurante']=$hotel['restaurante'];
               $datos['direccion_mapa']=$hotel['direccion_mapa'];
               $datos['latitud']=$hotel['latitud'];
               $datos['longitud']=$hotel['longitud'];
               $this->db->insert('hotel',$datos);
                $result = array(
                    'message'=>'success'
                );
        }else{
                $result = array(
                    'message'=>'Los campos: Nombre, categoria, direccion, Hora de Entrada, Hora de Salida, E-mail de Reservas son requridos'
                );
        }


        foreach ($data['facilidades_hotel'] as $facilidad) {
               $datos_hot['id_facilidad']=$facilidad['id'];
               $datos_hot['id_hotel']=$this->getLastId();
               $this->db->insert('facilidades_hot',$datos_hot);
        }

         foreach ($data['facilidades_habitacion'] as $facilidad) {
               $datos_hab['id_facilidad']=$facilidad['id'];
               $datos_hab['id_hotel']=$this->getLastId();
               $this->db->insert('facilidades_hab',$datos_hab);
        }

        
        return $result;
   }
}

   function edit($data){
    $sql="UPDATE hotel SET descripcion='$data->descripcion' WHERE id='$data->id'";
    $this->db->query($sql);
   }

    function delete($id){
     $sql="UPDATE hotel SET status='0' WHERE id='$id'";
    $this->db->query($sql);
   }


   function calcularNochesTranscurridas($fechaInicio, $fechaFin) {
        $inicio = new DateTime($fechaInicio);
        $fin = new DateTime($fechaFin);
        $diferencia = $inicio->diff($fin);
        $noches = $diferencia->days;
        return $noches;
    }

    function contarPersonasYParejas($numeroPersonas) {
        $personasPorPareja = 2;
        $parejasCompletas = intdiv($numeroPersonas, $personasPorPareja);
        $personasSolteras = $numeroPersonas % $personasPorPareja;
        return $parejasCompletas +$personasSolteras;
}


    //*** Consultas Api REST de App ***
   function getHotelApp($data){
        
    $country=$data->country;
    $city=$data->city;
    $ages_children=$data->ages_children;

    $children=0;
    foreach($ages_children as $rowAge){
        if($rowAge->age>11){
            $children++;
        }
    }
    
    $adult=$this->contarPersonasYParejas(($data->adult+$children));
    

    $from=$data->from;
    $to=$data->to;

    $noches= $this->calcularNochesTranscurridas($from, $to);

    $sqlH ="SELECT H.id,
           H.nombre,
           H.categoria,
           H.direccion,
           (SELECT C.nombre FROM ciudad C WHERE C.id=H.id_ciudad) as ciudad,
           (SELECT C.nombre FROM pais P WHERE P.id=H.id_pais) as pais,
           H.codigopostal,
           H.telefono,
           H.fax,
           H.emailreservas,
           H.emailpublico,
           H.hentrada as hora_entrada,
           H.hsalida as hora_salida,
           H.descripcion_hotel as descripcion,
           H.habitacion,
           H.restaurante,
           H.direccion_mapa,
           H.latitud,
           H.longitud
           FROM hotel H, ciudad C WHERE H.id_pais='$country' AND H.id_ciudad='$city' GROUP BY H.id";
       
        $responseHotel=$this->db->query($sqlH)->result();
        $result=array();
        $resultTarifa=array();

        foreach($responseHotel as $rowHot){
            
            $sqlT ="SELECT id,tipo,tipo_habitacion,descripcion, monto as precio, ('$noches') AS noches , (SELECT (monto * '$adult' * '$noches')) AS total_precio FROM tarifa WHERE id_hotel='$rowHot->id'";
            $responseTarifa=$this->db->query($sqlT)->result();
            
            $sqlFHab ="SELECT hab.id, hab.descripcion FROM habitacion_facilidades hab, facilidades_hab fac WHERE  hab.id=fac.id_facilidad AND fac.id_hotel='$rowHot->id'";
            $responseFacilidadHabitacion=$this->db->query($sqlFHab)->result();

            $sqlFHot ="SELECT hot.id, hot.descripcion FROM hotel_facilidades hot, facilidades_hot fac WHERE  hot.id=fac.id_facilidad AND fac.id_hotel='$rowHot->id'";
            $responseFacilidadHotel=$this->db->query($sqlFHot)->result();



            
            $item=array(
                    'hotel'=>$rowHot,
                    'tarifas'=>$responseTarifa,
                    'facilidades_habitacion'=>$responseFacilidadHabitacion,
                    'facilidades_hotel'=>$responseFacilidadHotel
                );
            array_push($result, $item);
                
        }
        return $result;
    }
     

     function getHotelAppById($id){
    
        $sqlH ="SELECT H.id,
           H.nombre,
           H.categoria,
           H.direccion,
           (SELECT C.nombre FROM ciudad C WHERE C.id=H.id_ciudad) as ciudad,
           (SELECT C.nombre FROM pais P WHERE P.id=H.id_pais) as pais,
           H.codigopostal,
           H.telefono,
           H.fax,
           H.emailreservas,
           H.emailpublico,
           H.hentrada as hora_entrada,
           H.hsalida as hora_salida,
           H.descripcion_hotel as descripcion,
           H.habitacion,
           H.restaurante,
           H.direccion_mapa,
           H.latitud,
           H.longitud
           FROM hotel H, ciudad C WHERE H.id='$id' GROUP BY H.id";
       
        $responseHotel=$this->db->query($sqlH)->result();
        $result=array();

        foreach($responseHotel as $rowHot){
            
            $sqlT ="SELECT id,tipo,tipo_habitacion,descripcion, monto as precio FROM tarifa WHERE id_hotel='$rowHot->id'";
            $responseTarifa=$this->db->query($sqlT)->result();
            
            $sqlFHab ="SELECT hab.id, hab.descripcion FROM habitacion_facilidades hab, facilidades_hab fac WHERE  hab.id=fac.id_facilidad AND fac.id_hotel='$rowHot->id'";
            $responseFacilidadHabitacion=$this->db->query($sqlFHab)->result();

            $sqlFHot ="SELECT hot.id, hot.descripcion FROM hotel_facilidades hot, facilidades_hot fac WHERE  hot.id=fac.id_facilidad AND fac.id_hotel='$rowHot->id'";
            $responseFacilidadHotel=$this->db->query($sqlFHot)->result();

            $sqlImagenes="SELECT * FROM hotel_imagenes IMG WHERE IMG.id_hotel='$rowHot->id'";
            $responseImagenes=$this->db->query($sqlImagenes)->result();

            
            $item=array(
                    'hotel'=>$rowHot,
                    'tarifas'=>$responseTarifa,
                    'facilidades_habitacion'=>$responseFacilidadHabitacion,
                    'facilidades_hotel'=>$responseFacilidadHotel,
                    'imagenes_hotel'=>$responseImagenes
                );
            array_push($result, $item);
                
        }
        return $result;

    }  

}