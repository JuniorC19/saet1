<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/web/consulta.css')}}">
</head>
<body>
	@if($status==true)
	<div class="main-content">
    <div class="header pb-8 pt-lg-8 d-flex align-items-center" style="background-image: url({{asset('img/mtc/fondo.jpg')}}); background-size: cover; background-position: center top;">
      <span class="mask bg-gradient-default opacity-8"></span>
      <div class="container-fluid">
    		<div class="row justify-content-md-center">
    			<div class="col text-center">
    				<h2 class="text-white">" {{$empresa->Ruc}} - {{$empresa->Nombre}} "</h2>
    				<h3 class="text-white">{{$resolucion->Resolucion}}. {{$resolucion->FechaIni}} al {{$resolucion->FechaFin}}</h3>
    			</div>	
    		</div>
        <div class="row">
          <div class="col-lg-12 col-md-12">
              <h1 class="display-2 text-white">Placa : {{$vehiculo->placa}} 
                @if($resolucion->Estado==1)
                <span class="badge badge-success d-inline" style="font-size: 20px">Activo</span>
                @else
                <span class="badge badge-danger d-inline" style="font-size: 20px">Inactivo</span>
                @endif
              </h1>
              <p class="text-white mt-0 mb-5">Color : {{$vehiculo->color}}</p>
              <a href="{{url('/')}}" class="btn btn-warning btn-lg">Realizar nueva consulta</a>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
        		<div class="col-xl-8">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Mas datos del Vehiculo</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      <h6 class="heading-small text-muted mb-4">User information</h6>
                      <div class="pl-lg-4">
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group focused">
                                <label class="form-control-label">Categoria</label>
                                <p>{{$vehiculo->Categoria}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Marca</label>
                                <p>{{$vehiculo->Marca}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Año de Fabricacion</label>
                                <p>{{$vehiculo->fabricacion}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Modelo</label>
                                <p>{{$vehiculo->modelo}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Combustible</label>
                                <p>{{$vehiculo->combustible}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Carroceria</label>
                                <p>{{$vehiculo->carroceria}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Color</label>
                                <p>{{$vehiculo->color}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Motor</label>
                                <p>{{$vehiculo->n_motor}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Chasis</label>
                                <p>{{$vehiculo->n_chasis}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N de Ejes</label>
                                <p>{{$vehiculo->n_ejes}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Cilindros</label>
                                <p>{{$vehiculo->n_cilindros}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Ruedas</label>
                                <p>{{$vehiculo->n_ruedas}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Pasajeros</label>
                                <p>{{$vehiculo->n_pasajeros}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">N° de Asientos</label>
                                <p>{{$vehiculo->n_asientos}}</p>
                              </div>
                            </div>

                          </div>
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Peso Neto</label>
                                <p>{{$vehiculo->peso_neto}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Peso Bruto</label>
                                <p>{{$vehiculo->peso_bruto}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Carga Uitil</label>
                                <p>{{$vehiculo->carga_util}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Largo</label>
                                <p>{{$vehiculo->largo}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Alto</label>
                                <p>{{$vehiculo->alto}}</p>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                              <div class="form-group">
                                <label class="form-control-label">Ancho</label>
                                <p>{{$vehiculo->ancho}}</p>
                              </div>
                            </div>
                          </div>
                      </div>
                      <hr class="my-4">
                      <h6 class="heading-small text-muted mb-4">Observacion</h6>
                      <div class="pl-lg-4">
                          <div class="form-group focused">
                          	<p>{{$vehiculo->observacion}}</p>
                              <!-- <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea> -->
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card card-profile shadow">
                    <div class="card-header bg-white border-0">
                         <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Rutas</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary pt-0 pt-md-4">
                      <div class="list-group">
                      	@foreach($rutas as $value)
											  <div class="list-group-item list-group-item-action">
											    <div class="d-flex w-100 justify-content-between">
											      <h4 class="mb-1 text-primary">{{$value->Origen}} - {{$value->Destino}}</h4>
											      <small class="font-weight-bold" style="font-size: 11px">{{$value->Frecuencia}}</small>
											    </div>
											    <p class="mb-1" style="font-size: 13px">{{$value->Itinerario}}</p>
											  </div>
											  @endforeach
											</div>
                      <!-- <div class="text-center">
                          <h3>
                              Jessica Jones<span class="font-weight-light">, 27</span>
                          </h3>
                          <div class="h5 font-weight-300">
                              <i class="ni location_pin mr-2"></i>Bucharest, Romania
                          </div>
                          <div class="h5 mt-4">
                              <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                          </div>
                          <div>
                              <i class="ni education_hat mr-2"></i>University of Computer Science
                          </div>
                          <hr class="my-4">
                          <p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.</p>
                          <a href="#">Show more</a>
                      </div> -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
	</div>
	@else
	<div class="main-content">
    <div class="header pb-8 pt-lg-8-false d-flex align-items-center" style="height: 500px;background-image: url({{asset('img/mtc/fondo.jpg')}}); background-size: cover; background-position: center top;">
      <span class="mask bg-gradient-default opacity-8"></span>
      <div class="container-fluid">
    		<div class="row justify-content-md-center">
    			<div class="col-12 text-center">
    				<div class="alert alert-warning" role="alert">
    					<h2>La numero de placa: {{$placa}}</h2>
    					<h2><strong>No se encuentra registrada.</strong></h2>
    					
						</div>
    			</div>	
    			<div class="col-12 text-center">
    				<a href="{{url('/')}}" class="btn btn-success btn-lg">Realizar nueva consulta</a>
    			</div>
    		</div>
      </div>
    </div>
	@endif
<!-- <footer class="footer">
  <div class="row align-items-center justify-content-xl-between">
    <div class="col-xl-6 m-auto text-center">
      <div class="copyright">
      	<p>Made with <a href="https://www.creative-tim.com/product/argon-dashboard" target="_blank">Argon Dashboard</a> by Creative Tim</p>
      </div>
    </div>
  </div>
</footer> -->
<script type="text/javascript" src="{{asset('js/web/inicio.js')}}"></script>
</body>
</html>
