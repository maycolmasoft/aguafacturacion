.<?php

class TipoPersonaController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
	    $tipo_persona=new TipoPersonaModel();
					//Conseguimos todos los usuarios
	    $resultSet=$tipo_persona->getAll("id_tipo_persona");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "TipoPersona";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $tipo_persona->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_tipo_persona"])   )
				{

					$nombre_controladores = "TipoPersona";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $tipo_persona->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
					    $_id_tipo_persona = $_GET["id_tipo_persona"];
						$columnas = " id_tipo_persona, nombre_tipo_persona";
						$tablas   = "tipo_persona";
						$where    = "id_tipo_persona = '$_id_tipo_persona' "; 
						$id       = "nombre_tipo_persona";
							
						$resultEdit = $tipo_persona->getCondiciones($columnas ,$tablas ,$where, $id);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Tipo Persona"
					
						));
					
					
					}
					
				}
		
				
				$this->view("TipoPersona",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a TipoPersona"
				
				));
				
				exit();	
			}
				
		}
	else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	public function InsertaTipoPersona(){
			
		session_start();
		$tipo_persona=new TipoPersonaModel();

		$nombre_controladores = "TipoPersona";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tipo_persona->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$tipo_persona=new TipoPersonaModel();
		
			if (isset ($_POST["nombre_tipo_persona"])   )
			{
				
			    $_nombre_tipo_persona = $_POST["nombre_tipo_persona"];
			 	
			    if($_id_tipo_persona > 0){
					
					$columnas = " nombre_tipo_persona = '$_nombre_tipo_persona'";
					$tabla = "tipo_persona";
					$where = "id_tipo_persona = '$_id_tipo_persona'";
					$resultado=$tipo_persona->UpdateBy($columnas, $tabla, $where);
					
				}else{
					
					$funcion = "ins_tipo_persona";
					$parametros = " '$_nombre_tipo_persona'";
					$tipo_persona->setFuncion($funcion);
					$tipo_persona->setParametros($parametros);
					$resultado=$tipo_persona->Insert();
				}
				
				
				
		
			}
			$this->redirect("TipoPersona", "index");

		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Insertar Tipo Persona
"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{

		session_start();
		$tipo_persona=new TipoPersonaModel();
		$nombre_controladores = "TipoPersona";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tipo_persona->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_tipo_persona"]))
			{
			    $id_tipo_persona=(int)$_GET["id_tipo_persona"];
		
				
				
			    $tipo_persona->deleteBy("id_tipo_persona",$id_tipo_persona);
				
				
			}
			
			$this->redirect("TipoPersona", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Tipo Persona"
			
			));
		}
				
	}
	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$roles=new RolesModel();
		//Conseguimos todos los usuarios
		
	
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $roles->getByPDF("id_rol, nombre_rol", " nombre_rol != '' ");
			$this->report("Roles",array(	"resultRep"=>$resultRep));
	
		}
					
	
	}
	
	
	
}
?>