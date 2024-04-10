<?php

session_start();
include "../dbcon.php";

// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');

$pageLayout = array(100, 150);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);


// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->SetPrintHeader(false);
$pdf->AddPage();
$pdf->SetPrintFooter(false);

// set cell padding
$pdf->setCellPaddings(0, 0, 0, 0);

// set cell margins
$pdf->setCellMargins(0, 0, 0, 0);

// set color for background
$pdf->SetFillColor(255, 255, 255);

$id = $_GET['id'];
$name = $_GET['name'];
$html = <<<EOD
<div style = "line-height: 5px; border-style: solid; margin: 20px;">
    <p style="text-align: center; font-weight: bold; font-size:20px;">BUNG-AW ECO FARM</p>

    <div style="text-align: center;">
        <label style=" text-align: center; font-size:15px">Food
            Orders:</label>
    </div>
</div>
EOD;
// <div style = "line-height: 1px;">';

$pdf->writeHTMLCell(0, 0, '', '', $html, 1, 0, 0, '', false);
$i = 1;
$total = 0;
$sql = "SELECT * FROM `food_orders` fo
JOIN `foods` f ON f.id = fo.`food_id` WHERE fo.`food_bulk_id` = {$id};";
$actresult = mysqli_query($conn, $sql);
while ($result = mysqli_fetch_assoc($actresult)) {
    $total += $result['cost'];
    $newhtml = <<<EOD
    <table cellspacing="8">
        <tr>
<<<<<<< HEAD
            
            <td style="font-size: 15px;">{$result['name']}:</td>
            <td style="font-size: 15px;" align="right">{$result['price']} Pesos</td>
=======
            <td>{$result['quantity']} - {$result['name']}:</td>
            <td align="right">{$result['cost']} Pesos</td>
>>>>>>> b14f013044e34fd8c7f8e867f327c666aca1829d
        </tr>
    </table>
    EOD;
    if ($i == 1) {
        $pos = ($i * 5) + 23;
    } else {
        $pos = ($i * 5) + 23;
    }
    $i += 1;
    $pdf->writeHTMLCell(0, 0, '', $pos, $newhtml, false, 0, 0, '', false);
}
$endhtml = <<<EOD
<table cellspacing="8">
    <tr>
        
        <td> </td>
        <td style="font-size: 15px;"align="right">Total: $total Pesos</td>
    </tr>
</table>
<label style=" text-align: left; font-size: 15px;">Ordered By: $name </label>
EOD; 
$pos = ($i * 5) + 23;
$pdf->writeHTMLCell(0, 0, '', $pos, $endhtml, 0, 0, true, '', true);
// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('');
//============================================================+
// END OF FILE
//============================================================+