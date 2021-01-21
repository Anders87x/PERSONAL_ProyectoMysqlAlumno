<?php
    require('../fpdf.php');
    require('../../config/conexion.php');
    require_once("../../modelos/Ventas.php");
    $ventas = new Ventas();

    $idx = $_GET["id"];
    $datos = $ventas->get_detalle_cliente($idx);

    $pdf = new FPDF('P','mm',array(60,80));
    $pdf->AddPage();
    $pdf->Image('55.png',17,1,28);
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(3,40,'cliente:' . $datos[0]["cliente"],0,0);
    $pdf->Cell(3,45,'Numero de Venta:' . $datos[0]["numero_venta"],0,0);
    $pdf->Cell(3,49,'Cedula Cliente:' . $datos[0]["cedula_cliente"],0,0);
    //$pdf->Cell(3,48,utf8_decode('cliente'));
    $pdf->Output();
?>
 

