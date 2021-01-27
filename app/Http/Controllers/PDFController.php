<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf as PDF;
use App\Token;
use App\Solicitud;


class PDFController extends Controller
{
    function pdf (Request $request) 
    {
        if($request["ews_token"]!==Token::first()["token"]){
            return response()->json(["wsp_mensaje"=>"TOKEN Invalido o Inexistente"]);
          }     
          $solicitud= Solicitud::where("id",$request["ews_no_solicitud"])->first();
          if(!$solicitud)
          {
            return response()->json(["ews_mensaje"=>"No se encontro la solicitud"],400);
          }
          $fpdf= new PDF();  
        ob_end_clean();
        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->SetTextColor(61, 135, 142);
        $fpdf->Cell(20);
        $fpdf->Cell(0, 0, 'Valoramos tu tiempo');
        $fpdf->ln(10);
        $fpdf->SetFont('Courier', '', 18);
        $fpdf->Cell(0, 0, utf8_decode('No más filas, silicita tu cargo automático'));
        $fpdf->ln(10);
        $fpdf->Cell(30);
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Cell(0, 0, utf8_decode('Es más facil'));
        $fpdf->ln(10);
        $fpdf->SetFont('Courier', '', 18);
        $fpdf->Cell(0, 0, 'Con tarjeta de credito');
        $fpdf->ln(10);
        $fpdf->Cell(100, 0, '', 1, 1, 'l');
        $fpdf->ln(5);
        $fpdf->Image('imagenes/logo.png',30,50,53);
        $fpdf->ln(25);
        $fpdf->Cell(0, 0, utf8_decode('O en línea en nuestra páginas web'));
        $fpdf->ln(5);
        $fpdf->Cell(0, 0, utf8_decode($solicitud["nombre"]));
        $fpdf->AddPage();
        $fpdf->Cell(0, 0, 'Hola mundo');
        $fpdf->ln(5);
        $fpdf->SetFont('Courier', '', 18);
        $fpdf->Cell(0, 0, 'Este es un trabajo de PDF');
        $fpdf->Output("F","Daniel.pdf");
    }
}

