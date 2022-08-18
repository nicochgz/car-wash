<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Permiso;

class PermisoController extends Controller{

	public function listado(){
		$permiso=Permiso::all();
		$datos=array();
		$datos['lista']=$permiso;
		$datos['usuario']='Juan';
		return view('permiso.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$permiso=new Permiso();
		}
		else{
			$operacion='Editar';
			$permiso=Permiso::find($datos['idpermiso']);
		}
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['permiso']=$permiso;

		return view('permiso.formulario')->with($informacion);
	}

	public function save(Request $r){
		$datos=$r->all();

		switch ($datos['operacion']) {
			case 'Agregar':	
					$permiso=new Permiso();
					$permiso->nompermiso=$datos['nompermiso'];
					$permiso->clave=$datos['clave'];
					$permiso->save();			
				break;
			case 'Editar':
					$permiso=Permiso::find($datos['idpermiso']);
					$permiso->nompermiso=$datos['nompermiso'];
					$permiso->clave=$datos['clave'];
					$permiso->save();	
				break;
			case 'Eliminar':
					$permiso=Permiso::find($datos['idpermiso']);
					$permiso->delete();
				break;
		}

		

		
		return $this->listado();
	}



}    