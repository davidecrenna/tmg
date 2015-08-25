<?php
	include("../../headerbasic.php");
	include("../../headerdownload.php");

if(!isset($_GET["u"])){
	header("location: ../../index.php");
}
$ctrl_user = new Ctrluser();
if($ctrl_user->IsUsername($_GET["u"]) != 0){
	header("location: ../../index.php");
}

$card= new Card($_GET["u"]);


// initiate PDF 
$pdf = new PDF_storia('P','mm','A4',true, 'UTF-8',false); 
//$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);
	
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($card->Get_nomeandcognome());
$pdf->SetKeywords('Top, Manager, group, '.$card->Getnameshowed().', storia');

$pdf->SetAutoPageBreak(true, 6);
$pdf->setFontSubsetting(false);

$pdf->AddPage(); 

$card->Set_arraycurriculumeurop_titolo($array_curr_titolo);
//titolo
$pdf->SetFont("helvetica", "", 16);
$html = '<strong style="font-size: 20px;" >'.$card->Getnameshowed().'</strong>';
$pdf->MultiCell(200,50,$html,0,J,false,1,9,35,true,0,true,true,0,'T',false);


$pdf->SetFont("helvetica", "", 14); 

$html = "<span style='color:#FFF;' class='text14px'>".$card->sudime."</span>";
$pdf->Image('../../image/banner/banner_pdf.jpg', 5, 5, 78, 24, '', '', '', true, 150, '', false, false, 0, false, false, false);
$pdf->MultiCell(190,60,$html,0,J,false,1,9,50,true,0,true,true,0,'T',false);

$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');

$pdf->Output($_SERVER['DOCUMENT_ROOT'].USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_storia.pdf', 'FI');
 
?>