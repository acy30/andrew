<?php

class Application_Model_Prolavcli extends Zend_Db_Table_Abstract
{
      protected $_name = 'pro_lav_cli'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM pro_lav_cli WHERE ser_lavanderiaid = ', //*** me dice si existe un producto reg a la orden actual
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

      public function crearOrden($ser_lavanderiaid,$productos_lavanderia_id,$cantidad) 
      { 
         $data = array( 
            'ser_lavanderiaid' => $ser_lavanderiaid, 
	    	'productos_lavanderia_id' => $productos_lavanderia_id,
            'cantidad' => $cantidad,
            ); 
         $this->insert($data); 
      } 
      /*
       *Modulo para ejecutar querys estaticos y retorna el res
       */
   	public function Ejecuter2($n,$p1) {

		$db = $this->IniciarBD();  	
	   $stmt = $db->query($this->consultas[$n].$p1);
		$stmt->setFetchMode(Zend_Db::FETCH_NUM);
		$rows = $stmt->fetchAll();
		return $rows;
	}	

}

