<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Model\Usuario;
use App\Model\Rol;

class UsuarioController extends Controller{

	public function listado(){
		//$socio=Socio::all();
		$usuario=Usuario::join('rol','rol.idrol','=','usuario.idrol')
					 ->select(
					 		 "usuario.idusuario"
					 		 ,"usuario.email"
					 		 ,"usuario.password"
					 		 ,"rol.idrol"
					 		 ,"rol.nomrol"
					 		 )
					 ->get();
		$datos=array();
		$datos['lista']=$usuario;
		$datos['usuario']='Juan';
		return view('usuario.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$usuario=new Usuario();
		}
		else{
			$operacion='Editar';
			$usuario=Usuario::find($datos['idusuario']);
		}

		$roles=Rol::all();

		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['usuario']=$usuario;
		$informacion['roles']=$roles;

		return view('usuario.formulario')->with($informacion);
	}



	public function save(Request $r){
		$datos=$r->all();
		//dd($datos);

		switch ($datos['operacion']) {
			case 'Agregar':	
					$usuario=new Usuario();
					$usuario->email=$datos['email'];
					
					$usuario->idrol=$datos['idrol'];
					$usuario->save();		
				break;

			case 'Editar':			
					$usuario=Usuario::find($datos['idusuario']);	
					$usuario->email=$datos['email'];
					
					$usuario->idrol=$datos['idrol'];
					
					$usuario->save();
				break;

			case 'Eliminar':
					$usuario=Usuario::find($datos['idusuario']);
					$usuario->delete();
				break;
		}

	
		return $this->listado();
	}


	/*No hay formulario, los registros se hacen en el 'auth.register' o en el autoregistro
	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$usuario=new Usuario();
		}
		else{
			$operacion='Editar';
			$usuario=Usuario::find($datos['idusuario']);
		}

		$roles=Rol::all();

		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['usuario']=$usuario;
		$informacion['roles']=$roles;

		return view('auth.register')->with($informacion);
	}*/

	


	/* Los datos se agregan en el 'auth.register' o en el autoregistro
	public function save(Request $r){
		$datos=$r->all();
		//dd($datos);

		switch ($datos['operacion']) {
			case 'Agregar':	
					$usuario=new Usuario();
					$usuario->nombre=$datos['nombre'];
					$usuario->idtiposocio=$datos['idtiposocio'];
					$usuario->foto=$nombre_archivo;
					$usuario->save();		
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
	}*/

	
	/*Funcion copiada del SocioController
	function perfil(){
		$usuario=auth()->user();
		//recupero el dato del socio de acuerdo al id del usuario
		$socio=Socio::where('idusuario',$usuario->idusuario)->first();
		$tiposocio=TipoSocio::find($socio->idtiposocio);

		
		

		$informacion=array();
		$informacion['socio']=$socio;
		$informacion['usuario']=$usuario;
		$informacion['tiposocio']=$tiposocio;

		
		

		$informacion['servicios']=Servicio::where('idsocio',$socio->idsocio)->get();



		return view('auth.profile')->with($informacion);
	}*/

}    