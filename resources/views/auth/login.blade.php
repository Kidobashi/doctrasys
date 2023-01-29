@extends('layouts.app')

@section('content')
<style>
html, body {
    height: 100%;
    width: 100%;
    background-image: url('/images/bg-sign-in.png');
    background-size: cover;
    background-repeat: no-repeat;
    overflow:hidden;
}
input {
    display: block;
    text-align: center;
}

input[type=text], input[type=email], input[type=password]{
    border-radius: 20px;
    margin: auto;
    font-size: 18px;
}
</style>
<section>
    <div class="container vh-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card" style="border-radius: 1rem;
                    -moz-box-shadow: 0px 3px 8px rgb(100,100,100);
                    -webkit-box-shadow: 0px 3px 8px rgb(100,100,100);
                    box-shadow: 0px 3px 8px rgb(100,100,100);">
              <div class="card-body px-5 text-center">
                <form method="POST" action="{{ route('login') }}">
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
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} id="form1Example3" />
                  <label class="form-check-label" for="form1Example3">&nbsp; Remember password </label>
                </div>

                <button class="btn btn-success btn-lg btn-block w-30 mb-4 px-5 fs-6" style="border-radius: 18px;" type="submit">Sign In</button>
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
      </div>
  </section>
@endsection
