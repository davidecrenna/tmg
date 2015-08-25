<?php	
	require_once("../../headerbasic.php");
	include('../../header.php');
	if(!isset($_GET["u"])){
		header("location: ../../index.php");
	}
	$ctrl_user = new Ctrluser();
	if($ctrl_user->IsUsername($_GET["u"]) != 0){
		header("location: ../../index.php");
	}
	
	$card= new Card($_GET["u"]);
	
	// customizable variables
	$font_file 		= '../../font/Futura-Book.ttf';
	$font_color 	= '#000000';
	$image_file 	= '../../image/biglietto/tmgbv2012.jpg';


	$x_finalpos 	= 227;
	$y_finalpos 	= 153;

	$mime_type 			= 'image/jpg' ;
	$extension 			= '.jpg' ;
	$s_end_buffer_size 	= 4096 ;

	// create and measure the text
	$font_rgb = hex_to_rgb($font_color) ;
	$image =  imagecreatefromjpeg($image_file);
	// allocate colors and measure final text position
	$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
	$image_width = imagesx($image);
	$image_height = imagesy($image);
	
	$card->SetArrayBv($arraybv);



	//stampo il nome / cognome / username
	if(strlen($card->Getnameshowed())>35){//il nameshowed è più lungo di 35 caratteri
		$font_size = 14 ; // font size in pts
		if ($card->flagnameshowed==1){	
			$text = strtoupper($card->Nome)." ".strtoupper($card->Cognome);	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $y_finalpos;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}else if ($card->flagnameshowed==2){
			$text = strtoupper($card->username);	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $y_finalpos;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			
			$text = "(".strtoupper($card->Nome)." ".strtoupper($card->Cognome).")";	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+12;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			
		}	
	}else{//name showed ci sta su una riga
		$font_size = 14 ; // font size in pts
		$text = $card->Getnameshowed();	
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $y_finalpos;
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
		
	
	//stampo la professione
	$font_size = 12;
	$font_file 	= '../../font/Futura-Bold.ttf';
	
	if($arraybv['p']!= NULL){
		$text= $arraybv['p'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+12;
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
	
	if($arraybv['cell']!= NULL){
		$text = $arraybv['cell'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+10;
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
	
	$currenty=220;
	$font_size = 12 ;
	$font_file 	= '../../font/Futura-Book.ttf';
	
	$text="web: ".$arraybv['web']."/".$card->username;
	$box = @ImageTTFBBox($font_size,0,$font_file,$text);
	$text_width = abs($box[2]-$box[0]);
	$text_height = abs($box[5]-$box[3]);
	$put_text_x = ($image_width/2)-($text_width/2);
	$currenty = $currenty+$text_height+8;
	imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	
	if($arraybv['email']!= ""){
		$text="mail: ".$arraybv['email'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+2;
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		
		if($card->bv_tmg_email==1){
			$text="TMG mail: ".$card->Get_member_email();
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+2;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
	}else{
		if($card->bv_tmg_email==1){
			$text="TMG mail: ".$card->Get_member_email();
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+2;
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
	}
	
	ImageJPEG($image,'../../'.USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_biglietto.jpg');
	
	//header('Content-type: ' . $mime_type) ;
	echo "<img src='../../".USERS_PATH.$card->username."/download_area/public/tmg_".$card->username."_biglietto.jpg' width='500'></img>";
	ImageDestroy($image);
	exit;

	

	/* 

		decode an HTML hex-code into an array of R,G, and B values.

		accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff 

	*/    

	function hex_to_rgb($hex) {

		// remove '#'

		if(substr($hex,0,1) == '#')

			$hex = substr($hex,1) ;

	

		// expand short form ('fff') color to long form ('ffffff')

		if(strlen($hex) == 3) {

			$hex = substr($hex,0,1) . substr($hex,0,1) .

				   substr($hex,1,1) . substr($hex,1,1) .

				   substr($hex,2,1) . substr($hex,2,1) ;

		}

	

		if(strlen($hex) != 6)

			fatal_error('Error: Invalid color "'.$hex.'"') ;

	

		// convert from hexidecimal number systems

		$rgb['red'] = hexdec(substr($hex,0,2)) ;

		$rgb['green'] = hexdec(substr($hex,2,2)) ;

		$rgb['blue'] = hexdec(substr($hex,4,2)) ;

	

		return $rgb ;

	}

?>