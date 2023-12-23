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
              <div class="col-lg-12 form-group">
                <h4>{{$empresa->ruc}} | {{$empresa->razon_social}}</h4>
                <h6 class="text-muted">{{$empresa->Tipo}} | {{$empresa->Numero}}</h6>
              </div>
            </div>
            <hr class="mt-0">
            <h6 class="text-primary">Resolucion</h6>
            <div class="row">
              <div class="col-lg-6 col-md-12 form-group">
                <label for="resolucion">N° Resolucion</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="resolucion" name="resolucion">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">-</span>
                  </div>
                  <input type="text" class="form-control" id="anio" name="anio" value="{{date('Y')}}">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">-{{$config->siglas}}</span>
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
						    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
						  </div>
			    	</div>

			    	<h6 class="text-primary">Vehiculos Activos</h6>
			    	<div class="table-responsive border border-primary">
              <table class="table table-bordered">
                <thead>
                  <th class="font-weight-bold"></th>
                  <th class="font-weight-bold">Placa</th>
                  <th class="font-weight-bold">Marca</th>
                  <th class="font-weight-bold">Categoria</th>
                  <th class="font-weight-bold">Fabricacion</th>
                  <th class="font-weight-bold">Resolucion</th>
                </thead>
                <tbody>
                  @foreach($vehiculos as $key => $value)
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_vehiculo" id="check{{$key}}" name="vehiculos[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="check{{$key}}">Sustituir</label>
                        </div>
                      </td>
                      <td>{{$value->Placa}}</td>
                      <td>{{$value->Marca}}</td>
                      <td>{{$value->Categoria}}</td>
                      <td>{{$value->Fabricacion}}</td>
                      <td>{{$value->Resolucion}}</td>
                    </tr>
                  @endforeach  
                </tbody>
              </table>
            </div>
            <button type="button" id="plus-vehiculo-inactivos" class="btn btn-link"><i class="fas fa-plus"></i> Mostrar vehiculos Inactivos</button>
            <div class="table-responsive border border-danger" id="vehiculo-inactivos" style="display: none;">
              <table class="table table-bordered">
                <tbody>
                  @foreach($inactivos as $key => $value)
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_vehiculo check_vehiculo_i" id="check_i{{$key}}" name="vehiculos[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="check_i{{$key}}">Sustituir</label>
                        </div>
                      </td>
                      <td>{{$value->Placa}}</td>
                      <td>{{$value->Marca}}</td>
                      <td>{{$value->Categoria}}</td>
                      <td>{{$value->Fabricacion}}</td>
                      <td>{{$value->Resolucion}}</td>
                    </tr>
                  @endforeach  
                </tbody>
              </table>
            </div>
            <button type="button" id="remove-vehiculo-inactivos" class="btn btn-link" style="display: none;"><i class="fas fa-minus"></i> Ocultar vehiculos Inactivos</button>
            <br>
		        <div class="card border border-success" id="add-vehiculo" style="display: none">
			        <div class="card-header py-1 pr-0">
			          <strong>Agregar Vehiculo</strong>
			          <div class="float-right">
			            <button type="button" class="btn btn-success btn-sm" id="new-vehiculo"><i class="fas fa-plus"></i> Crear Vehiculo</button>
			          </div>
			        </div>
			        <div class="card-body py-3">
		            <div class="row">
		              <div class="col-md-12">
		                <div class="form-group m-0">
		                  <select id="vehiculo" name="vehiculo" class="form-control">
		                  </select>
		                </div>
		              </div>
		            </div>
			        </div>
			      </div>

			      <h6 class="text-success">Vehiculos Entran Sustitucion</h6>
			    	<div>
			    		<div class="table-responsive border border-success">
					      <table class="table table-hover table-bordered">
					        <thead>
					          <tr>
					            <th></th>
					            <th>Placa</th>
		                  <th>Marca</th>
		                  <th>Categoria</th>
		                  <th>Año Fabrica</th>
					          </tr>
					        </thead>
					        <tbody  id="vehiculos">
					        	<tr>
					        	</tr>
					        </tbody>
					      </table>
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
<table style="display: none;">
	<tbody id="clon">
		<tr>
			<td>
				<button class="btn btn-outline-danger eliminar" type="button"><i class="fas fa-times"></i></button>
				<input type="hidden" name="input_vehiculo[]" class="input_vehiculo">
			</td>
			<td class="placa">0025-545</td>
			<td class="marca">Mercedes bez</td>
			<td class="categoria">M2</td>
			<td class="anio">2016</td>
		</tr>
	</tbody>
</table>

<!-- moddlas -->
<div class="modal fade" id="modal-datatable" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title-datatable">Vehiculo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formularyVehiculo">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="placa">Placa</label>
                <input type="text" id="placa" name="placa" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="fecha">Fecha Inscripcion</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <label for="fecha" class="input-group-text"><i class="fa fa-calendar"></i></label>
                  </div>
                  <input type="text" class="form-control datetimepicker-input" id="fecha" name="fecha">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  <label for="categoria">Categoria</label>
                  <select id="categoria" name="categoria" class="form-control">
                    <option value="">--Seleccionar--</option>
                    @foreach($categoria as $value)
                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="marca">Marca</label>
                  <select id="marca" name="marca" class="form-control">
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="fabricacion">Año de Fabricacion</label>
                  <input type="text" id="fabricacion" name="fabricacion" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="modelo">Modelo</label>
                  <input type="text" id="modelo" name="modelo" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="combustible">Combustible</label>
                  <input type="text" id="combustible" name="combustible" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="carroceria">Carroceria</label>
                  <select id="carroceria" name="carroceria" class="form-control">
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="color">Color</label>
                  <input type="text" id="color" name="color" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_motor">N° de Motor</label>
                  <input type="text" id="n_motor" name="n_motor" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_chasis">N° de Chasis</label>
                  <input type="text" id="n_chasis" name="n_chasis" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_ejes">N° de Ejes</label>
                  <input type="text" id="n_ejes" name="n_ejes" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_cilindros">N° de cilindros</label>
                  <input type="text" id="n_cilindros" name="n_cilindros" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_ruedas">N° de ruedas</label>
                  <input type="text" id="n_ruedas" name="n_ruedas" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_pasajeros">N° de pasajeros</label>
                  <input type="text" id="n_pasajeros" name="n_pasajeros" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_asientos">N° de asientos</label>
                  <input type="text" id="n_asientos" name="n_asientos" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  <label for="peso_neto">Peso Neto</label>
                  <div class="input-group">
                    <input type="text" id="peso_neto" name="peso_neto" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">Kg.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="peso_bruto">Peso Bruto</label>
                  <div class="input-group">
                    <input type="text" id="peso_bruto" name="peso_bruto" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">Kg.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="carga_util">Carga Util</label>
                  <div class="input-group">
                    <input type="text" id="carga_util" name="carga_util" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">Kg.</span>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  <label for="largo">Largo</label>
                  <div class="input-group">
                    <input type="text" id="largo" name="largo" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">m.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="alto">Alto</label>
                  <div class="input-group">
                    <input type="text" id="alto" name="alto" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">m.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="ancho">Ancho</label>
                  <div class="input-group">
                    <input type="text" id="ancho" name="ancho" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">m.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="acc_seguridad">Acc de Seguridad</label>
                  <input type="text" id="acc_seguridad" name="acc_seguridad" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_puertas">N° de Puertas</label>
                  <input type="text" id="n_puertas" name="n_puertas" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="tocografo">tocografo</label>
                  <input type="text" id="tocografo" name="tocografo" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_salida_emergencia">N° de Salida Emergencia</label>
                  <input type="text" id="n_salida_emergencia" name="n_salida_emergencia" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="reg_seguridad">Reg. Seguridad</label>
                  <input type="text" id="reg_seguridad" name="reg_seguridad" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="limitador_seguridad">Limitador de Seguridad</label>
                  <input type="text" id="limitador_seguridad" name="limitador_seguridad" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="sistema_comunicacion">Sistema de Comunicacion</label>
                  <input type="text" id="sistema_comunicacion" name="sistema_comunicacion" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <label for="observacion">Observacion</label>
                  <textarea id="observacion" name="observacion" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="guardarVehiculo">Guardar</button>
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
<script type="text/javascript">
  var ide = "{!!$empresa->id!!}";
  var ida = "{!!$empresa->idA!!}"
</script>
<script type="text/javascript" src="{{asset('js/extranet/modificacion/vehiculos/sustitucion_empresa.js')}}"></script>
@endsection
