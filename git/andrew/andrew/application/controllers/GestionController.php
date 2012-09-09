<?php

class GestionController extends Zend_Controller_Action
{

	/*
	*Formularios
	*/
	public function getFormCrear()
	{
		$form = new Application_Form_Crearprod;
		return $form;
	}
	public function getFormMod()
	{
		$form = new Application_Form_Modprod;
		return $form;
	}
	public function getFormId()
	{
		$form = new Application_Form_Id;
		return $form;
	}
    public function init()
    {
        /* Initialize action controller here */
    }

   	/*
	*Titulo de la pag y mensajes
	*/
	public function contenidoPagina($titulo)
	{
		$this->view->mensaje = "\"\"";
		$this->view->titulo = $titulo;
	}

    public function indexAction()
	{
			$this->view->titulo = "Crear Producto Lavanderia";
			//***ejecuto la consulta
	   		$serlav = new Application_Model_productoslavanderia;
				$r = $serlav->Ejecuter(0);
				for($i=0; $i< sizeof($r); $i++){
					$r[$i][4] = "<a class='modificar' href=modificar?id=".$r[$i][0].">Modificar<a>";
					$r[$i][5] = "<a class='eliminar'  onclick=\"return confirm('¿Esta segur@ de eliminar el producto?')\" href=eliminar?id=".$r[$i][0].">Eliminar<a>";
				}
		
			//***devuelvo el json de la consulta
	    		$this->view->json = Zend_Json::encode($r);
	}

    public function crearAction()
   	{
   		$this->contenidoPagina("Crear Nuevo Producto Lavanderia");
       	 	$form = $this->getFormCrear();
      	  	echo $form;   
   	}
	/*
	*Creo un nuevo prod
	*/
    	public function guardarAction()
    	{
    		$this->_forward('index');
    		$form = $this->getFormCrear();
        	if ($form->isValid($_POST)) { //*** Valido que todos los parametros required esten
			  $lav = new Application_Model_productoslavanderia;
			  $values = $form->getValues(); //*** obtengo los valores
			  $lav->CrearOrden($values["nombre"],$values["descripcion"],$values["precio"]);//*** guardo los registros
			  $this->view->mensaje = "\"Producto ".$values["nombre"]." creado con exito\"";
			  
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";
    	}
	/*
	*Borro un registro
	*/
    	public function eliminarAction()
    	{
    		$this->_forward('index');
    		$form = $this->getFormId();
        	if ($form->isValid($_GET)) { //*** Valido que todos los parametros required esten
			  $lav = new Application_Model_productoslavanderia;
			  $values = $form->getValues(); //*** obtengo los valores
			  $lav->deleteContact($values["id"]);//*** guardo los registros
			  $this->view->mensaje = "\"Producto eliminado con exito\"";
			  
		}else 
			$this->view->mensaje = "\"A Ocurrido un error; El formulario no tiene todos los campos llenos\"";
    	}
		/*
		*Modifica un producto existente
		*/
		public function modificarAction()
	   	{
	   		$this->contenidoPagina("Modificar Producto Lavanderia");
			$form = $this->getFormId();
			if ($form->isValid($_GET)) { //*** me llego el id del cliente
				$values = $form->getValues(); //*** obtengo los valores
				$pro = new Application_Model_productoslavanderia;
				$r = $pro->Ejecuter2(2,$values["id"]);
				 		   	
				$form = $this->getFormMod();
				$pro=$form->getElement('id');
				$pro->setValue($r[0][0]);
				$pro=$form->getElement('nombre');
				$pro->setValue($r[0][1]);
				$pro=$form->getElement('descripcion');
				$pro->setValue($r[0][2]);
				$pro=$form->getElement('precio');
				$pro->setValue($r[0][3]);
		  		echo $form; 
			}else 
				$this->view->mensaje =  "\"A Ocurrido un error; producto no encontrado\""; 
		}
  
		public function modificar2Action()
	   	{
	   		$this->_forward('index');
			$form = $this->getFormMod();
			if ($form->isValid($_POST)) { //*** me llego el id del cliente
				$values = $form->getValues(); //*** obtengo los valores
				$pro = new Application_Model_productoslavanderia;
				$values = $form->getValues(); //*** obtengo los valores
				$orden = $pro->ModificarOrden($values["id"],$values["nombre"],$values["descripcion"],$values["precio"]);//*** guardo los registros  
				$this->view->mensaje =  "\"Producto ".$values["nombre"]." modificado satisfactoriamente\""; 
			}else 
				$this->view->mensaje =  "\"A Ocurrido un error; producto no encontrado\""; 
	   	}

}

