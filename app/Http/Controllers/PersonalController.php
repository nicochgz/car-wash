<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Model\Personal;

class PersonalController extends Controller{

	public function listado(){
		$personal=Personal::all();
		$datos=array();
		$datos['lista']=$personal;
		$datos['usuario']='Juan';
		return view('personal.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$personal=new Personal();
		}
		else{
			$operacion='Editar';
			$personal=Personal::find($datos['idpersonal']);
		}
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['personal']=$personal;

		return view('personal.formulario')->with($informacion);
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

					$personal=new Personal();
					$personal->nombrecompleto=$datos['nombrecompleto'];
					$personal->curp=$datos['curp'];
					$personal->foto=$nombre_archivo;
					$personal->save();		
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

					$personal=Personal::find($datos['idpersonal']);
					//Se borra el archivo viejo
					if($nombre_archivo!=''){
						Storage::delete($personal->foto);
					}
					$personal->nombrecompleto=$datos['nombrecompleto'];
					$personal->curp=$datos['curp'];
					//Guardo la referencia del archivo nuevo subido al file system
					if($nombre_archivo!='')
					$personal->foto=$nombre_archivo;
					$personal->save();
				break;

			case 'Eliminar':
					$personal=Personal::find($datos['idpersonal']);
					$personal->delete();
					Storage::delete($personal->foto);
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