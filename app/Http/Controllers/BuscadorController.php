<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BuscadorController extends Controller{
	function index(Request $r){
		$context=$r->all();
		if($r->isMethod('post')){
			//DB se le conoce como Query Builder
		$registros=DB::table('servicio')
					->join('personal','personal.idpersonal','=','servicio.idpersonal')
					->join('tiposervicio','tiposervicio.idtiposervicio','=','servicio.idtiposervicio')
					->join('socio','socio.idsocio','=','servicio.idsocio')
					->join('tiposocio','tiposocio.idtiposocio','=','socio.idtiposocio')
					->select(
							'socio.nombre'
							,'servicio.placa'
					        ,'modelo'
					        ,'anio'
					        //,'servicio.precio'
					        ,'tiposervicio.precio'
					        ,DB::Raw('tiposervicio.nombre as tiposervicio')
					        ,DB::Raw('tiposocio.nombre as nomtiposocio')
					        ,DB::Raw('personal.nombrecompleto as personal')
					)
					->whereRaw("placa like '%".$context['criterio']."%' or personal.nombrecompleto like '%".$context['criterio']."%' or socio.nombre like '%".$context['criterio']."%'")
					->get();

		
		$datos=array();
		$datos['registros']=$registros;
		$datos['criterio']=$context['criterio'];
		}
		else{
			$datos=array();
			$datos['registros']=array();
			$datos['criterio']='';
		}
		
		return view('buscador.index')->with($datos);
		/*
		select servicio.nombre
		      ,placa
		      ,modelo
		      ,anio
		      ,servicio.precio
		      ,tiposervicio.nombre as tiposervicio
		      ,personal.nombrecompleto as personal
		from servicio
		join personal on servicio.idpersonal=personal.idpersonal
		join tiposervicio on tiposervicio.idtiposervicio=servicio.idtiposervicio
		where placa like '%8%'
		*/
	}
}