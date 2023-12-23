<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\Ruta;
use App\Models\Itinerario;
use App\Models\ResolucionRuta;

class RutasController extends Controller
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
        //
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
            $id_users= Auth::user()->id;
            $res = DB::table("resolucion")
                    ->where("id_autorizacion",$request->ida)
                    ->where("tipo",0)
                    ->where("estado",1)
                    ->orderBy("id","desc")
                    ->first();

            $ruta = new Ruta;
            $ruta->origen = $request->origen;
            $ruta->destino = $request->destino;
            $ruta->frecuencia = $request->frecuencia;
            $ruta->id_empresa = $request->ide;
            $ruta->id_users = $id_users;
            $ruta->save();

            if(isset($request->itinerario)){
                // DB::table("itinerario")
                //         ->where("id_ruta",$id)
                //         ->delete();
                foreach ($request->itinerario as $value) {
                    $itinerario = new Itinerario;
                    $itinerario->nombre = $value;
                    $itinerario->id_ruta = $ruta->id;
                    $itinerario->id_users = $id_users;
                    $itinerario->save();
                }
            }

            $r_ruta = new ResolucionRuta;
            $r_ruta->id_resolucion = $res->id;
            $r_ruta->id_ruta = $ruta->id;
            $r_ruta->id_users = $id_users;
            $r_ruta->save();
                        
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
        $response["ruta"] = DB::table("ruta as r")
                            ->select("r.*")
                            ->where("r.id",$id)
                            ->first();
        $response["itinerario"] = DB::table("itinerario")
                            ->where("id_ruta",$id)
                            ->get();
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
        $id_users = Auth::user()->id;
        DB::beginTransaction();
        try {
            $ruta = Ruta::find($id);
            $ruta->origen = $request->origen;
            $ruta->destino = $request->destino;
            $ruta->frecuencia = $request->frecuencia;
            $ruta->id_users = $id_users;
            $ruta->save();

            DB::table("itinerario")
                    ->where("id_ruta",$id)
                    ->delete();
            if(isset($request->itinerario)){
                foreach ($request->itinerario as $value) {
                    $itinerario = new Itinerario;
                    $itinerario->nombre = $value;
                    $itinerario->id_ruta = $id;
                    $itinerario->id_users = $id_users;
                    $itinerario->save();
                }
            }
            DB::commit();
            $message = 'Actulizado.';
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Actualizar. Intente otra vez.';
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
}
