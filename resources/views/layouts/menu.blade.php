{{-- <li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('home') }}"><i class=" fas fa-building"></i><span>Inicio</span></a>
</li>
@can('ver-persona')
    <li class="side-menus {{ Request::is('persona') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('persona') }}"><i class=" fas fa-users"></i><span>Personas</span></a>
    </li>
@endcan

@can('ver-socio')
<li class="side-menus {{ Request::is('socio') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('socio') }}"><i class="fas fa-user-tie"></i><span>Socio</span></a>
</li>
@endcan


@can('ver-cargo')
<li class="side-menus {{ Request::is('cargo') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('cargo') }}"><i class="fas fa-id-card-alt"></i><span>Responsabilidad - Cargo</span></a>
</li>
@endcan

@can('ver-usuario')
<li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('usuarios') }}"><i class="fas fa-user-shield"></i><span>Usuarios</span></a>
</li>
@endcan

@can('ver-rol')
<li class="side-menus {{ Request::is('roles') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('roles') }}"><i class=" fas fa-lock"></i><span>Roles</span></a>
</li>
@endcan

<li class="side-menus {{ Request::is('blogs') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('blogs') }}"><i class=" fas fa-blog"></i><span>Blog</span></a>
</li>

<li class="side-menus {{ Request::is('blogs') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('blogs') }}"><i class="fas fa-cash-register"></i><span>Cobranza</span></a>
</li>
@endcan --}}




<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('home') }}"><i class=" fas fa-building"></i><span>Inicio</span></a>
</li>


<li class="side-menus">
    <a class="nav-link" href="#persona" onclick="toggleCollapse(event, 'persona')">
        <i class="fas fa-user-tie"></i> 
        <span class="mt-0">
            <span class="d-flex justify-content-between align-items-center">
                Persona
            <i class="fas fa-sort-down"></i>
            </span>
        </span>
    </a>
    <div class="collapse" id="persona" aria-expanded="false">
        <ul class="mini-menu flex-column pl-2 nav">
        @can('ver-persona')
            <li class="side-menus {{ Request::is('persona') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('persona') }}"><i class="fas fa-users"></i><span>Personas</span></a>
            </li>
        @endcan
        @can('ver-socio')
            <li class="side-menus {{ Request::is('socio') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('socio') }}"><i class="fas fa-user-tie"></i><span>Socio</span></a>
            </li>
        @endcan
        </ul>
    </div>
</li>


<li class="side-menus">
    <a class="nav-link" href="#usuario" onclick="toggleCollapse(event, 'usuario')">
        <i class="fas fa-user-shield"></i> 
        <span class="mt-0">
            <span class="d-flex justify-content-between align-items-center">
            Usuario
            <i class="fas fa-sort-down"></i>
            </span>
        </span>
    </a>
    <div class="collapse" id="usuario" aria-expanded="false">
        <ul class="mini-menu flex-column pl-2 nav">
        @can('ver-usuario')
        <li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('usuarios') }}"><i class="fas fa-user-shield"></i><span>Usuarios</span></a>
        </li>
        @endcan
        @can('ver-rol')
        <li class="side-menus {{ Request::is('roles') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('roles') }}"><i class=" fas fa-lock"></i><span>Roles</span></a>
        </li>
        @endcan
        @can('ver-cargo')
        <li class="side-menus {{ Request::is('cargo') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('cargo') }}"><i class="fas fa-id-card-alt"></i><span>Cargo</span></a>
        </li>
        @endcan
        </ul>
    </div>
</li>


{{-- <li class="side-menus">
    <a class="nav-link" href="#cobranza" onclick="toggleCollapse(event, 'cobranza')">
        <i class="fas fa-money-check-alt"></i>
        <span class="mt-0">
            <span class="d-flex justify-content-between align-items-center">
                Pago<i class="fas fa-sort-down"></i>
            </span>
        </span>
    </a>
    <div class="collapse" id="cobranza" aria-expanded="false">
        <ul class="mini-menu flex-column pl-2 nav">
            @can('ver-cargo')
            <li class="side-menus {{ Request::is('cobranza') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('cobranza') }}"><i class="fas fa-cash-register"></i><span>Cuenta Socio</span></a>
            </li>
            @endcan
            @can('registrar-pago')
            <li class="side-menus {{ Request::is('cobranza') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('cobranza') }}"><i class="fas fa-cash-register"></i><span>Registrar Pago</span></a>
            </li>
            @endcan
        </ul>
    </div> --}}
{{-- </li> --}}

{{-- <li class="side-menus">
    <a class="nav-link" href="#cobranza" onclick="toggleCollapse(event, 'cobranza')">
        <i class="fas fa-users-cog"></i>
        <span class="mt-0">
            <span class="d-flex justify-content-between align-items-center">
            Financiera
            <i class="fas fa-sort-down"></i>
            </span>
        </span>
    </a>
    <div class="collapse" id="cobranza" aria-expanded="false">
        <ul class="mini-menu flex-column pl-2 nav">
        @can('ver-usuario')
        <li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('usuarios') }}"><i class="fas fa-calendar-plus"></i><span>Nuevo capitulo</span></a>
        </li>
        @endcan
        </ul>
    </div>
</li> --}}

<li class="side-menus {{ Request::is('pago') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('pago') }}"><i class="fas fa-hand-holding-usd"></i><span>Pago</span></a>
</li>

<li class="side-menus {{ Request::is('deuda') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('deuda') }}"><i class="fas fa-cash-register"></i><span>Deuda</span></a>
</li>

{{-- <li class="side-menus {{ Request::is('pago') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('pago') }}"><i class="fas fa-cash-register"></i><span>Nuevo Capitulo</span></a>
</li> --}}
<li class="side-menus {{ Request::is('gaia') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('gaia') }}"><i class="fas fa-calendar-plus"></i><span>Nuevo Capitulo</span></a>
</li>
{{-- <li class="side-menus">
    <a class="nav-link" href="#sistema" onclick="toggleCollapse(event, 'sistema')">
        <i class="fas fa-users-cog"></i>
        <span class="mt-0">
            <span class="d-flex justify-content-between align-items-center">
            Sistema
            <i class="fas fa-sort-down"></i>
            </span>
        </span>
    </a>
    <div class="collapse" id="sistema" aria-expanded="false">
        <ul class="mini-menu flex-column pl-2 nav">
        @can('ver-usuario')
        <li class="side-menus {{ Request::is('usuarios') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('usuarios') }}"><i class="fas fa-calendar-plus"></i><span>Nuevo capitulo</span></a>
        </li>
        @endcan
        </ul>
    </div>
</li> --}}

{{-- @can('ver-blog')
<li class="side-menus {{ Request::is('blogs') ? 'active' : '' }}">
    <a class="nav-link" href="{{ url('blogs') }}"><i class=" fas fa-blog"></i><span>Blog</span></a>
</li>
@endcan --}} 

