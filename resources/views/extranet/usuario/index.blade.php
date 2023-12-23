@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/jquery-confirm2/dist/jquery-confirm.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.css')}}">
<style type="text/css">
  .hidden_checkbox{
    display: none;
  }
</style>
@endsection

@section('content')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">Usuarios</h4>
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
	          </div>
	          <div class="col-md-2">
	            <button class="btn btn-primary float-right" id="nuevo"><i class="fa fa-plus"></i> Nuevo Usuario</button>
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
		            <th>Nombre</th>
		            <th>Usuario</th>
		            <th>Rol</th>
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
        <h5 class="modal-title" id="title-datatable">Modal</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formulary">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" id="nombre" name="nombre" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="user">Usuario</label>
                  <input type="text" id="user" name="user" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label for="password">Contraseña <input type="checkbox" name="edit_pass" id="edit_pass"></label>
                  <input type="text" id="password" name="password" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="rol">Rol</label>
                  <select id="rol" name="rol"  class="form-control" aria-required="true">
                    @foreach($roles as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
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
<script type="text/javascript" src="{{asset('js/extranet/usuario/index.js')}}"></script>
@endsection
