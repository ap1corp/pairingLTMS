<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
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
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf/tcpdf.php');
require_once('C:/xampp/htdocs/kiosk/asset/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, 'A7', true, 'UTF-8', false);
// $width = 175;  
// $height = 266; 
// $pdf->addFormat("custom", $width, $height);  
// $pdf->reFormat("custom", 'P'); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luqman Hakim');
$pdf->SetTitle('Resume Cashier KiosK');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 20, 'PT. ANGKASA PURA I (PERSERO)', "Bandara Internasional I Gusti Ngurah Rai Airport - Bali");
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 7));
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(2, 15, 2, true);
$pdf->SetHeaderMargin(5);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 8, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = '
		 <table border="0">
		 	<tr>
		 		<td colspan="2" style="text-align:center; font-size:10pt;">Rekap Transaksi</td>
		 		<td></td>		 		
		 	</tr>
		 	<tr>
				<td width="17%">Kasir</td>
				<td width="3%"> : </td>
				<td width="80%">'.$nama['nama'].'</td>
			</tr>
		 	<tr>
				<td width="17%">Open</td>
				<td width="3%"> : </td>
				<td width="80%">'.date("j F Y, h:i", strtotime($entry['entry'])).'</td>
			</tr>
			<tr>
				<td>Closed</td>
				<td> : </td>
				<td>'.date("j F Y, h:i", strtotime($close['close'])).'</td>
			</tr>
			<tr>
				<td>Jml Trans</td>
				<td> : </td>
				<td>'.($cash['trans']+$prepaid['trans']).'</td>
			</tr>
			<tr>				
				<td>Cash</td>
				<td> : </td>
				<td>Rp. '.number_format($cash['amount'],0,",",".").' ('.$cash['trans'].')</td>				
			</tr>
			<tr>				
				<td>Cashless</td>
				<td> : </td>
				<td>Rp. '.number_format($prepaid['amount'],0,",",".").' ('.$prepaid['trans'].')</td>				
			</tr>
			<tr>
				<td>Total</td>
				<td> : </td>
				<td>Rp. '.number_format($balance['balance'],0,",",".").'</td>				
			</tr>
		 </table> <br/><br/>
		 <table width="70%">
			<tr>
				<td style="text-align:center;">Cashier<br/><br/><br/><br/><br/><u>'.$nama['nama'].'</u></td>
				<td style="text-align:center;">Supervisor<br/><br/><br/><br/><br/>________________</td>
			</tr>
						
		 </table> <br/><br/>

';
// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
$pdf->IncludeJS("print();");
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
