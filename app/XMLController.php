<?php

namespace App\Http\Controllers;

use App\Http\Requests\api2Request;
use App\Solicitud;
use App\Token;
use Illuminate\Http\Request;

class XMLController extends Controller
{
    public function xml(api2Request $solicitud2){
      if($solicitud2["ews_token"]!==Token::first()["token"]){
        return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente"]);
      }
      $solicitud= Solicitud::where("id",$solicitud2["ews_no_solicitud"])->first();        
        
        
        $solicitud["id_electronico"]=$solicitud2["ews_id_electronico"];
        $solicitud["referencia_pago"]=$solicitud2["ews_referencia_pago"];
        $solicitud["fecha_pago"]=$solicitud2["ews_fecha_pago"];
        $solicitud["hora_pago"]=$solicitud2["ews_hora_pago"];
        $solicitud["stripe_orden_id"]=$solicitud2["ews_stripe_orden_id"];
        $solicitud["stripe_creado"]=$solicitud2["ews_stripe_creado"];
        $solicitud["stripe_mensaje"]=$solicitud2["ews_stripe_mensaje"];
        $solicitud["stripe_tipo"]=$solicitud2["ews_stripe_tipo"];
        $solicitud["stripe_digitos"]=$solicitud2["ews_stripe_digitos"];
        $solicitud["stripe_estado"]=$solicitud2["ews_stripe_estado"];
        $solicitud["stripe_red"]=$solicitud2["ews_stripe_red"];
        $xml_ruta="archivo2s.xml";
        $solicitud["xml_url"]= "http://127.0.0.1:8000/".$xml_ruta;
        $solicitud->save();

      
        $xml = new \DomDocument('1.0', 'UTF-8');
        $raiz = $xml->createElement('Tramite');
        $raiz = $xml->appendChild($raiz);
        
        $documento = $xml->createElement('Documento');
        $documento = $raiz->appendChild($documento);
        
        $subnodoDocumento1 = $xml->createElement('no_solicitud',$solicitud["no_solicitud"]);
        $subnodoDocumento2 = $xml->createElement('fecha_solicitud',$solicitud["fecha_solicitud"]);
        $subnodoDocumento3 = $xml->createElement('hora_solicitud',$solicitud["hora_solicitud"]);
        $subnodoDocumento4 = $xml->createElement('id_electronico',$solicitud["id_electronico"]);  
        $subnodoDocumento5 = $xml->createElement('referencia_pago',$solicitud["referencia_pago"]);  
        $subnodoDocumento6 = $xml->createElement('fecha_pago',$solicitud["fecha_pago"]);  
        $subnodoDocumento7 = $xml->createElement('hora_pago',$solicitud["id_electronico"]);  
        $subnodoDocumento8 = $xml->createElement('stripe_orden_id',$solicitud["stripe_orden_id"]);  
        $subnodoDocumento9 = $xml->createElement('stripe_creado',$solicitud["stripe_creado"]);  
        $subnodoDocumento10 = $xml->createElement('stripe_mensaje',$solicitud["stripe_mensaje"]);  
        $subnodoDocumento11 = $xml->createElement('stripe_tipo',$solicitud["stripe_tipo"]);  
        $subnodoDocumento12 = $xml->createElement('stripe_digitos',$solicitud["stripe_digitos"]);  
        $subnodoDocumento13 = $xml->createElement('stripe_red',$solicitud["stripe_red"]);  
        $subnodoDocumento14 = $xml->createElement('stripe_estado',$solicitud["stripe_estado"]);  
        $subnodoDocumento15 = $xml->createElement('curp',$solicitud["curp"]);  
        $subnodoDocumento16 = $xml->createElement('nombre',$solicitud["nombre"]);  
        $subnodoDocumento17 = $xml->createElement('apellido_paterno',$solicitud["apellido_paterno"]);  
        $subnodoDocumento18 = $xml->createElement('apellido_materno',$solicitud["apellido_materno"]);  
        $subnodoDocumento19 = $xml->createElement('direccion',$solicitud["direccion"]);  
        $subnodoDocumento20 = $xml->createElement('colonia',$solicitud["colonia"]);  
        $subnodoDocumento21 = $xml->createElement('importe',$solicitud["importe"]);  
        $subnodoDocumento22 = $xml->createElement('fechalimite',$solicitud["fechalimite"]);  
        $subnodoDocumento23 = $xml->createElement('sector',$solicitud["sector"]);  
        $subnodoDocumento24 = $xml->createElement('manzana',$solicitud["manzana"]);  
        $subnodoDocumento25 = $xml->createElement('lote',$solicitud["lote"]);  
        $subnodoDocumento26 = $xml->createElement('tipo_servicio',$solicitud["tipo_servicio"]);  
        $subnodoDocumento27 = $xml->createElement('no_medidor',$solicitud["no_medidor"]);  
        
        
        
         $documento->appendChild($subnodoDocumento1);
         $documento->appendChild($subnodoDocumento2);
         $documento->appendChild($subnodoDocumento3);
         $documento->appendChild($subnodoDocumento4);
         $documento->appendChild($subnodoDocumento5);
         $documento->appendChild($subnodoDocumento6);
         $documento->appendChild($subnodoDocumento7);
         $documento->appendChild($subnodoDocumento8);
         $documento->appendChild($subnodoDocumento9);
         $documento->appendChild($subnodoDocumento10);
         $documento->appendChild($subnodoDocumento11);
         $documento->appendChild($subnodoDocumento12);
         $documento->appendChild($subnodoDocumento13);
         $documento->appendChild($subnodoDocumento14);
         $documento->appendChild($subnodoDocumento15);
         $documento->appendChild($subnodoDocumento16);
         $documento->appendChild($subnodoDocumento17);
         $documento->appendChild($subnodoDocumento18);
         $documento->appendChild($subnodoDocumento19);
         $documento->appendChild($subnodoDocumento20);
         $documento->appendChild($subnodoDocumento21);
         $documento->appendChild($subnodoDocumento22);
         $documento->appendChild($subnodoDocumento23);
         $documento->appendChild($subnodoDocumento24);
         $documento->appendChild($subnodoDocumento25);
         $documento->appendChild($subnodoDocumento26);
         $documento->appendChild($subnodoDocumento27);

        
        $firmaElectronica = $xml->createElement('Firma_Electronica');
        $firmaElectronica = $raiz->appendChild($firmaElectronica);
        $subnodoFirma1 = $xml->createElement('Hash');
        $subnodoFirma2 = $xml->createElement('Sello_Digital');
        $subnodoFirma3= $xml->createElement('Descripcion');
        $subnodoFirma4 = $xml->createElement('Fecha_Validez');
        $subnodoFirma1 = $firmaElectronica->appendChild($subnodoFirma1);
        $subnodoFirma2 = $firmaElectronica->appendChild($subnodoFirma2);
        $subnodoFirma3 = $firmaElectronica->appendChild($subnodoFirma3);
        $subnodoFirma4 = $firmaElectronica->appendChild($subnodoFirma4);
        $xml->formatOutput = true;
        $xml->saveXML();

        $xml->save($xml_ruta);


        $respuestaJson["wsp_mensaje"]="XML creado de forma correcta";
        $respuestaJson["wsp_no_solicitud"]=$solicitud["no_solicitud"];
        $respuestaJson["wsp_no_solicitud_api"]=$solicitud["no_solicitud_api"];
        $respuestaJson["wsp_fecha_generacion"]= date("Y-m-d");
        $respuestaJson["wsp_hora_generacion"]= date("H:i:s", time());
        $respuestaJson["wsp_url_xml"]= "http://127.0.0.1:8000/".$xml_ruta;
        return response()->json($respuestaJson,200);
    }
}