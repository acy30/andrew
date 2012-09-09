<?php

class Application_Form_Reporte2 extends Zend_Form
{

    public function init()
    {
        $this->setName('formulario') //***asocia monto a orden lavanderia
        ->setAction('tintoreria2')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
	$this->addElement('text','inicio', array('required' => true, 'label' => 'Inicio'));
	$this->addElement('text','fin', array('required' => true, 'label' => 'Fin'));
	$this->addElement('submit', 'guardar', array('label' => 'Enviar'));
    }


}

