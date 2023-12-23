<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;

class ReporteController extends Controller
{
    public function vehiculo(){
    	return view("extranet.reporte.vehiculo");
    }
    public function vehiculo_empresa(Request $request){
    	if ($request->input('datatable')) {
    		// dd($request);
            $response = DB::table("resolucion_vehiculo as rv")
                        ->select(
                            "rv.id as RowId",
                            "v.placa as Placa",
                            "m.nombre as Marca",
                            "c.nombre as Categoria",
                            "v.fabricacion as Fabricacion",
                            "r.numero as Resolucion",
                            DB::raw("DATE_FORMAT(r.fecha_ini,'%d/%m/%Y') as FechaIni"),
	                        DB::raw("CASE 
	                                WHEN r.tipo = 0 THEN CONCAT('AUTORIZACION ',IFNULL(rv.comentario,''))
	                                WHEN r.tipo = 6 THEN CONCAT('SUSTITUCION ',IFNULL(rv.comentario,''))
	                                WHEN r.tipo = 7 THEN CONCAT('INCREMENTO ',IFNULL(rv.comentario,''))
	                                WHEN r.tipo = 8 THEN CONCAT('BAJA ',IFNULL(rv.comentario,''))
	                                ELSE ' '
	                                END AS Comentario"),
                            DB::raw("IF(rv.estado = 1,'Activo','Inactivo') as Estado"),
                            DB::raw('"" as Botones')
                        )
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->join("vehiculo as v","v.id","rv.id_vehiculo")
                        ->leftJoin("marca as m","m.id","v.id_marca")
                        ->leftJoin("categoria as c","c.id","v.id_categoria")
                        ->where("r.id_autorizacion",$request->autorizacion)
                        ->orderBy("v.id","asc");

            if(isset($request->estado)):
                $response = $response->where('rv.estado',$request->estado);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
        }
        $response["autorizacion"] = $request->autorizacion;
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
    	return view("extranet.reporte.vehiculo_empresa",$response);
    }
    public function ruta(){
        return view("extranet.reporte.ruta");
    }
    public function ruta_empresa(Request $request){
        if ($request->input('datatable')) {
            // dd($request);
            $response = DB::table("resolucion_ruta as rr")
                        ->select(
                            "rr.id as RowId",
                            "r.numero as Resolucion",
                            DB::raw("DATE_FORMAT(r.fecha_ini,'%d/%m/%Y') as FechaIni"),

                            "ru.origen as Origen",
                            "ru.destino as Destino",
                            "ru.frecuencia as Frecuencia",

                            DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ' | ')
                                    FROM itinerario as  i
                                    WHERE i.id_ruta = ru.id
                                    GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario"),

                            DB::raw("CASE 
                                    WHEN r.tipo = 0 THEN CONCAT('AUTORIZACION ',IFNULL(rr.comentario,''))
                                    WHEN r.tipo = 1 THEN CONCAT('AMPLIACION ',IFNULL(rr.comentario,''))
                                    WHEN r.tipo = 2 THEN CONCAT('FRECUENCIA ',IFNULL(rr.comentario,''))
                                    WHEN r.tipo = 3 THEN CONCAT('ITINERARIO ',IFNULL(rr.comentario,''))
                                    WHEN r.tipo = 4 THEN CONCAT('RENUNCIA ',IFNULL(rr.comentario,''))
                                    WHEN r.tipo = 5 THEN CONCAT('RECONSIDERACION ',IFNULL(rr.comentario,''))
                                    ELSE ' '
                                    END AS Comentario"),

                            DB::raw("IF(rr.estado = 1,'Activo','Inactivo') as Estado"),
                            DB::raw('"" as Botones')
                        )
                        ->join("resolucion as r","r.id","rr.id_resolucion")
                        ->join("ruta as ru","ru.id","rr.id_ruta")
                        ->where("r.id_autorizacion",$request->autorizacion)
                        ->orderBy("ru.id","asc");

            if(isset($request->estado)):
                $response = $response->where('rr.estado',$request->estado);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
        }
        $response["autorizacion"] = $request->autorizacion;
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
        return view("extranet.reporte.ruta_empresa",$response);
    }
    public function resolucion(Request $request){
        if ($request->input('datatable')) {
             $response = DB::table("resolucion as r")
                        ->select(
                            "r.id as RowId",
                            "e.razon_social as Empresa",
                            "r.numero as Resolucion",
                            DB::raw("DATE_FORMAT(r.fecha_ini,'%d/%m/%Y') as FechaIni"),

                            DB::raw("CASE 
                                    WHEN r.tipo = 0 THEN 'AUTORIZACION'
                                    WHEN r.tipo = 1 THEN 'AMPLIACION VEHICULO'
                                    WHEN r.tipo = 2 THEN 'FRECUENCIA VEHICULO'
                                    WHEN r.tipo = 3 THEN 'ITINERARIO VEHICULO'
                                    WHEN r.tipo = 4 THEN 'RENUNCIA VEHICULO'
                                    WHEN r.tipo = 5 THEN 'RECONSIDERACION VEHICULO'
                                    WHEN r.tipo = 6 THEN 'SUSTITUCION RUTA'
                                    WHEN r.tipo = 7 THEN 'INCREMENTO RUTA'
                                    WHEN r.tipo = 8 THEN 'BAJA RUTA'
                                    ELSE ' '
                                    END AS Tipo"),

                            DB::raw("IF(r.estado = 1,'Activo','Inactivo') as Estado"),
                            DB::raw('"" as Botones')
                        )
                        // ->where("r.id_autorizacion",$request->autorizacion)
                        ->join("empresa as e","e.id","r.id_empresa")
                        ->groupBy("r.numero")
                        ->orderBy("r.id","asc");

            if(isset($request->empresa)):
                $response = $response->where('r.id_empresa',$request->empresa);
            endif;
             if(isset($request->autorizacion)):
                $response = $response->where('r.id_autorizacion',$request->autorizacion);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
        }
        return view("extranet.reporte.resolucion");
    }
}
