<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


 

    function showLoginForm(){
            return view('auth.login');
    }

    protected function redirectTo()
    {
        //con la funcion auth()->user() recuperamos el modelo del usuario que está en la sesión del sistema
        
        switch(auth()->user()->idrol){
            case 4:
            //el "4" indica que un socio está haciendo el login
            return '/socio/bienvenido';
            break;

            case 3:
            //el "3" indica que un hostess está haciendo el login
            return '/catalogos/servicio/listado';
            break;

            case 2:
            //el "2" indica que una persona de contabilidad está haciendo el login
            return '/catalogos/personal/listado';
            break;

            case 1:
            //el "1" indica que un gerente está haciendo el login
            return '/catalogos/tiposocio/listado';
            break;


            default:
            //no es ninguno de los casos anteriores
            return '/home';
            break;
        }        
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        //dd('Login malo');
        //$errors = [$this->username() => trans('auth.failed')];

        $errors = [$this->username() => ('Login incorrecto')];

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


}
