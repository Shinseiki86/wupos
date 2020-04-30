<header>
    <nav class="navbar {{ config('app.debug') ? 'navbar-custom2' : 'navbar-custom1'}} navbar-fixed-top" role="navigation" style="margin-bottom: 0">

        <div class="col-xs-1" style="margin-right: 10px;">
            <div class="row">
                <a class="navbar-brand" href="{{ url ('') }}" >{{ config('app.name', 'APP_NAME') }}</a>
            </div>
            <!--menu toggle button -->
            <button id="menu-toggle" type="button" data-toggle="button" class="menu-toggler sidebar-toggler btn btn-link" style="margin-left: 0px;color: #333;">
                <i class="fas fa-toggle-off fa-fw"></i>
            </button>
        </div>

        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Menú</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <ul class="nav navbar-top-links navbar-right">

                @if(isset($menusTop))
                @foreach ($menusTop as $key => $item)
                    {{-- @if(Entrust::can(['usuarios-*', 'roles-*', 'permisos-*'])) --}}
                        @if ($item['MENU_PARENT'] != 0)
                            @break
                        @endif

                        @include('layouts.menu.menu-top-list', ['item' => $item])
                    {{-- @endif --}}
                @endforeach
                @endif

                <!-- /.dropdown -->
                @if( null !== Auth::user() )

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user fa-fw"></i> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ url('app/parameters') }}"><i class="fas fa-user fa-fw" aria-hidden="true"></i> Parametrizar {{ Auth::user()->username }}</a></li>
                        <li><a href="{{ url('password/reset') }}"><i class="fas fa-key fa-fw" aria-hidden="true"></i> Cambiar contraseña</a></li>
                        <li><a href="{{ url('/help') }}"><i class="fa fa-life-ring fa-fw" aria-hidden="true"></i> Ayuda</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                            </a>
                            {{ Form::open(['route'=>'logout', 'id'=>'logout-form', 'style'=>'display: none']) }}
                            {{ Form::close() }}
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                @endif
            </ul>
            
        </div>
    </nav> <!-- /.navbar-header -->
</header>