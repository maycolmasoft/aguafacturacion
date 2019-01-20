<?php
class GeoposicionamientoController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
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
				
			
			$nombre_controladores = "Geoposicionamiento";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $clientes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
			if (!empty($resultPer))
			{
			
					
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
								  clientes.lat,
								  clientes.lng,
								  clientes.formato_direccion_clientes,
								  medidores_agua.identificador_medidores_agua";
						
						$tablas   = "public.clientes, 
									  public.parroquias, 
									  public.provincias, 
									  public.cantones, 
									  public.tipo_persona, 
									  public.tipo_identificacion, 
									  public.estado,
								      public.asignacion_clientes_medidor_agua,
								      public.medidores_agua";
						
						$id       = "clientes.id_clientes";
						
						
						$where    = " medidores_agua.id_medidores_agua=asignacion_clientes_medidor_agua.id_medidores_agua AND
								      asignacion_clientes_medidor_agua.id_clientes= clientes.id_clientes AND 
								      clientes.id_tipo_persona = tipo_persona.id_tipo_persona AND
									  clientes.id_tipo_identificacion = tipo_identificacion.id_tipo_identificacion AND
									  clientes.id_provincias = provincias.id_provincias AND
									  clientes.id_cantones = cantones.id_cantones AND
									  clientes.id_parroquias = parroquias.id_parroquias AND
									  clientes.id_estado = estado.id_estado"; 
						$resultSet = $clientes->getCondiciones($columnas ,$tablas ,$where, $id); 
					
			
					
					$this->view("Geoposicionamiento",array(
							"resultSet" =>$resultSet, "resultProvincias"=>$resultProvincias,
							"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones
					
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Geoposicionamiento"
			
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
	
				
			$clientes = new ClientesModel();
				
	
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
				
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
				
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
	
				
			$nombre_controladores = "Geoposicionamiento";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $clientes->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				$resultSet="";
				if(isset($_GET["id_clientes"])){
				
				$_id_clientes=$_GET["id_clientes"];
					
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
								  clientes.lat,
								  clientes.lng,
								  clientes.formato_direccion_clientes";
	
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
									  clientes.id_estado = estado.id_estado AND clientes.id_clientes=$_id_clientes";
				$resultSet = $clientes->getCondiciones($columnas ,$tablas ,$where, $id);
					
				}	
					
				$this->view("GeoposicionamientoDetalle",array(
						"resultSet" =>$resultSet, "resultProvincias"=>$resultProvincias,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones
							
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Geoposicionamiento"
		
				));
					
			}
				
	
		}
		else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
	
	}
	
	
	
	
	
}
?>
