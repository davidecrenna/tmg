<?php
	include("../../headerdownload.php");
	
	$username = "davidecrenna";	
	$data = date("d-m-Y");
	$total_confirmed = 1500;
	$user_id = 1;
	$nomebeneficiario = "Davide Crenna";
	$iban = "IT012345678000000000000234";
	$codfis = "DVDCRN91E02E514R";
	$swift = "sail cazzo";


	$card= new Card($username);

		// initiate PDF 
		$pdf = new PDF_fattura('P','mm','A4',true, 'UTF-8',false); 
		$pdf->setPrintHeader(true);
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
		$pdf->SetFont("Helvetica", "", 8); 
		$dati_cliente = $card->Get_nomeandcognome()."<br/>";
		$dati_cliente .= "C.F. : ". $card->codfis."<br/>";
		$pdf->MultiCell(80,10,$dati_cliente,0,J,false,1,18,87,true,0,true,true,0,'T',false);
	
	
		//Servizio card
		$pdf->SetFont("Helvetica", "", 9); 
		$servizio = "Servizio Card ".date("m/Y",strtotime($data))."<br/>";
		$pdf->MultiCell(60,100,$servizio,0,J,false,1,20,107,true,0,true,true,0,'T',false);
		
		//Data Fattura
		$pdf->SetFont("Helvetica", "", 9); 
		$datafattura = date("d/m/Y",strtotime($data));
		$pdf->MultiCell(60,100,$datafattura,0,J,false,1,150,50,true,0,true,true,0,'T',false);
		
		
		//Numero Fattura
		$pdf->SetFont("Helvetica", "", 9); 
		$numerofattura = date("d/m/Y",strtotime($data));
		$pdf->MultiCell(60,100,$numerofattura,0,J,false,1,150,43,true,0,true,true,0,'T',false);
		
		$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');
		
		
		$pdf->Output('../../fatture/fattura '.$card->username.' '.$data.'.pdf', 'F');

?>