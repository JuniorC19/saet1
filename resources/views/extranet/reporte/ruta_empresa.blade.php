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
			<h4 class="page-title">Reportes / Vehiculos</h4>
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
	<div class="card">
		<div class="card-body">
			<h6 class="text-primary">Datos de la Empresa</h6>
	    <div class="row">
	      <div class="col-lg-12 form-group">
	        <h4>{{$empresa->ruc}} | {{$empresa->razon_social}}</h4>
	        <h6 class="text-muted">{{$empresa->Tipo}} | {{$empresa->Numero}}</h6>
	      </div>
	    </div>
    </div>
	</div>
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-header bg-white">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" class="form-control">
                	<option value="">Todo</option>
                	<option value="1">Activo</option>
                	<option value="0">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="col-8">
            	<button class="btn btn-default float-right" id="imprimir">Imprimir</button>
            </div>
          </div>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <!-- <th>Opciones</th> -->
			            <th>Origen</th>
			            <th>Destino</th>
			            <th>Frecuencia</th>
			            <th>Itinerario</th>
			            <th>Resolucion</th>
			            <th>Fecha</th>
			            <th>Comentario</th>
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

<div class="modal fade" id="modal-datatable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-datatable">Editar Empresa</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formulary">
           <div class="row">
			        <div class="col-md-4 form-group">
						    <label for="ruc">Ruc</label>
						    <input type="text" class="form-control" id="ruc" disabled="true">
						  </div>
						</div>
						<div class="row">
						  <div class="col-lg-6 col-md-12 form-group">
						    <label for="razon_social">Razon Social</label>
						    <textarea class="form-control" id="razon_social" name="razon_social" rows="2"></textarea>
						  </div>
			    		<div class="col-lg-6 col-md-12 form-group">
						    <label for="nombre_imprimir">Nombre Imprimir</label>
						    <textarea class="form-control" id="nombre_imprimir" name="nombre_imprimir" rows="2"></textarea>
						  </div>
			    	</div>
			    	<div class="row">
						  <div class="col-lg-4 col-md-4 form-group">
						    <label for="telefono">Telefono</label>
						    <input type="text" class="form-control" id="telefono" name="telefono">
						  </div>
						  <div class="col-lg-4 col-md-4 form-group">
						    <label for="ficha_registro">N° Ficha Registro</label>
						    <input type="text" class="form-control" id="ficha_registro" name="ficha_registro">
						  </div>
						  <div class="col-lg-4 col-md-4 form-group">
						    <label for="partida_electronico">N° Partida Electronica</label>
						    <input type="text" class="form-control" id="partida_electronico" name="partida_electronico">
						  </div>
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
	var ida = "{!!$autorizacion!!}";
</script>
<script type="text/javascript" src="{{asset('js/extranet/reporte/ruta_empresa.js')}}"></script>
@endsection
