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
	$image_file 	= '../../image/biglietto/tmgbv2012.png';

	// x and y for the bottom right of the text
	// so it expands like right aligned text
	$x_finalpos 	= 227;
	$y_finalpos 	= 303;

	// trust me for now...in PNG out PNG
	$mime_type 			= 'image/png' ;
	$extension 			= '.png' ;
	$s_end_buffer_size 	= 4096 ;

	// check for GD support
	if(!function_exists('ImageCreate'))
		fatal_error('Error: Server does not support PHP image generation') ;

	// check font availability;
	if(!is_readable($font_file)) {
		fatal_error('Error: The server is missing the specified font.') ;
	}
	// create and measure the text
	$font_rgb = hex_to_rgb($font_color) ;
	$image =  imagecreatefrompng($image_file);
	// allocate colors and measure final text position
	$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
	$image_width = imagesx($image);
	$image_height = imagesy($image);
	
	$card->SetArrayBv($arraybv);

	//stampo il nome / cognome / username
	if(strlen($card->Getnameshowed())>35){//il nameshowed è più lungo di 35 caratteri
		$font_size = 30 ; // font size in pts
		if ($card->flagnameshowed==1){	
			$text = strtoupper($card->Nome)." ".strtoupper($card->Cognome);	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $y_finalpos;
			if(!$image || !$box)
			{
				fatal_error('Error: The server could not create this image 1.') ;
			}
		
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}else if ($card->flagnameshowed==2){
			$text = strtoupper($card->username);	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $y_finalpos;
			if(!$image || !$box)
			{
				fatal_error('Error: The server could not create this image 1.') ;
			}
		
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			
			$text = "(".strtoupper($card->Nome)." ".strtoupper($card->Cognome).")";	
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+12;
			if(!$image || !$box)
			{
				fatal_error('Error: The server could not create this image 1.') ;
			}
		
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
			
		}	
	}else{//name showed ci sta su una riga
		$font_size = 31 ; // font size in pts
		$text = $card->Getnameshowed();	
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $y_finalpos;
		if(!$image || !$box)
		{
			fatal_error('Error: The server could not create this image 1.') ;
		}
	
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
	
	
	$font_size = 28;
	$font_file 	= '../../font/Futura-Bold.ttf';
	
	if($arraybv['p']!= NULL){
		$text= $arraybv['p'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+12;
		if(!$image || !$box)
		{
			fatal_error('Error: The server could not create this image 2.') ;
		}
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
	
	if($arraybv['cell']!= NULL){
		$text = $arraybv['cell'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+10;
		if(!$image || !$box)
		{
			fatal_error('Error: The server could not create this image 3.') ;
		}
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	}
	
	$currenty=428;
	$font_size = 25 ;
	$font_file 	= '../../font/Futura-Book.ttf';
	
	$text="web: ".$arraybv['web']."/".$card->username;
	$box = @ImageTTFBBox($font_size,0,$font_file,$text);
	$text_width = abs($box[2]-$box[0]);
	$text_height = abs($box[5]-$box[3]);
	$put_text_x = ($image_width/2)-($text_width/2);
	$currenty = $currenty+$text_height+8;
	if(!$image || !$box)
	{
		fatal_error('Error: The server could not create this image 4.') ;
	}
	imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
	
	if($arraybv['email']!= ""){
		$text="mail: ".$arraybv['email'];
		$box = @ImageTTFBBox($font_size,0,$font_file,$text);
		$text_width = abs($box[2]-$box[0]);
		$text_height = abs($box[5]-$box[3]);
		$put_text_x = ($image_width/2)-($text_width/2);
		$currenty = $currenty+$text_height+8;
		if(!$image || !$box)
		{
			fatal_error('Error: The server could not create this image 5.') ;
		}
		imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		
		if($card->bv_tmg_email==1){
			$text="TMG mail: ".$card->Get_member_email();
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+8;
			if(!$image || !$box)
			{
				fatal_error('Error: The server could not create this image 5.') ;
			}
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
	}else{
		if($card->bv_tmg_email==1){
			$text="TMG mail: ".$card->Get_member_email();
			$box = @ImageTTFBBox($font_size,0,$font_file,$text);
			$text_width = abs($box[2]-$box[0]);
			$text_height = abs($box[5]-$box[3]);
			$put_text_x = ($image_width/2)-($text_width/2);
			$currenty = $currenty+$text_height+8;
			if(!$image || !$box)
			{
				fatal_error('Error: The server could not create this image 5.') ;
			}
			imagettftext($image, $font_size, 0, $put_text_x, $currenty, $font_color, $font_file, $text);
		}
	}
	
	ImagePNG($image,'../../'.USERS_PATH.$card->username.'/download_area/public/tmg_'.$card->username.'_biglietto.png');
	echo "<img id='img_biglietto_preview' width='350'></img>";
	?>
    <script>
		newImage= document.getElementById("img_biglietto_preview");
		newImage.src = "../../<? echo USERS_PATH.$card->username; ?>/download_area/public/tmg_<? echo $card->username ?>_biglietto.png?" + new Date();
	</script>
    <?
	ImageDestroy($image);
	exit;

	/*

		attempt to create an image containing the error message given. 

		if this works, the image is sent to the browser. if not, an error

		is logged, and passed back to the browser as a 500 code instead.

	*/

	function fatal_error($message)

	{

		// send an image

		if(function_exists('ImageCreate'))

		{

			$width = ImageFontWidth(5) * strlen($message) + 10 ;

			$height = ImageFontHeight(5) + 10 ;

			if($image = ImageCreate($width,$height))

			{

				$background = ImageColorAllocate($image,255,255,255) ;

				$text_color = ImageColorAllocate($image,0,0,0) ;

				ImageString($image,5,5,5,$message,$text_color) ;    

				header('Content-type: image/png') ;

				ImagePNG($image) ;

				ImageDestroy($image) ;

				exit ;

			}

		}

	

		// send 500 code

		header("HTTP/1.0 500 Internal Server Error") ;

		print($message) ;

		exit ;

	}

	

	

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