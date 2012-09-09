<?php

class Application_Model_Serlavanderia extends Zend_Db_Table_Abstract
{
      protected $_name = 'ser_lavanderia'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM ser_lavanderia',
      	1 => 'SELECT sl.id,sl.f_llegada,l.nombre,l.apellido,sl.monto FROM ser_lavanderia sl LEFT JOIN lavanderia l on sl.lavanderiaid = l.id where sl.f_salida is null and l.id = ', //me trae las ordenes que no an sido cerradas
      	2 => 'SELECT sl.id,sl.f_llegada,sl.f_salida,l.nombre,l.apellido,sl.monto FROM ser_lavanderia sl LEFT JOIN lavanderia l on sl.lavanderiaid = l.id where sl.f_salida is not null and l.id = ', //me trae las ordenes que an sido cerradas
      	3 => 'SELECT * FROM ser_lavanderia WHERE id = ',
      	4 => 'SELECT sl.id,sl.f_llegada,sl.f_salida,l.nombre,l.apellido,sl.monto FROM ser_lavanderia sl LEFT JOIN lavanderia l on sl.lavanderiaid = l.id'
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
	/*
	*Por orden
	*/
      
	public function Reporte($p1,$p2){
		$q = 'SELECT *  FROM ser_lavanderia WHERE id >='.$p1.' AND id <='.$p2;
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
      	
      	$sql = 'SELECT * FROM ser_lavanderia WHERE f_salida LIKE  "%-'.$mes.'-'.$ano.'%"';
      	$db = $this->IniciarBD();  	
		   $stmt = $db->query($sql);
			$stmt->setFetchMode(Zend_Db::FETCH_NUM);
			$rows = $stmt->fetchAll();
			return $rows;
      	
      }
   public function CrearOrden($lavanderiaid) 
   { 
         $db = $this->IniciarBD();  
         $data = array( 
            'monto' => 0, 
	    		'lavanderiaid' => $lavanderiaid,
            'f_llegada' => date('d-m-Y H:i:s').'', 
            ); 
         return $this->insert($data);  
   } 
   function CerrarOrden($id)
   { 
      $data = array( 
			'f_salida' => date('d-m-Y H:i:s').'',  
      ); 
      $this->update($data, 'id = '. (int)$id); 
      }  
   function AbonarOrden($id,$monto)
   { 
      $data = array( 
			'monto' => $monto, 
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

}

