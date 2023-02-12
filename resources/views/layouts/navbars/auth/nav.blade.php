<style>
.nav-item {
  display: inline-block;
  position: relative;
  color: #fff;
}

.active {
    border-bottom: 2px solid white;
}
.nav-item:after {
  content: '';
  position: absolute;
  width: 100%;
  transform: scaleX(0);
  height: 2px;
  bottom: 0;
  left: 0;
  background-color:#fff;
  transform-origin: bottom right;
  transition: transform 0.25s ease-out;
}

.nav-item:hover:after {
  transform: scaleX(1);
  transform-origin: bottom left;
}
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid col-md-8 justify-content-center">
      <a class="navbar-brand" href="#">
        <span>{{ config('app.name', 'Laravel') }}</span>
      </a>
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item mx-2">
                <a class="nav-link {{ (Request::is('index') ? 'active' : '') }}" href="{{ url('index') }}">
                    <span class="mx-2 my-2">Tracking</span>
                </a>
            </li>
            @auth
            <li class="nav-item mx-2">
                <a class="nav-link {{ (Request::is('documents') ? 'active' : '') }}" href="{{ url('documents') }}">
                    <span class="mx-2 my-2">My Documents</span>
                </a>
            </li>
            @endauth
            @auth
            <li class="nav-item mx-2">
              <a class="nav-link {{ (Request::is('add-document') ? 'active' : '') }}" href="{{ url('add-document') }}">
                  <span class="mx-2 my-2">Create Document</span>
              </a>
            </li>
            @endauth
        </ul>
        <ul class="navbar-nav d-flex flex-row ms-auto me-3">
            @auth
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="{{ url('/logout')}}" class="nav-link text-center font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1 white"></i>
                        <span class="font-weight-bold d-sm-inline text-center text-black"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</span>
                    </a>
                </div>
              </div>
            @endauth
            @guest
            <div>
            <li class="nav-item">
                <a href="{{ route('register') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-sharp fa-solid fa-user"></i>
                <span class="d-sm-inline text-black">Register</span>
                </a>
            </li>
        </div>
            <div>
            <li class="nav-item">
                <a href="{{ url('/login')}}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-sharp fa-solid fa-right-to-bracket"></i>
                <span class="d-sm-inline text-black">Login</span>
                </a>
            </li>
        </div>
            @endguest
        </ul>
      </div>
    </div>
  </nav>
