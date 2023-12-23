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
      <h4 class="page-title">Renovacion / Modificaciones</h4>
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
                <h6 class="text-muted">{{$resolucion}}-{{$anio}}-{{$config->siglas}} | {{$tipo->nombre}}</h6>
              </div>
            </div>

            <input type="hidden" name="objeto" value="{{$objeto}}">
            <h4 class="text-primary">Rutas</h4>
            <hr class="mt-0">
            <h6 class="text-primary">Activas</h6>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="font-weight-bold"></th>
                  <th class="font-weight-bold">Origen</th>
                  <th class="font-weight-bold">Destino</th>
                  <th class="font-weight-bold">Frecuencia</th>
                  <th class="font-weight-bold" width="200px">Itinerario</th>
                  <th class="font-weight-bold">Resolucion</th>
                </thead>
                <tbody>
                  @foreach($rutas as $key => $value)
                  	<?php 
                  		$itinerario = $value->Itinerario!=NULL?explode("|", $value->Itinerario):array();
                  	 ?>
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_renovacion" id="renovacion{{$key}}" name="renovacion[]" value="{{$value->RowId}}" checked>
                          <label class="custom-control-label" for="renovacion{{$key}}">renovacion</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_ampliacion" id="ampliacion{{$key}}" name="ampliacion[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="ampliacion{{$key}}">ampliacion</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_frecuencia" id="frecuencia{{$key}}" name="m_frecuencia[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="frecuencia{{$key}}">frecuencia</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_itinerario" id="itinerario{{$key}}" name="m_itinerario[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="itinerario{{$key}}">itinerario</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_renuncia" id="renuncia{{$key}}" name="renuncia[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="renuncia{{$key}}">renuncia</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_rutas_activas check_reconsideracion" id="reconsideracion{{$key}}" name="reconsideracion[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="reconsideracion{{$key}}">reconsideracion</label>
                        </div>
                      </td>
                      <td>
                      	<div class="form-group">
		                  		<input type="text" class="form-control origen" name="origen[{{$value->RowId}}]" value="{{$value->Origen}}" 
		                  			required="true" data-msg-required="Este campo es requerido."
		                  		>
		                  	</div>
                      </td>
                      <td>
                      	<div class="form-group">
		                  		<input type="text" class="form-control destino" name="destino[{{$value->RowId}}]" value="{{$value->Destino}}" 
		                  			required="true" data-msg-required="Este campo es requerido."
		                  		>
		                  	</div>
                      </td>
                      <td>
                      	<div class="form-group">
		                  		<input type="text" class="form-control frecuencia" name="frecuencia[{{$value->RowId}}]" value="{{$value->Frecuencia}}" 
		                  			required="true" data-msg-required="Este campo es requerido."
		                  		>
		                  	</div>
                      </td>
                      <td>
                      	<button type="button" class="btn btn-success btn-sm new_itinerario" numero="{{$value->RowId}}" >
							          	<i class="fas fa-plus"></i>Agregar
							          </button>
							          <div class="itinerario">
							          	@foreach($itinerario as $val)
							          	<div class="form-group my-1">
														<div class="input-group input-group-sm">
														  <input type="text" class="form-control name_itinerario" name="itinerario[{{$value->RowId}}][]" value="{{$val}}" 
														  	required="true" data-msg-required="Este campo es requerido."
														  	 
														  >
														  <div class="input-group-append">
														    <button class="btn btn-outline-danger eliminar_itinerario" type="button" ><i class="fas fa-times"></i></button>
														  </div>
														</div>
													</div>
							          	@endforeach
							          </div>
                      </td>
                      <td>{{$value->Resolucion}}</td>
                    </tr>
                  @endforeach  
                </tbody>
              </table>
            </div>
            <h6 class="text-danger">Renunciadas</h6>
            <div class="table-responsive border border-danger">
              <table class="table table-bordered">
                <thead>
                  <th class="font-weight-bold"></th>
                  <th class="font-weight-bold">Origen</th>
                  <th class="font-weight-bold">Destino</th>
                  <th class="font-weight-bold">Frecuencia</th>
                  <th class="font-weight-bold" width="200px">Itinerario</th>
                  <th class="font-weight-bold">Resolucion Renuncia</th>
                </thead>
                <tbody>
                  @foreach($renuncia as $key => $value)
                    <?php 
                      $itinerario = $value->Itinerario!=NULL?explode("|", $value->Itinerario):array();
                     ?>
                    <tr>
                      <td>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input check_habilitar" id="habilitar{{$key}}" name="habilitar[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="habilitar{{$key}}">habilitar</label>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control origen" name="origen[{{$value->RowId}}]" value="{{$value->Origen}}" 
                            required="true" data-msg-required="Este campo es requerido."
                          disabled>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control destino" name="destino[{{$value->RowId}}]" value="{{$value->Destino}}" 
                            required="true" data-msg-required="Este campo es requerido."
                          disabled>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control frecuencia" name="frecuencia[{{$value->RowId}}]" value="{{$value->Frecuencia}}" 
                            required="true" data-msg-required="Este campo es requerido."
                            disabled>
                        </div>
                      </td>
                      <td>
                       <!--  <button type="button" class="btn btn-success btn-sm new_itinerario" numero="{{$value->RowId}}" >
                          <i class="fas fa-plus"></i>Agregar
                        </button> -->
                        <div class="itinerario">
                          @foreach($itinerario as $val)
                          <div class="form-group my-1">
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control name_itinerario" name="itinerario[{{$value->RowId}}][]" value="{{$val}}" 
                                required="true" data-msg-required="Este campo es requerido."
                                disabled 
                              >
                              <!-- <div class="input-group-append">
                                <button class="btn btn-outline-danger eliminar_itinerario" type="button" ><i class="fas fa-times"></i></button>
                              </div> -->
                            </div>
                          </div>
                          @endforeach
                        </div>
                      </td>
                      <td>{{$value->Resolucion}}</td>
                    </tr>
                  @endforeach  
                </tbody>
              </table>
            </div>
            <br><br>
            <h4 class="text-primary">Vehiculos</h4>
            <hr>
            <h6 class="text-primary">Activas</h6>
            <div class="table-responsive">
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
                          <input type="checkbox" class="custom-control-input renova_vehiculo" id="renova{{$key}}" name="renova[]" value="{{$value->RowId}}" checked>
                          <label class="custom-control-label" for="renova{{$key}}">renovacion</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input sustitucion_vehiculo" id="sustitucion{{$key}}" name="sustitucion[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="sustitucion{{$key}}">Sustitucion</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input baja_vehiculo" id="baja{{$key}}" name="baja[]" value="{{$value->RowId}}">
                          <label class="custom-control-label" for="baja{{$key}}">Baja</label>
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

            <h6 class="text-primary">Vehiculos</h6>
            <div class="card border border-success">
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

            <div>
              <div class="table-responsive">
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

<div style="display: none;" id="clon_itinerario">
	<div class="form-group my-1">
		<div class="input-group input-group-sm">
		  <input type="text" class="form-control name_itinerario" name="itinerario[]"
		  	required="true" data-msg-required="Este campo es requerido." 
		  >
		  <div class="input-group-append">
		    <button class="btn btn-outline-danger eliminar_itinerario" type="button"><i class="fas fa-times"></i></button>
		  </div>
		</div>
	</div>
</div>

<table style="display: none;">
  <tbody id="clon">
    <tr>
      <td>
        <button class="btn btn-outline-danger eliminar" type="button"><i class="fas fa-times"></i></button>
        <input type="hidden" name="input_vehiculo[]" class="input_vehiculo">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input sustitucion_entra_vehiculo" id="sustitucion_entra" name="sustitucion_entra[]" value="" checked>
          <label class="custom-control-label sustitucion_label" for="sustitucion_entra">Sustitucion</label>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input incremento_vehiculo" id="incremento" name="incremento[]" value="">
          <label class="custom-control-label imcremento_label" for="incremento">Incremento</label>
        </div>
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
  var ide = "{!!$id!!}";
  var ida = "{!!$idA!!}"
</script>
<script type="text/javascript" src="{{asset('js/extranet/renovacion/modificacion.js')}}"></script>
@endsection
