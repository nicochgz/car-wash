<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inicio de sesión</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{asset('public/app/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('public/app/ionicons.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('public/app/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#">Sistema de Carwash</a>
  </div>
 
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login para iniciar sesión</p>
      @if($errors->any())
      <div class="alert alert-danger" role="alert">
        {{$errors->first()}}
      </div>
      @endif
      <form action="{{action('Auth\LoginController@login')}}" method="post">
        {{csrf_field()}}
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">          
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <p class="mb-0">
        <a href="/car_wash/registrate" class="text-center">No tengo cuenta de socio</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('public/app/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/app/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/app/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('public/app/demo.js')}}"></script>
<script src="{{asset('public/vue.js')}}"></script>

</body>
</html>
