<?php

class TintexternaController extends Zend_Controller_Action
{

	public function init()
	{
	/* Initialize action controller here */
	}

	/*
	*Formularios
	*/
	public function getFormId()
	{
		$form = new Application_Form_Id;
		return $form;
	}

   /*
	*Titulo de la pag y mensajes
	*/
	public function contenidoPagina($titulo)
	{
		$this->view->mensaje = "\"\"";
		$this->view->titulo = $titulo;
	}
	/*
	*Cargo la tabla con los clientes
	*/
	public function indexAction()
	{
		$this->view->titulo="Ordenes Tintoreria Externa";	
	
		//***ejecuto la consulta
	   $exttin = new Application_Model_Tintoreriaexterna;
		$r = $exttin->Ejecuter(0);

		//***Agrego un par de campos para agregar servicios y para eliminar cliente
		for($i=0; $i<sizeof($r); $i++){
				$r[$i][5] = "<a class='cerrar' onclick=\"return confirm('¿Esta segur@ de cerrar la orden?')\" href=cerrar?id=".$r[$i][0].">Cerrar<a>";
				$r[$i][6] = "<a class='imprimir' href=../pdf/tintexterna?id=".$r[$i][1].">Descargar factura<a>";
		}
		//***devuelvo el json de la consulta
	   $this->view->json = Zend_Json::encode($r);
	}

	/*
	***Cierro la orden del cliente (vino a buscarla)
	*/
	public function cerrarAction()
	{
		$form = $this->getFormId();
		$this->_forward('index');
		$this->contenidoPagina("Cerrar Orden Tintoreria Externa");
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
			$sertin = new Application_Model_Tintoreriaexterna;
			$values = $form->getValues(); //*** obtengo los valores
			$sertin->Cerrar($values["id"]);//*** guardo los registros
			$this->view->mensaje = "\"Orden ".$values["id"]." Cerrada con exito\""; 
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";      

	}
	/*
	***Muestro las ordenes cerradas cel cliente actual
	*/
	public function cerradasAction()
	{
			$this->contenidoPagina("Ordenes Tintoreria Externa Cerradas y/o Nulas");
	
			//***ejecuto la consulta
	   	$exttin = new Application_Model_Tintoreriaexterna;
			$r = $exttin->Ejecuter(1);
			//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($r);
	}
	public function exitoAction()
	{}

}

