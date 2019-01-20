<?php
class AsignacionClientesMedidorAguaController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    

    public function consulta_medidores(){
    
    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$medidores_agua = new MedidoresAguaModel();
    	$where_to="";
    	$columnas = " medidores_agua.id_medidores_agua, 
					  medidores_agua.identificador_medidores_agua, 
					  medidores_agua.id_estado, 
					  estado.nombre_estado_medidores, 
					  medidores_agua.creado, 
					  medidores_agua.modificado";
    	
    	$tablas   = "public.estado, 
  					 public.medidores_agua";
    	
    	$id       = "medidores_agua.id_medidores_agua";
    	
    	
    	$where    = "medidores_agua.id_estado = estado.id_estado";
    	
    
    	 
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	 
    	 
    	 
    	 
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (medidores_agua.identificador_medidores_agua LIKE '%".$search."%' OR estado.nombre_estado_medidores LIKE '".$search."%')";
    
    			$where_to=$where.$where1;
    		}else{
    
    			$where_to=$where;
    
    		}
    
    		$html="";
    		$resultSet=$medidores_agua->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    
    		$per_page = 6; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    
    		$resultSet=$medidores_agua->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
    		$count_query   = $cantidadResult;
    		$total_pages = ceil($cantidadResult/$per_page);
    
    		 
    
    
    
    		if($cantidadResult>0)
    		{
    
    			$html.='<div class="pull-left" style="margin-left:11px;">';
    			$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    			$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
    			$html.='</div>';
    			$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
    			$html.='<section style="height:320px; overflow-y:scroll;">';
    			$html.= "<table id='tabla_medidores' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			
    			$html.='<th style="text-align: left;  font-size: 12px;">Medidor Agua</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Registro</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Asignación</th>';
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
    				$html.='<td style="font-size: 11px;">'.$res->nombre_estado_medidores.'</td>';
    				$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
    				
    				if(!empty($res->modificado) && $res->id_estado==1){
    					
    					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->modificado)).'</td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					
    				}else{
    					
    					$html.='<td style="font-size: 11px;"></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=AsignacionClientesMedidorAgua&action=index&id_medidores_agua='.$res->id_medidores_agua.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					
    				}
    				
    				
    				
    				$html.='</tr>';
    	
    			}
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_medidores_agua("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay medidores registrados...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    
    	}
    
    
    }
    
    
    
    public function  consulta_asignacion_medidores_clientes(){
    	


    	session_start();
    	$id_rol=$_SESSION["id_rol"];
    	$asignacion_clientes_medidor_agua = new AsignacionClientesMedidorAguaModel();
    	$where_to="";
    	$columnas = "asignacion_clientes_medidor_agua.id_asignacion_clientes_medidor_agua, 
					  asignacion_clientes_medidor_agua.id_clientes, 
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
					  clientes.telefono_clientes, 
					  clientes.celular_clientes, 
					  clientes.correo_clientes, 
					  clientes.id_estado, 
					  asignacion_clientes_medidor_agua.id_medidores_agua, 
					  medidores_agua.identificador_medidores_agua, 
					  asignacion_clientes_medidor_agua.creado, 
					  asignacion_clientes_medidor_agua.modificado";
    	 
    	$tablas   = "public.asignacion_clientes_medidor_agua, 
					  public.medidores_agua, 
					  public.clientes, 
					  public.paises, 
					  public.tipo_identificacion, 
					  public.provincias, 
					  public.cantones, 
					  public.parroquias";
    	 
    	$id       = "asignacion_clientes_medidor_agua.id_asignacion_clientes_medidor_agua";
    	 
    	 
    	$where    = "asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
					  medidores_agua.id_medidores_agua = asignacion_clientes_medidor_agua.id_medidores_agua AND
					  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
					  clientes.id_provincias = provincias.id_provincias AND
					  clientes.id_paises = paises.id_paises AND
					  cantones.id_cantones = clientes.id_cantones AND
					  parroquias.id_parroquias = clientes.id_parroquias";
    	 
    	
    	
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	
    	
    	
    	
    	if($action == 'ajax')
    	{
    	
    		if(!empty($search)){
    	
    	
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.razon_social_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%' OR medidores_agua.identificador_medidores_agua LIKE '%".$search."%')";
    	
    			$where_to=$where.$where1;
    		}else{
    	
    			$where_to=$where;
    	
    		}
    	
    		$html="";
    		$resultSet=$asignacion_clientes_medidor_agua->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    	
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    	
    		$per_page = 10; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    	
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    	
    		$resultSet=$asignacion_clientes_medidor_agua->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
    		$count_query   = $cantidadResult;
    		$total_pages = ceil($cantidadResult/$per_page);
    	
    		 
    	
    	
    	
    		if($cantidadResult>0)
    		{
    	
    			$html.='<div class="pull-left" style="margin-left:11px;">';
    			$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    			$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
    			$html.='</div>';
    			$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
    			$html.='<section style="height:350px; overflow-y:scroll;">';
    			$html.= "<table id='tabla_asignacion_clientes_medidor' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr>";
    			$html.='<th style="text-align: left;  font-size: 12px;">Medidor Agua</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Identificación</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Razón Social</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Provincia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Cantón</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Parroquia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Fecha Asignación</th>';
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
    				$html.='<td style="font-size: 11px;">'.$res->correo_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->celular_clientes.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_provincias.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_cantones.'</td>';
    				$html.='<td style="font-size: 11px;">'.$res->nombre_parroquias.'</td>';
    				$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=AsignacionClientesMedidorAgua&action=index&id_medidores_agua_asignacion='.$res->id_medidores_agua.'&id_clientes='.$res->id_clientes.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					
    				
    					
    				$html.='</tr>';
    			}
    	
    	
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate_asignacion_medidores_clientes("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    	
    	
    	
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay asignaciones de medidores registrados...</b>';
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
		
			
			$asignar_medidor = new AsignacionClientesMedidorAguaModel();
			
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
				
			
			$nombre_controladores = "AsignarMedidores";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $asignar_medidor->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
				$resultEdit = "";
				$resultEditAsig= "";
				
				
				if(isset($_GET["id_medidores_agua"])){
					
					$_id_medidores_agua = $_GET["id_medidores_agua"];
					
					$columnas = " medidores_agua.id_medidores_agua,
					  medidores_agua.identificador_medidores_agua,
					  medidores_agua.id_estado,
					  estado.nombre_estado_medidores,
					  medidores_agua.creado,
					  medidores_agua.modificado";
					 
					$tablas   = "public.estado,
  					 public.medidores_agua";
					 
					$id       = "medidores_agua.id_medidores_agua";
					 
					$where    = "medidores_agua.id_estado = estado.id_estado AND medidores_agua.id_medidores_agua='$_id_medidores_agua'";
					
					$resultEdit = $asignar_medidor->getCondiciones($columnas ,$tablas ,$where, $id);
				}
				
				
				
				
				if(isset($_GET["id_medidores_agua_asignacion"]) && isset($_GET["id_clientes"])){
						
					$_id_medidores_agua = $_GET["id_medidores_agua_asignacion"];
					$_id_clientes = $_GET["id_clientes"];
					
					
					$columnas = "asignacion_clientes_medidor_agua.id_asignacion_clientes_medidor_agua,
					  asignacion_clientes_medidor_agua.id_clientes,
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
					  clientes.telefono_clientes,
					  clientes.celular_clientes,
					  clientes.correo_clientes,
					  clientes.id_estado,
					  asignacion_clientes_medidor_agua.id_medidores_agua,
					  medidores_agua.identificador_medidores_agua,
					  asignacion_clientes_medidor_agua.creado,
					  asignacion_clientes_medidor_agua.modificado";
					
					$tablas   = "public.asignacion_clientes_medidor_agua,
					  public.medidores_agua,
					  public.clientes,
					  public.paises,
					  public.tipo_identificacion,
					  public.provincias,
					  public.cantones,
					  public.parroquias";
					
					$id       = "asignacion_clientes_medidor_agua.id_asignacion_clientes_medidor_agua";
					
					
					$where    = "asignacion_clientes_medidor_agua.id_clientes = clientes.id_clientes AND
					  medidores_agua.id_medidores_agua = asignacion_clientes_medidor_agua.id_medidores_agua AND
					  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
					  clientes.id_provincias = provincias.id_provincias AND
					  clientes.id_paises = paises.id_paises AND
					  cantones.id_cantones = clientes.id_cantones AND
					  parroquias.id_parroquias = clientes.id_parroquias AND asignacion_clientes_medidor_agua.id_clientes='$_id_clientes' AND asignacion_clientes_medidor_agua.id_medidores_agua='$_id_medidores_agua'";
					
					
					
					$resultEditAsig = $asignar_medidor->getCondiciones($columnas ,$tablas ,$where, $id);
				}
				
					
					$this->view("AsignacionClientesMedidorAgua",array(
					"resultEditAsig" =>$resultEditAsig, "resultEdit" =>$resultEdit, "resultTipIdenti"=>$resultTipIdenti
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Asignación Medidores Clientes"
			
				));
			
			}
			
		
		}
		else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
		
	}
	
	
	
	
	
	
	public function InsertaAsignacionMedidores(){
		


		session_start();
		$resultado = null;
		$asignacion_clientes_medidor_agua = new AsignacionClientesMedidorAguaModel();
		$medidores_agua = new MedidoresAguaModel();
		$solicitudes = new SolicitudesModel();
		$solicitudes_detalle = new SolicitudesDetalleModel();
		
		
		$_clave_usuario = "";
		$_id_medidores_agua=0;
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
		
			if (isset ($_POST["id_clientes"]))
			{
				$_id_clientes    = $_POST["id_clientes"];
					
					
				$_id_medidores_agua_asignacion            = $_POST["id_medidores_agua_asignacion"];
				$_id_asignacion_clientes_medidor_agua    = $_POST["id_asignacion_clientes_medidor_agua"];
		
				if($_id_asignacion_clientes_medidor_agua>0){
					
					
					$resultMedidor = $asignacion_clientes_medidor_agua->getBy("id_asignacion_clientes_medidor_agua='$_id_asignacion_clientes_medidor_agua'");
					if(!empty($resultMedidor)){
						$_id_medidores_agua  =$resultMedidor[0]->id_medidores_agua;
					}else{}
						
					if($_id_medidores_agua>0){
						

						$colval = "id_estado=2";
						$tabla = "medidores_agua";
						$where = "id_medidores_agua = '$_id_medidores_agua'";
						$resultado=$medidores_agua->UpdateBy($colval, $tabla, $where);
							
					}else{
						
					}
					
					
					$colval = "id_medidores_agua='$_id_medidores_agua_asignacion'";
					$tabla = "asignacion_clientes_medidor_agua";
					$where = "id_asignacion_clientes_medidor_agua = '$_id_asignacion_clientes_medidor_agua'";
					$resultado=$asignacion_clientes_medidor_agua->UpdateBy($colval, $tabla, $where);
					
					$colval = "id_estado=1";
					$tabla = "medidores_agua";
					$where = "id_medidores_agua = '$_id_medidores_agua_asignacion'";
					$resultado=$medidores_agua->UpdateBy($colval, $tabla, $where);
					
					
				}else{
				
				
					$funcion = "ins_asignacion_clientes_medidor_agua";
					$parametros = "'$_id_clientes', '$_id_medidores_agua_asignacion'";
					$asignacion_clientes_medidor_agua->setFuncion($funcion);
					$asignacion_clientes_medidor_agua->setParametros($parametros);
					$resultado=$asignacion_clientes_medidor_agua->Insert();
				
				
					$colval = "id_estado=1";
					$tabla = "medidores_agua";
					$where = "id_medidores_agua = '$_id_medidores_agua_asignacion'";
					$resultado=$medidores_agua->UpdateBy($colval, $tabla, $where);
					 
					
					
					
					
				}
					
				$this->redirect("AsignacionClientesMedidorAgua", "index");
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
	
	
	
	
	public function InsertaMedidores(){
			
		session_start();
		$resultado = null;
		$medidores_agua = new MedidoresAguaModel();
		
		
		$_clave_usuario = "";
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
		if (isset ($_POST["identificador_medidores_agua"]))
		{
			$_identificador_medidores_agua    = $_POST["identificador_medidores_agua"];
			
			
		    $_id_medidores_agua            = $_POST["id_medidores_agua"];
		    
		    
		    
		    
		    if($_id_medidores_agua > 0){
		    	
		    	
		    		$colval = "identificador_medidores_agua='$_identificador_medidores_agua'";
		    		$tabla = "medidores_agua";
		    		$where = "id_medidores_agua = '$_id_medidores_agua'";
		    		$resultado=$medidores_agua->UpdateBy($colval, $tabla, $where);
		    	
		    	
		    }else{
		    
		        	$funcion = "ins_medidores_agua";
		        	$parametros = "'$_identificador_medidores_agua'";
		        	$medidores_agua->setFuncion($funcion);
		        	$medidores_agua->setParametros($parametros);
		        	$resultado=$medidores_agua->Insert();
		        	
		        	
		        	
		 	 	
		  }
		  
		   
		    $this->redirect("AsignacionClientesMedidorAgua", "index");
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
	
	
	


	public function AutocompleteIdentificador(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$medidores_agua = new MedidoresAguaModel();
		$identificador_medidores_agua = $_GET['term'];
			
		$resultSet=$medidores_agua->getBy("identificador_medidores_agua LIKE '$identificador_medidores_agua%'");
			
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
			
		$identificador_medidores_agua = $_POST['identificador_medidores_agua'];
		$resultSet=$medidores_agua->getBy("identificador_medidores_agua = '$identificador_medidores_agua'");
			
		$respuesta = new stdClass();
			
		if(!empty($resultSet)){
	
			$respuesta->identificador_medidores_agua = $resultSet[0]->identificador_medidores_agua;
			$respuesta->id_medidores_agua = $resultSet[0]->id_medidores_agua;
				
			echo json_encode($respuesta);
		}
			
	}
	


	public function AutocompleteCedula(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$clientes = new ClientesModel();
		$identificacion_clientes = $_GET['term'];
		
		
		$columnas="clientes.identificacion_clientes, 
				  clientes.id_estado, 
				  solicitudes.id_estado";
		$tablas=" public.solicitudes, 
 				 public.clientes";
		$where=" clientes.id_clientes = solicitudes.id_clientes
  			AND solicitudes.id_estado=1 AND clientes.id_estado=1 AND clientes.identificacion_clientes LIKE '$identificacion_clientes%' AND solicitudes.pagado='TRUE'";
		$id="clientes.identificacion_clientes";
		$resultSet=$clientes->getCondiciones($columnas,$tablas, $where, $id );
			
		
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
		$resultSet=$clientes->getBy("identificacion_clientes = '$identificacion_clientes' AND id_estado=1");
			
		$respuesta = new stdClass();
			
		if(!empty($resultSet)){
	
			$respuesta->razon_social_clientes = $resultSet[0]->razon_social_clientes;
			$respuesta->id_tipo_identificacion = $resultSet[0]->id_tipo_identificacion;
			$respuesta->identificacion_clientes = $resultSet[0]->identificacion_clientes;
			$respuesta->id_clientes = $resultSet[0]->id_clientes;
				
				
			echo json_encode($respuesta);
		}
			
	}
	
	
	
	public function AutocompleteIdentificadorAsignar(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$medidores_agua = new MedidoresAguaModel();
		$identificador_medidores_agua = $_GET['term'];
			
		$resultSet=$medidores_agua->getBy("identificador_medidores_agua LIKE '$identificador_medidores_agua%' AND id_estado=2");
			
		if(!empty($resultSet)){
	
			foreach ($resultSet as $res){
					
				$_identificador_medidores_agua[] = $res->identificador_medidores_agua;
			}
			echo json_encode($_identificador_medidores_agua);
		}
			
	}
	
	
	public function AutocompleteDevuelveIdentificadorAsignar(){
			
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$medidores_agua = new MedidoresAguaModel();
			
		$identificador_medidores_agua = $_POST['identificador_medidores_agua'];
		$resultSet=$medidores_agua->getBy("identificador_medidores_agua = '$identificador_medidores_agua' AND id_estado=2");
			
		$respuesta = new stdClass();
			
		if(!empty($resultSet)){
	
			$respuesta->identificador_medidores_agua = $resultSet[0]->identificador_medidores_agua;
			$respuesta->id_medidores_agua = $resultSet[0]->id_medidores_agua;
			
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
	
	
	
	
	public function paginate_medidores_agua($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_medidores_agua(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_medidores_agua(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_medidores_agua(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_medidores_agua(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_medidores_agua(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_medidores_agua($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_medidores_agua(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	

	public function paginate_asignacion_medidores_clientes($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_asignacion_medidores_clientes(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	
	
	
	
}
?>
