<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\Empresa;
use App\Models\Autorizacion;
use App\Models\Resolucion;
use App\Models\TipoEmpresa;

class AutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view("extranet.autorizacion.create",$response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $id_users = Auth::user()->id;
            $config = DB::table("config")
                        ->first();
            $numero = $request->resolucion."-".$request->anio."-".$config->siglas;

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
            $autorizacion->id_empresa = $request->empresa;
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
            $resolucion->id_empresa = $request->empresa;
            $resolucion->id_autorizacion = $autorizacion->id;
            $resolucion->id_users = $id_users;
            $resolucion->save();

            ///**************
                // $empresa = Empresa::find($request->empresa);
                // $empresa->rutas = $request->rutas;
                // $empresa->vehiculos = $request->vehiculos;
                // $empresa->save();

                // $res = DB::table("resolucion")
                //     ->where("id_empresa",$request->empresa)
                //     ->where("estado",1)
                //     ->get();
                // foreach ($res as $value) {
                //     DB::table("resolucion_vehiculo")
                //         ->where("id_resolucion",$value->id)
                //         ->where("estado",1)
                //         ->update([
                //             "estado"=>0
                //         ]);
                //     DB::table("resolucion_ruta")
                //         ->where("id_resolucion",$value->id)
                //         ->where("estado",1)
                //         ->update([
                //             "estado"=>0
                //         ]);
                // }

                // DB::table("tipo_empresa")
                //     ->where("id_empresa",$request->empresa)
                //     ->where("estado",1)
                //     ->update([
                //         "estado"=>0
                //     ]);  
                // DB::table("resolucion")
                //     ->where("id_empresa",$request->empresa)
                //     ->where("estado",1)
                //     ->update([
                //         "estado"=>0
                //     ]);

                // $temp_ini = \DateTime::createFromFormat('d/m/Y', $request->fecha_ini);
                // $date_ini = $temp_ini->format('Y-m-d');

                // $temp_fin = \DateTime::createFromFormat('d/m/Y', $request->fecha_fin);
                // $date_fin = $temp_fin->format('Y-m-d');

                // $resolucion = new Resolucion;
                // $resolucion->numero = $request->resolucion;
                // $resolucion->fecha_ini = $date_ini;
                // $resolucion->fecha_fin = $date_fin;
                // $resolucion->rutas = $request->rutas;
                // $resolucion->vehiculos = $request->vehiculos;
                // $resolucion->descripcion = $request->descripcion;
                // $resolucion->id_empresa = $request->empresa;
                // $resolucion->save();

                // $tipo = new TipoEmpresa;
                // $tipo->id_tipo = $request->tipo;
                // $tipo->id_empresa = $request->empresa;
                // $tipo->id_resolucion = $resolucion->id;
                // $tipo->save();

            DB::commit();
            $message = 'Guardado.';
            $response["id"] = $request->empresa;
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
        //
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
        //
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
    public function select($id){
        $response["data"] = DB::table("autorizacion as a")
                    ->select(
                        "a.*",
                        "t.nombre as Tipo"
                    )
                    ->join("tipo as t","t.id","a.id_tipo")
                    ->where("a.estado",1)
                    ->where("a.id_empresa",$id)
                    ->get();
        return $response;
    }
    public function cerrar($id){
        // dd($id);
        DB::beginTransaction();
        try {

            $data = Autorizacion::find($id);
            $data->cerrar = 1;
            $data->save();

            DB::commit();
            $message = 'Autorizacion Cerrado.';
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Cerrar. Intente otra vez.';
            $status = false;
        }
        $response["status"] = $status;
        $response["message"] = $message;
        return $response;
    }
}
