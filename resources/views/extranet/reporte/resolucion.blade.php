@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">
@endsection

@section('content')
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<h6 class="text-primary">Datos de la Empresa</h6>
    </div>
	</div>
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-header bg-white">
          <div class="row">
          	<div class="col-lg-4 form-group">
					    <label for="empresa">Empresa</label>
					    <select class="form-control" id="empresa" name="empresa"></select>
					  </div>
					  <div class="col-lg-6 form-group">
					    <label for="autorizacion">Autorizacion</label>
					    <select class="form-control" id="autorizacion" name="autorizacion">
					    	<option value="">--Seleccionar--</option>
					    </select>
					  </div>
           <!--  <div class="col-md-4">
              <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" class="form-control">
                	<option value="">Todo</option>
                	<option value="1">Activo</option>
                	<option value="0">Inactivo</option>
                </select>
              </div>
            </div> -->
            <div class="col-2">
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
			            <th>Empresa</th>
			            <th>Resolucion</th>
			            <th>Tipo</th>
			            <th>FechaIni</th>
			            <!-- <th>Estado</th> -->
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
<script type="text/javascript" src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/jQuery.print.js')}}"></script>

<script type="text/javascript" src="{{asset('js/extranet/reporte/resolucion.js')}}"></script>
@endsection
