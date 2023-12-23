<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Auth;
use App\Models\Empresa;
use App\Models\Autorizacion;
use App\Models\Resolucion;
use App\Models\ResolucionRuta;
use App\Models\Ruta;
use App\Models\ResolucionVehiculo;
use App\Models\EmpresaVehiculo;
use App\Models\TipoEmpresa;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('datatable')) {

            $response = DB::table("empresa as e")
                        ->select(
                            "e.id as RowId",
                            "e.razon_social as Nombre",
                            "e.ruc as Ruc",
                            "e.telefono as Telefono",
                            "e.resolucion as ResolucionPrimaria",
                            "e.ficha_registro as NumeroRegistro",
                            "e.partida_electronico as NumeroElectronico",
                            "a.id_tipo",
                            DB::raw('"" as Botones')
                        )
                        ->rightJoin("autorizacion as a","a.id_empresa","e.id")
                        ->groupBY("e.id");

            if(isset($request->tipo)):
                $response = $response->where('a.id_tipo',$request->tipo);
            endif;

            $response = $response->get();
            // dd($response);
            return DataTables::of($response)
                    ->make('true'); 
        }
        
        $response["tipo"] = DB::table("tipo")->get();
        return view('extranet.empresa.index',$response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response["tipo"] = DB::table("tipo")
                        ->get();
        $response["config"] = DB::table("config")
                            ->first();
        return view("extranet.empresa.create",$response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_users= Auth::user()->id;
        // dd($request);
        DB::beginTransaction();
        try {
            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;
            $empresa = new Empresa;
            $empresa->razon_social = $request->razon_social;
            $empresa->ruc = $request->ruc;
            $empresa->nombre_imprimir = $request->nombre;
            $empresa->telefono = $request->telefono;
            $empresa->ficha_registro = $request->ficha;
            $empresa->partida_electronico = $request->partida;
            $empresa->resolucion = $numero;
            $empresa->id_users = $id_users;
            // $empresa->rutas = $request->rutas;
            // $empresa->vehiculos = $request->vehiculos;
            $empresa->save();

            $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
            $date_ini = $temp_ini->format('Y-m-d');

            $temp_fin = \DateTime::createFromFormat('d/m/Y', $request->fecha_fin);
            $date_fin = $temp_fin->format('Y-m-d');

            $autorizacion = new Autorizacion;
            $autorizacion->numero = $numero;
            $autorizacion->fecha_ini = $date_ini;
            $autorizacion->fecha_fin = $date_fin;
            $autorizacion->rutas = $request->rutas;
            $autorizacion->vehiculos = $request->vehiculos;
            $autorizacion->descripcion = $request->descripcion;
            $autorizacion->id_empresa = $empresa->id;
            $autorizacion->id_tipo = $request->tipo;
            $autorizacion->id_users = $id_users;
            $autorizacion->save();

            $resolucion = new Resolucion;
            $resolucion->numero = $numero;
            $resolucion->fecha_ini = $date_ini;
            $resolucion->fecha_fin = $date_fin;
            // $resolucion->rutas = $request->rutas;
            // $resolucion->vehiculos = $request->vehiculos;
            $resolucion->descripcion = $request->descripcion;
            $resolucion->id_empresa = $empresa->id;
            $resolucion->id_autorizacion = $autorizacion->id;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            // $tipo = new TipoEmpresa;
            // $tipo->id_tipo = $request->tipo;
            // $tipo->id_empresa = $empresa->id;
            // $tipo->id_resolucion = $resolucion->id;
            // $tipo->save();

            // for ($i=0; $i <$request->rutas ; $i++) { 

            //     $ruta = new Ruta;
            //     $ruta->id_empresa = $empresa->id;
            //     $ruta->save();

            //     $r_ruta = new ResolucionRuta;
            //     $r_ruta->id_resolucion = $resolucion->id;
            //     $r_ruta->id_ruta = $ruta->id;
            //     $r_ruta->save();
            // }
            // for ($i=0; $i <$request->vehiculos ; $i++) { 

            //     $vehiculo = new Vehiculo;
            //     $vehiculo->save();

            //     $e_vehiculo = new EmpresaVehiculo;
            //     $e_vehiculo->id_vehiculo = $vehiculo->id;
            //     $e_vehiculo->id_empresa = $empresa->id;
            //     $e_vehiculo->save();

            //     $r_vehiculo = new ResolucionVehiculo;
            //     $r_vehiculo->id_resolucion = $resolucion->id;
            //     $r_vehiculo->id_vehiculo = $vehiculo->id;
            //     $r_vehiculo->save();
            // }
            DB::commit();
            $message = 'Guardado.';
            $response["id"] = $empresa->id;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response["data"] = DB::table("empresa")
                ->select(
                    "razon_social",
                    "ruc",
                    "nombre_imprimir",
                    "telefono",
                    "ficha_registro",
                    "partida_electronico",
                    "resolucion"
                )
                ->where("id",$id)
                ->first();

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $id_users= Auth::user()->id;

            $empresa = Empresa::find($id);
            $search = $empresa->resolucion;
            // dd($empresa->resolucion);
            $empresa->razon_social = $request->razon_social;
            $empresa->nombre_imprimir = $request->nombre_imprimir;
            $empresa->telefono = $request->telefono;
            $empresa->ficha_registro = $request->ficha_registro;
            $empresa->partida_electronico = $request->partida_electronico;
            $empresa->id_users = $id_users;
            if(isset($request->editar)){
                $empresa->resolucion = $request->resolucion;
                DB::table("autorizacion")
                    ->where("numero",$search)
                    ->update(["numero"=>$request->resolucion]);

                DB::table("resolucion")
                    ->where("numero",$search)
                    ->update(["numero"=>$request->resolucion]);
            }
            $empresa->save();

            DB::commit();
            $message = 'Actulizado.';
            $response["id"] = $empresa->id;
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Actulizado. Intente otra vez.';
            $status = false;
        }
        $response["status"] = $status;
        $response["message"] = $message;
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function ruta(Request $request,$id){
        if ($request->input('datatable')) {

            $response = DB::table("ruta as r")
                        ->select(
                            "r.id as RowId",
                            "r.origen as Origen",
                            "r.destino as Destino",
                            "r.frecuencia as Frecuencia",
                            DB::raw("(SELECT GROUP_CONCAT(i.nombre SEPARATOR  ' | ')
                                    FROM itinerario as  i
                                    WHERE i.id_ruta = r.id
                                    GROUP BY i.id_ruta ORDER BY i.id asc) as Itinerario"),
                            "re.numero as Resolucion",
                            DB::raw('"" as Botones')
                        )
                        ->join("resolucion_ruta as rr","rr.id_ruta","r.id")
                        ->join("resolucion as re","re.id","rr.id_resolucion")
                        ->join("autorizacion as a","a.id","re.id_autorizacion")
                        ->where("rr.estado",1)
                        ->where("a.estado",1)
                        ->where("a.id_empresa",$id)
                        ->orderBy("r.id","asc");

            if(isset($request->autorizacion)):
                $response = $response->where('a.id',$request->autorizacion);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 

        }
        $response["empresa"] = DB::table("empresa as e")
                        ->select(
                            "e.id",
                            "e.ruc",
                            "e.nombre_imprimir as Nombre",
                            "e.rutas as Rutas",
                            "e.vehiculos as Vehiculos"
                        )
                        ->where("e.id",$id)
                        ->first();
        $response["autorizacion"] = DB::table("autorizacion as a")
                        ->select(
                            "a.id",
                            "t.nombre as Tipo",
                            "a.numero as Resolucion",
                            "a.rutas as Rutas"
                        )
                        ->join("tipo as t","t.id","a.id_tipo")
                        ->where("a.estado",1)
                        ->where("a.id_empresa",$id)
                        ->get();
        return view("extranet.empresa.ruta",$response);
    }
    public function vehiculo(Request $request,$id){
        if ($request->input('datatable')) {

            $response = DB::table("vehiculo as v")
                        ->select(
                            "v.id as RowId",
                            "a.id as RowIdA",
                            "v.placa as Placa",
                            "m.nombre as Marca",
                            "c.nombre as Categoria",
                            "v.fabricacion as Fabricacion",
                            "re.numero as Resolucion",
                            DB::raw("IF(rv.estado=1,'activo','inactivo') as Estado"),
                            DB::raw('"" as Botones')
                        )
                        ->leftJoin("marca as m","m.id","v.id_marca")
                        ->leftJoin("categoria as c","c.id","v.id_categoria")
                        // ->join('resolucion_vehiculo as rv', function ($join) {
                        //     $join->on('rv.id_vehiculo', '=', 'v.id')
                        //             ->where("rv.estado",1);
                        // })
                        // ->Join("resolucion as re","re.id","rv.id_resolucion")

                        ->join("resolucion_vehiculo as rv","rv.id_vehiculo","v.id")
                        ->join("resolucion as re","re.id","rv.id_resolucion")
                        ->join("autorizacion as a","a.id","re.id_autorizacion")
                        ->where("rv.estado",1)
                        ->where("a.estado",1)

                        ->where("a.id_empresa",$id);
                        // ->where("ev.id_empresa",;

            if(isset($request->autorizacion)):
                $response = $response->where('a.id',$request->autorizacion);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 

        }
        $response["empresa"] = DB::table("empresa as e")
                        ->select(
                            "e.id",
                            "e.ruc",
                            "e.nombre_imprimir as Nombre"
                        )
                        ->where("e.id",$id)
                        ->first();
        $response["autorizacion"] = DB::table("autorizacion as a")
                        ->select(
                            "a.id",
                            "t.nombre as Tipo",
                            "a.numero as Resolucion",
                            "a.vehiculos as Vehiculos",
                            "a.cerrar as Cerrar"
                        )
                        ->join("tipo as t","t.id","a.id_tipo")
                        ->where("a.estado",1)
                        ->where("a.id_empresa",$id)
                        ->get();
        $response["categoria"] = DB::table("categoria as c")
                        ->get();
        return view("extranet.empresa.vehiculo",$response);
    }
    public function add_vehiculo(Request $request,$id){
        // dd($request);
        DB::beginTransaction();
        try {
        $id_users= Auth::user()->id;
            $query = DB::table("resolucion_vehiculo as rv")
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->where("r.id_empresa",$request->ide)
                        ->where("r.estado",1)
                        ->where("rv.id_vehiculo",$request->vehiculo)
                        ->get();
            if(count($query))
            {
                // dd($query);
                $response["status"] = false;
                $response["message"] = 'El vehiculo ya pertenece a la empresa.';
                return $response;
            } else {
                $res = DB::table("resolucion")
                        ->where("id_autorizacion",$id)
                        ->where("tipo",0)
                        ->where("estado",1)
                        ->orderBy("id","desc")
                        ->first();

                $activos = DB::table("resolucion_vehiculo as rv")   
                        ->select("r.fecha_ini","r.id_autorizacion","r.id_empresa","rv.id_vehiculo")    
                        ->join("resolucion as r","r.id","rv.id_resolucion")
                        ->where("rv.id_vehiculo",$request->vehiculo)
                        ->where("rv.estado",1)
                        ->get();
                if(count($activos)>0){

                    $resolucion_activos = new Resolucion;
                    $resolucion_activos->numero = $res->numero;
                    $resolucion_activos->fecha_ini = $activos[0]->fecha_ini;
                    $resolucion_activos->fecha = $activos[0]->fecha_ini;
                    $resolucion_activos->fecha_fin = $activos[0]->fecha_ini;
                    $resolucion_activos->id_empresa = $activos[0]->id_empresa;
                    $resolucion_activos->id_autorizacion = $activos[0]->id_autorizacion;
                    $resolucion_activos->estado = 0;
                    $resolucion_activos->tipo = 0;
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
                    ->where("id_vehiculo",$request->vehiculo)
                    ->where("estado",1)
                    ->update([
                        "estado"=>0
                    ]);
                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $res->id;
                $r_vehiculo->id_vehiculo = $request->vehiculo;
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
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
    public function terminal(Request $request,$id){
        if ($request->input('datatable')) {

            $response = DB::table("terminal as t")
                        ->select(
                            "t.id as RowId",
                            "t.direccion as Direccion",
                            "t.certificado_habilitacion as CertificadoHabilitacion",
                            // "re.numero as Resolucion",
                            DB::raw('"" as Botones')
                        )
                        // ->leftJoin("resolucion_terminal as rt","rt.id_terminal","t.id")
                        // ->join("resolucion as re","re.id","rt.id_resolucion")
                        // ->where("rr.estado",1)
                        ->where("t.id_empresa",$id);


            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 

        }
        $response["empresa"] = DB::table("empresa as e")
                        ->select(
                            "e.id",
                            "e.ruc",
                            "e.nombre_imprimir as Nombre"
                        )
                        // ->join("tipo_empresa as te","te.id_empresa","e.id")
                        // ->join("tipo as t","t.id","te.id_tipo")
                        ->where("e.id",$id)
                        ->first();
        return view("extranet.empresa.terminal",$response);
    }
    public function oficina(Request $request,$id){
        if ($request->input('datatable')) {

            $response = DB::table("oficina as o")
                        ->select(
                            "o.id as RowId",
                            "o.direccion as Direccion",
                            // "re.numero as Resolucion",
                            DB::raw('"" as Botones')
                        )
                        // ->leftJoin("resolucion_terminal as rt","rt.id_terminal","t.id")
                        // ->join("resolucion as re","re.id","rt.id_resolucion")
                        // ->where("rr.estado",1)
                        ->where("o.id_empresa",$id);


            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 

        }
        $response["empresa"] = DB::table("empresa as e")
                        ->select(
                            "e.id",
                            "e.ruc",
                            "e.nombre_imprimir as Nombre"
                            // "t.nombre as Tipo"
                        )
                        // ->join("tipo_empresa as te","te.id_empresa","e.id")
                        // ->join("tipo as t","t.id","te.id_tipo")
                        ->where("e.id",$id)
                        // ->where("te.estado",1)
                        ->first();
        return view("extranet.empresa.oficina",$response);
    }
    public function gerente(Request $request,$id){
        if ($request->input('datatable')) {

            $response = DB::table("gerente as g")
                        ->select(
                            "g.id as RowId",
                            DB::raw("CONCAT(g.paterno,' ',g.materno) as Apellidos"),
                            "g.nombres as Nombres",
                            "g.documento as Documento",
                            "g.telefono as Telefono",
                            "g.direccion as Direccion",
                            "g.email as Email",
                            DB::raw("IF(g.estado=1,'Activo','Inactivo') as Estado"),
                            DB::raw('"" as Botones')
                        )
                        // ->leftJoin("resolucion_terminal as rt","rt.id_terminal","t.id")
                        // ->join("resolucion as re","re.id","rt.id_resolucion")
                        // ->where("rr.estado",1)
                        ->where("g.id_empresa",$id);


            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 

        }
        $response["empresa"] = DB::table("empresa as e")
                        ->select(
                            "e.id",
                            "e.ruc",
                            "e.nombre_imprimir as Nombre"
                            // "t.nombre as Tipo"
                        )
                        // ->join("tipo_empresa as te","te.id_empresa","e.id")
                        // ->join("tipo as t","t.id","te.id_tipo")
                        ->where("e.id",$id)
                        // ->where("te.estado",1)
                        ->first();
        return view("extranet.empresa.gerente",$response);
    }

    public function select2(Request $request){
        $search = $request->q;
        $response["items"] = DB::table("empresa as e")
                ->select(
                    "e.id",
                    DB::raw("CONCAT(e.ruc,' | ',e.razon_social) as text")
                    // "te.id_tipo as idTipo"
                    
                )
                // ->where("v.placa","like","%$search%")
                ->where(function ($query)  use ($search){
                    $query->where("e.razon_social","like","%$search%")
                        ->orWhere("e.ruc","like","%$search%");
                })
                // ->join("tipo_empresa as te","te.id_empresa","e.id")
                // ->leftJoin('tipo_empresa as te', function ($join) {
                //     $join->on('te.id_empresa', '=', 'e.id')
                //             ->where("te.estado",1);
                // })
                ->get();
        return $response;
    }
}
