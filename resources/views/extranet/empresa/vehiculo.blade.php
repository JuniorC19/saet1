@extends('layouts.extranet')

@section('css')
<link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
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
			<h4 class="page-title">Vehiculos</h4>
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
	  <p class="mb-0"><strong>RUC:</strong> {{$empresa->ruc}}</p>
	  <p class="mb-0">
      <div class="form-group">
        <label for="autorizacion"><strong>Autorizacion</strong></label>
        <select id="autorizacion" name="autorizacion" class="form-control">
          @foreach($autorizacion as $value)
          <option value="{{$value->id}}" data-vehiculos="{{$value->Vehiculos}}" data-estado="{{$value->Cerrar}}">{{$value->Resolucion}} -|- {{$value->Tipo}}</option>
          @endforeach
        </select>
      </div>
    </p>
    <p class="mb-0"><strong>VEHICULOS:</strong> <span class="n_vehiculos"></span>
    @role('Master|Admin|Registro') 
      <button type="button" class="btn btn-danger float-right" id="cerrar" style="display: none;">Cerrar</button>
    @endcan
    </p>
	</div>
</div>
<!-- Page Title Header Ends-->
<div class="row">
  @role('Master|Admin|Registro')
  <div class="col-md-12">
    <div class="card mb-0 border border-success" id="new-add" style="display: none;">
      <div class="card-header">
        <strong>Agregar Vehiculo</strong>
        <div class="float-right">
          <button class="btn btn-primary btn-sm" id="new-vehiculo"><i class="fas fa-plus"></i> Crear Vehiculo</button>
        </div>
      </div>
      <div class="card-body py-3">
        <form id="formularyVehiculo">
          <div class="row">
            <div class="col-8">
              <div class="form-group m-0">
                <select id="vehiculo" name="vehiculo" class="form-control">
                </select>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group m-0">
                <button type="button" class="btn btn-success" id="add-vehiculo"><i class="fas fa-plus"></i> Agregar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endcan
  <div class="col-lg-12">
    
    <div class="card">
      <!-- <div class="card-header bg-white">
        <div class="row">
          <div class="col-md-10">
            <form id="formulary">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <select id="cargo" name="cargo" class="form-control">
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2">
            <a href="{{url('/extranet/postulante/apto/pdf')}}" target="_blank" class="btn btn-primary float-right"><i class="fas fa-download"></i> Exportar PDF</a>
            <button class="btn btn-primary float-right" id="nuevo"><i class="fa fa-plus"></i> Nueva Empresa</button>
          </div>
        </div>
      </div> -->
      <div class="card-body">
        <div class="table-responsive">
		      <table class="table table-hover table-bordered dt-responsive" id="table-data" width="100%" cellspacing="0">
		        <thead>
		          <tr>
		            <th>Opciones</th>
		            <th>Placa</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Año Fabrica</th>
                <th>Resolucion</th>
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
        <form id="formulary">
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
                  <select id="categoria" name="categoria" class="form-control" aria-required="true">
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
                  <select id="marca" name="marca" class="form-control" aria-required="true">
                  </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="fabricacion">Año de Fabricacion</label>
                  <input type="text" id="fabricacion" name="fabricacion" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="modelo">Modelo</label>
                  <input type="text" id="modelo" name="modelo" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="combustible">Combustible</label>
                  <input type="text" id="combustible" name="combustible" class="form-control" aria-required="true">
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
                  <input type="text" id="color" name="color" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_motor">N° de Motor</label>
                  <input type="text" id="n_motor" name="n_motor" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_chasis">N° de Chasis</label>
                  <input type="text" id="n_chasis" name="n_chasis" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_ejes">N° de Ejes</label>
                  <input type="text" id="n_ejes" name="n_ejes" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_cilindros">N° de cilindros</label>
                  <input type="text" id="n_cilindros" name="n_cilindros" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_ruedas">N° de ruedas</label>
                  <input type="text" id="n_ruedas" name="n_ruedas" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_pasajeros">N° de pasajeros</label>
                  <input type="text" id="n_pasajeros" name="n_pasajeros" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_asientos">N° de asientos</label>
                  <input type="text" id="n_asientos" name="n_asientos" class="form-control" aria-required="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                  <label for="peso_neto">Peso Neto</label>
                  <div class="input-group">
                    <input type="text" id="peso_neto" name="peso_neto" class="form-control" aria-required="true">
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
                    <input type="text" id="peso_bruto" name="peso_bruto" class="form-control" aria-required="true">
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
                    <input type="text" id="carga_util" name="carga_util" class="form-control" aria-required="true">
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
                    <input type="text" id="largo" name="largo" class="form-control" aria-required="true">
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
                    <input type="text" id="alto" name="alto" class="form-control" aria-required="true">
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
                    <input type="text" id="ancho" name="ancho" class="form-control" aria-required="true">
                    <div class="input-group-append">
                      <span class="input-group-text">m.</span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="acc_seguridad">Acc de Seguridad</label>
                  <input type="text" id="acc_seguridad" name="acc_seguridad" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_puertas">N° de Puertas</label>
                  <input type="text" id="n_puertas" name="n_puertas" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="tocografo">tocografo</label>
                  <input type="text" id="tocografo" name="tocografo" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="n_salida_emergencia">N° de Salida Emergencia</label>
                  <input type="text" id="n_salida_emergencia" name="n_salida_emergencia" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="reg_seguridad">Reg. Seguridad</label>
                  <input type="text" id="reg_seguridad" name="reg_seguridad" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="limitador_seguridad">Limitador de Seguridad</label>
                  <input type="text" id="limitador_seguridad" name="limitador_seguridad" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label for="sistema_comunicacion">Sistema de Comunicacion</label>
                  <input type="text" id="sistema_comunicacion" name="sistema_comunicacion" class="form-control" aria-required="true">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="observacion">Observacion</label>
                <textarea id="observacion" name="observacion" class="form-control" aria-required="true"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="asignar" name="asignar">
                <label class="custom-control-label text-primary" for="asignar">Asignar Conductor</label>
              </div>
            </div>
          </div>
          <hr class="m-0">
          <div style="display: none;" id="conductor">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="documento">Documento</label>
                  <input type="text" id="documento" name="documento" class="form-control" aria-required="true">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="paterno">paterno</label>
                  <input type="text" id="paterno" name="paterno" class="form-control" aria-required="true">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="materno">materno</label>
                  <input type="text" id="materno" name="materno" class="form-control" aria-required="true">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nombres">nombres</label>
                  <input type="text" id="nombres" name="nombres" class="form-control" aria-required="true">
                </div>
              </div>
            </div>  
            <hr>
            <!-- <h3 class="text-primary">Ubigeo</h3> -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="checkbox" name="editar" value="0" id="editar">
                  <label for="editar"> Editar ubigeo: <span id="nombre_ubigeo" class="font-weight-bold"></span></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="departamento">Departamento:</label>
                    <select class="form-control" id="departamento" name="departamento">
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="provincia">Provincia:</label>
                    <select class="form-control" id="provincia" name="provincia">
                    </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="distrito">Distrito:</label>
                    <select class="form-control" id="distrito" name="distrito">
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="direccion">Direccion</label>
                  <input type="text" id="direccion" name="direccion" class="form-control" aria-required="true">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="cat">cat</label>
                  <select id="cat" name="cat" class="form-control" aria-required="true">
                    <option value="">--Seleccionar--</option> 
                    <option value="A-I">A-I</option> 
                    <option value="AII-a">AII-a</option> 
                    <option value="AII-b">AII-b</option> 
                    <option value="AIII-a">AIII-a</option> 
                    <option value="AIII-b">AIII-b</option> 
                    <option value="AIII-c">AIII-c</option> 
                    <option value="AIV">AIV</option> 
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="estado_licencia">Estado Licencia</label>
                  <select id="estado_licencia" name="estado_licencia" class="form-control" aria-required="true">
                    <option value="1">SI</option> 
                    <option value="0">NO</option> 
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vencimiento">Vencimiento</label>
                  <div class="input-group">
                    <div class="input-group-append">
                      <label for="vencimiento" class="input-group-text"><i class="fa fa-calendar"></i></label>
                    </div>
                    <input type="text" class="form-control datetimepicker-input" id="vencimiento" name="vencimiento">
                  </div>
                </div>
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
<script type="text/javascript" src="{{asset('vendor/select2/select2.min.js')}}"></script>   
<script type="text/javascript" src="{{asset('vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/validator.setDefaults.js')}}"></script>

<script type="text/javascript" src="{{asset('vendor/moment/min/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/moment/locale/es.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.js')}}"></script>

<script type="text/javascript" src="{{asset('vendor/monkeymonk-jquery.loader/jquery.loader.js')}}"></script>

<script type="text/javascript">
	var ide = "{!!$empresa->id!!}";
  var ida = 0;
  var nV = 0;
  var Cerrar = 0;
</script>
<script type="text/javascript" src="{{asset('js/extranet/empresa/vehiculo.js')}}"></script>
@endsection
