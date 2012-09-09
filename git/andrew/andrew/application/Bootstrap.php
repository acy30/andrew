<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    function _initViewHelpers() 
    { 
       $this->bootstrap('layout');     
       
      $layout = $this->getResource('layout'); 
       $view = $layout->getView(); 
       $view->doctype('XHTML1_STRICT'); 
       $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 
       
       $view->headTitle('Lavanderia y tintoreria Andrew'); 
      
       $view->headLink()->setStylesheet('../css/jquery.toastmessage.css');
		 $view->headLink()->setStylesheet('../css/estilo.css');       
       
    	 $view->headScript()->appendFile('../js/jquery.js');
    	 $view->headScript()->appendFile('../js/jquery.dataTables.js');
    	 $view->headScript()->appendFile('../js/jquery.toastmessage.js');
    	 $view->headScript()->appendFile('../js/mensajes.js');
		 $view->headScript()->appendFile('../js/protector.js');
    }
}

