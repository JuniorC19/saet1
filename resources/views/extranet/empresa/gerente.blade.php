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
			<h4 class="page-title">Gerentes</h4>
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
	  <p class="mb-0">RUC: {{$empresa->ruc}}</p>
	</div>
</div>
<!-- Page Title Header Ends-->
<div class="container-fluid">
	<div class="row">
	  <div class="col-lg-12">
	    <div class="card">
	      <div class="card-header bg-white">
	        <div class="float-right">
	        	<button class="btn btn-primary float-right" id="nuevo"><i class="fa fa-plus"></i> Nueva Gerente</button>
	        </div>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
			      <table class="table table-hover table-bordered dt-responsive" id="table-data" width="100%" cellspacing="0">
			        <thead>
			          <tr>
			            <th>Opciones</th>
			            <th>Documento</th>
			            <th>Apellidos</th>
			            <th>Nombres</th>
			            <th>Telefono</th>
			            <th>Direccion</th>
                  <th>Email</th>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-datatable"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formulary">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="documento">Documento</label>
                  <input type="text" id="documento" name="documento" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                  <label for="paterno">Apellido Paterno</label>
                  <input type="text" id="paterno" name="paterno" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="materno">Apellido Materno</label>
                  <input type="text" id="materno" name="materno" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="nombres">Nombres</label>
                  <input type="text" id="nombres" name="nombres" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                  <label for="telefono">Telefono</label>
                  <input type="text" id="telefono" name="telefono" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" id="email" name="email" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="direccion">Direccion</label>
                  <input type="text" id="direccion" name="direccion" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-12">
          		<label for="activo">Activo</label>
		            <div class="custom-control custom-checkbox mr-sm-2">
	                <input type="checkbox" class="custom-control-input" id="activo" name="activo">
	                <label class="custom-control-label" for="activo">Gerente en activadad</label>
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

<script type="text/javascript">
	var ide = "{!!$empresa->id!!}";
</script>
<script type="text/javascript" src="{{asset('js/extranet/empresa/gerente.js')}}"></script>
@endsection
