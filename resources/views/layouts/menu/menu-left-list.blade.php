

@if ($item['submenu'] != [])
    <ul class="nav nav-{{number_to_ordinal($nivel)}}-level">
        @foreach ($item['submenu'] as $submenu)
                <li class="{{ $submenu['submenu'] != [] ? 'nav-header-level' : 'nav-body-level'}}">
                    <a href="{{ isset($submenu['MENU_URL']) ? url($submenu['MENU_URL']) : '#' }}" target="{{ starts_with($submenu['MENU_URL'], 'http') ? '_blank' : '' }}" class="dropdown-collapse">
                        <i class="{{ $submenu['MENU_ICON'] }} fa-fw"></i> <span class="{{ $submenu['submenu'] != [] ? 'side-menu-title' : '' }}" style="{{ $submenu['submenu'] != [] ? 'display: inline !important;padding-left: 5px;' : '' }}">{{ $submenu['MENU_LABEL'] }}</span>
                        @if ($submenu['submenu'] != [])
                            <span class="fa arrow"></span>
                        @endif
                    </a>

                    @if ($submenu['submenu'] != [])
                        @include('layouts.menu.menu-left-list', [ 'item'=>$submenu , 'nivel'=>$nivel+1])
                    @endif

                </li>
        @endforeach
    </ul>
@endif


{{-- 
<li class="nav nav-first-level">
    <a href="{{ isset($item['MENU_URL']) ? url($item['MENU_URL']) : '#' }}" target="{{ starts_with($item['MENU_URL'], 'http') ? '_blank' : '' }}" class="dropdown-collapse">
        <i class="{{ $item['MENU_ICON'] }} fa-fw"></i> 
        <span class="side-menu-title">{{ $item['MENU_LABEL'] }}</span><span class="fa arrow"></span>
    </a>
    @if ($item['submenu'] != [])
        <ul class="nav nav-second-level">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li>
                        <a href="{{ isset($submenu['MENU_URL']) ? url($submenu['MENU_URL']) : '#' }}" target="{{ starts_with($submenu['MENU_URL'], 'http') ? '_blank' : '' }}">
                            <i class="{{ $submenu['MENU_ICON'] }} fa-fw"></i> 
                            {{ $submenu['MENU_LABEL'] }}
                        </a>
                    </li>
                @else
                    @include('layouts.menu.menu-left-list', [ 'item'=>$submenu , 'nivel'=>$nivel+1])
                @endif
            @endforeach
        </ul>
    @endif
</li>
 --}}