<?php

namespace App\BusinessLogic;

use App\Model\TipoServicio;
use App\Model\Puntos;
use App\Model\Servicio;
use App\Model\Sucursal;
use App\Model\Socio;
use App\Model\Personal;


use Illuminate\Support\Facades\DB;

Class BoPuntos{

	function registrar_puntos($objeto){
		$resultado=new \StdClass();
		//$puntos=Puntos::where('idsocio',$objeto->idsocio)->first();

		/*$puntos=new Puntos();
		$puntos->idsocio=$objeto->idsocio;
		$puntos->save();
		$resultado->status='OK';
		$resultado->puntos=$puntos;*/


		if(isset($objeto->curp_personal)){
			$personal=Personal::where('curp',$objeto->curp_personal)->first();
			$objeto->idpersonal=$personal->idpersonal;
		}


		$tiposervicio=TipoServicio::where('idtiposervicio',$objeto->idtiposervicio)->first();
		//$servicio=Servicio::where('idservicio',$objeto->idservicio)->first();
		//$servicio=Servicio::find($objeto->idservicio);
		//$tiposervicio=TipoServicio::find($objeto->idtiposervicio);
		//$socio=Socio::find($objeto->idsocio);
		if($tiposervicio){
			
			
			//switch ($personal->idsucursal) {
			switch ($objeto->idtiposervicio) {	
			 	case 1:
			 		switch ($personal->idsucursal) {
						case 1:
							$puntos=0;
							break;
						case 2:
							$puntos=0;
							break;
						case 3:
							$puntos=0;
							break;
						case 4:
							$puntos=0;
							break;
					}
			 		break;
			 	case 2:
			 		switch ($personal->idsucursal) {
						case 1:
							$puntos=0;
							break;
						case 2:
							$puntos=0;
							break;
						case 3:
							$puntos=0;
							break;
						case 4:
							$puntos=0;
							break;
					}
			 		break;			
				case 3:
				$personal=Personal::find($objeto->idpersonal);					
					switch ($personal->idsucursal) {
						case 1:
							$puntos=5;
							break;
						case 2:
							$puntos=10;
							break;
						case 3:
							$puntos=15;
							break;
						case 4:
							$puntos=20;
							break;
					}
					break;

			


			}
			$total_puntos=($tiposervicio->precio)*($puntos/100);
			$puntos=Puntos::where('idsocio',$objeto->idsocio)->first();
			$sucursal=Sucursal::where('idsucursal',$personal->idsucursal)->first();
			if($puntos){
				$puntos->puntos=$puntos->puntos+$total_puntos;
				$sucursal->puntos=$sucursal->puntos+$total_puntos;
			}
			else{
				$puntos=new Puntos();
				$puntos->idsocio=$objeto->idsocio;
				$puntos->puntos=$total_puntos;				
			}
			$puntos->save();
			$sucursal->save();
			$resultado->status='OK';
			$resultado->puntos=$puntos;
			$resultado->sucursal=$sucursal;
			
			
		}
		else{
			//Registro de la información si la validacion(es) no se cumpla
			$resultado->status='Error';
			$resultado->mensaje='No se realizó ningún servicio';
		}
		return $resultado;

	}
}

