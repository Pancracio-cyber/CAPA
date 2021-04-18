<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudRequest;
use Illuminate\Http\Request;
use App\Solicitud;
use App\Token;
use Illuminate\Support\Facades\Validator;
use Http;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Solicitud::all();
    }
public function prueba(SolicitudRequest $request){
    return $request->all();
}

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitudRequest $request)
    {
        if($request["ews_token"]!==Token::first()["token"])
        {
            return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente"],403);
        }
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
    
        $response = $client->request('POST', 'http://www.capa.gob.mx/capanet/apiroo.php', [
            'form_params' => [
                "ews_token" => "***wsjus2389dki34***...",
                "ews_no_contrato" => $request->ews_no_contrato,
                "ews_id_municipio" => $request->ews_municipio_capa
            ]
        ]);
        $response = json_decode((string) $response->getBody(), true);
        //Creación de la varible no_solicutd_api para que sea auto incrementable 
        $no_solicitud_api = (Solicitud::count())+1;
        //Creación de una nueva solicitud
        $solicitud = new Solicitud();
        /*Los datos fijos pertenecen a API-2 y API-3*/
        $solicitud->id_tramite = $request->ews_id_tramite;
        $solicitud->llave = $request->ews_llave;
        $solicitud->no_solicitud = $request->ews_no_solicitud;
        $solicitud->fecha_solicitud = $request->ews_fecha_solicitud;
        $solicitud->hora_solicitud = $request->ews_hora_solicitud;
        /*$config=['table'=>'solicitudes','length'=>15,'prefix'=>date("Y")];*/
        /*IdGenerator::generate($config) + Solicitudes::count()*/
        $solicitud->no_solicitud_api = $no_solicitud_api;
        $solicitud->fecha_solicitud_api = date("Y-m-d");
        $solicitud->hora_solicitud_api = date("H:i:s", time());
        /*$solicitud->referencia_pago = '9300-0000-9281-82';*/
        $solicitud->id_estado = '1';
        //$solicitud->id_electronico = 'jhey38slwi';
    
        $solicitud->curp = $request->ews_curp_sw;
        $solicitud->nombre = $request->ews_nombre_sw;
        $solicitud->apellido_paterno = $request->ews_apellido_paterno_sw;
        $solicitud->apellido_materno = $request->ews_apellido_materno_sw;
        $solicitud->no_contrato = $request->ews_no_contrato;
        $solicitud->id_municipio = $request->ews_municipio_capa;
        $municipio="";
        switch ($request->ews_municipio_capa) {
        case 1:
            $municipio="Cozumel";
            break;
        case 2:
            $municipio="Felipe Carrillo Puerto";
            break;
        case 3:
            $municipio="Lázaro Cárdenas";
            break;
        case 4:
            $municipio="José María Morelos";
            break;
        case 5:
            $municipio="Othón P. Blanco";
            break;
        case 7:
            $municipio="Tulum";
            break;
        case 8:
        $municipio="Bacalar";
        break;
        default:
        # code...
        break;
        }   
        /*Consumir API de usuarios de POTYS para validar los datos del solicitante con el usuario registrdo en POTYS*/
        /*Consumir API-5 de repositorio de POTYS para conocer si el solicitante ya integro los documentos requisito*/
        /*Datos que se obtendran de la consulta de la CAPA*/
        
        $string1 =Str::of($response["direccion"])->replace('\\\"', '');
        $string2 =(String)Str::of($string1)->replace('"', '');
        $solicitud->direccion = $string2;
        $solicitud->importe = $response["importe"];
        $string3 =Str::of($response["colonia"])->replace('\\\"', '');
        $string4 =(String)Str::of($string3)->replace('"', '');
        $solicitud->colonia = $string4;
        //return $response["fechalimite"];
        $datos = explode('/',$response["fechalimite"]);
        $fechalimite = $datos[2]."-".$datos[1]."-".$datos[0];
        $solicitud->fechalimite = $fechalimite;
        $solicitud->sector = $response["sector"];
        $solicitud->manzana = $response["manzana"];
        $solicitud->lote = $response["lote"];
        $string5 = $response["tipoServicio"];
        $string6 =(String)Str::of($string5)->replace(' ', '');
        $solicitud->tipo_servicio = $string6;
        $string7 = $response["numeroMedidor"];
        $string8 =(String)Str::of($string7)->replace(' ', '');
        $solicitud->no_medidor = $string8;
        $string9 = $response["diametroToma"];
        $string10 =(String)Str::of($string9)->replace(' ', '');
        $string11 =(String)Str::of($string10)->replace('"', '');
        $solicitud->diametroToma = $string11;
        $string12 =Str::of($response["tarifa"])->replace('\\\"', '');
        $string13 =(String)Str::of($string12)->replace('"', '');
        $string14 =(String)Str::of($string13)->replace(' ', '');
        $solicitud->tarifa= $string14;
        $string15 =(String)Str::of($response["calle1"])->replace(' ', '');
        $solicitud->calle1=$string15;
        $string16 =(String)Str::of($response["calle2"])->replace(' ', '');
        $solicitud->calle2=$string16;
        //Se almacena la slicitud
        $solicitud->save();
        //Repuesta en formato json
        return response()->json([
            'wsp_mensaje' => 'Datos del contrato encontrados exitosamente',
            'wsp_no_solicitud' => $request->ews_no_solicitud,
            'wsp_no_solicitud_api' => $no_solicitud_api,
            'wsp_nivel' => '2',
            'wsp_datos'=> (Object)
            [
                '0' => (Object)
                [
                    '0' => (Object) 
                    [
                        '0' => 'Datos del contrato encontrado'                 
                    ],
                    '1' => (Object)
                    [
                        '0' => 'Número de contrato',
                        '1' => $request->ews_no_contrato
                    ],
                    '2' => (Object)
                    [
                        '0' => 'Municipio',
                        '1' => $municipio
                    ],
                    '3' => (Object)
                    [
                        '0' => 'Primer No. de calle',
                        '1' => $string15
                    ],
                    '4' => (Object)
                    [
                        '0' => 'Segundo No. de calle',
                        '1' => $string16
                    ],
                    '5' => (Object)
                    [
                        '0' => 'Dirección',
                        '1' => $string2
                    ],
                    '6' => (Object)
                    [
                        '0' => 'Colonia',
                        '1' => $string4
                    ],
                    '7' => (Object)
                    [
                        '0' => 'Importe del contrato',
                        '1' => $response["importe"]
                    ],
                    '8' => (Object)
                    [
                        '0' => 'Fecha límite del recibo (factura)',
                        '1' => $solicitud["fechalimite"]
                    ],
                    '9' => (Object)
                    [
                        '0' => 'Sector',
                        '1' => $solicitud["sector"]
                    ],
                    '10' => (Object)
                    [
                        '0' => 'Manzana',
                        '1' => $solicitud["manzana"]
                    ],
                    '11' => (Object)
                    [
                        '0' => 'Lote',
                        '1' => $solicitud["lote"]
                    ],
                    '12' => (Object)
                    [
                        '0' => 'Tipo de servicio',
                        '1' => $string6
                    ],
                    '13' => (Object)
                    [
                        '0' => 'Número de medidor',
                        '1' => $string8
                    ],
                    '14' => (Object)
                    [
                        '0' => 'Tarifa',
                        '1' => $string14
                    ]
                ] 
            ],
            '1' => (Object)
                [
                    '0' => (Object)
                    [
                        '0' => 'Datos del contratante/solicitante'
                    ],
                    '1' => (Object)
                    [
                        '0' => 'CURP',
                        '1' => $request->ews_curp_sw
                    ],
                    '2' => (Object)
                    [
                        '0' => 'Nombre (s)',
                        '1' => $request->ews_nombre_sw
                    ],
                    '3' => (Object)
                    [
                        '0' => 'Apellido peterno',
                        '1' => $request->ews_apellido_paterno_sw
                    ],
                    '4' => (Object)
                    [
                        '0' => 'Apellido Materno',
                        '1' => $request->ews_apellido_materno_sw
                    ]
                ]
        ], 200);
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

}
