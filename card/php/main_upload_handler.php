<?php 
	require_once("../../headerbasic.php");
	require_once "../../header.php" ?>    
<?php    
    $uploader=new PhpUploader();    
   
    $mvcfile=$uploader->GetValidatingFile();    
	
	$card = new Card(NULL,$_GET["u"]);
	if($card->Is_uploadable($mvcfile->FilePath)==1){
		$uploader->WriteValidationError("Non è possibile eseguire l'upload, l'utente ha terminato lo spazio residuo della card.");
	}
	if($card->is_user_logged()){
		
		$min_width = 210;
		$min_height = 315;
		$image = new SimpleImage();
		$image->load($mvcfile->FilePath);
		$width = $image->getWidth();
		$height =  $image->getHeight();
		//Scale the image if it is greater than the width set above  
		
		if ($width < $min_width || $height<$min_height){
			$error = "L'immagine è troppo piccola. Per un risultato professionale, l'immagine deve avere dimensioni minime (altezza: ".$min_height." x larghezza: ".$min_width.")";
			$uploader->WriteValidationError($error);
			return false;
		}
		
		$dir_path =  "../../".USERS_PATH.$card->username."/download_area/public/photo/";
		$file_name = correggi($mvcfile->FileName);
		$targetfilepath= $dir_path.$file_name;    
		if(is_file($targetfilepath))    
			unlink($targetfilepath);
		$mvcfile->MoveTo($targetfilepath);
		
		if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/')){
			mkdir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/');	
		}
			
		copy($targetfilepath,'../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/'.$file_name);
		
		
		$uploader->WriteValidationOK("File caricato!");	
		?>
			<script language="javascript" type="text/javascript">window.parent.Upload_success("<?php echo $targetfilepath ?>",<?php echo $height; ?>);</script>   
		<?php
		
		
	}else{
		$card->Logout();	
	}
	
	function correggi($stringa) {
		$correzioni = array("À" => "A", "Á" => "A", "Â" => "A", "Ä" => "A", "Å" => "A", "Æ" => "AE", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ñ" => "N", "Ò" => "O", "Ó" => "O", "Ô" => "O", "Ö" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "ß" => "ss", "à" => "a", "á" => "a", "â" => "a", "ä" => "a", "æ" => "ae", "ç" => "c", "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "ö" => "o", "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "Ő" => "O", "ő" => "o", "Œ" => "OE", "œ" => "oe");
		foreach($correzioni as $chiave => $valore) {
			$stringa = str_replace($chiave, $valore, $stringa);
		}
		$stringa = eregi_replace("[[:space:]]" , "_", $stringa);
		$stringa = eregi_replace("[^[:alnum:]._-]" , "", $stringa);
		return $stringa;
	}
	

?> 