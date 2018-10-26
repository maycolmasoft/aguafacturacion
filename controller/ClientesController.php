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
									  clientes.correo_clientes";
    	
    	$tablas   = "public.clientes,
									  public.cantones,
									  public.provincias,
									  public.parroquias,
									  public.sexo,
									  public.tipo_identificacion";
    	
    	$id       = "clientes.id_clientes";
    	
    	
    	$where    = "clientes.id_provincias = provincias.id_provincias AND
    	cantones.id_cantones = clientes.id_cantones AND
    	parroquias.id_parroquias = clientes.id_parroquias AND
    	sexo.id_sexo = clientes.id_sexo AND
    	tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion";
    	
    
    	 
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	 
    	 
    	 
    	 
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.apellidos_clientes LIKE '".$search."%' OR clientes.nombres_clientes LIKE '".$search."%' OR tipo_identificacion.nombre_tipo_identificacion LIKE '".$search."%' OR sexo.nombre_sexo LIKE '".$search."%' OR provincias.nombre_provincias LIKE '".$search."%' OR cantones.nombre_cantones LIKE '".$search."%' OR parroquias.nombre_parroquias LIKE '".$search."%' OR clientes.correo_clientes LIKE '".$search."%')";
    
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
    			$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Apellidos</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Nombres</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Teléfono</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Provincia</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Cantón</th>';
    			$html.='<th style="text-align: left;  font-size: 12px;">Parroquia</th>';
    
    			if($id_rol==1){
    				 
    				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
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
    				 
    				if($id_rol==1){
    					 
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=index&id_clientes='.$res->id_clientes.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Clientes&action=borrarId&id_clientes='.$res->id_clientes.'" class="btn btn-danger" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
    					 
    					 
    				}else{
    					 
    					 
    				}
    				 
    				$html.='</tr>';
    			}
    
    
    			$html.='</tbody>';
    			$html.='</table>';
    			$html.='</section></div>';
    			$html.='<div class="table-pagination pull-right">';
    			$html.=''. $this->paginate("index.php", $page, $total_pages, $adjacents).'';
    			$html.='</div>';
    
    
    			 
    		}else{
    			$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    			$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    			$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay clientes registrados...</b>';
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
			
			$sexo= new SexoModel();
			$resultSexo = $sexo->getAll("nombre_sexo");
				
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
			
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
			
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
				
			$tipo_identificacion = new TipoIdentificacionModel();
			$resultTipIdenti= $tipo_identificacion->getAll("nombre_tipo_identificacion");
			
			
			
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
									  clientes.correo_clientes";
						
						$tablas   = "public.clientes, 
									  public.cantones, 
									  public.provincias, 
									  public.parroquias, 
									  public.sexo, 
									  public.tipo_identificacion";
						
						$id       = "clientes.id_clientes";
						
						
						$where    = "clientes.id_provincias = provincias.id_provincias AND
								  cantones.id_cantones = clientes.id_cantones AND
								  parroquias.id_parroquias = clientes.id_parroquias AND
								  sexo.id_sexo = clientes.id_sexo AND
								  tipo_identificacion.id_tipo_identificacion = clientes.id_tipo_identificacion AND clientes.id_clientes = '$_id_clientes' "; 
						$resultEdit = $clientes->getCondiciones($columnas ,$tablas ,$where, $id); 
					}
			
					
					$this->view("Clientes",array(
							"resultEdit" =>$resultEdit, "resultProvincias"=>$resultProvincias,
							"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones, "resultSexo"=>$resultSexo,
							"resultTipIdenti"=>$resultTipIdenti
					
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
		$usuarios=new UsuariosModel();
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
		if (isset ($_POST["cedula_usuarios"]))
		{
			$_cedula_usuarios    = $_POST["cedula_usuarios"];
			$_nombre_usuarios     = $_POST["nombre_usuarios"];
			//$_usuario_usuario     = $_POST["usuario_usuario"];
			$_clave_usuarios      = $usuarios->encriptar($_POST["clave_usuarios"]);
			$_pass_sistemas_usuarios      = $_POST["clave_usuarios"];
			$_telefono_usuarios   = $_POST["telefono_usuarios"];
			$_celular_usuarios    = $_POST["celular_usuarios"];
			$_correo_usuarios     = $_POST["correo_usuarios"];
		    $_id_rol             = $_POST["id_rol"];
		    $_id_estado          = $_POST["id_estado"];
		    
		    $_id_usuarios          = $_POST["id_usuarios"];
		    
		    
		    if($_id_usuarios > 0){
		    	
		    	
		    	if ($_FILES['fotografia_usuarios']['tmp_name']!="")
		    	{
		    			
		    		$directorio = $_SERVER['DOCUMENT_ROOT'].'/aguafacturacion/fotografias_usuarios/';
		    			
		    		$nombre = $_FILES['fotografia_usuarios']['name'];
		    		$tipo = $_FILES['fotografia_usuarios']['type'];
		    		$tamano = $_FILES['fotografia_usuarios']['size'];
		    			
		    		move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
		    		$data = file_get_contents($directorio.$nombre);
		    		$imagen_usuarios = pg_escape_bytea($data);
		    			
		    			
		    		$colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado', fotografia_usuarios ='$imagen_usuarios'";
		    		$tabla = "usuarios";
		    		$where = "id_usuarios = '$_id_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    			
		    	}
		    	else
		    	{
		    	
		    		$colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado'";
		    		$tabla = "usuarios";
		    		$where = "id_usuarios = '$_id_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    	
		    	}
		    	
		    	
		    	
		    }else{
		    
		    	
		    	
		    	
		    if ($_FILES['fotografia_usuarios']['tmp_name']!="")
		    {
		    
		    	$directorio = $_SERVER['DOCUMENT_ROOT'].'/aguafacturacion/fotografias_usuarios/';
		    
		    	$nombre = $_FILES['fotografia_usuarios']['name'];
		    	$tipo = $_FILES['fotografia_usuarios']['type'];
		    	$tamano = $_FILES['fotografia_usuarios']['size'];
		    	
		    	move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
		    	$data = file_get_contents($directorio.$nombre);
		    	$imagen_usuarios = pg_escape_bytea($data);
		    
		    
		    	$funcion = "ins_usuarios";
		    	$parametros = "'$_cedula_usuarios',
		    				   '$_nombre_usuarios',
		    				   '$_clave_usuarios',
		    	               '$_pass_sistemas_usuarios',
		    	               '$_telefono_usuarios',
		    	               '$_celular_usuarios',
		    	               '$_correo_usuarios',
		    	               '$_id_rol',
		    	               '$_id_estado',
		    	               '$imagen_usuarios'";
		    	$usuarios->setFuncion($funcion);
		    	$usuarios->setParametros($parametros);
		    	$resultado=$usuarios->Insert();
		    
		    }
		    else
		    {
		    
		    	$where_TO = "cedula_usuarios = '$_cedula_usuarios'";
		    	$result=$usuarios->getBy($where_TO);
		    	 
		    	if ( !empty($result) )
		    	{
		    		 
		    		$colval = "nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado'";
		    		$tabla = "usuarios";
		    		$where = "cedula_usuarios = '$_cedula_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    	}
		        else{
		        	
		        	$imagen_usuarios="";
		        	
		        	$funcion = "ins_usuarios";
		        	$parametros = "'$_cedula_usuarios',
		        	'$_nombre_usuarios',
		        	'$_clave_usuarios',
		        	'$_pass_sistemas_usuarios',
		        	'$_telefono_usuarios',
		        	'$_celular_usuarios',
		        	'$_correo_usuarios',
		        	'$_id_rol',
		        	'$_id_estado',
		        	'$imagen_usuarios'";
		        	$usuarios->setFuncion($funcion);
		        	$usuarios->setParametros($parametros);
		        	$resultado=$usuarios->Insert();
		    	}
		    
		    }
		
		  	 	
		  }
		  
		   
		    $this->redirect("Usuarios", "index");
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
	
			$respuesta->apellidos_clientes = $resultSet[0]->apellidos_clientes;
			$respuesta->nombres_clientes = $resultSet[0]->nombres_clientes;
			$respuesta->id_tipo_identificacion = $resultSet[0]->id_tipo_identificacion;
			$respuesta->identificacion_clientes = $resultSet[0]->identificacion_clientes;
			$respuesta->id_sexo = $resultSet[0]->id_sexo;
			$respuesta->id_paises = $resultSet[0]->id_paises;
			$respuesta->id_provincias = $resultSet[0]->id_provincias;
			$respuesta->id_cantones = $resultSet[0]->id_cantones;
			$respuesta->id_parroquias = $resultSet[0]->id_parroquias;
			$respuesta->direccion_clientes = $resultSet[0]->direccion_clientes;
			$respuesta->telefono_clientes = $resultSet[0]->telefono_clientes;
			$respuesta->celular_clientes = $resultSet[0]->celular_clientes;
			$respuesta->correo_clientes = $resultSet[0]->correo_clientes;
					
			echo json_encode($respuesta);
		}
			
	}
	
	
	
	
	
	public function borrarId()
	{
		if(isset($_GET["id_clientes"]))
		{
			$id_clientes=(int)$_GET["id_clientes"];
	
			
				
			$clientes= new ClientesModel();
			$clientes->deleteBy(" id_clientes",$id_clientes);
				
				
		}
	
		$this->redirect("Clientes", "index");
	}
	
	
	
	
	public function paginate($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_clientes(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_clientes($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_clientes(".($page+1).")'>$nextlabel</a></span></li>";
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
	
	
		if(isset($_POST["id_provincias_vivienda"]))
		{
	
			$id_provincias=(int)$_POST["id_provincias_vivienda"];
	
			$cantones=new CantonesModel();
	
			$resultCan = $cantones->getBy(" id_provincias = '$id_provincias'  ");
	
	
		}
	
		if(isset($_POST["id_provincias_asignacion"]))
		{
	
			$id_provincias=(int)$_POST["id_provincias_asignacion"];
	
			$cantones=new CantonesModel();
	
			$resultCan = $cantones->getBy(" id_provincias = '$id_provincias'  ");
	
	
		}
			
		echo json_encode($resultCan);
	
	}
	
	
	
	
	
	
	
	public function devuelveParroquias()
	{
		session_start();
		$resultParr = array();
	
	
		if(isset($_POST["id_cantones_vivienda"]))
		{
	
			$id_cantones_vivienda=(int)$_POST["id_cantones_vivienda"];
	
			$parroquias=new ParroquiasModel();
	
			$resultParr = $parroquias->getBy(" id_cantones = '$id_cantones_vivienda'  ");
	
	
		}
		if(isset($_POST["id_cantones_asignacion"]))
		{
	
			$id_cantones_vivienda=(int)$_POST["id_cantones_asignacion"];
	
			$parroquias=new ParroquiasModel();
	
			$resultParr = $parroquias->getBy(" id_cantones = '$id_cantones_vivienda'  ");
	
	
		}
			
		echo json_encode($resultParr);
	
	}
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
}
?>
