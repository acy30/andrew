<?php

class Application_Model_Sertintoreria extends Zend_Db_Table_Abstract
{
      protected $_name = 'ser_tintoreria'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM ser_tintoreria',
      	1 => 'SELECT st.id,st.f_llegada,t.nombre,t.apellido,st.monto FROM ser_tintoreria st LEFT JOIN tintoreria t on st.tintoreriaid = t.id where st.f_salida is null and t.id = ', //me trae las ordenes que no an sido cerradas
      	2 => 'SELECT st.id,st.f_llegada,st.f_salida,t.nombre,t.apellido,st.monto FROM ser_tintoreria st LEFT JOIN tintoreria t on st.tintoreriaid = t.id where st.f_salida is not null and t.id = ', //me trae las ordenes que an sido cerradas
      	3 => 'SELECT * FROM ser_tintoreria WHERE id = ', //me traela onden
      	4 => 'SELECT st.id,st.f_llegada,st.f_salida,t.nombre,t.apellido,st.monto FROM ser_tintoreria st LEFT JOIN tintoreria t on st.tintoreriaid = t.id'
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
      public function CrearOrden($monto,$tintoreriaid) 
      { 
         $db = $this->IniciarBD();  
         $data = array( 
            'monto' => $monto, 
	    		'tintoreriaid' => $tintoreriaid,
            'f_llegada' => date('d-m-Y H:i:s').'', 
            ); 
         return $this->insert($data);  
      } 
      function Cerrar($id)
      { 
            $data = array( 
		'f_salida' => date('d-m-Y H:i:s').'', 
            ); 
            $this->update($data, 'id = '. (int)$id); 
      }  
      function Anular($id)
      { 
            $data = array( 
		'monto' => '0',  
		'f_salida' => 'NULA',   
            ); 
            $this->update($data, 'id = '. (int)$id); 
      }  
   /*
	*Por orden
	*/
	public function Reporte($p1,$p2){
		$q = 'SELECT st.* , te.id FROM ser_tintoreria st JOIN tintoreria_externa te ON te.tintoreriaid = st.id WHERE st.id >='.$p1.' AND st.id <='.$p2;
		$db = $this->IniciarBD();  	
	    $stmt = $db->query($q);
		$stmt->setFetchMode(Zend_Db::FETCH_NUM);
		$rows = $stmt->fetchAll();
		return $rows;

	}
	/*
	*Por fecha
	*/
	function Reporte2($mes,$ano) {
      	
      	$sql = 'SELECT st.id, st.f_llegada, st.f_salida, st.Monto, t.nombre, t.apellido FROM ser_tintoreria st JOIN tintoreria t ON t.id = st.tintoreriaid WHERE f_salida LIKE  "%-'.$mes.'-'.$ano.'%"';
      	$db = $this->IniciarBD();  	
		   $stmt = $db->query($sql);
			$stmt->setFetchMode(Zend_Db::FETCH_NUM);
			$rows = $stmt->fetchAll();
			return $rows;
      	
      }
}

