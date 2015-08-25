<?
	require_once("../../headerbasic.php");
	include("../../header.php");
	$username=$_GET['u'];
	$card= new Card(NULL,$username);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>Ritaglia la foto</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<!--<script type="text/javascript" src="js/mootools-for-crop.js"> </script>
    <script type="text/javascript" src="js/UvumiCrop-compressed.js"> </script>-->
    <link rel="stylesheet" type="text/css" media="screen" href="../../common/css/uvumi-crop.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../../common/css/text.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../../common/css/buttons.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../css/photocrop.css"/>
    
    <script type="text/javascript" src="../../common/js/ajax.inc.js"></script>
    <script type="text/javascript" src="../../common/js/mootools-for-crop.js"> </script>
    
    <script type="text/javascript" src="../../common/js/UvumiCrop-compressed.js"> </script>
    <script type="text/javascript" src="../js/photocrop.js"> </script>
	<style type="text/css">
		body,html{
			background-color:#838383;
			margin:0;
			padding:0;
			font-family:Trebuchet MS, Helvetica, sans-serif;
		}
		
		hr{
			margin:20px 0;
		}
		
		#main{
			margin:10px;
			position:relative;
			overflow:auto;
			color:#aaa;
			padding:10px;
			border:1px solid #888;
			background-color:#838383;
			text-align:center;
		}

		#resize_coords{
			width:300px;
		}
		
		#previewExample3{
			margin:10px;
		}

		.yellowSelection{
			border: 2px dotted #FFB82F;
		}

		.blueMask{
			background-color:#00f;
			cursor:pointer;
		}
	</style>
	<script type="text/javascript">
		    new uvumiCropper('myImage',{
			keepRatio:true,
			//preview:'myPreview',
			handles:[
			['top','left'],
			['top','right'],
			['bottom','left'],
			['bottom','right']
			],mini:{
			x:210,
			y:315
			},
			onComplete:function(top,left,width,height){
				$('input_top').set('value', top);
				$('input_left').set('value', left);
				$('input_width').set('value', width);
				$('input_height').set('value', height);
			},
			coordinates:false
			//coordinates:true,
			//preview:true,
			//downloadButton:true,
			//saveButton:true
		});
	</script>
</head>
<body>

 <?php $card->Show_input_username(); ?>
	<div style="position:fixed; z-index:15000; left:30px;">	
				<div class='personal_button' style='width:200px; height:23px;' id='cambia_foto'>
                    <a target='_self' style='width:150px; height:23px;' onclick='Annulla_crop()'><span class='text14px' style="position:relative; top:-2px; color:#FFF;">INDIETRO E ANNULLA</span>
                    </a>
                </div>
                <div class='personal_button' style='width:150px; height:23px;' id='cambia_foto'>
                    <a target='_self' style='width:150px; height:23px;' onclick="Crop_photo()"><span class='text14px' style="position:relative; top:-2px; color:#FFF;">RITAGLIA E SALVA</span>
                    </a>
                </div>
     </div>
	<div id="main">
		<div>
				<img id="myImage" src="<?php echo $_GET["image_path"]; ?>" alt="My image" class="img_crop"/>
                <input id="input_top" type="hidden" value="0"/>
                <input id="input_left" type="hidden" value="0" />
                <input id="input_width" type="hidden" value="215" />
                <input id="input_height" type="hidden" value="375"/>
                <input id="image_path" type="hidden" value="<?php echo $_GET["image_path"]; ?>"/>
		</div>
	</div>
</body>
</html>
