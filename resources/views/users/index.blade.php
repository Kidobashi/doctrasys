@extends('templates.user')
@section('content')
@include('layouts.navbars.auth.nav')
<div>
    <h1>Index</h1>
    @foreach($docs as $doc)

    @endforeach
</div>
@endsection
