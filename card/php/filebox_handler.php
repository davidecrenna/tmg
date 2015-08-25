<?php 
	require_once("../../headerbasic.php");
	require_once "../../header.php";

    $uploader=new PhpUploader();    
   
    $mvcfile=$uploader->GetValidatingFile();    
	
	$card = new Card(NULL,$_GET["u"]);

	if($card->Is_uploadable($mvcfile->FilePath)==1){
		$uploader->WriteValidationError("Non è possibile eseguire l'upload, l'utente ha terminato lo spazio residuo della card.");
	}
	
	if($card->is_user_logged()){
		if(isset($_GET['public'])){
			$dir_path =  "../../".USERS_PATH.$card->username."/filebox/public/";
			$handler = opendir($dir_path);
			
			$index = 0;
			$total_size = 0;
			// open directory and walk through the filenames
			while ($file = readdir($handler)) {
			// if file isn't this directory or its parent, add it to the results
				if ($file != "." && $file != "..") {
					$extension = pathinfo($dir_path.$file, PATHINFO_EXTENSION);
					$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif","ZIP","zip","RAR","rar","DOC","doc","DOCX","docx","ODT","odt","TXT","txt","xls","xlsx","PDF","pdf","MP3","mp3","WAV","wav","MP4","mp4","MPEG","mpeg","MOV","mov","AVI","avi","WMA","wma","ODS","ods");
					//jpeg,jpg,gif,png,zip,doc,txt,rar,xls,xlsx,docx,pdf,mov,mp4
					
					$allowed = 0;
					foreach ($listed_extension as $value) {
						if($extension == $value){
							$allowed = 1;
						}
					}
					if( $allowed == 1 ){
						$size = filesize($dir_path.$file);
						$index++;
					}
				}
	
				$total_size = $total_size + $size;
			}
		
			// tidy up: close the handler
			closedir($handler);
			
			$total_size = $total_size + filesize($mvcfile->FilePath);
			
			
			if($total_size<104857600){
				$file_name = correggi($mvcfile->FileName);
				$targetfilepath= $dir_path.$file_name;    
				if( is_file ($targetfilepath) )    
					unlink($targetfilepath);    
				$mvcfile->MoveTo($targetfilepath);
				 $extension = pathinfo($targetfilepath, PATHINFO_EXTENSION);
				 
				 
				if(($extension=="jpeg")||($extension=="JPEG")||($extension=="jpg")||($extension=="JPG")||($extension=="PNG")||($extension=="png")||($extension=="gif")||($extension=="GIF")){
					$start_width=0;
					$start_height=0;
					$image_size = getimagesize ( $targetfilepath );
					$width = $image_size[0];
					$height = $image_size[1];
					
					$newImageHeight = 28;
					$ratio = $newImageHeight / $height;
     				$newImageWidth = $width * $ratio;
					
					$thumb_image_name = $file_name;
					ini_set('memory_limit', -1);
					$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
					switch($extension){
						case "JPG": case "jpg": case "JPEG": case "jpeg": 
							$source = imagecreatefromjpeg($targetfilepath);
						break;	
						case "PNG": case "png": 
							$source = imagecreatefrompng($targetfilepath);
						break;	
						case "GIF": case "gif": 
							$source = imagecreatefromgif($targetfilepath);
						break;	
					}
					
					imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
					imagejpeg($newImage,$thumb_image_name,90);
					chmod($thumb_image_name, 0777);
					copy($thumb_image_name,"../../".USERS_PATH.$card->username."/filebox/public/thumb/thumb_".$thumb_image_name);
					unlink($thumb_image_name);
					ini_restore('memory_limit');
				}
				
				$uploader->WriteValidationOK();	
				
				?>
                	<script type="text/javascript">
						window.parent.Show_Setting_Saved("file_saved");
                    </script>
                <?
			}else{
				$uploader->WriteValidationError("Hai raggiunto il limite di caricamento (100MB)");   	
				exit(200);
			}
		}
		if(isset($_GET['sub_folder'])){
			$folder = $_GET['folder'];
			$parent = $_GET['parent'];
			$dir_path =  "../../".USERS_PATH.$card->username."/filebox/".$parent."/".$folder."/";
			
			$handler = opendir($dir_path);
			
			$index = 0;
			// open directory and walk through the filenames
			while ($file = readdir($handler)) {
			// if file isn't this directory or its parent, add it to the results
				if ($file != "." && $file != "..") {
					$extension = pathinfo($path.$file, PATHINFO_EXTENSION);
				
					if($_GET['parent']!="photo"){
						$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif","ZIP","zip","RAR","rar","DOC","doc","DOCX","docx","ODT","odt","TXT","txt","xls","xlsx","PDF","pdf","MP3","WAV","wav","mp3","AVI","avi","WMA","wma");
					}else if($_GET['parent']=="photo"){
						$listed_extension = array("JPG","jpg","JPEG","jpeg","PNG","png","GIF","gif");
					}
					
					$allowed = 0;
					foreach ($listed_extension as $value) {
						if($extension == $value){
							$allowed = 1;
						}
					}
					if( $allowed == 1 ){
						$index++;
					}
				}
			}
			
			$parent_path = "../../".USERS_PATH.$card->username."/filebox/".$GET_['parent']."/";
			
			$total_size=0;
			$parent_handler = opendir($parent_path);
			while ($f = readdir($parent_handler)) {
				if ($f != "." && $f != ".."){
					$tot_size=0;
					if(is_dir($parent_path.$f)){
						$sub_handler = opendir($parent_path.$f);
						while ($file = readdir($sub_handler)) {
							if ($file != "." && $file != ".."){
								  $size = filesize($parent_path.$f."/".$file);
								  $tot_size = $tot_size + $size;
							}
						}
					}else{
						 $tot_size = filesize($parent_path.$f);
					}
					$total_size = $total_size + $tot_size;
				}
			}
			
			
			// tidy up: close the handler
			closedir($handler);
			$total_size = $total_size + filesize($mvcfile->FilePath);
			if($_GET['parent']=="private")
				$max_size=2097483648;
			else if($_GET['parent']=="public")
				$max_size=104857600;
			else if($_GET['parent']=="photo")
				$max_size=104857600;
				
				
			if($total_size<$max_size){
				$file_name = str_replace("'","",$mvcfile->FileName);
				$targetfilepath= $dir_path.$file_name;    
				if( is_file ($targetfilepath) )    
					unlink($targetfilepath);
				$mvcfile->MoveTo($targetfilepath);
				 $extension = pathinfo($targetfilepath, PATHINFO_EXTENSION);
				if(($extension=="jpeg")||($extension=="JPEG")||($extension=="jpg")||($extension=="JPG")||($extension=="PNG")||($extension=="png")||($extension=="gif")||($extension=="GIF")){
					$start_width=0;
					$start_height=0;
					$image_size = getimagesize ( $targetfilepath );
					$width = $image_size[0];
					$height = $image_size[1];
					
					if($_GET['parent']=="photo"){
						$newImageHeight_small_thumb = 69;
						if($width>720){
							$newImageWidth_big_thumb = 720;	
							$ratio_big_thumb = $newImageWidth_big_thumb / $width;
							$newImageHeight_big_thumb = $height * $ratio_big_thumb;
						}
					}else{
						$newImageHeight_small_thumb = 28;
					}
					
					$ratio_small_thumb = $newImageHeight_small_thumb / $height;
     				$newImageWidth_small_thumb = $width * $ratio_small_thumb;
					
					
					$small_thumb_image_name = $file_name;
					ini_set('memory_limit', -1);
					
					//SMALL THUMB
					$newImage = imagecreatetruecolor($newImageWidth_small_thumb,$newImageHeight_small_thumb);
					switch($extension){
						case "JPG": case "jpg": case "JPEG": case "jpeg": 
							$source = imagecreatefromjpeg($targetfilepath);
						break;	
						case "PNG": case "png": 
							$source = imagecreatefrompng($targetfilepath);
						break;	
						case "GIF": case "gif": 
							$source = imagecreatefromgif($targetfilepath);
						break;	
					}
					imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth_small_thumb,$newImageHeight_small_thumb,$width,$height);
					imagejpeg($newImage,$small_thumb_image_name,90);
					chmod($small_thumb_image_name, 0777);
					
					if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/thumb/')){
						mkdir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/thumb/');	
					}
					
					copy($small_thumb_image_name,"../../".USERS_PATH.$card->username."/filebox/".$parent."/".$folder."/thumb/thumb_".$small_thumb_image_name);
					unlink($small_thumb_image_name);
					
					//BIG THUMB
					if($width>720){
						$newImage_big = imagecreatetruecolor($newImageWidth_big_thumb,$newImageHeight_big_thumb);
						switch($extension){
							case "JPG": case "jpg": case "JPEG": case "jpeg": 
								$source = imagecreatefromjpeg($targetfilepath);
							break;	
							case "PNG": case "png": 
								$source = imagecreatefrompng($targetfilepath);
							break;	
							case "GIF": case "gif": 
								$source = imagecreatefromgif($targetfilepath);
							break;	
						}
						$big_thumb_image_name = $file_name;
						imagecopyresampled($newImage_big,$source,0,0,$start_width,$start_height,$newImageWidth_big_thumb,$newImageHeight_big_thumb,$width,$height);
						imagejpeg($newImage_big,$big_thumb_image_name,90);
						chmod($big_thumb_image_name, 0777);
						
						if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/big_thumb/')){
							mkdir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/big_thumb/');	
						}
						
						copy($big_thumb_image_name,"../../".USERS_PATH.$card->username."/filebox/".$parent."/".$folder."/big_thumb/big_thumb_".$big_thumb_image_name);
						unlink($big_thumb_image_name);
					}else{
						$newImage_big = imagecreatetruecolor($width,$height);
						switch($extension){
							case "JPG": case "jpg": case "JPEG": case "jpeg": 
								$source = imagecreatefromjpeg($targetfilepath);
							break;	
							case "PNG": case "png": 
								$source = imagecreatefrompng($targetfilepath);
							break;	
							case "GIF": case "gif": 
								$source = imagecreatefromgif($targetfilepath);
							break;	
						}
						$big_thumb_image_name = $file_name;
						imagecopyresampled($newImage_big,$source,0,0,$start_width,$start_height,$width,$height,$width,$height);
						imagejpeg($newImage_big,$big_thumb_image_name,90);
						chmod($big_thumb_image_name, 0777);
						
						if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/big_thumb/')){
							mkdir('../../'.USERS_PATH.$card->username.'/filebox/'.$parent.'/'.$folder.'/big_thumb/');	
						}
						
						copy($big_thumb_image_name,"../../".USERS_PATH.$card->username."/filebox/".$parent."/".$folder."/big_thumb/big_thumb_".$big_thumb_image_name);
						unlink($big_thumb_image_name);
					}
					
					
					ini_restore('memory_limit');
					
					
				}
				$uploader->WriteValidationOK("File caricato!");	
				?>
                	<script type="text/javascript">
						window.parent.Show_Setting_Saved("file_saved");
                    </script>
                <?
			}else{
				$uploader->WriteValidationError("Hai raggiunto il limite di caricamento (".$max_size.")");   
				?>
                	<script type="text/javascript">
						window.parent.Show_Setting_Saved("file_error");
                    </script>
                <?
				exit(200);
			}
		}
	}else{
		$card->Logout();	
	}
	
	function correggi($stringa) {
		$correzioni = array("À" => "A", "Á" => "A", "Â" => "A", "Ä" => "A", "Å" => "A", "Æ" => "AE", "Ç" => "C", "È" => "E", "É" => "E", "Ê" => "E", "Ë" => "E", "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ñ" => "N", "Ò" => "O", "Ó" => "O", "Ô" => "O", "Ö" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "ß" => "ss", "à" => "a", "á" => "a", "â" => "a", "ä" => "a", "æ" => "ae", "ç" => "c", "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï" => "i", "ñ" => "n", "ò" => "o", "ó" => "o", "ô" => "o", "ö" => "o", "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "Ő" => "O", "ő" => "o", "Œ" => "OE", "œ" => "oe");
		foreach($correzioni as $chiave => $valore) {
			$stringa = str_replace($chiave, $valore, $stringa);
		}
		$stringa = eregi_replace("[[:space:]]" , "_", $stringa);
		//$stringa = eregi_replace("[^a-z0-9._-]" , "", $stringa);
		$stringa = eregi_replace("[^[:alnum:]._-]" , "", $stringa);
		return $stringa;
	} 

?> 