@extends('layouts.web')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
@endsection
@section('content')
<!-- Header -->
  <header class="py-5 mb-5">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-lg-12 text-center">
          <h3 class="mt-5 pt-4 mb-2">CONSULTA DE VEHÍCULO Y RUTA(S) AUTORIZADA(S)</h3>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container">
    <form id="formulary" method="get" action="{{url('/vehiculo')}}">
      {{ csrf_field() }}
      <div class="row justify-content-md-center">
      	<div class="col-md-4">
  	      <div class="form-group text-center">
  	      	<label class="font-weight-bold" for="placa">NÚMERO DE PLACA</label>
  			    <input type="text" class="form-control text-center" id="placa" name="placa" placeholder="Ejm: W3X-256">
  			  </div>
  			  <div class="form-group">
            <div class="d-flex justify-content-center">
              <div class="g-recaptcha" data-sitekey="6LdtAfoSAAAAANbNT_vL65Gsi3WY4eBx3vX2-HUV" data-callback="correctCaptcha"></div>
            </div>
              <label id="recaptchaError" class="d-none invalid-feedback">Captcha requerido.</label>
          </div>
          <div>
          	<button type="button" class="btn btn-primary btn-lg d-block col-12" id="consultar"><i class="fas fa-car"></i> Consultar</button>
  			  </div>
  		  </div>
      </div>
    </form>

  </div>
@endsection
@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" src="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/validator.setDefaults.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('js/loader.js')}}"></script> -->
<script type="text/javascript" src="{{asset('js/web/inicio.js')}}"></script>
@endsection
