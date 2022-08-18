<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Rol;

class RolController extends Controller{

	public function listado(){
		$rol=Rol::all();
		$datos=array();
		$datos['lista']=$rol;
		$datos['usuario']='Juan';
		return view('rol.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$rol=new Rol();
		}
		else{
			$operacion='Editar';
			$rol=Rol::find($datos['idrol']);
		}
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['rol']=$rol;

		return view('rol.formulario')->with($informacion);
	}

	public function save(Request $r){
		$datos=$r->all();

		switch ($datos['operacion']) {
			case 'Agregar':	
					$rol=new Rol();
					$rol->nomrol=$datos['nomrol'];
					$rol->save();			
				break;
			case 'Editar':
					$rol=Rol::find($datos['idrol']);
					$rol->nomrol=$datos['nomrol'];
					$rol->save();	
				break;
			case 'Eliminar':
					$rol=Rol::find($datos['idrol']);
					$rol->delete();
				break;
		}

		

		
		return $this->listado();
	}



}    