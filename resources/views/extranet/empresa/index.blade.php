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
			<h4 class="page-title">Empresas</h4>
		</div>
	</div>
</div>
<!-- Page Title Header Ends-->
<div class="container-fluid">
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-header bg-white">
	        <div class="row">
	          <div class="col-md-10">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="tipo">tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                    	<option value="">Todo</option>
                    	@foreach($tipo as $value)
                    	<option value="{{$value->id}}">{{$value->nombre}}</option>
                    	@endforeach
                    </select>
                  </div>
                </div>
	            </div>
	          </div>
	          <div class="col-md-2">
	            <!-- <a href="{{url('/extranet/postulante/apto/pdf')}}" target="_blank" class="btn btn-primary float-right"><i class="fas fa-download"></i> Exportar PDF</a> -->
	            <!-- <button class="btn btn-primary float-right" id="nuevo"><i class="fa fa-plus"></i> Nueva Empresa</button> -->
	          </div>
	        </div>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <th>Opciones</th>
			            <th>Id</th>
			            <th>Razon Social</th>
			            <th>Ruc</th>
			            <th>Telefono</th>
			            <th>R.Primaria</th>
			            <th>N.Registro</th>
			            <th>N.Electronico</th>
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
			    	<div class="row">
              <div class="col-md-12">
                <div class="form-group mb-0">
                  <input type="checkbox" name="editar" value="0" id="editar">
                  <label for="editar"> Editar Resolucion</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
	                <label for="resolucion">Resolucion Primaria</label>
							    <input type="text" class="form-control" id="resolucion" name="resolucion">
                </div>
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
<script type="text/javascript" src="{{asset('js/extranet/empresa/index.js')}}"></script>
@endsection
