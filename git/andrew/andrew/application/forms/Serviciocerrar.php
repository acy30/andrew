<?php

class Application_Form_Serviciocerrar extends Zend_Form
{

    public function init()
    {
        $this->setName('monto') //***crear cliente lavanderia
        ->setAction('cerrar2')
        ->setMethod('post')
        ->setAttrib('class', 'formulario2');
        
	$this->addElement('hidden','id', array('required' => true, 'label' => ''));
	$this->addElement('submit', 'cerrar', array('label' => 'Cerrar'));
    }


}

