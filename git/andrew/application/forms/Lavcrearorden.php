<?php

class Application_Form_Lavcrearorden extends Zend_Form
{

    public function init()
    {
        $this->setName('guardar') //***Crea una orden de lav
        ->setAction('guardar')
        ->setMethod('post')
        ->setAttrib('class','formulario2');
        
   	$this->addElement('hidden','lavanderiaid', array('required' => true, 'label' => ''));
	$this->addElement('submit', 'crear', array('label' => 'Crear Orden'));
    }


}

