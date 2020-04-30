<nav role="navigation" style="margin-bottom: 0; margin-top: -1px;">
	<div class="navbar-default sidebar" role="navigation">

		<div class="sidebar-nav navbar-collapse" id="sidebar-area">
			<ul class="nav" id="sidebar">

				@rinclude('menu-left-search')

				@if(isset($menusLeft))
                @foreach ($menusLeft as $key => $item)

                    @if ($item['MENU_PARENT'] != 0)
                        @break
                    @endif

					<li class="nav nav-first-level">
					    <a href="{{ isset($item['MENU_URL']) ? url($item['MENU_URL']) : '#' }}" target="{{ starts_with($item['MENU_URL'], 'http') ? '_blank' : '' }}" class="dropdown-collapse">
					        <i class="{{ $item['MENU_ICON'] }} fa-fw"></i> <span class="side-menu-title">{{ $item['MENU_LABEL'] }}</span>
					        @if ($item['submenu'] != [])
					            <span class="fa arrow"></span>
					        @endif
					    </a>

		                @include('layouts.menu.menu-left-list', [ 'item'=>$item , 'nivel'=>2])

					</li>

                @endforeach
				@endif
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
</nav>
<!-- /.navbar-static-side -->
