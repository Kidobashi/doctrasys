@extends('layouts.app')

@section('content')
<style>
html, body {
    height: 100%;
    width: 100%;
    /* background-image: url('/images/bg-sign-in.png'); */
    background-size: cover;
    background-repeat: no-repeat;
    overflow:hidden;
}
input{
    display: block;
    text-align: center;
}

input[type=text], input[type=email], input[type=password], select, option{
    border-radius: 20px;
    margin: auto;
    font-size: 18px;
}
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.bg-img{
    opacity: .4;
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
}

.container {
    position: relative;
    z-index: 2;
}

@media only screen and (max-width: 600px) {
    input[type=text], input[type=email], input[type=password], select, option{
    border-radius: 20px;
    margin: auto;
    font-size: 12px;
}
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
      </div>
    <div class="bg-img">
        <img src="/images/bg-sign-in.png" alt="">
    </div>
</section>
@endsection
