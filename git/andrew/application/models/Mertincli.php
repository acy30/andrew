<?php

class Application_Model_Mertincli extends Zend_Db_Table_Abstract
{
   protected $_name = 'mer_tin_cli'; 
   public function crearOrden($ser_tintoreriaid,$productos_tintoreria_id,$cantidad,$tipo_prendaid) 
   { 
         $data = array( 
            'ser_tintoreriaid' => $ser_tintoreriaid, 
	         'productos_tintoreria_id' => $productos_tintoreria_id,
            'cantidad' => $cantidad, 
	         'tipo_prendaid' => $tipo_prendaid, 
            ); 
         $this->insert($data); 
   } 

}

