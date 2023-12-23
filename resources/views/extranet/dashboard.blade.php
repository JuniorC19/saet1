@extends('layouts.extranet')
@section('css')
<link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.css')}}">
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
      <div class="bg-primary p-10 text-white text-center">
         <i class="fa fa-building m-b-5 font-20"></i>
         <h3 class="m-b-0 m-t-5">{{$empresa}}</h3>
         <h5 class="font-light">Empresas</h5>
      </div>
    </div>
    <div class="col-md-3">
      <div class="bg-success p-10 text-white text-center">
         <i class="mdi mdi-file-check m-b-5 font-20"></i>
         <h3 class="m-b-0 m-t-5">{{$autorizacion}}</h3>
         <h5 class="font-light">Autorizaciones</h5>
      </div>
    </div>
    <div class="col-md-3">
      <div class="bg-danger p-10 text-white text-center">
         <i class="mdi mdi-car m-b-5 font-20"></i>
         <h3 class="m-b-0 m-t-5">{{$vehiculo}}</h3>
         <h5 class="font-light">Vehiculos</h5>
      </div>
    </div>
    <div class="col-md-3">
      <div class="bg-info p-10 text-white text-center">
         <i class="mdi mdi-road-variant m-b-5 font-20"></i>
         <h3 class="m-b-0 m-t-5">{{$ruta}}</h3>
         <h5 class="font-light">Rutas</h5>
      </div>
    </div>
	</div>
  @role('Master|Admin|Reporte')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-white">
          <h5 class="text-primary">Reporte Semanal</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_semana">Fecha</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <label for="fecha_semana" class="input-group-text"><i class="fa fa-calendar"></i></label>
                  </div>
                  <input type="text" class="form-control datetimepicker-input" id="fecha_semana" name="fecha_semana" value="{{date('Y-m-d')}}" data-target="#fechaSemana"/>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="usuario">Usuario</label>
                <select class="form-control" id="usuario" name="usuario">
                  @foreach($user as $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <button class="btn btn-primary mt-4" id="enviarSemana">Enviar</button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th></th>
                  <th>Lu <span class="f_1"></span></th>
                  <th>Ma <span class="f_2"></span></th>
                  <th>Mi <span class="f_3"></span></th>
                  <th>Ju <span class="f_4"></span></th>
                  <th>Vi <span class="f_5"></span></th>
                  <th>Sa <span class="f_6"></span></th>
                  <th>Do <span class="f_7"></span></th>
                </thead>
                <tbody>
                  <th scope="row">Ordenes</th>
                  <td><span class="total_1">0</span></td>
                  <td><span class="total_2">0</span></td>
                  <td><span class="total_3">0</span></td>
                  <td><span class="total_4">0</span></td>
                  <td><span class="total_5">0</span></td>
                  <td><span class="total_6">0</span></td>
                  <td><span class="total_7">0</span></td>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 table-responsive">
              <table class="table table-bordered">
                <tbody>
                  <th scope="row">Cantidad Total</th>
                  <td><span class="totalSemana">0</span></td>
                </tbody>
              </table>
            </div>
          </div>  
        </div>  
      </div>
    </div>
  </div>
  @endcan
</div>
<div class="container-fluid">
  
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('vendor/moment/min/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/moment/locale/es.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js')}}"></script>
<!-- <script type="text/javascript" src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script> -->
<script type="text/javascript" src="{{asset('js/extranet/dashboard.js')}}"></script>
@endsection