<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Registrar Marcaciones</title>

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
        		   load_consultar_registros(1);
        		   load_bitacora_validacion(1);
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
            	
		        setTimeout($.unblockUI, 500); 
		        
        	   }


        	   
        	   function load_consultar_registros(pagina){

        		   var search=$("#search_consultar_registros").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_consultar_registros_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_consultar_registros_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=MarcacionesMensualesMedidorAgua&action=consultar_registros&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#consultar_registros_registrados").html(x);
           	               	 $("#tabla_marcaciones").tablesorter(); 
           	                 $("#load_consultar_registros_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#consultar_registros_registrados").html("Ocurrio un error al cargar la información de Marcaciones Mensuales..."+estado+"    "+error);
           	              }
           	            });

           		   }


        	   function load_bitacora_validacion(pagina){

        		   var search=$("#search_bitacora_validacion").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_bitacora_validacion").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_bitacora_validacion").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=MarcacionesMensualesMedidorAgua&action=consulta_bitacora_validacion&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#bitacora_validacion").html(x);
           	               	 $("#tabla_bitacora_validacion").tablesorter(); 
           	                 $("#load_bitacora_validacion").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#bitacora_validacion").html("Ocurrio un error al cargar la información bitacora de validación..."+estado+"    "+error);
           	              }
           	            });

           		   }

       		   
        </script>
        
        
        
        
       
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#CancelarAsig").click(function() 
			{
		    	$('#marcaciones_masivas').val("");
		    	
		    }); 
		    }); 
			</script>
		 
        
        
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#Cancelar").click(function() 
			{
		    	$('#id_medidores_agua').val("0");
		    	$('#identificador_medidores_agua').val("");
		    	$('#id_clientes').val("0");
		    	$('#marcacion_mensual_final').val("");
		    	$('#marcacion_mensual_inicial').val("");
		    	$('#identificacion_clientes').val("");
		    	$('#razon_social_clientes').val("");
		    	$('#existe_registro_fecha').val("0");
		     
		    }); 
		    }); 
			</script>
        
        
          
        <script>
        

	       	$(document).ready(function(){

	       		var id_marcaciones_mensuales_medidor_agua=$('#id_marcaciones_mensuales_medidor_agua').val();


					if (id_marcaciones_mensuales_medidor_agua>0){}else{
	       		
						$( "#identificador_medidores_agua" ).autocomplete({
		      				source: "<?php echo $helper->url("MarcacionesMensualesMedidorAgua","AutocompleteIdentificador"); ?>",
		      				minLength: 1
		    			});
		
						$("#identificador_medidores_agua").focusout(function(){
		    				$.ajax({
		    					url:'<?php echo $helper->url("MarcacionesMensualesMedidorAgua","AutocompleteDevuelveIdentificador"); ?>',
		    					type:'POST',
		    					dataType:'json',
		    					data:{identificador_medidores_agua:$('#identificador_medidores_agua').val()}

		    				}).done(function(respuesta){
		    					
		    					$('#identificador_medidores_agua').val(respuesta.identificador_medidores_agua);
		    					$('#identificacion_clientes').val(respuesta.identificacion_clientes);
		    					$('#razon_social_clientes').val(respuesta.razon_social_clientes);
		    					$('#id_medidores_agua').val(respuesta.id_medidores_agua);
		    					$('#id_clientes').val(respuesta.id_clientes);
		    					$('#marcacion_mensual_inicial').val(respuesta.marcacion_mensual_inicial);
		    					$('#fecha_pago_mensual_correspondiente_db').val(respuesta.fecha_pago_mensual_correspondiente);
			    				
		    					
		        			}).fail(function(respuesta) {

		        				
		    					$('#identificacion_clientes').val("");
		    					$('#razon_social_clientes').val("");
		    					$('#id_medidores_agua').val("0");
		    					$('#id_clientes').val("0");
		    					$('#marcacion_mensual_inicial').val("");
		    					$('#fecha_pago_mensual_correspondiente_db').val("0");
			    				
		        			  });
		    				 
		    				
		    			});  
                        
					}
		    		});
		
	     
		     </script>
		     
		     
		     
		     
		     
		     
          
		 
		     
		     
		     
		     
        <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardar").click(function() 
			{


				
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var identificador_medidores_agua = $("#id_medidores_agua").val();
		    	var id_medidores_agua = $("#id_medidores_agua").val();
		    	var id_clientes = $("#id_clientes").val();
		    	var fecha_pago_mensual_correspondiente = $("#fecha_pago_mensual_correspondiente").val();
		    	var marcacion_mensual_final = $("#marcacion_mensual_final").val();
		    	var marcacion_mensual_inicial = $("#marcacion_mensual_inicial").val();
                var fecha_pago_mensual_correspondiente_db = $("#fecha_pago_mensual_correspondiente_db").val();
		    	
		    	 var contador=0;
		    	 var tiempo = tiempo || 1000;
		    	 
		    	
		    	if (identificador_medidores_agua == "")
		    	{
			    	
		    		$("#mensaje_identificador_medidores_agua").text("Introduzca Identificador");
		    		$("#mensaje_identificador_medidores_agua").fadeIn("slow"); //Muestra mensaje de error

		    		$("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua).offset().top }, tiempo);
			        return false;
			    }
		    	else 
		    	{
		    		if(id_medidores_agua==0){
		    			$("#mensaje_identificador_medidores_agua").text("Medidor no Registrado.");
			    		$("#mensaje_identificador_medidores_agua").fadeIn("slow"); //Muestra mensaje de error
			           
			            $("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua).offset().top }, tiempo);
			            return false;
					}else{
						
						$("#mensaje_identificador_medidores_agua").fadeOut("slow"); //Muestra mensaje de error
								
					}

		    		if(id_clientes==0){
		    			$("#mensaje_identificador_medidores_agua").text("Medidor no tiene asignado un Cliente.");
			    		$("#mensaje_identificador_medidores_agua").fadeIn("slow"); //Muestra mensaje de error
			           
			            $("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua).offset().top }, tiempo);
			            return false;
					}else{
						
						$("#mensaje_identificador_medidores_agua").fadeOut("slow"); //Muestra mensaje de error
								
					}
		            
				}


               if(fecha_pago_mensual_correspondiente==""){

           	        $("#mensaje_fecha_pago_mensual_correspondiente").text("Seleccione Fecha");
		    		$("#mensaje_fecha_pago_mensual_correspondiente").fadeIn("slow"); //Muestra mensaje de error
		           
		            $("html, body").animate({ scrollTop: $(mensaje_fecha_pago_mensual_correspondiente).offset().top }, tiempo);
		            return false;

            	   
               }else{


            	   if(fecha_pago_mensual_correspondiente_db==0){

            	    $("#mensaje_fecha_pago_mensual_correspondiente").fadeOut("slow"); //Muestra mensaje de error
            	           
            		   
            		
                   }else{

						if(fecha_pago_mensual_correspondiente <= fecha_pago_mensual_correspondiente_db ){
                       
                	   $("#mensaje_fecha_pago_mensual_correspondiente").text("Ya existe un registro para el mes Seleccionado.");
      		    		$("#mensaje_fecha_pago_mensual_correspondiente").fadeIn("slow"); //Muestra mensaje de error
      		           
      		            $("html, body").animate({ scrollTop: $(mensaje_fecha_pago_mensual_correspondiente).offset().top }, tiempo);
      		            return false;

						}else{

							 $("#mensaje_fecha_pago_mensual_correspondiente").fadeOut("slow"); //Muestra mensaje de error
	            	           
			            		
						}


            	   }

            	   
               }


               if(marcacion_mensual_final==""){

          	        $("#mensaje_marcacion_mensual_final").text("Ingrese Marcación");
		    		$("#mensaje_marcacion_mensual_final").fadeIn("slow"); //Muestra mensaje de error
		           
		            $("html, body").animate({ scrollTop: $(mensaje_marcacion_mensual_final).offset().top }, tiempo);
		            return false;

           	   
              }else{


              	   if (marcacion_mensual_final.length==5 ) {
              			$("#mensaje_marcacion_mensual_final").fadeOut("slow"); //Muestra mensaje de error
       			    	
   		    			
   		    		}else{
   		    			$("#mensaje_marcacion_mensual_final").text("Deben ser 5 Dígitos");
   			    		$("#mensaje_marcacion_mensual_final").fadeIn("slow"); //Muestra mensaje de error
   			            $("html, body").animate({ scrollTop: $(mensaje_marcacion_mensual_final).offset().top }, tiempo);
   			            return false;
   		    		}
              	   


            	  
           	   if (marcacion_mensual_final <  marcacion_mensual_inicial ) {
  			    	
		    			$("#mensaje_marcacion_mensual_final").text("Marcación no puede ser menor a la inicial");
			    		$("#mensaje_marcacion_mensual_final").fadeIn("slow"); //Muestra mensaje de error
			            $("html, body").animate({ scrollTop: $(mensaje_marcacion_mensual_final).offset().top }, tiempo);
			            return false;
		    		}else{
		    			$("#mensaje_marcacion_mensual_final").fadeOut("slow"); //Muestra mensaje de error
			    	}
           	   
              }
				


			 				    

			}); 


		        $( "#identificador_medidores_agua" ).focus(function() {
				  $("#mensaje_identificador_medidores_agua").fadeOut("slow");
			    });
		        $( "#fecha_pago_mensual_correspondiente" ).focus(function() {
					  $("#mensaje_fecha_pago_mensual_correspondiente").fadeOut("slow");
				    });
		        $( "#marcacion_mensual_final" ).focus(function() {
					  $("#mensaje_marcacion_mensual_final").fadeOut("slow");
				    });
				
		      
				    
		}); 

	</script>
        
        
        
        
        <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#GuardarAsig").click(function() 
			{


				
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var marcaciones_masivas = $("#marcaciones_masivas").val();

		    	 extensiones_permitidas = new Array(".txt"); 
		    	 mierror = ""; 
		    	  	
		    	var contador=0;
		    	 var tiempo = tiempo || 1000;
		    	 
		    	
		    	if (marcaciones_masivas == "")
		    	{
			    	
		    		$("#mensaje_marcaciones_masivas").text("Seleccione Archivo");
		    		$("#mensaje_marcaciones_masivas").fadeIn("slow"); //Muestra mensaje de error

		    		$("html, body").animate({ scrollTop: $(mensaje_marcaciones_masivas).offset().top }, tiempo);
			        return false;
			    }
		    	else 
		    	{


		    		if(marcaciones_masivas != ""){ 
		  		      extension = (marcaciones_masivas.substring(marcaciones_masivas.lastIndexOf("."))).toLowerCase(); 
		  		      permitida = false; 
		  		      for (var i = 0; i < extensiones_permitidas.length; i++) { 
		  		         if (extensiones_permitidas[i] == extension) { 
		  		         permitida = true; 
		  		         break; 
		  		         } 
		  		      } 
		  		      if (!permitida) { 
		  		    	  $("#mensaje_marcaciones_masivas").text("Sólo se pueden subir archivos con extensiones: "+ extensiones_permitidas.join());
		  		    	  $("#mensaje_marcaciones_masivas").fadeIn("slow"); //Muestra mensaje de error

		  		    	  $("html, body").animate({ scrollTop: $(mensaje_marcaciones_masivas).offset().top }, tiempo);
					      return false;

			  			}else{ 
		  			        $("#mensaje_marcaciones_masivas").fadeOut("slow"); //Muestra mensaje de error
		  		      	} 
		  		   }

				}   

			}); 


		        $( "#marcaciones_masivas" ).focus(function() {
				  $("#mensaje_marcaciones_masivas").fadeOut("slow");
			    });
		       
				    
		}); 

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
         <li class="active">Clientes</li>
         </ol>
         </section>
       

      
        <!-- /page content -->
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Panel<small>Registro de Marcaciones Mensuales Medidores</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					
				
				   <section class="content">
                   <div class='nav-tabs-custom'>
          	       <ul id="myTabs" class="nav nav-tabs">
                 
                   <?php if(!empty($resultEdit)){?>
                    <li id="nav-registro_manual" class="active"><a href="#registro_manual" data-toggle="tab">Registro Manual</a></li>
                    <li id="nav-registro_masivo"><a href="#registro_masivo" data-toggle="tab" >Registro Masivo</a></li>
               	   <?php }elseif (!empty($resultEditAsig)){?>
               	    <li id="nav-registro_manual"><a href="#registro_manual" data-toggle="tab">Registro Manual</a></li>
                    <li id="nav-registro_masivo" class="active"><a href="#registro_masivo" data-toggle="tab" >Registro Masivo</a></li>
               	   <?php }else{?>
               	   <li id="nav-registro_manual" class="active"><a href="#registro_manual" data-toggle="tab">Registro Manual</a></li>
                    <li id="nav-registro_masivo"><a href="#registro_masivo" data-toggle="tab" >Registro Masivo</a></li>
               	   <?php }?>
               	   
               	   </ul>
				
				
				
				<div class="tab-content">
 		        <br>
               <?php if(!empty($resultEdit)){?>
                 
                <div class="tab-pane active" id="registro_manual">
               <?php }elseif(!empty($resultEditAsig)){?> 
                   <div class="tab-pane" id="registro_manual">
             
                <?php }else{?>
                   <div class="tab-pane active" id="registro_manual">
             
                <?php }?>
                
              <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Insertar<small>Marcaciones Mensuales</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
                
                <form  action="<?php echo $helper->url("MarcacionesMensualesMedidorAgua","InsertaMarcacionesManuales"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                           <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                             
                               
                              <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="identificador_medidores_agua" class="control-label">Identificador Medidor:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua" name="id_medidores_agua" value="<?php echo $resEdit->id_medidores_agua; ?>" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua" name="identificador_medidores_agua" value="<?php echo $resEdit->identificador_medidores_agua; ?>"  placeholder="identificador.." readonly>
                                                      <div id="mensaje_identificador_medidores_agua" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                 <div class="col-lg-2 col-xs-12 col-md-2">
                        		 <div class="form-group">
                                                      <label for="identificacion_clientes" class="control-label">Identificación:</label>
                                                      <input type="hidden" class="form-control" id="id_marcaciones_mensuales_medidor_agua" name="id_marcaciones_mensuales_medidor_agua" value="<?php echo $resEdit->id_marcaciones_mensuales_medidor_agua; ?>" readonly>
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="<?php echo $resEdit->id_clientes; ?>" readonly>
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value="<?php echo $resEdit->identificacion_clientes; ?>"  placeholder="identificación.." readonly>
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                   </div>
                                   </div>
                                    
                                   <div class="col-lg-6 col-xs-12 col-md-6">
                        		   <div class="form-group">
                                                      <label for="razon_social_clientes" class="control-label">Razón Social:</label>
                                                      <input type="text" class="form-control" id="razon_social_clientes" name="razon_social_clientes" value="<?php echo $resEdit->razon_social_clientes; ?>"  placeholder="razón social.." readonly>
                                                      <div id="mensaje_razon_social_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                  
                                
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="fecha_pago_mensual_correspondiente" class="control-label">Fecha Correspondiente:</label>
                                                      <input type="date" class="form-control" id="fecha_pago_mensual_correspondiente" name="fecha_pago_mensual_correspondiente"  value="<?php echo $resEdit->fecha_pago_mensual_correspondiente; ?>" disabled>
                                                      <input type="hidden" class="form-control" id="fecha_pago_mensual_correspondiente_db" name="fecha_pago_mensual_correspondiente_db"  value="0" disabled>
                                                      
                                                      <div id="mensaje_fecha_pago_mensual_correspondiente" class="errores"></div>
                                </div>
                                </div>
                                </div>
                    			
                    			
                    			<div class="row">
                    			<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="marcacion_mensual_inicial" class="control-label">Marcación Inicial:</label>
                                                      <input type="number" class="form-control" id="marcacion_mensual_inicial" name="marcacion_mensual_inicial" value="<?php echo $resEdit->marcacion_mensual_inicial; ?>" placeholder="marcación inicial.." readonly>
                                                      <div id="mensaje_marcacion_mensual_inicial" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="marcacion_mensual_final" class="control-label">Marcación Final:</label>
                                                      <input type="number" class="form-control" id="marcacion_mensual_final" name="marcacion_mensual_final" value="<?php echo $resEdit->marcacion_mensual_final; ?>" placeholder="marcación final..">
                                                      <div id="mensaje_marcacion_mensual_final" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="tipo_registro" class="control-label">Tipo Registro:</label>
                                                      <input type="text" class="form-control" id="tipo_registro" name="tipo_registro" value="<?php echo $resEdit->tipo_registro; ?>" readonly>
                                                      <div id="mensaje_tipo_registro" class="errores"></div>
                                </div>
                                </div>
                                
                    			</div>
                               
                    	       
                             
                             
                             
                             
                             
                                <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Actualizar</i></button>
                                					   <a href="index.php?controller=MarcacionesMensualesMedidorAgua&action=index" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>
				  		
                                					
                                </div>
                    		    </div>
                    		    </div>
                             
                                
                                
                    		     <?php } } else {?>
                    		   
                    		    <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="identificador_medidores_agua" class="control-label">Identificador Medidor:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua" name="id_medidores_agua" value="0" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua" name="identificador_medidores_agua" value=""  placeholder="identificador..">
                                                      <div id="mensaje_identificador_medidores_agua" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                 <div class="col-lg-2 col-xs-12 col-md-2">
                        		 <div class="form-group">
                                                      <label for="identificacion_clientes" class="control-label">Identificación:</label>
                                                      <input type="hidden" class="form-control" id="id_marcaciones_mensuales_medidor_agua" name="id_marcaciones_mensuales_medidor_agua" value="0" readonly>
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="0" readonly>
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value=""  placeholder="identificación.." readonly>
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                   </div>
                                   </div>
                                    
                                   <div class="col-lg-6 col-xs-12 col-md-6">
                        		   <div class="form-group">
                                                      <label for="razon_social_clientes" class="control-label">Razón Social:</label>
                                                      <input type="text" class="form-control" id="razon_social_clientes" name="razon_social_clientes" value=""  placeholder="razón social.." readonly>
                                                      <div id="mensaje_razon_social_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="fecha_pago_mensual_correspondiente" class="control-label">Fecha Correspondiente:</label>
                                                      <input type="hidden" class="form-control" id="fecha_pago_mensual_correspondiente_db" name="fecha_pago_mensual_correspondiente_db"  value="0" disabled>
                                                      <input type="date" class="form-control" id="fecha_pago_mensual_correspondiente" name="fecha_pago_mensual_correspondiente"  value="" >
                                                      <div id="mensaje_fecha_pago_mensual_correspondiente" class="errores"></div>
                                </div>
                                </div>
                                </div>
                    			
                    			
                    			
                    			<div class="row">
                    			<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="marcacion_mensual_inicial" class="control-label">Marcación Inicial:</label>
                                                      <input type="number" class="form-control" id="marcacion_mensual_inicial" name="marcacion_mensual_inicial" value="" placeholder="marcación inicial.." readonly>
                                                      <div id="mensaje_marcacion_mensual_inicial" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="marcacion_mensual_final" class="control-label">Marcación Final:</label>
                                                      <input type="number" class="form-control" id="marcacion_mensual_final" name="marcacion_mensual_final" value="" placeholder="marcación final..">
                                                      <div id="mensaje_marcacion_mensual_final" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="tipo_registro" class="control-label">Tipo Registro:</label>
                                                      <input type="text" class="form-control" id="tipo_registro" name="tipo_registro" value="Manual" readonly>
                                                      <div id="mensaje_tipo_registro" class="errores"></div>
                                </div>
                                </div>
                                
                    			</div>
                               
                    	           	
                    	           	
                    	           	
                    	        <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Guardar</i></button>
                                					  <button type="button" id="Cancelar" name="Cancelar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></button>
                                
                                </div>
                    		    </div>
                    		    </div>
                    	           	
                    	           	
                    	           	
                    		     <?php } ?>
                    		      
                    		   
  
              </form>
  </div>
  </div>
 </div>
                
    
    
    
                
                
                
                
                <div class="col-md-12 col-lg-12 col-xs-12">
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>Listado<small>Marcaciones Mensuales Registradas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
					<div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_consultar_registros" name="search_consultar_registros" onkeyup="load_consultar_registros(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_consultar_registros_registrados" ></div>	
					<div id="consultar_registros_registrados"></div>	
				 </div>
				</div>
			   </div>
			 </div>
				
				
				
				
				
				
				
				
				<?php if(!empty($resultEditAsig)){?>
                <div class="tab-pane active" id="registro_masivo">
               <?php }else{?> 
                   <div class="tab-pane " id="registro_masivo">
               <?php }?>
				
			     
              <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Insetar<small>Marcaciones Mensuales Masivas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
                
                <form  action="<?php echo $helper->url("MarcacionesMensualesMedidorAgua","InsertaMarcacionesnMasivas"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                                       		   
                    		   
                    		       <div class="row">
             					   <div class="col-lg-6 col-xs-12 col-md-6">
                        		   <div class="form-group">
                                                          <label for="marcaciones_masivas" class="control-label">Seleccione Archivo:</label>
                                                          <input type="hidden" name="tipo_registro_masiva" id="tipo_registro_masiva"  value="Masiva" class="form-control"/> 
			   		                                      <input type="file" name="marcaciones_masivas" id="marcaciones_masivas" accept="txt" value="" class="form-control"/> 
			   		                                      <div id="mensaje_marcaciones_masivas" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    </div>     
                    			
                               
                         
                    	           	
                    	           	
                    	           	
                    	        <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="GuardarAsig" name="GuardarAsig" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Guardar</i></button>
                                					  <button type="button" id="CancelarAsig" name="CancelarAsig" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></button>
                                
                                </div>
                    		    </div>
                    		    </div>
                    	           	
                    	       
  
              </form>
		  </div>
		  </div>
		 </div>
                
    			
				
				<div class="col-md-12 col-lg-12 col-xs-12">
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>Bitacora<small>Validación Marcaciones Masivas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
					<div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_bitacora_validacion" name="search_bitacora_validacion" onkeyup="load_bitacora_validacion(1)" placeholder="search.."/>
					</div>
					
					<div id="load_bitacora_validacion" ></div>	
					<div id="bitacora_validacion"></div>	
				
				 </div>
				</div>
			   </div>
				
				
				
				
				
				
				
				
				
				
				
				
				</div>
				
				
				
				</div>
				</div>
				
				</section>
				
				
				
				
				
				
					
                  
                  </div>
                </div>
              </div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
      
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

	
  </body>
</html>   