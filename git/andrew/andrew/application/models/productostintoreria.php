<?php

class Application_Model_productostintoreria extends Zend_Db_Table_Abstract
{
      protected $_name = 'productos_tintoreria'; 
      protected $consultas = array(
      	0 => 'SELECT * FROM productos_tintoreria ORDER BY nombre',
      	1 => 'SELECT tp.nombre,pt.id,pt.nombre,pt.precio,mtc.cantidad FROM tipo_prenda tp 
			LEFT JOIN mer_tin_cli mtc 
			on mtc.tipo_prendaid =tp.id 
			LEFT JOIN productos_tintoreria pt 
			on pt.id = mtc.productos_tintoreria_id
			WHERE mtc.ser_tintoreriaid= ',//me trae los productos del la factura actual
      	2 => 'SELECT * FROM productos_tintoreria WHERE id =', 
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
   function deleteContact($id) 
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

