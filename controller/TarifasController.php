<?php

class TarifasController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
	    $tarifas=new TarifasModel();
					//Conseguimos todos los usuarios
	    $resultSet=$tarifas->getAll("id_tarifas");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "Tarifas";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $tarifas->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_tarifas"])   )
				{

					$nombre_controladores = "Tarifas";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $tarifas->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
					    $_id_tarifas = $_GET["id_tarifas"];
						$columnas = " id_tarifas, nombre_tarifa, valor_tarifa ";
						$tablas   = "tarifas";
						$where    = "id_tarifas = '$_id_tarifas' "; 
						$id       = "nombre_tarifa";
							
						$resultEdit = $tarifas->getCondiciones($columnas ,$tablas ,$where, $id);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Tarifas"
					
						));
					
					
					}
					
				}
		
				
				$this->view("Tarifas",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Tarifas"
				
				));
				
				exit();	
			}
				
		}
	else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	public function InsertaTarifas(){
			
		session_start();
		$tarifas=new TarifasModel();

		$nombre_controladores = "Tarifas";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tarifas->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$tarifas=new TarifasModel();
		
			if (isset ($_POST["nombre_tarifa"])   )
			{
				
			    $_nombre_tarifa = $_POST["nombre_tarifa"];
			    $_valor_tarifa =  $_POST["valor_tarifa"];
				
				if($_id_rol > 0){
					
					$columnas = " nombre_tarifa = '$_nombre_tarifa', valor_tarifa = '$_valor_tarifa' ";
					$tabla = "tarifas";
					$where = "id_tarifas = '$_id_tarifas'";
					$resultado=$tarifas->UpdateBy($columnas, $tabla, $where);
					
				}else{
					
					$funcion = "ins_tarifas";
					$parametros = " '$_nombre_tarifa', '$_valor_tarifa'";
					$tarifas->setFuncion($funcion);
					$tarifas->setParametros($parametros);
					$resultado=$tarifas->Insert();
				}
				
				
				
		
			}
			$this->redirect("Tarifas", "index");

		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Insertar Tarifas
"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{

		session_start();
		$tarifas=new TarifasModel();
		$nombre_controladores = "Tarifas";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $tarifas->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_tarifas"]))
			{
			    $id_tarifas=(int)$_GET["id_tarifas"];
		
				
				
			    $tarifas->deleteBy("id_tarifas",$id_tarifas);
				
				
			}
			
			$this->redirect("Tarifas", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Tarifas"
			
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