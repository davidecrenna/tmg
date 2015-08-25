<?php
class CardUploader{
	public function upload_image($server_file_name,$server_file_temp_name,$max_size,$upload_dir,$new_name = NULL,&$error,$max_width,$min_width,$min_height,$save_dir){
		$file_name = ($new_name) ? $new_name : $server_file_name;
		if(trim($server_file_name) == "") {
			$error = "Errore. Non hai selezionato il file!";
			return false;
		}
		$file_ext = substr($server_file_name, strrpos($server_file_name, ".") + 1);  
  
		//Only process if the file is a JPG and below the allowed limit  
		if (($file_ext!="jpg") && ($file_ext!="jpeg") && ($file_ext!="gif") && ($file_ext!="png") &&($file_ext!="JPG") && ($file_ext!="JPEG") && ($file_ext!="GIF") && ($file_ext!="PNG")){
			$error = "Il file non rispetta i formati supportati.";  
			return false;
		}
		
		if( filesize($server_file_temp_name) > $max_size){
			$error = "Il file è troppo grande";
			return false;
		}
		
		$large_image_location = "$upload_dir/$file_name";
		$saved_large_image_location = "$save_dir/$file_name";
		;
		if(@is_uploaded_file($server_file_temp_name)) {
			if(!@move_uploaded_file($server_file_temp_name, $saved_large_image_location)){
				$error = "Impossibile spostare il file, controlla l'esistenza o i permessi della directory dove fare l'upload.";
				return false;
			}else{
				$image = new SimpleImage();
				$image->load($saved_large_image_location);
				$width = $image->getWidth();
				$height =  $image->getHeight();
				//Scale the image if it is greater than the width set above  
				if ($width < $min_width || $height<$min_height){
					$error = "L'immagine e troppo piccola. Per un risultato professionale l'immagine deve avere dimensioni minime ( larghezza: ".$min_width." x altezza:".$min_height." )px.";
					return false;
				}
				if ($width > $max_width){
					$image->resizeToWidth($max_width);   
				}
				$image->save($large_image_location);
				
				return USER_LARGE_PHOTO_PATH.$server_file_name;
			}
		} else {
			$error = "Problemi nell'upload del file ".$server_file_name;
			return false;
		}
		return true;
	}
	
}
?>