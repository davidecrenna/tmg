<?php
	require_once("../../headerbasic.php");
	include("../../header.php");
	$username=$_GET['u'];
	if(session_id() == '') {
		session_name(SESSION_NAME);
	   // Now we cat start the session
	   session_start();
	}
	$card= new Card(NULL,$username);
	if(!$card->is_user_logged()){
		header("location: ../../error_page.php");
		exit ("Non hai effettuato l'accesso!" );
	}
		
	$card->del_file_in_dir("../../".USERS_PATH.$username."/".USER_LARGE_PHOTO_PATH);
	$card->del_file_in_dir("../../".USERS_PATH.$username."/".USER_PHOTO_TEMP_PATH);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $card->Show_title()?></title>
<link rel="stylesheet" type="text/css" href="../css/photo.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/text.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/icon.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/buttons.css"/>

<script type="text/javascript" src="../../common/js/ajax.inc.js"></script>
<script type="text/javascript" src="../../common/js/jquery.min.js"></script>
<script src="../../common/js/jquery.tools.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/photo.js"></script>

</head>
<body>
	<div style='display:none;'>
		<? $card->fix_upload(); ?>
    </div>
	 <? $card->Show_input_username(); ?>
     <div id='slide_loading' class='personal_tab_loading_onpage'><img src='../../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>
     <div id='slide_saved' class='personal_tab_loading_onpage'><img src='../../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Informazioni salvate<span></div>
		<div align="center">
         	<div class="cols" id="upload">
                 <div style="left:19px; top:370px;" class="colfooter">
                    <div class='personal_button' onclick='Javascript:return_to_the_card()' style='width:100px;'>
                        <span class='text14px' alt='Salva'>INDIETRO</span>
                    </div>
                    
					<div class="upload_progress_container">
                        <img id="uploadercancelbutton" style="position:absolute; top: 5px; z-index:9000; left: 0px; cursor:pointer" alt="Cancel" src="../../image/btn/btn_cancella.png" />
                        
                         <div id="uploaderprogresspanel" style="position:absolute;left: 85px; top: 0px; display:block; background-color:#33333; border: 2px gray; padding:4px; width:370px; z-index:9000;" BorderColor="Grey" BorderStyle="dashed">
                         
                        <span id="uploaderprogresstext" style="color:white"></span></div>
                    </div>
                </div>
                <div style="left: 20px; top: 10px; background-color:#6B6B6B;" class="col2">
                    <span class="text14px">Modifica Foto Principale</span>
                    
                    <? $card->Show_main_photo(170,255,"../../"); ?>
                    <div style="position:absolute; top:270px; left:85px;">
                        <? $card->Personal_upload_main_photo_mini(); ?>
                    </div>
                </div>
                
                <div style="left: 230px; top: 10px; background-color:#6B6B6B;" class="col3">
                    <span class="text14px">Modifica Foto Slideshow</span>
                    <div class="slide_photo_main_container">
						<?
							if(count($card->user_photo_slide_path)>0){
								$index=0;
								foreach($card->user_photo_slide_path as $photo_slide_path){
									echo "<div class='slide_photo_container'>";
										$pos = strpos($photo_slide_path, "default_photo/");
										if ($pos !== false){
											echo "<img src='".$photo_slide_path."' style='width:140px;'/>";										
										}else{
											echo "<img src='../../".USERS_PATH."/".$card->username."/user_photo/".$photo_slide_path."' style='width:140px;'/>";	
										}
										echo "<div class='delete_slide_photo_container'>";
											echo "<div class='personal_button_mini' onclick='Javascript:delete_slide_photo(".$index.")' style='width:70px;'>
													<span class='text12px'>ELIMINA</a>
												</div>";
											
											
										echo "</div>";
										echo "<div class='change_slide_photo_container'>";
											$card->Personal_upload_slide_photo($index,NULL);
										 echo "</div>"; 	
									echo "</div>";
									$index++;
								}
							}else{
								echo "<span class='text12px'>Non sono presenti foto. Clicca su AGGIUNGI per inserire foto nel tuo slideshow.</span>";
							}
                        ?>
                        
                    </div>
                    
                    <div class="slide_photo_add_container">
                    <? 
						if(count($card->user_photo_slide_path)<8){
							$card->Personal_upload_slide_photo(count($card->user_photo_slide_path),1);
					   }else{
							echo "<span class='text12px'>Hai raggiunto il limite massimo di foto nel tuo slideshow. Puoi caricare altre foto nella sezione FOTO e DOCUMENTI.</span>";
					   }
					?>
                    </div>
                </div>
                
               
             </div>
        </div>
</body>
</html>