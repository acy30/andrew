<?php

class Application_Model_Tintoreriaexterna extends Zend_Db_Table_Abstract
{
      protected $_name = 'tintoreria_externa'; 
      protected $consultas = array(
      	0 => 'SELECT te.id, st.id, st.f_llegada, te.llego, st.monto FROM ser_tintoreria st , tintoreria_externa te WHERE te.llego="N" and te.tintoreriaid = st.id',//me trae las ordenes que no an sido cerradas
      	1 => 'SELECT te.id, st.id, st.f_llegada,te.f_llegada, te.llego, st.monto FROM ser_tintoreria st , tintoreria_externa te WHERE te.llego="Y" and te.tintoreriaid = st.id', //me trae las ordenes que an sido cerradas
      	2 => 'SELECT * FROM tintoreria_externa WHERE tintoreriaid = ', 
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
      public function CrearOrden($tintoreriaid) 
      { 
         $data = array( 
		 'tintoreriaid' => $tintoreriaid,
            ); 
         $this->insert($data); 
      } 
      function Cerrar($id,$monto)
      { 
            $data = array( 
		'f_llegada' => date('d-m-Y H:i:s').'',  
		'llego' => 'Y', 
            ); 
            $this->update($data, 'id = '. (int)$id); 
      }  
      function Anular($id)
      { 
            $data = array( 
				'f_llegada' => 'NULA',  
				 'llego' => '',  
            ); 
            $this->update($data, 'tintoreriaid = '. (int)$id); 
      }  

}

