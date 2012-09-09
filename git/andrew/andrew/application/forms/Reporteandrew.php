<?php

class Application_Form_Reporteandrew extends Zend_Form
{

    public function init()
    {
        $this->setName('formulario') //***asocia monto a orden lavanderia
        ->setAction('lavanderia4')
        ->setMethod('post')
        ->setAttrib('class', 'formulario');
        
		$mes = new Zend_Form_Element_Select('mes', array(
			   "label" => "Mes",
			   "required" => true,
			));
		$mes->addMultiOptions(array(
				"01" => 1,
				"02" => 2,
				"03" => 3,
				"04" => 4,
				"05" => 5,
				"06" => 6,
				"07" => 7,
				"08" => 8,
				"09" => 9,
				"10" => 10,
				"11" => 11,
				"12" => 12,
			));
		$ano = new Zend_Form_Element_Select('ano', array(
			   "label" => "Ano",
			   "required" => true,
			));
		$ano->addMultiOptions(array(
				"2012" => 2012,
			));
		$this->addElements(array($mes));
		$this->addElements(array($ano));
	$this->addElement('submit', 'guardar', array('label' => 'Enviar'));
    }



}

