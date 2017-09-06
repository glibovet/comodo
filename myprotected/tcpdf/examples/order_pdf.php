<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ZEN WP');
$pdf->SetTitle('ORDER PDF');
$pdf->SetSubject('ZEN WP ORDER');
$pdf->SetKeywords('PDF, Order');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default header data
//$pdf->SetHeaderData("logo.png", PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true); // 

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "

<table style=\"width:150%;\">
	<tr>
		<td style=\"width:15%;\">
			<span style=\"text-decoration: underline;\" ><b>Постачальник</b></span>
		</td>
		<td>
			ТОВ \"ЗЕН\" <br />
			ЄДРПОУ 38320186, тел. 044 234-09-17 <br />
			Р/р 260010001119 <br />
			20 в Ф-Я ВАТ <br />
			Не є платником податку на прибуток на загальних підставах <br />
			Адреса вул. Симона Петлюри, буд. 7/9
		</td>
	</tr>
	<tr>
		<td style=\"width:15%;\"><br /><br />
			<span style=\"text-decoration: underline;\" ><b>Одержувач</b></span>
		</td>
		<td><br /><br />
			<hr />
			<p>тел.</p>
		</td>
	</tr>
	<tr>
		<td style=\"width:15%;\"><br /><br />
			<span style=\"text-decoration: underline;\" ><b>Платник</b></span>
		</td>
		<td><br /><br />
			Той самий
		</td>
	</tr>
	<tr>
		<td style=\"width:15%;\"><br /><br />
			<span style=\"text-decoration: underline;\" ><b>Замовлення</b></span>
		</td>
		<td><br /><br />
			<hr />
			<p></p>
			<hr />
		</td>
	</tr>
</table>

<h4 align=\"center\">Рахунок-фактура № _____________</h4>
<h4 align=\"center\">від _____________________ 201__ р.</h4>

<table border=\"1\">
	<tr>
		<th width=\"5%\" align=\"center\"  style=\"background-color:#CCC;\">№</th>
		<th width=\"40%\" align=\"center\" style=\"background-color:#CCC;\">Назва</th>
		<th width=\"5%\" align=\"center\"  style=\"background-color:#CCC;\">Од.</th>
		<th width=\"20%\" align=\"center\" style=\"background-color:#CCC;\">Кількість</th>
		<th width=\"15%\" align=\"center\" style=\"background-color:#CCC;\">Ціна без ПДВ</th>
		<th width=\"15%\" align=\"center\" style=\"background-color:#CCC;\">Сума без ПДВ</th>
	</tr>
	<tr>
		<td align=\"center\">1</td>
		<td>
			<table border=\"1\">
				<tr>
					<td width=\"70%\"> Крем для обличчя</td>
					<td width=\"30%\" align=\"center\">1800374</td>
				</tr>
			</table>
		</td>
		<td align=\"center\">шт.</td>
		<td align=\"center\">2</td>
		<td align=\"center\">263 грн.</td>
		<td align=\"center\">526 грн.</td>
	</tr>
</table>

<br />
<br />

<table>
	<tr>
		<td width=\"40%\">
			<b>Всього на суму:</b> 526 грн.
			<br />
			<br />
			Без ПДВ
		</td>
		<td width=\"10%\"></td>
		<td width=\"60%\">
			<br />
			<br />
			<p>Виписав(ла):    _____________________________________
			</p>
			<p><b>Рахунок дійсний до сплати до</b> _______________
			</p>
		</td>
	</tr>
<table>

";


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('zencosmetics_order_5007.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
