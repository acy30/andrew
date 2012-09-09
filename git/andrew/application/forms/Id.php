<?php

class Application_Form_Id extends Zend_Form
{

    public function init()
    {
        $this->setName('id') //***de control
        ->setAction('')
        ->setMethod('get');
        
	$this->addElement('text','id', array('required' => true, 'label' => 'id'));
    }


}

