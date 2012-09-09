<?php

class Application_Form_Modtipoprenda extends Zend_Form
{

   public function init()
    {
        $this->setName('cct') //***crear tipo prenda
        ->setAction('modificar2')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
		$this->addElement('text','nombre', array('required' => true, 'label' => '*Nombre'));        
		$this->addElement('hidden','id', array('required' => true, 'label' => ''));     
		$this->addElement('submit', 'crear', array('label' => 'Modificar Tipo Prenda'));
    }


}

