@extends('templates.user')
<style>
/* body, html {
    background-color: #eee8e1;
} */
/* .alt-search{
    display: none;
} */

.transparent-input {
    background-color: transparent;
    border: none;
    border-bottom: 2px solid black;
    padding: 0;
    margin: 0;
    font-size: 16px;
  }
  .transparent-input:focus {
    outline: none;
    border-color: blue;
    font-size: 24px;
  }

.script {
    display:block;
    text-align: center;
}

.center-home-div img{
    width: 80%;
}

.center-home-container{
    display:flex;
    margin-top: 20px;
}

.bordered-image {
    border: 15px solid black;
    border-radius: 15px;
}

@media screen and (max-width: 600px) {
/* .alt-search{
    display: flex;
} */

.script{
    display: block;
    text-align: center;
    position: relative;
    bottom:50px;
}
}
@media screen and (max-width: 400px) {

    .center-home-container{
    display:flex;
    margin-top: 20px;
}
/* .alt-search{
    display: block;
    width: %;
} */
input {
    width: 100%;
    position: relative;
    font-size: 12px;
    padding: 5px;
    border-radius:25px;

  }
button {
    margin-top: 10px;
    width: 40%;
    padding: 12px;
    font-size: 5px;
    border-radius:25px;
}

.center-home-container .center-home-div, .scan-ins, .center-home-div img{
    display:none;
}

.script
{
    margin-top: 10px;
    display: block;
}
}
@media screen and (max-width: 950px) {
.display-4 {
    font-size: 28px;
    justify-content: center;
}
.search {
    position: relative;
    display: block;
    justify-content: center;
}
input {
    width: 100%;
    position: relative;
    font-size: 12px;
    padding: 5px;
    border-radius:25px;

}
button {
    margin-top: 10px;
    width: 40%;
    padding: 10px;
    font-size: 14px;
    border-radius:25px;
}

.script{
    margin-top: 10px;
    display: block;
}
}

.alternative{
    display: none;
}

@media screen and (max-width: 1100px) {

.search {
    position: relative;
}

.center-home-div , .bordered-image, .scan-ins{
    display: none;
}
input {
    width: 100%;
    position: relative;
    font-size: 18px;
    padding: 10px;
    border-radius:25px;
}
button {
    margin-top: 10px;
    width: 40%;
    padding: 10px;
    font-size: 14px;
    border-radius:25px;
}
}
</style>
@section('content')
<div class="container mt-3">
    <div class="col-lg-6 p-1 mx-auto">
      <form action="tracking" method="get">
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><button class="btn"><i class="fa fa-search fa-3x"></i></button></span>
            </div>
            <input type="text" class="form-control transparent-input rounded" name="search" placeholder="Reference Number...">
          </div>
      </form>
    </div>
  </div>

<div class="script">
    @if(session()->has('success'))
        <p class="display-4">No 'results' found</td></p>
    @elseif (Request::is('index') || Request::is('tracking'))
        <p class="display-5"></p>
    @endif
</div>
{{-- <section> --}}
    <div class="container center-home-container">
        <div class="col-md-6 col-sm-0 col-xs-0 d-flex flex-column align-items-center justify-content-center center-home-div d-lg-block d-md-block d-xs-none d-sm-block">
           <img class="bordered-image" src="{{ url('images/home-qr.png') }}" alt="WELCOME" style="width: 300px; height:300px;">
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 d-flex align-items-center justify-content-center">
            <div class="p-4 bg-warning rounded">
                <div class="d-block btn bg-success text-white">
                    <h1>Welcome! This is the Central Mindanao University</h1>
                    <h3>Document Tracking System</h3>
                    <div>
                     <img src="{{ asset('images/cmulogo.png') }}" alt="CMU Logo" width="140" style="width: 140px; height:140px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </section> --}}



<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<footer class="footer py-3 bg-light mt-5">
    <div class="container text-center">
    <span class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}</span>
    </div>
</footer>
@endsection
