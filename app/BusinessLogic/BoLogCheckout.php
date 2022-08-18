<?php

namespace App\BusinessLogic;
use App\Model\LogCheckout;

use Illuminate\Support\Facades\DB;

class BoLogCheckout{
	function registrar($objeto){
		$log=new LogCheckout();
		$log->idservicio=$objeto->idservicio;
		$log->fecha=date('Y-m-d H:i:s');
		if(isset($objeto->pasarela))
		 $log->pasarela=$objeto->pasarela;
		else
		 $log->pasarela='Stripe';
		 $log->json=$objeto->json;
		 $log->save();
	}
	
}