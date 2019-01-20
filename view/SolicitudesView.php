<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Solicitudes</title>


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
        		   load_pendientes(1);
        		   load_aprobadas(1);
        		   load_anuladas(1);
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


        	   
        	   function load_pendientes(pagina){

        		   var search=$("#search_pendientes").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_pendientes_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_pendientes_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=Solicitudes&action=pendientes&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#pendientes_registrados").html(x);
           	               	 $("#tabla_pendientes").tablesorter(); 
           	                 $("#load_pendientes_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#pendientes_registrados").html("Ocurrio un error al cargar la informacion de Solicitudes Pendientes..."+estado+"    "+error);
           	              }
           	            });

           		   }


        	   function load_aprobadas(pagina){

        		   var search=$("#search_aprobadas").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_aprobadas_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_aprobadas_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=Solicitudes&action=aprobadas&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#aprobadas_registrados").html(x);
           	               	 $("#tabla_aprobadas").tablesorter(); 
           	                 $("#load_aprobadas_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#aprobadas_registrados").html("Ocurrio un error al cargar la informacion de Solicitudes Aprobadas..."+estado+"    "+error);
           	              }
           	            });

           		   }


        	   function load_anuladas(pagina){

        		   var search=$("#search_anuladas").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_anuladas_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_anuladas_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=Solicitudes&action=anuladas&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#anuladas_registrados").html(x);
           	               	 $("#tabla_anuladas").tablesorter(); 
           	                 $("#load_anuladas_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#anuladas_registrados").html("Ocurrio un error al cargar la informacion de Solicitudes Anuladas..."+estado+"    "+error);
           	              }
           	            });

           		   }

       		   
        </script>
        
        
        
        
                
        
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#Cancelar").click(function() 
			{
		    	$('#razon_social_clientes').val("");
				$('#id_tipo_identificacion').val("0");
				$('#identificacion_clientes').val("");
				$('#id_tipo_persona').val("0");
		        $("#id_clientes").val("0");
		        $("#id_tipo_consumo").val("0");
		        $("#documentacion_solicitudes").val("");
				
		        
		     
		    }); 
		    }); 
			</script>
        
        
          
        <script>
        

	       	$(document).ready(function(){

                        var id_clientes = $("#id_clientes").val();

                        if(id_clientes>0){}else{
        	       		
						$( "#identificacion_clientes" ).autocomplete({
		      				source: "<?php echo $helper->url("Solicitudes","AutocompleteCedula"); ?>",
		      				minLength: 1
		    			});
		
						$("#identificacion_clientes").focusout(function(){
		    				$.ajax({
		    					url:'<?php echo $helper->url("Solicitudes","AutocompleteDevuelveNombres"); ?>',
		    					type:'POST',
		    					dataType:'json',
		    					data:{identificacion_clientes:$('#identificacion_clientes').val()}
		    				}).done(function(respuesta){

		    					$('#razon_social_clientes').val(respuesta.razon_social_clientes);
		    					$('#id_tipo_persona').val(respuesta.id_tipo_persona);
		    					$('#id_tipo_identificacion').val(respuesta.id_tipo_identificacion);
		    					$('#identificacion_clientes').val(respuesta.identificacion_clientes);
		    					$('#id_clientes').val(respuesta.id_clientes);

		    					
		    					
		    				
		        			}).fail(function(respuesta) {

		        				$('#razon_social_clientes').val("");
		        				$('#identificacion_clientes').val("");
		        				$('#id_tipo_identificacion').val("0");
		    					$('#id_tipo_persona').val("0");
		    					$('#id_clientes').val("0");
		    					
		    					
		        			    
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
		    	$('#lista_tarifas option').prop('selected', 'selected'); 
				
		    	selecionarTodos();
				
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var id_clientes  = $("#id_clientes").val();
		    	var id_tipo_consumo = $("#id_tipo_consumo").val();
		    	var documentacion_solicitudes = $("#documentacion_solicitudes").val();
                var id_solicitudes = $("#id_solicitudes").val();
		    	
		    	var contador=0;
		    	var tiempo = tiempo || 1000;


		    	if (id_clientes == 0)
		    	{
			    	
		    		$("#mensaje_identificacion_clientes").text("Introduzca Identificación");
		    		$("#mensaje_identificacion_clientes").fadeIn("slow"); //Muestra mensaje de error
		    		$("html, body").animate({ scrollTop: $(mensaje_identificacion_clientes).offset().top }, tiempo);
			        
			            return false;
			    }
		    	else 
		    	{
						$("#mensaje_identificacion_clientes").fadeOut("slow"); //Muestra mensaje de error
				                     
				}

				
			
		    	if (id_tipo_consumo == 0)
		    	{
			    	
		    		$("#mensaje_id_tipo_consumo").text("Seleccione Tipo");
		    		$("#mensaje_id_tipo_consumo").fadeIn("slow"); //Muestra mensaje de error
		    		$("html, body").animate({ scrollTop: $(mensaje_id_tipo_consumo).offset().top }, tiempo);
			        
			            return false;
			    }
		    	else 
		    	{
					$("#mensaje_id_tipo_consumo").fadeOut("slow"); //Muestra mensaje de error
		    	
				}
		    			

		    			    	
		    	if (documentacion_solicitudes == "" )
		    	{
			    	if(id_solicitudes==0){
		    		$("#mensaje_documentacion_solicitudes").text("Seleccione Documentación");
		    		$("#mensaje_documentacion_solicitudes").fadeIn("slow"); //Muestra mensaje de error
		    		$("html, body").animate({ scrollTop: $(mensaje_documentacion_solicitudes).offset().top }, tiempo);
					
			            return false;
			       }else 
			    	{
						$("#mensaje_documentacion_solicitudes").fadeOut("slow"); //Muestra mensaje de error
					}
			    }
		    	else 
		    	{
						$("#mensaje_documentacion_solicitudes").fadeOut("slow"); //Muestra mensaje de error
				}

		    	var contar_to =0;
		    	 var contar_to = $("#lista_tarifas option").length;
					
				    if (contar_to==0 || contar_to =="")
			    	{
				    	$("#mensaje_lista_tarifas").text("Seleccione Servicios");
			    		$("#mensaje_lista_tarifas").fadeIn("slow"); //Muestra mensaje de error
			            return false;
				    }
			    	else 
			    	{
			    		$("#mensaje_lista_tarifas").fadeOut("slow"); //Muestra mensaje de error
			            
					}


	    				    

			}); 



	        $( "#identificacion_clientes" ).focus(function() {
			  $("#mensaje_identificacion_clientes").fadeOut("slow");
		    });
		        $( "#id_tipo_consumo" ).focus(function() {
				  $("#mensaje_id_tipo_consumo").fadeOut("slow");
			    });
		        $( "#documentacion_solicitudes" ).focus(function() {
					  $("#mensaje_documentacion_solicitudes").fadeOut("slow");
				 });
		        $( "#lista_tarifas" ).focus(function() {
		  		  $("#mensaje_lista_tarifas").fadeOut("slow");
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
         <li class="active">Solicitudes</li>
         </ol>
         </section>
       
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>INSERTAR<small>Solicitud</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">






            <form  action="<?php echo $helper->url("Solicitudes","InsertaSolicitudes"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                           <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                 
                 
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
                                    
                                  
                                    
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="razon_social_clientes" class="control-label">Razón Social:</label>
                                                      <input type="text" class="form-control" id="razon_social_clientes" name="razon_social_clientes" value="<?php echo $resEdit->razon_social_clientes; ?>"  placeholder="razón social.." readonly>
                                                      <div id="mensaje_razon_social_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                 
                                    <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_consumo" class="control-label">Tipo Consumo:</label>
                                                          <select name="id_tipo_consumo" id="id_tipo_consumo"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTip_Con as $res) {?>
                        										<option value="<?php echo $res->id_tipo_consumo; ?>" <?php if ($res->id_tipo_consumo == $resEdit->id_tipo_consumo )  echo  ' selected="selected" '  ;  ?>><?php echo $res->nombre_tipo_consumo; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_consumo" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-lg-2 col-xs-12 col-md-2">
                        		    <div class="form-group">
                                                          <label for="documentacion_solicitudes" class="control-label">Documentación:</label>
                                                          <input type="file" accept=".pdf" class="form-control" id="documentacion_solicitudes" name="documentacion_solicitudes" value="">
                                                          <div id="mensaje_documentacion_solicitudes" class="errores"></div>
                                    </div>
                        		    </div>
                                 
                                  
                                   
                                    
            </div>        		   
                    	      
                    			
            
            
            <div class="row">
                        		<div class="col-xs-12 col-lg-5 col-md-5">
                        		   <div class="form-group">
                                      <label for="id_tarifas" class="control-label">Servicios</label>
                                      <select name="id_tarifas" id="id_tarifas" multiple="multiple" style="height: 250px" class="form-control" >
    									<?php foreach($resultTarifa as $res) {?>
    										<option value="<?php echo $res->id_tarifas; ?>" style="font-size: 12px;"><?php echo $res->nombre_tarifa; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_tarifas" class="errores"></div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-xs-12 col-lg-2 col-md-2">
                                 	<table class="table" style="text-align: center;">
                                        <br>                                          
                                        <br>                                          
                                        <br>
                                        <br>
                                        <tr>                                          
                                          <td>
                                            <div class="btn-group-vertical">
                                              <button id="link_agregar_tarifa" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-right"></i></button>
                                              <button id="link_agregar_tarifas" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-double-right"></i></button>
                                              <button id="link_eliminar_tarifa" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-left"></i></button>
                                              <button id="link_eliminar_tarifas" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-double-left"></i></button>
                                            </div>
                                          </td>
                                         </tr>
                                      </table>
                                 	 
                                 </div>
                                 
                                 <div class="col-xs-12 col-lg-5 col-md-5">
                        		   <div class="form-group">
                                      <label for="lista_tarifas" class="control-label">Sus servicios seleccionados:</label>
                                      <select name="lista_tarifas[]" id="lista_tarifas" style="height: 250px" multiple="multiple" class="form-control" >
                                      <?php foreach($result_tar as $res) {?>
    										<option value="<?php echo $res->id_tarifas; ?>"  ><?php echo $res->nombre_tarifa; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_lista_tarifas" class="errores"></div>
                                    </div>
                                 </div>
            </div>
                     
          
                
                    	           	
                    	           	
                    	        <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Actualizar</i></button>
                                					  <a href="index.php?controller=Solicitiudes&action=index" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>
				  		
                                </div>
                    		    </div>
                    		    </div>
                    	           	
                    
                 
                               
                    		  
                                
                    	   <?php } } else {?>
                    		    
                    		   
                    		   
            <div class="row">
             					   
             					   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_persona" class="control-label">Tipo Persona:</label>
                                                          <select name="id_tipo_persona" id="id_tipo_persona"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTip_Per as $res) {?>
                        										<option value="<?php echo $res->id_tipo_persona; ?>"><?php echo $res->nombre_tipo_persona; ?> </option>
                        							    
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
                        										<option value="<?php echo $res->id_tipo_identificacion; ?>" ><?php echo $res->nombre_tipo_identificacion; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_identificacion" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="identificacion_clientes" class="control-label">Identificación:</label>
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="0" >
                                                      <input type="hidden" class="form-control" id="id_solicitudes" name="id_solicitudes" value="0" >
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value=""  placeholder="identificación..">
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="razon_social_clientes" class="control-label">Razón Social:</label>
                                                      <input type="text" class="form-control" id="razon_social_clientes" name="razon_social_clientes" value=""  placeholder="razón social.." readonly>
                                                      <div id="mensaje_razon_social_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_consumo" class="control-label">Tipo Consumo:</label>
                                                          <select name="id_tipo_consumo" id="id_tipo_consumo"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTip_Con as $res) {?>
                        										<option value="<?php echo $res->id_tipo_consumo; ?>" ><?php echo $res->nombre_tipo_consumo; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_consumo" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-lg-2 col-xs-12 col-md-2">
                        		    <div class="form-group">
                                                          <label for="documentacion_solicitudes" class="control-label">Documentación:</label>
                                                          <input type="file" accept=".pdf" class="form-control" id="documentacion_solicitudes" name="documentacion_solicitudes" value="">
                                                          <div id="mensaje_documentacion_solicitudes" class="errores"></div>
                                    </div>
                        		    </div>
                        		
                                    
            </div>        		   
                    	      
                    	           	
            
            
            <div class="row">
                        		<div class="col-xs-12 col-lg-5 col-md-5">
                        		   <div class="form-group">
                                      <label for="id_tarifas" class="control-label">Servicios</label>
                                      <select name="id_tarifas" id="id_tarifas" multiple="multiple" style="height: 250px" class="form-control" >
    									<?php foreach($resultTarifa as $res) {?>
    										<option value="<?php echo $res->id_tarifas; ?>" style="font-size: 12px;"><?php echo $res->nombre_tarifa; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_tarifas" class="errores"></div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-xs-12 col-lg-2 col-md-2">
                                 	<table class="table" style="text-align: center;">
                                        <br>                                          
                                        <br>                                          
                                        <br>
                                        <br>
                                        <tr>                                          
                                          <td>
                                            <div class="btn-group-vertical">
                                              <button id="link_agregar_tarifa" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-right"></i></button>
                                              <button id="link_agregar_tarifas" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-double-right"></i></button>
                                              <button id="link_eliminar_tarifa" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-left"></i></button>
                                              <button id="link_eliminar_tarifas" type="button" class="btn btn-default"><i class="fa fa-fw fa-angle-double-left"></i></button>
                                            </div>
                                          </td>
                                         </tr>
                                      </table>
                                 	 
                                 </div>
                                 
                                 <div class="col-xs-12 col-lg-5 col-md-5">
                        		   <div class="form-group">
                                      <label for="lista_tarifas" class="control-label">Sus servicios seleccionados:</label>
                                      <select name="lista_tarifas[]" id="lista_tarifas" style="height: 250px" multiple="multiple" class="form-control" >
                                      
    								   </select> 
                                      <div id="mensaje_lista_tarifas" class="errores"></div>
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
		
  
      
        <!-- /page content -->
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LISTADO<small>Solicitudes</small></h2>
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
                    <li id="nav-pendientes" class="active"><a href="#pendientes" data-toggle="tab">Solicitudes Pendientes</a></li>
                     <li id="nav-aprobadas"><a href="#aprobadas" data-toggle="tab" >Solicitudes Aprobadas</a></li>
                    <li id="nav-anuladas"><a href="#anuladas" data-toggle="tab" >Solicitudes Anuladas</a></li>
               	   </ul>
				
				
				
				<div class="tab-content">
 		        <br>
                <div class="tab-pane active" id="pendientes">
                
					<div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_pendientes" name="search_pendientes" onkeyup="load_pendientes(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_pendientes_registrados" ></div>	
					<div id="pendientes_registrados"></div>	
				 
				</div>
				
				
				
				
				
                <div class="tab-pane" id="aprobadas">
               
					<div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_aprobadas" name="search_aprobadas" onkeyup="load_aprobadas(1)" placeholder="search.."/>
					</div>
					
					<div id="load_aprobadas_registrados" ></div>	
					<div id="aprobadas_registrados"></div>	
				
				</div>
				
				
				
				<div class="tab-pane" id="anuladas">
               
					<div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_anuladas" name="search_anuladas" onkeyup="load_anuladas(1)" placeholder="search.."/>
					</div>
					
					<div id="load_anuladas_registrados" ></div>	
					<div id="anuladas_registrados"></div>	
				
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







  <script type="text/javascript">
     
   $(document).ready( function (){
	   
	    $('#link_agregar_tarifa').click(function() { 
	        copiarOpcion($('#id_tarifas option:selected').clone(), "#lista_tarifas");
	    });
	    $('#link_agregar_tarifas').click(function() { 
	        $('#id_tarifas option').each(function() {
	            copiarOpcion($(this).clone(), "#lista_tarifas");
	        }); 
	    });
	    $('#link_eliminar_tarifa').click(function() { 
	        $('#lista_tarifas option:selected').remove(); 
	    });
	    $('#link_eliminar_tarifas').click(function() { 
	        $('#lista_tarifas option').each(function() {
	            $(this).remove(); 
	        }); 
	    });
	 	
		
});
    function copiarOpcion(opcion, destino) {
        var valor = $(opcion).val();
        if (($(destino + " option[value=" + valor + "] ").length == 0) && valor != 0 ) {
            $(opcion).appendTo(destino);
        }
    }
    function selecionarTodos(){
    	$("#lista_tarifas option").each(function(){
	      $(this).attr("selected", true);
		 });
     }
    
 
        	   
   
  
  
   
</script>





	
  </body>
</html>   