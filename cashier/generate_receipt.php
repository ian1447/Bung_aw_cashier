<?php

session_start();
include "../dbcon.php";

// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');

$pageLayout = array(100, 100);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);


// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(0, 0, 0, 0);

// set cell margins
$pdf->setCellMargins(2, 4, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);

$type = $_GET['type'];
$item_name = $_GET['item_name'];
$no_of_people = $_GET['no_of_people'];
$datetime = date_create()->format('Y-m-d');
$amount = $_GET['amount'];

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

//Add Image
// $image_file = K_PATH_IMAGES.'logo.png';
// $pdf->Image($image_file, 44, 15 , 15, '', 'PNG', '', 'C');

// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some text for example
// $image_file = K_PATH_IMAGES.'logo.png';
// $pdf->Image($image_file, 44 + ($horizontal*84), 15+($vertical*110) , 15, '', 'PNG', '', 'C');

// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$html = <<<EOD

<div>

<p style="text-align: center; font-weight: bold">BUNG-AW-CASHIERING</p>

    <table cellspacing="0" cellpadding="1" border="1" style="border-color:gray;">
    <tr>
    <th>Type:</th>
    <td>{$type}</td>
    </tr>
    <tr>
    <th>Item Name:</th>
    <td>{$item_name}</td>
    </tr>
    <tr>
    <th>Number of People:</th>
    <td>{$no_of_people}</td>
    </tr>
    <tr>
    <th>Printed On:</th>
    <td>{$datetime}</td>
    </tr>
    <tr>
    <th>Amount:</th>
    <td><span>Php </span>{$amount}</td>
    </tr>
</table>

</div>
EOD;

//<h3 style="color:red; text-align: center"> PLEASE DO NOT REMOVE </h3>
// Multicell test
$pdf->writeHTMLCell(80, 20,'', '', $html, 1, 0, true, '', true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('');
//============================================================+
// END OF FILE
//============================================================+