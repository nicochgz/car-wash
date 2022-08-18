<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Libro;
use App\Model\Socio;
use App\Model\TipoServicio;
use App\Model\Puntos;
use App\Model\Servicio;
use App\Model\Sucursal;
use App\Model\Personal;
use App\BusinessLogic\BoServicio;
use App\BusinessLogic\BoPuntos;

//email
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionServicio;
//email



class DemoController extends Controller{

	
	public function listado(){
		dd('Ya entre al listado desde el DemoController');
	}
    

	public function prueba_bo(){
		$boservicio=new BoServicio();
		$x=new \StdClass();
		$x->idsocio=1;
		$x->idtiposervicio=2;
		$x->idpersonal=2;
		$x->placa='YTR-2469';
		$x->modelo='Tesla';
		$x->anio='2018';
		//$x->origen='WEB';
		$x->idestacion=2;
		$x->idhorario=4;
		$x->fecha_servicio='2021-02-14';
		$y=$boservicio->registrar_servicio($x);
		dd($y);
	}



	//Llegamos a este metodo por GET y POST
	public function prueba_vue(Request $r){
		$datos=array();
		//filas son los horarios
		$datos['horarios']=array();
		$datos['horarios'][]=array("iden"=>1,"label"=>'09:00 am');
		$datos['horarios'][]=array("iden"=>2,"label"=>'10:00 am');
		$datos['horarios'][]=array("iden"=>3,"label"=>'11:00 am');
		$datos['horarios'][]=array("iden"=>4,"label"=>'12:00 pm');
		$datos['horarios'][]=array("iden"=>5,"label"=>'13:00 pm');

		
		$datos['estaciones']=array();
		//columnas son las estaciones
		$datos['estaciones'][]=array("iden"=>1,"label"=>'Este');
		$datos['estaciones'][]=array("iden"=>2,"label"=>'Oeste');
		$datos['estaciones'][]=array("iden"=>3,"label"=>'Norte');
		$datos['estaciones'][]=array("iden"=>4,"label"=>'Sur');

		//Cuando es get no hay asignaciones porque no hay una fecha seleccionada
		
		if($r->isMethod('post')){
			$datos['asignaciones']=array();
			$datos['asignaciones'][]=array("fila"=>1,"columna"=>1,"cliente"=>'Nicolas Chavez','tipo'=>'Normal');
			
			$datos['asignaciones'][]=array("fila"=>1,"columna"=>2,"cliente"=>'Juan Peña','tipo'=>'Normal');
		}
		else{
			//dd('Estoy entrando la primera vez');
			$boservicio=new BoServicio();
			$objeto=new \StdClass();
			$objeto->fecha=date('Y-m-d');
			$datos['asignaciones']=$boservicio->obten_servicios($objeto);
			
			//Recuperar los servicios del dia de hoy
		}


		$datos['socios']=Socio::all();
		$datos['tipos']=TipoServicio::all();


		return view('test_vue.index')->with($datos);
	}

	public function prueba_asincrona(Request $r){
		/*$datos=array();
		$datos['asignaciones']=array();
		$datos['asignaciones'][]=array("fila"=>1,"columna"=>1,"cliente"=>'Nicolas Chavez','tipo'=>'Normal');	
		$datos['asignaciones'][]=array("fila"=>1,"columna"=>2,"cliente"=>'Juan Ruiz Solis','tipo'=>'Normal');*/
		$context=$r->all();
		$boservicio=new BoServicio();
		$objeto=new \StdClass();
		$objeto->fecha=$context['fecha'];
		return response()->json($boservicio->obten_servicios($objeto));
	}

	//ajuste
	public function obtener_servicios(){
		$boservicio=new BoServicio();
		$objeto=new \StdClass();
		$objeto->fecha='2021-11-04';
		return response()->json($boservicio->obtener_servicios($objeto));
	}
 	

 	public function insertar_servicio(Request $r){
 		$context=$r->all();
 		//dd($context);
 		$objeto=new \StdClass();
 		$objeto->idsocio=$context['servicio']['socio'];
 		$objeto->fecha_servicio=$context['servicio']['fecha'];
 		$objeto->idestacion=$context['servicio']['columna'];
 		$objeto->idhorario=$context['servicio']['fila'];
 		//$objeto->fa_inicial=$context['servicio']['fila'];
 		$objeto->idtiposervicio=$context['servicio']['tipo'];
 		$objeto->placa=$context['servicio']['placa'];
 		$objeto->modelo=$context['servicio']['modelo'];
 		$objeto->anio=$context['servicio']['anio'];
 		$objeto->curp_personal=$context['servicio']['personal']; 		

 		$boservicio=new BoServicio();
 		$resultado=$boservicio->registrar_servicio($objeto);

 		//enciar el correo electronico
 		if($resultado->status=='OK'){
 			$datos=new \StdClass();
	 		$datos->num_servicio=$resultado->servicio->idservicio;
	 		$datos->fecha_servicio=$resultado->servicio->fecha_atencion_inicial;
	 		$datos->cliente=$resultado->cliente;
	 		$datos->tipo_servicio=$resultado->tipo;
	 		$datos->total=$resultado->servicio->precio;
	 		Mail::to($resultado->email)->send(new ConfirmacionServicio($datos));
 		}
 		
 		//enciar el correo electronico
 		
 		return response()->json($resultado);

 	}


 	

 	public function insertar_puntos(Request $r){
 		$context=$r->all();
 		//dd($context);
 		$bopuntos=new BoPuntos();
 		$objeto=new \StdClass();
 		$objeto->idsocio=$context['servicio']['socio'];
 		$objeto->idtiposervicio=$context['servicio']['tipo'];
 		$objeto->curp_personal=$context['servicio']['personal'];
 		/*$objeto->puntos='';
 		$objeto->idsocio=2;
 		$objeto->idtiposervicio=3;
 		$objeto->curp_personal='CAGN010703HYNHMCA8';*/
 		//$objeto->curp_personal=$context['servicio']['personal'];
 		//$objeto->idtiposervicio=$context['servicio']['tipo'];
 		//$objeto->puntos=$context['puntos'];
 		
 		$resultado=$bopuntos->registrar_puntos($objeto);

 		dd($resultado);
 		//return response()->json($resultado);


 	}

 	public function envio_mail(){
 		$datos=new \StdClass();
 		$datos->num_servicio='7777';
 		$datos->fecha_servicio='14 de Febrero de 2022';
 		$datos->cliente='Nicolás Chávez';
 		$datos->tipo_servicio='Vip';
 		$datos->total=150;
 		Mail::to('nicolas.chavez@carwash.com')->send(new ConfirmacionServicio($datos));
 	}	
 
}