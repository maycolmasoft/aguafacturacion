<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Asignar Medidor Clientes</title>


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
        		   load_medidores_agua(1);
        		   load_asignacion_medidores_clientes(1);
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


        	   
        	   function load_medidores_agua(pagina){

        		   var search=$("#search_medidores_agua").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_medidores_agua_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_medidores_agua_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=AsignacionClientesMedidorAgua&action=consulta_medidores&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#medidores_agua_registrados").html(x);
           	               	 $("#tabla_medidores").tablesorter(); 
           	                 $("#load_medidores_agua_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#medidores_agua_registrados").html("Ocurrio un error al cargar la informacion de Medidores..."+estado+"    "+error);
           	              }
           	            });

           		   }


        	   function load_asignacion_medidores_clientes(pagina){

        		   var search=$("#search_asignacion_medidores_clientes").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_asignacion_medidores_clientes_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_asignacion_medidores_clientes_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=AsignacionClientesMedidorAgua&action=consulta_asignacion_medidores_clientes&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#asignacion_medidores_clientes").html(x);
           	               	 $("#tabla_asignacion_clientes_medidor").tablesorter(); 
           	                 $("#load_asignacion_medidores_clientes_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#asignacion_medidores_clientes").html("Ocurrio un error al cargar la informacion de Aignaciones de Medidores..."+estado+"    "+error);
           	              }
           	            });

           		   }

       		   
        </script>
        
        
        
        
       
		 
        
        
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#Cancelar").click(function() 
			{
		    	$('#id_medidores_agua').val("0");
		    	$('#identificador_medidores_agua').val("");
		        
		     
		    }); 
		    }); 
			</script>
        
        
        
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#CancelarAsig").click(function() 
			{
		    	$('#id_asignacion_clientes_medidor_agua').val("0");
		    	$('#id_clientes').val("");
		    	$('#identificacion_clientes').val("");
		    	$('#id_tipo_identificacion').val("0");
		    	$('#apellidos_clientes').val("");
		    	$('#nombres_clientes').val("");
		    	$('#id_medidores_agua_asignacion').val("");
		    	$('#identificador_medidores_agua_asignacion').val("");



		    	
		    	
		    	
		    	

		    	
		    	

		    	
		    	
		     
		    }); 
		    }); 
			</script>
        
        
          
        <script>
        

	       	$(document).ready(function(){

                        var id_medidores_agua = $("#id_medidores_agua").val();

                        if(id_medidores_agua>0){}else{
        	       		
						$( "#identificador_medidores_agua" ).autocomplete({
		      				source: "<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteIdentificador"); ?>",
		      				minLength: 1
		    			});
		
						$("#identificador_medidores_agua").focusout(function(){
		    				$.ajax({
		    					url:'<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteDevuelveIdentificador"); ?>',
		    					type:'POST',
		    					dataType:'json',
		    					data:{identificador_medidores_agua:$('#identificador_medidores_agua').val()}
		    				}).done(function(respuesta){

		    					$('#identificador_medidores_agua').val(respuesta.identificador_medidores_agua);
		    					

		    					
		    					
		    				
		        			}).fail(function(respuesta) {

		        				//$('#id_medidores_agua_ver').val("0");
		    					
		        			  });
		    				 
		    				
		    			});  
                        }
						
		    		});
		
	     
		     </script>
		     
		     
		     
		     
		     
		     
          
        <script>
        

	       	$(document).ready(function(){

                        var id_clientes = $("#id_clientes").val();

                        if(id_clientes>0){}else{
        	       		
						$( "#identificacion_clientes" ).autocomplete({
		      				source: "<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteCedula"); ?>",
		      				minLength: 1
		    			});
		
						$("#identificacion_clientes").focusout(function(){
		    				$.ajax({
		    					url:'<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteDevuelveNombres"); ?>',
		    					type:'POST',
		    					dataType:'json',
		    					data:{identificacion_clientes:$('#identificacion_clientes').val()}
		    				}).done(function(respuesta){

		    					$('#apellidos_clientes').val(respuesta.apellidos_clientes);
		    					$('#nombres_clientes').val(respuesta.nombres_clientes);
		    					$('#id_tipo_identificacion').val(respuesta.id_tipo_identificacion);
		    					$('#identificacion_clientes').val(respuesta.identificacion_clientes);
		    					$('#id_clientes').val(respuesta.id_clientes);

		    					
		    					
		    				
		        			}).fail(function(respuesta) {

		        				$('#apellidos_clientes').val("");
		    					$('#nombres_clientes').val("");
		    					$('#id_tipo_identificacion').val("0");
		    					$('#id_clientes').val("0");
		    					
		        			    
		        			    
		        			  });
		    				 
		    				
		    			});  
                        }
						
		    		});
		
	     
		     </script>
        
		     
		     
		     
		     
          
        <script>
        	$(document).ready(function(){
        	       		
						$( "#identificador_medidores_agua_asignacion" ).autocomplete({
		      				source: "<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteIdentificadorAsignar"); ?>",
		      				minLength: 1
		    			});
		
						$("#identificador_medidores_agua_asignacion").focusout(function(){
		    				$.ajax({
		    					url:'<?php echo $helper->url("AsignacionClientesMedidorAgua","AutocompleteDevuelveIdentificadorAsignar"); ?>',
		    					type:'POST',
		    					dataType:'json',
		    					data:{identificador_medidores_agua:$('#identificador_medidores_agua_asignacion').val()}
		    				}).done(function(respuesta){

		    					$('#id_medidores_agua_asignacion').val(respuesta.id_medidores_agua);
		    					$('#identificador_medidores_agua_asignacion').val(respuesta.identificador_medidores_agua);
		    					
		    				
		        			}).fail(function(respuesta) {

		        				$('#id_medidores_agua_asignacion').val("0");
		        			    
		        			  });
		    			});  
						
		    		});
		 
		     </script>
		     
		     
		     
		     
		     
        <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardar").click(function() 
			{


				
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var identificador_medidores_agua = $("#identificador_medidores_agua").val();
		    	
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
		    		if(identificador_medidores_agua.length==10){

						$("#mensaje_identificador_medidores_agua").fadeOut("slow"); //Muestra mensaje de error
					}else{
						
						$("#mensaje_identificador_medidores_agua").text("Deben ser 10 dígitos");
			    		$("#mensaje_identificador_medidores_agua").fadeIn("slow"); //Muestra mensaje de error
			           
			            $("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua).offset().top }, tiempo);
			            return false;
					}
		            
				}


			 				    

			}); 


		        $( "#identificador_medidores_agua" ).focus(function() {
				  $("#mensaje_identificador_medidores_agua").fadeOut("slow");
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

		    	var id_clientes = $("#id_clientes").val();
		    	var id_medidores_agua_asignacion = $("#id_medidores_agua_asignacion").val();
		    	

		    	var contador=0;
		    	 var tiempo = tiempo || 1000;
		    	 
		    	
		    	if (id_clientes == "")
		    	{
			    	
		    		$("#mensaje_identificacion_clientes").text("Ingrese Identificación");
		    		$("#mensaje_identificacion_clientes").fadeIn("slow"); //Muestra mensaje de error

		    		$("html, body").animate({ scrollTop: $(mensaje_identificacion_clientes).offset().top }, tiempo);
			        return false;
			    }
		    	else 
		    	{

			    	if(id_clientes==0){

			    		$("#mensaje_identificacion_clientes").text("Cliente no Registrado o esta Inactivo.");
			    		$("#mensaje_identificacion_clientes").fadeIn("slow"); //Muestra mensaje de error

			    		$("html, body").animate({ scrollTop: $(mensaje_identificacion_clientes).offset().top }, tiempo);
				        return false;
				        
				    	}else{

				    		$("#mensaje_identificacion_clientes").fadeOut("slow"); //Muestra mensaje de error
							
					    }
		    	    
				}   


		    	if (id_medidores_agua_asignacion == "")
		    	{
			    	
		    		$("#mensaje_identificador_medidores_agua_asignacion").text("Ingrese # Medidor");
		    		$("#mensaje_identificador_medidores_agua_asignacion").fadeIn("slow"); //Muestra mensaje de error

		    		$("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua_asignacion).offset().top }, tiempo);
			        return false;
			    }
		    	else 
		    	{

			    	if(id_medidores_agua_asignacion==0){

			    		$("#mensaje_identificador_medidores_agua_asignacion").text("Medidor no Registrado o ya esta Asignado.");
			    		$("#mensaje_identificador_medidores_agua_asignacion").fadeIn("slow"); //Muestra mensaje de error

			    		$("html, body").animate({ scrollTop: $(mensaje_identificador_medidores_agua_asignacion).offset().top }, tiempo);
				        return false;
				        
				    	}else{

				    		$("#mensaje_identificador_medidores_agua_asignacion").fadeOut("slow"); //Muestra mensaje de error
							
					    }
		    	    
				}     
			 				    

			}); 


		        $( "#identificacion_clientes" ).focus(function() {
				  $("#mensaje_identificacion_clientes").fadeOut("slow");
			    });
		        $( "#identificador_medidores_agua_asignacion" ).focus(function() {
					  $("#mensaje_identificador_medidores_agua_asignacion").fadeOut("slow");
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
                    <h2>Panel<small>Medidores de Agua</small></h2>
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
                    <li id="nav-registrar" class="active"><a href="#registrar" data-toggle="tab">Medidores de Agua</a></li>
                    <li id="nav-asignar"><a href="#asignar" data-toggle="tab" >Asignar Medidor al Cliente</a></li>
               	   <?php }elseif (!empty($resultEditAsig)){?>
               	    <li id="nav-registrar"><a href="#registrar" data-toggle="tab">Medidores de Agua</a></li>
                    <li id="nav-asignar" class="active"><a href="#asignar" data-toggle="tab" >Asignar Medidor al Cliente</a></li>
               	   <?php }else{?>
               	   <li id="nav-registrar" class="active"><a href="#registrar" data-toggle="tab">Medidores de Agua</a></li>
                    <li id="nav-asignar"><a href="#asignar" data-toggle="tab" >Asignar Medidor al Cliente</a></li>
               	   <?php }?>
               	   
               	   </ul>
				
				
				
				<div class="tab-content">
 		        <br>
               <?php if(!empty($resultEdit)){?>
                 
                <div class="tab-pane active" id="registrar">
               <?php }elseif(!empty($resultEditAsig)){?> 
                   <div class="tab-pane" id="registrar">
             
                <?php }else{?>
                   <div class="tab-pane active" id="registrar">
             
                <?php }?>
                
              <div class="col-md-6 col-lg-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Insertar<small>Medidores de Agua</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
                
                <form  action="<?php echo $helper->url("AsignacionClientesMedidorAgua","InsertaMedidores"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                           <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                             
                               
                               
                                <div class="row">
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="identificador_medidores_agua" class="control-label">Identificador Medidor:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua" name="id_medidores_agua" value="<?php echo $resEdit->id_medidores_agua; ?>" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua" name="identificador_medidores_agua" value="<?php echo $resEdit->identificador_medidores_agua; ?>"  placeholder="identificador..">
                                                      <div id="mensaje_identificador_medidores_agua" class="errores"></div>
                                </div>
                                </div>
                    		    </div>
                             
                             
                              <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Actualizar</i></button>
                                					   <a href="index.php?controller=AsignacionClientesMedidorAgua&action=index" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>
				  		
                                					
                                </div>
                    		    </div>
                    		    </div>
                             
                                
                                
                    		     <?php } } else {?>
                    		    
                    		   
									                    		   
                    		   
                    		    <div class="row">
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="identificador_medidores_agua" class="control-label">Identificador Medidor:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua" name="id_medidores_agua" value="0" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua" name="identificador_medidores_agua" value=""  placeholder="identificador..">
                                                      <div id="mensaje_identificador_medidores_agua" class="errores"></div>
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
                
    
    
    
                
                
                
                
                <div class="col-md-6 col-lg-6 col-xs-12">
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>Listado<small>Medidores de Agua</small></h2>
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
					<input type="text" value="" class="form-control" id="search_medidores_agua" name="search_medidores_agua" onkeyup="load_medidores_agua(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_medidores_agua_registrados" ></div>	
					<div id="medidores_agua_registrados"></div>	
				 </div>
				</div>
			   </div>
			 </div>
				
				
				
				
				
				
				
				
				<?php if(!empty($resultEditAsig)){?>
                 
                <div class="tab-pane active" id="asignar">
               <?php }else{?> 
                   <div class="tab-pane " id="asignar">
             
                <?php }?>
				
			     
              <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Asignar<small>Medidores de Agua a Clientes</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                
                
                
                
                <form  action="<?php echo $helper->url("AsignacionClientesMedidorAgua","InsertaAsignacionMedidores"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                           <?php if ($resultEditAsig !="" ) { foreach($resultEditAsig as $resEditAsig) {?>
                             
                               
                        	   
                    		       <div class="row">
             					   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                          <label for="id_tipo_identificacion" class="control-label">Tipo Identificación:</label>
                                                          <select name="id_tipo_identificacion" id="id_tipo_identificacion"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTipIdenti as $res) {?>
                        										<option value="<?php echo $res->id_tipo_identificacion; ?>" <?php if ($res->id_tipo_identificacion == $resEditAsig->id_tipo_identificacion )  echo  ' selected="selected" '  ;  ?>><?php echo $res->nombre_tipo_identificacion; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_tipo_identificacion" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                    
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="identificacion_clientes" class="control-label">Identificación:</label>
                                                       <input type="hidden" class="form-control" id="id_asignacion_clientes_medidor_agua" name="id_asignacion_clientes_medidor_agua" value="<?php echo $resEditAsig->id_asignacion_clientes_medidor_agua; ?>" >
                                                     
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="<?php echo $resEditAsig->id_clientes; ?>" readonly>
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value="<?php echo $resEditAsig->identificacion_clientes; ?>"  placeholder="identificación.." readonly>
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   <div class="col-lg-3 col-xs-12 col-md-3">
                        		   <div class="form-group">
                                                      <label for="apellidos_clientes" class="control-label">Apellidos:</label>
                                                      <input type="text" class="form-control" id="apellidos_clientes" name="apellidos_clientes" value="<?php echo $resEditAsig->apellidos_clientes; ?>"  placeholder="apellidos.." readonly>
                                                      <div id="mensaje_apellidos_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   <div class="col-lg-3 col-xs-12 col-md-3">
                        		   <div class="form-group">
                                                      <label for="nombres_clientes" class="control-label">Nombres:</label>
                                                      <input type="text" class="form-control" id="nombres_clientes" name="nombres_clientes" value="<?php echo $resEditAsig->nombres_clientes; ?>"  placeholder="nombres.." readonly>
                                                      <div id="mensaje_nombres_clientes" class="errores"></div>
                                   </div>
                                   </div>
                                   
                                   
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="identificador_medidores_agua_asignacion" class="control-label">Medidor Agua:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua_asignacion" name="id_medidores_agua_asignacion" value="<?php echo $resEditAsig->id_medidores_agua; ?>" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua_asignacion" name="identificador_medidores_agua_asignacion" value="<?php echo $resEditAsig->identificador_medidores_agua; ?>"  placeholder="identificador..">
                                                      <div id="mensaje_identificador_medidores_agua_asignacion" class="errores"></div>
                                   </div>
                                   </div>
                                   </div>     
                    			     
                             
                                <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="GuardarAsig" name="GuardarAsig" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"> Actualizar</i></button>
                                					   <a href="index.php?controller=AsignacionClientesMedidorAgua&action=index" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>
				  		
                                					
                                </div>
                    		    </div>
                    		    </div>
                             
                                
                                
                    		     <?php } } else {?>
                    		    
                    		   
									                    		   
                    		   
                    		       <div class="row">
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
                                                      
                                                      <input type="hidden" class="form-control" id="id_asignacion_clientes_medidor_agua" name="id_asignacion_clientes_medidor_agua" value="0" >
                                                      <input type="hidden" class="form-control" id="id_clientes" name="id_clientes" value="" >
                                                      <input type="number" class="form-control" id="identificacion_clientes" name="identificacion_clientes" value=""  placeholder="identificación..">
                                                      <div id="mensaje_identificacion_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   <div class="col-lg-3 col-xs-12 col-md-3">
                        		   <div class="form-group">
                                                      <label for="apellidos_clientes" class="control-label">Apellidos:</label>
                                                      <input type="text" class="form-control" id="apellidos_clientes" name="apellidos_clientes" value=""  placeholder="apellidos.." readonly>
                                                      <div id="mensaje_apellidos_clientes" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                   <div class="col-lg-3 col-xs-12 col-md-3">
                        		   <div class="form-group">
                                                      <label for="nombres_clientes" class="control-label">Nombres:</label>
                                                      <input type="text" class="form-control" id="nombres_clientes" name="nombres_clientes" value=""  placeholder="nombres.." readonly>
                                                      <div id="mensaje_nombres_clientes" class="errores"></div>
                                   </div>
                                   </div>
                                   
                                   
                                   <div class="col-lg-2 col-xs-12 col-md-2">
                        		   <div class="form-group">
                                                      <label for="identificador_medidores_agua_asignacion" class="control-label">Medidor Agua:</label>
                                                      <input type="hidden" class="form-control" id="id_medidores_agua_asignacion" name="id_medidores_agua_asignacion" value="" >
                                                      <input type="number" class="form-control" id="identificador_medidores_agua_asignacion" name="identificador_medidores_agua_asignacion" value=""  placeholder="identificador..">
                                                      <div id="mensaje_identificador_medidores_agua_asignacion" class="errores"></div>
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
                    	           	
                    	           	
                    	           	
                    		     <?php } ?>
                    		      
                    		   
  
              </form>
		  </div>
		  </div>
		 </div>
                
    			
				
				<div class="col-md-12 col-lg-12 col-xs-12">
                 <div class="x_panel">
                  <div class="x_title">
                    <h2>Listado<small>Asignaciones Medidores de Agua</small></h2>
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
					<input type="text" value="" class="form-control" id="search_asignacion_medidores_clientes" name="search_asignacion_medidores_clientes" onkeyup="load_asignacion_medidores_clientes(1)" placeholder="search.."/>
					</div>
					
					<div id="load_asignacion_medidores_clientes_registrados" ></div>	
					<div id="asignacion_medidores_clientes"></div>	
				
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