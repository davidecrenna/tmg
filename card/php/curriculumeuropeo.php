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
$pdf = new PDF_curriculum('P','mm','A4',true, 'UTF-8',false); 
   $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
	
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($card->Get_nomeandcognome());
$pdf->SetKeywords('Top, Manager, group, '.$card->Get_nome().', '.$card->Get_cognome().', curriculum europeo');

 
$pdf->SetMargins(0, 6, 0); 
$pdf->SetAutoPageBreak(true, 6); 
$pdf->setFontSubsetting(false); 

$pdf->AddPage(); 

$card->Set_arraycurriculumeurop_titolo($array_curr_titolo);

//titolo
$pdf->SetFont("helvetica", "", 16); 
$html = '<strong style="font-size: 20px;" >Curriculum Vitae</strong> di '.$array_curr_titolo['nomecognome'];
$pdf->MultiCell(145,18,$html,0,J,false,1,9,10,true,0,true,true,0,'T',false);

//foto
if(strpos($card->photo1_path,"default_photo/main.png")){
	$pdf->Image('../'.$card->photo1_path, 162, 10, 36, 54, '', '', '', true, 150, '', false, false, 1, false, false, false);
}else{
	$pdf->Image('../../'.USERS_PATH.$card->username.'/user_photo/main/'.$card->photo1_path, 162, 10, 36, 54, '', '', '', true, 150, '', false, false, 1, false, false, false);
}

//sottotitolo
$pdf->SetFont("helvetica", "B", 13);
$html = '<p style="line-height:1.1; color:#494949;">'.$array_curr_titolo['sottotitolo'].'</p>';
$pdf->MultiCell(200,30,$html,0,'J',false,1,10,30,true,0,true,true,50,'T',false);

$card->Set_arraycurriculumeurop($array_curr,$array_curr_desc,$array_num_righe,$array_offset);
$left_coloumn_font_size = 10;
$right_coloumn_font_size = 10;
$left_coloumn_cell_width = 42;
$right_coloumn_cell_width = 157;
		
$html = '<table border="0" cellspacing="3" cellpadding="4">
    <tr>
        <th align="right" width="133"></th>
        <th align="left" width="450"></th>
    </tr>';
	
	foreach ($array_curr_desc as $key => $value) {
		if($array_curr[$key]!=NULL){
			
			$pdf->SetFont("helvetica", "", $left_coloumn_font_size);
			$html .='<tr>
			<td align="right"><strong>'.$value.'</strong></td>';
			
			//$pdf->SetFont("helvetica", "", $right_coloumn_font_size);
			$html .='<td align="left">'.$array_curr[$key].'</td>
			</tr>';
		}
	}
	
$html .= '</table>';
    
		
$pdf->writeHTML($html, true, false, true, false, '');
	
$pdf->SetDisplayMode('fullpage','SinglePage','UseNone');

$pdf->Output($_SERVER['DOCUMENT_ROOT'].USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_curriculum_europeo.pdf', 'FI');
 
?>