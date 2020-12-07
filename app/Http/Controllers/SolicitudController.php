<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validación de campos vacios
        $validacion=Validator::make($request->all(),
        [
            'ews_llave' => 'required',
            'ews_id_tramite' => 'required',
            'ews_no_solicitud' => 'required',
            'ews_fecha_solicitud' => 'required',
            'ews_hora_solicitud' => 'required',
            'ews_curp' => 'required',
            'ews_nombre' => 'required',
            'ews_apellido_paterno' => 'required',
            'ews_apellido_materno' => 'required',
            'ews_no_contrato' => 'required',
            'ews_id_municipio' => 'required',
        ]);
        //Validación de datos campos vacios
        if($validacion->fails())
        {
            //Creación de la variable respuesta
            $respuesta=$validacion->messages()->get('*');
            return response()->json([
                'wsp_mensaje'=>'Solicitud invalida',
                'wsp_campos_faltantes'=>$respuesta
            ],400);
        }
        //Validación del ID 
        if($request->ews_id_tramite!=17)
        {
            return response()->json([
                'wsp_mensaje'=>'Id incorrecto'
            ],400);
        }
        //Variables proporcionadas por URL con metofo GET
        //$direccion= Http::get('URL')[''];
        //Creación de la varible no_solicutd_api para que sea auto incrementable 
        $no_solicitud_api = Solicitud::count();
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
    
        $solicitud->curp = $request->ews_curp;
        $solicitud->nombre = $request->ews_nombre;
        $solicitud->apellido_paterno = $request->ews_apellido_paterno;
        $solicitud->apellido_materno = $request->ews_apellido_materno;
        $solicitud->no_contrato = $request->ews_no_contrato;
        $solicitud->id_municipio = $request->ews_id_municipio;
        
        /*Consumir API de usuarios de POTYS para validar los datos del solicitante con el usuario registrdo en POTYS*/
        /*Consumir API-5 de repositorio de POTYS para conocer si el solicitante ya integro los documentos requisito*/
        /*Datos que se obtendran de la consulta de la CAPA*/
        $solicitud->direccion = 'r201';
        $solicitud->colonia = 'hzda';
        $solicitud->importe = '748.50';
        $solicitud->fechalimite = date("2020-02-23");
        $solicitud->sector = '13';
        $solicitud->manzana = '132';
        $solicitud->lote = '2';
        $solicitud->tipo_servicio = 'domestico';
        $solicitud->no_medidor = '4502';


        /*$solicitud->stripe_orden_id = '6735';
        $solicitud->stripe_creado = '1583253990';
        $solicitud->stripe_mensaje = "Payment_complete";
        $solicitud->stripe_tipo = "authorized";
        $solicitud->stripe_digitos = '8001';
        $solicitud->stripe_red = "visa";
        $solicitud->stripe_estado = "succeeded";
        $solicitud->xml_url = "localhost";*/
        //Se almacena la slicitud
        $solicitud->save();
        //Repuesta en formato json
        return response()->json([
            'wsp_mensaje' => 'Datos del contrato encontrados exitosamente',
            'wsp_no_solicitud' => '2020-0000000001',
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
                        '1' => $request->ews_id_municipio
                    ],
                    '3' => (Object)
                    [
                        '0' => 'Dirección',
                        '1' => ''
                    ],
                    '4' => (Object)
                    [
                        '0' => 'Colonia',
                        '1' => ''
                    ],
                    '5' => (Object)
                    [
                        '0' => 'Importe del contrato',
                        '1' => ''
                    ],
                    '6' => (Object)
                    [
                        '0' => 'Fecha límite del recibo (factura)',
                        '1' => ''
                    ],
                    '7' => (Object)
                    [
                        '0' => 'Tarifa',
                        '1' => ''
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
                        '1' => $request->ews_curp
                    ],
                    '2' => (Object)
                    [
                        '0' => 'Nombre (s)',
                        '1' => $request->ews_nombre
                    ],
                    '3' => (Object)
                    [
                        '0' => 'Apellido peterno',
                        '1' => $request->ews_apellido_paterno
                    ],
                    '4' => (Object)
                    [
                        '0' => 'Apellido Materno',
                        '1' => $request->ews_apellido_materno
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
