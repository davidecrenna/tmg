<?php
	include("../../headerbasic.php");
	include("../../headerdownload.php");
$username = $_GET["u"];
if(!isset($_GET["u"])){
	header("location: ../../index.php");
}
$ctrl_user = new Ctrluser();
if($ctrl_user->IsUsername($_GET["u"]) != 0){
	header("location: ../../index.php");
}
//$card= new Card($_GET["u"]);
$card= new Card($username);

//Add a custom size  
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
  


// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($card->Get_nomeandcognome());
$pdf->SetKeywords('Top, Manager, group, '.$card->Getnameshowed().', biglietto da visita');
$pdf->SetTitle("Top Manager Group - Biglietto da visita di ".$card->Getnameshowed());
$pdf->SetMargins(0, 0, 0); 
$pdf->SetAutoPageBreak(true, 0); 
$pdf->setFontSubsetting(false); 

// -------------------------------------------------------------------
// add a page
$resolution= array(85, 55);
$pdf->AddPage('L', $resolution);

// set JPEG quality
$pdf->setJPEGQuality(99);

// Image example with resizing
$pdf->Image('../../'.USERS_PATH.$username.'/download_area/public/tmg_'.$username.'_biglietto.jpg', 0,0, 85, 55, 'JPG', '../'.$username.'/index.php', '', true, 150, '', false, false, 1, false, false, false);

$pdf->Output('tmg_'.$username.'_biglietto.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+