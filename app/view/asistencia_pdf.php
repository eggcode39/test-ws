<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 05/12/2019
 * Time: 18:55
 */
$pdf = new PDFF();

$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial','U',12);
$pdf->Cell(180,6,'Rango de Fechas: '.$inicio.' y '.$fin,0,1,'L',0);
$pdf->Ln();

foreach ($fechas as $f){
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(180,6,'Fecha de Control: ' . $f->fecha,0,1,'L',0);
    $pdf->Ln();

    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(100,6,'Nombre Docente:',1,0,'C',1);
    $pdf->Cell(30,6,'Hora Entrada',1,0,'C',1);
    $pdf->Cell(30,6,'Hora Salida',1,0,'C',1);
    $pdf->Ln();
    foreach ($docentes as $d){
        $entrada = $this->asistencia->listar_docente_entrada_dia($d->idPersona, $f->fecha);
        $salida = $this->asistencia->listar_docente_salida_dia($d->idPersona, $f->fecha);
        $pdf->Cell(100,6,'' . $d->cNombres . ' ' . $d->cApellidos,1,0,'C',1);
        if(isset($entrada->id)){
            $pdf->Cell(30,6,'' . $entrada->hora,1,0,'C',1);
        } else {
            $pdf->Cell(30,6,'SIN REGISTRO',1,0,'C',1);
        }
        if(isset($salida->id)){
            $pdf->Cell(30,6,'' . $salida->hora,1,0,'C',1);
        } else {
            $pdf->Cell(30,6,'SIN REGISTRO',1,0,'C',1);
        }
        $pdf->Ln();
    }
    $pdf->Ln();
    $pdf->Ln();
}
$pdf->Output();