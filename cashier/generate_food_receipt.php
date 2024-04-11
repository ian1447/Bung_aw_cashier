<?php

session_start();
include "../dbcon.php";

// Include the main TCPDF library (search for installation path).
require_once('includes/TCPDF/tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        // $image_file = K_PATH_IMAGES . 'images/admin.jpg'; 
        // $this->Image($image_file, 10, 10, 190, '', 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
        // $this->Image('images/admin.jpg',10,10,10);
        $this->Cell(12);
        // // Set font
        // $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, 1);
    }

}
$pageLayout = array(100, 150);
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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
<div style="display: flex; justify-content: space-between; align-items: center; text-align: center; line-height: 5px; border-style: solid;">
    <div>
        <img src="images/admin.jpg" style="width: 50px; height: 50px;">
        <h1>Bung-Aw Eco Farm</h1>
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
    <table cellspacing="0" style="padding-top: 50px">
        <tr>
            <td>{$result['quantity']} - {$result['name']}:</td>
            <td align="right">{$result['cost']} Pesos</td>
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
<table cellspacing="0" style="padding-top: 50px">
    <tr>
        <td> </td>
        <td align="right">Total: $total Pesos</td>
    </tr>
</table>
<label style=" text-align: left;">Ordered By: $name </label>
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