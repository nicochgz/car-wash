<?php

namespace App\Http\Controllers\Auth;


use App\Model\Usuario;
use App\Model\Socio;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Model\Rol;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'idrol' => 'required|int',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Usuario::create([            
            'email' => $data['email'],
            'idrol' => $data['idrol'],
            //encripto el password
            'password' => bcrypt($data['password']),
        ]);
    }




    
    function formulario_registro(){
        
        
        return view('auth.register');
    }


    public function register(Request $request)
    {
        if($request->exists('essocio')){
            //voy a dar de alta un socio
            //entonces fijo el idrol
            $request->request->add(['idrol'=>4]);

            //dd('Vamos a dar de alta un socio');
        }

        $this->validator($request->all())->validate();

        //usuario
        event(new Registered($user = $this->create($request->all())));
        if($request->exists('essocio')){
            $context=$request->all();
            //entonces voy a dar de alta al socio
            $socio=new Socio();
            $socio->nombre=$context['nombre'];
            $socio->idtiposocio=1;
            //aqui asigno al socio nuevo el id de usuario recien creado
            $socio->idusuario=$user->idusuario;
            $socio->save();
            $this->guard()->login($user);
            $this->redirectTo='/socio/bienvenido';
        }

        //hace un login automatico del usuario
        


        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }






}
