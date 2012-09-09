<?php

class ReportesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

	/*
	*Formularios
	*/
	public function getFormCrear()
	{
		$form = new Application_Form_Reporte;
		return $form;
	}	
	public function getFormCrear2()
	{
		$form = new Application_Form_Reporte2;
		return $form;
	}
	public function getFormCrear3()
   {
		$form = new Application_Form_Reporteandrew;
		return $form;
   }
	public function getFormCrear4()
   {
		$form = new Application_Form_Reporteandrewtint;
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

    public function lavanderiaAction()
    {
   		$this->contenidoPagina("Crear Reporte Lavanderia");
       	$form = $this->getFormCrear();
      	echo $form;   
    }

    public function lavanderia2Action()
    {
        $this->contenidoPagina("Crear Reporte Lavanderia");
	   	$form = $this->getFormCrear();
		if ($form->isValid($_POST)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
			$form = $this->getFormCrear();

			//***ejecuto la consulta
	   		$tippre = new Application_Model_Serlavanderia;
			//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($tippre->Reporte($values["inicio"],$values["fin"]));
 
		}else 
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
    }
    public function tintoreriaAction()
    {
   		$this->contenidoPagina("Crear Reporte Tintoreria");
       	$form = $this->getFormCrear2();
      	echo $form;   
    }

    public function tintoreria2Action()
    {
        $this->contenidoPagina("Crear Reporte Tintoreria");
	   	$form = $this->getFormCrear();
		if ($form->isValid($_POST)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
			$form = $this->getFormCrear();

			//***ejecuto la consulta
	   		$tippre = new Application_Model_Sertintoreria;
			//***devuelvo el json de la consulta
	    	$this->view->json = Zend_Json::encode($tippre->Reporte($values["inicio"],$values["fin"]));
 
		}else 
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
    }
    
    public function lavanderia3Action()
    {
    	 $this->contenidoPagina("Crear Reporte Lavanderia");
       $form = $this->getFormCrear3();
		 echo $form; 
    }
    public function lavanderia4Action()
    {
    	$this->contenidoPagina("Crear Reporte Lavanderia");
      $form = $this->getFormCrear3();
		if ($form->isValid($_POST)){
			$rep = new Application_Model_Serlavanderia;
			$aux = $form->getValues();
			$r = $rep->Reporte2($aux["mes"],$aux["ano"]);
			$this->view->json = Zend_Json::encode($r);
		}else
			$this->view->mensaje = "\"Faltan datos en el form\"";
    }
    public function tintoreria3Action()
    {
    	 $this->contenidoPagina("Crear Reporte Tintoreria");
       $form = $this->getFormCrear4();
		 echo $form; 
    }
    public function tintoreria4Action()
    {
    	$this->contenidoPagina("Crear Reporte Tintoreria");
      $form = $this->getFormCrear4();
		if ($form->isValid($_POST)){
			$rep = new Application_Model_Sertintoreria;
			$aux = $form->getValues();
			$r = $rep->Reporte2($aux["mes"],$aux["ano"]);
			$this->view->json = Zend_Json::encode($r);
		}else
			$this->view->mensaje = "\"Faltan datos en el form\"";
    }
}





