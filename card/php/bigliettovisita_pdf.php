<?php
require_once("../../headerbasic.php");
include('../../header.php');
if(!isset($_GET["u"])){
	header("location: ../../index.php");
}
$ctrl_user = new Ctrluser();
if($ctrl_user->IsUsername($_GET["u"]) != 0){
	header("location: ../../index.php");
}

$card= new Card($_GET["u"]);

// initiate PDF
$resolution= array(77,106);
$pdf = new PDF_biglietto('L','mm',$resolution,true,'UTF-8',false,false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($card->Getnameshowed());
$pdf->SetKeywords('Top, Manager, group, '.$card->Getnameshowed().', biglietto da visita');
$pdf->SetTitle("Top Manager Group - Biglietto da visita di ".$card->Getnameshowed());
$pdf->SetMargins(0, 0, 0); 
$pdf->SetAutoPageBreak(true, 0); 
$pdf->setFontSubsetting(false); 

// add a page 
//array(h, w);

$pdf->AddPage(); 

// get esternal file content 
//$utf8text = file_get_contents("cache/utf8test.txt", true); 

$pdf->SetFont("helvetica", "", 10); 
// now write some text above the imported page 
//$pdf->Write(5, "prova 123"); 
$card->SetArrayBv($arraybv);
	
$html .= $card->Getnameshowed();
		
$html .= '<br/><span style="font-size: 19px; color:#000; ">web: '.$arraybv['web'].'/'.$card->username.'<br/>mail: '.$card->Get_member_email().'</span>';
$html .= "</div>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=90, $h=25, $x='11', $y='33', $html, $border=0, $ln=1, $fill=false, $reseth=true, $align='C', $autopadding=true);

$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');	
//$pdf->Output('tmg_Melixa_roncari_biglietto.pdf', 'I');
$pdf->Output('../../'.USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_biglietto.pdf', 'I');
 
?>