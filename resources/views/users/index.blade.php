@extends('templates.user')
@section('content')
<head>
    <title>Tracking</title>
</head>
<style>
.search{
    justify-content: center;
    position: relative;
    top: 120px;
    height: 30%;
}
input {
    font-size: 16px;
    margin-top: 120px;
    width: 480px;
    padding:10px;
    border-radius:25px 0 0 25px;
}

button {
    padding:10px;
    font-size: 16px;
    border-radius:0 25px 25px 0;

}

@media screen and (max-width: 400px) {

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
    padding: 12px;
    font-size: 5px;
    border-radius:25px;
}
}

@media screen and (max-width: 950px) {
.display-4 {
    font-size: 28px;
    justify-content: center;
}
input {
    width: 100%;
    position: relative;
    font-size: 14px;
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
}

@media screen and (max-width: 1100px) {

.search {
    position: relative;
    left: 10px;
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
This page took {{ (microtime(true) - LARAVEL_START) }} seconds to render
<div class="search d-flex ml-4 col-lg-12 col-md-12 col-md-8">
    <form action="tracking" method="get">
        <input type="text" name="search">
        <button type="submit">Track Document</button>
    </form>
</div>

<div class="d-flex mt-6 justify-content-center">
    @if(isset($data->referenceNo))
    <a class="bg-white w-80 border m-2 p-2" href="http://127.0.0.1:8000/qrinfo/{{ $data->referenceNo }}">
    <div>
        <h3>Reference Number : {{ $data->referenceNo }}</h3>
        <div class="d-flex justify-content-end">
            <p class="details">{{ date_format($data->created_at,'M d Y h:i a') }}</p>
        </div>
    </div></a>
    @elseif (Request::is('index'))
        <p class="display-4">Track 'Document' with reference number...</p>
    @else
    <p class="display-4">No 'results' found</td></p>
    @endif
</div>
@if(Session::has('message'))
    <p style="color: white; position: fixed; top: 5px;width: 400px;" id="divID" style="display: block;" class="alert {{ Session::get('alert-class', 'alert-danger') }} text-center"><strong>{{ Session::get('message') }}</strong></p>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script>
setTimeout(function(){
  $('#divID').remove();
}, 4000);
</script>
@endsection
