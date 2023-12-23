@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">

@endsection

@section('content')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">Rutas</h4>
			<div class="ml-auto text-right">
				<nav aria-label="breadcrumb">
					@include('extranet.empresa.links')
				</nav>
			</div>
		</div>
	</div>
</div>
<br>
<div class="card m-0">
	<div class="card-body py-3">
	  <h4 class="card-title text-primary">{{$empresa->Nombre}}</h4>
	  <p class="mb-0"><strong>RUC:</strong> {{$empresa->ruc}}</p>
	  <p class="mb-0">
	  	<div class="form-group">
        <label for="autorizacion"><strong>Autorizacion</strong></label>
        <select id="autorizacion" name="autorizacion" class="form-control">
        	@foreach($autorizacion as $value)
        	<option value="{{$value->id}}" data-rutas="{{$value->Rutas}}">{{$value->Resolucion}} -|- {{$value->Tipo}}</option>
        	@endforeach
        </select>
    	</div>
	  </p>
	  <p class="mb-0"><strong>RUTAS: </strong> <span class="n_rutas"></span></p>
	</div>
</div>
<!-- Page Title Header Ends-->
<!-- <div class="container-fluid"> -->
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-header bg-white">
					<div class="float-right" id="new-add" style="display: none;">
						<button class="btn btn-primary btn-sm" id="nuevo"><i class="fas fa-plus"></i> Crear Ruta</button>
					</div>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <th>Opciones</th>
			            <th>Origen</th>
			            <th>Destino</th>
			            <th>Frecuencia</th>
			            <th>Itinerario</th>
			            <th>Resolucion</th>
			          </tr>
			        </thead>
			        <tbody>
			        </tbody>
			      </table>
			    </div>
	      </div>
	    </div>
	  </div>
	</div>
<!-- </div> -->

<div class="modal fade" id="modal-datatable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-datatable">Modal</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formulary">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="origen">Origen</label>
                  <input type="text" id="origen" name="origen" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="destino">Destino</label>
                  <input type="text" id="destino" name="destino" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <label for="frecuencia">Frecuencia</label>
                  <input type="text" id="frecuencia" name="frecuencia" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <hr>
          <h5 class="text-primary">Itinerario</h5>
          <button type="button" class="btn btn-primary btn-sm" id="new_itinerario">
          	<i class="fas fa-plus"></i>Agregar
          </button>
          <div id="itinerario">
          	
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="guardar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- ***************Clonar***************** -->

<div style="display: none;" id="clon">
	<div class="form-group my-1">
		<div class="input-group">
		  <input type="text" class="form-control" name="itinerario[]">
		  <div class="input-group-append">
		    <button class="btn btn-outline-danger eliminar_itinerario" type="button"><i class="fas fa-times"></i></button>
		  </div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="{{asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<script type="text/javascript" src="{{asset('vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/validator.setDefaults.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.js')}}"></script>

<script type="text/javascript">
	var ide = "{!!$empresa->id!!}";
	var ida = 0;
	var nR = 0;
</script>
<script type="text/javascript" src="{{asset('js/extranet/empresa/ruta.js')}}"></script>
@endsection
