<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

class SunatController extends Controller
{
    public function dni($dni){

    	try { 
    		
			$cs = new Dni(new ContextClient(), new DniParser());

			$person = $cs->get($dni);

			if ($person === false) {
			    // echo $cs->getError();
			    // exit();
			    $response["message"]= $cs->getError();
			    $response["status"]= false;
			}else{
				// echo json_encode($person);
				$response["message"]= "Datos Obtenidos.";
			    $response["status"]= true;
			    $response["datos"]= $person;
			}
		} catch (\Exception $e) {
            $response["message"]= "No existe en la base de datos";
			$response["status"]= false;
        }
		return $response;
    }
    public function ruc($ruc){

		try { 
    		
			$cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser()));

			$company = $cs->get($ruc);

			if (!$company) {
			    // echo $cs->getError();
			    // exit();
			    $response["message"]= "No existe en la base de datos";
			    $response["status"]= false;
			}else{
				// echo json_encode($person);
				$response["message"]= "Datos Obtenidos.";
			    $response["status"]= true;
			    $response["datos"]= $company;
			}
		} catch (\Exception $e) {
            $response["message"]= "No existe en la base de datos";
			$response["status"]= false;
        }
		return $response;

    }
}
