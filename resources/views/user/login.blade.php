@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          Member Panel
        </div>

        <div class="card card-primary">
          <div class="card-header"><h4>Login</h4></div>

          <div class="card-body">
            @if (session('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login_member') }}" class="needs-validation" novalidate="">
                {{ csrf_field() }}
              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" value="{{ old('email') }}" name="email" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Please fill in your email
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="d-block">Password
                </label>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" tabindex="4">
                  Login
                </button>
                <hr>
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
              </div>
            </form>
          </div>
        </div>
        <div class="simple-footer">
          Copyright &copy; {{ $site_config->sip_trx_site_configs_title }} {{ date('Y') }}
        </div>
      </div>
    </div>
  </div>
</section>

@endsection