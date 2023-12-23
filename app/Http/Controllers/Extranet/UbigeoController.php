<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UbigeoController extends Controller
{
    public function select2departamento(Request $request){
    	$response["items"] = DB::table("ubigeo")
    					->select("departamento as id","nombre as text")
    					->where("provincia","0")
    					->where("distrito","0")
    					->where("nombre","like","$request->q%")
    					->get();
    	return $response;
    }
    public function select2provincia(Request $request){
    	// return "hola".$request->departamento;
    	$response["items"] = DB::table("ubigeo")
    					->select("provincia as id","nombre as text")
    					->where("distrito","0")
    					->where("provincia","!=","0")
    					->where("departamento",(string)$request->departamento)
    					->where("nombre","like","$request->q%")
    					->get();
    	return $response;
    }
    public function select2distrito(Request $request){
    	// return "hola".$request->departamento;
    	$response["items"] = DB::table("ubigeo")
    					->select("id","nombre as text")
    					->where("distrito","!=","0")
    					// ->where("provincia","!=","0")
    					->where("departamento",(string)$request->departamento)
    					->where("provincia",(string)$request->provincia)
    					->where("nombre","like","$request->q%")
    					->get();
    	return $response;
    }
}
