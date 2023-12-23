<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAET - Sub Dirección de Transportes</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/styles.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}"> -->
    @yield('css')
	<script>
	    window.Laravel = {!! json_encode([
	        'csrfToken' => csrf_token(),
	    ]) !!};
	</script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div id="main-wrapper">
        @include('layouts.includes.header')
        @include('layouts.includes.menu')
        <div class="page-wrapper">
        	@yield('content')
        </div>
    </div>
    <script type="text/javascript" src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script type="text/javascript" src="{{asset('vendor/popper.js/dist/umd/popper.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script type="text/javascript" src="{{asset('vendor/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <!-- <script src="../../assets/extra-libs/sparkline/sparkline.js"></script> -->
    <!--Wave Effects -->
    <script type="text/javascript" src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script type="text/javascript" src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript" src="{{asset('js/custom.min.js')}}"></script>
    <script type="text/javascript">
        $('.form-control').keyup(function () {
            $(this).val($(this).val().toUpperCase());
        })
    </script>
    <!-- this page js -->
    <!-- <script src="../../assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="../../assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="../../assets/extra-libs/DataTables/datatables.min.js"></script> -->
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