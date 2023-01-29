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
</style>
  <!-- Section: Design Block -->
  <section class="h-100 rounded my-1" style="">
    <div class="container vh-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="card py-3 col-md-6 col-lg-6 col-xl-6" style="border-radius: 1rem;
            -moz-box-shadow: 0px 3px 8px rgb(100,100,100);
            -webkit-box-shadow: 0px 3px 8px rgb(100,100,100);
            box-shadow: 0px 3px 8px rgb(100,100,100);">
        <div class="card-body px-5 text-center">
              <h3 class="text-center"><strong>Sign Up</strong></h3>
                <p class="my-3 text-center">Fill in to sign up </p>
                <form method="POST" action="{{ route('register') }}">
                @csrf
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="form-outline mb-4">
                    <input type="text" id="form3Example1" placeholder="Username" name="name" class="form-control w-75 @error('name') is-invalid @enderror" required/>
                        @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form3Example3" placeholder="Email" name="email" class="form-control  w-75 @error('email') is-invalid @enderror" required/>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-outline mb-4">
                        <select class="form-control text-center w-75" id="assignedOffice" name="assignedOffice">
                            <option value="" selected disabled>Select Office
                                @foreach ($offices as $row)
                                <option style="font-size:1.2rem;" value="{{ $row->id }}">{{ $row->officeName }}</option>
                            </option>
                                @endforeach
                            </select>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="form3Example4" placeholder="Password" class="form-control w-75 @error('password') is-invalid @enderror" name="password" required/>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-outline mb-4">
                        <input type="password" id="form3Example4" placeholder="Confirm Password" class="form-control w-75" name="password_confirmation" required/>
                    </div>

                        <!-- Checkbox -->
                    <div class="text-center">
                        <!-- Submit button -->
                    <button type="submit" class="btn btn-success w-30 btn-block mb-2 px-5 fs-5" style="border-radius: 18px;">
                          Sign up
                        </button>
                        <hr>
                        <!-- Register buttons -->
                          <p>Already have an account?</p>

                          <a href="/login" class="btn btn-outline-success mb-4 px-4 fs-6" style="border-radius: 18px;" role="button">Sign In</a>
                        </div>
                      </form>
            </div>
          </div>
        </div>
      </div>
  </section>
@endsection
