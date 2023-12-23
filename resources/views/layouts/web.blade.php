<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Direccion de Circulacion - DRTC</title>

  <!-- Bootstrap core CSS -->
  <!-- <link href="{{asset('vendor/fontawesome-free/css/fontawesome.css')}}" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="{{asset('vendor/fontawesome-free/css/all.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <style type="text/css">
  	.bg-color{
  		background: #4b4b4d;
  		color: white;
  	}
  	.nav-link{
  		color: white !important;
  	}
  	.nav-link:hover{
  		color: white;
  		/*color: #0178BA !important;*/
  		text-shadow: 3px 3px 3px #FEC200;
  	}
  </style>
  @yield('css')
  <script>
      window.Laravel = {!! json_encode([
          'csrfToken' => csrf_token(),
      ]) !!};
  </script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-color fixed-top border-bottom">
    <div class="container-fluid">
    	<nav class="navbar navbar-light p-0">
			  <a class="navbar-brand p-0" href="{{url('/')}}">
			    <img src="{{asset('img/mtc/logocirculacion.png')}}" height="70" class="d-inline-block align-top" alt="">
			  </a>
			</nav>
      <!-- <a class="navbar-brand" href="#">Start Bootstrap</a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{url('/')}}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/login')}}">Iniciar Sesion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  @yield('content')

  <!-- <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
  </footer> -->

  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script type="text/javascript">
        // Inicializamos jQuery para X-CSRF
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
  </script>
    @yield('scripts')

</body>

</html>
