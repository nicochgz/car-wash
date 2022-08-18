<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Model\Socio;
use App\Model\TipoSocio;
use App\Model\Servicio;
use App\Model\TipoServicio;
use App\Model\Puntos;

class SocioController extends Controller{

	public function listado(){
		//$socio=Socio::all();
		$socio=Socio::join('tiposocio','tiposocio.idtiposocio','=','socio.idtiposocio')	
					 ->join('puntos','puntos.idsocio','=','socio.idsocio')					
					 ->select(
					 		 "socio.idsocio"
					 		 ,"socio.nombre"
					 		 ,"socio.foto"
					 		 ,"tiposocio.idtiposocio"
					 		 ,"tiposocio.nombre as nomtiposocio"	
					 		 ,"puntos.puntos" 		 
					 		 )
					 ->get();
		$datos=array();
		$datos['lista']=$socio;
		$datos['usuario']='Juan';
		return view('socio.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$socio=new Socio();
		}
		else{
			$operacion='Editar';
			$socio=Socio::find($datos['idsocio']);
		}

		$tipos=TipoSocio::all();

		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['socio']=$socio;
		$informacion['tipos']=$tipos;

		return view('socio.formulario')->with($informacion);
	}

	public function save(Request $r){
		$datos=$r->all();
		//dd($datos);

		switch ($datos['operacion']) {
			case 'Agregar':	
			if ($r->hasFile('foto')) {
				$archivo=$r->file('foto');
				//time() nos genera un timestamp
				//getClientOriginalExtension nos obtiene la extension del archivo
				$nombre='foto-'.time().'.'.$archivo->getClientOriginalExtension();
				/*Solo muestra el nombre cuando es png
					dd($nombre);*/
				$nombre_archivo=$archivo->storeAs('fotos',$nombre);
			}
			else{
				$nombre_archivo='';
			}

					$socio=new Socio();
					$socio->nombre=$datos['nombre'];
					$socio->idtiposocio=$datos['idtiposocio'];
					$socio->foto=$nombre_archivo;
					$socio->save();		
				break;

			case 'Editar':
			if ($r->hasFile('foto')) {
				$archivo=$r->file('foto');				
				//time() nos genera un timestamp
				//getClientOriginalExtension nos obtiene la extension del archivo
				$nombre='foto-'.time().'.'.$archivo->getClientOriginalExtension();
				$nombre_archivo=$archivo->storeAs('fotos',$nombre);
				//Solo muestra el nombre cuando es png dd($nombre_archivo);
			}
			else{
				$nombre_archivo='';
			}

					$socio=Socio::find($datos['idsocio']);
					//Se borra el archivo viejo
					if($nombre_archivo!=''){
						Storage::delete($socio->foto);
					}
					$socio->nombre=$datos['nombre'];
					$socio->idtiposocio=$datos['idtiposocio'];
					//Guardo la referencia del archivo nuevo subido al file system
					if($nombre_archivo!='')
					$socio->foto=$nombre_archivo;
					$socio->save();
				break;

			case 'Eliminar':
					$socio=Socio::find($datos['idsocio']);
					$socio->delete();
					Storage::delete($socio->foto);
				break;
		}

	
		return $this->listado();
	}

	/*Comentar esto*/
	public function mostrar_foto($nombre_foto){
		//storage_path es una funcion de laravel que devuelve la ruta real del archivo dentro de la carpeta storage

		$path = storage_path('app/fotos/'.$nombre_foto);


		if (!File::exists($path)) {
			abort(404);
		}
		//recuperar el contenido del archivo
		$file = File::get($path);
		//recupero el tipo de archivo
		$type = File::mimeType($path);
		//devuelvo el archivo
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		return $response;
	}

	function perfil(){
		$usuario=auth()->user();
		//recupero el dato del socio de acuerdo al id del usuario
		$socio=Socio::where('idusuario',$usuario->idusuario)->first();
		$tiposocio=TipoSocio::find($socio->idtiposocio);

		//hay que poner el precio del servicio en lugar de solo el id de tiposervicio
		//$tiposervicio=TipoServicio::where('idtiposervicio',$servicio->idtiposervicio)->first();
		

		$informacion=array();
		$informacion['socio']=$socio;
		$informacion['usuario']=$usuario;
		$informacion['tiposocio']=$tiposocio;

		//hay que poner el precio del servicio en lugar de solo el id de tiposervicio   VIDEO 11
		/*$informacion['tiposervicio']=$tiposervicio;		
		$informacion['servicios']=Servicio::where('idtiposervicio',$tiposervicio->idtiposervicio)->get();*/
		

		$informacion['servicios']=Servicio::where('idsocio',$socio->idsocio)->get();



		return view('auth.profile')->with($informacion);
	}

}    