<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Permiso;
use App\Model\Rol;
use App\Model\RolxPermiso;

class RolxPermisoController extends Controller{

	function formulario(Request $r){
		$datos=$r->all();		
		$info=array();
		$permisos=Permiso::all();
		$asignados=RolxPermiso::where('idrol',$datos['idrol'])->get();		
		$rol=Rol::find($datos['idrol']);

		for($i=0;$i<count($permisos);$i++){
			$bandera=false;
			foreach($asignados as $elemento){
				if($elemento->idpermiso==$permisos[$i]->idpermiso){
					$bandera=true;
				}
			}

			$permisos[$i]->asignado=$bandera;
		}


		$info['permisos']=$permisos;
		$info['rol']=$rol;
		return view('rolxpermiso.formulario')->with($info);
	}

	function save(Request $r){
		$datos=$r->all();

		//1.- Borrar todos los permisos del rol seleccionado
		RolxPermiso::where('idrol',$datos['idrol'])->delete();

		//Cuando no selecciono ningun checkbox no existe el datos['idpermiso']
		if(isset($datos['idpermiso'])){
			//2.-Insertar todos los permisos de la petición
			foreach($datos['idpermiso'] as $permiso){
				$rolxper=new RolxPermiso();
				$rolxper->idpermiso=$permiso;
				$rolxper->idrol=$datos['idrol'];
				$rolxper->save();
			}			
		}

		return $this->formulario($r);
		
	}
}