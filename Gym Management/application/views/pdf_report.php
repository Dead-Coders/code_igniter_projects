<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).



// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        
        
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(0, 10, 'Gym Reports', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gym Management');
$pdf->SetTitle('Sales Report');
$pdf->SetSubject('Gym Sales Report');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', 'R', 8);

// add a page
$pdf->AddPage();

$counter=0;

// set some text to print
$table ='<table style="border:1px solid black"><thead>';
$table .='<tr>
            <th style="border:1px solid black">ID</th>
            <th style="border:1px solid black">B.N</th>
            <th style="border:1px solid black">Member Name</th>
            <th style="border:1px solid black">Type</th>
            <th colspan="2" style="border:1px solid black">Packages</th>
            <th style="border:1px solid black">Amount Paid</th>
            <th style="border:1px solid black">Tax</th>
            <th style="border:1px solid black">Total</th>
            <th style="border:1px solid black">Balance</th>
            <th style="border:1px solid black">Cashier</th>
            <th style="border:1px solid black">Pay-Type</th>
            <th style="border:1px solid black">Date</th>
        </tr></thead>';
$table .= '<tbody>';
$cash_sum=0;
$cc_sum=0;
$amount=0;
$balance=0;
foreach($reports->result() as $report)
{
    if($report->payment_type=='Cash')
    {
        $cash_sum=$cash_sum+$report->total_amount;

    }
    if($report->payment_type=='Card')
    {
        $cc_sum=$cc_sum+$report->total_amount;
    }

    $amount=$amount+$report->total_amount;
    if($report->balance!='' || $report->balance !=null)
    {
        $balance=$balance+$report->balance;    
    }
    
    $sum=$report->fee+$report->tax;
    $counter++;
    $table.='<tr>
    <td style="border:1px solid black">'.$counter.'</td>
    <td style="border:1px solid black">'.$report->id_r.'</td>
    <td style="border:1px solid black">'.$report->member_name.'</td>
    <td style="border:1px solid black">'.$report->member_type.'</td>
    <td colspan="2" style="border:1px solid black">'.$report->packages.'</td>
    <td style="border:1px solid black">'.$report->total_amount.'</td>
    <td style="border:1px solid black">'.$report->tax.'</td>
    <td style="border:1px solid black">'.$sum.'</td>
    <td style="border:1px solid black">'.$report->balance.'</td>
    <td style="border:1px solid black">'.$report->cashier.'</td>
    <td style="border:1px solid black">'.$report->payment_type.'</td>
    <td style="border:1px solid black">'.$report->fee_date.'</td>


    </tr>';

}


$table.='</tbody></table>';

$cash_print='<h4>Cash: $'.$cash_sum.'</h4>';
$cc_print='<h4>Credit Card:  $'.$cc_sum.'</h4>';
$amount_print='<h4>Amount:  $'.$amount.'</h4>';
$balance_print='<h4>Balance:  $'.$balance.'</h4>';
$com_gent='<h5>*This is computer generated report</h5>.';



$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
$pdf->writeHTMLCell(0,0,'','',$cash_print,0,1,0,true,'R',true);
$pdf->writeHTMLCell(0,0,'','',$cc_print,0,1,0,true,'R',true);
$pdf->writeHTMLCell(0,0,'','',$amount_print,0,1,0,true,'R',true);
$pdf->writeHTMLCell(0,0,'','',$balance_print,0,1,0,true,'R',true);
$pdf->writeHTMLCell(0,0,'','',$com_gent,0,1,0,true,'L',true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('report1.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+