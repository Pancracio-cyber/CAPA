<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as PDF;
use App\Token;
use App\Solicitud;


class PDFGenerateController extends Controller
{
    public function pdf (Request $request) 
    {
        if($request["ews_token"]!==Token::first()["token"]){
            return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente"]);
          }     
          $solicitud= Solicitud::where("no_solicitud",$request["ews_no_solicitud"])->first();
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
            $fpdf= new PDF();  
            $string = "Entre calles: ".$solicitud["calle1"]." y ".$solicitud["calle2"];
            //return $solicitud;
        //ob_end_clean();
        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Image('imagenes/Principal.jpeg',0,0,210);
        $fpdf->ln(110);
        $fpdf->Cell(110,0, "");
        $fpdf->Cell(0, 0, utf8_decode($solicitud["no_contrato"]));
        $fpdf->ln(14);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["nombre"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["direccion"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($string));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["colonia"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($municipio));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["tipo_servicio"]."                  ".$solicitud["no_medidor"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["diametroToma"]."                     ".$solicitud["tarifa"]));
        $fpdf->ln(12);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["importe"]));
        $fpdf->ln(17);
        $fpdf->Cell(15,0, "");
        $fpdf->Cell(0, 0, utf8_decode("Cozumel"."  ".date("d")."   ".$mes."  ".date("Y")));
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
        $fpdf->Image('imagenes/Normas.jpeg',0,0,210);
        return $fpdf->Output();
    }
}