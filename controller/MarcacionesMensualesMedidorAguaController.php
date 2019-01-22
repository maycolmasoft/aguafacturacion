<?php
class MarcacionesMensualesMedidorAguaController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function consultar_registros(){
    
    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	
    	$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
    		
    	$where_to="";
    	$columnas = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua, 
					  marcaciones_mensuales_medidor_agua.id_medidores_agua, 
					  medidores_agua.identificador_medidores_agua, 
					  marcaciones_mensuales_medidor_agua.id_clientes, 
					  clientes.razon_social_clientes, 
					  clientes.fecha_nacimiento_clientes, 
					  clientes.id_tipo_identificacion, 
					  tipo_identificacion.nombre_tipo_identificacion, 
					  clientes.identificacion_clientes, 
					  clientes.id_paises, 
					  paises.nombre_paises, 
					  clientes.id_provincias, 
					  provincias.nombre_provincias, 
					  clientes.id_cantones, 
					  cantones.nombre_cantones, 
					  clientes.id_parroquias, 
					  parroquias.nombre_parroquias, 
					  clientes.direccion_clientes, 
					  clientes.celular_clientes, 
					  clientes.telefono_clientes, 
					  clientes.correo_clientes, 
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_inicial, 
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_final, 
					  marcaciones_mensuales_medidor_agua.fecha_pago_mensual_correspondiente, 
					  marcaciones_mensuales_medidor_agua.valor_pago_mensual_correspondiente, 
					  marcaciones_mensuales_medidor_agua.id_usuarios_registra, 
					  marcaciones_mensuales_medidor_agua.id_estado, 
					  estado.nombre_estado_pago_marcaciones_mensuales, 
					  marcaciones_mensuales_medidor_agua.tipo_registro, 
					  marcaciones_mensuales_medidor_agua.creado";
    	
    	$tablas   = "public.marcaciones_mensuales_medidor_agua, 
					  public.clientes, 
					  public.medidores_agua, 
					  public.estado, 
					  public.tipo_identificacion, 
					  public.paises, 
					  public.provincias, 
					  public.cantones, 
					  public.parroquias";
    	
