<?php

class TintoreriaController extends Zend_Controller_Action
{
	/*
	*Formularios
	*/
	public function getFormCrear()
	{
		$form = new Application_Form_Tintcrear;
		return $form;
	}
	public function getFormId()
	{
		$form = new Application_Form_Id;
		return $form;
	}

	public function actualizarAction()
	{
		$form = $this->getForm();
		echo $form; 
	}
   	/*
	*Titulo de la pag y mensajes
	*/
	public function contenidoPagina($titulo) 
	{
		$this->view->titulo = $titulo;
		$this->view->mensaje = "\"\"";
	}
    public function init(){}

	/*
	*Cargo la tabla con los clientes
	*/
	public function indexAction(){
	
		$this->view->titulo = "Clientes Tintoreria";	
	
		//***ejecuto la consulta
	   	$lav = new Application_Model_Tintoreria;
		$r = $lav->Ejecuter(0);
		$rid = $lav->Ejecuter(2);

		//***Agrego un par de campos para agregar servicios y para eliminar cliente
		for($i=0; $i<sizeof($r); $i++)
			$r[$i][5] = "<a class='eliminar' onclick=\"return confirm('¿Esta segur@ de borrar el cliente?')\" href=eliminar?id=".$rid[$i][0].">Eliminar<a>";
		
		for($i=0; $i< sizeof($r); $i++)
			$r[$i][0] = "<a class='agregar'href=../sertintoreria/gestion?id=".$rid[$i][0].">".$r[$i][0]."<a>";

		//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($r);
	    }

	/*
	*Manda el form para crear un nuevo cliente
	*/
    	public function crearAction()
   	{
   		$this->contenidoPagina("Crear Nuevo Cliente Tintoreria");
       	 	$form = $this->getFormCrear();
      	  	echo $form;   
   	}
	/*
	*Creo un nuevo cliente
	*/
    	public function guardarAction()
    	{
    		$this->_forward('index');
    		$form = $this->getFormCrear();
        	if ($form->isValid($_POST)) { //*** Valido que todos los parametros required esten
			  $lav = new Application_Model_Tintoreria;
			  $values = $form->getValues(); //*** obtengo los valores
			  $lav->addContact($values["nombre"],$values["apellido"],$values["email"],$values["cedula"],$values["telefono"]);//*** guardo los registros
			  $this->view->mensaje = "\"Cliente ".$values["nombre"]." creado con exito\"";
			  
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";
    	}
	/*
	*Elimina un cliente
	*/
    	public function eliminarAction()
    	{
		$this->_forward('index');
		$form = $this->getFormId();
		if ($form->isValid($_GET)){
			$cli = new Application_Model_Tintoreria;
			$aux = $form->getValues();
			$cli->deleteContact($aux["id"]);
			$this->view->mensaje = "\"Cliente eliminado con exito\"";
		}else
			$this->view->mensaje = "\"El cliente no pudo eliminarce\"";
    	}

}





