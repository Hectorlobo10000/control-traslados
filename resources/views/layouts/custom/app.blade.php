<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <div id="app">
    {{-- Navbar --}}
    @auth    
      <nav class="navbar navbar-dark navbar-expand-md fixed-top flex-md-nowrap p-0 shadow">
        <div class="d-flex flex-row bd-highlight">
          <div class="pr-0 pl-2 pt-2 pb-2 bd-highlight d-md-block">
              <span class="navbar-toggler-icon icon" id="menu-toggle"></span>
          </div>
          <div class="pr-2 pl-0 pt-2 pb-2 bd-highlight">
            <a href="#" class="navbar-brand col-sm-3 col-md-2 mr-0">{{ config('app.name', 'Laravel') }}</a>
          </div>
        </div>
        <ul class="navbar-nav ml-auto mr-2 d-none d-sm-none d-md-block d-lg-block">
          {{-- @auth --}}
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  {{ __('Cerrar sesion') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          {{-- @endauth --}}
        </ul>
      </nav>

        <div class="container-fluid" id="wrapper">
          <div class="row">
            {{-- Sidebar --}}
            <nav class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2 bg-light sidebar" id="sidebar-wrapper">
              <div class="sidebar-sticky">
                <ul class="nav flex-colum">
                  @if (Auth::user()->id == 1)    
                    <li class="nav-item col-xl-12">
                      <a href="{{ route('users') }}" class="nav-link">
                        <i class="fa fa-users"></i> Usuarios
                      </a>
                    </li>
                  @endif
                  @if (Auth::user()->id == 1)    
                    <li class="nav-item col-xl-12">
                      <a href="{{ route('branch-offices') }}" class="nav-link">
                        <i class="fa fa-building"></i> Sucursales
                      </a>
                    </li>
                  @endif
                  {{-- <li class="nav-item col-xl-12">
                    <a href="{{ route('movements') }}" class="nav-link">
                      <i class="fa fa-exchange-alt"></i> Movimientos
                    </a>
                  </li> --}}
                  <li class="nav-item col-xl-12">
                    <a href="{{ route('transfers') }}" class="nav-link">
                      <i class="fa fa-truck-moving"></i> Traslados
                    </a>
                  </li>
                  <li class="nav-item col-xl-12">
                    <a href="{{ route('boxes') }}" class="nav-link">
                      <i class="fa fa-boxes"></i> Cajas
                    </a>
                  </li>
                  <li class="nav-item col-xl-12">
                    <a href="{{ route('products') }}" class="nav-link">
                      <i class="fa fa-shopping-cart"></i> Productos
                    </a>
                  </li>
                  <li class="nav-item col-xl-12">
                    <a href="{{ route('inventories') }}" class="nav-link">
                      <i class="fa fa-warehouse"></i> Inventario
                    </a>
                  </li>
                  @if (Auth::user()->id == 1)    
                    <li class="nav-item col-xl-12">
                      <a href="#" class="nav-link">
                        <i class="fa fa-file-alt"></i> Reportes
                      </a>
                    </li>
                  @endif
                  <li class="nav-item col-xl-12 d-block d-sm-block d-md-none d-lg-none">
                    <a href="#" class="nav-link" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                      <i class="fa fa-power-off"></i> Cerrar sesion
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
            {{-- sidebar --}}
    
            {{-- content --}}
            <div class="page-content-wrapper col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div class="container-fluid page-content"> 
                @yield('content')
              </div>
            </div>
            {{-- content --}}
    
          </div>
        </div>
      </div>
    
    @else  
      {{-- content login --}}
      <div class="page-content-wrapper">
        <div class="container-fluid page-content-login d-flex align-items-center"> 
          @yield('content-login')
        </div>
      </div>
      {{-- content login --}}
    @endauth

  <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

  @yield('modal')
  
</body>
</html>