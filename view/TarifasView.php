<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Tarifas </title>

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
       
       
       <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var nombre_tarifa = $("#nombre_tarifa").val();
		    	var valor_tarifa = $("#valor_tarifa").val();
		    	
		    	
		    	
		    	if (nombre_tarifa == "")
		    	{
			    	
		    		$("#mensaje_nombre_tarifa").text("Introduzca una Tarifa");
		    		$("#mensaje_nombre_tarifa").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombre_tarifa").fadeOut("slow"); //Muestra mensaje de error
		            
				}  
		    	if (valor_tarifa == 0.00)
		    	{
			    	
		    		$("#mensaje_valor_tarifa").text("Introduzca un Valor");
		    		$("#mensaje_valor_tarifa").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_valor_tarifa").fadeOut("slow"); //Muestra mensaje de error
		            
				}    
								    

			}); 


		        $( "#nombre_tarifa" ).focus(function() {
				  $("#mensaje_nombre_tarifa").fadeOut("slow");
			    });


		        $( "#valor_tarifa" ).focus(function() {
				  $("#mensaje_valor_tarifa").fadeOut("slow");
			    });
				
				
		      
				    
		}); 

	</script>
        
	
	    
       <script>
      $(document).ready(function(){
      $(".cantidades1").inputmask();
      });
	  </script>
	
	
			        
    </head>
    
    
    <body class="nav-md"  >
    
    
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
            <?php
       $sel_menu = "";
       
    
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       	 
       	 
       	$sel_menu=$_POST['criterio'];
       	
       	 
       }
      
	 	?>
    <div class="container">
  <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Roles</li>
         </ol>
         </section>
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>INSERTAR<small>Tarifas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

						<form action="<?php echo $helper->url("Tarifas","InsertaTarifas"); ?>" method="post" class="col-lg-12 col-md-12 col-xs-12">
                              <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                	        
                	        	   <div class="row">
                        		    <div class="col-xs-12 col-md-4 col-md-4 ">
                            		    <div class="form-group">
                                                              <label for="nombre_tarifa" class="control-label">Nombres Tarifas</label>
                                                              <input type="text" class="form-control" id="nombre_tarifa" name="nombre_tarifa" value="<?php echo $resEdit->nombre_tarifa; ?>"  placeholder="Nombre Tarifa">
                                                               <input type="hidden" name="id_tarifas" id="id_tarifas" value="<?php echo $resEdit->id_tarifas; ?>" class="form-control"/>
					                                          <div id="mensaje_nombre_tarifa" class="errores"></div>
                                        </div>
                            		  </div>
                            		     <div class="col-xs-12 col-md-2 col-md-2 ">
                            		    <div class="form-group">
                                                              <label for="valor_tarifa" class="control-label">Valor Tarifas</label>
                                                               <input type="text" class="form-control cantidades1" id="valor_tarifa" name="valor_tarifa" value='<?php echo $resEdit->valor_tarifa; ?>' 
                                                               data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                     
                                                              <div id="mensaje_valor_tarifa" class="errores"></div>
                                        </div>
                            		  </div>
                        			</div>	
                	        
                	        
                	        
                            
                		     <?php } } else {?>
                		    
                  	        	   <div class="row">
                        		    <div class="col-xs-12 col-md-4 col-md-4 ">
                            		    <div class="form-group">
                                                              <label for="nombre_tarifa" class="control-label">Nombres Tarifas</label>
                                                              <input type="text" class="form-control" id="nombre_tarifa" name="nombre_tarifa" value=""  placeholder="Nombre Tarifa">
                                                              <div id="mensaje_nombre_tarifa" class="errores"></div>
                                        </div>
                            		  </div>
                            		     <div class="col-xs-12 col-md-2 col-md-2 ">
                            		    <div class="form-group">
                                                              <label for="valor_tarifa" class="control-label">Valor Tarifas</label>
                                                               <input type="text" class="form-control cantidades1" id="valor_tarifa" name="valor_tarifa" value='0.00' 
                                                               data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                              <div id="mensaje_valor_tarifa" class="errores"></div>
                                        </div>
                            		  </div>
                            		  
                            		  
                             	  
                            		  
                        			</div>	
                	        		            
                		            
                		     <?php } ?>
                		        
                           		<div class="row">
                    			    <div class="col-xs-12 col-md-4 col-md-4 " style="margin-top:15px;  text-align: center; ">
 		                	   		    <div class="form-group">
                    	                  <button type="submit" id="Guardar" name="Guardar" class="btn btn-success">Guardar</button>
        	    	                    </div>
            	        		    </div>
                    		    </div>
 
                       </form>
                      
                  </div>
                </div>
              </div>
		
  
  
        <!-- /page content -->
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LISTADO<small>Tarifas</small></h2>
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
                          <th>#</th>
                          <th>Nombre Tarifas</th>
                          <th>Valor Tarifas</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php $i=0;?>
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
    						<?php $i++;?>
            	        		<tr>
            	                   <td > <?php echo $i; ?>  </td>
            		               <td > <?php echo $res->nombre_tarifa; ?>     </td> 
            		                <td > <?php echo $res->valor_tarifa; ?>     </td> 
            		               <td>
            			           		<div class="right">
            			                    <a href="<?php echo $helper->url("Tarifas","index"); ?>&id_tarifas=<?php echo $res->id_tarifas; ?>" class="btn btn-warning" style="font-size:65%;"><i class='glyphicon glyphicon-edit'></i></a>
            			                </div>
            			            
            			             </td>
            			             <td>   
            			                	<div class="right">
            			                    <a href="<?php echo $helper->url("Tarifas","borrarId"); ?>&id_tarifas=<?php echo $res->id_tarifas; ?>" class="btn btn-danger" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a>
            			                </div>
            			              
            		               </td>
            		    		</tr>
            		        <?php } } ?>
                    
                    </tbody>
                    </table>
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
            
  </body>
</html>   




