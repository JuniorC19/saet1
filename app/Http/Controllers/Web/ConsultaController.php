<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConsultaController extends Controller
{
    public function consulta(Request $request){

    	$response["vehiculo"] = DB::table("vehiculo as v")
                            ->select(
                                "v.*",
                                "m.nombre as Marca",
                                "c.nombre as Carroceria",
                                "ca.nombre as Categoria",
                                DB::raw("DATE_FORMAT(v.fecha,'%d/%m/%Y') as Fecha")
                            )
                            ->leftJoin("categoria as ca","ca.id","v.id_categoria")
                            ->leftJoin("marca as m","m.id","v.id_marca")
                            ->leftJoin("carroceria as c","c.id","v.id_carroceria")
                            ->where("v.placa",$request->placa)
                            ->first();
        // dd($response);
        if($response["vehiculo"]!=null){
        	$response["status"] = true;
	        $resolucion = DB::table("resolucion_vehiculo as rv")
	        					->select(
	        						"r.id_autorizacion as id",
	        						"r.numero as Resolucion",
	        						DB::raw("DATE_FORMAT(r.fecha_ini,'%d/%m/%Y') as FechaIni"),
	                            	DB::raw("DATE_FORMAT(r.fecha_fin,'%d/%m/%Y') as FechaFin"),
	                            	"rv.estado as Estado"
	        					)
	        					->join("resolucion as r","r.id","rv.id_resolucion")
	        					->join("autorizacion as a","a.id","r.id_autorizacion")
	        					->where("rv.id_vehiculo",$response["vehiculo"]->id)
	        					->orderBy("r.id","desc")
	        					->first();

			$response["resolucion"] = $resolucion; 
			// dd($resolucion);       					

	        $response["empresa"] = DB::table("autorizacion as a")
	                    ->select(
	                        "e.razon_social as Nombre",
	                        "e.ruc as Ruc",
	                        "e.partida_electronico as Partida"
	                    )
	                    ->join("empresa as e","e.id","a.id_empresa")
	                    ->where("a.id",$resolucion->id)
	                    ->first();

	        $response["rutas"] = DB::table("ruta as r")
	                        ->select(
	                            "r.id as RowId",
	                            "r.origen as Origen",
	                            "r.destino as Destino",
	                            "r.frecuencia as Frecuencia",
	                            DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ', ')
	                                    FROM itinerario as  i
	                                    WHERE i.id_ruta = r.id
	                                    GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario")
	                            // "re.numero as Resolucion",
	                            // DB::raw('"" as Botones')
	                        )
	                        ->join("resolucion_ruta as rr","rr.id_ruta","r.id")
	                        ->join("resolucion as re","re.id","rr.id_resolucion")
	                        ->join("autorizacion as a","a.id","re.id_autorizacion")
	                        ->where("rr.estado",1)
	                        ->where("a.estado",1)
	                        ->where("a.id",$resolucion->id)
	                        ->get();
	    }else{
	    	$response["status"] = false;
	    	$response["placa"] = $request->placa;
	    }                    
        // dd($response);
    	return view("web.consulta",$response);
    }
}
