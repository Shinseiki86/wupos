<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;
use App\Models\Permission;

class Menu extends ModelWithSoftDeletes
{
	
	//Nombre de la tabla en la base de datos  
	protected $table = 'MENUS';
	protected $primaryKey = 'MENU_ID';
	// protected $filterKey = 'MENU_NOMBRE';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'MENU_FECHACREADO';
	const UPDATED_AT = 'MENU_FECHAMODIFICADO';
	const DELETED_AT = 'MENU_FECHAELIMINADO';
	protected $dates = ['MENU_FECHACREADO','MENU_FECHAMODIFICADO','MENU_FECHAELIMINADO'];

	public $fillable = [
		'MENU_LABEL',
		'MENU_URL',
		'MENU_ICON',
		'MENU_PARENT',
		'MENU_ORDER',
		'MENU_POSITION',
		'MENU_ENABLED',
		'PERM_ID',
	];

	public static function rules(){
		$rules = [
			'MENU_LABEL'  => ['required', 'max:30', ],//'unique:MENUS,MENU_LABEL,'.$this->getKey().',MENU_ID'],
			'MENU_URL'    => ['max:300', ],//'unique:MENUS,MENU_URL,'.$this->getKey().',MENU_ID'],
			'MENU_ICON'   => ['string', 'max:300'],
		];
		return $rules;
	}

	public function getChildren($data, $line)
	{
		$children = [];
		foreach ($data as $line1) {
			if ($line['MENU_ID'] == $line1['MENU_PARENT']) {
				$children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
			}
		}
		return $children;
	}

	public function optionsMenu($showAll=false, $position='LEFT')
	{
		$arrMenu = $showAll ? $this : $this->where('MENU_ENABLED', true);
		$arrMenu = $arrMenu->with('permission')->where('MENU_POSITION', $position)
			->orderby('MENU_PARENT')
			->orderby('MENU_ORDER')
			->orderby('MENU_LABEL')
			->get()->toArray();

		if(!$showAll){
			$arrMenu = array_filter($arrMenu, function($menu) {
				if(isset($menu['permission'])){
					return \Entrust::can($menu['permission']['name']);
				}
				return true;
			});
		}
		return $arrMenu;
	}

	public static function menus($showAll=false, $position='LEFT')
	{
		$menus = new Menu();
		$data = $menus->optionsMenu($showAll, $position);
		$menuAll = [];
		foreach ($data as $line) {
			$item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];

			if(!(count($item[0]['submenu'])==0 and $item[0]['MENU_PARENT']==0 and $item[0]['MENU_URL']==null) or $showAll){
				$menuAll = array_merge($menuAll, $item);
			}
		}
		return $menus->menuAll = $menuAll;
	}

	public function permission()
	{
		$foreingKey = 'PERM_ID';
		return $this->belongsTo(Permission::class, $foreingKey);
	}

}
