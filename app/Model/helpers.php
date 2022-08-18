<?php
use App\Model\Permiso;
use App\Model\RolxPermiso;
use App\Model\Personal;
use App\Model\Socio;


function dummy(){
	dd('llegué al helper');
}

function hoy($formato='Y-m-d H:i:s'){
	date_default_timezone_set("America/Merida");
	return date($formato);
}

function validar_permiso_rol($idrol,$permiso)
{

    	//$idrol=auth()->user()->idrol;
    	$permiso_db=Permiso::where('clave',$permiso)->first();
    	$rolxpermiso=RolxPermiso::where('idrol',$idrol)->where('idpermiso',$permiso_db->idpermiso)->first();

    	if($rolxpermiso){
            
    	return true;
    	}
    	else{
            return false;  		
    	} 
}

function dame_nombre_usuario($user){
	$nombre='Username';
	//dd($user->idusuario);
	switch($user->idrol){
		case 1:
			//Gerente y lo tomo de la tabla personal
			$personal=Personal::where('idusuario',$user->idusuario)->first();
			$nombre=$personal->nombrecompleto;
		break;
		case 2:
			//Contabilidad y lo tomo de la tabla personal
			$personal=Personal::where('idusuario',$user->idusuario)->first();
			$nombre=$personal->nombrecompleto;
		break;
		case 3:
			//Hostess y lo tomo de la tabla personal
			$personal=Personal::where('idusuario',$user->idusuario)->first();
			$nombre=$personal->nombrecompleto;
		break;
		case 4:
			//Socio y lo tomo de la tabla socio
			$socio=Socio::where('idusuario',$user->idusuario)->first();
			$nombre=$socio->nombre;
		break;
	}

	return $nombre;
}

