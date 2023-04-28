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

#myLinks, .mobileDropDown, .mobile-menu-container, .mobile-menu-container a{
    display: none;
    z-index: 1;
}

#loginMobile{
    display: flex;
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
/* Navbar styles */
.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #333;
  color: #fff;
  padding: 1rem;
}

/* App name styles */
.app-name {
  font-size: 2rem;
  margin: 0;
}

/* Navigation links styles */
.nav-links {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-links li {
  margin-left: 1rem;
}

.nav-links li:first-child {
  margin-left: 0;
}

.nav-links a {
  color: #fff;
  text-decoration: none;
  font-size: 1.2rem;
}

/* Media query for small screens */
@media only screen and (max-width: 767px) {
  .nav-links {
    display: none;
    flex-direction: column;
    align-items: center;
    width: 100%;
  }

  .web-input {
    display: none;
  }
  .extra-search
  {
    display: none;
  }

  .nav-links.show {
    display: flex;
  }

  .nav-links li {
    margin: 1rem 0;
  }
}

@media only screen and (max-width: 400px) {
  .nav-links {
    display: none;
    flex-direction: column;
    align-items: center;
    width: 100%;
  }

  .navbar-search {
    display: none;
  }
  .extra-search
  {
    display: none;
  }

  .nav-links.show {
    display: flex;
  }

  .nav-links li {
    margin: 1rem 0;
  }
}

</style>

<nav class="navbar navbar-expand-lg navbar-light bg-success p-2">
    <div class="container">
        <div class="d-flex">
            <button class="navbar-toggler ml-1 my-auto" style="width:14%;" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand text-white text-center" href="index">{{ config('app.name', 'Laravel') }}</a>
        </div>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-2 my-1 text-center">
            <a class="nav-link {{ (Request::is('index') ? 'active' : '') }}" href="{{ url('index') }}">
              <span class="text-white">Home</span>
            </a>
          </li>
          @auth
          <li class="nav-item mx-2 my-1 text-center">
            <a class="nav-link {{ (Request::is('my-qr-codes') ? 'active' : '') }}" href="{{ url('my-qr-codes') }}">
              <span class="text-white">My QR Codes</span>
            </a>
          </li>
          <li class="nav-item mx-2 my-1 text-center">
            <a class="nav-link {{ (Request::is('generate-qr-codes') ? 'active' : '') }}" href="{{ url('generate-qr-codes') }}">
              <span class="text-white">Generate QR Code</span>
            </a>
          </li>
          <li class="nav-item mx-2 my-1 navbar-search text-center">
            <div class="d-flex pt-0 web-input justify-content-center">
              <form action="tracking" method="get">
                <input class="text-center" type="text" name="search" placeholder="🔍 Search reference number...">
              </form>
            </div>
          </li>
          @endauth
          @guest
              <div class="col-md-12">

              </div>
              <div class="col-md-12">

              </div>
              <div class="col-md-12">

              </div>
              <div class="col-md-4">

              </div>
          @endguest
          @guest
          <li class="nav-item mx-2 my-1">
            <div class="container" id="loginMobile">
              <div class="row d-flex justify-content-between">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#loginModal">
                  <strong>Login/Register</strong>
                </button>
              </div>
            </div>
          </li>
          @endguest
          @auth
          <li class="nav-item dropdown ml-4 my-1">
            <a class="nav-link dropdown-toggle text-white text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <strong>{{ Auth::user()->name }}</strong>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <p class="dropdown-item p-2 mb-0" href="#">
                <span class="text-wrap text-center">Assigned Office: <strong>{{ Auth::user()->office->officeName }}</strong></span>
              </p>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ url('/logout')}}" >Logout</a>
            </div>
          </li>
          @endauth
        </ul>
      </div>
    </div>
</nav>
@auth
<nav class="d-flex justify-content-center nav mobile-menu-container nav-justified fixed-bottom bg-success pb-0 mt-5">
    <a class="nav-item nav-link pb-0 mb-0 {{ (Request::is('index') ? 'active' : '') }}" href="{{ url('index') }}">
        <i class="fas fa-location-dot fa-lg mb-3"></i>
        <p class="pb-0 mb-0">Tracking</p>
    </a>
    <a class="nav-item nav-link pb-0 mb-0  {{ (Request::is('generate-qr-codes') ? 'active' : '') }}" href="{{ url('generate-qr-codes') }}">
        <i class="fas fa-qrcode fa-lg mb-3"></i>
        <p class="pb-0 mb-0">Generate QR</p>
    </a>
    <a class="nav-item nav-link pb-0 mb-0 {{ (Request::is('my-qr-codes') ? 'active' : '') }}" href="{{ url('my-qr-codes') }}">
        <i class="fas fa-list fa-lg mb-3" aria-hidden="true"></i>
        <p class="pb-0 mb-0">My QR Codes</p>
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
                <h3 class="mb-2">Login</h3>
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

                <button class="btn btn-success btn-lg btn-block w-30 mb-2 px-4 fs-6" style="border-radius: 18px;" type="submit">Login</button>
                <div class="form-outline mb-2">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                     @endif
                </div>

                <hr class="my-2">
                <p>Don't have an account?</p>
                <a data-toggle="modal" data-target="#registerModal" id="registerBtn" class="btn btn-outline-success mb-4c" style="border-radius: 18px;" role="button">Register</a>
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

                <button class="btn btn-success btn-lg btn-block w-30 mb-2 fs-6" style="border-radius: 18px;" type="submit">Register</button>
                <div class="form-outline mb-2">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                     @endif
                </div>

                <hr class="mt-2">
                <p class="mb-0">Already have an account? <a class="btn btn-outline-success" id="loginBtn" class="close" data-dismiss="modal" style="border-radius: 18px;" role="button">Login</a></p>
                </form>
        </div>
      </div>
    </div>
</div>
 <script>
  $(function() {
  // hide other modals when a new one is shown
  $('.modal').on('show.bs.modal', function() {
    $('.modal').not($(this)).modal('hide');
  });

  // show register modal after login modal is hidden
  $('#loginModal').on('hidden.bs.modal', function() {
    $('#registerModal').modal('show');
  });

  // show login modal after register modal is hidden
  $('#registerModal').on('hidden.bs.modal', function() {
    $('#loginModal').modal('show');
  });
});


</script>
