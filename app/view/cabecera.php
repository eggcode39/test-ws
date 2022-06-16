<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 05/12/2019
 * Time: 18:19
 */
require 'app/models/fpdf.php';
class PDFF extends FPDF{
    function Header(){
        //Arial bold 15
        $this->SetFont('Arial','B',16);
        //Mover
        $this->Cell(30);
        //Titulo
        $this->Cell(130,10,'Control de Asistencia',0,1,'C');
        $this->SetFont('Arial','B',14);
        $this->Cell(190,10,'Reporte Según Fechas',0,0,'C');
        //Salto de linea
        $this->Ln(20);
    }
    function Footer(){
        $fecha=date('Y-m-d H:i:s');
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(90,10,'Reporte generado el: '.$fecha,0,0,'L');
        $this->Cell(20,10,'Pagina ' . $this->PageNo().'/{nb}',0,0,'C');
    }
}
?>