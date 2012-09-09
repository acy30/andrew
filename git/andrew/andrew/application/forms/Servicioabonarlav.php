<?php

class Application_Form_Servicioabonarlav extends Zend_Form
{

    public function init()
    {
        $this->setName('monto') //***crear cliente lavanderia
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class', 'formulario2');
        
	$this->addElement('hidden','id', array('required' => true, 'label' => ''));
	$this->addElement('hidden','cantidades', array('required' => true, 'label' => ''));
	$this->addElement('hidden','productos_lavanderiaid', array('required' => true, 'label' => ''));
	$this->addElement('hidden','montototal', array('required' => true, 'label' => ''));
	$this->addElement('submit', 'cerrar', array('label' => 'Abonar'));
    }


}

