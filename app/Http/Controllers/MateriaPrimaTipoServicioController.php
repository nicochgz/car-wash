<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\MateriaPrima;
use App\Model\TipoServicio;
use App\Model\MateriaPrimaTipoServicio;

/*use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
*/

class MateriaPrimaTipoServicioController extends Controller{

	function formulario(Request $r){
		$datos=$r->all();
		$info=array();
		$materias=MateriaPrima::all();
		$asignadas=MateriaPrimaTipoServicio::where('idtiposervicio',$datos['idtiposervicio'])->get();
		$tiposervicio=TipoServicio::find($datos['idtiposervicio']);

		for($i=0;$i<count($materias);$i++){
			$bandera=false;
			foreach($asignadas as $elemento){
				if($elemento->idmateria_prima==$materias[$i]->idmateria_prima){
					$bandera=true;
				}
			}

			$materias[$i]->asignada=$bandera;
		}


		$info['materias']=$materias;
		$info['tiposervicio']=$tiposervicio;

		return view('materiaprimaxtiposervicio.formulario')->with($info);
		
	}

	function save(Request $r){
		$datos=$r->all();
		//1.-Borrar todas las materias primas del tipo de servicio seleccionado
		MateriaPrimaTipoServicio::where('idtiposervicio',$datos['idtiposervicio'])->delete();

		if(isset($datos['idmateria_prima'])){
			//2.-Insertar todas las materias de la petición
			foreach($datos['idmateria_prima'] as $materia){
				$mxtip=new MateriaPrimaTipoServicio();
				$mxtip->idmateria_prima=$materia;
				$mxtip->idtiposervicio=$datos['idtiposervicio'];
				$mxtip->save();
			}
		}
		return $this->formulario($r);
	}


}    