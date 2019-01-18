<?php

class TipoConsumoController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
	    $tipo_consumo=new TipoConsumoModel();
					//Conseguimos todos los usuarios
	    $resultSet=$tipo_consumo->getAll("id_tipo_consumo");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "TipoConsumo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $tipo_consumo->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_tipo_consumo"])   )
				{

					$nombre_controladores = "TipoConsumo";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $tipo_consumo->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
					    $_id_tipo_consumo = $_GET["id_tipo_consumo"];
						$columnas = " id_tipo_consumo, nombre_tipo_consumo";
						$tablas   = "tipo_consumo";
						$where    = "id_tipo_consumo = '$_id_tipo_consumo' "; 
						$id       = "nombre_tipo_consumo";
							
						$resultEdit = $tipo_consumo->getCondiciones($columnas ,$tablas ,$where, $id);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Tipo Consumo"
					
						));
					
					
					}
					
				}
		
				
				$this->view("TipoConsumo",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Tipo Consumo"
				
				));
				
				exit();	
			}
				
		}
	else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	public function InsertaTipoConsumo(){
			
		session_start();
		$tipo_consumo=new TipoConsumoModel();

		$nombre_controladores = "TipoConsumo";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tipo_consumo->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$tipo_consumo=new TipoConsumoModel();
		
			if (isset ($_POST["nombre_tipo_consumo"])   )
			{
				
			    $_nombre_tipo_consumo = $_POST["nombre_tipo_consumo"];
			 	
			    if($_id_tipo_consumo > 0){
					
					$columnas = " nombre_tipo_consumo = '$_nombre_tipo_consumo'";
					$tabla = "tipo_consumo";
					$where = "id_tipo_consumo = '$_id_tipo_consumo'";
					$resultado=$tipo_consumo->UpdateBy($columnas, $tabla, $where);
					
				}else{
					
					$funcion = "ins_tipo_consumo";
					$parametros = " '$_nombre_tipo_consumo'";
					$tipo_consumo->setFuncion($funcion);
					$tipo_consumo->setParametros($parametros);
					$resultado=$tipo_consumo->Insert();
				}
				
				
				
		
			}
			$this->redirect("TipoConsumo", "index");

		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Insertar Tipo Consumo
"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{

		session_start();
		$tipo_consumo=new TipoConsumoModel();
		$nombre_controladores = "TipoConsumo";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tipo_consumo->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_tipo_consumo"]))
			{
			    $id_tipo_consumo=(int)$_GET["id_tipo_consumo"];
		
				
				
			    $tipo_consumo->deleteBy("id_tipo_consumo",$id_tipo_consumo);
				
				
			}
			
			$this->redirect("TipoConsumo", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Tipo Consumo"
			
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