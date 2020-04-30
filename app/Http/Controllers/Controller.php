<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorMessages;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $nameClass;

	public function __construct($requireAuth=true)
	{
		//Se crea arreglo en session con los items del menú disponibles
		if(auth()->check() && is_null(session()->get('menusLeft'))){
			\App\Http\Controllers\App\MenuController::refreshMenu();
		}

		if($requireAuth){
			$this->middleware('auth');
		}

		if(property_exists($this, 'class')){
			$this->nameClass =  strtolower(last(explode('\\',basename($this->class))));
			$this->middleware('permission:'.$this->nameClass.'-index',  ['only' => ['index', 'getData']]);
			$this->middleware('permission:'.$this->nameClass.'-create', ['only' => ['create', 'store']]);
			$this->middleware('permission:'.$this->nameClass.'-edit',   ['only' => ['edit', 'update']]);
			$this->middleware('permission:'.$this->nameClass.'-delete', ['only' => ['destroy']]);
		}
	}


	/**
	 * Obtiene datos para select2 con ajax.
	 *
	 * @param  Request $request
	 * @return json
	 */
	public function ajax(Request $request)
	{
		$model = $request->input('model');
		$column = $request->input('column');
		$filter = $request->input('q');

		$arrModel = array_filter( model_to_array($model, $column) , function($item) use ($filter){
				return preg_match('/'.$filter.'/i', $item);
			});
		return response()->json($arrModel);
	}


	/**
	 * {@inheritdoc}
	 */
	protected function formatValidationErrors(ValidatorMessages $validator)
	{
		return $validator->errors()->all();
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  Request $request
	 * @return void
	 */
	protected function validateRules($data, $id = 0)
	{
		return Validator::make($data, call_user_func($this->class.'::rules', $id));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @param  array  $relations
	 * @return Response
	 */
	protected function storeModel($redirect=true, $showAlert=true)
	{
		//Datos recibidos desde la vista.
		$data = $this->getRequest();
		
		//Se valida que los datos recibidos cumplan los requerimientos necesarios.
		$validator = $this->validateRules($data);

		if($validator->passes()){
			$class = get_model($this->class);

			//Se crea el registro.
			if(array_has($data, 'password')){ //Si el request contiene una contraseña, se debe cifrar.
				$data['password'] = bcrypt($data['password']);
			}
			$model = $class::create($data);
			$model = $this->postCreateOrUpdate($model);
			$model->save();

			//Se crean las relaciones
			$this->storeRelations($model, $data);

			$this->nameClassClass = str_upperspace(class_basename($model));

			if($showAlert){
				flash_alert( $this->nameClassClass.' '.$model->id.' creado exitosamente.', 'success' );
			}

			return $redirect ? redirect()->route($this->route.'.index')->send() : $model;

		} else {
			return redirect()->back()->withErrors($validator)->withInput()->send();
		}		
	}

	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $id
	 * @param  array  $relations
	 * @return Response
	 */
	protected function updateModel($id, $redirect=true, $showAlert=true)
	{
		//Datos recibidos desde la vista.
		$data = $this->getRequest();

		//Se valida que los datos recibidos cumplan los requerimientos necesarios.
		$validator = $this->validateRules($data, ($id instanceof \Illuminate\Database\Eloquent\Model) ? $id->getKey() : $id);

		if($validator->passes()){
			$class = get_model($this->class);

			// Se obtiene el registro

			$model = ($id instanceof \Illuminate\Database\Eloquent\Model)
						? $id
						: $class::findOrFail($id);
			//y se actualiza con los datos recibidos.
			$model->fill($data);
			$model = $this->postCreateOrUpdate($model);
			$model->save();

			//Se crean las relaciones
			$this->storeRelations($model, $data);

			$this->nameClassClass = str_upperspace(class_basename($model));

			if($showAlert){
				flash_alert( $this->nameClassClass.' '.$model->getKey().' modificado exitosamente.', 'success' );
			}

			return $redirect ? redirect()->route($this->route.'.index')->send() : $model;
		} else {
			return redirect()->back()->withErrors($validator)->withInput()->send();
		}
	}


	/**
	 * Funcion para sobrecarga y realizar funciones adicionales al crear o modificar el modelo.
	 * Ej: Procesar archivos.
	 *
	 * @param  Model $model
	 * @return Model $model
	 */
	protected function postCreateOrUpdate($model)
	{
		return $model;
	}


	/**
	 * Obtiene los datos recibidos por request, convierte a mayúsculas y elimina los input vacíos
	 *
	 * @return array
	 */
	protected function getRequest()
	{
		$exceptions = (isset($this->route) && in_array($this->route, [
			'app.menu',
			'auth.roles',
			'auth.permisos',
			'auth.usuarios',
		]));

		$data = request()->all();
		foreach ($data as $input => $value) {
			if($value=='' && !is_bool($value)){
				$data[$input] = null;
			}
			elseif (!(
					$value instanceof \Illuminate\Http\UploadedFile ||
					is_bool($value) ||
					in_array($input, $this->getFieldsNoUppercase())
				)) {
				$data[$input] = ($exceptions || ($input == '_token') || is_array($value))
					? $value
					: mb_strtoupper($value);
			}
		}
		
		return $data;
	}


	/**
	 * Obtiene los campos definidos en el modelo a los cuales no se debe modificar a mayúsculas.
	 *
	 * @return array
	 */
	private function getFieldsNoUppercase(){

		$fields = (isset($this->class) && class_exists($this->class) && method_exists($this->class,'getNoUppercase'))
			? $this->class::getNoUppercase()
			: [];
		return $fields;
	}


	/**
	 * Guarda las relaciones entre modelos.
	 *
	 * @param  Illuminate\Database\Eloquent\Model $model
	 * @param  array $relations
	 * @return void
	 */
	protected function storeRelations($model, $attributes)
	{
		foreach ($attributes as $key => $val) {
			if (isset($model) &&
				method_exists($model, $key) &&
				is_a(@$model->$key(), 'Illuminate\Database\Eloquent\Relations\Relation')
			) {
				$methodClass = get_class($model->$key($key));
				switch ($methodClass) {
					case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
						$model = $this->storeRelationBelongsToMany($model, $attributes, $key);
						break;
					case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
						$model = $this->storeRelationBelongsTo($model, $attributes, $key);
						break;
					case 'Illuminate\Database\Eloquent\Relations\HasMany':
						$model = $this->storeRelationHasMany($model, $attributes, $key);
						break;
					default:
						break;
				}
			}
		}

		return $model;
	}


	/**
	 * Guarda las relaciones BelongsToMany.
	 *
	 * @param  Illuminate\Database\Eloquent\Model $model
	 * @param  array $relations
	 * @return void
	 */
	private function storeRelationBelongsToMany($model, $attributes, $key)
	{
		$new_values = array_get($attributes, $key, []);
		if (array_search('', $new_values) !== false) {
			unset($new_values[array_search('', $new_values)]);
		}
		$model->$key()->sync(array_values($new_values));
		return $model;
	}

	/**
	 * Guarda las relaciones BelongsToMany.
	 *
	 * @param  Illuminate\Database\Eloquent\Model $model
	 * @param  array $relations
	 * @return void
	 */
	private function storeRelationBelongsTo($model, $attributes, $key)
	{
		$model_key = $model->$key()->getQualifiedForeignKey();
		$new_value = array_get($attributes, $key, null);
		$new_value = $new_value == '' ? null : $new_value;
		$model->$model_key = $new_value;
		return $model;
	}

	/**
	 * Guarda las relaciones HasMany.
	 *
	 * @param  Illuminate\Database\Eloquent\Model $model
	 * @param  array $relations
	 * @return void
	 */
	private function storeRelationHasMany($model, $attributes, $key)
	{
		$new_values = array_get($attributes, $key, []);
		if (array_search('', $new_values) !== false) {
			unset($new_values[array_search('', $new_values)]);
		}

		list($temp, $model_key) = explode('.', $model->$key($key)->getQualifiedForeignKeyName());

		foreach ($model->$key as $rel) {
			if (!in_array($rel->id, $new_values)) {
				$rel->$model_key = null;
				$rel->save();
			}
			unset($new_values[array_search($rel->id, $new_values)]);
		}

		if (count($new_values) > 0) {
			$related = get_class($model->$key()->getRelated());
			foreach ($new_values as $val) {
				$rel = $related::find($val);
				$rel->$model_key = $model->id;
				$rel->save();
			}
		}
		return $model;
	}



	/**
	 * Elimina un registro en la base de datos.
	 *
	 * @param  int  $id
	 * @param  string  $class
	 * @param  string  $redirect
	 * @return Response
	 */
	protected function destroyModel($id, $redirect=null)
	{
		// Se obtiene el registro
		$class = get_model($this->class);
		$model = $class::findOrFail($id);

		$prefix = strtoupper(substr($class::CREATED_AT, 0, 4));
		$created_by = $prefix.'_CREADOPOR';

		$nameClass = str_upperspace(class_basename($model));

		//Si el registro fue creado por SYSTEM, no se puede borrar.
		if($model->$created_by == 'SYSTEM'){
			flash_modal( $nameClass.' '.$id.' no se puede borrar (Creado por SYSTEM).', 'danger' );
		} else {

			$relations = $model->relationships('HasMany');

			if(!$this->validateRelations($nameClass, $relations)){
				$model->delete();
				flash_alert( $nameClass.' '.$id.' eliminado exitosamente.', 'success' );
			}
		}
		return redirect()->route(isset($redirect) ? $redirect : $this->route.'.index')->send();
	}

	protected function validateRelations($nameClass, $relations)
	{
		$hasRelations = false;
		$strRelations = [];

		foreach ($relations as $relation => $info) {
			if($info['count']>0){
				$strRelations[] = $info['count'].' '.$relation;
				$hasRelations = true;
			}
		}

		if(!empty($strRelations)){
			session()->flash('deleteWithRelations', compact('nameClass','strRelations'));
		}
		return $hasRelations;
	}

	protected function buttonShow($model)
	{
		if(\Entrust::can([$this->nameClass.'-edit'])){
			return $this->button($model, 'show', 'Ver', 'default', 'fas fa-eye');
		}
	}

	protected function buttonEdit($model)
	{
		if(\Entrust::can([$this->nameClass.'-edit'])){
			return $this->button($model, 'edit', 'Editar', 'info', 'fas fa-edit');
		}
		return '';
	}

	protected function button($model, $route, $title, $class, $icon)
	{
		if(!\Route::has($route)){
			$route = $this->route.'.'.$route;
		}

		return \Html::link(route($route, [ $model->getKeyName() => $model->getKey() ]), '<i class="'.$icon.' fa-fw" aria-hidden="true"></i>', [
			'class'=>'btn btn-xs btn-'.$class,
			'title'=>$title,
			'data-tooltip'=>'tooltip'
		],null,false);
	}

	protected function buttonDelete($model, $modelDescrip)
	{
		if(\Entrust::can([$this->nameClass.'-delete'])){
			return \Form::button('<i class="fas fa-trash-alt fa-fw" aria-hidden="true"></i>',[
				'class'=>'btn btn-xs btn-danger btn-delete',
				'data-toggle'=>'modal',
				'data-id'=> $model->getKey(),
				'data-modelo'=> str_upperspace(class_basename($model)),
				'data-descripcion'=> $model->$modelDescrip,
				'data-action'=> route( $this->route.'.destroy', [ $model->getKeyName() => $model->getKey() ]),
				'data-target'=>'#pregModalDelete',
				'data-tooltip'=>'tooltip',
				'title'=>'Borrar',
			]);
		}
		return '';
	}

}
