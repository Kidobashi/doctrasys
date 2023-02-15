<style>

nav a{
    outline: none;
    text-decoration: none !important;
}
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

.fa-circle-user {
    font-weight: 800;
    color: white;
}

#loginMobile, #myLinks, .mobileDropDown{
    display: none;
}

#myLinks li {
    list-style-type: none;
    color: white;
}

@media only screen and (max-width: 600px) {
  header nav {
    display: none;
  }

 #loginMobile, #myLinks , .mobileDropDown, .mobile-menu-container{
    display: block;
  }
.mobile-menu-container {
  overflow:hidden;
  border: 1px solid grey;
  background-color: green;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
  padding: 0;
}

.mobile-menu-container a{
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.mobile-menu-container p {
    font-size: 11.5px;
    font-weight: 800;
}

.mobile-menu-container a:focus, .mobile-menu-container a:active, .mobile-menu-container a.active {
    background-color: white;
    color: green;
}

.btn-success:focus,
.btn-success:active,
.btn-sucess.active {
    background-color: white;
    color: green;
}
}
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid col-md-8 justify-content-center">
      <a class="navbar-brand" href="#">
        <span>{{ config('app.name', 'Laravel') }}</span>
      </a>
      @guest
      <div class="container" id="loginMobile">
        <div class="row">
          <div class="col text-center border border-white rounded mx-1">
            <a href="{{ route('register') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user-circle-o fa-lg text-white" aria-hidden="true"></i>
                <span class="d-sm-inline text-white bolder">Register</span>
            </a>
          </div>
          <div class="col text-center border border-white rounded mx-1">
            <a href="{{ route('login') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-sign-in fa-lg text-white" aria-hidden="true"></i>
                <span class="d-sm-inline text-white bolder">Login</span>
            </a>
          </div>
        </div>
      </div>
      @endguest
        @auth
        <div class="dropdown mobileDropDown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a href="{{ url('/logout')}}" class="nav-link text-center font-weight-bold px-0">
                    <span class="font-weight-bold d-sm-inline text-center text-black"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</span>
                </a>
            </div>
        </div>
        @endauth
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
                        <span class="font-weight-bold d-sm-inline text-center text-black"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</span>
                    </a>
                </div>
              </div>
            @endauth
            @guest
            <div>
                <li class="nav-item mx-2">
                    <a href="{{ route('register') }}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fa-sharp fa-solid fa-user white"></i>
                    <span class="d-sm-inline text-black">Register</span>
                    </a>
                </li>
            </div>
            <div>
                <li class="nav-item mx-2">
                    <a href="{{ url('/login')}}" class="nav-link text-body font-weight-bold px-0">
                    <i class="fa-sharp fa-solid fa-right-to-bracket white"></i>
                    <span class="d-sm-inline text-black">Login</span>
                    </a>
                </li>
            </div>
            @endguest
        </ul>
      </div>
    </div>
  </nav>

@auth
<nav class="d-flex justify-content-center nav mobile-menu-container nav-justified fixed-bottom pb-0">
    <a class="nav-item nav-link pb-0 mb-0 {{ (Request::is('index') ? 'active' : '') }}" href="{{ url('index') }}">
        <i class="fa-solid fa-location-dot fa-lg mb-3"></i>
        <p class="pb-0 mb-0">Tracking</p>
    </a>
    <a class="nav-item nav-link pb-0 mb-0  {{ (Request::is('add-document') ? 'active' : '') }}" href="{{ url('add-document') }}">
        <i class="fa-solid fa-qrcode fa-lg mb-3"></i>
        <p class="pb-0 mb-0">Generate QR</p>
    </a>
    <a class="nav-item nav-link pb-0 mb-0 {{ (Request::is('documents') ? 'active' : '') }}" href="{{ url('documents') }}">
        <i class="fa fa-list fa-lg mb-3" aria-hidden="true"></i>
        <p class="pb-0 mb-0">My Documents</p>
    </a>
  </nav>
@endauth
