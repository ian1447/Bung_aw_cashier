<?php

session_start();
include "../dbcon.php";

// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(2, 4, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);


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

<h3 style="text-align: center;"></h3>
<p style="text-align: center; font-weight: bold">BUNG-AW-CASHIERING</p>

    <table cellspacing="0" cellpadding="1" border="1" style="border-color:gray;">
    <tr>
    <th>Property Number:</th>
    <td>asdf</td>
    </tr>
    <tr>
    <th>Classification:</th>
    <td>asdf</td>
    </tr>
    <tr>
    <th>Article and Description:</th>
    <td>asdf</td>
    </tr>
    <tr>
    <th>Acquisition Cost:</th>
    <td>asdf</td>
    </tr>
    <tr>
    <th>Date Acquired:</th>
    <td>asdf</td>
    </tr>
    <tr>
    <th>Date of Account:</th>
    <td></td>
    </tr>
    <tr>
    <th>Property Custodian:</th>
    <td>asdf</td>
    </tr>
</table>

<h3 style="color:red; text-align: center"> PLEASE DO NOT REMOVE </h3>
</div>
EOD;


// Multicell test
$pdf->writeHTMLCell(80, 20,'', '', $html, 1, 0, true, '', true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('');
//============================================================+
// END OF FILE
//============================================================+