    	$id       = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua";
    	
    	
    	$where    = "marcaciones_mensuales_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND
					  marcaciones_mensuales_medidor_agua.id_clientes = clientes.id_clientes AND
					  marcaciones_mensuales_medidor_agua.id_estado = estado.id_estado AND
					  clientes.id_cantones = cantones.id_cantones AND
					  tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND
					  paises.id_paises = clientes.id_paises AND
					  provincias.id_provincias = clientes.id_provincias AND
					  parroquias.id_parroquias = clientes.id_parroquias";
    	
    
    	 
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	 
    	 
    	 
    	 
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%'  OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%' OR estado.nombre_estado_pago_marcaciones_mensuales LIKE '".$search."%' OR  medidores_agua.identificador_medidores_agua LIKE '%".$search."%')";
    
    			$where_to=$where.$where1;
    		}else{
    
    			$where_to=$where;
    
    		}
    
    		$html="";
    		$resultSet=$marcaciones_mensuales->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    
    		$per_page = 50; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    
    		$resultSet=$marcaciones_mensuales->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
    		$count_query   = $cantidadResult;
    		$total_pages = ceil($cantidadResult/$per_page);
    
    		 
    
    
    
    		if($cantidadResult>0)
    		{
    
    			$html.='<div class="pull-left" style="margin-left:11px;">';
    			$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    			$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
    			$html.='</div>';
    			$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
    			$html.='<section style="height:425px; overflow-y:scroll;">';
    			$html.= "<table id='tabla_marcaciones' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;">Medidor</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Identificación</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Marc. Ini</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Mar. Fin</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Corres.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Valor a Pagar</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado Pago</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    			 
    			$html.='</tr>';
    			$html.='</thead>';
    			$html.='<tbody>';
    			 
    			$i=0;
    
    
    
    			foreach ($resultSet as $res)
    			{
    				$i++;
    				$html.='<tr>';
    				$html.='<td style="font-size: 11px;">'.$res->identificador_medidores_agua.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_inicial.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_final.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_pago_mensual_correspondiente.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->valor_pago_mensual_correspondiente.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_estado_pago_marcaciones_mensuales.'</td>';
    				
    				if($res->id_estado==1){
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" title="Editar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" title="Eliminar" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
    				 
    				}else{
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=MarcacionesMensualesMedidorAgua&action=index&id_marcaciones_mensuales_medidor_agua='.$res->id_marcaciones_mensuales_medidor_agua.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=MarcacionesMensualesMedidorAgua&action=borrarId&id_marcaciones_mensuales_medidor_agua='.$res->id_marcaciones_mensuales_medidor_agua.'" class="btn btn-danger" style="font-size:65%;" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
    				 
    				}
    				
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_consultar_registros("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay marcaciones registradas...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    
    	}
    
    
    }
    
    
    
    
    
    
    
    public function consulta_bitacora_validacion(){
        
        session_start();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        
       
        
        $errores = new ErroresImportacionModel();
        
        $where_to="";
        $columnas = "errores_importacion_marcaciones_masivas.id_errores_importacion_marcaciones_masivas, 
                      errores_importacion_marcaciones_masivas.linea_errores_importacion_marcaciones_masivas, 
                      errores_importacion_marcaciones_masivas.errores_encontrados_importacion_marcaciones_masivas, 
                      errores_importacion_marcaciones_masivas.id_usuarios_registra_carga, 
                      errores_importacion_marcaciones_masivas.creado, 
                      errores_importacion_marcaciones_masivas.modificado";
        
        $tablas   = "public.errores_importacion_marcaciones_masivas";
        
        $id       = "errores_importacion_marcaciones_masivas.id_errores_importacion_marcaciones_masivas";
        
        
        $where    = "errores_importacion_marcaciones_masivas.id_usuarios_registra_carga='$id_usuarios'";
        
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
        
        
        
        
        if($action == 'ajax')
        {
            
            if(!empty($search)){
                
                
                $where1=" AND (errores_importacion_marcaciones_masivas.errores_encontrados_importacion_marcaciones_masivas LIKE '".$search."%')";
                
                $where_to=$where.$where1;
            }else{
                
                $where_to=$where;
                
            }
            
            $html="";
            $resultSet=$errores->getCantidad("*", $tablas, $where_to);
            
           
            
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 50; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$errores->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
            $count_query   = $cantidadResult;
            $total_pages = ceil($cantidadResult/$per_page);
            
            
         
            
            if($cantidadResult>0)
            {
                
                $html.='<div class="pull-left" style="margin-left:11px;">';
                $html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
                $html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
                $html.='</div>';
                $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
                $html.='<section style="height:425px; overflow-y:scroll;">';
                $html.= "<table id='tabla_bitacora_validacion' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
                $html.= "<thead>";
                $html.= "<tr>";
            
                $html.='<th style="text-align: left;  font-size: 12px;">Línea</th>';
                $html.='<th style="text-align: left;  font-size: 12px;">Descripción</th>';
                $html.='<th style="text-align: left;  font-size: 12px;">Fecha Registro.</th>';
                
                $html.='</tr>';
                $html.='</thead>';
                $html.='<tbody>';
                
                $i=0;
                
                
                
                foreach ($resultSet as $res)
                {
                    $i++;
                    $html.='<tr>';
             
                    $html.='<td style="font-size: 11px;">'.$res->linea_errores_importacion_marcaciones_masivas.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->errores_encontrados_importacion_marcaciones_masivas.'</td>';
                    $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
                   
                    $html.='</tr>';
                }
                
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_bitacora_validacion("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay errores en tu carga masiva...</b>';
                $html.='</div>';
                $html.='</div>';
            }
            
            
            echo $html;
            die();
            
        }
        
        
    }
    
    
    
    
    
    
    
    
    public function  index11(){
    	


    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$clientes = new ClientesModel();
    	$where_to="";
    	$columnas = "clientes.id_clientes,
									  clientes.apellidos_clientes,
									  clientes.nombres_clientes,
									  clientes.id_tipo_identificacion,
									  tipo_identificacion.nombre_tipo_identificacion,
									  clientes.identificacion_clientes,
									  clientes.id_sexo,
									  sexo.nombre_sexo,
									  clientes.id_paises,
									  clientes.id_provincias,
									  provincias.nombre_provincias,
									  clientes.id_cantones,
									  cantones.nombre_cantones,
									  clientes.id_parroquias,
									  parroquias.nombre_parroquias,
									  clientes.direccion_clientes,
									  clientes.telefono_clientes,
									  clientes.celular_clientes,
									  clientes.correo_clientes,
    			                      clientes.id_estado,
    			                      estado.nombre_estado";
    	 
    	$tablas   = "public.clientes,
									  public.cantones,
									  public.provincias,
									  public.parroquias,
									  public.sexo,
									  public.tipo_identificacion,
    			public.estado";
    	 
    	$id       = "clientes.id_clientes";
    	 
    	 
    	$where    = "estado.id_estado=clientes.id_estado AND clientes.id_provincias = provincias.id_provincias AND
    	cantones.id_cantones = clientes.id_cantones AND
    	parroquias.id_parroquias = clientes.id_parroquias AND
    	sexo.id_sexo = clientes.id_sexo AND
    	tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND clientes.id_estado=2";
    	 
    	
    	
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	
    	
    	
    	
    	if($action == 'ajax')
    	{
    	
    		if(!empty($search)){
    	
    	
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.apellidos_clientes LIKE '".$search."%' OR clientes.nombres_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR sexo.nombre_sexo LIKE '".$search."%' OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%' OR estado.nombre_estado LIKE '".$search."%')";
    	
    			$where_to=$where.$where1;
    		}else{
    	
    			$where_to=$where;
    	
    		}
    	
    		$html="";
    		$resultSet=$clientes->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    	
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    	
    		$per_page = 50; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    	
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    	
    		$resultSet=$clientes->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
    		$count_query   = $cantidadResult;
    		$total_pages = ceil($cantidadResult/$per_page);
    	
    		 
    	
    	
    	
    		if($cantidadResult>0)
    		{
    	
    			$html.='<div class="pull-left" style="margin-left:11px;">';
    			$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    			$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
    			$html.='</div>';
    			$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
    			$html.='<section style="height:425px; overflow-y:scroll;">';
    			$html.= "<table id='tabla_clientes' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Identificación</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Apellidos</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Nombres</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Teléfono</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Provincia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Cantón</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Parroquia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    	
    			if($id_rol==1){
    					
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				
    					
    			}else{
    					
    					
    	
    			}
    	
    			$html.='</tr>';
    			$html.='</thead>';
    			$html.='<tbody>';
    	
    			$i=0;
    	
    	
    	
    			foreach ($resultSet as $res)
    			{
    				$i++;
    				$html.='<tr>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->apellidos_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombres_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->correo_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->telefono_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->celular_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_provincias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_cantones.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_parroquias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_estado.'</td>';
    					
    				if($id_rol==1){
    	
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					
    	
    				}else{
    	
    	
    				}
    					
    				$html.='</tr>';
    			}
    	
    	
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_clientes_inactivos("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    	
    	
    	
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay clientes inactivos registrados...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    	
    	}
    	
    	
    	
    	
    }
    
    
  
    
		public function index(){
	
		session_start();
		if (isset(  $_SESSION['id_usuarios']) )
		{
		
			
			
			
			$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
			$resultMar1= $marcaciones_mensuales->getBy("id_estado=2");
			
			if(!empty($resultMar1)){
				
				$total_mora=0;
				$total_mora_registrar=0;
					
				$taza_mora=0.03;
				$fecha_actual = date('Y-m-d');
				
				
				
				foreach ($resultMar1 as $res){
					
					$id_marcaciones_mensuales_medidor_agua=$res->id_marcaciones_mensuales_medidor_agua;
					$fecha_maxima_pago=date("Y-m-d", strtotime($res->fecha_maxima_pago));
		    		$valor_pago_mensual_correspondiente=$res->valor_pago_mensual_correspondiente;
					
		    		
		    		
					if($fecha_maxima_pago < $fecha_actual){
						
						
						
						$diff = abs(strtotime($fecha_maxima_pago) - strtotime($fecha_actual));
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						$days = $days-1;
							
						
						$total_mora=$valor_pago_mensual_correspondiente*$taza_mora;
						$total_mora_registrar=$total_mora*$days;
						
						$marcaciones_mensuales->UpdateBy("valor_mora='$total_mora_registrar'","marcaciones_mensuales_medidor_agua","id_marcaciones_mensuales_medidor_agua='$id_marcaciones_mensuales_medidor_agua'");
							
						
					}
					$total_mora=0;
					$total_mora_registrar=0;
					
				}
				
				
			}
			
			
			
			
			
			
			$nombre_controladores = "RegistrarMarcacionesMensuales";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $marcaciones_mensuales->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
					$resultEdit = "";
					$resultEditAsig= "";
			
					if (isset ($_GET["id_marcaciones_mensuales_medidor_agua"])   )
					{
						$_id_marcaciones_mensuales_medidor_agua = $_GET["id_marcaciones_mensuales_medidor_agua"];
						
						$columnas = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua,
					  marcaciones_mensuales_medidor_agua.id_medidores_agua,
					  medidores_agua.identificador_medidores_agua,
					  marcaciones_mensuales_medidor_agua.id_clientes,
					  clientes.razon_social_clientes,
					  clientes.id_tipo_identificacion,
					  tipo_identificacion.nombre_tipo_identificacion,
					  clientes.identificacion_clientes,
					  clientes.id_paises,
					  paises.nombre_paises,
					  clientes.id_provincias,
					  provincias.nombre_provincias,
					  clientes.id_cantones,
					  cantones.nombre_cantones,
					  clientes.id_parroquias,
					  parroquias.nombre_parroquias,
					  clientes.direccion_clientes,
					  clientes.celular_clientes,
					  clientes.telefono_clientes,
					  clientes.correo_clientes,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_inicial,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_final,
					  marcaciones_mensuales_medidor_agua.fecha_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.valor_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.id_usuarios_registra,
					  marcaciones_mensuales_medidor_agua.id_estado,
					  estado.nombre_estado_pago_marcaciones_mensuales,
					  marcaciones_mensuales_medidor_agua.tipo_registro,
					  marcaciones_mensuales_medidor_agua.creado";
						 
						$tablas   = "public.marcaciones_mensuales_medidor_agua,
					  public.clientes,
					  public.medidores_agua,
					  public.estado,
					  public.tipo_identificacion,
					  public.paises,
					  public.provincias,
					  public.cantones,
					  public.parroquias";
						 
						$id       = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua";
						 
						 
						$where    = "marcaciones_mensuales_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND
					  marcaciones_mensuales_medidor_agua.id_clientes = clientes.id_clientes AND
					  marcaciones_mensuales_medidor_agua.id_estado = estado.id_estado AND
					  clientes.id_cantones = cantones.id_cantones AND
					  tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND
					  paises.id_paises = clientes.id_paises AND
					  provincias.id_provincias = clientes.id_provincias AND
					  parroquias.id_parroquias = clientes.id_parroquias AND marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua='$_id_marcaciones_mensuales_medidor_agua'";
						 
						
						
						$resultEdit = $marcaciones_mensuales->getCondiciones($columnas ,$tablas ,$where, $id); 
					}
			
					
					$this->view("MarcacionesMensualesMedidorAgua",array(
							"resultEdit" =>$resultEdit, "resultEditAsig"=>$resultEditAsig
					
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Registrar Marcaciones."
			
				));
			
			}
			
		
		}
		else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
		
	}
	
	
	
	
	
	
	
	
	public function InsertaMarcacionesManuales(){
			
		session_start();
		$resultado = null;
		$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
			
		$_clave_usuario = "";
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
		if (isset ($_POST["id_medidores_agua"]))
		{
			$_id_medidores_agua    = $_POST["id_medidores_agua"];
			$_id_clientes            = $_POST["id_clientes"];
		    $_id_marcaciones_mensuales_medidor_agua   = $_POST["id_marcaciones_mensuales_medidor_agua"];
		    
		    $_fecha_pago_mensual_correspondiente   = $_POST["fecha_pago_mensual_correspondiente"];
		    $_marcacion_mensual_inicial   = $_POST["marcacion_mensual_inicial"];
		    $_marcacion_mensual_final   = $_POST["marcacion_mensual_final"];
		    $_tipo_registro   = $_POST["tipo_registro"];
		    
		    
		    $_fecha_maxima_pago = strtotime ( '+15 day' , strtotime ($_fecha_pago_mensual_correspondiente) ) ;
		    $_fecha_maxima_pago = date ( 'Y-m-j' , $_fecha_maxima_pago );
		    
		    
		    
		    $_id_usuarios= $_SESSION['id_usuarios'];

		    
		    $valor_mora=0;
		    $var_alca=0;

		    $mar_inicial=0;
		    $mar_final=0;
		    $agua_metros_cubicos=0;
		    
		    $tarifa_basica=0;
		    $tarifa_adicional=0;
		    $alcantarillado='NO';
		    

		    $solicitudes = new SolicitudesModel();
		    $resultTipoConsumo= $solicitudes->getBy("id_clientes='$_id_clientes'");
		    $id_tipo_consumo=$resultTipoConsumo[0]->id_tipo_consumo;
		     
		     
		    $clientes = new ClientesModel();
		    $resultClientes= $clientes->getBy("id_clientes='$_id_clientes'");
		    $fecha_nacimiento=date("Y-m-d", strtotime($resultClientes[0]->fecha_nacimiento_clientes));
		    $id_tipo_persona=$resultClientes[0]->id_tipo_persona;
		    $discapacidad_clientes=$resultClientes[0]->discapacidad_clientes;
		    
		    
		    $solicitudes_detalle = new SolicitudesDetalleModel();
		    $columnas1="tarifas.nombre_tarifa";
		    $tablas1="public.tarifas, 
  					public.solicitudes_detalle";
		    $where1="solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND tarifas.nombre_tarifa like '%ALCANTARILLADO%' AND solicitudes_detalle.id_clientes='$_id_clientes'";
		    $id1="tarifas.nombre_tarifa";
		    $resultAlcantarillado= $solicitudes_detalle->getCondiciones($columnas1, $tablas1, $where1, $id1);
		    
		    if(!empty($resultAlcantarillado)){
		    	$alcantarillado="SI";
		    
		    }
		    
		    
		    
		    $total=0;
		    $descuento_mayor_edad=0;
		    $descuento_discapacidad=0;
		    $descuento_x_tener_alcantarillado=0;
		    $total_des=0;
		    $total_des1=0;
		    $total_registrar=0;
		    
		    $cargo_fijo_por_conexion=0;
		    $mar_inicial = ltrim($_marcacion_mensual_inicial,"0");
		    $mar_final = ltrim($_marcacion_mensual_final,"0");
		    
		    
		    if($mar_inicial==""){
		    	 
		    	$mar_inicial=0;
		    }
		    if($mar_final==""){
		    	$mar_final=0;
		    }
		    
		    $agua_metros_cubicos=$mar_final-$mar_inicial;
		    
		    
		    

		    if($id_tipo_consumo>0){
		    
		    
		    	/// VALIDACIÓN PARA DOMESTICO
		    	 
		    	if($id_tipo_consumo==1){
		    
		    
		    		if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
		    			 
		    			$tarifa_basica=0;
		    			$tarifa_adicional=0.31;
		    			 
		    		}
		    
		    		if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
		    
		    			$tarifa_basica=3.41;
		    			$tarifa_adicional=0.43;
		    
		    		}
		    
		    
		    		if($agua_metros_cubicos >18){
		    
		    			$tarifa_basica=6.42;
		    			$tarifa_adicional=0.72;
		    
		    		}
		    
		    
		    
		    
		    	}
		    
		    
		    	 
		    	 
		    	/// VALIDACIÓN PARA COMERCIAL
		    
		    	if($id_tipo_consumo==2){
		    		 
		    		 
		    		if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
		    
		    			$tarifa_basica=0;
		    			$tarifa_adicional=0.72;
		    
		    		}
		    		 
		    		if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
		    		  
		    			$tarifa_basica=3.41;
		    			$tarifa_adicional=0.72;
		    		  
		    		}
		    		 
		    		 
		    		if($agua_metros_cubicos >18){
		    		  
		    			$tarifa_basica=6.42;
		    			$tarifa_adicional=0.72;
		    		  
		    		}
		    		 
		    
		    
		    
		    
		    	}
		    	 
		    	 
		    	/// VALIDACÓN PARA INSDUSTRIAL
		    	 
		    	if($id_tipo_consumo==3){
		    		 
		    		 
		    		if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
		    		  
		    			$tarifa_basica=0;
		    			$tarifa_adicional=0.72;
		    		  
		    		}
		    		 
		    		if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
		    
		    			$tarifa_basica=3.41;
		    			$tarifa_adicional=0.72;
		    
		    		}
		    		 
		    		 
		    		if($agua_metros_cubicos >18){
		    
		    			$tarifa_basica=6.42;
		    			$tarifa_adicional=0.72;
		    
		    		}
		    		 
		    		 
		    	}
		    	 
		    	$total=$cargo_fijo_por_conexion+$tarifa_basica+$tarifa_adicional;
		    	 
		    	 
		    	if($id_tipo_persona==1){
		    		 
		    		$date2 = date('Y-m-d');//
		    		$diff = abs(strtotime($date2) - strtotime($fecha_nacimiento));
		    		$years = floor($diff / (365*60*60*24));
		    		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		    		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		    		 
		    		
		    		if($years > 65){
		    
		    			if($agua_metros_cubicos <=20 ){
		    				 
		    				$descuento_mayor_edad=$total*0.5;
		    				 
		    			}
		    		}
		    		 
		    		$totaldes1=$total-$descuento_mayor_edad;
		    		 
		    		if($discapacidad_clientes == 't'){
		    		  
		    			if($agua_metros_cubicos <=10 ){
		    				 
		    				
		    				
		    				$descuento_discapacidad=$totaldes1*0.5;
		    				
		    			}
		    		}
		    		 
		    		 
		    	}
		    	
		    	if($id_tipo_persona==2){
		    		$totaldes1=$total-$descuento_mayor_edad;
		    	}
		    	 
		    	$total_des=$totaldes1-$descuento_discapacidad;
		    	 
		    	 
		    	if($alcantarillado=="SI"){
		    		 $var_alca=1.32;
		    		$descuento_x_tener_alcantarillado=$total_des*0.386;
		    		$total_des=$descuento_x_tener_alcantarillado+$var_alca;
		    	}
		    	$total_administracion=2.10;
		    	$total_registrar=$total_des;
		    	$total_registrar=$total_registrar+$total_administracion;
		    	 
		    	 
		    	 
		    }
		     
		    
		    
		    if($_id_marcaciones_mensuales_medidor_agua > 0){
		    	
		    	
		    	
		    	
		    		$colval = "marcacion_mensual_final='$_marcacion_mensual_final', 
		    		valor_pago_mensual_correspondiente='$total_registrar',
		    		fecha_maxima_pago='$_fecha_maxima_pago', descuento_por_mayor_edad='$descuento_mayor_edad',
		    		descuento_discapacidad='$descuento_discapacidad',
		    		descuento_alcatarillado='$descuento_x_tener_alcantarillado',
		    		valor_mora='$valor_mora',
		    		consumo_metros_cubicos='$agua_metros_cubicos',
		    		valor_consumo_agua='$total',
		    		valor_fijo_administracion='$total_administracion',
		    		valor_fijo_alcantarillado='$var_alca'";
		    		
		    		
		    		$tabla = "marcaciones_mensuales_medidor_agua";
		    		$where = "id_marcaciones_mensuales_medidor_agua = '$_id_marcaciones_mensuales_medidor_agua'";
		    		$resultado=$marcaciones_mensuales->UpdateBy($colval, $tabla, $where);
		    	
		    		
		    	
		    }else{
		    
		    
		    	
		        	$funcion = "ins_marcaciones_mensuales_medidor_agua";
		        	$parametros = "'$_id_medidores_agua',
		        	'$_id_clientes',
		        	'$_marcacion_mensual_inicial',
		        	'$_marcacion_mensual_final',
		        	'$_fecha_pago_mensual_correspondiente',
		        	'$total_registrar',
		        	'$_id_usuarios',
		        	'$_tipo_registro',
		        	'$_fecha_maxima_pago',
		        	'$descuento_mayor_edad',
		        	'$descuento_discapacidad',
		        	'$descuento_x_tener_alcantarillado',
		        	'$valor_mora',
		        	'$agua_metros_cubicos',
		        	'$total',
		        	'$total_administracion',
		        	'$var_alca'";
		        	$marcaciones_mensuales->setFuncion($funcion);
		        	$marcaciones_mensuales->setParametros($parametros);
		        	$resultado=$marcaciones_mensuales->Insert();
		        	
		        	
		 	 	
		  }
		  
		   
		    $this->redirect("MarcacionesMensualesMedidorAgua", "index");
		}
		
	   }else{
	   	
	   	$error = TRUE;
	   	$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	   		
	   	$this->view("Login",array(
	   			"resultSet"=>"$mensaje", "error"=>$error
	   	));
	   		
	   		
	   	die();
	   	
	   }
	}
	
	
	

	public function InsertaMarcacionesnMasivas(){

		session_start();
		$resultado = null;
		$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
		$errores_importacion = new ErroresImportacionModel();
			
		$asignacion_clientes_medidor_agua = new AsignacionClientesMedidorAguaModel();
		$medidores_agua = new MedidoresAguaModel();
		
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			
			$marcacion_mensual_final_base_datos="00000";
		
			if (isset ($_POST["tipo_registro_masiva"]))
			{
				$_tipo_registro   = $_POST["tipo_registro_masiva"];
				$_id_usuarios= $_SESSION['id_usuarios'];
				
				$errores_importacion->deleteBy("id_usuarios_registra_carga",$_id_usuarios);
				
				
				$directorio = $_SERVER['DOCUMENT_ROOT'].'/aguafacturacion/upload_cargas_masivas/';
				
				$nombre = $_FILES['marcaciones_masivas']['name'];
				$tipo = $_FILES['marcaciones_masivas']['type'];
				$tamano = $_FILES['marcaciones_masivas']['size'];
				move_uploaded_file($_FILES['marcaciones_masivas']['tmp_name'],$directorio.$nombre);


				$lineas = file($directorio.$nombre);
				$numero_linea=0;
				$errores=false;
				$error_encontrado="";
				
				if(!empty($lineas)){
				
				
				foreach ($lineas as $linea_num => $linea)
				{
					$numero_linea++;
					$error_encontrado="";
					$datos = explode("\t",$linea);
						
						if(count($datos) == 3 && !empty(trim($datos[0])) && !empty(trim($datos[1])) && !empty(trim($datos[2]))){
						
							$identificador_medidor              = trim($datos[0]);
							$fecha_pago_mensual_correspondiente = trim($datos[1]);
							$marcacion_mensual_final            = trim($datos[2]);
							
							
						}else{
							
							$errores=true;
						
							$error_encontrado="Esta linea no contiene el formato establecido, las columnas no estan separadas por tabulaciones.";
							
							$funcion = "ins_errores_importacion_marcaciones_masivas";
							$parametros = "'$numero_linea',
							'$error_encontrado',
							'$_id_usuarios'";
							$errores_importacion->setFuncion($funcion);
							$errores_importacion->setParametros($parametros);
							$resultado=$errores_importacion->Insert();
							
						}
					
				
				}
				
				
				
				// cuando pasa la primera validacion de verificar tabulaciones. 
				if($errores==false){
					
					$numero_linea=0;

					$identificador_medidor="";
					$fecha_pago_mensual_correspondiente="";
					$marcacion_mensual_final="";
					// AQUI VALIDAMOS QUE EL IDENTIFICADOR DEL MEDIDOR EXISTA REGISTRADO EN LA BASE DE DATOS.
					foreach ($lineas as $linea_num => $linea)
					{
						$numero_linea++;
						$error_encontrado="";
						$datos = explode("\t",$linea);
					
						if(count($datos) == 3 && !empty(trim($datos[0])) && !empty(trim($datos[1])) && !empty(trim($datos[2]))){
					
							$identificador_medidor              = trim($datos[0]);
							$fecha_pago_mensual_correspondiente = trim($datos[1]);
							$marcacion_mensual_final            = trim($datos[2]);
						
						
							$columnas="asignacion_clientes_medidor_agua.id_clientes,
									  clientes.razon_social_clientes,
									  clientes.identificacion_clientes,
									  asignacion_clientes_medidor_agua.id_medidores_agua,
									  medidores_agua.identificador_medidores_agua";
							
							$tablas ="public.medidores_agua,
									  public.clientes,
									  public.asignacion_clientes_medidor_agua";
							
							$where ="asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
							         asignacion_clientes_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND medidores_agua.identificador_medidores_agua= '$identificador_medidor'";
							
							$id="asignacion_clientes_medidor_agua.id_medidores_agua";
							
							$resultMedCli=$asignacion_clientes_medidor_agua->getCondiciones($columnas,$tablas,$where,$id);
							
							
							if(!empty($resultMedCli)){
								
								
								
							}else{
								
								$errores=true;
								
								$error_encontrado="El medidor de agua identificado por $identificador_medidor no existe registrado en la base de datos.";
									
								$funcion = "ins_errores_importacion_marcaciones_masivas";
								$parametros = "'$numero_linea',
								'$error_encontrado',
								'$_id_usuarios'";
								$errores_importacion->setFuncion($funcion);
								$errores_importacion->setParametros($parametros);
								$resultado=$errores_importacion->Insert();
								
							}
							
							
							$valores = explode('/', $fecha_pago_mensual_correspondiente);
							
							if(count($valores) == 3){
								
							}else{
								
								$errores=true;
								
								$error_encontrado="La fecha $fecha_pago_mensual_correspondiente debe contener el formato YYYY/MM/DD. Separada por (/)";
									
								$funcion = "ins_errores_importacion_marcaciones_masivas";
								$parametros = "'$numero_linea',
								'$error_encontrado',
								'$_id_usuarios'";
								$errores_importacion->setFuncion($funcion);
								$errores_importacion->setParametros($parametros);
								$resultado=$errores_importacion->Insert();
							}
							
							
							
							if(checkdate($valores[1], $valores[2], $valores[0])){
							
							}else{
							
								$errores=true;
							
								$error_encontrado="La fecha $fecha_pago_mensual_correspondiente no existe en el calendario.";
									
								$funcion = "ins_errores_importacion_marcaciones_masivas";
								$parametros = "'$numero_linea',
								'$error_encontrado',
								'$_id_usuarios'";
								$errores_importacion->setFuncion($funcion);
								$errores_importacion->setParametros($parametros);
								$resultado=$errores_importacion->Insert();
							}
							
							
							
							if(!is_numeric($marcacion_mensual_final)){
								
								$errores=true;
								
								$error_encontrado="La marcación final $marcacion_mensual_final debe ser solo numeros.";
									
								$funcion = "ins_errores_importacion_marcaciones_masivas";
								$parametros = "'$numero_linea',
								'$error_encontrado',
								'$_id_usuarios'";
								$errores_importacion->setFuncion($funcion);
								$errores_importacion->setParametros($parametros);
								$resultado=$errores_importacion->Insert();
								
							}else{
								
								
								if(strlen($marcacion_mensual_final)==5){
									
								}else{
									
									
									$errores=true;
									
									$error_encontrado="La marcación final $marcacion_mensual_final debe estar compuesta de 5 Digistos.";
										
									$funcion = "ins_errores_importacion_marcaciones_masivas";
									$parametros = "'$numero_linea',
									'$error_encontrado',
									'$_id_usuarios'";
									$errores_importacion->setFuncion($funcion);
									$errores_importacion->setParametros($parametros);
									$resultado=$errores_importacion->Insert();
									
								}
								
								
								
							}
							
							
							
							
						}else{
							
							$errores=true;
						
							$error_encontrado="Esta linea no contiene el formato establecido, las columnas no estan separadas por tabulaciones.";
							
							$funcion = "ins_errores_importacion_marcaciones_masivas";
							$parametros = "'$numero_linea',
							'$error_encontrado',
							'$_id_usuarios'";
							$errores_importacion->setFuncion($funcion);
							$errores_importacion->setParametros($parametros);
							$resultado=$errores_importacion->Insert();
							
						}
					}
					
					
					
				}
				
				
				
				
				
				
				// terinar validacion de fechas
				if($errores==false){
						
					$numero_linea=0;
					$identificador_medidor="";
					$fecha_pago_mensual_correspondiente="";
					$marcacion_mensual_final="";
					// AQUI VALIDAMOS QUE EL IDENTIFICADOR DEL MEDIDOR EXISTA REGISTRADO EN LA BASE DE DATOS.
					foreach ($lineas as $linea_num => $linea)
					{
						$numero_linea++;
						$error_encontrado="";
						$datos = explode("\t",$linea);
							
				
						if(count($datos) == 3 && !empty(trim($datos[0])) && !empty(trim($datos[1])) && !empty(trim($datos[2]))){
				
							$identificador_medidor              = trim($datos[0]);
							$fecha_pago_mensual_correspondiente = trim($datos[1]);
							$marcacion_mensual_final            = trim($datos[2]);
								
				
				

				$fecha = new DateTime($fecha_pago_mensual_correspondiente);
				$fecha->modify('last day of this month');
				$fecha_encontrada= $fecha->format('Y/m/d');
				
					
				if($fecha_pago_mensual_correspondiente==$fecha_encontrada){
						
				}else{
						
					$errores=true;
						
					$error_encontrado="El dia de la fecha $fecha_pago_mensual_correspondiente debe ser el fin de mes. Ejm ($fecha_encontrada).";
						
					$funcion = "ins_errores_importacion_marcaciones_masivas";
					$parametros = "'$numero_linea',
					'$error_encontrado',
					'$_id_usuarios'";
					$errores_importacion->setFuncion($funcion);
					$errores_importacion->setParametros($parametros);
					$resultado=$errores_importacion->Insert();
				}
					
				
						}else{
							
							$errores=true;
						
							$error_encontrado="Esta linea no contiene el formato establecido, las columnas no estan separadas por tabulaciones.";
							
							$funcion = "ins_errores_importacion_marcaciones_masivas";
							$parametros = "'$numero_linea',
							'$error_encontrado',
							'$_id_usuarios'";
							$errores_importacion->setFuncion($funcion);
							$errores_importacion->setParametros($parametros);
							$resultado=$errores_importacion->Insert();
							
						}
					}
				}
				
				
				
				
				
				
				
				
				if($errores==false){
					
					$numero_linea=0;
					$identificador_medidor="";
					$fecha_pago_mensual_correspondiente="";
					$marcacion_mensual_final="";
					// AQUI VALIDAMOS QUE EL IDENTIFICADOR DEL MEDIDOR EXISTA REGISTRADO EN LA BASE DE DATOS.
					foreach ($lineas as $linea_num => $linea)
					{
						$numero_linea++;
						$error_encontrado="";
						$datos = explode("\t",$linea);
					

						if(count($datos) == 3 && !empty(trim($datos[0])) && !empty(trim($datos[1])) && !empty(trim($datos[2]))){
								
							$identificador_medidor              = trim($datos[0]);
							$fecha_pago_mensual_correspondiente = trim($datos[1]);
							$marcacion_mensual_final            = trim($datos[2]);
						
						
							$columnas="asignacion_clientes_medidor_agua.id_clientes,
									  clientes.razon_social_clientes,
									  clientes.identificacion_clientes,
									  asignacion_clientes_medidor_agua.id_medidores_agua,
									  medidores_agua.identificador_medidores_agua";
								
							$tablas ="public.medidores_agua,
									  public.clientes,
									  public.asignacion_clientes_medidor_agua";
								
							$where ="asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
							asignacion_clientes_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND medidores_agua.identificador_medidores_agua= '$identificador_medidor'";
								
							$id="asignacion_clientes_medidor_agua.id_medidores_agua";
								
							$resultMedCli1=$asignacion_clientes_medidor_agua->getCondiciones($columnas,$tablas,$where,$id);
								
								
							if(!empty($resultMedCli1)){
						
								
								$_id_medidores_agua  =$resultMedCli1[0]->id_medidores_agua;
								
								
								$resultMar=$medidores_agua->getCondiciones("max(id_marcaciones_mensuales_medidor_agua) as id, id_medidores_agua", "marcaciones_mensuales_medidor_agua",
										"id_medidores_agua ='$_id_medidores_agua' GROUP BY id_medidores_agua", "id_medidores_agua");
								if(!empty($resultMar)){
									 
									$id_marcaciones_mensuales_medidor_agua=$resultMar[0]->id;
								
									$resultReg=$marcaciones_mensuales->getBy("id_marcaciones_mensuales_medidor_agua = '$id_marcaciones_mensuales_medidor_agua'");
									 
									if(!empty($resultReg)){
										$marcacion_mensual_final_base_datos = $resultReg[0]->marcacion_mensual_final;
										$fecha_pago_mensual_correspondiente_base_datos =  $resultReg[0]->fecha_pago_mensual_correspondiente;
								
										$mes_ver = substr($fecha_pago_mensual_correspondiente_base_datos, -5, 2);
										$mes = substr($fecha_pago_mensual_correspondiente, -5, 2);
										
										
										if($mes<=$mes_ver){
											
										//if($fecha_pago_mensual_correspondiente <= $fecha_pago_mensual_correspondiente_base_datos){
											
											$errores=true;
											
											$error_encontrado="Ya existe un registro para la fecha $fecha_pago_mensual_correspondiente del medidor de agua $identificador_medidor registrado en la base de datos.";
												
											$funcion = "ins_errores_importacion_marcaciones_masivas";
											$parametros = "'$numero_linea',
											'$error_encontrado',
											'$_id_usuarios'";
											$errores_importacion->setFuncion($funcion);
											$errores_importacion->setParametros($parametros);
											$resultado=$errores_importacion->Insert();
											
											
										}else{
											
											
											if($marcacion_mensual_final < $marcacion_mensual_final_base_datos){
												
												$errores=true;
													
												$error_encontrado="Marcación final $marcacion_mensual_final no puede ser menor a marcación inicial $marcacion_mensual_final_base_datos.";
												
												$funcion = "ins_errores_importacion_marcaciones_masivas";
												$parametros = "'$numero_linea',
												'$error_encontrado',
												'$_id_usuarios'";
												$errores_importacion->setFuncion($funcion);
												$errores_importacion->setParametros($parametros);
												$resultado=$errores_importacion->Insert();
												
											}else{
												
											}
											
											
											
											 
										}
								
									}else{
										$marcacion_mensual_final_base_datos = "00000";
										
										
										if($marcacion_mensual_final < $marcacion_mensual_final_base_datos){
										
											$errores=true;
												
											$error_encontrado="Marcación final $marcacion_mensual_final no puede ser menor a marcación inicial $marcacion_mensual_final_base_datos.";
										
											$funcion = "ins_errores_importacion_marcaciones_masivas";
											$parametros = "'$numero_linea',
											'$error_encontrado',
											'$_id_usuarios'";
											$errores_importacion->setFuncion($funcion);
											$errores_importacion->setParametros($parametros);
											$resultado=$errores_importacion->Insert();
										
										}else{
										
										}
										 
									}
								
								}else{
		      	
									$marcacion_mensual_final_base_datos = "00000";
									
									
									if($marcacion_mensual_final < $marcacion_mensual_final_base_datos){
									
										$errores=true;
									
										$error_encontrado="Marcación final $marcacion_mensual_final no puede ser menor a marcación inicial $marcacion_mensual_final_base_datos.";
									
										$funcion = "ins_errores_importacion_marcaciones_masivas";
										$parametros = "'$numero_linea',
										'$error_encontrado',
										'$_id_usuarios'";
										$errores_importacion->setFuncion($funcion);
										$errores_importacion->setParametros($parametros);
										$resultado=$errores_importacion->Insert();
									
									}else{
									
									}
						      	 
						      }
						
						
							}else{
						
								$errores=true;
						
								$error_encontrado="El medidor de agua identificado por $identificador_medidor no existe registrado en la base de datos.";
									
								$funcion = "ins_errores_importacion_marcaciones_masivas";
								$parametros = "'$numero_linea',
								'$error_encontrado',
								'$_id_usuarios'";
								$errores_importacion->setFuncion($funcion);
								$errores_importacion->setParametros($parametros);
								$resultado=$errores_importacion->Insert();
						
							}
								
							
								
								
								
						}else{
							
							$errores=true;
						
							$error_encontrado="Esta linea no contiene el formato establecido, las columnas no estan separadas por tabulaciones.";
							
							$funcion = "ins_errores_importacion_marcaciones_masivas";
							$parametros = "'$numero_linea',
							'$error_encontrado',
							'$_id_usuarios'";
							$errores_importacion->setFuncion($funcion);
							$errores_importacion->setParametros($parametros);
							$resultado=$errores_importacion->Insert();
							
						}
						
						
					
					}
					
				}
				
				
				
				
				
				/// guardamos en la base de datos si todo esta bien
				
				
				

				if($errores==false){
						
					$numero_linea=0;
					$identificador_medidor="";
					$fecha_pago_mensual_correspondiente="";
					$marcacion_mensual_final="";
					// AQUI VALIDAMOS QUE EL IDENTIFICADOR DEL MEDIDOR EXISTA REGISTRADO EN LA BASE DE DATOS.
					foreach ($lineas as $linea_num => $linea)
					{
						$numero_linea++;
						$error_encontrado="";
						$datos = explode("\t",$linea);
							
				
						if(count($datos) == 3 && !empty(trim($datos[0])) && !empty(trim($datos[1])) && !empty(trim($datos[2]))){
				
							$identificador_medidor              = trim($datos[0]);
							$fecha_pago_mensual_correspondiente = trim($datos[1]);
							$marcacion_mensual_final            = trim($datos[2]);
							

							$_fecha_maxima_pago = strtotime ( '+15 day' , strtotime ($fecha_pago_mensual_correspondiente) ) ;
							$_fecha_maxima_pago = date ( 'Y-m-j' , $_fecha_maxima_pago );
							
							
							
							$columnas="asignacion_clientes_medidor_agua.id_clientes,
									  clientes.razon_social_clientes,
									  clientes.identificacion_clientes,
									  asignacion_clientes_medidor_agua.id_medidores_agua,
									  medidores_agua.identificador_medidores_agua";
								
							$tablas ="public.medidores_agua,
									  public.clientes,
									  public.asignacion_clientes_medidor_agua";
								
							$where ="asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
							asignacion_clientes_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND medidores_agua.identificador_medidores_agua= '$identificador_medidor'";
								
							$id="asignacion_clientes_medidor_agua.id_medidores_agua";
								
							$resultMedCli5=$asignacion_clientes_medidor_agua->getCondiciones($columnas,$tablas,$where,$id);
								
								
							if(!empty($resultMedCli5)){
							
								$id_medidores_agua_fin=$resultMedCli5[0]->id_medidores_agua;
								$id_clientes_fin=$resultMedCli5[0]->id_clientes;
								

								
								$resultMar5=$medidores_agua->getCondiciones("max(id_marcaciones_mensuales_medidor_agua) as id, id_medidores_agua", "marcaciones_mensuales_medidor_agua",
										"id_medidores_agua ='$id_medidores_agua_fin' GROUP BY id_medidores_agua", "id_medidores_agua");
								if(!empty($resultMar5)){
								
									$id_marcaciones_mensuales_medidor_agua5=$resultMar5[0]->id;
								
									$resultReg5=$marcaciones_mensuales->getBy("id_marcaciones_mensuales_medidor_agua = '$id_marcaciones_mensuales_medidor_agua5'");
								
									if(!empty($resultReg5)){
										$marcacion_mensual_final_base_datos = $resultReg5[0]->marcacion_mensual_final;
									}else{
										$marcacion_mensual_final_base_datos="00000";
										
									}
								
								}else{
										$marcacion_mensual_final_base_datos="00000";
										
									}
								
								

									$valor_mora=0;
									$var_alca=0;
										

									$mar_inicial=0;
									$mar_final=0;
									$agua_metros_cubicos=0;
									
									$tarifa_basica=0;
									$tarifa_adicional=0;
									$alcantarillado='NO';
									
									
									$solicitudes = new SolicitudesModel();
									$resultTipoConsumo= $solicitudes->getBy("id_clientes='$id_clientes_fin'");
									$id_tipo_consumo=$resultTipoConsumo[0]->id_tipo_consumo;
									 
									 
									$clientes = new ClientesModel();
									$resultClientes= $clientes->getBy("id_clientes='$id_clientes_fin'");
									$fecha_nacimiento=date("Y-m-d", strtotime($resultClientes[0]->fecha_nacimiento_clientes));
									$id_tipo_persona=$resultClientes[0]->id_tipo_persona;
									$discapacidad_clientes=$resultClientes[0]->discapacidad_clientes;
									
									
									$solicitudes_detalle = new SolicitudesDetalleModel();
									$columnas1="tarifas.nombre_tarifa";
									$tablas1="public.tarifas,
  									public.solicitudes_detalle";
									$where1="solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND tarifas.nombre_tarifa like '%ALCANTARILLADO%' AND solicitudes_detalle.id_clientes='$id_clientes_fin'";
									$id1="tarifas.nombre_tarifa";
									$resultAlcantarillado= $solicitudes_detalle->getCondiciones($columnas1, $tablas1, $where1, $id1);
									
									if(!empty($resultAlcantarillado)){
										$alcantarillado="SI";
									
									}
									
									
									
									$total=0;
									$descuento_mayor_edad=0;
									$descuento_discapacidad=0;
									$descuento_x_tener_alcantarillado=0;
									$total_des=0;
									$total_des1=0;
									$total_registrar=0;
									
									$cargo_fijo_por_conexion=0;
									$mar_inicial = ltrim($marcacion_mensual_final_base_datos,"0");
									$mar_final = ltrim($marcacion_mensual_final,"0");
									
									
									if($mar_inicial==""){
									
										$mar_inicial=0;
									}
									if($mar_final==""){
										$mar_final=0;
									}
									
									$agua_metros_cubicos=$mar_final-$mar_inicial;
									
									
									
									
									if($id_tipo_consumo>0){
									
									
										/// VALIDACIÓN PARA DOMESTICO
									
										if($id_tipo_consumo==1){
									
									
											if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
									
												$tarifa_basica=0;
												$tarifa_adicional=0.31;
									
											}
									
											if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
									
												$tarifa_basica=3.41;
												$tarifa_adicional=0.43;
									
											}
									
									
											if($agua_metros_cubicos >18){
									
												$tarifa_basica=6.42;
												$tarifa_adicional=0.72;
									
											}
									
									
									
									
										}
									
									
									
									
										/// VALIDACIÓN PARA COMERCIAL
									
										if($id_tipo_consumo==2){
											 
											 
											if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
									
												$tarifa_basica=0;
												$tarifa_adicional=0.72;
									
											}
											 
											if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
									
												$tarifa_basica=3.41;
												$tarifa_adicional=0.72;
									
											}
											 
											 
											if($agua_metros_cubicos >18){
									
												$tarifa_basica=6.42;
												$tarifa_adicional=0.72;
									
											}
											 
									
									
									
									
										}
									
									
										/// VALIDACÓN PARA INSDUSTRIAL
									
										if($id_tipo_consumo==3){
											 
											 
											if($agua_metros_cubicos >=0 && $agua_metros_cubicos <=11 ){
									
												$tarifa_basica=0;
												$tarifa_adicional=0.72;
									
											}
											 
											if($agua_metros_cubicos >=12 && $agua_metros_cubicos <=18){
									
												$tarifa_basica=3.41;
												$tarifa_adicional=0.72;
									
											}
											 
											 
											if($agua_metros_cubicos >18){
									
												$tarifa_basica=6.42;
												$tarifa_adicional=0.72;
									
											}
											 
											 
										}
									
										$total=$cargo_fijo_por_conexion+$tarifa_basica+$tarifa_adicional;
									
									
										if($id_tipo_persona==1){
											 
											$date2 = date('Y-m-d');//
											$diff = abs(strtotime($date2) - strtotime($fecha_nacimiento));
											$years = floor($diff / (365*60*60*24));
											$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
											$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
											 
									
											if($years > 65){
									
												if($agua_metros_cubicos <=20 ){
													 
													$descuento_mayor_edad=$total*0.5;
													 
												}
											}
											 
											$totaldes1=$total-$descuento_mayor_edad;
											 
											if($discapacidad_clientes == 't'){
									
												if($agua_metros_cubicos <=10 ){
													 
													$descuento_discapacidad=$totaldes1*0.5;
									
												}
											}
											 
											 
										}
										
										if($id_tipo_persona==2){
											$totaldes1=$total-$descuento_mayor_edad;
										}
									
										$total_des=$totaldes1-$descuento_discapacidad;
				
										
										
										
										if($alcantarillado=="SI"){
											$var_alca=1.32;
											$descuento_x_tener_alcantarillado=$total_des*0.386;
											$total_des=$descuento_x_tener_alcantarillado+$var_alca;
										}
										$total_administracion=2.10;
										$total_registrar=$total_des;
										$total_registrar=$total_registrar+$total_administracion;
										
										
									
									
									
									}
										
									
									
									
									
									
									
									
									
									
									
									
									
								$funcion = "ins_marcaciones_mensuales_medidor_agua";
								$parametros = "'$id_medidores_agua_fin',
								'$id_clientes_fin',
								'$marcacion_mensual_final_base_datos',
								'$marcacion_mensual_final',
								'$fecha_pago_mensual_correspondiente',
								'$total_registrar',
								'$_id_usuarios',
								'$_tipo_registro',
								'$_fecha_maxima_pago',
		        				'$descuento_mayor_edad',
					        	'$descuento_discapacidad',
					        	'$descuento_x_tener_alcantarillado',
					        	'$valor_mora',
					        	'$agua_metros_cubicos',
					        	'$total',
					        	'$total_administracion',
					        	'$var_alca'";
											$marcaciones_mensuales->setFuncion($funcion);
								$marcaciones_mensuales->setParametros($parametros);
								$resultado=$marcaciones_mensuales->Insert();
									
								
								
							}else{
								
								
							}
							
							
							
							
							
						}else{
							
							$errores=true;
						
							$error_encontrado="Esta linea no contiene el formato establecido, las columnas no estan separadas por tabulaciones.";
							
							$funcion = "ins_errores_importacion_marcaciones_masivas";
							$parametros = "'$numero_linea',
							'$error_encontrado',
							'$_id_usuarios'";
							$errores_importacion->setFuncion($funcion);
							$errores_importacion->setParametros($parametros);
							$resultado=$errores_importacion->Insert();
							
						}
					}
				}
				
				
				
				
				
				
				// cuando el txt esta vacio.
				}else{
					
					$errores=true;
					
					$error_encontrado="El archivo seleccionado no contiene registros, esta vacio.";
					
					$funcion = "ins_errores_importacion_marcaciones_masivas";
					$parametros = "'0',
					'$error_encontrado',
					'$_id_usuarios'";
					$errores_importacion->setFuncion($funcion);
					$errores_importacion->setParametros($parametros);
					$resultado=$errores_importacion->Insert();
					
					
				}
				
				
				
				
				
				
				
				
			}
		


			$this->redirect("MarcacionesMensualesMedidorAgua", "index");
			
			
		}else{
			 
			$error = TRUE;
			$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
		
			$this->view("Login",array(
					"resultSet"=>"$mensaje", "error"=>$error
			));
		
		
			die();
			 
		}
		
	}
	
	
	

	
	
	public function borrarId()
	{
		if(isset($_GET["id_marcaciones_mensuales_medidor_agua"]))
		{
			$id_marcaciones_mensuales_medidor_agua=(int)$_GET["id_marcaciones_mensuales_medidor_agua"];
			$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
			$marcaciones_mensuales->deleteBy("id_marcaciones_mensuales_medidor_agua",$id_marcaciones_mensuales_medidor_agua);
				
				
		}
	
		$this->redirect("MarcacionesMensualesMedidorAgua", "index");
	}
	
	


	public function AutocompleteIdentificador(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$medidores_agua = new MedidoresAguaModel();
		$identificador_medidores_agua = $_GET['term'];
		
		
		$columnas="medidores_agua.identificador_medidores_agua";
		$tablas ="public.medidores_agua, 
                  public.asignacion_clientes_medidor_agua";
		$where="asignacion_clientes_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND medidores_agua.identificador_medidores_agua LIKE '%$identificador_medidores_agua%'";
		$id="medidores_agua.identificador_medidores_agua";
		
		$resultSet=$medidores_agua->getCondiciones($columnas,$tablas,$where,$id);
			
		
		
		
		if(!empty($resultSet)){
	
			foreach ($resultSet as $res){
					
				$_identificador_medidores_agua[] = $res->identificador_medidores_agua;
			}
			echo json_encode($_identificador_medidores_agua);
		}
			
	}
	
	
	public function AutocompleteDevuelveIdentificador(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$medidores_agua = new MedidoresAguaModel();
		$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
		
		$identificador_medidores_agua = $_POST['identificador_medidores_agua'];
		
		
		$columnas="asignacion_clientes_medidor_agua.id_clientes, 
				  clientes.razon_social_clientes, 
				  clientes.identificacion_clientes, 
				  asignacion_clientes_medidor_agua.id_medidores_agua, 
				  medidores_agua.identificador_medidores_agua";
		
		$tablas ="public.medidores_agua, 
				  public.clientes, 
				  public.asignacion_clientes_medidor_agua";
		
		$where ="asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
                 asignacion_clientes_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND medidores_agua.identificador_medidores_agua= '$identificador_medidores_agua'";
		
		$id="asignacion_clientes_medidor_agua.id_medidores_agua";
		
		$resultSet=$medidores_agua->getCondiciones($columnas,$tablas,$where,$id);
			
		$respuesta = new stdClass();
			
		if(!empty($resultSet)){
	
			$id_medidores_agua = $resultSet[0]->id_medidores_agua;
			
			$respuesta->identificador_medidores_agua = $resultSet[0]->identificador_medidores_agua;
			$respuesta->id_medidores_agua = $resultSet[0]->id_medidores_agua;
			$respuesta->id_clientes = $resultSet[0]->id_clientes;
			$respuesta->razon_social_clientes = $resultSet[0]->razon_social_clientes;
			$respuesta->identificacion_clientes = $resultSet[0]->identificacion_clientes;
				
			
			
				
				
		      $resultMar=$medidores_agua->getCondiciones("max(id_marcaciones_mensuales_medidor_agua) as id, id_medidores_agua", "marcaciones_mensuales_medidor_agua",
						"id_medidores_agua ='$id_medidores_agua' GROUP BY id_medidores_agua", "id_medidores_agua");
		      if(!empty($resultMar)){
		      	
		      	$id_marcaciones_mensuales_medidor_agua=$resultMar[0]->id;
		      		
		      	$resultReg=$marcaciones_mensuales->getBy("id_marcaciones_mensuales_medidor_agua = '$id_marcaciones_mensuales_medidor_agua'");
		      	
		      	if(!empty($resultReg)){
		      		$respuesta->marcacion_mensual_inicial = $resultReg[0]->marcacion_mensual_final;
		      		$respuesta->fecha_pago_mensual_correspondiente =  $resultReg[0]->fecha_pago_mensual_correspondiente;
		      		
		      	}else{
		      		$respuesta->marcacion_mensual_inicial = "00000";
		      		$respuesta->fecha_pago_mensual_correspondiente =  "0";
		      		
		      	}
		      	
		      }else{
		      	
		      	$respuesta->marcacion_mensual_inicial = "00000";
		      	$respuesta->fecha_pago_mensual_correspondiente =  "0";
		      	
		      }
		      
		
			echo json_encode($respuesta);
		}
			
	}
	
	
	
	
	public function paginate_consultar_registros($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consultar_registros(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consultar_registros(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_consultar_registros(1)'>1</a></li>";
		}
		// interval
		if($page>($adjacents+2)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// pages
	
		$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
		$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$page) {
				$out.= "<li class='active'><a>$i</a></li>";
			}else if($i==1) {
				$out.= "<li><a href='javascript:void(0);' onclick='load_consultar_registros(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_consultar_registros(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_consultar_registros($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consultar_registros(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	
	public function paginate_bitacora_validacion($reload, $page, $tpages, $adjacents) {
	    
	    $prevlabel = "&lsaquo; Prev";
	    $nextlabel = "Next &rsaquo;";
	    $out = '<ul class="pagination pagination-large">';
	    
	    // previous label
	    
	    if($page==1) {
	        $out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
	    } else if($page==2) {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_bitacora_validacion(1)'>$prevlabel</a></span></li>";
	    }else {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_bitacora_validacion(".($page-1).")'>$prevlabel</a></span></li>";
	        
	    }
	    
	    // first label
	    if($page>($adjacents+1)) {
	        $out.= "<li><a href='javascript:void(0);' onclick='load_bitacora_validacion(1)'>1</a></li>";
	    }
	    // interval
	    if($page>($adjacents+2)) {
	        $out.= "<li><a>...</a></li>";
	    }
	    
	    // pages
	    
	    $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	    $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	    for($i=$pmin; $i<=$pmax; $i++) {
	        if($i==$page) {
	            $out.= "<li class='active'><a>$i</a></li>";
	        }else if($i==1) {
	            $out.= "<li><a href='javascript:void(0);' onclick='load_bitacora_validacion(1)'>$i</a></li>";
	        }else {
	            $out.= "<li><a href='javascript:void(0);' onclick='load_bitacora_validacion(".$i.")'>$i</a></li>";
	        }
	    }
	    
	    // interval
	    
	    if($page<($tpages-$adjacents-1)) {
	        $out.= "<li><a>...</a></li>";
	    }
	    
	    // last
	    
	    if($page<($tpages-$adjacents)) {
	        $out.= "<li><a href='javascript:void(0);' onclick='load_bitacora_validacion($tpages)'>$tpages</a></li>";
	    }
	    
	    // next
	    
	    if($page<$tpages) {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_bitacora_validacion(".($page+1).")'>$nextlabel</a></span></li>";
	    }else {
	        $out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
	    }
	    
	    $out.= "</ul>";
	    return $out;
	}
	
	
	
	


	public function devuelveCanton()
	{
		session_start();
		$resultCan = array();
	
	
		if(isset($_POST["id_provincias"]))
		{
	
			$id_provincias=(int)$_POST["id_provincias"];
	
			$cantones=new CantonesModel();
	
			$resultCan = $cantones->getBy(" id_provincias = '$id_provincias'  ");
	
	
		}
	
		
			
		echo json_encode($resultCan);
	
	}
	
	
	
	
	
	
	
	public function devuelveParroquias()
	{
		session_start();
		$resultParr = array();
	
	
		if(isset($_POST["id_cantones"]))
		{
	
			$id_cantones_vivienda=(int)$_POST["id_cantones"];
	
			$parroquias=new ParroquiasModel();
	
			$resultParr = $parroquias->getBy(" id_cantones = '$id_cantones_vivienda'  ");
	
	
		}
		
			
		echo json_encode($resultParr);
	
	}
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
}
?>
