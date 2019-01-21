<?php
class ClientesController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function index10(){
    
    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$clientes = new ClientesModel();
    	$where_to="";
    	$columnas = " clientes.id_clientes, 
					  clientes.razon_social_clientes, 
					  tipo_identificacion.id_tipo_identificacion, 
					  tipo_identificacion.nombre_tipo_identificacion, 
					  clientes.identificacion_clientes, 
					  provincias.id_provincias, 
					  provincias.nombre_provincias, 
					  cantones.id_cantones, 
					  cantones.nombre_cantones, 
					  parroquias.id_parroquias, 
					  parroquias.nombre_parroquias, 
					  clientes.direccion_clientes, 
					  clientes.telefono_clientes, 
					  clientes.celular_clientes, 
					  clientes.correo_clientes, 
					  estado.id_estado, 
					  estado.nombre_estado, 
					  tipo_persona.id_tipo_persona, 
					  tipo_persona.nombre_tipo_persona, 
					  clientes.fecha_nacimiento_clientes, 
					  clientes.creado";
    	
    	$tablas   = "public.clientes, 
					  public.parroquias, 
					  public.provincias, 
					  public.cantones, 
					  public.tipo_persona, 
					  public.tipo_identificacion, 
					  public.estado";
    	
    	$id       = "clientes.id_clientes";
    	
    	
    	$where    = "clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
					  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
					  clientes.id_provincias = provincias.id_provincias AND
					  clientes.id_cantones = cantones.id_cantones AND
					  clientes.id_parroquias = parroquias.id_parroquias AND
					  clientes.id_estado = estado.id_estado AND clientes.id_estado=1";
					    	
    
    	 
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	 
    	 
    	 
    	 
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%' OR estado.nombre_estado LIKE '".$search."%')";
    
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
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci /Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Provincia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Cantón</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Parroquia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    
    			if($id_rol==1){
    				 
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				
    				 
    			}else{
    				 
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				
    				
    			}
    
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
    				$html.='<td style="font-size: 11px;">'.$res->correo_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_nacimiento_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->celular_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_provincias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_cantones.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_parroquias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_estado.'</td>';
    				 
