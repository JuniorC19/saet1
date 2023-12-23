@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">
@endsection

@section('content')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">Nueva Autorizacion</h4>
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
			    	<h6 class="text-primary">Datos de la Empresa</h6>
			    	<div class="row">
						  <div class="col-lg-6 col-md-12 form-group">
						    <label for="empresa">Empresa</label>
						    <select class="form-control" id="empresa" name="empresa">
						    </select>
						  </div>
						</div>
						<div class="row">
						  <div class="col-lg-6 col-md-12 form-group">
						    <label for="tipo">Tipo</label>
						    <select class="form-control" id="tipo" name="tipo">
						    	<option value="">--Seleccionar--</option>
						    	@foreach($tipo as $value)
						    	<option value="{{$value->id}}">{{$value->nombre}}</option>
						    	@endforeach
						    </select>
						  </div>
						</div>
			    	<hr class="mt-0">
			    	<h6 class="text-primary">Datos de Autorizacion</h6>
			    	<div class="row">
						  <div class="col-lg-6 col-md-12 form-group">
						    <label for="resolucion">N° Resolucion</label>
						    <div class="input-group mb-3">
								  <input type="text" class="form-control" id="resolucion" name="resolucion">
								  <div class="input-group-append">
								    <span class="input-group-text" id="basic-addon2">-</span>
								  </div>
								  <input type="text" class="form-control" id="anio" name="anio" value="{{date('Y')}}">
								  <div class="input-group-append">
								    <span class="input-group-text" id="basic-addon2">-{{$config->siglas}}</span>
								  </div>
								</div>
						  </div>
			    	</div>
			    	<h6 class="text-primary">Vigencia</h6>
			    	<div class="row">
			    		<div class="col-lg-3 col-md-4">
								<div class="form-group">
									<label for="fecha_ini">Del</label>
									<div class="input-group">
										<div class="input-group-append">
											<label for="fecha_ini" class="input-group-text"><i class="fa fa-calendar"></i></label>
										</div>
										<input type="text" class="form-control datetimepicker-input" id="fecha_ini" name="fecha_ini" data-target="#fechaIni"/>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-4">
								<div class="form-group">
									<label for="fecha_fin">A</label>
									<div class="input-group">
										<div class="input-group-append">
											<label for="fecha_fin" class="input-group-text"><i class="fa fa-calendar"></i></label>
										</div>
										<input type="text" class="form-control datetimepicker-input" id="fecha_fin" name="fecha_fin" data-target="#fechaFin"/>
									</div>
								</div>
							</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-lg-3 col-md-4 form-group">
						    <label for="rutas">N° Rutas</label>
						    <input type="text" class="form-control" id="rutas" name="rutas">
						  </div>
						  <div class="col-lg-3 col-md-4 form-group">
						    <label for="vehiculos">N° Vehiculos</label>
						    <input type="text" class="form-control" id="vehiculos" name="vehiculos">
						  </div>
			    	</div>
			    	<div class="row">
			    		<div class="col-md-12 form-group">
						    <label for="descripcion">Descripcion</label>
						    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
						  </div>
			    	</div>	
			    </form>

			    <hr>
			    <div class="row justify-content-md-center">
			  			<button class="btn btn-lg col-md-6 btn-primary" type="button" id="guardar" style="font-size: 20px">Guardar Empresa</button>
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

<script type="text/javascript" src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/moment/min/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/moment/locale/es.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.js')}}"></script>

<script type="text/javascript" src="{{asset('js/extranet/autorizacion/create.js')}}"></script>
@endsection
