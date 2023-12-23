<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
// use App\Models\Empresa;
use App\Models\Ruta;
use App\Models\Itinerario;
use App\Models\ResolucionRuta;
use App\Models\ResolucionVehiculo;
use App\Models\Resolucion;

class ModificacionController extends Controller
{
    public function ampliacion(){
        return view("extranet.modificacion.rutas.ampliacion");
    }
    public function ampliacion_empresa(Request $request){

        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();

        $response["rutas"] = DB::table("ruta as r")
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
                        ->Join("resolucion as re","re.id","rr.id_resolucion")
                        ->where("rr.estado",1)
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();
        $response["config"] = DB::table("config")
                        ->first();                
    	return view("extranet.modificacion.rutas.ampliacion_empresa",$response);
    }
    public function ampliacion_store(Request $request){
    	// dd($request);
    	DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 1;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $i = 0;
            DB::table("resolucion_ruta")
                ->whereIn("id_ruta",$request->rutas)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "id_users"=>$id_users
                ]);
            foreach ($request->rutas as $key => $value) {
            	// echo $key."<br>";
	            $ruta = new Ruta;
	            $ruta->origen = $request->origen[$value];
	            $ruta->destino = $request->destino[$value];
	            $ruta->frecuencia = $request->frecuencia[$value];
	            $ruta->id_empresa = $request->empresa;
                $ruta->id_users = $id_users;
	            $ruta->save();

	            if(isset($request->itinerario[$value])){
	                foreach ($request->itinerario[$value] as $value) {
	                    $itinerario = new Itinerario;
	                    $itinerario->nombre = $value;
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
	            
	            // $i++; 
            }        

            // $empresa = Empresa::find($request->empresa)->increment('rutas', $i);
            // DB::table('empresa')
            // 	->where("id",$request->empresa)
            // 	->increment('rutas', $i);
            // $empresa->rutas = $request->empresa;
            // $empresa->save();

            DB::commit();
            $message = 'Guardado.';
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
    public function frecuencia(){
        return view("extranet.modificacion.rutas.frecuencia");
    }
    public function frecuencia_empresa(Request $request){
        // dd($request);
        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();

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
        $response["config"] = DB::table("config")
                        ->first();
        return view("extranet.modificacion.rutas.frecuencia_empresa",$response);
    }
    public function frecuencia_store(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();
            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;
                    
            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 2;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $i = 0;
            DB::table("resolucion_ruta")
                ->whereIn("id_ruta",$request->rutas)
                ->where("estado",1)
                ->update([
                    "estado" => 0
                ]);
            foreach ($request->rutas as $key => $value) {
                // DB::table("resolucion_ruta")
                //     ->where("id_ruta",$value)
                //     ->where("estado",1)
                //     ->update([
                //         "estado" => 0
                //     ]);

                $a_ruta = Ruta::find($value);
                $itinerario = DB::table("itinerario")
                            ->where("id_ruta",$value)
                            ->get();

                $ruta = new Ruta;
                $ruta->origen = $a_ruta->origen;
                $ruta->destino = $a_ruta->destino;
                $ruta->frecuencia = $request->input('frecuencia'.$value);
                $ruta->id_empresa = $request->empresa;
                $ruta->id_users = $id_users;
                $ruta->save();
                // dd($itinerario);
                if(count($itinerario)>0){
                    foreach ($itinerario as $val) {
                        $itinerario = new Itinerario;
                        $itinerario->nombre = $val->nombre;
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
            }        


            DB::commit();
            $message = 'Guardado.';
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
    public function itinerario(){
        return view("extranet.modificacion.rutas.itinerario");
    }
    public function itinerario_empresa(Request $request){
        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();

        $response["rutas"] = DB::table("ruta as r")
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
                        ->Join("resolucion as re","re.id","rr.id_resolucion")
                        ->where("rr.estado",1)
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();
        $response["config"] = DB::table("config")
                        ->first();
        return view("extranet.modificacion.rutas.itinerario_empresa",$response);
    }
    public function itinerario_store(Request $request){
        // return $request;
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();
            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 3;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $i = 0;
            DB::table("resolucion_ruta")
                ->whereIn("id_ruta",$request->rutas)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "id_users" => $id_users
                ]);
            foreach ($request->rutas as $key => $value) {

                // $a_ruta = Ruta::find($value);

                // $ruta = new Ruta;
                // $ruta->origen = $a_ruta->origen;
                // $ruta->destino = $a_ruta->destino;
                // $ruta->frecuencia = $a_ruta->frecuencia;
                // $ruta->id_empresa = $request->empresa;
                // $ruta->id_users = $id_users;
                // $ruta->save();

                $ruta = new Ruta;
                $ruta->origen = $request->origen[$value];
                $ruta->destino = $request->destino[$value];
                $ruta->frecuencia = $request->frecuencia[$value];
                $ruta->id_empresa = $request->empresa;
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

                
                // $i++;            
            }        


            DB::commit();
            $message = 'Guardado.';
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
    public function renuncia(){
        return view("extranet.modificacion.rutas.renuncia");
    }
    public function renuncia_empresa(Request $request){

        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();

        $response["rutas"] = DB::table("ruta as r")
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
                        ->Join("resolucion as re","re.id","rr.id_resolucion")
                        ->where("rr.estado",1)
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->get();
        $response["config"] = DB::table("config")
                        ->first();                
        return view("extranet.modificacion.rutas.renuncia_empresa",$response);
    }
    public function renuncia_store(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 4;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $i = 0;
            DB::table("resolucion_ruta")
                ->whereIn("id_ruta",$request->rutas)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "renuncia" => 1,
                    "id_resolucion_afectado" => $resolucion->id,
                    "id_users" => $id_users
                ]);
            foreach ($request->rutas as $key => $value) {
                // echo $key."<br>";

                $ruta = new Ruta;
                $ruta->origen = $request->origen[$value];
                $ruta->destino = $request->destino[$value];
                $ruta->frecuencia = $request->frecuencia[$value];
                $ruta->id_empresa = $request->empresa;
                $ruta->id_users = $id_users;
                $ruta->save();

                if(isset($request->itinerario[$value])){
                    foreach ($request->itinerario[$value] as $value) {
                        $itinerario = new Itinerario;
                        $itinerario->nombre = $value;
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
                
                // $i++; 
            }        

            // $empresa = Empresa::find($request->empresa)->increment('rutas', $i);
            // DB::table('empresa')
            //  ->where("id",$request->empresa)
            //  ->increment('rutas', $i);
            // $empresa->rutas = $request->empresa;
            // $empresa->save();

            DB::commit();
            $message = 'Guardado.';
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
    public function reconsideracion(){
        return view("extranet.modificacion.rutas.reconsideracion");
    }
    public function reconsideracion_empresa(Request $request){

        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();

        $response["rutas"] = DB::table("ruta as r")
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
        // dd($response["renuncia"]);
        $response["config"] = DB::table("config")
                        ->first();                
        return view("extranet.modificacion.rutas.reconsideracion_empresa",$response);
    }
    public function reconsideracion_store(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 5;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $i = 0;
            DB::table("resolucion_ruta")
                ->whereIn("id_ruta",$request->rutas)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "id_resolucion_afectado" => $resolucion->id,
                    "id_users" => $id_users
                ]);
            foreach ($request->renuncia as $key => $value) {
                // echo $key."<br>";
                $ruta = new Ruta;
                $ruta->origen = $request->origen[$value];
                $ruta->destino = $request->destino[$value];
                $ruta->frecuencia = $request->frecuencia[$value];
                $ruta->id_empresa = $request->empresa;
                $ruta->id_users = $id_users;
                $ruta->save();

                if(isset($request->itinerario[$value])){
                    foreach ($request->itinerario[$value] as $value) {
                        $itinerario = new Itinerario;
                        $itinerario->nombre = $value;
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
                
                // $i++; 
            }        

            // $empresa = Empresa::find($request->empresa)->increment('rutas', $i);
            // DB::table('empresa')
            //  ->where("id",$request->empresa)
            //  ->increment('rutas', $i);
            // $empresa->rutas = $request->empresa;
            // $empresa->save();

            DB::commit();
            $message = 'Guardado.';
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
    //****************************************
    //          Vehiculos
    //****************************************
    public function sustitucion(){
        return view("extranet.modificacion.vehiculos.sustitucion");
    }
    public function sustitucion_empresa(Request $request){
        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();
        $response["config"] = DB::table("config")
                        ->first(); 
        $response["categoria"] = DB::table("categoria")
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
        $response["inactivos"] = DB::table("vehiculo as v")
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
                                    ->where("rv.estado",0);
                        })
                        ->Join("resolucion as re","re.id","rv.id_resolucion")
                        ->where("re.id_autorizacion",$request->autorizacion)
                        ->groupBy("v.id")
                        ->get();
        // dd($response["inactivos"]);
        return view("extranet.modificacion.vehiculos.sustitucion_empresa",$response);
    }
    public function sustitucion_store(Request $request){
        // return $request;
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 6;
            $resolucion->id_users = $id_users;
            $resolucion->save();

                DB::table("resolucion_vehiculo as rv")
                    ->join("resolucion as re","re.id","rv.id_resolucion")
                    ->whereIn("rv.id_vehiculo",$request->vehiculos)
                    ->where("rv.estado",1)
                    ->where("re.id_empresa",$request->empresa)
                    ->update([
                        "rv.estado" => 0,
                        "rv.id_resolucion_afectado" => $resolucion->id,
                        "rv.id_users" => $id_users
                    ]);
            foreach ($request->vehiculos as $key => $value) {
                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $resolucion->id;
                $r_vehiculo->id_vehiculo = $value;
                $r_vehiculo->comentario = "SALE";
                $r_vehiculo->estado = 0;
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
            }
            // $i = 0;

            $activos = DB::table("resolucion_vehiculo as rv")   
                        ->select("r.id_autorizacion","r.id_empresa","rv.id_vehiculo")    
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->whereIn("rv.id_vehiculo",$request->input_vehiculo)
                        ->where("rv.estado",1)
                        ->get();
            if(count($activos)>0){

                $resolucion_activos = new Resolucion;
                $resolucion_activos->numero = $numero;
                $resolucion_activos->fecha_ini = $date_ini;
                $resolucion_activos->fecha = $date_ini;
                $resolucion_activos->fecha_fin = $date_ini;
                $resolucion_activos->descripcion = $request->descripcion;
                $resolucion_activos->id_empresa = $activos[0]->id_empresa;
                $resolucion_activos->id_autorizacion = $activos[0]->id_autorizacion;
                $resolucion_activos->estado = 0;
                $resolucion_activos->tipo = 6;
                $resolucion_activos->id_users = $id_users;
                $resolucion_activos->save();

                foreach ($activos as $value) {
                    $r_a_vehiculo = new ResolucionVehiculo;
                    $r_a_vehiculo->id_resolucion = $resolucion_activos->id;
                    $r_a_vehiculo->id_vehiculo = $value->id_vehiculo;
                    $r_a_vehiculo->estado = 0;
                    $r_a_vehiculo->comentario = "BAJA";
                    $r_a_vehiculo->id_users = $id_users;
                    $r_a_vehiculo->save();
                }
            }
            DB::table("resolucion_vehiculo")
                    ->whereIn("id_vehiculo",$request->input_vehiculo)
                    ->where("estado",1)
                    ->update([
                        "estado" => 0,
                        "id_users" => $id_users
                    ]);
            foreach ($request->input_vehiculo as $key => $value) {

                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $resolucion->id;
                $r_vehiculo->id_vehiculo = $value;
                $r_vehiculo->comentario = "ENTRA";
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
                
                // $i++;            
            }        
            // DB::table("autorizacion")
            //     ->where("id",$request->autorizacion)
            //     ->increment("vehiculos",$i);

            DB::commit();
            $message = 'Guardado.';
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
    public function incremento(){
        return view("extranet.modificacion.vehiculos.incremento");
    }
    public function incremento_empresa(Request $request){
        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();
        $response["config"] = DB::table("config")
                        ->first(); 
        $response["categoria"] = DB::table("categoria")
                            ->get();
        return view("extranet.modificacion.vehiculos.incremento_empresa",$response);
    }
    public function verificar(Request $request){

        $query = DB::table("resolucion_vehiculo as rv")
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->where("r.id_empresa",$request->ide)
                        ->where("rv.estado",1)
                        ->where("rv.id_vehiculo",$request->vehiculo)
                        ->get();
            if(count($query))
            {
                $response["status"] = false;
                $response["message"] = 'El vehiculo ya pertenece a la empresa.';
            } else {
                $response["status"] = true;
                $response["message"] = 'Vehiculo valido.';
            }
        return $response;
    }
    public function incremento_store(Request $request){
        // dd($request->input_vehiculo[0]);
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 7;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            
            $activos = DB::table("resolucion_vehiculo as rv")   
                        ->select("r.id_autorizacion","r.id_empresa","rv.id_vehiculo")    
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->whereIn("rv.id_vehiculo",$request->input_vehiculo)
                        ->where("rv.estado",1)
                        ->get();
            if(count($activos)>0){

                $resolucion_activos = new Resolucion;
                $resolucion_activos->numero = $numero;
                $resolucion_activos->fecha_ini = $date_ini;
                $resolucion_activos->fecha = $date_ini;
                $resolucion_activos->fecha_fin = $date_ini;
                $resolucion_activos->descripcion = $request->descripcion;
                $resolucion_activos->id_empresa = $activos[0]->id_empresa;
                $resolucion_activos->id_autorizacion = $activos[0]->id_autorizacion;
                $resolucion_activos->estado = 0;
                $resolucion_activos->tipo = 7;
                $resolucion_activos->id_users = $id_users;
                $resolucion_activos->save();

                foreach ($activos as $value) {
                    $r_a_vehiculo = new ResolucionVehiculo;
                    $r_a_vehiculo->id_resolucion = $resolucion_activos->id;
                    $r_a_vehiculo->id_vehiculo = $value->id_vehiculo;
                    $r_a_vehiculo->estado = 0;
                    $r_a_vehiculo->comentario = "BAJA";
                    $r_a_vehiculo->id_users = $id_users;
                    $r_a_vehiculo->save();
                }
            }

            DB::table("resolucion_vehiculo")
                ->whereIn("id_vehiculo",$request->input_vehiculo)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "id_users" => $id_users
                ]);

            $i = 0;
            foreach ($request->input_vehiculo as $key => $value) {

                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $resolucion->id;
                $r_vehiculo->id_vehiculo = $value;
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
                
                $i++;            
            }        
            DB::table("autorizacion")
                ->where("id",$request->autorizacion)
                ->increment("vehiculos",$i);

            DB::commit();
            $message = 'Guardado.';
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
    public function baja(){
        return view("extranet.modificacion.vehiculos.baja");
    }
    public function baja_empresa(Request $request){
        $response["empresa"] = DB::table("autorizacion as a")
                    ->select(
                            "e.id",
                            "a.id as idA",
                            "e.razon_social as razon_social",
                            "e.ruc as ruc",
                            "a.numero as Numero",
                            "t.nombre as Tipo"
                        )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.id",$request->autorizacion)
                    ->first();
        $response["config"] = DB::table("config")
                        ->first();  

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

        return view("extranet.modificacion.vehiculos.baja_empresa",$response);
    }
    public function baja_store(Request $request){
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->autorizacion)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();


            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d'); 

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha = $date_ini;
            $resolucion->fecha_fin = $res->fecha_fin;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $request->autorizacion;
            $resolucion->tipo = 8;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            $i = 0;
            DB::table("resolucion_vehiculo")
                ->whereIn("id_vehiculo",$request->vehiculos)
                ->where("estado",1)
                ->update([
                    "estado" => 0,
                    "id_users" => $id_users
                ]);
            foreach ($request->vehiculos as $key => $value) {
                // echo $key;

                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $resolucion->id;
                $r_vehiculo->id_vehiculo = $value;
                $r_vehiculo->estado = 0;
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
                
                $i++;            
            }        
            DB::table("autorizacion")
                ->where("id",$request->autorizacion)
                ->decrement("vehiculos",$i);

            DB::commit();
            $message = 'Guardado.';
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
