@extends('frontend.masterview')
@section('content')
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="d-flex my-5 justify-content-center align-items-center h-100">
      <div class="col-md-8 col-lg-6 col-xl-4">
        <form action="{{route('postLogin')}}" method="POST">

          <h1 class="row d-flex justify-content-center align-items-center h-100">Login</h1>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <label>Email address</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
          </div>

          <!-- Checkbox -->
          <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" name="remember_me" />
              <label>Remember me</label>
            </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="button" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
@stop