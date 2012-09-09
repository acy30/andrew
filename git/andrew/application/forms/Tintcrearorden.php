<?php

class Application_Form_Tintcrearorden extends Zend_Form
{

    public function init()
    {
        $this->setName('guardar') //***crea una orden de tintoreria
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class','formulario2');
        
   $this->addElement('hidden','tintoreriaid', array('required' => true, 'label' => ''));
	$this->addElement('hidden','tipo_prendaid', array('required' => true, 'label' => ''));
	$this->addElement('hidden','cantidades', array('required' => true, 'label' => ''));
	$this->addElement('hidden','productos_tintoreriaid', array('required' => true, 'label' => ''));
	$this->addElement('hidden','montototal', array('required' => true, 'label' => ''));
	$this->addElement('submit', 'crear', array('label' => 'Crear Orden'));
    }


}

