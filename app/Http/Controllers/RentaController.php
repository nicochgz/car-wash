<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Model\Renta;
use App\Model\Socio;

class RentaController extends Controller{

	public function listado(Request $r){
		$context=$r->all();
		//$renta=Renta::all();
		$renta=Renta::where('idsocio',$context['idsocio'])->get();
		$socio=Socio::find($context['idsocio']);		
		$datos=array();
		$datos['lista']=$renta;
		$datos['usuario']='Juan';
		$datos['socio']=$socio;
		return view('renta.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			//$context=$r->all();
			//POST significa que vamos a agregar
			$operacion='Agregar';
			$renta=new Renta();
			$renta->idsocio=$datos['idsocio'];
		}
		else{
			$operacion='Editar';
			$renta=Renta::find($datos['idrenta']);
		}

		//$socio=Socio::find($context['idsocio']);

		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['renta']=$renta;
		//$informacion['socio']=$socio;

		return view('renta.formulario')->with($informacion);
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

					$renta=new Renta();
					$renta->idrenta=$datos['idrenta'];
					$renta->idsocio=$datos['idsocio'];
					$renta->fecha_inicio=$datos['fecha_inicio'];
					$renta->fecha_fin=$datos['fecha_fin'];
					$renta->precio=$datos['precio'];				
					//$tiposocio->foto=$nombre_archivo;
					$renta->save();		
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

					$renta=Renta::find($datos['idrenta']);
					//Se borra el archivo viejo
					if($nombre_archivo!=''){
						Storage::delete($renta->foto);
					}
					
					$renta->fecha_inicio=$datos['fecha_inicio'];
					$renta->fecha_fin=$datos['fecha_fin'];
					$renta->precio=$datos['precio'];
					//Guardo la referencia del archivo nuevo subido al file system
					if($nombre_archivo!='')
					$renta->foto=$nombre_archivo;
					$renta->save();
				break;

			case 'Eliminar':
					$renta=Renta::find($datos['idrenta']);
					$renta->delete();
					Storage::delete($renta->foto);
				break;
		}

	
		return $this->listado($r);
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