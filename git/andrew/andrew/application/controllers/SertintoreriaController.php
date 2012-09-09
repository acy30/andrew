<?php

class SertintoreriaController extends Zend_Controller_Action
{


	/*
	*Me dice si la orden se puede cerrar
	*/

	public function Puedo_Cerrar($id){
			//***ejecuto la consulta
	   		$sertin = new Application_Model_Tintoreriaexterna;
			$r = $sertin->Ejecuter2(2,$id);
			if($r[0][2] == 'Y')
				return true;
			return false;
	}

	/*
	*Formularios
	*/
	public function getFormCrear()
	{
		$form = new Application_Form_Tintcrearorden;
		return $form;
	}

	public function getFormCerrar()
	{
		$form = new Application_Form_Serviciocerrar;
		return $form;
	}

	public function getFormId()
	{
		$form = new Application_Form_Id;
		return $form;
	}

	public function init(){}

   	/*
	*Titulo de la pag y mensajes
	*/
	public function contenidoPagina($titulo)
	{
		$this->view->mensaje = "\"\"";
		$this->view->titulo = $titulo;
	}
	public function exitoAction(){}
	/*
	***pinto el form en pantalla para crear una orden a un cliente
	*/
	public function crearAction()
	{
		$this->contenidoPagina("Crear Orden Tintoreria");
	   $form = $this->getFormId();
	   
		if ($form->isValid($_GET)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
			$form = $this->getFormCrear();
			$tin=$form->getElement('tintoreriaid');
			$tin->setValue($values["id"]);

			//***ejecuto la consulta
	   	$tippre = new Application_Model_productostintoreria;
			//***devuelvo el json de la consulta
	    	$this->view->prod = Zend_Json::encode($tippre->Ejecuter(0));

			//***ejecuto la consulta
	   	$tippre = new Application_Model_tipoprenda;			
			//***devuelvo el json de la consulta
	    	$this->view->tipo = Zend_Json::encode($tippre->Ejecuter(0));

			   echo $form;   
		}else 
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
	}
	/*
	***Guardo la orden del cliente
	*/
	public function guardarAction()
	{
	   $this->_forward('index','tintoreria');
	   $this->contenidoPagina("Crear Orden Tintoreria");
		$form = $this->getFormCrear();		
		
		if ($form->isValid($_POST)) { //*** Me llego el form
				$values = $form->getValues(); //*** obtengo los valores
				$sertin = new Application_Model_Sertintoreria;	
				$mertin = new Application_Model_Mertincli;
				$tinext = new Application_Model_Tintoreriaexterna;
				
				//*** recorro todos los tipos de prenda
				$prendas = split(",", $values["tipo_prendaid"]);
				$cantidades = split(",", $values["cantidades"]);
				$productos = split(",", $values["productos_tintoreriaid"]);			
				
				$idorden = $sertin->crearOrden($values["montototal"],$values["tintoreriaid"]);//*** Creo la orden
				$tinext = $tinext->crearOrden($idorden);//Creo una orden externa
				for($i=1; $i<sizeof($productos); $i++)
					$mertin->crearOrden($idorden,$productos[$i],$cantidades[$i],$prendas[$i]);//*** guardo las prenda asociadas a la orden
				$this->view->mensaje =  "\"Orden ".$idorden." creada satisfactoriamente\"";
		}else 
				$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\"";        	
	}
	/*
	***Cierro la orden del cliente (vino a buscarla)
	*/
	public function cerrarAction()
	{
		$form = $this->getFormId();
		$this->_forward('index','tintoreria');
		$this->contenidoPagina("Cerrar Orden Tintoreria");
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
			$sertin = new Application_Model_Sertintoreria;
			$values = $form->getValues(); //*** obtengo los valores
			
			if($this->Puedo_Cerrar($values["id"])){
				$this->view->mensaje = "\"Orden ".$values["id"]." cerrada satisfactoriamente\""; 
				$sertin->Cerrar($values["id"]);//*** guardo los registros
			}else
				$this->view->mensaje = "\"Orden ".$values["id"]." no ha llegado a andrew no se puede cerrar\"";
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";      

	}
	/*
	***Anulo una Orden
	*/
	public function anularAction()
	{
	   $this->contenidoPagina("Orden Anulada Satisfactoriamente");
	   $this->_forward('index','tintoreria');
			$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$sertin = new Application_Model_Sertintoreria;
				$sertinext = new Application_Model_Tintoreriaexterna;
			    $values = $form->getValues(); //*** obtengo los valores
			    $sertin->Anular($values["id"]);//*** guardo los registros
				$sertinext->Anular($values["id"]);//*** guardo los registros
				$this->view->mensaje = "\"Orden ".$values["id"]." anulada  satisfactoriamente\""; 

		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";         

	}
	/*
	***Pinto todas las ordnenes del cliente seleccionado
	*/
	public function gestionAction()
	{
		$this->contenidoPagina("Gestion de Ordenes Tintoreria");
		//*** Obtengo el cliente
		$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
			$values = $form->getValues(); //*** obtengo los valores
			$this->view->id = $values["id"];
			//***ejecuto la consulta
	   		$sertin = new Application_Model_Sertintoreria;
			$r = $sertin->Ejecuter2(1,$values["id"]);
			for($i=0; $i< sizeof($r); $i++){
				$r[$i][5] = "<a class='cerrar' onclick=\"return confirm('¿Esta segur@ de cerrar la orden?')\" href=cerrar?id=".$r[$i][0].">Cerrar<a>";
				$r[$i][6] = "<a class='anular' onclick=\"return confirm('¿Esta segur@ de anular la orden?')\" href=anular?id=".$r[$i][0].">Anular<a>";
				$r[$i][7] = "<a class='imprimir' href=../pdf/tintexterna?id=".$r[$i][0].">Descargar factura<a>";
			}
		
			//***devuelvo el json de la consulta
	    		$this->view->json = Zend_Json::encode($r);
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; No esta el Id del cliente\""; 
	}
	/*
	***Muestro las ordenes cerradas cel cliente actual
	*/
	public function cerradasAction()
	{
	$this->contenidoPagina("Ordenes Cerradas Tintoreria y/o Nulas");
		//*** Obtengo el cliente
		$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$this->view->id = $values["id"];
					//***ejecuto la consulta
	   		$serlav = new Application_Model_Sertintoreria;
				$r = $serlav->Ejecuter2(2,$values["id"]);
		
			//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($r);
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; No esta el Id del cliente\""; 
	}

	/*
	***Facturas
	*/
	public function ordenesAction()
	{
		$this->contenidoPagina("Todas Facturas Tintoreria");
		$sertin = new Application_Model_Sertintoreria;
		$r = $sertin->Ejecuter(4);
		//***devuelvo el json de la consulta

			for($i=0; $i< sizeof($r); $i++)
				$r[$i][6] = "<a class='imprimir' href=../pdf/tintexterna?id=".$r[$i][0].">Descargar factura<a>";

	    $this->view->json = Zend_Json::encode($r);

	}
}














