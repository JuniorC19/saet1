<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DataTables;

class InicioController extends Controller
{
    public function index()
    {
    	$response["empresa"] = DB::table("empresa")
    						->count();
    	$response["autorizacion"] = DB::table("autorizacion")
    						->where("estado",1)
    						->count();
    	$response["vehiculo"] = DB::table("vehiculo")
    						->count();
    	$response["ruta"] = DB::table("ruta as r")
    						->join("resolucion_ruta as rr","rr.id_ruta","r.id")
    						->where("rr.estado",1)
    						->count();

        // $users = DB::table("users as u")
        //                 ->select("u.name","u.id")
        //                 ->join("model_has_roles as mr","mr.model_id","u.id")
        //                 ->where("role_id",5)
        //                 ->get();

        // foreach ($users as $key => $value) {
        //     $vehiculos = DB::table("vehiculo")
        //                     ->where("id_users",$value->id)
        //                     ->count();
        //     $obj[$key] = new \stdClass;
        //     $obj[$key]->usuario = $value->name;
        //     $obj[$key]->vehiculos = $vehiculos;
        // }
        $response["user"] = DB::table("users as u")
                        ->select("u.name","u.id")
                        ->join("model_has_roles as mr","mr.model_id","u.id")
                        ->where("role_id",5)
                        ->get();

        // dd($obj);
        // $response["practicante"] = $obj;
    	// return $response;
    	return view("extranet.dashboard",$response);
    }
    public function semana($fecha){
        // dd($fecha);
        // $id_sede = Auth::user()->id_sede;
        $ids = explode("|", $fecha);
        $fecha = new \DateTime($ids[0]);
        $semna = $fecha->format('W');
        $year = $fecha->format('Y');

        $total = 0;
        for($day=1; $day<=7; $day++)
        {
            $fecha_dia = date('Y-m-d', strtotime($year."W".$semna.$day));
            $fecha_tabla = date('d/m', strtotime($year."W".$semna.$day));

            // $response["datos"][$day] = DB::table("orden")
            //                 ->where("id_sede",$id_sede)
            //                 ->where("fecha",$fecha_dia)
            //                 ->whereIn("estado",["0","1"])
            //                 ->count();
             $response["datos"][$day]=DB::table("vehiculo")
                            ->where("id_users",$ids[1])
                            ->where(DB::raw("DATE_FORMAT(updated_at,'%Y-%m-%d')"),$fecha_dia)
                            ->count();
            $response["fechas"][$day] = $fecha_tabla;

            $total += $response["datos"][$day];
        }
        $response["total"] = $total;
        return $response;
    }
    public function search(Request $request){
        // $rutas = DB::table("rutas")
        // $search = $request->key;

        if ($request->input('vehiculo')) {
            $search = "";
            if(isset($request->search)):
                $search = $request->search;
            endif;
            $response = DB::table("vehiculo as v")
                            ->select(
                                "v.id as RowId",
                                "v.placa as Placa",
                                "m.nombre as Marca",
                                "c.nombre as Categoria",
                                "v.fabricacion as Fabricacion",
                                DB::raw('"" as Botones')
                            )
                            ->leftJoin("marca as m","m.id","v.id_marca")
                            ->leftJoin("categoria as c","c.id","v.id_categoria")
                            // ->where("v.placa","like","%$search%");
                            ->where(function ($query)  use ($search){
                                // ->where("nombre","like","%$request->q%")
                                    $query->where("v.placa","like","%$search%")
                                        ->orWhere("m.nombre","like","%$search%")
                                        ->orWhere("c.nombre","like","%$search%");
                                        // ->orWhere(DB::raw("CONCAT(r.apellido_paterno,' ',r.apellido_materno)"), "LIKE", "%".$search."%")
                                    // $query->where('type', 0)
                                });
                            // ->get();

                            
            $response = $response->get();
            return DataTables::of($response)
                    ->make('true');  
        }
        if ($request->input('ruta')) {
            $search = "";
            if(isset($request->search)):
                $search = $request->search;
            endif;
            $response = DB::table("ruta as r")
                    ->select(
                        "r.id as RowId",
                        "e.ruc as Ruc",
                        "e.nombre_imprimir as Empresa",
                        "re.numero as Resolucion",
                        // DB::raw("CASE 
                        //             WHEN re.tipo = 0 THEN CONCAT('AUTORIZACION ',IFNULL(rr.comentario,''))
                        //             WHEN re.tipo = 1 THEN CONCAT('AMPLIACION ',IFNULL(rr.comentario,''))
                        //             WHEN re.tipo = 2 THEN CONCAT('FRECUENCIA ',IFNULL(rr.comentario,''))
                        //             WHEN re.tipo = 3 THEN CONCAT('ITINERARIO ',IFNULL(rr.comentario,''))
                        //             WHEN re.tipo = 4 THEN CONCAT('RENUNCIA ',IFNULL(rr.comentario,''))
                        //             WHEN re.tipo = 5 THEN CONCAT('RECONSIDERACION ',IFNULL(rr.comentario,''))
                        //             ELSE ' '
                        //             END AS Comentario"),

                        DB::raw("IF(rr.estado = 1,'Activo','Inactivo') as Estado"),

                        "r.origen as Origen",
                        "r.destino as Destino",
                        "r.frecuencia as Frecuencia",
                        DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ' | ')
                                FROM itinerario as  i
                                WHERE i.id_ruta = r.id
                                GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario"),
                        DB::raw('"" as Botones')

                    )
                    ->join("empresa as e","e.id","r.id_empresa")
                    ->leftJoin("resolucion_ruta as rr","rr.id_ruta","r.id")
                    ->leftJoin("resolucion as re","re.id","rr.id_resolucion")
                    ->leftJoin("itinerario as it","it.id_ruta","r.id")
                    ->where(function ($query)  use ($search){
                    // ->where("nombre","like","%$request->q%")
                        $query->where("r.origen","like","%$search%")
                            ->orWhere("r.destino","like","%$search%")
                            ->orWhere("r.frecuencia","like","%$search%")
                            // ->orWhere(DB::raw("CONCAT(r.apellido_paterno,' ',r.apellido_materno)"), "LIKE", "%".$search."%")
                            ->orWhere("it.nombre","like","%$search%");
                        // $query->where('type', 0)
                    })
                    ->groupBy("r.id");
                    
            if(isset($request->estado)):
                $response = $response->where('rr.estado',$request->estado);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
                    // ->leftJoin("seguro as s","s.id","p.id_seguro")
                    // ->get();
        }
        
        // return $response;
        $response["search"] = $request->key;
        return view("extranet.search",$response);
        // dd($response);
    }

}
