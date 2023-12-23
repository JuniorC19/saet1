<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Marca;
use DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('datatable')) {
            $response = DB::table("marca as m")
                        ->select(
                            "m.id as RowId",
                            "m.nombre as Nombre",
                            "c.nombre as Categoria",
                            DB::raw('"" as Botones')
                        )
                        ->join("categoria as c","c.id","m.id_categoria");
            if(isset($request->categoria)):
                $response = $response->where("id_categoria",$request->categoria);
            endif;

            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
        }
        $response["categoria"] = DB::table("categoria")
                            ->get();
        return view("extranet.configuracion.marca",$response);
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
        DB::beginTransaction();
        try {  

            $data = new Marca;
            $data->nombre = strtoupper($request->nombre);
            $data->id_categoria = $request->categoria;
            $data->save();

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
        $response["data"] = DB::table("marca")
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

            $data = Marca::find($id);
            $data->nombre = strtoupper($request->nombre);
            $data->id_categoria = $request->categoria;
            $data->save();

            DB::commit();
            $message = 'Editado.';
            $status = true;
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Error al Editar. Intente otra vez.';
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
    public function select2(Request $request){
        $search = $request->q;
        $query = DB::table("marca as m")
                ->select(
                    "m.id",
                    "m.nombre as text"
                )
                ->where("m.nombre","like","%$search%");

        if(isset($request->c)&&$request->c!=""):
            $query = $query->where('m.id_categoria',$request->c);
        endif;

        $response["items"] = $query->get();
                // ->get();
        return $response;
    }
}
