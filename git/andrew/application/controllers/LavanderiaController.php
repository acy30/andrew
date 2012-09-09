<?php

class LavanderiaController extends Zend_Controller_Action
{

    public function getFormCrear()
    {
		$form = new Application_Form_Lavcrear;
		return $form;
    }
    public function getFormId()
    {
		$form = new Application_Form_Id;
		return $form;
    }

    public function init()
    {
    }

    public function contenidoPagina($titulo)
    {
		$this->view->titulo = $titulo;
		$this->view->mensaje = "\"\"";
    }

    public function indexAction()
    {
	
		$this->view->titulo = "Clientes Lavanderia";	
	
		//***ejecuto la consulta
	   $lav = new Application_Model_Lavanderia;
		$r = $lav->Ejecuter(0);
		$rid = $lav->Ejecuter(2);
		//***Agrego un par de campos para agregar servicios y para eliminar cliente
		for($i=0; $i<sizeof($r); $i++)
			$r[$i][5] = "<a class='eliminar' onclick=\"return confirm('¿Esta segur@ de borrar el cliente?')\" href=eliminar?id=".$rid[$i][0].">Eliminar<a>";
		
		for($i=0; $i< sizeof($r); $i++)
			$r[$i][0] = "<a class='agregar'href=../serlavanderia/gestion?id=".$rid[$i][0].">".$r[$i][0]."<a>";

		//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($r);
    }

    public function crearAction()
    {
   		$this->contenidoPagina("Crear Nuevo Cliente Lavanderia");
       	 	$form = $this->getFormCrear();
      	  	echo $form;   
    }

    public function guardarAction()
    {
    		$this->_forward('index');
    		$form = $this->getFormCrear();
        	if ($form->isValid($_POST)) { //*** Valido que todos los parametros required esten
			  $lav = new Application_Model_Lavanderia;
			  $values = $form->getValues(); //*** obtengo los valores
			  $lav->addContact($values["nombre"],$values["apellido"],$values["email"],$values["cedula"],$values["telefono"]);//*** guardo los registros
			  $this->view->mensaje = "\"Cliente ".$values["nombre"]." creado con exito\"";
			  
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";
    }

    public function eliminarAction()
    {
		$this->_forward('index');
		$form = $this->getFormId();
		if ($form->isValid($_GET)){
			$cli = new Application_Model_Lavanderia;
			$aux = $form->getValues();
			$cli->deleteContact($aux["id"]);
			$this->view->mensaje = "\"Cliente eliminado con exito\"";
		}else
			$this->view->mensaje = "\"El cliente no pudo eliminarce\"";
    }

}













