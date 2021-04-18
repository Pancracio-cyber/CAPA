<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use App\Token;

class ChangeBDCapaController extends Controller
{
    public function change(Request $request)
    {
        if($request["ews_token"]!==Token::first()["token"])
        {
            return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente","wsp_fecha_consumo"=>date("Y-m-d H:i:s")],403);
        }
        $solicitudes = Solicitud::select("no_solicitud as wsp_no_solicitud","fecha_solicitud as wsp_fecha_solicitud","hora_solicitud as wsp_hora_solicitud","no_contrato as wsp_no_contrato","id_municipio as wsp_municipio", "nombre as wsp_nuevo_nombre")->where("id_estado",">","1")->get();
        if(count($solicitudes)==0)
        {
            return response()->json(["wsp_mensaje"=>"NOMBRES NO ENCONTRADOS","wsp_fecha_consumo"=>date("Y-m-d H:i:s")],400);
        }
        $respuesta["wsp_mensaje"]="NOMBRES ENCONTRADOS POR APLICAR";
        $respuesta["wsp_fecha_consumo"]=date("Y-m-d H:i:s");
        $respuesta["wsp_solicitudes"]=$solicitudes;
        return $respuesta;
    }
}
