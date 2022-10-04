<!doctype html>
<html lang="en">
  <head>
    <title>Rcv - Login Project</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <section class="vh-100">
      <div class="container-fluid h-custom">
        <div class="d-flex my-5 justify-content-center align-items-center h-100">
          <div class="col-md-8 col-lg-6 col-xl-4">
            <form action="{{route('postLogin')}}" method="POST">
                @csrf
                <h1 class="row d-flex justify-content-center align-items-center h-100">Login</h1>
                
                @if(session('fail_login'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{session('fail_login')}}</strong>
                </div>
                @endif

                <!-- Email input -->
                <div class="form-outline mb-4">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                    @error('email')
                    <span style="color:red;">{{$message}}</span>
                    @enderror
                </div>

                <!-- Password input -->
                <div class="form-outline mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
                    @error('password')
                    <span style="color:red;">{{$message}}</span>
                    @enderror
                </div>
                
                <!-- Checkbox -->
                <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" name="remember" value="1"/>
                    <label>Remember me</label>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" class="btn btn-primary btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                </div>

            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>