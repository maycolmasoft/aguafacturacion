<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Facturar</title>


        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="view/css/estilos.css">
		<link rel="stylesheet" href="view/vendors/table-sorter/themes/blue/style.css">
	
		    <!-- Bootstrap -->
    		<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    		<!-- Font Awesome -->
		    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    <!-- NProgress -->
		    <link href="view/vendors/nprogress/nprogress.css" rel="stylesheet">
		    
		   
		    <!-- Custom Theme Style -->
		    <link href="view/build/css/custom.min.css" rel="stylesheet">
				
			
			<!-- Datatables -->
		    <link href="view/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		    
		   		

			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script type="text/javascript" src="view/vendors/table-sorter/jquery.tablesorter.js"></script> 
       		 <script src="view/js/jquery.blockUI.js"></script>
            <script src="view/js/jquery.inputmask.bundle.js"></script>
            
            <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
		
			<script>
			    //webshims.activeLang("en");
			    webshims.setOptions('forms-ext', { datepicker: { dateFormat: 'yy/mm/dd' } });
				webshims.polyfill('forms forms-ext');
			</script>
           
           
       		<script src="view/input-mask/jquery.inputmask.js"></script>
			<script src="view/input-mask/jquery.inputmask.date.extensions.js"></script>
			<script src="view/input-mask/jquery.inputmask.extensions.js"></script>
			
			
			
			     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>  
                 <script src="view/js/jquery.js"></script>
		         <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        
        <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   pone_espera();
        		  
	   			});

        	   function pone_espera(){
        		   $.blockUI({ 
        				message: '<h4><img src="view/images/load.gif" /> Espere por favor, estamos procesando su requerimiento...</h4>',
        				css: { 
        		            border: 'none', 
        		            padding: '15px', 
        		            backgroundColor: '#000', 
        		            '-webkit-border-radius': '10px', 
        		            '-moz-border-radius': '10px', 
        		            opacity: .5, 
        		            color: '#fff',
        		           
        	        		}
        	    });
            	
		        setTimeout($.unblockUI, 300); 
		        
        	   }


        	   
       		   
        </script>
        
        
        
        
                
        

       
        
			        
    </head>
    
    
    <body class="nav-md">
    
      <?php
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
      ?>
    
    
       
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col  menu_fixed">
          <div class="left_col scroll-view">
            <?php include("view/modulos/logo.php"); ?>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php include("view/modulos/menu_profile.php"); ?>
            <!-- /menu profile quick info -->

            <br />
			<?php include("view/modulos/menu.php"); ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
		<?php include("view/modulos/head.php"); ?>	
        <!-- /top navigation -->

        <!-- page content -->
		<div class="right_col" role="main">        
          
    <div class="container">
        <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Facturar</li>
         </ol>
         </section>
       
       
       
    <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                 
                 
       
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>DATOS<small>del Cliente</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">



                   
                           <div class="row">
                           
                           
                           
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_persona" class="control-label">Tipo Persona:</label>
                                                          <select name="id_tipo_persona" id="id_tipo_persona"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTip_Per as $res) {?>
                        										<option value="<?php echo $res->id_tipo_persona; ?>" <?php if ($res->id_tipo_persona == $resEdit->id_tipo_persona )  echo  ' selected="selected" '  ;  ?>><?php echo $res->nombre_tipo_persona; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_persona" class="errores"></div>
                                    </div>
                                    </div>
                                    
                           
             					   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_identificacion" class="control-label">Tipo Identificación:</label>
                                                          <select name="id_tipo_identificacion" id="id_tipo_identificacion"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTipIdenti as $res) {?>
                        										<option value="<?php echo $res->id_tipo_identificacion; ?>" <?php if ($res->id_tipo_identificacion == $resEdit->id_tipo_identificacion )  echo  ' selected="selected" '  ;  ?>><?php echo $res->nombre_tipo_identificacion; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_identificacion" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="identificacion_clientes" class="control-label">Identificación:</label>
                                                      <input type="hidden" class="form-control" id="id_solicitudes" name="id_solicitudes" value="<?php echo $resEdit->id_solicitudes; ?>" >
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="<?php echo $resEdit->id_clientes; ?>" >
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value="<?php echo $resEdit->identificacion_clientes; ?>"  placeholder="identificación.." readonly>
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                  
                                    
                                   <div class="col-lg-4 col-xs-12 col-md-4">
                        		   <div class="form-group">
                                                      <label for="razon_social_clientes" class="control-label">Razón Social:</label>
                                                      <input type="text" class="form-control" id="razon_social_clientes" name="razon_social_clientes" value="<?php echo $resEdit->razon_social_clientes; ?>"  placeholder="razón social.." readonly>
                                                      <div id="mensaje_razon_social_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                 
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="numero_factura" class="control-label">Número Factura:</label>
                                                      <input type="text" class="form-control" id="numero_factura" name="numero_factura" value="<?php echo $numero_consecutivo; ?>"  placeholder="número factura.." readonly>
                                                      <div id="mensaje_numero_factura" class="errores"></div>
                                    </div>
                                    </div>
                                   
                               
                                    
                                     
                                    
            </div>        		   
                    	      
                    			
            
            
                                
                    	   
                 
                  </div>
                </div>
              </div>
		
  	 <?php } if (!empty($result_tar)){?>
                    	 
                    	 
                   
                   
                   
         <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Detalle<small>Servicios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					 <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Descripción</th>
                          <th>Cantidad</th>
                          <th>Valor C/U</th>
                          <th>Valor Total</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php $i=0; $valor_total_db=0; $valor_total_vista=0;?>
    						<?php if (!empty($result_tar)) {  foreach($result_tar as $res) {?>
    						<?php $i++; $valor_total=$res->valor_tarifa; $valor_total_vista=$valor_total_vista+$valor_total;?>
            	        		<tr>
            	                   <td > <?php echo $res->nombre_tarifa; ?>     </td> 
            		               <td >1</td> 
            		               <td > <?php echo $res->valor_tarifa; ?>     </td> 
            		               <td > <?php echo $res->valor_tarifa; ?>     </td> 
            		              
            		    		</tr>
            		    		
            		    		<?php $valor_total_db=0;?>
            		    		
            		        <?php } } ?>
                    
                
                <tr>
				<td class='text-right' colspan=3>SubTotal</td>
				<td class='text-left'>
		             <?php echo number_format($valor_total_vista, 2, '.', ',');?>          
				</td>
				</tr>
                
                 <?php $valor_iva=0; $valor_iva=$valor_total_vista*0.12?>
                <tr>
				<td class='text-right' colspan=3>Iva 12%</td>
				<td class='text-left'>
				     <?php echo number_format($valor_iva, 2, '.', ',');?>          
				</td>
				</tr>
                    
                   <?php $valor_FIN=0; $valor_FIN=$valor_total_vista+$valor_iva?> 
                    
                <tr>
				
				<td class='text-right' colspan=1>TOTAL $</td>
				<td colspan=2>
		        <input type="text" class="form-control" id="valor_letras" name="valor_letras" value="<?php echo $valor_FIN ? numtoletras ($valor_FIN) : ''; ?>" readonly>
                                
				</td>
				
				<td class='text-left'>
				<?php echo number_format($valor_FIN, 2, '.', ',');?>
				
				</td>
				
			    </tr>
                    
                    
                    </tbody>
                    </table>
				
					
					           	
                    	        <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <a href="index.php?controller=Facturar&action=InsertaFacturas&id_clientes=<?php echo $resEdit->id_clientes;?>&id_solicitudes=<?php echo $resEdit->id_solicitudes;?>" class="btn btn-success" ><i class="glyphicon glyphicon-floppy-saved"> Facturar</i></a>
				  		                              <a href="index.php?controller=Facturar&action=index" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>
				  		
                                </div>
                    		    </div>
                    		    </div>
                    	           	
                    
                  
                  </div>
                </div>
              </div>
		
		
                    	 
                    	 
                    	 
                    	           	
                     <?php }} ?>
                    		     
      
      </div>
    </div>

