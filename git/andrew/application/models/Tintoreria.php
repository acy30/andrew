<?php

class Application_Model_Tintoreria extends Zend_Db_Table_Abstract
{
      protected $_name = 'tintoreria';
      protected $consultas = array(
      	0 => 'SELECT nombre,apellido,email,telefono,cedula FROM tintoreria',
      	1 => 'SELECT * FROM tintoreria WHERE id = ',
      	2 => 'SELECT id FROM tintoreria',
      	3 => '',
      	4 => ''
      ); 

	/*
	***seteo la conexion a BD
	*/
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

      public function getContact($id) 
      { 
            $id = (int)$id; 
            $row = $this->fetchRow('id = ' . $id); 
            if (!$row) { 
                 throw new Exception("No se encuentra la fila $id"); 
            } 
            return $row->toArray(); 
      } 
      public function addContact($nombre, $apellido, $email,$cedula,$telefono) 
      { 
            $data = array( 
                 'nombre' => $nombre, 
                 'apellido' => $apellido, 
                 'email' => $email,
				'cedula' => $cedula,  
		 'telefono' => $telefono,
            ); 
            $this->insert($data); 
      } 
      function updateContact($id, $nombre, $apellido, $email,$telefono)
      { 
            $data = array( 
                 'nombre' => $nombre, 
                 'apellido' => $apellido, 
                 'email' => $email,
				 'cedula' => $cedula, 
		 'telefono' => $telefono, 
            ); 
            $this->update($data, 'id = '. (int)$id); 
      } 
      function deleteContact($id) 
      { 
            $this->delete('id =' . (int)$id); 
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

}

