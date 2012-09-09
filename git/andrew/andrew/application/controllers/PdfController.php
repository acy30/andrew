<?php

class PdfController extends Zend_Controller_Action
{
	/*
	*Formularios
	*/
	public function getFormPdf()
	{
		$form = new Application_Form_Id;
		return $form;
	}

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function lavanderiaAction()
    {
        $form = $this->getFormPdf();
		if ($form->isValid($_GET)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
		}else{
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
			return 0 ;
		}

		//***ejecuto la consulta
	   	$tippre = new Application_Model_productoslavanderia;
		//***me da la los productos asociados al cliente
	    $prod = $tippre->Ejecuter2(1,$values["id"]);

		//***ejecuto la consulta
	   	$sertin = new Application_Model_Serlavanderia;
		//***me la info de la orden del cliente
	    $orden = $sertin->Ejecuter2(3,$values["id"]);

		//***ejecuto la consulta
	   	$tin = new Application_Model_Lavanderia;
		//***me al cliente
		if($orden[0][1] != null)
	    $clic = $tin->Ejecuter2(1,$orden[0][1]);

		//*** Create new PDF 
		$pdf = new Zend_Pdf(); 

		//*** Add new page to the document 
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
		$pdf->pages[] = $page; 

		//*** Creo la pagina en blanco
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12); 
		
		//*** Medidas
		$width  = $page->getWidth();        
    	$height = $page->getHeight(); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setLineColor(new Zend_Pdf_Color_Html('#0099BB'));

		//*** circulo nulo amarillo
		$page->setLineDashingPattern(Zend_Pdf_Page::LINE_DASHING_SOLID)->setFillColor(new Zend_Pdf_Color_Html('#FFFF00'))->drawCircle(250, $height-70, 3);

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB')); 
		//*** logo
		$image = Zend_Pdf_Image::imageWithPath('../public/img/logopdf.png');
		$page->drawImage($image, 10, $height-70, 160, $height-12);

		//*** borde1
		$image = Zend_Pdf_Image::imageWithPath('../public/img/bordepdf1.png');
		$page->drawImage($image, 3, $height-70, 50, $height-2);

		//*** lav trans
		$image = Zend_Pdf_Image::imageWithPath('../public/img/lavpdftrans.png');
		$page->drawImage($image, 75, $height-185, 165, $height-303);

