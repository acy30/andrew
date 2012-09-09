<?php

class Application_Form_Monto extends Zend_Form
{

    public function init()
    {
        $this->setName('monto') //***asocia monto a orden lavanderia
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
	$this->addElement('text','monto', array('required' => false, 'label' => 'monto'));
	$this->addElement('hidden','id', array('required' => true, 'label' => ''));
	$this->addElement('submit', 'guardar', array('label' => 'Guardar'));
    }


}

