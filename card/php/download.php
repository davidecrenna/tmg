<?php
	include("../../headerbasic.php");
	include("../../headerdownload.php");
	$username = $_GET['u'];
  	$card= new Card(NULL,$username);
	ini_set('memory_limit', -1);
	if(isset($_GET["foto"])){
		$card->create_main_zip_folder();
		output_file("../../".USERS_PATH.$card->username."/download_area/public/tmg_".$card->username."_foto.zip", "tmg_".$card->username."_foto.zip"); 
		
	}else if(isset($_GET["photo_album"])){
		$subfolder=rtrim($_GET['subfolder'],"/");
		
		$card->create_photo_album_zip_folder($subfolder);
		
		output_file("../../".USERS_PATH.$card->username."/filebox/photo/tmg_".$card->username."_".$subfolder.".zip", "tmg_".$card->username."_".$subfolder.".zip"); 
		
	}else if(isset($_GET["cv"])){
		output_file("../../".USERS_PATH.$card->username."/download_area/public/tmg_".$card->username."_curriculum.pdf", 'tmg_'.$card->username.'_curriculum.pdf'); 
	}else if(isset($_GET["bv"])){
		$card->Generate_bv();
		output_file('../../'.USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_biglietto.pdf', 'tmg_'.$card->username.'_biglietto.pdf'); 
		
	}else if(isset($_GET["attachments"])){
		if($card->is_user_logged()){
			output_file( $card->messaggi[$_GET['index']]['allegato_'.$_GET['id_allegato'].'_path'] , $card->messaggi[$_GET['index']]['allegato_'.$_GET['id_allegato'].'_name'] ); 
			
		}else{
			$card->Logout();	
		}	
	}else if(isset($_GET["file_box"])){
		$subfolder=rtrim($_GET['subfolder'],"/");
		$name =rtrim($_GET['name'],"/");
		$subfolder = str_replace("*","",$subfolder);
		output_file('../../'.USERS_PATH.$card->username.'/filebox/public/'.$subfolder.'/'.$name,$name);
	}else if(isset($_GET["file_box_private"])){
		$subfolder=rtrim($_GET['subfolder'],"/");
		$name=rtrim($_GET['name'],"/");
		$subfolder = str_replace("*","",$subfolder);
		if(isset($_SESSION['private_folder']) == md5($subfolder.$card->folders[$subfolder]['folder_pass'].session_id() ) ){
			output_file('../../'.USERS_PATH.$card->username.'/filebox/private/'.$subfolder.'/'.$name,$name);
		}else{
			echo "Non hai il permesso di accedere al file. E non dovresti essere qui!";	
		}
	}else if(isset($_GET["evidenza"])){
			output_file('../../'.USERS_PATH.$card->username.'/download_area/evidenza/news_'.$_GET['id'].'/'.$_GET['name'],$_GET['name']);
	}

	ini_restore('memory_limit');
	
	function output_file($file, $name, $mime_type='')
{
 /*
 This function takes a path to a file to output ($file),
 the filename that the browser will see ($name) and
 the MIME type of the file ($mime_type, optional).
 
 If you want to do something on download abort/finish,
 register_shutdown_function('function_name');
 */
 if(!is_readable($file)) die('Il file è inesistente o non è accessibile! ');
 
 $size = filesize($file);
 $name = rawurldecode($name);
 
 /* Figure out the MIME type (if not specified) */
 $known_mime_types=array(
    "pdf" => "application/pdf",
    "txt" => "text/plain",
    "html" => "text/html",
    "htm" => "text/html",
    "exe" => "application/octet-stream",
    "zip" => "application/zip",
    "doc" => "application/msword",
    "xls" => "application/vnd.ms-excel",
    "ppt" => "application/vnd.ms-powerpoint",
    "gif" => "image/gif",
    "png" => "image/png",
    "jpeg"=> "image/jpg",
    "jpg" =>  "image/jpg",
    "php" => "text/plain"
 );
 
 if($mime_type==''){
     $file_extension = strtolower(substr(strrchr($file,"."),1));
     if(array_key_exists($file_extension, $known_mime_types)){
        $mime_type=$known_mime_types[$file_extension];
     } else {
        $mime_type="application/force-download";
		
     };
 };
 
 @ob_end_clean(); //turn off output buffering to decrease cpu usage
 
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 /* The three lines below basically make the
    download non-cacheable */
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
    list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
    list($range) = explode(",",$range,2);
    list($range, $range_end) = explode("-", $range);
    $range=intval($range);
    if(!$range_end) {
        $range_end=$size-1;
    } else {
        $range_end=intval($range_end);
    }
 
    $new_length = $range_end-$range+1;
    header("HTTP/1.1 206 Partial Content");
    header("Content-Length: $new_length");
    header("Content-Range: bytes $range-$range_end/$size");
 } else {
    $new_length=$size;
    header("Content-Length: ".$size);
 }
 
 /* output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
    if(isset($_SERVER['HTTP_RANGE']))
    fseek($file, $range);
 
    while(!feof($file) &&
        (!connection_aborted()) &&
        ($bytes_send<$new_length)
          )
    {
        $buffer = fread($file, $chunksize);
        print($buffer); //echo($buffer); // is also possible
        flush();
        $bytes_send += strlen($buffer);
    }
 fclose($file);
 } else die('Error - can not open file.');
 
die();
}   
	
?>