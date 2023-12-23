<?php

namespace App\Http\Controllers\Extranet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\ResolucionVehiculo;
use App\Models\Vehiculo;
use App\Models\EmpresaVehiculo;
use PdfTuc;
include("phpqrcode/qrlib.php");
use Qrcode;

class VehiculoController extends Controller
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
        
        // dd($res);
        DB::beginTransaction();
        try {

            $id_users = Auth::user()->id;

            $temp = \DateTime::createFromFormat('d/m/Y', $request->fecha);
            $date = $temp->format('Y-m-d');
            $vehiculo = new Vehiculo;
            $vehiculo->fecha = $date;
            $vehiculo->placa = $request->placa;
            $vehiculo->fabricacion = $request->fabricacion;
            $vehiculo->estado = $request->estado;
            $vehiculo->id_marca = $request->marca;
            $vehiculo->id_categoria = $request->categoria;
            $vehiculo->clase = $request->clase;
            $vehiculo->anio_fabrica = $request->anio_fabrica;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->combustible = $request->combustible;
            $vehiculo->carroceria = $request->carroceria;
            $vehiculo->color = $request->color;
            $vehiculo->n_motor = $request->n_motor;
            $vehiculo->n_chasis = $request->n_chasis;
            $vehiculo->n_ejes = $request->n_ejes;
            $vehiculo->n_cilindros = $request->n_cilindros;
            $vehiculo->n_ruedas = $request->n_ruedas;
            $vehiculo->n_pasajeros = $request->n_pasajeros;
            $vehiculo->n_asientos = $request->n_asientos;
            $vehiculo->peso_neto = $request->peso_neto;
            $vehiculo->peso_bruto = $request->peso_bruto;
            $vehiculo->carga_util = $request->carga_util;
            $vehiculo->largo = $request->largo;
            $vehiculo->alto = $request->alto;
            $vehiculo->ancho = $request->ancho;
            $vehiculo->acc_seguridad = $request->acc_seguridad;
            $vehiculo->n_puertas = $request->n_puertas;
            $vehiculo->tacografo = $request->tacografo;
            $vehiculo->n_salida_emergencia = $request->n_salida_emergencia;
            $vehiculo->reg_seguridad = $request->reg_seguridad;
            $vehiculo->limitador_seguridad = $request->limitador_seguridad;
            $vehiculo->sistema_comunicacion = $request->sistema_comunicacion;
            $vehiculo->observacion = $request->observacion;
            $vehiculo->id_users = $id_users;
            if(isset($request->asignar)){
                $temp_v = \DateTime::createFromFormat('d/m/Y', $request->vencimiento);
                $ven = $temp_v->format('Y-m-d');
                $vehiculo->conductor = 1;
                $vehiculo->paterno = $request->paterno;
                $vehiculo->materno = $request->materno;
                $vehiculo->nombres = $request->nombres;
                $vehiculo->documento = $request->documento;
                $vehiculo->estado_licencia = $request->estado_licencia;
                $vehiculo->vencimiento = $ven;
                $vehiculo->cat = $request->cat;
                $vehiculo->direccion = $request->direccion;

                if(isset($request->distrito)):
                    $vehiculo->id_ubigeo = $request->distrito;
                endif;
            }
            $vehiculo->save();

            if(isset($request->ida)){           
                $res = DB::table("resolucion")
                        ->where("id_autorizacion",$request->ida)
                        ->where("tipo",0)
                        ->where("estado",1)
                        ->orderBy("id","desc")
                        ->first();
                $r_vehiculo = new ResolucionVehiculo;
                $r_vehiculo->id_resolucion = $res->id;
                $r_vehiculo->id_vehiculo = $vehiculo->id;
                $r_vehiculo->id_users = $id_users;
                $r_vehiculo->save();
            } 

            DB::commit();
            $message = 'Guardado.';
            $response["id"] = $vehiculo->id;
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
        $response["vehiculo"] = DB::table("vehiculo as v")
                                ->select(
                                    "v.*",
                                    "m.nombre as Marca",
                                    "c.nombre as Carroceria",
                                    DB::raw("DATE_FORMAT(v.fecha,'%d/%m/%Y') as Fecha"),
                                    DB::raw("DATE_FORMAT(v.vencimiento,'%d/%m/%Y') as vencimiento")
                                )
                                ->leftJoin("marca as m","m.id","v.id_marca")
                                ->leftJoin("carroceria as c","c.id","v.id_carroceria")
                                ->where("v.id",$id)
                                ->first();
        if(!empty($response["vehiculo"]->id_ubigeo)){
            $response['distrito'] = DB::table('ubigeo')
                            ->select('nombre','provincia','departamento')
                            ->where('id',$response["vehiculo"]->id_ubigeo)
                            ->first();

            $response['provincia'] = DB::table('ubigeo')
                            ->select('nombre')
                            ->where('provincia',$response['distrito']->provincia)
                            ->where('departamento',$response['distrito']->departamento)
                            ->where('distrito','0')
                            ->first();

            $response['departamento'] = DB::table('ubigeo')
                            ->select('nombre')
                            ->where('departamento',$response['distrito']->departamento)
                            ->where('provincia','0')
                            ->where('distrito','0')
                            ->first();
        }else{
            $response['departamento'] = new \stdClass(); 
            $response['distrito'] = new \stdClass(); 
            $response['provincia'] = new \stdClass(); 

            $response['departamento']->nombre = ""; 
            $response['distrito']->nombre = ""; 
            $response['provincia']->nombre = ""; 
        }

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
            $id_users = Auth::user()->id;

            $temp = \DateTime::createFromFormat('d/m/Y', $request->fecha);
            $date = $temp->format('Y-m-d');

            $vehiculo = Vehiculo::find($id);
            $vehiculo->fecha = $date;
            $vehiculo->fabricacion = $request->fabricacion;
            $vehiculo->estado = $request->estado;
            $vehiculo->id_marca = $request->marca;
            $vehiculo->id_categoria = $request->categoria;
            $vehiculo->clase = $request->clase;
            $vehiculo->anio_fabrica = $request->anio_fabrica;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->combustible = $request->combustible;
            $vehiculo->id_carroceria = $request->carroceria;
            $vehiculo->color = $request->color;
            $vehiculo->n_motor = $request->n_motor;
            $vehiculo->n_chasis = $request->n_chasis;
            $vehiculo->n_ejes = $request->n_ejes;
            $vehiculo->n_cilindros = $request->n_cilindros;
            $vehiculo->n_ruedas = $request->n_ruedas;
            $vehiculo->n_pasajeros = $request->n_pasajeros;
            $vehiculo->n_asientos = $request->n_asientos;
            $vehiculo->peso_neto = $request->peso_neto;
            $vehiculo->peso_bruto = $request->peso_bruto;
            $vehiculo->carga_util = $request->carga_util;
            $vehiculo->largo = $request->largo;
            $vehiculo->alto = $request->alto;
            $vehiculo->ancho = $request->ancho;
            $vehiculo->acc_seguridad = $request->acc_seguridad;
            $vehiculo->n_puertas = $request->n_puertas;
            $vehiculo->tacografo = $request->tacografo;
            $vehiculo->n_salida_emergencia = $request->n_salida_emergencia;
            $vehiculo->reg_seguridad = $request->reg_seguridad;
            $vehiculo->limitador_seguridad = $request->limitador_seguridad;
            $vehiculo->sistema_comunicacion = $request->sistema_comunicacion;
            $vehiculo->observacion = $request->observacion;
            $vehiculo->id_users = $id_users;
            if(isset($request->asignar)){
                $temp_v = \DateTime::createFromFormat('d/m/Y', $request->vencimiento);
                $ven = $temp_v->format('Y-m-d');
                $vehiculo->conductor = 1;
                $vehiculo->paterno = $request->paterno;
                $vehiculo->materno = $request->materno;
                $vehiculo->nombres = $request->nombres;
                $vehiculo->documento = $request->documento;
                $vehiculo->estado_licencia = $request->estado_licencia;
                $vehiculo->vencimiento = $ven;
                $vehiculo->cat = $request->cat;
                $vehiculo->direccion = $request->direccion;

                if(isset($request->distrito)):
                    $vehiculo->id_ubigeo = $request->distrito;
                endif;
            }
            $vehiculo->save();

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
    public function select2(Request $request){
        $search = $request->q;
        $response["items"] = DB::table("vehiculo as v")
                ->select(
                    "v.id",
                    DB::raw("CONCAT(v.placa,' | ',IFNULL(m.nombre,''),'|',IFNULL(c.nombre,'')) as text"),
                    "v.placa",
                    "m.nombre as marca",
                    "c.nombre as categoria",
                    "v.fabricacion"
                    
                )
                ->where("v.placa","like","%$search%")
                ->leftJoin("marca as m","m.id","v.id_marca")
                ->leftJoin("categoria as c","c.id","v.id_categoria")
                ->get();
        return $response;
    }
    public function historial($id){
        $response["historial"] = DB::table("resolucion_vehiculo as rv")
                    ->select(
                        "e.ruc as Ruc",
                        "e.razon_social as RazonSocial",
                        "r.numero as Resolucion",
                        "r.fecha_ini as FechaIni",
                        "r.fecha_fin as FechaFin",
                        DB::raw("IF(rv.estado=1,'activo','inactivo') as Estado"),
                        DB::raw("CASE 
                                    WHEN r.tipo = 0 THEN CONCAT('AUTORIZACION ',IFNULL(rv.comentario,''))
                                    WHEN r.tipo = 6 THEN CONCAT('SUSTITUCION ',IFNULL(rv.comentario,''))
                                    WHEN r.tipo = 7 THEN CONCAT('INCREMENTO ',IFNULL(rv.comentario,''))
                                    WHEN r.tipo = 8 THEN CONCAT('BAJA ',IFNULL(rv.comentario,''))
                                    ELSE ' '
                                    END AS Comentario")
                    )
                    ->join("resolucion as r","r.id","rv.id_resolucion")
                    ->join("empresa as e","e.id","r.id_empresa")
                    ->where("rv.id_vehiculo",$id)
                    ->orderBy("rv.id","desc")
                    ->get();
        return $response;
    }
    public function pdf($id){
        $ids = explode("-",$id);
        
        // dd($ids);
        $vehiculo = DB::table("vehiculo as v")
                        ->select(
                            // "v.id as RowId",
                            DB::raw("DATE_FORMAT(re.fecha_ini,'%d/%m/%Y') as FechaIni"),
                             DB::raw("DATE_FORMAT(re.fecha_fin,'%d/%m/%Y') as FechaFin"),
                            "v.color as Color",
                            "v.placa as Placa",
                            "v.n_asientos as Asientos",
                            "v.fabricacion as Fabricacion",
                            "v.n_chasis as Chasis",
                            "v.n_ejes as Ejes",
                            "v.largo as Largo",
                            "v.alto as Alto",
                            "v.ancho as Ancho",
                            "v.peso_neto as PesoNeto",
                            "v.carga_util as CargaUtil",
                            "v.peso_bruto as PesoBruto",
                            "m.nombre as Marca",
                            "c.nombre as Categoria",
                            "re.numero as Resolucion"
                        )
                        ->leftJoin("marca as m","m.id","v.id_marca")
                        ->leftJoin("categoria as c","c.id","v.id_categoria")

                        ->join("resolucion_vehiculo as rv","rv.id_vehiculo","v.id")
                        ->join("resolucion as re","re.id","rv.id_resolucion")
                        ->join("autorizacion as a","a.id","re.id_autorizacion")
                        ->where("rv.estado",1)
                        ->where("re.estado",1)
                        ->where("a.estado",1)
                        ->where("v.id",$ids[0])
                        ->where("a.id",$ids[1])
                        ->first();
        $empresa = DB::table("autorizacion as a")
                    ->select(
                        "e.nombre_imprimir as Nombre",
                        "e.ruc as Ruc",
                        "e.partida_electronico as Partida"
                    )
                    ->join("empresa as e","e.id","a.id_empresa")
                    ->where("a.id",$ids[1])
                    ->first();
        $rutas = DB::table("ruta as r")
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
                        ->where("a.id",$ids[1])
                        ->get();
        // dd($rutas);
        QRcode::png($vehiculo->Placa,"test.png");
        // QRcode::png("https://www.youtube.com/watch?v=UEwEK5FLHIY","test.png");
        $pdf = new PdfTuc($orientation='L',$unit='mm', array(85,55));
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins(0,0,0);

        $x = 5;
        $y = 15;
            // 75
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',5);
            $pdf->MultiCell(15,3,utf8_decode("PLACA: "),0,"R");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(20,3,utf8_decode($vehiculo->Placa),0,"L");

            $pdf->SetXY($x+35,$y);
            $pdf->SetFont('Arial','B',5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(40,3,utf8_decode("N° DE IMPRESIÓN: 00000"),0,"R");

            $y=$y+6;

            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("RAZÓN SOCIAL"),0,"L");

            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(60,2,utf8_decode(":".$empresa->Nombre),0,"L");

            $y=$y+3;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("RUC"),0,"L");

            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$empresa->Ruc),0,"L");
            
            $pdf->SetXY($x+37,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("PARTIDA REG"),0,"L");
            $pdf->SetXY($x+52,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$empresa->Partida),0,"L");

            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("N° CHASIS"),0,"L");

            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->Chasis),0,"L");
            
            $pdf->SetXY($x+37,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("N° ASIENTOS"),0,"L");
            $pdf->SetXY($x+52,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->Asientos),0,"L");

            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("MARCA"),0,"L");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->Marca),0,"L");
            
            $pdf->SetXY($x+37,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("PESO NETO"),0,"L");
            $pdf->SetXY($x+52,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->PesoNeto),0,"L");

            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("AÑO DE FABR."),0,"L");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->Fabricacion),0,"L");
            
            $pdf->SetXY($x+37,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("CARGA UTIL"),0,"L");
            $pdf->SetXY($x+52,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->CargaUtil),0,"L");

            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("COLOR"),0,"L");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->Color),0,"L");

            $y=$y+5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->MultiCell(75,2,utf8_decode("RDR N° ".$vehiculo->Resolucion.".".$vehiculo->FechaIni),0,"L");

            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("F. EXPEDICION"),0,"L");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->FechaIni),0,"L");
            $y=$y+2.5;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(15,2,utf8_decode("F.VENCIMIENTO"),0,"L");
            $pdf->SetXY($x+15,$y);
            $pdf->SetFont('Arial','B',4.5);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(21,2,utf8_decode(":".$vehiculo->FechaFin),0,"L");
            
        // $pdf->Line(3,11,19,11);
        // $pdf->Line(3,29,19,29);
        // $pdf->Line(3,11,3,29);
        // $pdf->Line(19,11,19,29);


        $pdf->Line(0.5,0.5,85,0.5);
        $pdf->Line(0.5,54.5,85,54.5);

        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins(0,0,0);

        $pdf->SetLineWidth(0.1);

        $pdf->Image("test.png",65,5,16,16,"png");
        $y=15;
        $x=5;
        $pdf->SetXY($x,$y);
        $pdf->SetFont('Arial','B',5);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell(50,3,utf8_decode("CERTIFICADO DE HABILITACION VEHICULAR N° 00000"),0,"L");
        $y=$y+3;

        $pdf->SetXY($x,$y);
        $pdf->SetFont('Arial','B',6);
        $pdf->MultiCell(75,3,utf8_decode("RUTAS AUTORIZADAS A OPERAR"),0,"C");
        // for($i=65; $i<=90; $i++) {  
        //     $letra = chr($i);  
        //     echo $letra;  
        // }
        $i = 1; 
        $y=$y+1;
        foreach ($rutas as $key => $value) {
            # code...
            $y=$y+2;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(1,5,64);
            $pdf->MultiCell(11,2,utf8_decode("RUTA(".$i.")"),0,"L");

            $pdf->SetXY($x+11,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(54,2,utf8_decode(": ".$value->Origen." - ".$value->Destino),0,"L");

            $y=$y+2;
            $pdf->SetXY($x,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->MultiCell(11,2,utf8_decode("ITINERARIO"),0,"L");

            $itinerario = "SIN ITINERARIO";
            if(!empty($value->Itinerario)){
                $itinerario = $value->Itinerario;
            }else{
                $itinerario = "SIN ITINERARIO";

            }
            $pdf->SetXY($x+11,$y);
            $pdf->SetFont('Arial','B',4);
            $pdf->MultiCell(54,2,utf8_decode(": ".$itinerario),0,"L");

            $i++;
        }
        $pdf->Line(0.5,0.5,85,0.5);
        $pdf->Line(0.5,54.5,85,54.5);
        $pdf->Output("I","Tuc.pdf");
        exit;
    }
    public function qr($id){
         $data = 'saet.transportespuno.gob.pe/extranet/empresa';
         // $options = new QROptions([
        //     'version'      => 7,
        //     'outputType'   => QRCode::OUTPUT_IMAGE_PNG,
        //     'eccLevel'     => QRCode::ECC_L,
        //     'scale'        => 5,
        //     'imageBase64'  => true,
        //     'moduleValues' => [
        //         // finder
        //         1536 => [0, 63, 255], // dark (true)
        //         6    => [255, 255, 255], // light (false), white is the transparency color and is enabled by default
        //         // alignment
        //         2560 => [255, 0, 255],
        //         10   => [255, 255, 255],
        //         // timing
        //         3072 => [255, 0, 0],
        //         12   => [255, 255, 255],
        //         // format
        //         3584 => [67, 191, 84],
        //         14   => [255, 255, 255],
        //         // version
        //         4096 => [62, 174, 190],
        //         16   => [255, 255, 255],
        //         // data
        //         1024 => [0, 0, 0],
        //         4    => [255, 255, 255],
        //         // darkmodule
        //         512  => [0, 0, 0],
        //         // separator
        //         8    => [255, 255, 255],
        //         // quietzone
        //         18   => [255, 255, 255],
        //     ],
        // ]);
        // header('Content-type: image/png');
        // (new QRCode($options))->render($data);

        // QRCode::png($data);

    //quick and simple:
        // echo (new QRCode)->render($data);
    }
}
