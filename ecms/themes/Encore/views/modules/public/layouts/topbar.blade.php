<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{url('/')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22"> <span class="logo-txt">@lang('translation.Symox')</span>
                    </span>
                </a>

                <a href="{{url('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ Theme::url('images/logo-sm.svg') }}" alt="" height="22"> <span class="logo-txt">Eje Satelital</span>
                    </span>
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Search -->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Buscar...">
                    <span class="bx bx-search"></span>
                </div>
            </form>

        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none">
                <button type="button" class="btn header-item"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-feather="search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Buscar...">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block language-switch">
                <button type="button" class="btn header-item" disabled
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <strong>{{$currentUser->driver->company->name}}</strong>
                </button>
            </div>


            @include('partials.top-nav')

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item light-dark" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-sm layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-sm layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{$currentUser->present()->gravatar()}}"
                         alt="{{$currentUser->present()->fullName()}}">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst($currentUser->present()->fullName())}}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="{{route('account.profile.view')}}"><i class='bx bx-user-circle text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Mi cuenta </span></a>
                    {{-- <a class="dropdown-item" href="{{url('#')}}"><i class='bx bx-buoy text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Soporte</span></a> --}}
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item d-flex align-items-center" href="#"><i class='bx bx-cog text-muted font-size-18 align-middle me-1'></i> <span class="align-middle me-3">Configuración</span></a> --}}
                    <a class="dropdown-item" href="{{route('account.profile.view')}}#notification"><i class='bx bx-lock text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Notificaciones</span></a>
                    <a class="dropdown-item"  href="{{ route('logout') }}"><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span key="t-logout">{{ trans('core::core.general.sign out') }}</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
<header id="page-topbar" class="ishorizontal-topbar"></header>
