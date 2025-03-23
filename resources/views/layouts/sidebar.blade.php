<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <!-- end Dashboard Menu -->
                <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMovimientos" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMovimientos">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Movimientos</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMovimientos">
                        <ul class="nav nav-sm flex-column">
                            {{-- Menú de Movimientos: Accesible para Super Admin y Admin --}}
                            @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('movements.index') }}" class="nav-link" data-key="t-control-movimientos">Control Movimientos</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCuentas" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCuentas">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">Gestionar Cuentas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCuentas">
                        <ul class="nav nav-sm flex-column">
                            {{-- Menú de Cuentas: Accesible para Super Admin y Admin --}}
                            @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('accounts.index') }}" class="nav-link" data-key="t-clientes">Cuentas</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarClientes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarClientes">
                        <i class="ri-pages-line"></i> <span data-key="t-pages">Gestionar Clientes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarClientes">
                        <ul class="nav nav-sm flex-column">
                            {{-- Menú de Clientes: Accesible para Super Admin y Admin --}}
                            @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('clients.index') }}" class="nav-link" data-key="t-clientes">Clientes</a>
                                </li>
                            @endif
                            
                            <li class="nav-item">
                                <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProfile" data-key="t-profile"> Estado clientes
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProfile">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="pages-profile.html" class="nav-link" data-key="t-simple-page">
                                                Ver estados </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings.html" class="nav-link" data-key="t-settings"> Actualizar </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Components</span></li>

               

                {{-- menu empresa --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEmpresa" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmpresa">
                        <i class="ri-building-line"></i> <span data-key="t-empresa">Empresa</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEmpresa">
                        {{-- menu index de companies solo podra ser gestiodao por el super admin --}}                       
                        @if(auth()->user()->hasRole('Super Admin'))
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('companies.index') }}" class="nav-link" data-key="t-servicios">Registrar Empresa</a>
                                </li>
                            </ul>
                        @endif
                        {{-- menu companies --}}

                        {{-- vista companies SOLO VER MI EMPRESA Y MODIFICAR DATOS DE MI EMPRESA --}}                       
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('companies.show', auth()->user()->company_id) }}" class="nav-link" data-key="t-servicios">Empresa</a>
                            </li>
                        </ul>
                        {{-- vista companies --}}
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('services.index') }}" class="nav-link" data-key="t-servicios">Servicios</a>
                            </li>
                        </ul>

                    </div>
                </li>
                {{-- menu empresa --}}

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Administración</span></li>

                {{-- menu administracion --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdmin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmpresa">
                        <i class="ri-building-line"></i> <span data-key="t-admin">Administración de usuarios</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdmin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link" data-key="t-servicios">Usuarios</a>
                            </li>
                        </ul>
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link" data-key="t-servicios">Roles</a>
                            </li>
                        </ul>
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link" data-key="t-servicios">Permisos</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- menu  administracion --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>