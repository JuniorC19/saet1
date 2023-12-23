@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">

<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	    	<div class="card-header bg-white pb-0">
	        <h3 class="mb-0 text-primary">Vehiculos</h3>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data-vehiculo" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <th>Opciones</th>
			            <th>Placa</th>
			            <th>Marca</th>
			            <th>Categoria</th>
			            <th>Fabricacion</th>
			          </tr>
			        </thead>
			        <tbody>
			        </tbody>
			      </table>
			    </div>
	      </div>
	    </div>
	  </div>
	  <div class="col-lg-12">
	    <div class="card">
	    	<div class="card-header bg-white pb-0">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="mb-0 text-primary">Rutas</h3>
	        	</div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" class="form-control">
                	<option value="">Todo</option>
                	<option value="1">Activo</option>
                	<option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data-ruta" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <!-- <th>Opciones</th> -->
			            <th>Ruc</th>
			            <th>Empresa</th>
			            <th>Resolucion</th>
			            <!-- <th>Comentario</th> -->
			            <th>Origen</th>
			            <th>Destino</th>
			            <th>Frecuencia</th>
			            <th>Itinerario</th>
			            <th>Estado</th>
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
</div>

<div class="modal fade" id="modal-datatable-historial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-datatable">Vehiculo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <th>#</th>
              <th>Ruc</th>
              <th>Razon Social</th>
              <th>N° Resolucion</th>
              <th>Comentario</th>
              <th>Fecha Ingreso</th>
              <th>Fecha Fin</th>
              <th>Estado</th>
            </thead>
            <tbody id="historial">
              
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
	var search = "{!!$search!!}";
</script>
<script type="text/javascript" src="{{asset('js/extranet/search.js')}}"></script>
@endsection
