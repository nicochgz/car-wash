<?php

namespace App\Pagos;
require_once 'Stripe/init.php';

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\ApiOperations\Create;
use Stripe\Charge;
use Stripe\HttpClient\CurlClient;
use Stripe\ApiRequestor;

use App\BusinessLogic\BoLogCheckout;

//use Illuminate\Support\Facades\DB;

Class StripeProcessor{
	var $objeto_stripe;

	function __construct(){
		$curl = new CurlClient([CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2]);
		ApiRequestor::setHttpClient($curl);
		$this->objeto_stripe=new Stripe();
		$this->objeto_stripe->setVerifySslCerts(false);
		$this->objeto_stripe->setApiKey('sk_test_51Ke7gxLjAsFwQDstrwZCwOyT6q7NRlHlGSafax8y2YWhNj9U4Pr2QmKFLOfmlsvUO3fzLIPhqeafCyvSNg9qjSBN008lto6Sxm');
	}

	function crear_customer($objeto){
		$customer = new Customer();
		$datos_customer=array();
		$datos_customer['email']=$objeto->email;
		$datos_customer['source']=$objeto->token;
		$customerDetails = $customer->create($datos_customer);
		return $customerDetails;
	}

	function enviar_datos_pago($objeto){
		$customerResult = $this->crear_customer($objeto);
		$cargo = new Charge();
		$cardDetailsAry = array(
			'customer'=>$customerResult->id,
			'amount'=>$objeto->amount,
			'currency'=>$objeto->currency_code,
			'description'=>$objeto->producto,
			'metadata' => array(
				'order_id' => $objeto->item_number
			)
		);
		//Conectamos con Stripe
		$result = $cargo->create($cardDetailsAry);
		$obj_result=$result->jsonSerialize();

		$resultado=new \StdClass();
		if(($obj_result['amount_refunded'] == 0) && (empty($obj_result['failure_code'])) && ($obj_result['paid']) && ($obj_result['captured']) && ($obj_result['status'] == 'succeeded') ){
			$resultado->status='OK';
			$resultado->transaccion=$obj_result;
		}
		else{
			$resultado->status='Error';
			$resultado->transaccion=null;
		}

		$bo=new BoLogCheckout();
		$objeto_log=new \StdClass();
		$objeto_log->idservicio=$objeto->item_number;
		$objeto_log->json=json_encode($obj_result);
		$bo->registrar($objeto_log);




		return $resultado;
	}
}