    				if($id_rol==1){
    					 
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" class="btn btn-success" title="Editar" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=borrarId&id_clientes='.$res->id_clientes.'" class="btn btn-danger" title="Eliminar" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" title="Geoposicionar" target="_blank" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-search"></i></a></span></td>';
    					
    					 
    				}else{
    					 
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" class="btn btn-success" title="Editar" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" title="Geoposicionar" target="_blank" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    					
    				}
    				 
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_clientes_activos("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay clientes activos registrados...</b>';
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
    	$columnas = " clientes.id_clientes,
					  clientes.razon_social_clientes,
					  tipo_identificacion.id_tipo_identificacion,
					  tipo_identificacion.nombre_tipo_identificacion,
					  clientes.identificacion_clientes,
					  provincias.id_provincias,
					  provincias.nombre_provincias,
					  cantones.id_cantones,
					  cantones.nombre_cantones,
					  parroquias.id_parroquias,
					  parroquias.nombre_parroquias,
					  clientes.direccion_clientes,
					  clientes.telefono_clientes,
					  clientes.celular_clientes,
					  clientes.correo_clientes,
					  estado.id_estado,
					  estado.nombre_estado,
					  tipo_persona.id_tipo_persona,
					  tipo_persona.nombre_tipo_persona,
					  clientes.fecha_nacimiento_clientes,
					  clientes.creado";
    	 
    	$tablas   = "public.clientes,
					  public.parroquias,
					  public.provincias,
					  public.cantones,
					  public.tipo_persona,
					  public.tipo_identificacion,
					  public.estado";
    	 
    	$id       = "clientes.id_clientes";
    	 
    	 
    	$where    = "clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
					  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
					  clientes.id_provincias = provincias.id_provincias AND
					  clientes.id_cantones = cantones.id_cantones AND
					  clientes.id_parroquias = parroquias.id_parroquias AND
					  clientes.id_estado = estado.id_estado AND clientes.id_estado=2";
    	
    	
    	
    	
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	
    	
    	
    	
    	if($action == 'ajax')
    	{
    	
    		if(!empty($search)){
    	
    	
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%' OR estado.nombre_estado LIKE '".$search."%')";
    	
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
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Per</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Tipo Ide</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Ci / Ruc</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Provincia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Cantón</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Parroquia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    	
    			if($id_rol==1){
    					
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				
    					
    			}else{
    					
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    				
    	
    			}
    	
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
    				$html.='<td style="font-size: 11px;">'.$res->correo_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->fecha_nacimiento_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->celular_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_provincias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_cantones.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_parroquias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_estado.'</td>';
    					
    				if($id_rol==1){
    	
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" title="Editar" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" title="Geoposicionar" target="_blank" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    					
    	
    				}else{
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" title="Editar" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Geoposicionamiento&action=index2&id_clientes='.$res->id_clientes.'" title="Geoposicionar" target="_blank" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
    					 
    	
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
		
			
			$clientes = new ClientesModel();
			
				
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
			
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
			
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
				
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
			
			$estado = new EstadoModel();
			$resultEst = $estado->getAll("nombre_estado");
			
			$tipo_persona = new TipoPersonaModel();
			$resultTip_Per = $tipo_persona->getAll("nombre_tipo_persona");
			
			$nombre_controladores = "Clientes";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $clientes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
					$resultEdit = "";
			
					if (isset ($_GET["id_clientes"])   )
					{
						$_id_clientes = $_GET["id_clientes"];
						
						$columnas = "clientes.id_clientes, 
								  clientes.razon_social_clientes, 
								  tipo_identificacion.id_tipo_identificacion, 
								  tipo_identificacion.nombre_tipo_identificacion, 
								  clientes.identificacion_clientes, 
								  provincias.id_provincias, 
								  provincias.nombre_provincias, 
								  cantones.id_cantones, 
								  cantones.nombre_cantones, 
								  parroquias.id_parroquias, 
								  parroquias.nombre_parroquias, 
								  clientes.direccion_clientes, 
								  clientes.telefono_clientes, 
								  clientes.celular_clientes, 
								  clientes.correo_clientes, 
								  estado.id_estado, 
								  estado.nombre_estado, 
								  tipo_persona.id_tipo_persona, 
								  tipo_persona.nombre_tipo_persona, 
								  clientes.fecha_nacimiento_clientes, 
								  clientes.creado,
								  clientes.discapacidad_clientes";
						
						$tablas   = "public.clientes, 
									  public.parroquias, 
									  public.provincias, 
									  public.cantones, 
									  public.tipo_persona, 
									  public.tipo_identificacion, 
									  public.estado";
						
						$id       = "clientes.id_clientes";
						
						
						$where    = " clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
									  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
									  clientes.id_provincias = provincias.id_provincias AND
									  clientes.id_cantones = cantones.id_cantones AND
									  clientes.id_parroquias = parroquias.id_parroquias AND
									  clientes.id_estado = estado.id_estado AND clientes.id_clientes = '$_id_clientes' "; 
						$resultEdit = $clientes->getCondiciones($columnas ,$tablas ,$where, $id); 
					}
			
					
					$this->view("Clientes",array(
							"resultEdit" =>$resultEdit, "resultProvincias"=>$resultProvincias,
							"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
							"resultTipIdenti"=>$resultTipIdenti, "resultEst"=>$resultEst, "resultTip_Per"=>$resultTip_Per
					
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Clientes"
			
				));
			
			}
			
		
		}
		else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
		
	}
	
	
	
	
	
	
	
	
	public function InsertaClientes(){
			
		session_start();
		$resultado = null;
		$clientes=new ClientesModel();
		$usuarios=new UsuariosModel();
		
		$provincias = new ProvinciasModel();
			
		$parroquias = new ParroquiasModel();
			
		$cantones = new CantonesModel();
			
		
		$_clave_usuario = "";
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
		if (isset ($_POST["identificacion_clientes"]))
		{
			$_id_tipo_identificacion    = $_POST["id_tipo_identificacion"];
			
			
			$_identificacion_clientes      = $_POST["identificacion_clientes"];
			$_razon_social_clientes        = $_POST["razon_social_clientes"];
			$_id_tipo_persona   		   = $_POST["id_tipo_persona"];
			$_fecha_nacimiento_clientes    = $_POST["fecha_nacimiento_clientes"];
			$_telefono_clientes    = $_POST["telefono_clientes"];
			$_celular_clientes     = $_POST["celular_clientes"];
		    $_correo_clientes      = $_POST["correo_clientes"];
		    $_id_provincias        = $_POST["id_provincias"];
		    $_id_cantones          = $_POST["id_cantones"];
		    $_id_parroquias          = $_POST["id_parroquias"];
		    $_direccion_clientes     = $_POST["direccion_clientes"];
		    $_id_estado            = $_POST["id_estado"];
		    $_id_clientes            = $_POST["id_clientes"];
		    $_discapacidad_clientes  = $_POST["discapacidad_clientes"];
		    
		    
		    
		    
		    if($_id_clientes > 0){
		    	
		    	
		    	

		    	$resultProv= $provincias->getBy("id_provincias='$_id_provincias'");
		    	$nombre_provincias=$resultProv[0]->nombre_provincias;
		    	
		    	$resultCan= $cantones->getBy("id_cantones='$_id_cantones'");
		    	$nombre_cantones=$resultCan[0]->nombre_cantones;
		    	 
		    	$resultParro= $parroquias->getBy("id_parroquias='$_id_parroquias'");
		    	$nombre_parroquias=$resultParro[0]->nombre_parroquias;
		    	 
		    	 
		    	$address = urlencode($nombre_parroquias.', '.$_direccion_clientes.', '.'Ecuador');
		    	$googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyALVhAqBusTEJ4LDma_V176VezRpCXCcu4";
		    	$geocodeResponseData = file_get_contents($googleMapUrl);
		    	$responseData = json_decode($geocodeResponseData, true);
		    	
		    	if($responseData['status']=='OK') {
		    		 
		    		$latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
		    		$longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
		    		$formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
		    		 
		    		 
		    		/*if($latitude && $longitude && $formattedAddress) {
		    		 $geocodeData = array();
		    		 array_push(
		    		 $geocodeData,
		    		 $latitude,
		    		 $longitude,
		    		 $formattedAddress
		    		 );
		    	
		    		 } */
		    		 
		    	}else{
		    		 
		    		$latitude = "";
		    		$longitude = "";
		    		$formattedAddress = "";
		    		 
		    	}
		    	
		    	
		    	if($_id_tipo_persona==1){
		    		
		    		$colval = "id_tipo_identificacion='$_id_tipo_identificacion',
		    		identificacion_clientes= '$_identificacion_clientes',
		    		id_tipo_persona = '$_id_tipo_persona',
		    		razon_social_clientes = '$_razon_social_clientes',
		    		fecha_nacimiento_clientes='$_fecha_nacimiento_clientes',
		    		telefono_clientes = '$_telefono_clientes',
		    		celular_clientes = '$_celular_clientes',
		    		correo_clientes = '$_correo_clientes',
		    		id_provincias = '$_id_provincias',
		    		id_cantones = '$_id_cantones',
		    		id_parroquias= '$_id_parroquias',
		    		direccion_clientes='$_direccion_clientes',
		    		id_estado='$_id_estado',
		    		lat='$latitude',
		    		lng='$longitude',
		    		formato_direccion_clientes='$formattedAddress',
		    		discapacidad_clientes='$_discapacidad_clientes'";
		    		$tabla = "clientes";
		    		$where = "id_clientes = '$_id_clientes'";
		    		$resultado=$clientes->UpdateBy($colval, $tabla, $where);
		    		 
		    		
		    	}else{
		    		
		    		
		    		$colval = "id_tipo_identificacion='$_id_tipo_identificacion',
		    		identificacion_clientes= '$_identificacion_clientes',
		    		id_tipo_persona = '$_id_tipo_persona',
		    		razon_social_clientes = '$_razon_social_clientes',
		    		fecha_nacimiento_clientes=NULL,
		    		telefono_clientes = '$_telefono_clientes',
		    		celular_clientes = '$_celular_clientes',
		    		correo_clientes = '$_correo_clientes',
		    		id_provincias = '$_id_provincias',
		    		id_cantones = '$_id_cantones',
		    		id_parroquias= '$_id_parroquias',
		    		direccion_clientes='$_direccion_clientes',
		    		id_estado='$_id_estado',
		    		lat='$latitude',
		    		lng='$longitude',
		    		formato_direccion_clientes='$formattedAddress',
		    		discapacidad_clientes='FALSE'";
		    		$tabla = "clientes";
		    		$where = "id_clientes = '$_id_clientes'";
		    		$resultado=$clientes->UpdateBy($colval, $tabla, $where);
		    		
		    		
		    	}
		    	
		    		
		    	
		    }else{
		    	

		    	$resultProv= $provincias->getBy("id_provincias='$_id_provincias'");
		    	$nombre_provincias=$resultProv[0]->nombre_provincias;
		    	 
		    	$resultCan= $cantones->getBy("id_cantones='$_id_cantones'");
		    	$nombre_cantones=$resultCan[0]->nombre_cantones;
		    	
		    	$resultParro= $parroquias->getBy("id_parroquias='$_id_parroquias'");
		    	$nombre_parroquias=$resultParro[0]->nombre_parroquias;
		    	
		    	
		    	$address = urlencode($nombre_parroquias.', '.$_direccion_clientes.', '.'Ecuador');
		    	$googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyALVhAqBusTEJ4LDma_V176VezRpCXCcu4";
		    	$geocodeResponseData = file_get_contents($googleMapUrl);
		    	$responseData = json_decode($geocodeResponseData, true);
		    	 
		    	if($responseData['status']=='OK') {
		    		 
		    		$latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
		    		$longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
		    		$formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
		    	
		    	
		    		/*if($latitude && $longitude && $formattedAddress) {
		    		 $geocodeData = array();
		    		 array_push(
		    		 $geocodeData,
		    		 $latitude,
		    		 $longitude,
		    		 $formattedAddress
		    		 );
		    		  
		    		 } */
		    	
		    	}else{
		    	
		    		$latitude = "";
		    		$longitude = "";
		    		$formattedAddress = "";
		    	
		    	}
		    

		    	if($_id_tipo_persona==1){
		    	
		        	$funcion = "ins_clientes_nat";
		        	$parametros = "'$_razon_social_clientes',
		        	'$_id_tipo_identificacion',
		        	'$_identificacion_clientes',
		        	'1',
		        	'$_id_provincias',
		        	'$_id_cantones',
		        	'$_id_parroquias',
		        	'$_direccion_clientes',
		        	'$_telefono_clientes',
		        	'$_celular_clientes',
		        	'$_correo_clientes',
		        	'$_id_estado',
		        	'$_id_tipo_persona',
		        	'$_fecha_nacimiento_clientes',
		        	'$latitude',
		        	'$longitude',
		        	'$formattedAddress',
		        	'$_discapacidad_clientes'";
		        	$clientes->setFuncion($funcion);
		        	$clientes->setParametros($parametros);
		        	$resultado=$clientes->Insert();
		        	
		        	
		    	}else{
		    		
		    		$funcion = "ins_clientes";
		    		$parametros = "'$_razon_social_clientes',
		    		'$_id_tipo_identificacion',
		    		'$_identificacion_clientes',
		    		'1',
		    		'$_id_provincias',
		    		'$_id_cantones',
		    		'$_id_parroquias',
		    		'$_direccion_clientes',
		    		'$_telefono_clientes',
		    		'$_celular_clientes',
		    		'$_correo_clientes',
		    		'$_id_estado',
		    		'$_id_tipo_persona',
		    		'$latitude',
		    		'$longitude',
		    		'$formattedAddress'";
		    		$clientes->setFuncion($funcion);
		    		$clientes->setParametros($parametros);
		    		$resultado=$clientes->Insert();
		    		 
		    	} 
		        	
		        	
		        
		  }
		  
		   
		    $this->redirect("Clientes", "index");
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
	
	
	


	public function AutocompleteCedula(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$clientes = new ClientesModel();
		$identificacion_clientes = $_GET['term'];
			
		$resultSet=$clientes->getBy("identificacion_clientes LIKE '$identificacion_clientes%'");
			
		if(!empty($resultSet)){
	
			foreach ($resultSet as $res){
					
				$_identificacion_clientes[] = $res->identificacion_clientes;
			}
			echo json_encode($_identificacion_clientes);
		}
			
	}
	
	
	
	
	
	public function AutocompleteDevuelveNombres(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$clientes = new ClientesModel();
			
		$identificacion_clientes = $_POST['identificacion_clientes'];
		$resultSet=$clientes->getBy("identificacion_clientes = '$identificacion_clientes'");
			
		$respuesta = new stdClass();
			
		if(!empty($resultSet)){
	
			$respuesta->razon_social_clientes = $resultSet[0]->razon_social_clientes;
			$respuesta->id_tipo_persona = $resultSet[0]->id_tipo_persona;
			$respuesta->id_tipo_identificacion = $resultSet[0]->id_tipo_identificacion;
			$respuesta->identificacion_clientes = $resultSet[0]->identificacion_clientes;
			$respuesta->fecha_nacimiento_clientes = $resultSet[0]->fecha_nacimiento_clientes;
			$respuesta->id_paises = $resultSet[0]->id_paises;
			$respuesta->id_provincias = $resultSet[0]->id_provincias;
			$respuesta->id_cantones = $resultSet[0]->id_cantones;
			$respuesta->id_parroquias = $resultSet[0]->id_parroquias;
			$respuesta->direccion_clientes = $resultSet[0]->direccion_clientes;
			$respuesta->telefono_clientes = $resultSet[0]->telefono_clientes;
			$respuesta->celular_clientes = $resultSet[0]->celular_clientes;
			$respuesta->correo_clientes = $resultSet[0]->correo_clientes;
			$respuesta->id_estado = $resultSet[0]->id_estado;
			
			$var = $resultSet[0]->discapacidad_clientes;
			
			if($var=='t'){
				
				$respuesta->discapacidad_clientes = "TRUE";
					
			}else{
				$respuesta->discapacidad_clientes = "FALSE";
				
			}
			
			
			
			echo json_encode($respuesta);
		}
			
	}
	
	
	
	
	
	public function borrarId()
	{
		if(isset($_GET["id_clientes"]))
		{
			$id_clientes=(int)$_GET["id_clientes"];
			$clientes= new ClientesModel();
			$clientes->UpdateBy("id_estado=2","clientes","id_clientes='$id_clientes'");
				
		}
	
		$this->redirect("Clientes", "index");
	}
	
	
	
	
	public function paginate_clientes_activos($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_activos(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_activos(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_activos(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_activos(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_activos(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_activos($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_activos(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	

	public function paginate_clientes_inactivos($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_inactivos(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_inactivos(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_inactivos(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_inactivos(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_inactivos(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes_inactivos($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes_inactivos(".($page+1).")'>$nextlabel</a></span></li>";
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
