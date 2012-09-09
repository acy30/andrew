<?php

class Application_Model_productoslavanderia extends Zend_Db_Table_Abstract
{
      protected $_name = 'productos_lavanderia'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM productos_lavanderia ORDER BY nombre',
      	1 => 'SELECT pl.nombre,pl.id,pl.nombre,pl.precio,plc.cantidad FROM pro_lav_cli plc  
			LEFT JOIN productos_lavanderia pl 
			on pl.id = plc.productos_lavanderia_id
			WHERE plc.ser_lavanderiaid= ',
      	2 => 'SELECT * FROM productos_lavanderia WHERE id = ', 
      	3 => '',
      	4 => ''
      );

      public function IniciarBD() {
    	  try {
      	  // Seteos para la conexión con la base de datos
        	$db = Zend_Db::factory('Pdo_Mysql', array(
         	'host'     => 'localhost',
            	'username' => 'root',
            	'password' => 'root',
            	'dbname'   => 'andrew'
        	));
        
        	//Test de conexión con la base de datos
        	$db->getConnection();        
         	return $db;

	} catch (Zend_Db_Adapter_Exception $e) {
		//Sucedió un error con las credenciales del usuario o la base de datos.
		die($e->getMessage());
	} catch (Zend_Exception $e) {
		// Sucedió un error inexperado
		die($e->getMessage());
	}	
      }
      /*
       *Modulo para ejecutar querys estaticos y retorna el res
       */
	public function Ejecuter($n) {
		$db = $this->IniciarBD();  	
	      	$stmt = $db->query($this->consultas[$n]);
		$stmt->setFetchMode(Zend_Db::FETCH_NUM);
		$rows = $stmt->fetchAll();
		return $rows;
	}
   public function Ejecuter2($n,$p1) {
		$db = $this->IniciarBD();  	
	   $stmt = $db->query($this->consultas[$n].$p1);
		$stmt->setFetchMode(Zend_Db::FETCH_NUM);
		$rows = $stmt->fetchAll();
		return $rows;
	}
   public function CrearOrden($nombre,$descripcion,$precio) 
   { 
         $db = $this->IniciarBD();  
         $data = array( 
            	'nombre' => $nombre, 
	    		'descripcion' => $descripcion,
            	'precio' => $precio, 
            ); 
         return $this->insert($data);  
   } 
   public function deleteContact($id) 
   { 
        $this->delete('id =' . (int)$id); 
   } 

  function ModificarOrden($id, $nombre, $descripcion, $precio)
  { 
        $data = array( 
         	 'nombre' => $nombre, 
             'descripcion' => $descripcion, 
             'precio' => $precio, 
        ); 
        $this->update($data, 'id = '. (int)$id); 
  } 
}

