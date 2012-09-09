<?php

class SerlavanderiaController extends Zend_Controller_Action
{

    public function getFormCrear()
    {
		$form = new Application_Form_Lavcrearorden;
		return $form;
    }

    public function getFormCerrar()
    {
		$form = new Application_Form_Serviciocerrarlav;
		return $form;
    }

    public function getFormAbonar()
    {
		$form = new Application_Form_Servicioabonarlav;
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

	/*
	*Me dice si la orden se puede cerrar tiene algo abonado
	*/

	public function Puedo_Cerrar($id){
			//***ejecuto la consulta
	   		$sertin = new Application_Model_Prolavcli;
			$r = $sertin->Ejecuter2(0,$id);
			if(sizeof($r) > 0)
				return true;
			return false;
	}

    public function contenidoPagina($titulo)
    {
		$this->view->mensaje = "\"\"";
		$this->view->titulo = $titulo;
    }

    public function exitoAction()
    {
    }

    public function crearAction()
    {
		$this->_forward('index','lavanderia');
		$this->contenidoPagina("Crear Orden Lavanderia");
	   	$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
			$serlav = new Application_Model_Serlavanderia;
			$values = $form->getValues(); //*** obtengo los valores
			$orden = $serlav->CrearOrden($values["id"]);//*** guardo los registros  
			$this->view->mensaje =  "\"Orden ".$orden." creada satisfactoriamente\""; 
		}else 
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
    }

    public function cerrarAction()
    {
    	$form = $this->getFormId();
		$this->_forward('index','lavanderia');
		$this->contenidoPagina("Cerrar Orden Lavanderia");
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
			$serlav = new Application_Model_Serlavanderia;
			$values = $form->getValues(); //*** obtengo los valores
			
			if($this->Puedo_Cerrar($values["id"])){
				$this->view->mensaje = "\"Orden ".$values["id"]." cerrada satisfactoriamente\""; 
				$serlav->CerrarOrden($values["id"]);//*** guardo los registros
			}else
				$this->view->mensaje = "\"Orden ".$values["id"]." no se le ha abonado nada aun; no se puede cerrar\"";
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";     

    }

    public function cerrar2Action()
    {
	$this->contenidoPagina("Orden Cerrada Satisfactoriamente");
		$this->_forward('index','lavanderia');
		$form = $this->getFormCerrar();
		if ($form->isValid($_POST)) { //*** Valido que todos los parametros required esten
			$serlav = new Application_Model_Serlavanderia;
			$values = $form->getValues(); //*** obtengo los valores
			$serlav->Cerrar($values["id"],$values["monto"]);//*** guardo los registros
			$this->view->mensaje = "\"Orden ".$values["id"]." cerrada satisfactoriamente\"";  
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";      

    }

    public function anularAction()
    {
	   $this->contenidoPagina("Orden Anulada Satisfactoriamente");
	   $this->_forward('index','lavanderia');
			$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$serlav = new Application_Model_Serlavanderia;
			   $values = $form->getValues(); //*** obtengo los valores
			   $serlav->Anular($values["id"]);//*** guardo los registros
				$this->view->mensaje = "\"Orden ".$values["id"]." anulada satisfactoriamente\""; 
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";         

    }

    public function gestionAction()
    {
		$this->contenidoPagina("Gestion de Ordenes Lavanderia");
		//*** Obtengo el cliente
		$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$this->view->id = $values["id"];
				//***ejecuto la consulta
	   		$serlav = new Application_Model_Serlavanderia;
				$r = $serlav->Ejecuter2(1,$values["id"]);
				for($i=0; $i< sizeof($r); $i++){
					$r[$i][5] = "<a class='abonar' href=abonar?id=".$r[$i][0].">Abonar<a>";
					$r[$i][6] = "<a class='cerrar' href=cerrar?id=".$r[$i][0].">Cerrar<a>";
					$r[$i][7] = "<a class='anular' onclick=\"return confirm('¿Esta segur@ de anular la orden?')\" href=anular?id=".$r[$i][0].">Anular<a>";
					$r[$i][8] = "<a class='imprimir' href=../pdf/lavanderia?id=".$r[$i][0].">Descargar factura<a>";
				}
		
			//***devuelvo el json de la consulta
	    		$this->view->json = Zend_Json::encode($r);
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; No esta el Id del cliente\""; 
    }

    public function guardarAction()
    {
	   $this->_forward('index','lavanderia');
	   $this->contenidoPagina("Crear Orden Lavanderia");
		$form = $this->getFormCerrar();		
		
		if ($form->isValid($_POST)) { //*** Me llego el form
				$values = $form->getValues(); //*** obtengo los valores
				$serlav = new Application_Model_Serlavanderia;	
				$merlav = new Application_Model_Prolavcli;
				
				//*** recorro todos las productosqueconformanla orden
				$cantidades = split(",", $values["cantidades"]);
				$productos = split(",", $values["productos_lavanderiaid"]);			
				
				$serlav->AbonarOrden($values["id"],$values["montototal"]);//*** Creo la orden
				for($i=1; $i<sizeof($productos); $i++)
					$merlav->crearOrden($values["id"],$productos[$i],$cantidades[$i]);//*** guardo las prenda asociadas a la orden
				$this->view->mensaje =  "\"Orden ".$values["id"]." abonada satisfactoriamente\"";
		}else 
				$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado".$values["monto"]."\"";        	
    }

    public function cerradasAction()
    {
	$this->view->titulo = "Ordenes Lavanderia Cerradas y/o Nulas";
		//*** Obtengo el cliente
		$form = $this->getFormId();
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$this->view->id = $values["id"];
					//***ejecuto la consulta
	   		$serlav = new Application_Model_Serlavanderia;
				$r = $serlav->Ejecuter2(2,$values["id"]);
				
				for($i=0; $i< sizeof($r); $i++)
					$r[$i][6] = "<a class='imprimir' href=../pdf/lavanderia?id=".$r[$i][0].">Descargar factura<a>";
				
			//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($r);
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; No esta el Id del cliente\""; 
    }

    public function ordenesAction()
    {
		$this->contenidoPagina("Todas Facturas Lavanderia");
		$sertin = new Application_Model_Serlavanderia;
		$r = $sertin->Ejecuter(4);
		//***devuelvo el json de la consulta

			for($i=0; $i< sizeof($r); $i++)
				$r[$i][6] = "<a class='imprimir' href=../pdf/lavanderia?id=".$r[$i][0].">Descargar factura<a>";

	    $this->view->json = Zend_Json::encode($r);

    }

    public function abonarAction()
    {
        $form = $this->getFormId();
		$this->contenidoPagina("Abonar Orden Lavanderia");
		if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
				$values = $form->getValues(); //*** obtengo los valores
				$form = $this->getFormAbonar();
				$serlav=$form->getElement('id');
				$serlav->setValue($values["id"]);
				//***ejecuto la consulta
	   			$tippre = new Application_Model_productoslavanderia;
				//***devuelvo el json de la consulta
	    		$this->view->prod = Zend_Json::encode($tippre->Ejecuter(0));
			echo $form;   
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";  
    }


}















