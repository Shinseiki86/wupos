<li class="dropdown">
	<a class="dropdown-toggle" data-toggle="{{$item['submenu']!=[]?'dropdown':''}}" href="{{ isset($item['MENU_URL']) ? url($item['MENU_URL']) : '#' }}" target="{{ starts_with($item['MENU_URL'], 'http') ? '_blank' : '' }}">
		<i class="{{ $item['MENU_ICON'] }} fa-fw"></i>
		<span class="hidden-xs">{{ $item['MENU_LABEL'] }}</span>
		@if ($item['submenu'] != []) <i class="fas fa-caret-down"></i>@endif
	</a>


	@if ($item['submenu'] != [])
		<ul class="dropdown-menu">
			{{-- <li class="divider"></li> --}}
			@foreach ($item['submenu'] as $submenu)
				@if ($submenu['submenu'] == [])
					<li class="kopie">
						<a href="{{ isset($submenu['MENU_URL']) ? url($submenu['MENU_URL']) : '#' }}" target="{{ starts_with($submenu['MENU_URL'], 'http') ? '_blank' : '' }}">
							<i class="{{ $submenu['MENU_ICON'] }} fa-fw"></i> 
							{{ $submenu['MENU_LABEL'] }}
						</a>
					</li>
				@else
					@include('layouts.menu.menu-top-list', [ 'item' => $submenu ])
				@endif
			@endforeach
		</ul>
	@endif

</li>



