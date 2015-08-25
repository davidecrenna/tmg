<?php
	include("../../headerdownload.php");

if(!isset($_GET["u"])){
	header("location: ../../index.php");
}
$ctrl_user = new Ctrluser();
if($ctrl_user->IsUsername($_GET["u"]) != 0){
	header("location: ../../index.php");
}

$card= new Card($_GET["u"]);

if(!isset($_GET["path"])){
	header("location: ../../index.php");
}else{
	$file_path = $_GET["path"];
}

if(!is_file($path)){
	header("location: ../../index.php");
}

// initiate PDF 
$pdf = new FPDI(); 
 
$pagecount = $pdf->setSourceFile('TestDoc.pdf'); 
$tplidx = $pdf->importPage(1, '/MediaBox'); 

$pdf->addPage(); 
$pdf->useTemplate($tplidx, 10, 10, 90); 
$pdf->Output('newpdf.pdf', 'D'); 

$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');

$pdf->Output('../../'.$card->username.'/download_area/public/tmg_'.$card->username.'_curriculum_europeo.pdf', 'FI');
 
?>