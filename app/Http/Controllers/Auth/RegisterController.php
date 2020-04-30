<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';


    protected $route = 'auth.usuarios';
    protected $class = User::class;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-index',  ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['showRegistrationForm','register']]);
        $this->middleware('permission:user-edit',   ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

 
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, User::rules());
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        //Se crea un array con los Role disponibles
        $arrRoles = model_to_array(Role::class, 'display_name');

        // Muestra el formulario de creación y los array para los 'select'
        return view('auth.register', compact('arrRoles'));
    }



    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        parent::storeModel();
    }



    /**
     * Muestra una lista de los registros.
     *
     * @return Response
     */
    public function index()
    {
        //Se obtienen todos los registros.
        $usuarios = User::with('roles')->get();
        //Se carga la vista y se pasan los registros
        return view('auth/index', compact('usuarios'));
    }


    /**
     * Muestra el formulario para editar un registro en particular.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Se obtiene el registro
        $usuario = User::findOrFail($id);

        //Se crea un array con los Role disponibles
        $arrRoles = model_to_array(Role::class, 'display_name');
        $roles_IDs = $usuario->roles->pluck('id')->toJson();

        // Muestra el formulario de edición y pasa el registro a editar
        return view('auth/edit', compact('usuario','arrRoles','roles_IDs'));
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  User|int  $usuario
     * @return Response
     */
    public function update($usuario)
    {
        parent::updateModel($usuario);
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  User|int  $usuario
     * @return Response
     */
    public function destroy($usuario)
    {
        parent::destroyModel($usuario);
    }

}
