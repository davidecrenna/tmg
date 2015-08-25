<?php 
require_once("../../headerbasic.php");
require_once "../../header.php" ?>    
<?php    
    $uploader=new PhpUploader();    
   	$username=$_GET['u'];
	$news_id=$_GET['news_id'];
	$card= new Card(NULL,$username);
	$mvcfile=$uploader->GetValidatingFile();
	if($card->Is_uploadable($mvcfile->FilePath)==1){
		$uploader->WriteValidationError("Non è possibile eseguire l'upload, l'utente ha terminato lo spazio residuo della card.");
	}
	if(!$card->is_user_logged()){
		$uploader->WriteValidationError("Devi essere loggato!");
		exit(200);
	}
	
	$card->del_file_in_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id);
    
	
    //USER CODE:
	$file_name = str_replace("'","",$mvcfile->FileName);
	$file_name = str_replace(" ","_",$file_name);
    $targetfilepath = "../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id."/".$file_name;
    if( is_file ($targetfilepath) )    
     	unlink($targetfilepath);    
    $mvcfile->MoveTo($targetfilepath);
    $uploader->WriteValidationOK();
	
	
	$extension = pathinfo($targetfilepath, PATHINFO_EXTENSION);
	if($extension=="pdf" || $extension=="PDF"){
		if(!is_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id."/pdfconverted/")){
			mkdir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id."/pdfconverted/");	
		}		
		
		$pdfname =$targetfilepath;
		
		for ($i=0;$i<count_pages($pdfname);$i++){
			$convertedfilepath = "../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$news_id."/pdfconverted/".$file_name.'_pag'.$i.'.jpg';
			
			// Max vert or horiz resolution
			$maxsize=1080;
			
			$im = new Imagick();
	
			$im->setResolution(300,300);
			$im->readimage($pdfname.'['.$i.']'); 
			$im->setImageFormat('jpeg');
			
			
			// Resizes to whichever is larger, width or height
			if($im->getImageHeight() <= $im->getImageWidth())
			{
			// Resize image using the lanczos resampling algorithm based on width
			$im->resizeImage($maxsize,0,Imagick::FILTER_LANCZOS,1);
			}
			else
			{
			// Resize image using the lanczos resampling algorithm based on height
			$im->resizeImage(0,$maxsize,Imagick::FILTER_LANCZOS,1);
			}
			
			// Set to use jpeg compression
			$im->setImageCompression(Imagick::COMPRESSION_JPEG);
			// Set compression level (1 lowest quality, 100 highest quality)
			$im->setImageCompressionQuality(100);
			// Strip out unneeded meta data
			$im->stripImage();
			
			$im->writeImage($convertedfilepath); 
			$im->clear(); 
			$im->destroy();
			
		}
	}
	
	
	if($_GET["mod"]==NULL){
	?>
		<script language="javascript" type="text/javascript">window.parent.Aggiorna_evidenza("<?php echo $file_name; ?>",<?php echo $news_id; ?>);</script>
    <?php
	}else if($_GET["mod"]==1){
	?>
		<script language="javascript" type="text/javascript">window.parent.Aggiorna_evidenza_mod("<?php echo $file_name; ?>",<?php echo $news_id; ?>);</script>
    <?php
	}else if($_GET["mod"]==2){
	?>
		<script language="javascript" type="text/javascript">window.parent.Aggiorna_evidenza_mod_now("<?php echo $file_name; ?>",<?php echo $news_id; ?>);</script>
    <?php
	}
	
	function count_pages($pdfname) {
	  $pdftext = file_get_contents($pdfname);
	  $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
	  return $num;
	}
	
?> 