<?php
class ConsultaSolicitudesController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function pendientes(){
    
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
  solicitudes.id_clientes = clientes.id_clientes AND solicitudes.id_estado=3 ";
    	$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
    	
    	
    	 
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
    			$html.= "<table id='tabla_pendientes' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;"># Solicitud</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci /Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Reg.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
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
    				$html.='<td style="font-size: 11px;">'.$res->numero_solicitudes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_persona.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_registro.'</td>';
    				
    				$html.='<td style="font-size: 11px;">Pendiente</td>';
    				$html.='<td style="font-size: 11px;"><a href="view/DevuelvePDFView.php?id_valor='.$res->id_solicitudes.'&id_nombre=id_solicitudes&tabla=solicitudes&campo=documentacion_solicitudes" target="_blank" title="Ver Documentación"><img src="view/images/pdf.png" width="80" height="40"></a></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=ConsultaSolicitudes&action=index2&id_clientes='.$res->id_clientes.'&id_solicitudes='.$res->id_solicitudes.'" title="Aprobar / Anular" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Solicitudes&action=generar_solicitud&id_clientes='.$res->id_clientes.'&id_solicitudes='.$res->id_solicitudes.'" target="_blank" title="Imprimir" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" target="_blank" title="Geoposicionar" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_pendientes("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitudes pendientes registrados...</b>';
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
  solicitudes.id_clientes = clientes.id_clientes AND solicitudes.id_estado=1 ";
    	$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
    	
    	
    	 
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
    				$html.='<td style="font-size: 11px;">'.$res->numero_solicitudes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_persona.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_registro.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_aprueba_registros.'</td>';
    				
    				$html.='<td style="font-size: 11px;">Aprobada</td>';
    				$html.='<td style="font-size: 11px;"><a href="view/DevuelvePDFView.php?id_valor='.$res->id_solicitudes.'&id_nombre=id_solicitudes&tabla=solicitudes&campo=documentacion_solicitudes" title="Ver Documentación" target="_blank"><img src="view/images/pdf.png" width="80" height="40"></a></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Solicitudes&action=generar_solicitud&id_clientes='.$res->id_clientes.'&id_solicitudes='.$res->id_solicitudes.'" title="Imprimir" target="_blank" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" target="_blank" class="btn btn-info" title="Geoposicionar" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				
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
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitudes aprobadas registrados...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    
    	}
    
    
    }
    
    
    
    

    public function  anuladas(){
    
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
  solicitudes.id_clientes = clientes.id_clientes AND solicitudes.id_estado=2 ";
    	$resultEdit = $solicitudes->getCondiciones($columnas ,$tablas ,$where, $id);
    	 
    	 
    
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
    			$html.= "<table id='tabla_anuladas' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;"># Solicitud</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci /Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Reg.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Anu.</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;"></th>';
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
    				$html.='<td style="font-size: 11px;">'.$res->numero_solicitudes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_persona.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_identificacion.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->identificacion_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->razon_social_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_registro.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_aprueba_registros.'</td>';
    
    				$html.='<td style="font-size: 11px;">Anulada</td>';
    				$html.='<td style="font-size: 11px;"><a href="view/DevuelvePDFView.php?id_valor='.$res->id_solicitudes.'&id_nombre=id_solicitudes&tabla=solicitudes&campo=documentacion_solicitudes" title="Ver Documentación" target="_blank"><img src="view/images/pdf.png" width="80" height="40"></a></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Solicitudes&action=generar_solicitud&id_clientes='.$res->id_clientes.'&id_solicitudes='.$res->id_solicitudes.'" title="Imprimir" target="_blank" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" target="_blank" class="btn btn-info" title="Geoposicionar" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    				 
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_anuladas("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitudes anuladas registrados...</b>';
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
			
			$tipo_consumo = new TipoConsumoModel();
			$resultTip_Con = $tipo_consumo->getAll("nombre_tipo_consumo");
			
			
			$tarifas = new TarifasModel();
			$resultTarifa = $tarifas->getAll("id_tarifas");
				
			
			$nombre_controladores = "ConsultaSolicitudes";
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
			
					
					$this->view("ConsultaSolicitudes",array(
							"resultEdit" =>$resultEdit, 
							"resultTipIdenti"=>$resultTipIdenti, "resultTip_Con"=>$resultTip_Con, "resultTip_Per"=>$resultTip_Per,
							"resultTarifa"=>$resultTarifa, "result_tar"=>$result_tar
					
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Solicitudes"
			
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
				
				
			$tarifas = new TarifasModel();
			$resultTarifa = $tarifas->getAll("id_tarifas");
	
				
			$nombre_controladores = "ConsultaSolicitudes";
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
					
					
				$this->view("ConsultaSolicitudesDetalle",array(
						"resultEdit" =>$resultEdit,
						"resultTipIdenti"=>$resultTipIdenti, "resultTip_Con"=>$resultTip_Con, "resultTip_Per"=>$resultTip_Per,
						"resultTarifa"=>$resultTarifa, "result_tar"=>$result_tar
							
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Solicitudes"
		
				));
					
			}
				
	
		}
		else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
	
	}
	
	
	
	
	
	
	
	
	public function InsertaSolicitudes(){
			
		session_start();
		$resultado = null;
		
		
		$solicitudes=new SolicitudesModel();
		$solicitides_detalle =new SolicitudesDetalleModel();
		
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			
		if (isset ($_GET["id_clientes"]))
		{
			$_id_clientes    = $_GET["id_clientes"];
			$_id_usuarios   = $_SESSION["id_usuarios"];
			$_id_estado  = $_GET["id_estado"];
			$_id_solicitudes = $_GET["id_solicitudes"];
			date_default_timezone_set('America/Guayaquil');
			$fechaActual = date('d-m-Y H:i:s');
		    
		    
		    if($_id_solicitudes > 0){
		    	
		        
		        $colval1 = "estado='FALSE' ";
		        $tabla1 = "solicitudes";
		        $where1 = "id_clientes = '$_id_clientes'";
		        $resultado=$solicitudes->UpdateBy($colval1, $tabla1, $where1);
		        
		        
		    		$colval = "id_usuarios_aprueba='$_id_usuarios', fecha_aprueba_registros='$fechaActual', id_estado='$_id_estado', estado='TRUE' ";
		    		$tabla = "solicitudes";
		    		$where = "id_clientes = '$_id_clientes' AND id_solicitudes='$_id_solicitudes'";
		    		$resultado=$solicitudes->UpdateBy($colval, $tabla, $where);
		    	
		    }else{
		    	
		    	
		    }
		  
		   
		    $this->redirect("ConsultaSolicitudes", "index");
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
	
	
	
	
	public function paginate_pendientes($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_pendientes(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_pendientes(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_pendientes(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_pendientes(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_pendientes(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_pendientes($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_pendientes(".($page+1).")'>$nextlabel</a></span></li>";
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
	
	
	
	public function paginate_anuladas($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_anuladas(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_anuladas(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_anuladas(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_anuladas(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_anuladas(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_anuladas($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_anuladas(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	


	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
}
?>
