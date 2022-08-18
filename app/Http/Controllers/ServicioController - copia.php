<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Servicio;
use App\Model\TipoServicio;
use App\Model\Socio;
use App\Model\Personal;

class ServicioController extends Controller{

	
	public function listado(){
		//$servicios=Servicio::all();
		//$servicios=DB::table('servicio')
		$servicios=Servicio::join('tiposervicio','tiposervicio.idtiposervicio','=','servicio.idtiposervicio')
					->join('personal','personal.idpersonal','=','servicio.idpersonal')
					//comentar
					->join('socio','socio.idsocio','=','servicio.idsocio')
					->select(
							//comentar
							"servicio.idservicio"
							,"servicio.placa"
					 		,"servicio.modelo"
					 		,"servicio.anio"
					 		,"tiposervicio.idtiposervicio"
							,"tiposervicio.nombre as nomtiposervicio"
							,"tiposervicio.precio as preciotipserv"
							,"personal.idpersonal"
							,"personal.nombrecompleto as personal"
							,"socio.idsocio"
							,"socio.nombre as nomsocio"
							,\DB::Raw("DATE_FORMAT(fecha_creacion, '%Y-%m-%d') as fecha_creacion")
							,\DB::Raw("DATE_FORMAT(fecha_atencion_inicial, '%Y-%m-%d') as fecha_atencion")

					 		
							//,"tiposervicio.precio as tiposervprec"
							
					        /*,DB::Raw('tiposervicio.nombre as tiposervicio')
					        ,DB::Raw('personal.nombrecompleto as personal')*/
					)
					->get();




		$datos=array();
		$datos['lista']=$servicios;
		$datos['usuario']='Juan';
		return view('servicio.listado')->with($datos);
	}

	public function formulario(Request $r){
		//recibir los datos que el usuario envíe
		$datos=$r->all();		
		
		if($r->isMethod('post')){
			//POST significa que vamos a agregar
			//dd('Vamos a agregar');
			$operacion='Agregar';
			$servicio=new Servicio();
		}
		else{
			//GET fue por enlace y significa que vamos a modificar
			//dd('Vamos a editar');
			$operacion='Editar';
			$servicio=Servicio::find($datos['idservicio']);
		}

		$tipos=TipoServicio::all();
		$socios=Socio::all();
		$personales=Personal::all(); 

		//para enviar informacion a la vista
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['servicio']=$servicio;
		$informacion['tipos']=$tipos;
		$informacion['socios']=$socios;
		$informacion['personales']=$personales; 
		
		return view('servicio.formulario')->with($informacion);
	}

	
	public function save(Request $r){
		//recibir los datos que el usuario envíe
		$datos=$r->all();

		//Son 3 componentes
		//Mysql (Hora del php)
		//Php (Hora del php)
		//Servidor (Apache) (Hora del php)
		date_default_timezone_set("America/Merida");
		
		switch ($datos['operacion']) {
			case 'Agregar':
					$servicio=new Servicio();
					$servicio->idsocio=$datos['idsocio'];
					$servicio->idpersonal=$datos['idpersonal'];
					$servicio->placa=$datos['placa'];
					$servicio->modelo=$datos['modelo'];
					$servicio->anio=$datos['anio'];
					$servicio->idtiposervicio=$datos['idtiposervicio'];
					$servicio->fecha_creacion=date('Y-m-d H:i:s');
					$servicio->fecha_atencion_inicial=$datos['fecha_atencion'];
					$servicio->save();				
				break;
			case 'Editar':
				    $servicio=Servicio::find($datos['idservicio']);
				    $servicio->idsocio=$datos['idsocio']; 
				    $servicio->idpersonal=$datos['idpersonal'];
					$servicio->placa=$datos['placa'];
					$servicio->modelo=$datos['modelo'];
					$servicio->anio=$datos['anio'];
					$servicio->idtiposervicio=$datos['idtiposervicio']; 
					$servicio->fecha_atencion_inicial=$datos['fecha_atencion'];
					$servicio->save();	
				break;
			case 'Eliminar':
					$servicio=Servicio::find($datos['idservicio']);
					$servicio->delete();
				break;
		}





	/*QUITAR COMENTARIO (VERSION ORIGINAL)
	public function save(Request $r){
		//recibir los datos que el usuario envíe
		$datos=$r->all();

		switch ($datos['operacion']) {
			case 'Agregar':
					$servicio=new Servicio();
					$servicio->nombre=$datos['cliente'];
					$servicio->placa=$datos['placa'];
					$servicio->modelo=$datos['modelo'];
					$servicio->anio=$datos['anio'];
					$servicio->tiposervicio=$datos['tiposervicio'];
					$servicio->save();				
				break;
			case 'Editar':
				    $servicio=Servicio::find($datos['idservicio']);
				    $servicio->nombre=$datos['cliente'];
					$servicio->placa=$datos['placa'];
					$servicio->modelo=$datos['modelo'];
					$servicio->anio=$datos['anio'];
					$servicio->tiposervicio=$datos['tiposervicio'];
					$servicio->save();	
				break;
			case 'Eliminar':
					$servicio=Servicio::find($datos['idservicio']);
					$servicio->delete();
				break;
		}*/

		//Comentar la redireccion al listado hasta que me quede bien mi insertar, modificar y eliminar
		return $this->listado();
	}
    


 
 
}