<?php

class Application_Model_tipoprenda extends Zend_Db_Table_Abstract
{
      protected $_name = 'tipo_prenda'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM tipo_prenda ORDER BY nombre',
      	1 => 'SELECT * FROM tipo_prenda WHERE id =',
      	2 => '', 
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
   public function CrearOrden($nombre) 
   { 
         $db = $this->IniciarBD();  
         $data = array( 
            	'nombre' => $nombre, 
            ); 
         return $this->insert($data);  
   } 
   function deleteContact($id) 
   { 
            $this->delete('id =' . (int)$id); 
   } 
  function ModificarOrden($id, $nombre)
  { 
        $data = array( 
         	 'nombre' => $nombre, 
        ); 
        $this->update($data, 'id = '. (int)$id); 
  } 
}

