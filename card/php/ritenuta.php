<?php
	include("../../headerdownload.php");

if(!isset($_GET["u"])){
	header("location: ../../index.php");
}
$ctrl_user = new Ctrluser();
if($ctrl_user->IsUsername($_GET["u"]) != 0){
	header("location: ../../index.php");
}
	
	$data = date("d/m/Y");
	$total_confirmed = 1500;
	$user_id = 1;
	$nomebeneficiario = "Davide Crenna";
	$iban = "IT012345678000000000000234";
	$codfis = "DVDCRN91E02E514R";
	$swift = "sail cazzo";
	$card= new Card($_GET["u"]);


	// initiate PDF 
	$pdf = new PDF_curriculum('P','mm','A4',true, 'UTF-8',false); 
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
		
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor($card->Get_nomeandcognome());
	$pdf->SetKeywords('Top, Manager, group, ritenuta acconto');
	
	 
	$pdf->SetMargins(0, 0, 0); 
	$pdf->SetAutoPageBreak(true, 0); 
	$pdf->setFontSubsetting(false); 
	
	$pdf->AddPage(); 
	
	//Dati cliente
	$pdf->SetFont("times", "", 12); 
	$dati_cliente = "Spett.le<br/>";
	$dati_cliente .= $nomebeneficiario."<br/>";
	$dati_cliente .= "C.F. : ".$codfis."<br/>";
	$pdf->MultiCell(80,10,$dati_cliente,0,J,false,1,10,10,true,0,true,true,0,'T',false);


	//Dati cliente
	$pdf->SetFont("times", "", 12); 
	$dati_alan = "Spett.le<br/>";
	$dati_alan .= "EXPORECLAM S.A.S.<br/>";
	$dati_alan .= "Via Marconi 23<br/>";
	$dati_alan .= "21012 Cassano Magnago (VA)<br/>";
	$dati_alan .= "P.IVA : 02346940022<br/>";
	$dati_alan .= "C.F. : MNSLNA80H21L682V<br/>";
	$pdf->MultiCell(60,100,$dati_alan,0,J,false,1,140,10,true,0,true,true,0,'T',false);
	
	
	$ra20 = ($total_confirmed*20)/100;
	$netto = $total_confirmed - $ra20;
	//Corpo ritenuta
	$pdf->SetFont("times", "", 12); 
	$corpo = "Cassano Magnago, ".$data."<br/><br/><br/>";
	$corpo .= "Compenso per prestazione occasionale per promozione prodotto<br/>";
	$corpo .= "Imponibile:    € ".$total_confirmed."<br/>";
	$corpo .= "R.A. 20%:      € ".$ra20."<br/>";
	$corpo .= "Netto a pagare: € ".$netto."<br/>";
	$pdf->MultiCell(200,100,$corpo,0,J,false,1,10,60,true,0,true,true,0,'T',false);

	//Corpo ritenuta
	$pdf->SetFont("times", "", 12); 
	$corpo = "Pagamento B/B 15 Giorni dalla data di fatturazione.<br/>";
	$corpo .= "IBAN: ".$iban."<br/>";
	$corpo .= "Compenso non soggetto a IVA ai sensi dell'art. 5 DPR 26/10/72 n°633 e successive modificazioni.<br/>";
	$pdf->MultiCell(200,100,$corpo,0,J,false,100,10,140,true,0,true,true,0,'T',false);

	
	$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
	
	
	$pdf->Output('../../ritenute/RA '.$username.'.pdf', 'F');

?>