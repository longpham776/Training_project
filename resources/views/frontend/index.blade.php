@extends('frontend.masterview')
@section('content')
<nav class="nav justify-content-center">
  <a class="nav-link active" href="#">Active link</a>
  <a class="nav-link" href="#">Link</a>
  <a class="nav-link disabled" href="#">Disabled link</a>
</nav>
<h1>Login Success!</h1>
<a href="{{route('logout')}}">Logout</a>
@stop