		// dibujar texto factura 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		$page->drawText('FACTURA ', 160, $height-30); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		if($cont != 0)
			$page->drawText('N° '.$values["id"], 250, $height-30);		

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6); 

		$page->drawText('CALLE PASCUAL NAVARRO N°6', 15, $height-85); 
		$page->drawText('URB EL RECREO SABANA GRANDE:', 15, $height-93); 
		$page->drawText('TELF: 762.88.07 - CARACAS D.C.', 15, $height-101); 
		$page->drawText('RIF: J-29607493-3', 30, $height-109); 


		//*** dibujar rectangulo cliente
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		
		$page->drawText('Fecha:', 135, $height-100); 
		$page->drawText(substr($orden[0][2],0,10), 180, $height-100);
		$page->drawRectangle(10, $height-120, 300, $height-170,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		$page->drawText('Cliente:', 13, $height-130); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText('  Nombre:', 16, $height-144); 
		$page->drawText($clic[0][1].' '.$clic[0][2],63, $height-144); 
		$page->drawText('  Teléfono:', 16, $height-164); 
		$page->drawText($clic[0][4],65, $height-164);

		//***orden externa
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText($ordenexterna[0][0], 240, $height-132);

		//***dibujar rectangulo campos factura
		$page->drawRectangle(10, $height-180, 300, $height-190,$fillType = Zend_Pdf_Page::SHAPE_DRAW_FILL);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawText('Codigo',10, $height-188); 
		$page->drawText('Descripción',50, $height-188); 
		$page->drawText('Cant.',180, $height-188); 
		$page->drawText('C/U',220, $height-188); 
		$page->drawText('Total',250, $height-188);

		$n = 200;
		$cont = 0;
		$page->setFillColor(new Zend_Pdf_Color_Html('#000000'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
		for($i=0; $i<sizeof($prod); $i++){
					$page->drawText($prod[$i][1],10, $height-$n); 
					$page->drawText($prod[$i][2],50, $height-$n); 
					$page->drawText($prod[$i][4],180, $height-$n); 
					$page->drawText($prod[$i][3].',00',215, $height-$n);
					$page->drawText($prod[$i][3]*$prod[$i][4].',00',250, $height-$n);
					$n +=12;
					$cont += $prod[$i][3]*$prod[$i][4];
		}

		//***linea total
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawLine(245, $height-188,245, $height-323);

		//*** cuadro inferior
		$page->drawRectangle(5, $height-293, 300, $height-323,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		//*** cuadro observaciones
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->drawRectangle(5, $height-293,131, $height-303,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->drawText('OBSERVACIONES',13, $height-300); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		$page->drawText('No da derecho a reclamo a mercancía(s)',7, $height-312); 
		$page->drawText('dejada después de 30 días',7, $height-319); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
		$page->drawText('Sub-total Bsf:',132, $height-303);
		if($cont !=0)
			$page->drawText($cont.',00',250, $height-303); 
		$page->drawText('Total Factura Bsf:',132, $height-319); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000'));
		if($cont !=0)
			$page->drawText($cont.',00',250, $height-319);
		//*** linea de observaciones
		$page->drawLine(131, $height-293,131, $height-323);

		//*** fac que se lleva el cliente
		$page->drawRectangle(5, $height-330, 300, $height-380,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);
		$page->drawText('Cliente:', 7, $height-340); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText('  Nombre:', 7, $height-360); 
		$page->drawText($clic[0][1].' '.$clic[0][2],63, $height-360); 
		$page->drawText('  Teléfono:', 7, $height-370); 
		$page->drawText($clic[0][4],65, $height-370);
		$page->drawText('FACTURA ', 150, $height-360); 
		if($values["id"] != 0)
		$page->drawText('N° '.$values["id"], 200, $height-360);	
		$page->drawText('Fecha:', 150, $height-370); 
		$page->drawText(substr($orden[0][2],0,10), 180, $height-370);

		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		$page->drawText('No da derecho a reclamo a mercancía(s) dejada después de 30 días',7, $height-390); 

		//*** borde2
		$image = Zend_Pdf_Image::imageWithPath('../public/img/bordepdf2.png');
		$page->drawImage($image, 260, $height-390, 307, $height-322);

  		$this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
    	$this->getResponse()->setHeader('Content-disposition', 'inline; filename='.$values["id"].'.pdf', true);
    	$this->getResponse()->setBody($pdf->render());
    }

    public function tintexternaAction()
    {
        $form = $this->getFormPdf();
		if ($form->isValid($_GET)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
		}else{
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
			return 0 ;
		}

		//***ejecuto la consulta
	   	$tippre = new Application_Model_productostintoreria;
		//***me da la los productos asociados al cliente
	    $prod = $tippre->Ejecuter2(1,$values["id"]);

		//***ejecuto la consulta
	   	$sertin = new Application_Model_Sertintoreria;
		//***me la info de la orden del cliente
	    $orden = $sertin->Ejecuter2(3,$values["id"]);

		//***ejecuto la consulta
	   	$tin = new Application_Model_Tintoreria;
		//***me al cliente
		if($orden[0][1] != null)
	    $clic = $tin->Ejecuter2(1,$orden[0][1]);

		//***ejecuto la consulta
	   	$tinext = new Application_Model_Tintoreriaexterna;
		//***me al cliente
	    $ordenexterna = $tinext->Ejecuter2(2,$values["id"]);

		//*** Create new PDF 
		$pdf = new Zend_Pdf(); 

		//*** Add new page to the document 
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
		$pdf->pages[] = $page; 

		//*** Creo la pagina en blanco
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12); 
		
		//*** Medidas
		$width  = $page->getWidth();        
    	$height = $page->getHeight(); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setLineColor(new Zend_Pdf_Color_Html('#0099BB'));
	
		//*** circulo nulo amarillo
		$page->setLineDashingPattern(Zend_Pdf_Page::LINE_DASHING_SOLID)->setFillColor(new Zend_Pdf_Color_Html('#FFFF00'))->drawCircle(250, $height-70, 3);

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB')); 
		//*** logo
		$image = Zend_Pdf_Image::imageWithPath('../public/img/logopdf.png');
		$page->drawImage($image, 10, $height-70, 160, $height-12);

		//*** borde1
		$image = Zend_Pdf_Image::imageWithPath('../public/img/bordepdf1.png');
		$page->drawImage($image, 3, $height-70, 50, $height-2);

		//*** lav trans
		$image = Zend_Pdf_Image::imageWithPath('../public/img/lavpdftrans.png');
		$page->drawImage($image, 75, $height-185, 200, $height-350);

		// dibujar texto factura 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		$page->drawText('FACTURA ', 150, $height-30); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		if($values["id"] !=0)
			$page->drawText('N° '.$values["id"], 250, $height-30);		

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6); 

		$page->drawText('CALLE PASCUAL NAVARRO N°6', 15, $height-85); 
		$page->drawText('URB EL RECREO SABANA GRANDE:', 15, $height-93); 
		$page->drawText('TELF: 762.88.07 - CARACAS D.C.', 15, $height-101); 
		$page->drawText('RIF: J-29607493-3', 30, $height-109); 


		//*** dibujar rectangulo cliente
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		
		$page->drawText('Fecha:', 135, $height-100); 
		$page->drawText(substr($orden[0][2],0,10), 180, $height-100);
		$page->drawRectangle(10, $height-120, 300, $height-170,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		$page->drawText('Cliente:', 13, $height-130); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText('  Nombre:', 16, $height-144); 
		$page->drawText($clic[0][1].' '.$clic[0][2],63, $height-144); 
		$page->drawText('  Teléfono:', 16, $height-164); 
		$page->drawText($clic[0][4],65, $height-164);

		//***orden externa
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText($ordenexterna[0][0], 240, $height-132);

		//***dibujar rectangulo campos factura
		$page->drawRectangle(10, $height-180, 300, $height-190,$fillType = Zend_Pdf_Page::SHAPE_DRAW_FILL);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawText('Codigo',10, $height-188); 
		$page->drawText('Descripción',50, $height-188); 
		$page->drawText('Cant.',180, $height-188); 
		$page->drawText('C/U',220, $height-188); 
		$page->drawText('Total',250, $height-188);

		$n = 200;
		$cont = 0;
		$page->setFillColor(new Zend_Pdf_Color_Html('#000000'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
		for($i=0; $i<sizeof($prod); $i++){
					$page->drawText($prod[$i][1],10, $height-$n); 
					$page->drawText($prod[$i][2].' '.$prod[$i][0],50, $height-$n); 
					$page->drawText($prod[$i][4],180, $height-$n); 
					$page->drawText($prod[$i][3].',00',215, $height-$n);
					$page->drawText($prod[$i][3]*$prod[$i][4].',00',250, $height-$n);
					$n +=12;
					$cont += $prod[$i][3]*$prod[$i][4];
		}

		//***linea total
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawLine(245, $height-188,245, $height-380);

		//*** cuadro inferior
		$page->drawRectangle(10, $height-350, 300, $height-380,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		//*** cuadro observaciones
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
		$page->drawText('Sub-total Bsf:',153, $height-365);
		if($cont !=0)
			$page->drawText($cont.',00',250, $height-365); 
		$page->drawText('Total Factura Bsf:',132, $height-378); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000'));
		if($cont !=0)
			$page->drawText($cont.',00',250, $height-378);
		//*** linea de observaciones
		$page->drawLine(131, $height-350,131, $height-380);

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->drawRectangle(10, $height-350,131, $height-360,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->drawText('OBSERVACIONES',13, $height-357); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		$page->drawText('No da derecho a reclamo a mercancía(s)',11, $height-367); 
		$page->drawText('dejada después de 30 días',11, $height-377); 

		//*** borde2
		$image = Zend_Pdf_Image::imageWithPath('../public/img/bordepdf2.png');
		$page->drawImage($image, 255, $height-390, 302, $height-322);

  		$this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
    	$this->getResponse()->setHeader('Content-disposition', 'inline; filename='.$values["id"].'.pdf', true);
    	$this->getResponse()->setBody($pdf->render());
    }


    public function tintandrewAction()
    {
        $form = $this->getFormPdf();
		if ($form->isValid($_GET)) { //*** me llego el id del cliente
			$values = $form->getValues(); //*** obtengo los valores
		}else{
			$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\""; 
			return 0 ;
		}

		//***ejecuto la consulta
	   	$tippre = new Application_Model_productostintoreria;
		//***me da la los productos asociados al cliente
	    $prod = $tippre->Ejecuter2(1,$values["id"]);

		//***ejecuto la consulta
	   	$sertin = new Application_Model_Sertintoreria;
		//***me la info de la orden del cliente
	    $orden = $sertin->Ejecuter2(3,$values["id"]);

		//***ejecuto la consulta
	   	$tin = new Application_Model_Tintoreria;
		//***me al cliente
	    $clic = $tin->Ejecuter2(1,$orden[0][1]);

		//***ejecuto la consulta
	   	$tinext = new Application_Model_Tintoreriaexterna;
		//***me al cliente
	    $ordenexterna = $tinext->Ejecuter2(2,$values["id"]);

		//*** Create new PDF 
		$pdf = new Zend_Pdf(); 

		//*** Add new page to the document 
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4); 
		$pdf->pages[] = $page; 

		//*** Creo la pagina en blanco
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12); 
		
		//*** Medidas
		$width  = $page->getWidth();        
    	$height = $page->getHeight(); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setLineColor(new Zend_Pdf_Color_Html('#0099BB'));
	
		//*** logo
		$image = Zend_Pdf_Image::imageWithPath('../public/img/logopdf.png');
		$page->drawImage($image, 50, $height-70, 150, $height-2);

		// dibujar texto factura 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		$page->drawText('FACTURA ', 180, $height-30); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		$page->drawText('N° '.$values["id"], 250, $height-30);		

		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6); 

		$page->drawText('CALLE PASCUAL NAVARRO N°6', 60, $height-85); 
		$page->drawText('URB EL RECREO SABANA GRANDE:', 60, $height-93); 
		$page->drawText('TELF: 762.88.07 - CARACAS D.C.', 60, $height-101); 
		$page->drawText('RIF: J-29607493-3', 60, $height-109); 


		//*** dibujar rectangulo cliente
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 11);
		
		$page->drawText('Fecha:', $width-160, $height-100); 
		$page->drawText(substr($orden[0][2],0,10), $width-120, $height-100);
		$page->drawRectangle(50, $height-120, $width-50, $height-170,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		$page->drawText('Cliente:', 53, $height-130); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText('  Nombre:', 53, $height-144); 
		$page->drawText($clic[0][1].' '.$clic[0][2],100, $height-144); 
		$page->drawText('  Teléfono:', 53, $height-164); 
		$page->drawText($clic[0][4],102, $height-164);
		
		//***orden externa
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10); 
		$page->drawText($ordenexterna[0][0], $width-80, $height-132);

		//***dibujar rectangulo campos factura
		$page->drawRectangle(50, $height-180, $width-50, $height-190,$fillType = Zend_Pdf_Page::SHAPE_DRAW_FILL);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawText('Codigo',58, $height-188); 
		$page->drawText('Descripción',250, $height-188); 
		$page->drawText('Cant.',400, $height-188); 
		$page->drawText('C/U',460, $height-188); 
		$page->drawText('Total',510, $height-188);

		$n = 210;
		$cont = 0;
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
		for($i=0; $i<sizeof($prod); $i++){
					$page->drawText($prod[$i][1],58, $height-$n); 
					$page->drawText($prod[$i][2],180, $height-$n); 
					$page->drawText($prod[$i][0],290, $height-$n); 
					$page->drawText($prod[$i][4],400, $height-$n); 
					$page->drawText($prod[$i][3],460, $height-$n);
					$page->drawText($prod[$i][3]*$prod[$i][4],510, $height-$n);
					$n +=12;
					$cont += $prod[$i][3]*$prod[$i][4];
		}

		//***linea total
		$page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));
		$page->drawLine($width-150, $height-190,$width-150, $height-370);

		//*** cuadro inferior
		$page->drawRectangle(50, $height-340, $width-50, $height-370,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);

		//*** cuadro observaciones
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->drawRectangle(50, $height-340,220, $height-350,$fillType = Zend_Pdf_Page::SHAPE_DRAW_STROKE);
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8); 
		$page->drawText('OBSERVACIONES',58, $height-347); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 7); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000')); 
		$page->drawText('No da derecho a reclamo a mercancía(s) dejada',58, $height-359); 
		$page->drawText('después de 30 días',58, $height-366); 
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
		$page->setFillColor(new Zend_Pdf_Color_Html('#0099BB'));
		$page->drawText('Sub-total Bsf:',$width-270, $height-350);
		if($cont != 0)
			$page->drawText($cont,510, $height-350); 
		$page->drawText('Total Factura Bsf:',$width-270, $height-366); 
		$page->setFillColor(new Zend_Pdf_Color_Html('#FF0000'));
		if($cont != 0)
			$page->drawText($cont,510, $height-366);
		//*** linea de observaciones
		$page->drawLine(220, $height-340,220, $height-370);

  		$this->getResponse()->setHeader('Content-type', 'application/x-pdf', true);
    	$this->getResponse()->setHeader('Content-disposition', 'inline; filename='.$values["id"].'.pdf', true);
    	$this->getResponse()->setBody($pdf->render());
    }
}








