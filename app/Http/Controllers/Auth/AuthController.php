<?php

namespace Wupos\Http\Controllers\Auth;

use Wupos\User;
use Wupos\Rol;
use Validator;
use Wupos\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';
	
	/**
	 * 
	 *
	 * @var string
	 */
	protected $username = 'username';

	/**

	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(Redirector $redirect=null)
	{

		//Lista de acciones que no requieren autenticación
		$arrActionsLogin = [
			'logout',
			'login',
			'getLogout',
			'showLoginForm',
		];

		//Lista de acciones que solo puede realizar los administradores
		$arrActionsAdmin = [
			'index',
			'edit',
			'show',
			'update',
			'destroy',
			'register',
			'showRegistrationForm',
			'getRegister',
			'postRegister',
		];


		//Requiere que el usuario inicie sesión, excepto en la vista logout.
		$this->middleware('auth', [ 'except' => $arrActionsLogin ]);

		if( auth()->check() ){ //Compatibilidad con el comando "php artisan route:list", ya que ingresa como guest y la ruta es nula.
			$action = explode("@", Route::currentRouteAction())[1];
			
			//Si el usuario ya está autenticado e ingresa a login, redirige al home.
			if( $action == 'showLoginForm' )
				return redirect()->route('home')->send();

			if( isset($redirect) ){
				$ROLE_id = auth()->check() ? auth()->user()->ROLE_id : 0;

				if( in_array($action, $arrActionsAdmin) )//Si la acción del controlador se encuentra en la lista de acciones de admin...
				{
					if( ! in_array($ROLE_id , [\Wupos\Rol::ADMIN]) )//Si el rol no es admin, se niega el acceso.
					{
						abort(403, 'Usuario no tiene permisos!.');
					}
				}
			}
		}
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data, $USER_id = null)
	{

	$rules = $USER_id !== null ? [
			//'num_documento' => 'required|numeric|unique:USERS,num_documento,'.$USER_id.',USER_id',
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:USERS,email,'.$USER_id.',USER_id',
			'ROLE_id' => 'required',
		] : [
			//'num_documento' => 'required|numeric|unique:USERS',
			'name' => 'required|max:255',
			'username' => 'required|max:20|unique:USERS',
			'email' => 'required|email|max:255|unique:USERS',
			'password' => 'required|min:6|confirmed',
			'ROLE_id' => 'required',
		];

		return Validator::make($data, $rules);
	}


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

		//Se crea una colección con los posibles roles.
		$roles = Rol::orderBy('ROLE_id')
						->select('ROLE_id', 'ROLE_descripcion')
						->get();

        return view('auth.register', compact('roles'));
    }

	/**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		$validator = $this->validator($request->all());

		if( $validator->fails() ) {
			return redirect()->back()
						->withErrors($validator)
						->withInput()->send();
		}

        //Auth::guard($this->getGuard())->login($this->create($request->all()));
        $user = $this->create($request->all());

		flash_alert('Usuario '.$user->username.' creado exitosamente!' , 'success' );
        return redirect('usuarios');
    }

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'username' => strtolower($data['username']),
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'ROLE_id' => $data['ROLE_id'],
			'USER_creadopor' => auth()->user()->username,
		]);
	}


	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$usuarios = User::orderBy('USER_id')->get();

		//Se carga la vista y se pasan los registros
		return view('auth/index', compact('usuarios'));
	}

	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $USER_id
	 * @return Response
	 */
	public function show($USER_id)
	{
		// Se obtiene el registro
		$usuario = User::findOrFail($USER_id);

		// Muestra la vista y pasa el registro
		return view('auth/show', compact('usuario'));
	}

	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $USER_id
	 * @return Response
	 */
	public function edit($USER_id)
	{
		// Se obtiene el registro
		$usuario = User::findOrFail($USER_id);

		//Se crea una colección con los posibles roles.
		$roles = Rol::orderBy('ROLE_id')
						->select('ROLE_id', 'ROLE_descripcion')
						->get();

		// Muestra el formulario de edición y pasa el registro a editar
		return view('auth/edit', compact('usuario', 'roles'));
	}

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $USER_id
     * @return Response
     */
    public function update($USER_id)
    {
        //Validación de datos
        $this->validate(request(), [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255',
			'ROLE_id' => 'required',
        ]);

        // Se obtiene el registro
        $usuario = User::findOrFail($USER_id);

        $usuario->name = Input::get('name');
        $usuario->email = Input::get('email');
        $usuario->ROLE_id = Input::get('ROLE_id'); //Relación con Rol
        $usuario->USER_modificadopor = auth()->user()->username;
        //Se guarda modelo
        $usuario->save();

        // redirecciona al index de controlador
        flash_alert( 'Usuario '.$usuario->username.' modificado exitosamente!', 'success' );
        return redirect('usuarios');
    }

    /**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $USER_id
	 * @return Response
	 */
	public function destroy($USER_id)
	{
		$usuario = User::findOrFail($USER_id);

		//Si el usuario fue creado por SYSTEM, no se puede borrar.
		if($usuario->USER_creadopor == 'SYSTEM'){
			flash_modal( '¡Usuario '.$usuario->username.' no se puede borrar!', 'danger' );
	    } else {
			$usuario->USER_eliminadopor = auth()->user()->username;
			$usuario->save();
			$usuario->delete();
			
			flash_alert( '¡Usuario '.$usuario->username.' borrado!', 'success' );
		}

	    return redirect('usuarios');
	}
}
