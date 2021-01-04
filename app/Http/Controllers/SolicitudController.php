<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudRequest;
use Illuminate\Http\Request;
use App\Solicitud;
use Illuminate\Support\Facades\Validator;
use Http;

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
        //Variables proporcionadas por URL con metofo GET API5
        $Datos= Http::get('https://apis.roo.gob.mx/repositorio/api_requisitoslandingpage.php?ews_curp='.$request->ews_curp_sw.'&ews_token=UA6H5auaxtDo$xcIMz3aYvpntoeCJC7GQ8abH6cUWYS7tvczbBTY0feM7J4C2Shvlq8bBCJC7GQ8abH6cUWYS7tvczbBTY0feM7J4C2Shvlq8bBcNNbYk5YQycBnx_BJXqADLz2Nk0xEWUZzZNMKK4*d&ews_nid_tramite=115856&=')['wsp_acreditado'];
        //Validación de documentos rquisitos completos
        if(!$Datos)
        {
            return response()->json([            
                'wsp_mensaje' =>'Complete sus datos requisito'
            ],400);
        }
        //Variables proporcionadas por URL con metofo GETAPI4
        /*$NumExterior= Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_exterior'];
        if($NumExterior)
        {

        }
        $NumInterior= Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_interior'];
        $Manzana= Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_manzana'];
        $Lote= Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_lote'];
        $Localidad= Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_localidad'];
        $Direccion = 'Número Exterior: '.$NumExterior.' Número Interior: '.$NumInterior.' Manzana: '.$Manzana.' Lote: '.$Lote.' Localidad: '.$Localidad;
        $Colonia = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116090&ews_codigo=0009&ews_curp='.$request->ews_curp.'&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_colonia'];*/
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
                        '1' => $request->ews_municipio_capa
                    ],
                    '3' => (Object)
                    [
                        '0' => 'Dirección',
                        '1' => '$Direccion'
                    ],
                    '4' => (Object)
                    [
                        '0' => 'Colonia',
                        '1' => '$Colonia'
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
