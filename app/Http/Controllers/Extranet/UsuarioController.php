<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Users;
use Auth;
use DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        if ($request->input('datatable')) {
            $response = DB::table("users as u")
                        ->select(
                            "u.id as RowId",
                            "u.name as Name",
                            "u.email as Email",
                            "r.name as Rol",
                            DB::raw('"" as Botones')
                        )
                        ->leftJoin("model_has_roles as mr","mr.model_id","u.id")
                        ->leftJoin("roles as r","r.id","mr.role_id");
            $response = $response->get();
            return DataTables::of($response)
                    ->make('true'); 
        }
        $response["roles"] = DB::table("roles")
                            ->get();
        return view("extranet.usuario.index",$response);
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

            $data = new Users;
            $data->name = $request->nombre;
            $data->email = $request->user;
            $data->password = bcrypt($request->password);
            $data->created_at = date("Y-m-d H:i:s");
            $data->save();

            DB::table("model_has_roles")
                        ->insert([
                            'role_id' => $request->rol,
                            'model_type' => 'App\User',
                            'model_id' => $data->id
                        ]);

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
        $response["data"] = DB::table("users as u")
                                ->where("u.id",$id)
                                ->leftJoin("model_has_roles as mr","mr.model_id","u.id")
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

            $data = Users::find($id);
            $data->name = $request->nombre;
            $data->email = $request->user;
            if(isset($request->edit_pass)){
                $data->password = bcrypt($request->password);
            }
            $data->created_at = date("Y-m-d H:i:s");
            $data->save();

            DB::table("model_has_roles")
                        ->where('model_id',$id)
                        ->delete();

            DB::table("model_has_roles")
                        ->insert([
                            'role_id' => $request->rol,
                            'model_type' => 'App\User',
                            'model_id' => $id
                        ]);

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

    public function perfil(){
        $id = Auth::user()->id;
        $response["perfil"] = DB::table("users as u")
                        ->select(
                            "u.name as Name",
                            "u.email as Email"
                        )
                        ->where("u.id",$id)
                        ->first();
        return view("extranet.usuario.perfil",$response);
    }
    public function perfil_save(Request $request)
    {
        DB::beginTransaction();
        try {  

            $id = Auth::user()->id;
            
            $data = Users::find($id);
            $data->name = $request->nombre;
            if(isset($request->edit_pass)){
                $data->password = bcrypt($request->password);
            }
            $data->updated_at = date("Y-m-d H:i:s");
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
}
