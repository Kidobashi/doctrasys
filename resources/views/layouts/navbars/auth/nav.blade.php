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

.web-input input{
    width: 340px;
}
.active {
    border-bottom: 2px solid white;
}

input {
    font-size: 15px;
    width: 520px;
    padding:7.5px;
    border-radius: 5px;
    background-color: rgb(238, 225, 225);
    border:0;
    outline:0;
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

#loginMobile, #myLinks, .mobileDropDown, .mobile-menu-container, .mobile-menu-container a{
    display: none;
    z-index: 1;
}

#myLinks li {
    list-style-type: none;
    color: white;
}

@media only screen and (max-width: 600px) {
  header nav {
    display: none;
  }

  .web-input {
    display: none;
  }

 #loginMobile, #myLinks , .mobileDropDown, .mobile-menu-container, .mobile-menu-container a{
    display: block;
  }
.mobile-menu-container {
    position: fixed;
    margin-top:50px;
    border: 1px solid grey;
    background-color: green;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 0;
    z-index: 1;
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
}
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid col-md-12 justify-content-center">
      <a class="navbar-brand" href="index">
        <span>{{ config('app.name', 'Laravel') }}</span>
      </a>
      @guest
      <div class="container" id="loginMobile">
        <div class="row d-flex justify-content-between">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">
                Login
            </button>

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#registerModal">
                Register
            </button>
        </div>
      </div>
      @endguest
        @auth
        <div class="dropdown mobileDropDown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <p class="p-1 pb-0 pt-2 bg-secondary">Assigned Office: <strong>{{ Auth::user()->office->officeName }}</strong></p>
                {{-- <a href="{{ url('/profile-settings')}}" class="nav-link font-weight-bold p-3">
                    <span class="font-weight-bold d-sm-inline text-center text-black"><i class="fas fa-cog"></i>Profile Settings</span>
                </a> --}}
                <a href="{{ url('/logout')}}" class="nav-link font-weight-bold p-3">
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
                  <span class="mx-2 my-2">Generate QR Code</span>
              </a>
            </li>
            @endauth
            <li class="nav-item mx-2 my-auto col-md-3">
                <div class="d-flex pt-0 web-input">
                    <form action="tracking" method="get">
                        <input type="text" name="search" placeholder=" Search with reference number...">
                    </form>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav d-flex flex-row ms-auto me-3">
            @auth
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Assigned in {{ Auth::user()->office->officeName }}">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <p class="p-3 pb-0 pt-2"><span>Assigned Office: <strong>{{ Auth::user()->office->officeName }}</strong><span></p>
                    <a href="{{ url('/logout')}}" class="nav-link p-3 font-weight-bold">
                        <span class="font-weight-bold d-sm-inline text-center text-black"><i class="fa-solid fa-right-from-bracket"></i>Sign Out</span>
                    </a>
                </div>
              </div>
            @endauth
            @guest
            <div>
                <li class="nav-item mx-2">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#registerModal">
                        Register
                    </button>
                </li>
            </div>
            <div>
                <li class="nav-item mx-2">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal">
                        Login
                    </button>
                </li>
            </div>
            @endguest
        </ul>
      </div>
    </div>
  </nav>

@auth
<nav class="d-flex justify-content-center nav mobile-menu-container nav-justified fixed-bottom bg-success pb-0 mt-5">
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
{{-- Login Modal --}}
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-end p-1">
          <button type="button" class="btn bg-white text-danger m-0" style="border: 1px solid black;" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times fa-2x m-0 p-0" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="modal-body text-center">
            <form method="POST" action="/session">
                @csrf
                <h3 class="mb-2">Sign in</h3>
                <p>Please enter your email and password to login</p>
                <div class="form-outline mb-4">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" />
                  @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-outline mb-2">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password"/>
                    @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-center mb-3">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} id="form1Example3" />
                  <label class="form-check-label" for="form1Example3">&nbsp; Remember password </label>
                </div>

                <button class="btn btn-success btn-lg btn-block w-30 mb-2 px-5 fs-6" style="border-radius: 18px;" type="submit">Sign In</button>
                <div class="form-outline mb-2">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                     @endif
                </div>

                <hr class="my-2">
                <p>Don't have an account?</p>
                <a href="/register" class="btn btn-outline-success mb-4c" style="border-radius: 18px;" role="button">Sign Up</a>
                {{-- <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #dd4b39;"
                  type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
                  type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button> --}}
                </form>
        </div>
      </div>
    </div>
</div>
{{-- Register Modal --}}
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-end p-1">
          {{-- <h5 class="modal-title" id="exampleModalLongTitle">Msdfasdfsditle</h5> --}}
          <button type="button" class="btn bg-white text-danger m-0" style="border: 1px solid black;" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times fa-2x m-0" aria-hidden="true"></i>
            </span>
          </button>
        </div>
        <div class="modal-body text-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h3 class="mb-2">Create an Account</h3>
                <p>Fill-in the fields to register</p>

                <div class="form-outline mb-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" required/>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required />
                  @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <select class="form-control text-center" style="border-radius: 22px;" id="assignedOffice" name="assignedOffice" required>
                        <option value="" selected disabled>Select Assigned Office
                            @foreach ($offices as $row)
                            <option style="font-size:1.2rem;" value="{{ $row->id }}">{{ $row->officeName }}</option>
                        </option>
                            @endforeach
                    </select>
                    @error('assignedOffice')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required/>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required/>
                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check d-flex justify-content-center mb-4">
                    <input type="checkbox" class="form-check-input" id="terms-checkbox" name="terms">
                    <label class="form-check-label" for="terms-checkbox">&nbsp;&nbsp; I agree to the terms and conditions</label>
                    @error('terms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-success btn-lg btn-block w-30 mb-2 px-5 fs-6" style="border-radius: 18px;" type="submit">Register</button>
                <div class="form-outline mb-2">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                     @endif
                </div>

                <hr class="mt-2">
                <p class="mb-0">Already have an account? <a href="/login" style="border-radius: 18px;" role="button">Login here</a></p>

                {{-- <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #dd4b39;"
                  type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                <button class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
                  type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button> --}}
                </form>
        </div>
      </div>
    </div>
  </div>
