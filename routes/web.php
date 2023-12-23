<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('web.inicio');
    // return view('welcome');
    // return redirect('/login');
});
Route::get('/vehiculo', 'Web\ConsultaController@consulta');


Auth::routes();
Route::get('/register',function(){
  return redirect('/');
});
Route::get('/password/reset',function(){
  return redirect('/');
});
Route::get('/home',function(){
	if(Auth::check()) {
        return redirect('/extranet/dashboard');
        // dd(Auth::user());
    }else{
        // echo "login sin administradores";
        return redirect('/');
    }
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'extranet'], function () {
		Route::get('/select/autorizacion/{id}', 'Extranet\AutorizacionController@select');
		Route::get('/select2/vehiculo', 'Extranet\VehiculoController@select2');
		Route::get('/select2/empresa', 'Extranet\EmpresaController@select2');
		Route::get('/select2/marca', 'Extranet\MarcaController@select2');
		Route::get('/select2/carroceria', 'Extranet\CarroceriaController@select2');

		Route::get('/select2departamento','Extranet\UbigeoController@select2departamento');
		Route::get('/select2provincia','Extranet\UbigeoController@select2provincia');
		Route::get('/select2distrito','Extranet\UbigeoController@select2distrito');

		Route::get('/dashboard', 'Extranet\InicioController@index');
		Route::get('/semana/{id}', 'Extranet\InicioController@semana');
		Route::get('/search', 'Extranet\InicioController@search');

		Route::group(['middleware' => ['role:Master|Admin|Registro|Practicante']], function () {	

			Route::resource('/empresa','Extranet\EmpresaController');
			Route::resource('/ruta','Extranet\RutasController');
			Route::resource('/vehiculo','Extranet\VehiculoController');
			Route::get('/vehiculo/historial/{id}','Extranet\VehiculoController@historial');
			Route::resource('/terminal','Extranet\TerminalController');
			Route::resource('/oficina','Extranet\OficinaController');
			Route::resource('/gerente','Extranet\GerenteController');
			Route::get('/empresacreate/create','Extranet\EmpresaController@create');

			Route::get('/empresa/ruta/{id}','Extranet\EmpresaController@ruta');
			Route::get('/empresa/vehiculo/{id}','Extranet\EmpresaController@vehiculo');
			Route::put('/empresa/add_vehiculo/{id}','Extranet\EmpresaController@add_vehiculo');
			Route::get('/empresa/vehiculo/pdftuc/{id}','Extranet\VehiculoController@pdf');
			Route::get('/empresa/vehiculo/qrtuc/{id}','Extranet\VehiculoController@qr');

			Route::get('/empresa/terminal/{id}','Extranet\EmpresaController@terminal');
			Route::get('/empresa/oficina/{id}','Extranet\EmpresaController@oficina');
			Route::get('/empresa/gerente/{id}','Extranet\EmpresaController@gerente');
		});
		Route::group(['middleware' => ['role:Master|Admin|Registro']], function () {

			Route::put('/autorizacion/cerrar/{id}','Extranet\AutorizacionController@cerrar');

			Route::resource('/autorizacion','Extranet\AutorizacionController');

			Route::get('/autorizacioncreate/create','Extranet\AutorizacionController@create');

			Route::get('/renovacion','Extranet\RenovacionController@index');
			Route::get('/renovacion/create','Extranet\RenovacionController@create');
			Route::get('/renovacion/modificacion','Extranet\RenovacionController@modificacion');
			Route::post('/renovacion','Extranet\RenovacionController@store');

			Route::group(['prefix' => 'modificacion'], function () {
				Route::group(['prefix' => 'rutas'], function () {
					Route::get("/ampliacion",'Extranet\ModificacionController@ampliacion');
					Route::get("/ampliacion/empresa",'Extranet\ModificacionController@ampliacion_empresa');
					Route::post("/ampliacion/save",'Extranet\ModificacionController@ampliacion_store');

					Route::get("/frecuencia",'Extranet\ModificacionController@frecuencia');
					Route::get("/frecuencia/empresa",'Extranet\ModificacionController@frecuencia_empresa');
					Route::post("/frecuencia/save",'Extranet\ModificacionController@frecuencia_store');

					Route::get("/itinerario",'Extranet\ModificacionController@itinerario');
					Route::get("/itinerario/empresa",'Extranet\ModificacionController@itinerario_empresa');
					Route::post("/itinerario/save",'Extranet\ModificacionController@itinerario_store');

					Route::get("/renuncia",'Extranet\ModificacionController@renuncia');
					Route::get("/renuncia/empresa",'Extranet\ModificacionController@renuncia_empresa');
					Route::post("/renuncia/save",'Extranet\ModificacionController@renuncia_store');

					Route::get("/reconsideracion",'Extranet\ModificacionController@reconsideracion');
					Route::get("/reconsideracion/empresa",'Extranet\ModificacionController@reconsideracion_empresa');
					Route::post("/reconsideracion/save",'Extranet\ModificacionController@reconsideracion_store');

				});
				Route::group(['prefix' => 'vehiculos'], function () {
					Route::get("/sustitucion",'Extranet\ModificacionController@sustitucion');
					Route::get("/sustitucion/empresa",'Extranet\ModificacionController@sustitucion_empresa');
					Route::post("/sustitucion/save",'Extranet\ModificacionController@sustitucion_store');

					Route::get("/incremento",'Extranet\ModificacionController@incremento');
					Route::get("/incremento/empresa",'Extranet\ModificacionController@incremento_empresa');
					Route::get("/incremento/verificar",'Extranet\ModificacionController@verificar');
					Route::post("incremento/save",'Extranet\ModificacionController@incremento_store');
					
					Route::get("/baja",'Extranet\ModificacionController@baja');
					Route::get("/baja/empresa",'Extranet\ModificacionController@baja_empresa');
					Route::post("/baja/save",'Extranet\ModificacionController@baja_store');
				});
			});
		});
		
		Route::group(['middleware' => ['role:Master|Admin|Reporte']], function () {
			Route::group(['prefix' => 'reporte'], function () {
				Route::get('/vehiculo','Extranet\ReporteController@vehiculo');
				Route::get('/vehiculo/empresa','Extranet\ReporteController@vehiculo_empresa');
				Route::get('/ruta','Extranet\ReporteController@ruta');
				Route::get('/ruta/empresa','Extranet\ReporteController@ruta_empresa');
				Route::get('/resolucion','Extranet\ReporteController@resolucion');
			});
		});

		Route::group(['middleware' => ['role:Master|Admin']], function () {
			Route::group(['prefix' => 'configuracion'], function () {
				Route::resource('/categoria','Extranet\CategoriaController');
				Route::resource('/marca','Extranet\MarcaController');
				Route::resource('/carroceria','Extranet\CarroceriaController');
			});
		});
		
		Route::group(['middleware' => ['role:Master']], function () {
			Route::resource('/usuario', 'Extranet\UsuarioController');
		});

		Route::get('/usuario/datos/perfil', 'Extranet\UsuarioController@perfil');
		Route::put('/usuario/save/perfil', 'Extranet\UsuarioController@perfil_save');
	});
});