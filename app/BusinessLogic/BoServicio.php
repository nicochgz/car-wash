<?php

namespace App\BusinessLogic;

use App\Model\TipoServicio;
use App\Model\Servicio;
use App\Model\Horario;
use App\Model\Personal;
use App\Model\Socio;
use App\Model\Usuario;
use App\Model\Estacion;
//ajuste
use Illuminate\Support\Facades\DB;

class BoServicio{

	//Metodo que cambia el status de un servicio ya pagado
	//Recibe un objeto con el atributo idservicio
	function pagar_servicio($objeto){
		$resultado=new \StdClass();
		$servicio=Servicio::find($objeto->idservicio);
		if($servicio->status==1){
			$servicio->status=2;
			$servicio->save();
			$resultado->status='OK';
		}
		else{
			$resultado->status='Error';
		}

		return $resultado;
	}



	//Metodo que recupera servicios a partir de los siguientes parametros
	//Fecha: la fecha de atencion del servicio	
	function obten_servicios($objeto){
		//$datos['asignaciones'][]=array("fila"=>1,"columna"=>2,"cliente"=>'Juan Peña','tipo'=>'Normal');
		$consulta=Servicio::join('socio','socio.idsocio','=','servicio.idsocio')
						  ->join('tiposervicio','servicio.idtiposervicio','=','tiposervicio.idtiposervicio')
						  ->join('estacion','estacion.idestacion','=','servicio.idestacion')
						  ->join('usuario','usuario.idusuario','socio.idusuario')
						  ->select(
						  		  \DB::Raw("idhorario as fila")
						  		  ,\DB::Raw("servicio.idestacion as columna")
						  		  ,\DB::Raw("socio.nombre as cliente")
						  		  ,\DB::Raw("tiposervicio.nombre as tipo")
						  		  ,\DB::Raw("DATE_FORMAT(fecha_atencion_inicial, '%Y-%m-%d %H:%i') as fecha_atencion_inicial")
						  		  ,"estacion.nomestacion"
						  		  ,"servicio.placa"
						  		  ,"servicio.modelo"
						  		  ,"servicio.anio"
						  		  ,"servicio.precio"
						  		  ,"servicio.idservicio"
						  		  ,"usuario.email"
						  		  );
		if(isset($objeto->fecha)){
			//Significa que quiero un filtro por fecha
			$consulta->whereRaw("DATE_FORMAT(fecha_atencion_inicial,'%Y-%m-%d')='".$objeto->fecha."'");
		}

		if(isset($objeto->idservicio)){
			$consulta->where("servicio.idservicio",$objeto->idservicio);
		}

		return $consulta->get();
	}


	/*function valida_horario($objeto){
		$bandera=true;

		$servicios=Servicio::where('idestacion',$objeto->idestacion)
							->whereRaw("fecha_atencion_inicial<'".$objeto->fa_final."' and fecha_atencion_final>'".$objeto->fa_inicial."'")
							->get();
		if(count($servicios)!=0){
			//Si la consulta devuelve datos significa que hay servicios que chocan y por lo tanto NO SE PUEDEN programar
			$bandera=false;
		}

		return $bandera;
	}*/
	function valida_horario($objeto){
		$resultado=new \StdClass();

		$servicios=Servicio::where('idestacion',$objeto->idestacion)
							->whereRaw("fecha_atencion_inicial<'".$objeto->fa_final."' and fecha_atencion_final>'".$objeto->fa_inicial."'")
							->get();
		if(count($servicios)!=0){
			//Si la consulta devuelve datos significa que hay servicios que chocan y por lo tanto NO SE PUEDEN programar
			$resultado->bandera=false;
			$resultado->servicios=$servicios;
		}
		else{
			$resultado->bandera=true;
		}

		return $resultado;
	}



	//Este metodo sirve para registrar un servicio
	//La información de entrada es: el idsocio, fecha de registro (opcional), idtiposervicio, idpersonal, placa, modelo del carro, anio del carro, origen del servicio (opcional), idestacion, idhorario, fecha del servicio

	//Tiene como dato de salida los datos del servicio creado

	function registrar_servicio($objeto){
		$resultado=new \StdClass();

		//1.- Tratamiento de la información de entrada
		if(!isset($objeto->fecha_registro)){
			$objeto->fecha_registro=date('Y-m-d H:i:s');
		}

		if(!isset($objeto->origen)){
			$objeto->origen='LOCAL';
		}

		if(!isset($objeto->precio)){
			$tipo=TipoServicio::find($objeto->idtiposervicio);
			$objeto->precio=$tipo->precio;
		}

		//if(!isset($objeto->idhorario))
		if(!isset($objeto->fa_inicial)){
			$horario=Horario::find($objeto->idhorario);
			$objeto->fa_inicial=$objeto->fecha_servicio.' '.$horario->hora_inicial;
			$objeto->fa_final=$objeto->fecha_servicio.' '.$horario->hora_final;
		}



				
		if(isset($objeto->curp_personal)){
			$personal=Personal::where('curp',$objeto->curp_personal)->first();
			$objeto->idpersonal=$personal->idpersonal;
		}

		

		//validacion para el procesamiento
		$bandera_procesar=1;

		$servicios=Servicio::where('idestacion',$objeto->idestacion)
							->whereRaw("fecha_atencion_inicial<'".$objeto->fa_final."' and fecha_atencion_final>'".$objeto->fa_inicial."'")
							->get();
		if(count($servicios)!=0){
			$bandera_procesar=0;
		}

		//validacion para el procesamiento

		

		//obtener el precio a través del tipo de servicio
		//1.- Tratamiento de la información de entrada

		//2.- Validaciones


		//$bandera=$this->valida_horario($objeto);


		//Si está disponible la estación para el horario seleccionado
		//2.- Validaciones

		//3.- Crear la información
		if($bandera_procesar==1){
			//Registro de la información si la validacion(es) se cumplen
			
			
			$servicio=new Servicio();
			$servicio->idsocio=$objeto->idsocio;
			$servicio->fecha_creacion=$objeto->fecha_registro;
			$servicio->fecha_atencion_inicial=$objeto->fa_inicial;
			$servicio->fecha_atencion_final=$objeto->fa_final;
			$servicio->idtiposervicio=$objeto->idtiposervicio;
			$servicio->idpersonal=$objeto->idpersonal;
			$servicio->precio=$objeto->precio;
			$servicio->placa=$objeto->placa;
			$servicio->modelo=$objeto->modelo;
			$servicio->anio=$objeto->anio;
			$servicio->origen=$objeto->origen;				
			$servicio->idestacion=$objeto->idestacion;
			$servicio->idhorario=$objeto->idhorario;
			$servicio->status=1;		
			$servicio->save();
			$resultado->status='OK';
			$resultado->servicio=$servicio;
			$socio2=Socio::find($servicio->idsocio);
			$tipo2=TipoServicio::find($servicio->idtiposervicio);
			$usuario2=Usuario::find($socio2->idusuario);
			$resultado->cliente=$socio2->nombre;
			$resultado->tipo=$tipo2->nombre;
			$resultado->email=$usuario2->email;
		}
		else{
			//Registro de la información si la validacion(es) no se cumpla
			$resultado->status='Error';
			$resultado->mensaje='La estación no está disponible para la fecha y el horario seleccionado';
		}
		//3.- Crear la información


		return $resultado;
	}



}