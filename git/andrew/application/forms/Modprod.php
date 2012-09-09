<?php

class Application_Form_Modprod extends Zend_Form
{

   public function init()
    {
        $this->setName('cct') //***crear cliente tinroreria
        ->setAction('modificar2')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
		$this->addElement('text','nombre', array('required' => true, 'label' => '*Nombre'));
		$this->addElement('text','descripcion', array('required' => false, 'label' => 'Descripcion'));        
		$this->addElement('text','precio', array('required' => true, 'label' => '*Precio'));     
		$this->addElement('hidden','id', array('required' => true, 'label' => ''));         
		$this->addElement('submit', 'crear', array('label' => 'Modificar Producto'));
    }


}

