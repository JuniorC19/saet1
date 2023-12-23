<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Crypt;
use App\Models\Autorizacion;
use App\Models\Resolucion;

use App\Models\Ruta;
use App\Models\Itinerario;
use App\Models\ResolucionRuta;
use App\Models\ResolucionVehiculo;

class RenovacionController extends Controller
{
    public function index(){
    	return view("extranet.renovacion.index");
    }
    public function create(Request $request)
    {
    	$response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo",
                            "t.id as IdTipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();
		$response["config"] = DB::table("config")
                        ->first();
        $response["tipo"] = DB::table("tipo")
                        ->get();
        return view("extranet.renovacion.create",$response);  
    }
    public function modificacion(Request $request){
        // dd($request);
        $response["empresa"] = DB::table("empresa")
                    ->where("id",$request->empresa)
                    ->first();
         $response["tipo"] = DB::table("tipo")
                    ->where("id",$request->tipo)
                    ->first();
        $response["config"] = DB::table("config")
                        ->first();
        $response["resolucion"] = $request->resolucion;
        $response["anio"] = $request->anio;

        $response["categoria"] = DB::table("categoria")
                            ->get(); 
        $response["id"] = $request->empresa;   
        $response["idA"] = $request->autorizacion;

        $objeto = new \stdClass();
        $objeto->anio = $request->anio;
        $objeto->autorizacion = $request->autorizacion;
        $objeto->descripcion = $request->descripcion;
        $objeto->empresa = $request->empresa;
        $objeto->fecha_ini = $request->fecha_ini;
        $objeto->fecha_fin = $request->fecha_fin;
        $objeto->resolucion = $request->resolucion;
        // $objeto->rutas = $request->rutas;
        $objeto->tipo = $request->tipo;
        // $objeto->vehiculos = $request->vehiculos;
        // dd($objeto);

        $response["objeto"] = Crypt::encrypt(json_encode($objeto));

        $response["rutas"] = DB::table("ruta as r")
                        ->select(
                            "r.id as RowId",
                            "r.origen as Origen",
                            "r.destino as Destino",
                            "r.frecuencia as Frecuencia",
                            DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ' | ')
                                    FROM itinerario as  i
                                    WHERE i.id_ruta = r.id
                                    GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario"),
                            "re.numero as Resolucion"
                        )
                        ->leftJoin("resolucion_ruta as rr","rr.id_ruta","r.id")
                        ->Join("resolucion as re","re.id","rr.id_resolucion")
                        ->where("rr.estado",1)
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();
        $response["renuncia"] = DB::table("ruta as r")
                        ->select(
                            "r.id as RowId",
                            "r.origen as Origen",
                            "r.destino as Destino",
                            "r.frecuencia as Frecuencia",
                            DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ' | ')
                                    FROM itinerario as  i
                                    WHERE i.id_ruta = r.id
                                    AND i.estado = 1
                                    GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario"),
                            "re.numero as Resolucion"
                        )
                        ->leftJoin("resolucion_ruta as rr","rr.id_ruta","r.id")
                        ->Join("resolucion as re","re.id","rr.id_resolucion_afectado")
                        ->where("rr.estado",0)
                        ->where("rr.renuncia",1)
                        ->where("re.tipo",4)
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();
        $response["vehiculos"] = DB::table("vehiculo as v")
                        ->select(
                            "v.id as RowId",
                            "v.placa as Placa",
                            "m.nombre as Marca",
                            "c.nombre as Categoria",
                            "v.fabricacion as Fabricacion",
                            "re.numero as Resolucion"
                        )
                        ->leftJoin("marca as m","m.id","v.id_marca")
                        ->leftJoin("categoria as c","c.id","v.id_categoria")
                        ->join('resolucion_vehiculo as rv', function ($join) {
                            $join->on('rv.id_vehiculo', '=', 'v.id')
                                    ->where("rv.estado",1);
                        })
                        ->Join("resolucion as re","re.id","rv.id_resolucion")
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();

        

            // if(isset($request->autorizacion)):
            //     $response = $response->where('a.id',$request->autorizacion);
            // endif;

            // $response = $response->get();
        // dd($response);
        return view("extranet.renovacion.modificacion",$response);

    }
    public function store(Request $request){
        // dd($request->objeto);
    	// dd($request);
    	DB::beginTransaction();
        try {
            $objeto =json_decode(Crypt::decrypt($request->objeto));
            $id_users = Auth::user()->id;
        	DB::table("autorizacion")
        		->where("id",$objeto->autorizacion)
        		->update([
        			"estado"=>0,
                    "id_users"=>$id_users
        		]);
        	DB::table("resolucion")
        		->where("id_autorizacion",$objeto->autorizacion)
        		->update([
        			"estado"=>0,
                    "id_users"=>$id_users
        		]);

        	DB::table("resolucion_ruta as rr")
        		->join("resolucion as re","re.id","rr.id_resolucion")
        		->where("re.id_autorizacion",$objeto->autorizacion)
        		->update([
        			"rr.estado"=>0,
                    "rr.id_users"=>$id_users
        		]);
        	DB::table("resolucion_vehiculo as rv")
        		->join("resolucion as re","re.id","rv.id_resolucion")
        		->where("re.id_autorizacion",$objeto->autorizacion)
        		->update([
        			"rv.estado"=>0,
                    "rv.id_users"=>$id_users
        		]);

            $config = DB::table("config")
                        ->first();
            $numero = $objeto->resolucion."-".$objeto->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $objeto->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d');

            $temp_fin = \DateTime::createFromFormat('d/m/Y', $objeto->fecha_fin);
            $date_fin = $temp_fin->format('Y-m-d');

            $autorizacion = new Autorizacion;
            $autorizacion->numero = $numero;
            $autorizacion->fecha_ini = $date_ini;
            $autorizacion->fecha_fin = $date_fin;
            // $autorizacion->rutas = $objeto->rutas;
            // $autorizacion->vehiculos = $objeto->vehiculos;
            $autorizacion->descripcion = $objeto->descripcion;
            $autorizacion->id_empresa = $objeto->empresa;
            $autorizacion->id_tipo = $objeto->tipo;
            $autorizacion->id_users = $id_users;
            $autorizacion->save();

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha_fin = $date_fin;
            // $resolucion->rutas = $objeto->rutas;
            // $resolucion->vehiculos = $objeto->vehiculos;
            $resolucion->descripcion = $objeto->descripcion;
            $resolucion->id_empresa = $objeto->empresa;
            $resolucion->id_autorizacion = $autorizacion->id;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            $count_ruta = 0;
            $count_vehi = 0;
            if(isset($request->renovacion)){

                foreach ($request->renovacion as $value) {
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->origen[$value];
                    $ruta->frecuencia = $request->origen[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->save();

                    $count_ruta++;
                }
            }

            if(isset($request->ampliacion)){
                foreach ($request->ampliacion as $key => $value) {
                    // echo $key."<br>";
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->comentario = "AMPLIACION";
                    $r_ruta->save();

                    $count_ruta++;
                }
            }

            if(isset($request->m_frecuencia)){
                foreach ($request->m_frecuencia as $key => $value) {

                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();
                    // dd($itinerario);
                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->comentario = "FRECUENCIA";
                    $r_ruta->save();

                    $count_ruta++;
                }
            }
            if(isset($request->m_itinerario)){
                foreach ($request->m_itinerario as $key => $value) {
                    // echo $key."<br>";
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->comentario = "ITINERARIO";
                    $r_ruta->save();

                    $count_ruta++;
                }
            }
            if(isset($request->renuncia)){
                foreach ($request->renuncia as $key => $value) {
                    // echo $key."<br>";
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->comentario = "RENUNCIA";
                    $r_ruta->save();

                    $count_ruta++;
                }
            }

            if(isset($request->reconsideracion)){
                foreach ($request->reconsideracion as $key => $value) {
                    // echo $key."<br>";
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->estado = 0;
                    $r_ruta->renuncia = 1;
                    $r_ruta->comentario = "RECONSIDERACION SALE";
                    $r_ruta->save();
                }

                foreach ($request->habilitar as $key => $value) {
                    // echo $key."<br>";
                    $ruta = new Ruta;
                    $ruta->origen = $request->origen[$value];
                    $ruta->destino = $request->destino[$value];
                    $ruta->frecuencia = $request->frecuencia[$value];
                    $ruta->id_empresa = $objeto->empresa;
                    $ruta->id_users = $id_users;
                    $ruta->save();

                    if(isset($request->itinerario[$value])){
                        foreach ($request->itinerario[$value] as $val) {
                            $itinerario = new Itinerario;
                            $itinerario->nombre = $val;
                            $itinerario->id_ruta = $ruta->id;
                            $itinerario->id_users = $id_users;
                            $itinerario->save();
                        }
                    }

                    $r_ruta = new ResolucionRuta;
                    $r_ruta->id_resolucion = $resolucion->id;
                    $r_ruta->id_ruta = $ruta->id;
                    $r_ruta->id_users = $id_users;
                    $r_ruta->comentario = "RECONSIDERACION ENTRA";
                    $r_ruta->save();

                    $count_ruta++;
                }
            }
            // ************VEHIVULOS**************
            if(isset($request->renova)){
                foreach ($request->renova as $key => $value) {
                    $r_vehiculo = new ResolucionVehiculo;
                    $r_vehiculo->id_resolucion = $resolucion->id;
                    $r_vehiculo->id_vehiculo = $value;
                    $r_vehiculo->id_users = $id_users;
                    $r_vehiculo->save();

                    $count_vehi++;
                }
            }

            if(isset($request->sustitucion)){
                foreach ($request->sustitucion as $key => $value) {
                    $r_vehiculo = new ResolucionVehiculo;
                    $r_vehiculo->id_resolucion = $resolucion->id;
                    $r_vehiculo->id_vehiculo = $value;
                    $r_vehiculo->comentario = "SALE";
                    $r_vehiculo->estado = 0;
                    $r_vehiculo->id_users = $id_users;
                    $r_vehiculo->save();
                }
                $activos = DB::table("resolucion_vehiculo as rv")   
                        ->select("r.id_autorizacion","r.id_empresa","rv.id_vehiculo")    
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->whereIn("rv.id_vehiculo",$request->sustitucion_entra)
                        ->where("rv.estado",1)
                        ->get();

                if(count($activos)>0){

                    $resolucion_activos = new Resolucion;
                    $resolucion_activos->numero = $numero;
                    $resolucion_activos->fecha_ini = $date_ini;
                    $resolucion_activos->fecha = $date_ini;
                    $resolucion_activos->fecha_fin = $date_ini;
                    $resolucion_activos->descripcion = $objeto->descripcion;
                    $resolucion_activos->id_empresa = $activos[0]->id_empresa;
                    $resolucion_activos->id_autorizacion = $activos[0]->id_autorizacion;
                    $resolucion_activos->estado = 0;
                    $resolucion_activos->tipo = 6;
                    $resolucion_activos->id_users = $id_users;
                    $resolucion_activos->save();

                    foreach ($activos as $val) {
                        $r_a_vehiculo = new ResolucionVehiculo;
                        $r_a_vehiculo->id_resolucion = $resolucion_activos->id;
                        $r_a_vehiculo->id_vehiculo = $val->id_vehiculo;
                        $r_a_vehiculo->estado = 0;
                        $r_a_vehiculo->comentario = "BAJA";
                        $r_a_vehiculo->id_users = $id_users;
                        $r_a_vehiculo->save();
                    }
                }
                foreach ($request->sustitucion_entra as $key => $value) {

                    $r_vehiculo = new ResolucionVehiculo;
                    $r_vehiculo->id_resolucion = $resolucion->id;
                    $r_vehiculo->id_vehiculo = $value;
                    $r_vehiculo->comentario = "ENTRA";
                    $r_vehiculo->id_users = $id_users;
                    $r_vehiculo->save();

                    $count_vehi++;
                } 
            }
            if(isset($request->incremento)){

                $activos = DB::table("resolucion_vehiculo as rv")   
                        ->select("r.id_autorizacion","r.id_empresa","rv.id_vehiculo")    
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->whereIn("rv.id_vehiculo",$request->incremento)
                        ->where("rv.estado",1)
                        ->get();
                if(count($activos)>0){

                    $resolucion_activos = new Resolucion;
                    $resolucion_activos->numero = $numero;
                    $resolucion_activos->fecha_ini = $date_ini;
                    $resolucion_activos->fecha = $date_ini;
                    $resolucion_activos->fecha_fin = $date_ini;
                    $resolucion_activos->descripcion = $objeto->descripcion;
                    $resolucion_activos->id_empresa = $activos[0]->id_empresa;
                    $resolucion_activos->id_autorizacion = $activos[0]->id_autorizacion;
                    $resolucion_activos->estado = 0;
                    $resolucion_activos->tipo = 7;
                    $resolucion_activos->id_users = $id_users;
                    $resolucion_activos->save();

                    foreach ($activos as $val) {
                        $r_a_vehiculo = new ResolucionVehiculo;
                        $r_a_vehiculo->id_resolucion = $resolucion_activos->id;
                        $r_a_vehiculo->id_vehiculo = $val->id_vehiculo;
                        $r_a_vehiculo->estado = 0;
                        $r_a_vehiculo->comentario = "BAJA";
                        $r_a_vehiculo->id_users = $id_users;
                        $r_a_vehiculo->save();
                    }
                }
                foreach ($request->incremento as $key => $value) {

                    $r_vehiculo = new ResolucionVehiculo;
                    $r_vehiculo->id_resolucion = $resolucion->id;
                    $r_vehiculo->id_vehiculo = $value;
                    $r_vehiculo->id_users = $id_users;
                    $r_vehiculo->save();

                    $count_vehi++;
                }

            }
            if(isset($request->baja)){
                foreach ($request->baja as $key => $value) {
                    $r_vehiculo = new ResolucionVehiculo;
                    $r_vehiculo->id_resolucion = $resolucion->id;
                    $r_vehiculo->id_vehiculo = $value;
                    $r_vehiculo->estado = 0;
                    $r_vehiculo->id_users = $id_users;
                    $r_vehiculo->save();
                }
            }

            $auto = Autorizacion::find($autorizacion->id);
            $auto->vehiculos = $count_vehi;
            $auto->rutas = $count_ruta;
            $auto->save();

            DB::commit();
            $message = 'Guardado.';
            // $response["id"] = $empresa->id;
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Guardar. Intente otra vez.';
            $status = false;
        }
        $response["status"] = $status;
        $response["message"] = $message;
        return $response;
    }
}
