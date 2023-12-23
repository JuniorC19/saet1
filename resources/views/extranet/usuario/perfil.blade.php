@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">
@endsection

@section('content')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">Perfil</h4>
			<!-- <div class="ml-auto text-right">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Library</li>
					</ol>
				</nav>
			</div> -->
		</div>
	</div>
</div>
<!-- Page Title Header Ends-->
<div class="container-fluid">
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-body">
	        <form id="formulary">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" id="nombre" name="nombre" value="{{$perfil->Name}}" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="user">Usuario</label>
                  <input type="text" value="{{$perfil->Email}}" class="form-control" disabled="disabled">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="password">Contraseña <input type="checkbox" name="edit_pass" id="edit_pass"></label>
                  <input type="text" id="password" name="password" class="form-control" aria-required="true" disabled="disabled">
              </div>
            </div>
          </div>
        </form>
        <hr>
        <div class="row">
        	<button type="button" class="btn btn-success btn-lg col-md-12" id="guardar">Guardar</button>
        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/validator.setDefaults.js')}}"></script>

<script type="text/javascript" src="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.js')}}"></script>

<script type="text/javascript" src="{{asset('js/extranet/usuario/perfil.js')}}"></script>
@endsection
