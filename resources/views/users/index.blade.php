@extends('templates.user')

@section('content')
<head>
    <title>Tracking</title>
</head>
<style>
body, html {
    background-color: #eee8e1;
}
.alt-search{
    display: none;
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
    margin-top: 150px;
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

.bordered-image {
    border: 15px solid black;
    border-radius: 15px;
}

@media screen and (max-width: 600px) {
.alt-search{
    display: block;
}

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
    margin-top: 30px;
}
    .alt-search{
    display: block;
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

.alternative{
    display: none;
}

@media screen and (max-width: 950px) {
.display-4 {
    font-size: 28px;
    justify-content: center;
}
.search {
    /* position: relative; */
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
    left: 10px;
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
<div class="d-block mt-3">
    <div class="alt-search col-lg-12 col-md-12 col-sm-12">
        <form action="tracking" method="get">
            <input class="text-center" type="text" name="search" placeholder="🔍 Reference number">
        </form>
    </div>
</div>
<div class="script mt-5">
    @if(session()->has('success'))
        <p class="display-4">No 'results' found</td></p>
    @elseif (Request::is('index') || Request::is('tracking'))
        <p class="display-5"></p>
    @endif
</div>
<section>
    <div class="container center-home-container">
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center center-home-div">
            <img class="bordered-image" src="{{ asset('images/home-qr.png') }}" alt="CMU Logo">
            <h1 class="scan-ins">[ Scan ]</h1>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center with-semicircle-div">
            <div class="p-4 bg-warning rounded">
                <div class="d-block btn bg-success text-white">
                    <h1>Welcome! This is the Central Mindanao University</h1>
                    <h3>Document Tracking System</h3>
                    <div>
                     <img src="{{ asset('images/cmulogo.png') }}" alt="CMU Logo" width="140">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script>
setTimeout(function(){
  $('#divID').remove();
}, 4000);
</script>
@endsection
