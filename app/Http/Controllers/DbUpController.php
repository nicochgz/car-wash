<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\Personal;
use App\Model\Servicio;
use App\Model\Sucursal;
use App\Model\TipoServicio;
use App\Model\Socio;

//para poder usar el Faker (generador de datos automático)
use Faker\Factory as Faker;
use App\BusinessLogic\BoServicio;
use App\Model\Horario;
use App\Model\Estacion;




class DbUpController extends Controller{
	public function personal(){
		$faker = Faker::create();
		$sucursales=Sucursal::all();
		for($i=1;$i<=50;$i++){			
			$personal=new Personal();			
			$personal->nombrecompleto=$faker->name.' '.$faker->lastname;		
			$personal->curp=$faker->regexify('([A-Z0-9]){10}');	
			$personal->foto='';	
			$personal->idsucursal=$sucursales->random()->idsucursal;
			$personal->save();
		}
	}



	
	public function servicio(){
		$faker = Faker::create();

		$modelos=array('Ford','Tesla','Seat','Mercedes-Benz','Nissan','Chevrolet','Honda','Volkswagen');

		$tipos=TipoServicio::all();
		$personales=Personal::all();

		for($i=1;$i<=50;$i++){
			$tipo=$tipos->random();
			$servicio=new Servicio();
			//nombre			
			$servicio->nombre=$faker->name.' '.$faker->lastname;
			//placa		
			$servicio->placa=$faker->regexify('([A-Z]){3}-([0-9]){4}');
			//modelo	
			$servicio->modelo=$faker->randomElement($modelos);
			//año
			$servicio->anio=$faker->numberBetween(2018,2020);
			//precio
			$servicio->precio=$tipo->precio;
			//idtiposervicio
			$servicio->idtiposervicio=$tipo->idtiposervicio;
			//idpersonal
			$servicio->idpersonal=$personales->random()->idpersonal;
			$servicio->save();
		}
	}



	public function servicio_fechas(){
		$faker = Faker::create();
		//Va a poblar el campo idsocio con uno de los socios registrados en la bd de forma aleatoria
		$socios=Socio::all();
		$servicios=Servicio::all();
		foreach($servicios as $servicio){
			//Asignar el idsocio de forma aleatoria
			//$servicio->idsocio=$socio->random()->idsocio;

			//la fecha de creacion es una fecha entre hoy y 4 meses atrás
			//La fecha de atencion es una fecha n dias despues de la fecha de registro donde n es un numero aleatorio entre 1 y 5
			$servicio->fecha_creacion=$faker->dateTimeBetween($startDate = '-4 month', $endDate = 'now');
			$dias_diferencia=$faker->numberBetween(1,5);
			$servicio->fecha_atencion=date('Y-m-d',strtotime($servicio->fecha_creacion->format('Y-m-d') . " + ".$dias_diferencia." day"));
			$servicio->save();
		}
	}


	public function servicio_bo(){
		$boservicio=new BoServicio();
		$faker = Faker::create();
		$modelos=array('Ford','Tesla','Seat','Mercedes-Benz','Nissan','Chevrolet','Honda','Volkswagen');
		$tipos=TipoServicio::all();
		$personales=Personal::all();
		$origenes=array('WEB','LOCAL','APP');
		$socios=Socio::all();
		$estaciones=Estacion::all();
		$horarios=Horario::all();

		$contador=1;

		while($contador<=100){



			$x=new \StdClass();
			$x->idsocio=$socios->random()->idsocio;
			$x->idtiposervicio=$tipos->random()->idtiposervicio;
			$x->idpersonal=$personales->random()->idpersonal;
			$x->placa=$faker->regexify('([A-Z]){3}-([0-9]){4}');
			$x->modelo=$faker->randomElement($modelos);
			$x->anio=$faker->numberBetween(2018,2020);
			$x->origen=$faker->randomElement($origenes);
			$x->idestacion=$estaciones->random()->idestacion;
			$x->idhorario=$horarios->random()->idhorario;
			$x->fecha_registro=$faker->dateTimeBetween($startDate = '-4 month', $endDate = 'now');
			$dias_diferencia=$faker->numberBetween(1,5);
			$x->fecha_servicio=date('Y-m-d',strtotime($x->fecha_registro->format('Y-m-d') . " + ".$dias_diferencia." day"));
			$y=$boservicio->registrar_servicio($x);
			if($y->status=='OK'){
				$contador++;
			}
		}		
	}
}