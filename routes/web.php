<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 




//El tipo de ruta, la dirección, el tercer parametro es el controlador y el metodo



Route::get('/helper', function(){
   dd(dummy());
});


Route::group(['middleware' => 'auth'], function() {//para que se valide el


   //SERVICIO Y TIPO SERVICIO//
   Route::get('/catalogos/servicio/listado','ServicioController@listado')->middleware('candado2:SERVICIO');
   //Una ruta que acepte tanto el POST como el GET   
   Route::match(array('GET','POST'),'/catalogos/servicio/formulario','ServicioController@formulario')->middleware('candado2:SERVICIO');
   //Route::post('/servicios/formulario','ServicioController@formulario');   
   Route::post('/catalogos/servicio/save','ServicioController@save')->middleware('candado2:SERVICIO');   



   Route::get('/catalogos/tiposervicio/listado','TipoServicioController@listado');
   Route::match(array('GET','POST'),'/catalogos/tiposervicio/formulario','TipoServicioController@formulario');
   Route::post('/catalogos/tiposervicio/save','TipoServicioController@save');
   //SERVICIO Y TIPO SERVICIO//



   Route::get('/catalogos/personal/listado','PersonalController@listado')->middleware('candado2:PERSONAL');
   Route::match(array('GET','POST'),'/catalogos/personal/formulario','PersonalController@formulario')->middleware('candado2:PERSONAL');
   //Route::post('/personal/formulario','PersonalController@formulario');
   Route::post('/catalogos/personal/save','PersonalController@save')->middleware('candado2:PERSONAL');

   Route::get('fotos/{nombre_foto}','PersonalController@mostrar_foto')->middleware('candado2:PERSONAL');



   Route::get('/catalogos/producto/listado','ProductoController@listado');
   Route::match(array('GET','POST'),'/catalogos/producto/formulario','ProductoController@formulario');
   //Route::post('/producto/formulario','ProductoController@formulario');
   Route::post('/catalogos/producto/save','ProductoController@save');


      /*Route::get('/servicios/listado_servicio',function(){
      	//Dumb and die
         dd('algo');
      });*/


   //ROL Y PERMISOS
   Route::get('/catalogos/rol/listado','RolController@listado');

   Route::match(array('GET','POST'),'/catalogos/rol/formulario','RolController@formulario');

   Route::post('/catalogos/rol/save','RolController@save');



   Route::get('/catalogos/permisos/listado','PermisoController@listado');

   Route::match(array('GET','POST'),'/catalogos/permisos/formulario','PermisoController@formulario');

   Route::post('/catalogos/permisos/save','PermisoController@save');
   //ROL Y PERMISOS


   //RENTA
   Route::get('/catalogos/renta/listado','RentaController@listado');
   Route::match(array('GET','POST'),'/catalogos/renta/formulario','RentaController@formulario');
   Route::post('/catalogos/renta/save','RentaController@save');
   //RENTA


   //MateriaPrima
   Route::get('/catalogos/materia_prima/listado','MateriaPrimaController@listado');

   Route::match(array('GET','POST'),'/catalogos/materia_prima/formulario','MateriaPrimaController@formulario');

   Route::post('/catalogos/materia_prima/save','MateriaPrimaController@save');
   //MateriaPrima


   //MateriaPrimaTipoServicio
   Route::get('/catalogos/tiposervicio/materia_prima','MateriaPrimaTipoServicioController@formulario');
   Route::post('/catalogos/tiposervicio/materia_prima/save','MateriaPrimaTipoServicioController@save');
   //MateriaPrimaTipoServicio



   //SOCIO Y TIPO SOCIO//
   Route::get('/catalogos/socio/listado','SocioController@listado');
   Route::match(array('GET','POST'),'/catalogos/socio/formulario','SocioController@formulario');
   Route::post('/catalogos/socio/save','SocioController@save');

   Route::get('fotos/{nombre_foto}','SocioController@mostrar_foto');


   Route::get('/catalogos/tiposocio/listado','TipoSocioController@listado')->middleware('candado2:TIPOSOCIO');
   Route::match(array('GET','POST'),'/catalogos/tiposocio/formulario','TipoSocioController@formulario')->middleware('candado2:TIPOSOCIO');
   Route::post('/catalogos/tiposocio/save','TipoSocioController@save')->middleware('candado2:TIPOSOCIO');

   //SOCIO Y TIPO SOCIO//

   //Usuario
   Route::get('/catalogos/usuarios/listado','UsuarioController@listado');
   Route::match(array('GET','POST'),'/catalogos/usuarios/formulario','UsuarioController@formulario');
   Route::post('/catalogos/usuarios/save','UsuarioController@save');
   //Usuario




   Route::get('/catalogos/permiso','RolxPermisoController@formulario');
   Route::post('/catalogos/permiso/save','RolxPermisoController@save');


   Route::get('sinpermiso',function(){
      dd('No tiene permiso');
   });


   Route::get('/cerrar_sesion',function(){
      //Cierre de sesión
      auth()->logout();
      return redirect('/');
   })->name('salir');


   Route::match(array('GET','POST'),'/buscador','BuscadorController@index');

   //test email
   Route::get('/test/email','DemoController@envio_mail');   
   //test email

   //pagos
   Route::match(array('GET','POST'),'/pagos/ventanilla','PagoController@ventanilla');
   Route::post('/pagos/procesar','PagoController@realizar_pago');
   //pagos

});

   //DbUp
   Route::get('dbup/personal','DbUpController@personal');
   Route::get('dbup/servicio','DbUpController@servicio');
   Route::get('dbup/servicio_fecha','DbUpController@servicio_fechas');
   Route::get('dbup/servicio_bo','DbUpController@servicio_bo');



   
   //DbUp


   Route::get('template_demo',function(){
      return view('app.dummy2');
   });


   	

   Route::get('/test_registro',function(){
      return view('auth.register');
   });


   Auth::routes();


   Route::get('/usuarios/registro','Auth\RegisterController@formulario_registro')->name('register');
   Route::post('/usuarios/registro/save','Auth\RegisterController@register');

   //autoregistro 
   Route::get('/registrate', function(){
      return view('auth.registro_socio');
   });
   Route::get('/socio/bienvenido', 'SocioController@perfil');
   //autoregistro


   //login
   Route::get('/manage','Auth\LoginController@showLoginForm')->name('login');
   Route::get('/','Auth\LoginController@showLoginForm');

   Route::post('login','Auth\LoginController@login');
   //login


   //Route::get('/home', 'HomeController@index')->name('home');


   //Route::get('/prueba_bo','DemoController@prueba_bo');


   Route::match(array('GET','POST'),'/test_vue','DemoController@prueba_vue');
   Route::post('/prueba_axios','DemoController@prueba_asincrona');
   Route::post('/insertar_servicio','DemoController@insertar_servicio');
   Route::post('/insertar_puntos','DemoController@insertar_puntos');
   //Route::match(array('GET','POST'),'/insertar_puntos','DemoController@insertar_puntos');
   Route::get('/prueba_consulta','DemoController@obtener_servicios');

