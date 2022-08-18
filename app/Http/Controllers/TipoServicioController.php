<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Model\TipoServicio;

class TipoServicioController extends Controller{

	public function listado(){
		$tiposervicio=TipoServicio::all();
		/*$tiposocio=TipoSocio::join('tiposocio','tiposocio.idtiposocio','=','socio.idtiposocio')
					 ->select(
					 		 "socio.idsocio"
					 		 ,"socio.nombre"
					 		 ,"tiposocio.idtiposocio"
					 		 ,"tiposocio.nombre as nomtiposocio"
					 		 )
					 ->get();*/
		$datos=array();
		$datos['lista']=$tiposervicio;
		$datos['usuario']='Juan';
		return view('tiposervicio.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$tiposervicio=new TipoServicio();
		}
		else{
			$operacion='Editar';
			$tiposervicio=TipoServicio::find($datos['idtiposervicio']);
		}
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['tiposervicio']=$tiposervicio;

		return view('tiposervicio.formulario')->with($informacion);
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

					$tiposervicio=new TipoServicio();
					$tiposervicio->nombre=$datos['nombre'];
					$tiposervicio->precio=$datos['precio'];
					$tiposervicio->idtiposervicio=$datos['idtiposervicio'];
					//$tiposocio->foto=$nombre_archivo;
					$tiposervicio->save();		
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

					$tiposervicio=TipoServicio::find($datos['idtiposervicio']);
					//Se borra el archivo viejo
					if($nombre_archivo!=''){
						Storage::delete($tiposervicio->foto);
					}
					$tiposervicio->nombre=$datos['nombre'];
					$tiposervicio->precio=$datos['precio'];
					$tiposervicio->idtiposervicio=$datos['idtiposervicio'];
					//Guardo la referencia del archivo nuevo subido al file system
					if($nombre_archivo!='')
					$tiposervicio->foto=$nombre_archivo;
					$tiposervicio->save();
				break;

			case 'Eliminar':
					$tiposervicio=TipoServicio::find($datos['idtiposervicio']);
					$tiposervicio->delete();
					Storage::delete($tiposervicio->foto);
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



}    