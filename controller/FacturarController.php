<?php
class FacturarController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
    
    public function marcaciones(){
    	


    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$marcaciones = new MarcacionesMensualesMedidorAguaModel();
    	$where_to="";
    	$columnas = " marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua, 
					  medidores_agua.id_medidores_agua, 
					  medidores_agua.identificador_medidores_agua, 
					  clientes.id_clientes, 
					  clientes.razon_social_clientes, 
					  tipo_identificacion.id_tipo_identificacion, 
					  tipo_identificacion.nombre_tipo_identificacion, 
					  clientes.identificacion_clientes, 
					  tipo_persona.id_tipo_persona, 
					  tipo_persona.nombre_tipo_persona, 
					  tipo_consumo.id_tipo_consumo, 
					  tipo_consumo.nombre_tipo_consumo, 
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_inicial, 
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_final, 
					  marcaciones_mensuales_medidor_agua.fecha_pago_mensual_correspondiente, 
					  marcaciones_mensuales_medidor_agua.valor_pago_mensual_correspondiente, 
					  marcaciones_mensuales_medidor_agua.tipo_registro, 
					  marcaciones_mensuales_medidor_agua.id_estado";
					    	 
    	$tablas   = " public.marcaciones_mensuales_medidor_agua, 
					  public.clientes, 
					  public.tipo_persona, 
					  public.tipo_identificacion, 
					  public.tipo_consumo, 
					  public.solicitudes, 
					  public.medidores_agua";
					    	 
    	$id       = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua";
    	 
    	 
    	$where    = " marcaciones_mensuales_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND
				  clientes.id_clientes = marcaciones_mensuales_medidor_agua.id_clientes AND
				  clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
				  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
				  solicitudes.id_clientes = clientes.id_clientes AND
				  solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND marcaciones_mensuales_medidor_agua.id_estado=2";
    	//$resultEdit = $marcaciones->getCondiciones($columnas ,$tablas ,$where, $id);
    	 
    	 
    	
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	
    	
    	
    	
    	if($action == 'ajax')
    	{
    	
    		if(!empty($search)){
    	
    	
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR tipo_consumo.nombre_tipo_consumo LIKE '".$search."%')";
    	
    			$where_to=$where.$where1;
    		}else{
    	
    			$where_to=$where;
    	
    		}
    	
    		$html="";
    		$resultSet=$marcaciones->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    	
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    	
    		$per_page = 50; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    	
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    	
    		$resultSet=$marcaciones->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
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
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci /Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Consumo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Marcación Ini</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Marcación Fin</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Valor</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Mes Corresp.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    			 
    			$html.='</tr>';
    			$html.='</thead>';
    			$html.='<tbody>';
    	
    			$i=0;
    	
    	
    	
    			foreach ($resultSet as $res)
    			{
    				$i++;
    				$html.='<tr>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_persona.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_consumo.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_inicial.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_final.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->valor_pago_mensual_correspondiente.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_pago_mensual_correspondiente.'</td>';
    				
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Facturar&action=index3&id_clientes='.$res->id_clientes.'&id_marcaciones_mensuales_medidor_agua='.$res->id_marcaciones_mensuales_medidor_agua.'" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    					
    				$html.='</tr>';
    			}
    	
    	
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_marcaciones("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    	
    	
    	
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay registros para facturar...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    	
    	}
    	
    	
    	
    	
    }
    
    
    
    
    
    public function  aprobadas(){
    
    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$solicitudes = new SolicitudesModel();
    	$solicitudes_detalle = new SolicitudesDetalleModel();
    	$where_to="";
    	$columnas = " solicitudes.id_solicitudes, 
					  clientes.id_clientes, 
					  clientes.razon_social_clientes, 
					  tipo_identificacion.id_tipo_identificacion, 
					  tipo_identificacion.nombre_tipo_identificacion, 
					  tipo_persona.id_tipo_persona, 
					  tipo_persona.nombre_tipo_persona, 
					  clientes.identificacion_clientes, 
					  tipo_consumo.id_tipo_consumo, 
					  tipo_consumo.nombre_tipo_consumo, 
					  solicitudes.id_estado, 
					  solicitudes.id_usuarios_registra, 
					  solicitudes.fecha_registro, 
    			      solicitudes.fecha_aprueba_registros, 
					  solicitudes.numero_solicitudes";
    	
    	$tablas   = "public.tipo_consumo, 
				  public.tipo_identificacion, 
				  public.tipo_persona, 
				  public.solicitudes, 
				  public.clientes";
    	
    	$id       = "solicitudes.id_solicitudes";
    	
    	
    	$where    = " tipo_consumo.id_tipo_consumo = solicitudes.id_tipo_consumo AND
  tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND
  tipo_persona.id_tipo_persona = clientes.id_tipo_persona AND
  solicitudes.id_clientes = clientes.id_clientes AND solicitudes.id_estado=1 AND solicitudes.pagado='FALSE'";
    	//$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
    	
    	
    	 
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	 
    	 
    	 
    	 
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR tipo_consumo.nombre_tipo_consumo LIKE '".$search."%')";
    
    			$where_to=$where.$where1;
    		}else{
    
    			$where_to=$where;
    
    		}
    
    		$html="";
    		$resultSet=$solicitudes->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    
    		$per_page = 50; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    
    		$resultSet=$solicitudes->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
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
    			$html.= "<table id='tabla_aprobadas' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;"># Solicitud</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci /Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Reg.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Apro.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    			
    			
    			$html.='</tr>';
    			$html.='</thead>';
    			$html.='<tbody>';
    			 
    			$i=0;
    
    
    
    			foreach ($resultSet as $res)
    			{
    				$i++;
    				$html.='<tr>';
    				$html.='<td style="font-size: 11px;">'.$res->numero_solicitudes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_persona.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_registro.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_aprueba_registros.'</td>';
    				$html.='<td style="font-size: 11px;">Aprobada</td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Facturar&action=index2&id_clientes='.$res->id_clientes.'&id_solicitudes='.$res->id_solicitudes.'" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				 
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_aprobadas("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitudes aprobadas registrados para facturar...</b>';
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
		
			
			$solicitudes = new SolicitudesModel();
			$solicitudes_detalle = new SolicitudesDetalleModel();
				
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
			
			$tipo_persona = new TipoPersonaModel();
			$resultTip_Per = $tipo_persona->getAll("nombre_tipo_persona");
			
			
			$nombre_controladores = "Facturar";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitudes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
					$resultEdit = "";
					$result_tar = "";
			
					if (isset ($_GET["id_clientes"]) && isset ($_GET["id_solicitudes"])  )
					{
						$_id_clientes = $_GET["id_clientes"];
						$_id_solicitudes = $_GET["id_solicitudes"];
						
						$columnas = "solicitudes.id_solicitudes, 
								  clientes.id_clientes, 
								  clientes.razon_social_clientes, 
								  clientes.id_tipo_identificacion, 
								  clientes.id_tipo_persona, 
								  clientes.identificacion_clientes, 
								  tipo_consumo.id_tipo_consumo, 
								  tipo_consumo.nombre_tipo_consumo, 
								  solicitudes.numero_solicitudes";
						
						$tablas   = "public.solicitudes, 
									  public.clientes, 
									  public.tipo_consumo";
						
						$id       = "solicitudes.id_solicitudes";
						
						
						$where    = " solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND
  									clientes.id_clientes = solicitudes.id_clientes AND solicitudes.id_solicitudes='$_id_solicitudes' AND clientes.id_clientes = '$_id_clientes' "; 
						$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id); 
						
						
						
						
						$columnas1 = "solicitudes_detalle.id_solicitudes_detalle, 
									  solicitudes_detalle.id_solicitudes, 
									  tarifas.id_tarifas, 
									  tarifas.nombre_tarifa";
						
						$tablas1   = " public.tarifas, 
  										public.solicitudes_detalle";
						
						$id1       = "solicitudes_detalle.id_solicitudes_detalle";
						
						
						$where1    = " solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND solicitudes_detalle.id_solicitudes='$_id_solicitudes' ";
						$result_tar = $solicitudes_detalle->getCondiciones($columnas1 ,$tablas1 ,$where1, $id1);
						
						
						
					}
			
					
					$this->view("Facturar",array(
							"resultEdit" =>$resultEdit, 
							"resultTipIdenti"=>$resultTipIdenti, "resultTip_Per"=>$resultTip_Per,
							"result_tar"=>$result_tar
					
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Facturar"
			
				));
			
			}
			
		
		}
		else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
		
	}
	
	
	
	
	
	public function index2(){
	
		session_start();
		if (isset(  $_SESSION['id_usuarios']) )
		{
	
				
			$solicitudes = new SolicitudesModel();
			$solicitudes_detalle = new SolicitudesDetalleModel();
	
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
				
			$tipo_persona = new TipoPersonaModel();
			$resultTip_Per = $tipo_persona->getAll("nombre_tipo_persona");
				
			$tipo_consumo = new TipoConsumoModel();
			$resultTip_Con = $tipo_consumo->getAll("nombre_tipo_consumo");
				
				
			$nombre_controladores = "Facturar";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitudes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				$resultEdit = "";
				$result_tar = "";
				$numero_consecutivo="";
					
				if (isset ($_GET["id_clientes"]) && isset ($_GET["id_solicitudes"])  )
				{
					$_id_clientes = $_GET["id_clientes"];
					$_id_solicitudes = $_GET["id_solicitudes"];
	
					$columnas = "solicitudes.id_solicitudes,
								  clientes.id_clientes,
								  clientes.razon_social_clientes,
								  clientes.id_tipo_identificacion,
								  clientes.id_tipo_persona,
								  clientes.identificacion_clientes,
								  tipo_consumo.id_tipo_consumo,
								  tipo_consumo.nombre_tipo_consumo,
								  solicitudes.numero_solicitudes";
	
					$tablas   = "public.solicitudes,
									  public.clientes,
									  public.tipo_consumo";
	
					$id       = "solicitudes.id_solicitudes";
	
	
					$where    = " solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND
					clientes.id_clientes = solicitudes.id_clientes AND solicitudes.id_solicitudes='$_id_solicitudes' AND clientes.id_clientes = '$_id_clientes' ";
					$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
					$columnas1 = "solicitudes_detalle.id_solicitudes_detalle,
									  solicitudes_detalle.id_solicitudes,
									  tarifas.id_tarifas,
									  tarifas.nombre_tarifa,
							          tarifas.valor_tarifa";
	
					$tablas1   = " public.tarifas,
  										public.solicitudes_detalle";
	
					$id1       = "solicitudes_detalle.id_solicitudes_detalle";
	
	
					$where1    = " solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND solicitudes_detalle.id_solicitudes='$_id_solicitudes' ";
					$result_tar = $solicitudes_detalle->getCondiciones($columnas1 ,$tablas1 ,$where1, $id1);
	
					
					$consecutivos = new ConsecutivosModel();
					$resultConsecutivo= $consecutivos->getBy("nombre_consecutivos='Facturas'");
					$numero_consecutivo=$resultConsecutivo[0]->real_numero_consecutivos;
					
					
					
	
				}
					
					
				$this->view("FacturarDetalle",array(
						"resultEdit" =>$resultEdit,
						"resultTipIdenti"=>$resultTipIdenti, "resultTip_Per"=>$resultTip_Per,
						"result_tar"=>$result_tar, "numero_consecutivo"=>$numero_consecutivo
							
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Facturar"
		
				));
					
			}
				
	
		}
		else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
	
	}
	
	
	
	
	
	public function index3(){
	
		session_start();
		if (isset(  $_SESSION['id_usuarios']) )
		{
	
	
			$solicitudes = new SolicitudesModel();
			$solicitudes_detalle = new SolicitudesDetalleModel();
	
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
	
			$tipo_persona = new TipoPersonaModel();
			$resultTip_Per = $tipo_persona->getAll("nombre_tipo_persona");
	
			$tipo_consumo = new TipoConsumoModel();
			$resultTip_Con = $tipo_consumo->getAll("nombre_tipo_consumo");
	
	
			$nombre_controladores = "Facturar";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitudes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				$resultEdit = "";
				$result_tar = "";
				$numero_consecutivo="";
					
				if (isset ($_GET["id_clientes"]) && isset ($_GET["id_marcaciones_mensuales_medidor_agua"])  )
				{
					$_id_clientes = $_GET["id_clientes"];
					$_id_marcaciones_mensuales_medidor_agua = $_GET["id_marcaciones_mensuales_medidor_agua"];
	
					$columnas = " marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua,
					  medidores_agua.id_medidores_agua,
					  medidores_agua.identificador_medidores_agua,
					  clientes.id_clientes,
					  clientes.razon_social_clientes,
					  tipo_identificacion.id_tipo_identificacion,
					  tipo_identificacion.nombre_tipo_identificacion,
					  clientes.identificacion_clientes,
					  tipo_persona.id_tipo_persona,
					  tipo_persona.nombre_tipo_persona,
					  tipo_consumo.id_tipo_consumo,
					  tipo_consumo.nombre_tipo_consumo,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_inicial,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_final,
					  marcaciones_mensuales_medidor_agua.fecha_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.valor_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.tipo_registro,
					  marcaciones_mensuales_medidor_agua.id_estado";
					 
					$tablas   = " public.marcaciones_mensuales_medidor_agua,
					  public.clientes,
					  public.tipo_persona,
					  public.tipo_identificacion,
					  public.tipo_consumo,
					  public.solicitudes,
					  public.medidores_agua";
					 
					$id       = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua";
					
					
					$where    = " marcaciones_mensuales_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND
				  clientes.id_clientes = marcaciones_mensuales_medidor_agua.id_clientes AND
				  clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
				  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
				  solicitudes.id_clientes = clientes.id_clientes AND
				  solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua='$_id_marcaciones_mensuales_medidor_agua'";
					$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
					
						
					$consecutivos = new ConsecutivosModel();
					$resultConsecutivo= $consecutivos->getBy("nombre_consecutivos='Facturas'");
					$numero_consecutivo=$resultConsecutivo[0]->real_numero_consecutivos;
						
						
						
	
				}
					
					
				$this->view("FacturarAguaDetalle",array(
						"resultEdit" =>$resultEdit,
						"resultTipIdenti"=>$resultTipIdenti, "resultTip_Per"=>$resultTip_Per,
						"numero_consecutivo"=>$numero_consecutivo
							
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Facturar"
	
				));
					
			}
	
	
		}
		else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
	
	}
	
	
	
	
	
	
	
	public function InsertaFacturas(){
			
		session_start();
		$resultado = null;
		
		
		$solicitudes=new SolicitudesModel();
		$solicitides_detalle =new SolicitudesDetalleModel();
		$consecutivos = new ConsecutivosModel();
		$resultConsecutivo= $consecutivos->getBy("nombre_consecutivos='Facturas'");
		$numero_consecutivo=$resultConsecutivo[0]->real_numero_consecutivos;
			
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			
		if (isset ($_GET["id_clientes"]))
		{
			$_id_clientes    = $_GET["id_clientes"];
			$_id_usuarios   = $_SESSION["id_usuarios"];
			$_id_solicitudes = $_GET["id_solicitudes"];
			date_default_timezone_set('America/Guayaquil');
			$fechaActual = date('d-m-Y H:i:s');
		    
		    
		    if($_id_solicitudes > 0){
		    	
		    		$colval = "pagado='TRUE', numero_factura='$numero_consecutivo' ";
		    		$tabla = "solicitudes";
		    		$where = "id_clientes = '$_id_clientes' AND id_solicitudes='$_id_solicitudes'";
		    		$resultado=$solicitudes->UpdateBy($colval, $tabla, $where);
		    		
		    		$consecutivos->UpdateBy("real_numero_consecutivos=real_numero_consecutivos+1", "consecutivos", "nombre_consecutivos='Facturas'");
		    			
		    		
		    		$html="";
		    		$fechaactual = getdate();
		    		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		    		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		    		$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		    			
		    		$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/aguafacturacion';
		    		$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
		    		$domLogo=$directorio.'/view/images/agua.png';
		    		$logo = '<img src="'.$domLogo.'" alt="Responsive image" width="130" height="70">';
		    			
		    		
		    					
		    				$columnas = "solicitudes.id_solicitudes,
								  clientes.id_clientes,
								  clientes.razon_social_clientes,
								  clientes.id_tipo_identificacion,
								  clientes.id_tipo_persona,
								  clientes.identificacion_clientes,
								  tipo_consumo.id_tipo_consumo,
								  tipo_consumo.nombre_tipo_consumo,
								  solicitudes.numero_factura,
						          tipo_persona.nombre_tipo_persona,
						          tipo_identificacion.nombre_tipo_identificacion,
						          solicitudes.fecha_registro,
						          solicitudes.id_estado,
						          solicitudes.id_usuarios_registra,
						          solicitudes.id_usuarios_aprueba";
		    		
		    				$tablas   = "public.solicitudes,
									  public.clientes,
									  public.tipo_consumo,
						              public.tipo_identificacion,
						              public.tipo_persona";
		    		
		    				$id       = "solicitudes.id_solicitudes";
		    		
		    		
		    				$where    = " tipo_identificacion.id_tipo_identificacion =clientes.id_tipo_identificacion AND tipo_persona.id_tipo_persona= clientes.id_tipo_persona AND solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND
		    				clientes.id_clientes = solicitudes.id_clientes AND solicitudes.id_solicitudes='$_id_solicitudes' AND clientes.id_clientes = '$_id_clientes' ";
		    		
		    		
		    		
		    					
		    					
		    				$resultSetCabeza=$solicitudes->getCondiciones($columnas, $tablas, $where, $id);
		    		
		    		
		    				$usuarios = new UsuariosModel();
		    		
		    		
		    				$_id_usuarios_registra=0;
		    				$_id_usuarios_aprueba=0;
		    				$_nombre_usuarios_registra="";
		    				$_nombre_usuarios_aprueba="";
		    		
		    		
		    				if(!empty($resultSetCabeza)){
		    		
		    		
		    		
		    					$numero_solicitudes     =$resultSetCabeza[0]->numero_factura;
		    					$_nombre_tipo_persona       =$resultSetCabeza[0]->nombre_tipo_persona;
		    					$_nombre_tipo_identificacion   =$resultSetCabeza[0]->nombre_tipo_identificacion;
		    					$_razon_social_clientes   =$resultSetCabeza[0]->razon_social_clientes;
		    					$_identificacion_clientes =$resultSetCabeza[0]->identificacion_clientes;
		    					$_nombre_tipo_consumo =$resultSetCabeza[0]->nombre_tipo_consumo;
		    					$_id_estado	=$resultSetCabeza[0]->id_estado;
		    					$_id_usuarios_registra =$resultSetCabeza[0]->id_usuarios_registra;
		    					$_id_usuarios_aprueba =$resultSetCabeza[0]->id_usuarios_aprueba;
		    		
		    					$_fecha_registro          =date("d/m/Y", strtotime($resultSetCabeza[0]->fecha_registro));
		    					$_fecha_registro=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		    		
		    		
		    					if($_id_usuarios_registra>0){
		    		
		    						$resultUsuReg= $usuarios->getBy("id_usuarios='$_id_usuarios_registra'");
		    						$_nombre_usuarios_registra=$resultUsuReg[0]->nombre_usuarios;
		    							
		    					}else{
		    		
		    						$_nombre_usuarios_registra="";
		    					}
		    		
		    		
		    		
		    		
		    					if($_id_usuarios_aprueba>0){
		    							
		    						$resultUsuAprue= $usuarios->getBy("id_rol='47'");
		    						$_nombre_usuarios_aprueba=$resultUsuAprue[0]->nombre_usuarios;
		    							
		    					}else{
		    							
		    						$_nombre_usuarios_aprueba="";
		    					}
		    		
		    		
		    					$columnas1 = "solicitudes_detalle.id_solicitudes_detalle,
									  solicitudes_detalle.id_solicitudes,
									  tarifas.id_tarifas,
									  tarifas.nombre_tarifa,
							          tarifas.valor_tarifa";
		    		
		    					$tablas1   = " public.tarifas,
  										public.solicitudes_detalle";
		    		
		    					$id1       = "solicitudes_detalle.id_solicitudes_detalle";
		    		
		    		
		    					$where1    = " solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND solicitudes_detalle.id_solicitudes='$_id_solicitudes' ";
		    		
		    					$resultSetDetalle=$solicitides_detalle->getCondiciones($columnas1, $tablas1, $where1, $id1);
		    		
		    		
		    					$html.='<p style="text-align: right;">'.$logo.'<hr style="height: 2px; background-color: black;"></p>';
		    					$html.='<p style="text-align: right; font-size: 13px;"><b>Fecha Factura:</b> '.$fechaactual.'</p>';
		    					$html.='<p style="text-align: center; font-size: 16px; margin-top:60px;"><b>Factura No. '.$numero_solicitudes.'</b></p>';
		    		
		    		
		    					$html.='<table style="width: 100%; margin-top:30px;">';
		    		
		    					$html.='<tr>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Persona</th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Identificación</th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Identificación</th>';
		    					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Razón Social</th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Consumo</th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Estado Solicitud</th>';
		    					$html.='</tr>';
		    		
		    					$html.='<tr>';
		    		
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_persona.'</td>';
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_identificacion.'</td>';
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_identificacion_clientes.'</td>';
		    					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_razon_social_clientes.'</td>';
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_consumo.'</td>';
		    		
		    					if($_id_estado==3){
		    						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Pendiente</td>';
		    					}else if($_id_estado==2){
		    						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Anulada</td>';
		    					}else {
		    						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Aprobada</td>';
		    					}
		    		
		    					$html.='</tr>';
		    					$html.='</table>';
		    		
		    		
		    					if(!empty($resultSetDetalle)){
		    							
		    							
		    							
		    						$html.= "<table style='width: 100%; margin-top:40px;' border=1 cellspacing=0>";
		    						$html.= "<thead>";
		    						$html.= "<tr>";
		    						$html.='<th style="text-align: left;  font-size: 13px;">Descripción</th>';
		    						$html.='<th style="text-align: left;  font-size: 13px;">Cantidad</th>';
		    						$html.='<th style="text-align: left;  font-size: 13px;">Valor C/U</th>';
		    						$html.='<th style="text-align: left;  font-size: 13px;">Valor Total</th>';
		    						$html.='</tr>';
		    						$html.='</thead>';
		    						$html.='<tbody>';
		    							
		    						$i=0;
		    						$i=0; $valor_total_db=0; $valor_total_vista=0;
		    		
		    						foreach ($resultSetDetalle as $res)
		    						{
		    							$valor_total_db=$res->valor_tarifa;
		    							$valor_total_vista=$valor_total_vista+$valor_total_db;
		    		
		    								
		    							$i++;
		    							$html.='<tr>';
		    							$html.='<td style="font-size: 11px;">'.$res->nombre_tarifa.'</td>';
		    							$html.='<td style="font-size: 11px;">1</td>';
		    							$html.='<td style="font-size: 11px;">'.$res->valor_tarifa.'</td>';
		    							$html.='<td style="font-size: 11px;">'.$res->valor_tarifa.'</td>';
		    							$html.='</tr>';
		    								
		    							$valor_total_db=0;
		    						}
		    							
		    						$valor_total_vista= number_format($valor_total_vista, 2, '.', ',');
		    							
		    		
		    						$html.='<tr>';
		    						$html.='<td class="text-right" colspan=2></td>';
		    						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>SubTotal</b></td>';
		    						$html.='<td class="text-left" style="font-size: 12px;">'.$valor_total_vista.'</td>';
		    						$html.='</tr>';
		    		
		    						$valor_iva=0; $valor_iva=$valor_total_vista*0.12;
		    						$valor_iva= number_format($valor_iva, 2, '.', ',');
		    		
		    		
		    						$html.='<tr>';
		    						$html.='<td class="text-right" colspan=2></td>';
		    						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>Iva 12%</b></td>';
		    						$html.='<td class="text-left" style="font-size: 11px;">'.$valor_iva.'</td>';
		    						$html.='</tr>';
		    		
		    						$valor_FIN=0; $valor_FIN=$valor_total_vista+$valor_iva;
		    						$valor_FIN= number_format($valor_FIN, 2, '.', ',');
		    		
		    						$html.='<tr>';
		    						$html.='<td class="text-right" colspan=2></td>';
		    						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>TOTAL $</b></td>';
		    						$html.='<td class="text-right" style="font-size: 11px;">'.$valor_FIN.'</td>';
		    		
		    						$html.='</tr>';
		    		
		    		
		    		
		    							
		    						$html.='</tbody>';
		    						$html.='</table>';
		    							
		    							
		    					}
		    		
		    		
		    					$html.='<table style="width: 100%; margin-top:40px;">';
		    		
		    					$html.='<tr>';
		    					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Cajero</th>';
		    					$html.='<th colspan="4" style="text-align:left; font-size: 13px;"></th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
		    					$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
		    					$html.='</tr>';
		    		
		    					$html.='<tr>';
		    		
		    					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_usuarios_aprueba.'</td>';
		    					$html.='<td colspan="4" style="text-align:left; font-size: 13px;"></td>';
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
		    					$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
		    		
		    					$html.='</tr>';
		    					$html.='</table>';
		    		
		    		
		    				}
		    					
		    					
		    				$this->report("Factura",array( "resultSet"=>$html, "numero_solicitudes"=>$numero_solicitudes));
		    				die();
		    					
		    		
		    		
		    }else{
		    	
		    	
		    }
		   
		}

		$this->redirect("Facturar", "index");
		
	   }else{
	   	
	   	$error = TRUE;
	   	$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	   		
	   	$this->view("Login",array(
	   			"resultSet"=>"$mensaje", "error"=>$error
	   	));
	   		
	   		
	   	die();
	   	
	   }
	}
	
	
	


	public function InsertaFacturasAgua(){
			
		session_start();
		$resultado = null;
	
	
		$marcaciones_mensuales = new MarcacionesMensualesMedidorAguaModel();
		 
		
		$consecutivos = new ConsecutivosModel();
		$resultConsecutivo= $consecutivos->getBy("nombre_consecutivos='Facturas'");
		$numero_consecutivo=$resultConsecutivo[0]->real_numero_consecutivos;
			
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
				
			if (isset ($_GET["id_clientes"]))
			{
				$_id_clientes    = $_GET["id_clientes"];
				$_id_usuarios   = $_SESSION["id_usuarios"];
				$_id_marcaciones_mensuales_medidor_agua = $_GET["id_marcaciones_mensuales_medidor_agua"];
				date_default_timezone_set('America/Guayaquil');
				$fechaActual = date('d-m-Y H:i:s');
	
	
				if($_id_marcaciones_mensuales_medidor_agua > 0){
					 
					$colval = "id_estado='1', numero_factura='$numero_consecutivo' ";
					$tabla = "marcaciones_mensuales_medidor_agua";
					$where = "id_clientes = '$_id_clientes' AND id_marcaciones_mensuales_medidor_agua='$_id_marcaciones_mensuales_medidor_agua'";
					$resultado=$marcaciones_mensuales->UpdateBy($colval, $tabla, $where);
	
					$consecutivos->UpdateBy("real_numero_consecutivos=real_numero_consecutivos+1", "consecutivos", "nombre_consecutivos='Facturas'");
					
					
					
					

					$html="";
					$fechaactual = getdate();
					$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
					 
					$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/aguafacturacion';
					$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
					$domLogo=$directorio.'/view/images/agua.png';
					$logo = '<img src="'.$domLogo.'" alt="Responsive image" width="130" height="70">';
					 
					
					 
					$columnas = " marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua,
					  medidores_agua.id_medidores_agua,
					  medidores_agua.identificador_medidores_agua,
					  clientes.id_clientes,
					  clientes.razon_social_clientes,
					  tipo_identificacion.id_tipo_identificacion,
					  tipo_identificacion.nombre_tipo_identificacion,
					  clientes.identificacion_clientes,
					  tipo_persona.id_tipo_persona,
					  tipo_persona.nombre_tipo_persona,
					  tipo_consumo.id_tipo_consumo,
					  tipo_consumo.nombre_tipo_consumo,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_inicial,
					  marcaciones_mensuales_medidor_agua.marcacion_mensual_final,
					  marcaciones_mensuales_medidor_agua.fecha_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.valor_pago_mensual_correspondiente,
					  marcaciones_mensuales_medidor_agua.tipo_registro,
					  marcaciones_mensuales_medidor_agua.id_estado,
					  marcaciones_mensuales_medidor_agua.numero_factura,
					  marcaciones_mensuales_medidor_agua.id_usuarios_registra";
					
					$tablas   = " public.marcaciones_mensuales_medidor_agua,
					  public.clientes,
					  public.tipo_persona,
					  public.tipo_identificacion,
					  public.tipo_consumo,
					  public.solicitudes,
					  public.medidores_agua";
					
					$id       = "marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua";
						
						
					$where    = " marcaciones_mensuales_medidor_agua.id_medidores_agua = medidores_agua.id_medidores_agua AND
					clientes.id_clientes = marcaciones_mensuales_medidor_agua.id_clientes AND
					clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
					clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
					solicitudes.id_clientes = clientes.id_clientes AND
					solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND marcaciones_mensuales_medidor_agua.id_marcaciones_mensuales_medidor_agua='$_id_marcaciones_mensuales_medidor_agua'";
						
					 
					$resultSetCabeza=$marcaciones_mensuales->getCondiciones($columnas, $tablas, $where, $id);
					
					
					$usuarios = new UsuariosModel();
					
					
					$_id_usuarios_registra=0;
					$_id_usuarios_aprueba=0;
					$_nombre_usuarios_registra="";
					$_nombre_usuarios_aprueba="";
					
					
					if(!empty($resultSetCabeza)){
					
					
					
						$numero_solicitudes     =$resultSetCabeza[0]->numero_factura;
						$_nombre_tipo_persona       =$resultSetCabeza[0]->nombre_tipo_persona;
						$_nombre_tipo_identificacion   =$resultSetCabeza[0]->nombre_tipo_identificacion;
						$_razon_social_clientes   =$resultSetCabeza[0]->razon_social_clientes;
						$_identificacion_clientes =$resultSetCabeza[0]->identificacion_clientes;
						$_nombre_tipo_consumo =$resultSetCabeza[0]->nombre_tipo_consumo;
						$_id_estado	=$resultSetCabeza[0]->id_estado;
						$_id_usuarios_registra =$resultSetCabeza[0]->id_usuarios_registra;
						
					
					
						if($_id_usuarios_registra>0){
								
							$resultUsuAprue= $usuarios->getBy("id_rol='47'");
							$_nombre_usuarios_aprueba=$resultUsuAprue[0]->nombre_usuarios;
								
						}else{
								
							$_nombre_usuarios_aprueba="";
						}
					
					
					
					
						$html.='<p style="text-align: right;">'.$logo.'<hr style="height: 2px; background-color: black;"></p>';
						$html.='<p style="text-align: right; font-size: 13px;"><b>Fecha Factura:</b> '.$fechaactual.'</p>';
						$html.='<p style="text-align: center; font-size: 16px; margin-top:60px;"><b>Factura No. '.$numero_solicitudes.'</b></p>';
					
					
						$html.='<table style="width: 100%; margin-top:30px;">';
					
						$html.='<tr>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Persona</th>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Identificación</th>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Identificación</th>';
						$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Razón Social</th>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Consumo</th>';
						$html.='</tr>';
					
						$html.='<tr>';
					
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_persona.'</td>';
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_identificacion.'</td>';
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_identificacion_clientes.'</td>';
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_razon_social_clientes.'</td>';
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_consumo.'</td>';
					
						
						$html.='</tr>';
						$html.='</table>';
					
					
						if(!empty($resultSetCabeza)){
								
								
								
							$html.= "<table style='width: 100%; margin-top:40px;' border=1 cellspacing=0>";
							$html.= "<thead>";
							$html.= "<tr>";
							$html.='<th style="text-align: left;  font-size: 13px;">Consumo</th>';
							$html.='<th style="text-align: left;  font-size: 13px;">Mes Correspondiente</th>';
							$html.='<th style="text-align: left;  font-size: 13px;">Marcación Inicial</th>';
							$html.='<th style="text-align: left;  font-size: 13px;">Marcación Final</th>';
							$html.='<th style="text-align: left;  font-size: 13px;">Valor</th>';
							$html.='</tr>';
							$html.='</thead>';
							$html.='<tbody>';
								
							$i=0;
							$i=0; $valor_total_db=0; $valor_total_vista=0;
					
							foreach ($resultSetCabeza as $res)
							{
								$valor_total_db=$res->valor_pago_mensual_correspondiente;
								$valor_total_vista=$valor_total_vista+$valor_total_db;
					
								$i++;
								$html.='<tr>';
								$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_consumo.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->fecha_pago_mensual_correspondiente.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_inicial.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->marcacion_mensual_final.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->valor_pago_mensual_correspondiente.'</td>';
								
								$html.='</tr>';
					
								$valor_total_db=0;
							}
								
							$valor_total_vista= number_format($valor_total_vista, 2, '.', ',');
								
					
							$html.='<tr>';
							$html.='<td class="text-right" colspan=3></td>';
							$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>SubTotal</b></td>';
							$html.='<td class="text-left" style="font-size: 12px;">'.$valor_total_vista.'</td>';
							$html.='</tr>';
					
							
							$valor_FIN=0; $valor_FIN=$valor_total_vista;
							$valor_FIN= number_format($valor_FIN, 2, '.', ',');
					
							$html.='<tr>';
							$html.='<td class="text-right" colspan=3></td>';
							$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>TOTAL $</b></td>';
							$html.='<td class="text-right" style="font-size: 11px;">'.$valor_FIN.'</td>';
					
							$html.='</tr>';
					
					
					
								
							$html.='</tbody>';
							$html.='</table>';
								
								
						}
					
					
						$html.='<table style="width: 100%; margin-top:40px;">';
					
						$html.='<tr>';
						$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Cajero</th>';
						$html.='<th colspan="4" style="text-align:left; font-size: 13px;"></th>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
						$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
						$html.='</tr>';
					
						$html.='<tr>';
					
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_usuarios_aprueba.'</td>';
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;"></td>';
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
					
						$html.='</tr>';
						$html.='</table>';
					
					
					}
					 
					 
					$this->report("Factura",array( "resultSet"=>$html, "numero_solicitudes"=>$numero_solicitudes));
					die();
						
					
					
					
					
					
				}else{
					 
					 
				}
				 
			}
	
			$this->redirect("Facturar", "index");
	
		}else{
		  
			$error = TRUE;
			$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	
			$this->view("Login",array(
					"resultSet"=>"$mensaje", "error"=>$error
			));
	
	
			die();
		  
		}
	}
	
	
	
	
	
	
	
	
	public function  paginate_marcaciones($reload, $page, $tpages, $adjacents){
		


		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
		
		// previous label
		
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_marcaciones(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_marcaciones(".($page-1).")'>$prevlabel</a></span></li>";
		
		}
		
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_marcaciones(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_marcaciones(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_marcaciones(".$i.")'>$i</a></li>";
			}
		}
		
		// interval
		
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
		
		// last
		
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_marcaciones($tpages)'>$tpages</a></li>";
		}
		
		// next
		
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_marcaciones(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
		
		$out.= "</ul>";
		return $out;
		
		
	}
	
	

	public function paginate_aprobadas($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_aprobadas(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_aprobadas(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_aprobadas(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_aprobadas(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_aprobadas(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_aprobadas($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_aprobadas(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	public function  generar_factura_servicios(){
			
		session_start();
		$solicitudes = new SolicitudesModel();
		$solicitudes_detalle = new SolicitudesDetalleModel();
			
	
		$html="";
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
		$fechaactual = getdate();
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
			
		$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/aguafacturacion';
		$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
		$domLogo=$directorio.'/view/images/agua.png';
		$logo = '<img src="'.$domLogo.'" alt="Responsive image" width="130" height="70">';
			
			
			
		if(!empty($cedula_usuarios)){
	
	
			if(isset($_GET["id_solicitudes"])){
					
					
				$_id_solicitudes = $_GET["id_solicitudes"];
				$_id_clientes = $_GET["id_clientes"];
	
					
				$columnas = "solicitudes.id_solicitudes,
								  clientes.id_clientes,
								  clientes.razon_social_clientes,
								  clientes.id_tipo_identificacion,
								  clientes.id_tipo_persona,
								  clientes.identificacion_clientes,
								  tipo_consumo.id_tipo_consumo,
								  tipo_consumo.nombre_tipo_consumo,
								  solicitudes.numero_factura,
						          tipo_persona.nombre_tipo_persona,
						          tipo_identificacion.nombre_tipo_identificacion,
						          solicitudes.fecha_registro,
						          solicitudes.id_estado,
						          solicitudes.id_usuarios_registra,
						          solicitudes.id_usuarios_aprueba";
	
				$tablas   = "public.solicitudes,
									  public.clientes,
									  public.tipo_consumo,
						              public.tipo_identificacion,
						              public.tipo_persona";
	
				$id       = "solicitudes.id_solicitudes";
	
	
				$where    = " tipo_identificacion.id_tipo_identificacion =clientes.id_tipo_identificacion AND tipo_persona.id_tipo_persona= clientes.id_tipo_persona AND solicitudes.id_tipo_consumo = tipo_consumo.id_tipo_consumo AND
				clientes.id_clientes = solicitudes.id_clientes AND solicitudes.id_solicitudes='$_id_solicitudes' AND clientes.id_clientes = '$_id_clientes' ";
	
	
	
					
					
				$resultSetCabeza=$solicitudes->getCondiciones($columnas, $tablas, $where, $id);
	
	
				$usuarios = new UsuariosModel();
	
	
				$_id_usuarios_registra=0;
				$_id_usuarios_aprueba=0;
				$_nombre_usuarios_registra="";
				$_nombre_usuarios_aprueba="";
	
	
				if(!empty($resultSetCabeza)){
	
	
	
					$_numero_solicitudes     =$resultSetCabeza[0]->numero_factura;
					$_nombre_tipo_persona       =$resultSetCabeza[0]->nombre_tipo_persona;
					$_nombre_tipo_identificacion   =$resultSetCabeza[0]->nombre_tipo_identificacion;
					$_razon_social_clientes   =$resultSetCabeza[0]->razon_social_clientes;
					$_identificacion_clientes =$resultSetCabeza[0]->identificacion_clientes;
					$_nombre_tipo_consumo =$resultSetCabeza[0]->nombre_tipo_consumo;
					$_id_estado	=$resultSetCabeza[0]->id_estado;
					$_id_usuarios_registra =$resultSetCabeza[0]->id_usuarios_registra;
					$_id_usuarios_aprueba =$resultSetCabeza[0]->id_usuarios_aprueba;
	
					$_fecha_registro          =date("d/m/Y", strtotime($resultSetCabeza[0]->fecha_registro));
					$_fecha_registro=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	
	
					if($_id_usuarios_registra>0){
	
						$resultUsuReg= $usuarios->getBy("id_usuarios='$_id_usuarios_registra'");
						$_nombre_usuarios_registra=$resultUsuReg[0]->nombre_usuarios;
							
					}else{
	
						$_nombre_usuarios_registra="";
					}
						
						
						
	
					if($_id_usuarios_aprueba>0){
							
						$resultUsuAprue= $usuarios->getBy("id_rol='47'");
						$_nombre_usuarios_aprueba=$resultUsuAprue[0]->nombre_usuarios;
							
					}else{
							
						$_nombre_usuarios_aprueba="";
					}
						
	
					$columnas1 = "solicitudes_detalle.id_solicitudes_detalle,
									  solicitudes_detalle.id_solicitudes,
									  tarifas.id_tarifas,
									  tarifas.nombre_tarifa,
							          tarifas.valor_tarifa";
						
					$tablas1   = " public.tarifas,
  										public.solicitudes_detalle";
						
					$id1       = "solicitudes_detalle.id_solicitudes_detalle";
						
						
					$where1    = " solicitudes_detalle.id_tarifas = tarifas.id_tarifas AND solicitudes_detalle.id_solicitudes='$_id_solicitudes' ";
						
					$resultSetDetalle=$solicitudes_detalle->getCondiciones($columnas1, $tablas1, $where1, $id1);
	
						
					$html.='<p style="text-align: right;">'.$logo.'<hr style="height: 2px; background-color: black;"></p>';
					$html.='<p style="text-align: right; font-size: 13px;"><b>Fecha Factura:</b> '.$_fecha_registro.'</p>';
					$html.='<p style="text-align: center; font-size: 16px; margin-top:60px;"><b>Factura No. '.$_numero_solicitudes.'</b></p>';
	
						
					$html.='<table style="width: 100%; margin-top:30px;">';
	
					$html.='<tr>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Persona</th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Identificación</th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Identificación</th>';
					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Razón Social</th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Tipo Consumo</th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Estado Solicitud</th>';
					$html.='</tr>';
	
					$html.='<tr>';
	
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_persona.'</td>';
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_identificacion.'</td>';
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_identificacion_clientes.'</td>';
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_razon_social_clientes.'</td>';
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_nombre_tipo_consumo.'</td>';
	
					if($_id_estado==3){
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Pendiente</td>';
					}else if($_id_estado==2){
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Anulada</td>';
					}else {
						$html.='<td colspan="2" style="text-align:left; font-size: 13px;">Aprobada</td>';
					}
	
					$html.='</tr>';
					$html.='</table>';
	
	
					if(!empty($resultSetDetalle)){
							
							
							
						$html.= "<table style='width: 100%; margin-top:40px;' border=1 cellspacing=0>";
						$html.= "<thead>";
						$html.= "<tr>";
						$html.='<th style="text-align: left;  font-size: 13px;">Descripción</th>';
						$html.='<th style="text-align: left;  font-size: 13px;">Cantidad</th>';
						$html.='<th style="text-align: left;  font-size: 13px;">Valor C/U</th>';
						$html.='<th style="text-align: left;  font-size: 13px;">Valor Total</th>';
						$html.='</tr>';
						$html.='</thead>';
						$html.='<tbody>';
							
						$i=0;
						$i=0; $valor_total_db=0; $valor_total_vista=0;
						
						foreach ($resultSetDetalle as $res)
						{
							$valor_total_db=$res->valor_tarifa;
							$valor_total_vista=$valor_total_vista+$valor_total_db;
								
							
							$i++;
							$html.='<tr>';
							$html.='<td style="font-size: 11px;">'.$res->nombre_tarifa.'</td>';
							$html.='<td style="font-size: 11px;">1</td>';
							$html.='<td style="font-size: 11px;">'.$res->valor_tarifa.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->valor_tarifa.'</td>';
							$html.='</tr>';
							
							$valor_total_db=0;
						}
							
						$valor_total_vista= number_format($valor_total_vista, 2, '.', ',');
							
						
						$html.='<tr>';
						$html.='<td class="text-right" colspan=2></td>';
						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>SubTotal</b></td>';
						$html.='<td class="text-left" style="font-size: 12px;">'.$valor_total_vista.'</td>';
						$html.='</tr>';
						
						$valor_iva=0; $valor_iva=$valor_total_vista*0.12;
						$valor_iva= number_format($valor_iva, 2, '.', ',');
						
						
						$html.='<tr>';
						$html.='<td class="text-right" colspan=2></td>';
						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>Iva 12%</b></td>';
						$html.='<td class="text-left" style="font-size: 11px;">'.$valor_iva.'</td>';
						$html.='</tr>';
						
						$valor_FIN=0; $valor_FIN=$valor_total_vista+$valor_iva;
						$valor_FIN= number_format($valor_FIN, 2, '.', ',');
						
						$html.='<tr>';
						$html.='<td class="text-right" colspan=2></td>';
						$html.='<td class="text-right" colspan=1 style="font-size: 11px;"><b>TOTAL $</b></td>';
						$html.='<td class="text-right" style="font-size: 11px;">'.$valor_FIN.'</td>';
						
						$html.='</tr>';
						
						
						
							
						$html.='</tbody>';
						$html.='</table>';
							
							
					}
	
	
					$html.='<table style="width: 100%; margin-top:40px;">';
	
					$html.='<tr>';
					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Cajero</th>';
					$html.='<th colspan="4" style="text-align:left; font-size: 13px;"></th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
					$html.='<th colspan="2" style="text-align:left; font-size: 13px;"></th>';
					$html.='</tr>';
	
					$html.='<tr>';
	
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_usuarios_aprueba.'</td>';
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;"></td>';
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;"></td>';
	
					$html.='</tr>';
					$html.='</table>';
	
	
				}
					
					
				$this->report("FacturaReporte",array( "resultSet"=>$html));
				die();
					
					
			}
	
	
	
	
		}else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
			
			
			
			
			
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	
	
	
}
?>
