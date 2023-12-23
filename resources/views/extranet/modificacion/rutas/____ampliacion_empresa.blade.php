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
			<h4 class="page-title">Ruta / Ampliacion</h4>
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
			    	<h6 class="text-primary">Datos de la Empresa</h6>
			    	<div class="row">
			        <div class="col-lg-6 form-group">
						    <label for="empresa">Empresa</label>
						    <select class="form-control" id="empresa" name="empresa"></select>
						  </div>
						</div>
			    	<hr class="mt-0">
			    	<h6 class="text-primary">Resolucion</h6>
			    	<div class="row">
						  <div class="col-lg-6 col-md-12 form-group">
						    <label for="resolucion">N° Resolucion</label>
						    <!-- <input type="text" class="form-control" id="resolucion" name="resolucion"> -->
						    <div class="input-group">
								  <input type="text" class="form-control" id="resolucion" name="resolucion">
								  <div class="input-group-append">
								    <span class="input-group-text" id="basic-addon2">-GRP.PUNO/DRTCVC.</span>
								  </div>
								</div>
						  </div>
			    	</div>
			    	<div class="row">
			    		<div class="col-lg-3 col-md-4">
								<div class="form-group">
									<label for="fecha_ini">Fecha</label>
									<div class="input-group">
										<div class="input-group-append">
											<label for="fecha_ini" class="input-group-text"><i class="fa fa-calendar"></i></label>
										</div>
										<input type="text" class="form-control datetimepicker-input" id="fecha_ini" name="fecha_ini" data-target="#fechaIni"/>
									</div>
								</div>
							</div>
							<!-- <div class="col-lg-3 col-md-4">
								<div class="form-group">
									<label for="fecha_fin">A</label>
									<div class="input-group">
										<div class="input-group-append">
											<label for="fecha_fin" class="input-group-text"><i class="fa fa-calendar"></i></label>
										</div>
										<input type="text" class="form-control datetimepicker-input" id="fecha_fin" name="fecha_fin" data-target="#fechaFin"/>
									</div>
								</div>
							</div> -->
			    	</div>
			    	<div class="row">
			    		<div class="col-md-12 form-group">
						    <label for="descripcion">Descripcion</label>
						    <textarea class="form-control" id="descripcion" name="descripcion" rows="2">Ampliación de Ruta</textarea>
						  </div>
			    	</div>	
		    	  <h6 class="text-primary">
		    		Rutas
		    		<button type="button" class="btn btn-success btn-sm" id="new_ruta">
		          	<i class="fas fa-plus"></i>Agregar
		          </button>
		        </h6>
			    	<div id="ruta">
				    	<div class="card border border-primary">
				    		<div class="card-body">
				    			<div class="row">
				            <div class="col-md-4">
				              <div class="form-group mb-1">
				                  <label for="origen">Origen</label>
				                  <input type="text" name="origen[1]" class="form-control" aria-required="true"
				                  	required="true" data-msg-required="Este campo es requerido." 
				                  >
				              </div>
				            </div>
				            <div class="col-md-4">
				              <div class="form-group mb-1">
				                  <label for="destino">Destino</label>
				                  <input type="text" name="destino[1]" class="form-control" aria-required="true"
				                  	required="true" data-msg-required="Este campo es requerido." 
				                  >
				              </div>
				            </div>
				            <div class="col-md-4">
				              <div class="form-group mb-1">
				                  <label for="frecuencia">Frecuencia</label>
				                  <input type="text" name="frecuencia[1]" class="form-control" aria-required="true"
				                  	required="true" data-msg-required="Este campo es requerido." 
				                  >
				              </div>
				            </div>
				          </div>
				          <!-- <hr> -->
				          <h5 class="text-primary">Itinerario</h5>
				          <button type="button" class="btn btn-primary btn-sm new_itinerario" numero="1">
				          	<i class="fas fa-plus"></i>Agregar
				          </button>
				          <div class="itinerario">
				          	
				          </div>
				    		</div>
				    	</div>
			    		
			    	</div>
			    </form>

			    <hr>
			    <div class="row justify-content-md-center">
			  			<button class="btn btn-lg col-md-6 btn-primary" type="button" id="guardar" style="font-size: 20px">Guardar Cambios</button>
			    </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- ***************Clonar***************** -->
<div style="display: none;" id="clon_ruta">
	<div class="card border border-primary">
		<div class="card-header p-0">
			<button type="button" class="btn btn-sm btn-primary eliminar_ruta float-right">Borrar</button>
		</div>
		<div class="card-body">
			<div class="row">
        <div class="col-md-4">
          <div class="form-group mb-1">
              <label for="origen">Origen</label>
              <input type="text" name="" class="form-control origen" aria-required="true"
              	required="true" data-msg-required="Este campo es requerido." 
              >
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group mb-1">
              <label for="destino">Destino</label>
              <input type="text" name="" class="form-control destino" aria-required="true"
              	required="true" data-msg-required="Este campo es requerido." 
              >
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group mb-1">
              <label for="frecuencia">Frecuencia</label>
              <input type="text" name="" class="form-control frecuencia" aria-required="true"
              	required="true" data-msg-required="Este campo es requerido." 
              >
          </div>
        </div>
      </div>
      <!-- <hr> -->
      <h5 class="text-primary">Itinerario</h5>
      <button type="button" class="btn btn-primary btn-sm new_itinerario">
      	<i class="fas fa-plus"></i>Agregar
      </button>
      <div class="itinerario">
      	
      </div>
		</div>
	</div>
</div>

<div style="display: none;" id="clon_itinerario">
	<div class="form-group my-1">
		<div class="input-group">
		  <input type="text" class="form-control name_itinerario" name=""
		  	required="true" data-msg-required="Este campo es requerido." 
		  >
		  <div class="input-group-append">
		    <button class="btn btn-outline-danger eliminar_itinerario" type="button"><i class="fas fa-times"></i></button>
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

<script type="text/javascript" src="{{asset('js/extranet/modificacion/rutas/ampliacion.js')}}"></script>
@endsection
