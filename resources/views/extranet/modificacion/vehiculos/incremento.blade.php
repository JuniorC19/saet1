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
      <h4 class="page-title">Vehiculo / Incremento</h4>
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
         <form id="formulary" method="GET" action="{{url('/extranet/modificacion/vehiculos/incremento/empresa')}}">
            <h6 class="text-primary">Datos de la Empresa</h6>
            <div class="row">
              <div class="col-lg-12 form-group">
                <label for="empresa">Empresa</label>
                <select class="form-control" id="empresa" name="empresa"></select>
              </div>
              <div class="col-lg-12 form-group">
                <label for="autorizacion">Autorizacion</label>
                <select class="form-control" id="autorizacion" name="autorizacion">
                  <option value="">--Seleccionar--</option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row justify-content-md-center">
                <button class="btn btn-lg col-md-6 btn-primary" type="submit" id="guardar" style="font-size: 20px">Siguiente</button>
            </div>
          </form>
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
<script type="text/javascript" src="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.js')}}"></script>

<script type="text/javascript" src="{{asset('js/extranet/modificacion/vehiculos/incremento.js')}}"></script>
@endsection
