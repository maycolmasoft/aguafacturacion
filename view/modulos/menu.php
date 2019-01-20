
<?php 


$controladores=$_SESSION['controladores'];
 function getcontrolador($controlador,$controladores){
 	$display="display:none";
 	
 	if (!empty($controladores))
 	{
 	foreach ($controladores as $res)
 	{
 		if($res->nombre_controladores==$controlador)
 		{
 			$display= "display:block";
 			break;
 			
 		}
 	}
 	}
 	
 	return $display;
 }
 

?>





<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li  style="<?php echo getcontrolador("MenuAdministracion",$controladores) ?>"  ><a    ><i class="fa fa-users"></i> Administración <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li style="<?php echo getcontrolador("Usuarios",$controladores) ?>"><a href="index.php?controller=Usuarios&action=index">Usuarios</a></li>
                      <li style="<?php echo getcontrolador("Controladores",$controladores) ?>"><a href="index.php?controller=Controladores&action=index">Controladores</a></li>
                      <li style="<?php echo getcontrolador("Roles",$controladores) ?>"><a href="index.php?controller=Roles&action=index">Roles de Usuario</a></li>
                      <li style="<?php echo getcontrolador("PermisosRoles",$controladores) ?>"><a href="index.php?controller=PermisosRoles&action=index">Permisos Roles</a></li>
                       
                    </ul>
                  </li>
                  
                  
                  <li  style="<?php echo getcontrolador("MenuMantenimiento",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Mantenimiento <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                    	<li style="<?php echo getcontrolador("Clientes",$controladores) ?>"><a href="index.php?controller=Clientes&action=index">Clientes</a></li>
                        <li style="<?php echo getcontrolador("Tarifas",$controladores) ?>"><a href="index.php?controller=Tarifas&action=index">Tarifas</a></li>
                        <li style="<?php echo getcontrolador("TipoConsumo",$controladores) ?>"><a href="index.php?controller=TipoConsumo&action=index">Tipo Consumo</a></li>
                        <li style="<?php echo getcontrolador("TipoPersona",$controladores) ?>"><a href="index.php?controller=TipoPersona&action=index">Tipo Persona</a></li>
                      
                    </ul>
                  </li>
                  
                  
                  
                  <li  style="<?php echo getcontrolador("MenuProcesos",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Procesos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                        <li style="<?php echo getcontrolador("Solicitudes",$controladores) ?>"><a href="index.php?controller=Solicitudes&action=index">Generar Solicitud</a></li>
                        <li style="<?php echo getcontrolador("ConsultaSolicitudes",$controladores) ?>"><a href="index.php?controller=ConsultaSolicitudes&action=index">Consulta Solicitud</a></li>
                        <li style="<?php echo getcontrolador("AsignarMedidores",$controladores) ?>"><a href="index.php?controller=AsignacionClientesMedidorAgua&action=index">Asignar Medidor Agua Clientes</a></li>
                        <li style="<?php echo getcontrolador("RegistrarMarcacionesMensuales",$controladores) ?>"><a href="index.php?controller=MarcacionesMensualesMedidorAgua&action=index">Registrar Marcaciones Mensuales</a></li>
                        <li style="<?php echo getcontrolador("Facturar",$controladores) ?>"><a href="index.php?controller=Facturar&action=index">Facturar</a></li>
                    
                    </ul>
                  </li>
                  
                  
                  
                  <li  style="<?php echo getcontrolador("MenuSecretaria",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Secretaria <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                    	<li style="<?php echo getcontrolador("Clientes",$controladores) ?>"><a href="index.php?controller=Clientes&action=index">Clientes</a></li>
                        <li style="<?php echo getcontrolador("Solicitudes",$controladores) ?>"><a href="index.php?controller=Solicitudes&action=index">Generar Solicitud</a></li>
                     
                    </ul>
                  </li>
                  
                  
                   <li  style="<?php echo getcontrolador("MenuCajero",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Cajero <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                      <li style="<?php echo getcontrolador("Clientes",$controladores) ?>"><a href="index.php?controller=Clientes&action=index">Clientes</a></li>
                      <li style="<?php echo getcontrolador("Facturar",$controladores) ?>"><a href="index.php?controller=Facturar&action=index">Facturar</a></li>
                    
                      </ul>
                  </li>
                  
                   <li  style="<?php echo getcontrolador("MenuSupervisor",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Supervisor <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                    <li style="<?php echo getcontrolador("Clientes",$controladores) ?>"><a href="index.php?controller=Clientes&action=index">Clientes</a></li>
                    <li style="<?php echo getcontrolador("ConsultaSolicitudes",$controladores) ?>"><a href="index.php?controller=ConsultaSolicitudes&action=index">Consulta Solicitud</a></li>
                      
                      </ul>
                  </li>
                  
                  
                   <li  style="<?php echo getcontrolador("MenuTecnico",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Técnico <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                     <li style="<?php echo getcontrolador("AsignarMedidores",$controladores) ?>"><a href="index.php?controller=AsignacionClientesMedidorAgua&action=index">Asignar Medidor Agua Clientes</a></li>
                     <li style="<?php echo getcontrolador("RegistrarMarcacionesMensuales",$controladores) ?>"><a href="index.php?controller=MarcacionesMensualesMedidorAgua&action=index">Registrar Marcaciones Mensuales</a></li>
                      
                      </ul>
                  </li>
                  
                  <li  style="<?php echo getcontrolador("MenuReportes",$controladores) ?>"  ><a    ><i class="fa fa-bars"></i> Reportes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                    
                        <li style="<?php echo getcontrolador("Sesiones",$controladores) ?>"><a href="index.php?controller=Sesiones&action=index">Sesiones</a></li>
                        <li style="<?php echo getcontrolador("ReportesSolicitudes",$controladores) ?>"><a href="index.php?controller=ReportesSolicitudes&action=index">Solicitudes</a></li>
                        <li style="<?php echo getcontrolador("ReportesFacturas",$controladores) ?>"><a href="index.php?controller=ReportesFacturas&action=index">Facturas</a></li>
                        <li style="<?php echo getcontrolador("Geoposicionamiento",$controladores) ?>"><a href="index.php?controller=Geoposicionamiento&action=index">Geoposicionar Clientes</a></li>
                       
                     
                      </ul>
                  </li>
                  
                  
                  
                  
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              
              
              <a data-toggle="tooltip" data-placement="top" title="Salir" href="index.php?controller=Usuarios&action=Loguear">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
