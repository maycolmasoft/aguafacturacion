<?php

class IniciarController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	public function index(){
	
		session_start();
		
			$encuestas = new EncuestasModel();
			$encuestas_cabeza= new EncuestasCabezaModel();
	
				
	
				$columnas="pre.nombre_preguntas_encuestas_participes,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=1 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=1 and enc.respuestas_encuestas_participes='Bueno') END BUENO_PREGUNTA_1,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=1 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=1 and enc.respuestas_encuestas_participes='Intermedio') END INTERMEDIO_1,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=1 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=1 and enc.respuestas_encuestas_participes='Malo') END MALO_1,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=2 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=2 and enc.respuestas_encuestas_participes='Si') END SI_2,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=2 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=2 and enc.respuestas_encuestas_participes='Algo') END ALGO_2,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=2 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=2 and enc.respuestas_encuestas_participes='Nada') END NADA_2,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=3 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=3 and enc.respuestas_encuestas_participes='Los Colores') END LOS_COLORES_3,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=3 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=3 and enc.respuestas_encuestas_participes='La Información') END LA_INFORMACION_3,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=3 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=3 and enc.respuestas_encuestas_participes='Las Imágenes') END LAS_IMAGENES_3,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=3 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=3 and enc.respuestas_encuestas_participes='Nada') END NADA_3,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='1') END R1_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='2') END R2_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='3') END R3_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='4') END R4_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='5') END R5_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='6') END R6_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='7') END R7_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='8') END R8_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='9') END R9_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=4 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=4 and enc.respuestas_encuestas_participes='10') END R10_4,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=5 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=5 and enc.respuestas_encuestas_participes='Si') END SI_5,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=5 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=5 and enc.respuestas_encuestas_participes='Intermedio') END INTERMEDIO_5,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=5 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=5 and enc.respuestas_encuestas_participes='No') END NO_5,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=6 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=6 and enc.respuestas_encuestas_participes='Si') END SI_6,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=6 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=6 and enc.respuestas_encuestas_participes='No') END NO_6,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=7 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=7 and enc.respuestas_encuestas_participes='Si') END SI_7,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=7 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=7 and enc.respuestas_encuestas_participes='No') END NO_7,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=8 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=8 and enc.respuestas_encuestas_participes='Si') END SI_8,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=8 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=8 and enc.respuestas_encuestas_participes='Intermedio') END INTERMEDIO_8,
						  CASE  WHEN pre.id_preguntas_encuestas_participes=8 THEN  (select count(*) from public.encuentas_participes_detalle enc where enc.id_preguntas_encuestas_participes=pre.id_preguntas_encuestas_participes and enc.id_preguntas_encuestas_participes=8 and enc.respuestas_encuestas_participes='No') END NO_8";
				$tablas="public.preguntas_encuestas_participes pre";
				$where="1=1";
				$id="pre.id_preguntas_encuestas_participes";
	
				$resultSet=$encuestas->getCondiciones($columnas, $tablas, $where, $id);
					
				$total=0;
				$resultSet_cabeza=$encuestas_cabeza->getCantidad("*", "encuentas_participes_cabeza", "1=1");
				$total=(int)$resultSet_cabeza[0]->total;
	
					
				$this->view("paginaweb",array(
						"resultSet"=>$resultSet, "total"=>$total
	
				));
	
			
	
	die();
		
	
	}
	
	
	
	
}
?>