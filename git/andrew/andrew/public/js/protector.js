   var id = 0; 
   var bEjecutado = false; 
   var nMiliSegundos = 60*3000; 
   var d = "";
   function iddle(){ 
    if (bEjecutado) window.clearTimeout(id); 
    bEjecutado = true; 
    id = window.setTimeout("screenSaver()", nMiliSegundos); 
    if(d != ""){
    	d.style.display = 'none';
    	d = "";
    }
    	
   } 
 
   function screenSaver(){ 
   	if(Math.floor(Math.random()*2+1) == 1)
			d = document.getElementById('animacion')
		else
			d = document.getElementById('snow')
			d.style.display = 'block'
   } 
