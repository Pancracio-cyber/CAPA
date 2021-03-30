<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as PDF;
use App\Token;
use App\Solicitud;
use App\Firmante_pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode as Qr;
/*:select("solicitudes.apellido_materno","solicitudes.apellido_paterno","solicitudes.calle1","solicitudes.calle2","solicitudes.colonia","solicitudes.created_at","solicitudes.curp","solicitudes.diametroToma","solicitudes.direccion","solicitudes.fechalimite","solicitudes.fecha_pago","solicitudes.fecha_solicitud","solicitudes.fecha_Solicitud_api","solicitudes.","solicitudes.hora_pago","solicitudes.hora_solicitud","solicitudes.hora_solicitud_api","solicitudes.id","solicitudes.id_electronico","solicitudes.id_estado","solicitudes.id_firmante","solicitudes.id_sello","solicitudes.id_tramite","solicitudes.importe","solicitudes.llave","solicitudes.lote","solicitudes.manzana","solicitudes.nombre as nombre_solicitud","municipios.nombre as nombre_municipio","actividades.texto_alternativo_img","actividades.url_imagen","actividades.descripcion","actividades.id","actividades.nombre","tipo_actividades.nombre as tipo_actividad"):*/

class PDFGenerateController extends Controller
{
    public function pdf (Request $request) 
    {
        if($request["ews_token"]!==Token::first()["token"]){
            return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente"]);
          }     
          $solicitud= Solicitud::where("no_solicitud",$request["ews_no_solicitud"])-> join('municipios', 'solicitudes.id_municipio', '=', 'municipios.id')->first();
          //return $solicitud;
          if(!$solicitud)
          {
            return response()->json(["wsp_mensaje"=>"No sev encontro la solicitud"],400);
          }
          switch ($solicitud["id_municipio"]) {
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
            switch (date("m")) {
              case "01":
                  $mes="Enero";
                  break;
              case "02":
                  $mes="Febrero";
                  break;
              case "03":
                  $mes="Marzo";
                  break;
              case "04":
                  $mes="Abril";
                  break;
              case "05":
                  $mes="Mayo";
                  break;
              case "06":
                  $mes="Junio";
                  break;
              case "07":
                  $mes="Julio";
                  break;    
              case "08":
                  $mes="Agosto";
                  break;
              case "09":
                  $mes="Septiembre";
                  break;
              case "10":
                  $mes="Octubre";
                  break;
              case "11":
                  $mes="Noviembre";
                  break;
              case "12":
                  $mes="Diciembre";
                  break;
              default:
              # code...
              break;
              }
                $longitudtipo_servicio= strlen($solicitud["tipo_servicio"]);
                $longitudDeseada=23;
                $cantidadEspaciosEnBlanco=$longitudDeseada-$longitudtipo_servicio;
                $espaciosEnBlanco="";
                    if($cantidadEspaciosEnBlanco<=0)
                    {
                        $cantidadEspaciosEnBlanco=1;
                    }
                    for ($i=0; $i < $cantidadEspaciosEnBlanco ; $i++) 
                    { 
                        $espaciosEnBlanco=$espaciosEnBlanco . " ";
                    }
                $tipo_servicio=$solicitud["tipo_servicio"].$espaciosEnBlanco.$solicitud["no_medidor"];
                $longituddiametroToma= strlen($solicitud["diametroToma"]);
                $longitudDeseada=23;
                $cantidadEspaciosEnBlanco=$longitudDeseada-$longituddiametroToma;
                $espaciosEnBlanco="";
                    if($cantidadEspaciosEnBlanco<=0)
                    {
                        $cantidadEspaciosEnBlanco=1;
                    }
                    for ($i=0; $i < $cantidadEspaciosEnBlanco ; $i++) 
                    { 
                        $espaciosEnBlanco=$espaciosEnBlanco . " ";
                    }
                $diametroToma=$solicitud["diametroToma"].$espaciosEnBlanco.$solicitud["tarifa"];
                $firmantepdf=Firmante_pdf::where("id",$solicitud["id_municipio"])->first();
                $nombresolicitante = $solicitud->nombre." ".$solicitud->apellido_paterno." ".$solicitud->apellido_materno;
                $longitud= strlen($nombresolicitante);
                $longitudDeseada=35;
                $cantidadEspaciosEnBlanco=$longitudDeseada-$longitud;
                $espaciosEnBlanco="";
                    if($cantidadEspaciosEnBlanco<=0)
                    {
                        $cantidadEspaciosEnBlanco=1;
                    }
                    for ($i=0; $i < $cantidadEspaciosEnBlanco ; $i++) 
                    { 
                        $espaciosEnBlanco=$espaciosEnBlanco . " ";
                    }
                $nombrefirmante=$firmantepdf["nombre_firmante"]." ".$firmantepdf["primer_apellido_firmante"]." ".$firmantepdf["segundo_apellido_firmante"];
                $nombreciudadano = $nombresolicitante.$espaciosEnBlanco.$nombrefirmante;
                Qr::format('png')->size(200)->generate('https://www.potys.gob.mx/validatramite/?id='.$solicitud->id_electronico,"QR".$solicitud->id_electronico.".png");
            $fpdf= new PDF();  
            $calle1= $solicitud["calle1"];
            $calle2= $solicitud["calle2"];
            if($calle1 && $calle2)
                {
                    $string= "" . $calle1." y " . $calle2;
                }else if($calle1 && !$calle2)               
                {
                    $string= "" . $calle1;
                }else if(!$calle1 && $calle2)
                {
                    $string= "" . $calle2;
                }else if(!$calle1 && !$calle2)
                {
                    $string= "";
                }else
                {
                    $string= "";
                }
            //return $solicitud;
        //ob_end_clean();
        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Image('imagenes/Principal.jpeg',0,0,210);
        $fpdf->ln(108);
        $fpdf->Cell(115,0, "");
        $fpdf->Cell(0, 0, utf8_decode($solicitud["no_contrato"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud->nombre." ".$solicitud->apellido_paterno." ".$solicitud->apellido_materno));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["direccion"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($string));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["colonia"]));
        $fpdf->ln(10);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["nombre_municipio"]." ".($solicitud["localidad"])));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($tipo_servicio));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($diametroToma));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["importe"]));
        $fpdf->ln(18);
        $fpdf->Cell(15,0, "");
        $fpdf->Cell(0, 0, utf8_decode($solicitud["localidad"]."       ".date("d")."   ".$mes."     ".date("Y")));
        $fpdf->ln(30);
        $fpdf->SetFont('Courier', 'B', 15);
        $fpdf->Cell(0,0, utf8_decode($nombreciudadano));
        $fpdf->ln(5);
        $fpdf->Image("QR".$solicitud->id_electronico.".png",20,262,35);
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
        $fpdf->Image('imagenes/Normas.jpeg',0,0,210);
        return $fpdf->Output();
    }
}
