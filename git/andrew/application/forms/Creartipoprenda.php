<?php

class Application_Form_Creartipoprenda extends Zend_Form
{

   public function init()
    {
        $this->setName('cct') //***crear tipo prenda
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
		$this->addElement('text','nombre', array('required' => true, 'label' => '*Nombre'));          
		$this->addElement('submit', 'crear', array('label' => 'Crear Tipo Prenda'));
    }


}

