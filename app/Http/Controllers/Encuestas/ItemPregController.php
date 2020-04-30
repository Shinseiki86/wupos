<?php
namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;

use App\Models\ItemPreg;

class ItemPregController extends Controller
{
	protected $route = 'encuestas';
	protected $class = ItemPreg::class;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:encuesta-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:encuesta-edit',   ['only' => ['edit', 'update', 'destroy']]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
     * @param  App\Pregunta  $pregunta
     * @param  string  $newValue
     * @return void
	 */
	public function store($pregunta, $newValue)
	{
		$newItemPreg = ItemPreg::make([
			'ITPR_POSICION' => $newValue['pos'],
			'ITPR_TEXTO'    => $newValue['value']
		]);
		//Se guarda la opción en la pregunta (asociación)
		$pregunta->itemPregs()->save($newItemPreg);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($idPregOld, $newValue)
	{
		$oldItemPreg = ItemPreg::find($idPregOld);
		$oldItemPreg->update([
			'ITPR_POSICION' => $newValue['pos'],
			'ITPR_TEXTO'    => $newValue['value'],
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyArray($itemPregs, array $iditemPregs)
	{
		foreach ($itemPregs as $itemPreg) {
			//Si el id actual no se encuentra en los id's del input, se borra.
			if(!in_array($itemPreg->ITPR_ID, $iditemPregs)){
					$itemPreg->delete();
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($ITPR_ID, $showMsg=True)
	{
		isset($ITPR_ID->ITPR_ID) ? $itemPreg = $ITPR_ID : $itemPreg = ItemPreg::findOrFail($ITPR_ID);
		
		// delete
		$itemPreg->ITPR_eliminadopor = auth()->user()->username;
		$itemPreg->save();
		$itemPreg->delete();
	}
}
