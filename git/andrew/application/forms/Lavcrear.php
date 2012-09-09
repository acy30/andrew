<?php

class Application_Form_Lavcrear extends Zend_Form
{

    public function init()
    {
        $this->setName('ccl') //***crear cliente lavanderia
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
		$this->addElement('text','nombre', array('required' => true, 'label' => '*Nombre'));
		$this->addElement('text','apellido', array('required' => true, 'label' => '*Apellido'));        
		$this->addElement('text','email', array('required' => false, 'label' => 'Email')); 
		$this->addElement('text','cedula', array('required' => true, 'label' => '*Cedula')); 
		$this->addElement('text','telefono', array('required' => true, 'label' => '*Telefono'));         
		$this->addElement('submit', 'crear', array('label' => 'Crear Cliente'));
    }


}