</div>
    
    
    
  
 
     <!-- Bootstrap -->
    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    
    
    <!-- NProgress -->
    <script src="view/vendors/nprogress/nprogress.js"></script>
   
   
    <!-- Datatables -->
    <script src="view/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    
    
    <script src="view/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    
    
    
    <!-- Custom Theme Scripts -->
    <script src="view/build/js/custom.min.js"></script>
	<script src="view/js/jquery.inputmask.bundle.js"></script>
	<!-- codigo de las funciones -->




    <?php 
    function numtoletras($xcifra)
    {
    	$xarray = array(0 => "Cero",
    			1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
    			"DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
    			"VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
    			100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    	);
    	//
    	$xcifra = trim($xcifra);
    	$xlength = strlen($xcifra);
    	$xpos_punto = strpos($xcifra, ".");
    	$xaux_int = $xcifra;
    	$xdecimales = "00";
    	if (!($xpos_punto === false)) {
    		if ($xpos_punto == 0) {
    			$xcifra = "0" . $xcifra;
    			$xpos_punto = strpos($xcifra, ".");
    		}
    		$xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
    		$xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    	}
    
    	$XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    	$xcadena = "";
    	for ($xz = 0; $xz < 3; $xz++) {
    		$xaux = substr($XAUX, $xz * 6, 6);
    		$xi = 0;
    		$xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
    		$xexit = true; // bandera para controlar el ciclo del While
    		while ($xexit) {
    			if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
    				break; // termina el ciclo
    			}
    
    			$x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
    			$xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
    			for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
    				switch ($xy) {
    					case 1: // checa las centenas
    						if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
    
    						} else {
    							$key = (int) substr($xaux, 0, 3);
    							if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
    								$xseek = $xarray[$key];
    								$xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
    								if (substr($xaux, 0, 3) == 100)
    									$xcadena = " " . $xcadena . " CIEN " . $xsub;
    									else
    										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
    										$xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
    							}
    							else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
    								$key = (int) substr($xaux, 0, 1) * 100;
    								$xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
    								$xcadena = " " . $xcadena . " " . $xseek;
    							} // ENDIF ($xseek)
    						} // ENDIF (substr($xaux, 0, 3) < 100)
    						break;
    					case 2: // checa las decenas (con la misma lógica que las centenas)
    						if (substr($xaux, 1, 2) < 10) {
    
    						} else {
    							$key = (int) substr($xaux, 1, 2);
    							if (TRUE === array_key_exists($key, $xarray)) {
    								$xseek = $xarray[$key];
    								$xsub = subfijo($xaux);
    								if (substr($xaux, 1, 2) == 20)
    									$xcadena = " " . $xcadena . " VEINTE " . $xsub;
    									else
    										$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
    										$xy = 3;
    							}
    							else {
    								$key = (int) substr($xaux, 1, 1) * 10;
    								$xseek = $xarray[$key];
    								if (20 == substr($xaux, 1, 1) * 10)
    									$xcadena = " " . $xcadena . " " . $xseek;
    									else
    										$xcadena = " " . $xcadena . " " . $xseek . " Y ";
    							} // ENDIF ($xseek)
    						} // ENDIF (substr($xaux, 1, 2) < 10)
    						break;
    					case 3: // checa las unidades
    						if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
    
    						} else {
    							$key = (int) substr($xaux, 2, 1);
    							$xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
    							$xsub = subfijo($xaux);
    							$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
    						} // ENDIF (substr($xaux, 2, 1) < 1)
    						break;
    				} // END SWITCH
    			} // END FOR
    			$xi = $xi + 3;
    		} // ENDDO
    
    		if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
    			$xcadena.= " DE";
    
    			if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
    				$xcadena.= " DE";
    
    				// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
    				if (trim($xaux) != "") {
    					switch ($xz) {
    						case 0:
    							if (trim(substr($XAUX, $xz * 6, 6)) == "1")
    								$xcadena.= "UN BILLON ";
    								else
    									$xcadena.= " BILLONES ";
    									break;
    						case 1:
    							if (trim(substr($XAUX, $xz * 6, 6)) == "1")
    								$xcadena.= "UN MILLON ";
    								else
    									$xcadena.= " MILLONES ";
    									break;
    						case 2:
    							if ($xcifra < 1) {
    								$xcadena = "CERO DOLARES $xdecimales/100********";
    							}
    							if ($xcifra >= 1 && $xcifra < 2) {
    								$xcadena = "UN DOLAR $xdecimales/100********";
    							}
    							if ($xcifra >= 2) {
    								$xcadena.= " DOLARES $xdecimales/100*******"; //
    							}
    							break;
    					} // endswitch ($xz)
    				} // ENDIF (trim($xaux) != "")
    				// ------------------      en este caso, para México se usa esta leyenda     ----------------
    				$xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
    				$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
    				$xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
    				$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
    				$xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
    				$xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
    				$xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    	} // ENDFOR ($xz)
    	return trim($xcadena);
    }
    
    // END FUNCTION
    
    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
    	$xsub = "";
    	//
    	if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
    		$xsub = "MIL";
    		//
    		return $xsub;
    }
    ?>






	
  </body>
</html>   