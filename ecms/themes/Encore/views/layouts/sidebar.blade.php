<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    {{-- <body data-layout="horizontal" data-sidebar="dark"> --}}
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('/') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ Theme::url('/images/logo-sm.svg') }}" alt="{{setting('core::site-name')}}" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ Theme::url('/images/logo-sm.svg') }}" alt="{{setting('core::site-name')}}"
                     height="22"> <span class="logo-txt">{{setting('core::site-name')}}</span>
            </span>
        </a>

        <a href="{{ url('/') }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ Theme::url('/images/logo-sm.svg') }}" alt="{{setting('core::site-name')}}"
                     height="22"> <span class="logo-txt">{{setting('core::site-name')}}</span>
            </span>
            <span class="logo-sm">
                <img src="{{ Theme::url('/images/logo-sm.svg') }}" alt="{{setting('core::site-name')}}" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ url('/') }}">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">{{ trans('dashboard::dashboard.name') }}</span>
                    </a>
                </li>
                @if($currentUser->hasAccess('sass.companies.index'))

                <li class="menu-title" data-key="t-applications">Empresas</li>

                    @if($currentUser->hasAccess('sass.companies.index'))
                        <li><a href="{{route('sass.company.index')}}">
                                <i class="mdi mdi-account-group icon nav-icon"></i>
                                <span class="menu-item" data-key="t-business">Empresas</span>
                            </a>
                        </li>
                    @endif
                @endif
                @if($currentUser->hasAccess('maintenance.events.index'))

                    <li class="menu-title" data-key="t-applications">Eventos</li>

                    @if($currentUser->hasAccess('maintenance.events.index'))
                        <li><a href="{{route('maintenance.event.index')}}">
                                <i class="mdi mdi-account-group icon nav-icon"></i>
                                <span class="menu-item" data-key="t-business">Eventos</span>
                            </a>
                        </li>
                    @endif
                @endif
                <li class="menu-title" data-key="t-applications">Transporte</li>
                @if($currentUser->hasAccess('transport.vehicles.index'))
                <li>
                    <a href="{{route('transport.vehicles.index')}}">
                        <i class="bx bx-car icon nav-icon"></i>
                        <span class="menu-item" data-key="t-chat">Vehiculos</span>
                    </a>
                </li>
                @endif
                @if($currentUser->hasAccess('transport.drivers.index'))
                <li>
                    <a href="{{route('transport.driver.index')}}">
                        <i class="bx bxs-bus icon nav-icon"></i>
                        <span class="menu-item" data-key="t-chat">Conductor</span>
                    </a>
                </li>
                @endif
                @if($currentUser->hasAccess('transport.drivers.index')|| $currentUser->hasAccess('user.roles.index'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="bx bxs-user-detail icon nav-icon"></i>
                            <span class="menu-item" data-key="t-ecommerce">Importar</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if($currentUser->hasAccess('user.roles.index'))
                                <li><a href="{{route('transport.driver.import')}}" data-key="t-user">Conductores y Vehículos</a></li>
                            @endif
                            <!--                        <li><a href="ecommerce-orders" data-key="t-orders">Api KEYS</a></li>-->
                        </ul>
                    </li>
                @endif
<!--                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-authentication">Reporte por Placa</span>
                    </a>
                </li>
                <li>
                    <a href="layouts-vertical">
                        <i class="bx bx-layout icon nav-icon"></i>
                        <span class="menu-item" data-key="t-vertical">Reporte de Pasajeros</span>
                    </a>
                </li>
                <li>
                    <a href="layouts-vertical">
                        <i class="bx bx-layout icon nav-icon"></i>
                        <span class="menu-item" data-key="t-vertical">Reporte de Rutas</span>
                    </a>
                </li>-->
                @if($currentUser->hasAccess('user.users.index')|| $currentUser->hasAccess('user.roles.index'))
                    <li class="menu-title" data-key="t-applications">Usuarios y Roles</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="bx bxs-user-detail icon nav-icon"></i>
                            <span class="menu-item" data-key="t-ecommerce">Usuarios</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if($currentUser->hasAccess('user.users.index'))
                                <li><a href="{{route('user.user.index')}}" data-key="t-user">Usuarios</a></li>
                            @endif
                            @if($currentUser->hasAccess('user.roles.index'))
                                <li><a href="{{route('user.role.index')}}" data-key="t-user">Roles</a></li>
                            @endif
                            <!--                        <li><a href="ecommerce-orders" data-key="t-orders">Api KEYS</a></li>-->
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
