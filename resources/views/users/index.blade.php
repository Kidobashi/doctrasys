@extends('templates.user')
@section('content')
<style>
.search{
    justify-content: center;
}
input {
    font-size: 22px;
    margin-top: 120px;
    width: 480px;
    padding:20px;
    border-radius:25px 0 0 25px;
}

button {
    padding:20px;
    font-size: 22px;
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

@media screen and (max-width: 950px) {
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
<div class="search d-flex ml-4 col-lg-12 col-md-12 col-md-8">
    <form action="{{ url("qrinfo/") }}" method="get">
        <input type="text" name="search">
        <button type="submit">Track Document</button>
    </form>
</div>
@endsection
