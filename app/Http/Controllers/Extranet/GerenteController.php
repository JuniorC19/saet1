<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gerente;
use DB;

class GerenteController extends Controller
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
            $gerente = new Gerente;
            $gerente->documento = $request->documento;
            $gerente->paterno = $request->paterno;
            $gerente->materno = $request->materno;
            $gerente->nombres = $request->nombres;
            $gerente->telefono = $request->telefono;
            $gerente->email = $request->email;
            $gerente->direccion = $request->direccion;
            $gerente->id_empresa = $request->ide;
            if(isset($request->activo)){
                DB::table("gerente")
                    ->where("id_empresa",$request->ide)
                    ->update([
                        "estado"=>0
                    ]);
                $gerente->estado = 1;   
            }else{
                $gerente->estado = 0;   
            }
            $gerente->save();


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
        $response["data"] = DB::table("gerente")
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
        DB::beginTransaction();
        try {
            $gerente = Gerente::find($id);
            $gerente->documento = $request->documento;
            $gerente->paterno = $request->paterno;
            $gerente->materno = $request->materno;
            $gerente->nombres = $request->nombres;
            $gerente->telefono = $request->telefono;
            $gerente->email = $request->email;
            $gerente->direccion = $request->direccion;
            $gerente->id_empresa = $request->ide;
            if(isset($request->activo)){
                DB::table("gerente")
                    ->where("id_empresa",$request->ide)
                    ->update([
                        "estado"=>0
                    ]);
                $gerente->estado = 1;   
            }
            $gerente->save();

            DB::commit();
            $message = 'Actulizado.';
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Actulizar. Intente otra vez.';
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

