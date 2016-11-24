<?php

namespace Wupos\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use Wupos\Regional;

class RegionalController extends Controller
{
    public function __construct(Redirector $redirect=null)
    {
        //Requiere que el usuario inicie sesión.
        $this->middleware('auth');
        if(isset($redirect)){

            $action = Route::currentRouteAction();
            $role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

            //Lista de acciones que solo puede realizar los administradores o los editores
            $arrActionsAdmin = array('index', 'create', 'edit', 'store', 'show', 'destroy');

            if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
            {
                if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
                {
                    Session::flash('error', '¡Usuario no tiene permisos!');
                    abort(403, '¡Usuario no tiene permisos!.');
                }
            }
        }
    }

    /**
     * Muestra una lista de los registros.
     *
     * @return Response
     */
    public function index()
    {
        //Se obtienen todos los registros.
        $regionales = Regional::orderBy('REGI_id')->get();
        //Se carga la vista y se pasan los registros
        return view('regionales/index', compact('regionales'));
    }

    /**
     * Muestra el formulario para crear un nuevo registro.
     *
     * @return Response
     */
    public function create()
    {
        return view('regionales/create');
    }

    /**
     * Guarda el registro nuevo en la base de datos.
     *
     * @return Response
     */
    public function store()
    {
        //Validación de datos
        $this->validate(request(), [
            'REGI_codigo' => ['required', 'numeric'],
            'REGI_nombre' => ['required', 'max:300'],
        ]);

        //Permite seleccionar los datos que se desean guardar.
        $regional = new Regional;
        $regional->REGI_codigo = Input::get('REGI_codigo');
        $regional->REGI_nombre = Input::get('REGI_nombre');
        $regional->REGI_creadopor = auth()->user()->username;
        //Se guarda modelo
        $regional->save();

        // redirecciona al index de controlador
        Session::flash('message', 'Regional '.$regional->REGI_id.' creada exitosamente!');
        return redirect()->to('regionales');
    }


    /**
     * Muestra información de un registro.
     *
     * @param  int  $REGI_id
     * @return Response
     */
    public function show($REGI_id)
    {
        // Se obtiene el registro
        $regional = Regional::findOrFail($REGI_id);

        // Muestra la vista y pasa el registro
        return view('regionales/show', compact('regional'));
    }


    /**
     * Muestra el formulario para editar un registro en particular.
     *
     * @param  int  $REGI_id
     * @return Response
     */
    public function edit($REGI_id)
    {
        // Se obtiene el registro
        $regional = Regional::findOrFail($REGI_id);

        // Muestra el formulario de edición y pasa el registro a editar
        return view('regionales/edit', compact('regional'));
    }


    /**
     * Actualiza un registro en la base de datos.
     *
     * @param  int  $REGI_id
     * @return Response
     */
    public function update($REGI_id)
    {
        //Validación de datos
        $this->validate(request(), [
            'REGI_codigo' => ['required', 'numeric'],
            'REGI_nombre' => ['required', 'max:300'],
        ]);

        // Se obtiene el registro
        $regional = Regional::findOrFail($REGI_id);

        $regional->REGI_codigo = Input::get('REGI_codigo');
        $regional->REGI_nombre = Input::get('REGI_nombre');
        $regional->REGI_modificadopor = auth()->user()->username;
        //Se guarda modelo
        $regional->save();

        // redirecciona al index de controlador
        Session::flash('message', 'Regional '.$regional->REGI_id.' modificada exitosamente!');
        return redirect()->to('regionales');
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param  int  $REGI_id
     * @return Response
     */
    public function destroy($REGI_id, $showMsg=True)
    {
        $regional = Regional::findOrFail($REGI_id);

        try {
            // delete
            $regional->REGI_eliminadopor = auth()->user()->username;
            $regional->save();
            $regional->delete();
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                abort(400, '¡Error 23000 (sql code): Integrity constraint violation!.');
            }
        }

        // redirecciona al index de controlador
        if($showMsg){
            Session::flash('message', 'Regional '.$regional->REGI_id.' eliminada exitosamente!');
            return redirect()->to('regionales');
        }
    }
}

