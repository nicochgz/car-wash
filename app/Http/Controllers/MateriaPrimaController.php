<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\MateriaPrima;

class MateriaPrimaController extends Controller{

	public function listado(){
		$materia=MateriaPrima::all();
		$datos=array();
		$datos['lista']=$materia;
		$datos['usuario']='Juan';
		return view('materiaprima.listado')->with($datos);
	}

	public function formulario(Request $r){
		$datos=$r->all();

		if($r->isMethod('post')){
			$operacion='Agregar';
			$materia=new MateriaPrima();
		}
		else{
			$operacion='Editar';
			$materia=MateriaPrima::find($datos['idmateria_prima']);
		}
		$informacion=array();
		$informacion['operacion']=$operacion;
		$informacion['materia']=$materia;

		return view('materiaprima.formulario')->with($informacion);
	}

	public function save(Request $r){
		$datos=$r->all();

		switch ($datos['operacion']) {
			case 'Agregar':	
					$materia=new MateriaPrima();
					$materia->nombre=$datos['nombre'];
					$materia->save();			
				break;
			case 'Editar':
					$materia=MateriaPrima::find($datos['idmateria_prima']);
					$materia->nombre=$datos['nombre'];
					$materia->save();	
				break;
			case 'Eliminar':
					$materia=MateriaPrima::find($datos['idmateria_prima']);
					$materia->delete();
				break;
		}

		

		
		return $this->listado();
	}



}    