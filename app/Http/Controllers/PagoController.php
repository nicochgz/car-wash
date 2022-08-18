<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\BusinessLogic\BoServicio;
use App\Pagos\StripeProcessor;

class PagoController extends Controller{

	function ventanilla(Request $r){
		$datos_vista=array();
		if($r->isMethod('post')){
		   $context=$r->all();
		   $boser=new BoServicio();
		   $data=new \StdClass();
		   $data->idservicio=$context['idservicio'];
		   $datos_vista['servicio']=$boser->obten_servicios($data)[0];
		}
		return view('pagos.ventanilla')->with($datos_vista);
	}

	public function realizar_pago(Request $r){
		//procesamiento del pago
		$context=$r->all();
		$boser=new BoServicio();
		$data=new \StdClass();
	    $data->idservicio=$context['idservicio'];
	    $servicio=$boser->obten_servicios($data)[0];

		$stripe=new StripeProcessor();
		$objeto_pago=new \StdClass();
		$objeto_pago->amount=$servicio->precio*100;
		$objeto_pago->currency_code='MXN';
		$objeto_pago->producto=$servicio->tipo;
		$objeto_pago->email=$servicio->email;
		$objeto_pago->token=$context['token_stripe'];
		$objeto_pago->item_number=$context['idservicio'];

		$stripeResponse = $stripe->enviar_datos_pago($objeto_pago);
		if($stripeResponse->status=='OK'){
			//Poner todos los procesos de post venta
			$objeto_status=new \StdClass();
			$objeto_status->idservicio=$context['idservicio'];
			$res_status=$boser->pagar_servicio($objeto_status);

			//Hacer un registro que represente a un pago

			//Envio de correo
		}
		return response()->json($stripeResponse);

	}
}    