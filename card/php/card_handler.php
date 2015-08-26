<?php
	require_once("../../headerbasic.php");
	include("../../header.php");
	if(session_id() == '') {
		session_name(SESSION_NAME);
	   // Now we cat start the session
	   session_start();
	}
	
	//LOGIN-----------------------------------------------------------------------------------------------------------
	if (isset($_POST['__user']))
    {
		if (trim($_POST['user'])!="")
		{
			// Ritorna al client la sfida.
			$login = new classe_login();
			echo $login->invia_sfida($_POST['user']);
		}
		exit;
    }
	
	if (isset($_POST['__submit']))
    {	
		//echo "USER: ".$_POST['user']." PWD: ".$_POST['pwd']." COPIA SFIDA: ".$_POST['copia_sfida']."";
		if (trim($_POST['user'])!="" && trim($_POST['pwd'])!="" && trim($_POST['copia_sfida'])!="")
        {
			$login = new classe_login();
			
			if ($login->verifica_login($_POST['user'],$_POST['pwd'],$_POST['copia_sfida']))
			{
				$json_string = json_encode(array("result"=>"true","user"=>$_POST['user'])); 
				echo $json_string;
			}
			else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;
			}
			exit;
        }else{
			$json_string = json_encode(array("result"=>"false")); 
			echo $json_string;
		}
    //altrimenti ri-visualizza il form di login.
    }
	if(isset($_POST["Check_user_logged"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			 $json_string = json_encode(array("result"=>"true")); 
			 echo $json_string;
		}else{ 					
			 $card->Logout();
			  $json_string = json_encode(array("result"=>"false")); 
			 echo $json_string;
		 }	
	}
	
	//--------------------------------------------------------------------------------------------------------------
	
	if(isset($_POST["Lista_gruppi_mailing"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged())
			 $card->Lista_gruppi_mailing();
		else{ 					
			 $card->Logout();
		 }	
	}
	
	if(isset($_POST["Load_photoslide"])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_photoslide();
		
	}
	if(isset($_POST["Load_login"])){
		$basic->Show_login($_POST["prepath"]);
	}
	
	if(isset($_POST["load_personal_area"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged())
			 $card->Show_personal_logged();
		else{ 					
			 $card->Show_Personal_Login_on_card();
		 }	
	}
	if(isset($_POST["Logout"]))
	{
		$card = new Card(NULL,$_POST["Username"]);
		$card->Logout();
		$card->Show_personal_login_on_card();
	}
	if(isset($_POST["Aggiorna_menu_avatar"]))
	{
		$card = new Card(NULL,$_POST["Username"]);
		$card->basic->Show_menu_avatar(true,$card->username, $card->is_user_logged(),$card->photo1_path);
	}
	
	
	//salvataggio contatti nella sezione personal
	if(isset($_POST['Delete_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->delete_contact_row($_POST["index"]);
		}else{
			$card->Logout();	
		}	
	}
	
	
	if(isset($_POST['Update_contact_element'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->update_contact_row($_POST["index"],$_POST["value"],$_POST["type"]);
		}else{
			$card->Logout();	
		}
	}

	if(isset($_POST['Refresh_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Contact_show_div();
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Add_contact_element'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			if(sizeof($card->contact_rows)<10){
				$card->Insert_contact_row($_POST["value"],$_POST["type"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Move_contact_up'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST['row_num']!=1){
				$card->Move_contact_up($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Load_create_bigliettovisita'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Create_bigliettovisita();
	}
	if(isset($_POST['Load_filebox_public_photo'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_files_public('photo','../../');
	}
	if(isset($_POST['Load_filebox_public_document'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_files_public('public','../../');
	}
	if(isset($_POST['Load_filebox_private'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->show_folder_private_filebox('private','../../');
	}
	
	if(isset($_POST['Move_contact_down'])){
		$card = new Card(NULL,$_POST["Username"]);
		$conta=0;
		for($i=0;$i<sizeof($card->contact_rows);$i++){
			if(($card->contact_rows[$i]['type']!="fb")&&($card->contact_rows[$i]['type']!="you")&&($card->contact_rows[$i]['type']!="tw")&&($card->contact_rows[$i]['type']!="sk")){
				$conta++;
			}	
		}
		if($card->is_user_logged()){
			if($_POST['row_num']!=$conta){
				$card->Move_contact_down($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	
	//salvataggio link social network nella sezione personal
	if(isset($_POST['Add_social_element'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if(sizeof($card->social_rows)<10){
				$card->Add_social_element($_POST["value"],$_POST["type"],$_POST["title"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
			
			
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Delete_social_element'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Delete_social_element($_POST["index"]);
			$card = new Card(NULL,$_POST["Username"]);
			echo $card->Social_show_div();
		}else{
			$card->Logout();	
		}	
	}
	
	
	if(isset($_POST['Move_social_up'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST['row_num']!=1){
				$card->Move_social_up($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Move_social_down'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST['row_num']!=sizeof($card->social_rows)){
				$card->Move_social_down($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Update_social_element'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Update_social_element($_POST["value"],$_POST["type"],$_POST["title"],$_POST["index"]);
		}else{
			$card->Logout();	
		}
	}
		
	if(isset($_POST['Refresh_social_rows'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Social_show_div();
		}else{
			$card->Logout();	
		}	
	}
	
	
	//MAIN PHOTO------------------------------------------------------------------------------------------------------
	if(isset($_GET['Change_main_photo'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$uploader = new CardUploader();
			if($_FILES["in_main_photo"]['name']==""||$_FILES["in_main_photo"]['tmp_name']==""){
				$error = "Devi selezionare un file.";
				?>
				<script language="javascript" type="text/javascript">window.parent.Upload_problem("<?php echo $error; ?>");</script>   
				<?php
				return;	
			}
			
			$upload_result = $uploader->upload_image($_FILES["in_main_photo"]['name'],$_FILES["in_main_photo"]['tmp_name'],10240000,"../../".USERS_PATH.$card->username."/user_photo_large",NULL,$error,600,210,315,"../../".USERS_PATH.$card->username."/download_area/public/photo");
			
			if( $upload_result == false ){
				?>
				<script language="javascript" type="text/javascript">window.parent.Upload_problem("<?php echo $error; ?>");</script>
				<?php
			}else{
				$image = new SimpleImage();
				$image->load("../../".USERS_PATH.$_POST["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_main_photo"]['name']);
				$height =  $image->getHeight();
				
				?>
				<script language="javascript" type="text/javascript">window.parent.Upload_success("<?php echo "../../".USERS_PATH.$_POST["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_main_photo"]['name']; ?>",<? echo $height; ?>);</script>   
				<?php
			}
		}else{
			$card->Logout();	
		}		
		
	}
	if (isset($_POST["Crop_main_photo"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			//prelevo le variabili dal crop
			$photo = isset($_POST['image_path']) ? $_POST['image_path'] : false; 
			$top = isset($_POST["x1"]) ? $_POST["x1"] : false;
			$left = isset($_POST["y1"]) ? $_POST["y1"] : false;
			$width = isset($_POST["w"]) ? $_POST["w"] : false;
			$height = isset($_POST["h"]) ? $_POST["h"] : false;
			$max_width = 215;
			$max_height = 315;
			$quality = 90;
			$thumbs_path="../../".USERS_PATH.$card->username."/user_photo_temp/";
			
			$thumb = $card->Crop_photo($photo,$top,$left,$width,$height,$max_width,$max_height,$quality,$thumbs_path);
			$target_file = $thumbs_path.$thumb;
			
			//elimino la vecchia main photo / delete the old main photo
			if((strpos($card->photo1_path,"../../image/default_photo/main.png")===FALSE) &&($card->photo1_path!=$thumb)){
				@unlink("../../".USERS_PATH.$card->username."/".USER_PHOTO_MAIN_PATH.$card->photo1_path);
				@unlink("../../".USERS_PATH.$card->username."/".DOWNLOAD_AREA_PHOTO.$card->photo1_path);
				@unlink('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/'.$card->photo1_path);
				@unlink('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_'.$card->photo1_path);
				$ctrl=0;
				$name = $card->photo1_path;
				for($i=0;$i<(count($card->user_photo_slide_big_path));$i++){
					if($name==$card->user_photo_slide_big_path[$i]&&($i!=$index)){
						$ctrl=1;
					}
				}
				if($name==$card->photo1_path){
					$ctrl=1;
				}
				if($ctrl==0){
					//@unlink("../../".$card->username."/".DOWNLOAD_AREA_PHOTO.$name);
					@unlink("../../".USERS_PATH.$card->username."/download_area/public/photo/".$name);
				}
			}
			//copio la foto temp nella cartella user_photo / copy temp photo in the folder user_photo
			copy($target_file,"../../".USERS_PATH.$card->username."/".USER_PHOTO_MAIN_PATH.$thumb);
			
			if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/')){
				mkdir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/');	
			}
			copy($target_file,'../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_'.$thumb);
			
			$card->Update_main_photo($thumb);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	if (isset($_POST["Annulla_crop"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$name = trim(substr($_POST["image_path"],(strrpos($_POST["image_path"],"/")+1)));
			
			$ctrl=0;
			for($i=0;$i<(count($card->user_photo_slide_big_path));$i++){
				if($name==$card->user_photo_slide_big_path[$i]&&($i!=$index)){
					$ctrl=1;
				}
			}
			if($name==$card->photo1_path){
				$ctrl=1;	
			}
			
			if($ctrl==0){
				@unlink("../../".USERS_PATH.$card->username."/download_area/public/photo/".$name);
				@unlink("../../".USERS_PATH.$card->username."/filebox/photo/FOTO_PROFILO/".$name);
				@unlink("../../".USERS_PATH.$card->username."/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_".$name);
				
			}
		}else{
			$card->Logout();	
		}
		
		exit();
	}	
	if (isset($_POST["Save_main_photo"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$photo_name = substr($_POST["photo_path"],(strrpos($_POST["photo_path"],"/thumb_")+7));
			$card->Update_main_photo($_POST["photo_path"],$photo_name);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	
	if(isset($_POST["Delete_photo_large"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->del_file_in_dir("../../".USERS_PATH.$_POST["Username"]."/user_photo_large/");
		}else{
			$card->Logout();	
		}	
	}
	//----------------------------------------------------------------------------------------------------------------
	

	
	
	
	//SLIDE-SHOW----------------------------------------------------------------------------------------------------
	if(isset($_POST["Load_photo_slide"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_slide_photo("../../".USERS_PATH.$card->username."/user_photo/",$_POST["index"]);
             
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['change_foto'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Personal_upload_slide_photo($_POST["index"]);
		}else{
			$card->Logout();	
		}
		
	}
	
	if(isset($_POST['Add_foto'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Personal_upload_slide_photo($_POST["index"],1);
		}else{
			$card->Logout();	
		}
		
	}	
	
	if(isset($_GET['Change_slide_photo'])){
		$card = new Card(NULL,$_GET["Username"]);
		if($card->is_user_logged()){
			$uploader = new CardUploader();
			if($_FILES["in_slide_photo_".$_GET['index']]['name']==""||$_FILES["in_slide_photo_".$_GET['index']]['tmp_name']==""){
				$error = "Devi selezionare un file.";
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_problem("<?php echo $error; ?>","<?php echo $_GET['index']; ?>");</script>   
				<?php
				return;	
			}
			
			$upload_result = $uploader->upload_image($_FILES["in_slide_photo_".$_GET['index']]['name'],$_FILES["in_slide_photo_".$_GET['index']]['tmp_name'],10240000,"../../".USERS_PATH.$card->username."/user_photo_large",NULL,$error,600,350,250,"../../".USERS_PATH.$card->username."/download_area/public/photo");
			
			if( $upload_result == false ){
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_problem("<?php echo $error; ?>","<?php echo $_GET['index']; ?>");</script>   
				<?php
			}else{
				$image = new SimpleImage();
				$image->load("../../".USERS_PATH.$_GET["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_slide_photo_".$_GET['index']]['name']);
				$height =  $image->getHeight();
				
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_success("<?php echo "../../".USERS_PATH.$_POST["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_slide_photo_".$_GET['index']]['name']; ?>",<?php echo $height; ?>,"<?php echo $_GET['index'] ?>");</script>   
				<?php
			}
		}else{
			$card->Logout();	
		}		
		
	}
	if (isset($_POST["Crop_slide_photo"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			//prelevo le variabili dal crop
			$photo = isset($_POST['image_path']) ? $_POST['image_path'] : false; 
			$top = isset($_POST["x1"]) ? $_POST["x1"] : false;
			$left = isset($_POST["y1"]) ? $_POST["y1"] : false;
			$width = isset($_POST["w"]) ? $_POST["w"] : false;
			$height = isset($_POST["h"]) ? $_POST["h"] : false;
			$index = isset($_POST["index"]) ? $_POST["index"] : false;
			$index = trim($index);
			$max_width = 350;
			$max_height = 250;
			$quality = 90;
			$thumbs_path="../../".USERS_PATH.$card->username."/user_photo_temp/";
			
			$thumb = $card->Crop_photo($photo,$top,$left,$width,$height,$max_width,$max_height,$quality,$thumbs_path);
			
			$target_file = $thumbs_path.$thumb;
			if($index<count($card->user_photo_slide_path)){
				//elimino la vecchia slide photo / delete the old slide photo
				
				if(strpos($card->user_photo_slide_path[$index],"../../image/default_photo/")===FALSE){
					@unlink("../../".USERS_PATH.$card->username."/".USER_PHOTO_PATH.$card->user_photo_slide_path[$index]);
					@unlink("../../".USERS_PATH.$card->username."/".DOWNLOAD_AREA_PHOTO.$card->user_photo_slide_path[$index]);
					@unlink("../../".USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/'.$card->user_photo_slide_path[$index]);
					@unlink("../../".USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_'.$card->user_photo_slide_path[$index]);
					
					$name = trim(substr($card->user_photo_slide_path[$index],4));
					
					$ctrl=0;
					for($i=0;$i<(count($card->user_photo_slide_big_path));$i++){
						if($name==$card->user_photo_slide_big_path[$i]&&($i!=$index)){
							$ctrl=1;
						}
					}
					
					if($name==$card->photo1_path){
						$ctrl=1;
					}
					if($ctrl==0){
						@unlink("../../".USERS_PATH.$card->username."/download_area/public/photo/".$name);
					}
				}
			}
			
			$photo_big_name=$thumb;
			
			if(!is_dir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/')){
				mkdir('../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/');	
			}
			
			copy($target_file,'../../'.USERS_PATH.$card->username.'/filebox/photo/FOTO_PROFILO/big_thumb/big_thumb_'.$photo_big_name);
			
			
			
			$thumb = "sp".trim($index)."_".trim($thumb);
			copy($target_file,"../../".USERS_PATH.$card->username."/".USER_PHOTO_PATH.$thumb);
			
			
			
			
			
			$card->Update_slide_photo($thumb,$photo_big_name,$index);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	
	if (isset($_POST["Save_slide_photo"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$thumb_photo_name = substr( $_POST["photo_path"],(strrpos($_POST["photo_path"],"/thumb_")+7));
			$card->Update_slide_photo($_POST["photo_path"],$thumb_photo_name,$_POST["index"]);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	
	if (isset($_POST["Save_new_slide_photo"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			$thumb_photo_name =  substr( $_POST["photo_path"],(strrpos($_POST["photo_path"],"/thumb_")+7));
			$card->Add_slide_photo($_POST["photo_path"],$thumb_photo_name,$_POST["index"]);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	
	if (isset($_POST["Delete_photo_slide"])) {
		//Get the new coordinates to crop the image.
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->delete_slide_photo($_POST["index"]);
		}else{
			$card->Logout();	
		}
		
		exit();
	}
	
	if(isset($_POST["add_photo_slide"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
            echo $card->Personal_upload_slide_photo($_POST["index"],1); 
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_GET['New_slide_photo'])){
		$card = new Card(NULL,$_GET["Username"]);
		if($card->is_user_logged()){
			$uploader = new CardUploader();
			if($_FILES["in_slide_photo_".$_GET['index']]['name']==""||$_FILES["in_slide_photo_".$_GET['index']]['tmp_name']==""){
				$error = "Devi selezionare un file.";
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_problem("<?php echo $error; ?>","<?php echo $_GET['index']; ?>");</script>
				<?php
				return;	
			}
			
			
			$upload_result = $uploader->upload_image($_FILES["in_slide_photo_".$_GET['index']]['name'],$_FILES["in_slide_photo_".$_GET['index']]['tmp_name'],10240000,"../../".USERS_PATH.$card->username."/user_photo_large",NULL,$error,600,350,250,"../../".USERS_PATH.$card->username."/download_area/public/photo");
			
			if( $upload_result == false ){
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_problem("<?php echo $error; ?>","<?php echo $_GET['index']; ?>");</script>   
				<?php
			}else{
				$image = new SimpleImage();
				$image->load("../../".USERS_PATH.$_GET["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_slide_photo_".$_GET['index']]['name']);
				$height =  $image->getHeight();
				
				?>
				<script language="javascript" type="text/javascript">window.top.window.Upload_success("<?php echo "../../".USERS_PATH.$_POST["Username"]."/".USER_LARGE_PHOTO_PATH.$_FILES["in_slide_photo_".$_GET['index']]['name']; ?>",<?php echo $height; ?>,"<?php echo $_GET['index'] ?>");</script>   
				<?php
			}
		}else{
			$card->Logout();	
		}		
		
	}
	//------------------------------------------------------------------------------------------------------------
	
	
	if(isset($_POST['Bv_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$bv_cellulare = $_POST['bv_cellulare'];
			
			$bv_email = $_POST['bv_email'];
			$bv_professione = $_POST['bv_professione'];
			$bv_check_cellulare = $_POST['bv_check_cellulare'];
			$bv_check_email = $_POST['bv_check_email'];
			$bv_check_tmg_email = $_POST['bv_check_tmg_email'];
			
			$bv_check_professione = $_POST['bv_check_professione'];
			$personal_in_bv_web = $_POST['personal_in_bv_web'];
			if($_POST['bv_check_professione']=='true')
				if($bv_professione==""){
					$bv_professione= $card->Professione;
				}
			$card->Update_bv($bv_check_cellulare,$bv_check_email,$bv_check_tmg_email,$bv_check_professione,$bv_cellulare,$bv_email,$bv_professione,$personal_in_bv_web);
			$card->Generate_bv();
			$json_string = json_encode(array("professione"=>$bv_professione)); 
			
			// risultato 
			echo $json_string; 
		}else{
			$card->Logout();	
		}	
		
	}
	//---------------------------------------------------------------------------------------------------------
	
	
	
	
	//CURRICULUM EUROPEO---------------------------------------------------------------------------------------
	if(isset($_POST['Step1_curriculum_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			$card->Update_europ_cv_step1($_POST["nomecognome"],$_POST["sesso"],$_POST["cittadinanza"],$_POST["dataluogo"],$_POST["telefono"],$_POST["email"],$_POST["indirizzo"]);
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Step0_crea_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			$card->Update_crea_step0($_POST["sudime"]);
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Step1_crea_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			$card->Update_crea_step1($_POST["nomecognome"],$_POST["sesso"],$_POST["cittadinanza"],$_POST["dataluogo"],$_POST["telefono"],$_POST["email"],$_POST["indirizzo"]);
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Step2_curriculum_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			
			$card->Update_europ_cv_step2($_POST["istruzformaz"],$_POST["esplavorativa"]);
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Step3_curriculum_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Update_europ_cv_step3($_POST["linguestraniere"],$_POST["madrelingua"],$_POST["capacitacompet"],$_POST["compinformatiche"],$_POST["comprelsoc"],$_POST["comporganiz"]);
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Step4_curriculum_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Update_europ_cv_step4($_POST["compartistiche"],$_POST["comptecniche"],$_POST["comprelativeallav"],$_POST["altrecompedinteressi"]);
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Step5_curriculum_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Update_europ_cv_step5($_POST["patente"],$_POST["ulteriori"]);
		}else{
			$card->Logout();	
		}	
	}
	
	//--------------------------------------------------------------------------------------------------------
	
	//IMPOSTAZIONI--------------------------------------------------------------------------------------------
	if(isset($_POST['Personal_password_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($card->Update_impostazioni_password($_POST["old_pass"],$_POST["new_pass"])){
				$json_string = json_encode(array("result"=>"true","email"=>$card->Get_member_email())); 
				echo $json_string;
				$card->Logout();
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;
			}
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Set_account_deleted_now'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Set_account_deleted_now();
			$card = new Card(NULL,$_POST["Username"]);
			$card->Show_mod_delete();
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Set_account_deleted'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Set_account_deleted();
			$card = new Card(NULL,$_POST["Username"]);
			$card->Show_mod_delete();
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Unset_account_deleted'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Unset_account_deleted();
			$card = new Card(NULL,$_POST["Username"]);
			$card->Show_mod_delete();
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['impostazioni_curr_save'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Update_impostazioni_curr($_POST["change_opt_curr"]);
		}else{
			$card->Logout();	
		}	
	}
	//--------------------------------------------------------------------------------------------------------
	if(isset($_POST['Change_card_colour'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Change_card_colour($_POST["colore_card"]);
		}else{
			$card->Logout();	
		}	
	}
	
	//FILE BOX------------------------------------------------------------------------------------------------
	if(isset($_POST['Show_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$path=rtrim($_POST['parent'],"/");
			
			echo $card->Show_files($_POST['path']);
		}else{
			$card->Logout();	
		}	
	}/*
	if(isset($_POST['Show_file_private'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$folder=rtrim($_POST['folder'],"/");
			echo $card->Show_folders_private($folder);
		}else{
			$card->Logout();	
		}	
	}*/
	if(isset($_POST['Show_public_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		$folder=rtrim($_POST['folder_name'],"/");
		echo "<p class='text14px'>File contenuti nella cartella public/".$folder."</p>";
		$card->Show_files_public('public/'.$folder,'../../');
			
	}
	
	if(isset($_POST['Show_photo_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		$folder=rtrim($_POST['folder_name'],"/");
		$card->Show_photogallery('photo/'.$folder,'../../');
			
	}
	
	if(isset($_POST['Delete_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$folder=rtrim($_POST['folder'],"/");
			$name=rtrim($_POST['name'],"/");
			$path = $folder."/".$name;
			if(is_file("../../".USERS_PATH.$card->username."/filebox/".$path)){
				@unlink("../../".USERS_PATH.$card->username."/filebox/".$path);
			}
			if(is_file("../../".USERS_PATH.$card->username."/filebox/".$folder."/thumb/thumb_".$name)){
				@unlink("../../".USERS_PATH.$card->username."/filebox/".$folder."/thumb/thumb_".$name);
			}
			if(is_file("../../".USERS_PATH.$card->username."/filebox/".$folder."/big_thumb/big_thumb_".$name)){
				@unlink("../../".USERS_PATH.$card->username."/filebox/".$folder."/big_thumb/big_thumb_".$name);
			}
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Delete_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->delete_folder($_POST['folder'],$_POST['name']);
			$card->show_filebox_subfolder($_POST['folder']); 
		}else{
			$card->Logout();	
		}	
	}
	
	
	if(isset($_POST['Rename_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$path="../../".USERS_PATH.$card->username."/filebox/".$_POST['folder']."/".$_POST['new_name'];
			if(!is_dir($path)){
				$card->Rename_folder($_POST['folder'],$_POST['name'],$_POST['new_name']);
				$json_string = json_encode(array("result"=>'0'));
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>'1'));
				echo $json_string;
			}
		}else{
			$card->Logout();	
		}	
	}

	if(isset($_POST['Create_private_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$result = $card->Create_private_folder($_POST['folder_name'],$_POST['folder_pass']);
			$json_string = json_encode(array("result"=>$result)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Refresh_subfolder"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->show_filebox_subfolder($_POST['folder']); 
		}else{
			$card->Logout();	
		}
		
	}
	
	if(isset($_POST['Create_public_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$result = $card->Create_public_folder($_POST['folder_name']);
			$json_string = json_encode(array("result"=>$result)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Create_photo_folder'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$result = $card->Create_photo_folder($_POST['folder_name']);
			$json_string = json_encode(array("result"=>$result)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Change_folder_password'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$folder_name = substr($_POST['folder_name'],strpos($_POST['folder_name'],"/")+1);
			$card->Change_folder_password($folder_name,$_POST['folder_pass']);
			$json_string = json_encode(array("password"=>$_POST['folder_pass'])); 
			echo $json_string;
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST["Load_create_public_folder"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->load_create_public_folder();
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST["Load_create_photo_folder"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Load_create_photo_folder();
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST["load_create_private_folder"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->load_create_private_folder();
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST['Load_accedi'])){
		$card = new Card(NULL,$_POST["Username"]);
		$folder = $_POST['folder'];
		echo "<div id='password'>
                 <p class='text14px'>Inserisci la password per accedere alla cartella ".$folder."</p>
				 <div style='width:100%; height:200px;'>
                    <img src='../image/filebox/icona_password.png' style='width:25px; height:25px; vertical-align:middle;'/><input type='password' id='private_folder_pass' class='input_text_normal' style='color:#FFF' onkeydown='invio_filebox(event,\"".$folder."\");' />
					
					<div class='overlay_button'>
						<a target='_self' class='text14px'  style='text-decoration:none;' onclick='Javascript:accedi(\"".$folder."\");'>Accedi</a>
					</div>
					<img src='../image/icone/ajax-loader.gif' id='file_box_accedi_loading' class='file_box_loading'>
				</div>
		   </div>
		   ";
		echo "";
	}
	
	if(isset($_POST['Accedi'])){
		$card = new Card(NULL,$_POST["Username"]);
		$pass= $_POST['folder_pass'];
		$folder = $_POST['folder'];
		if($pass==$card->folders[$folder]['folder_pass']){
			$_SESSION['private_folder'] = md5($folder.$pass.session_id());
			echo "<p class='text14px'>File contenuti nella cartella private/".$folder."</p>";
			echo $card->Show_files_private_area($folder);
		}else{
			echo "<div id='password'>
			   		<p class='class='text14px'><img src='../image/icone/error.png' alt='errore' /> Ricontrolla la password inserita!</p>
			   		<p class='text14px'>Inserisci la password per accedere alla cartella ".$folder."</p>
			  			<div style='width:100%; height:200px;'>
                    		<img src='../image/filebox/icona_password.png' style='width:25px; height:25px; vertical-align:middle;'/><input type='password' id='private_folder_pass' class='input_text_normal' style='color:#FFF' onkeydown='invio_filebox(event,\"".$folder."\");'/>
					
							<div class='overlay_button'>
								<a target='_self' class='text14px'  style='text-decoration:none;' onclick='Javascript:accedi(\"".$folder."\");'>Accedi</a>
							</div>
							<img src='../image/icone/ajax-loader.gif' id='file_box_accedi_loading' class='file_box_loading'>
						</div>
				</div>";	
		}
	}
	

	
//--------------------------------------------------------------------------------------------------------
//------------EVIDENZA----------------------------------------------------------------------------------
	
	if(isset($_POST['Save_new_news_first_step'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$id_row = $_POST["id_row"];
			$title = $_POST["title"];
			$subtitle = $_POST["subtitle"];
			if(strlen($title)>60){
				$title = substr($title,0,60);	
			}
			$desc = $_POST["desc"];
			$file = $_POST["file"];
			$card->Evidenza_save_row($id_row,$title,$subtitle,$desc,$file);
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST['Save_new_news_second_step'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$data = $_POST['data'];
			$id_row = $_POST["id_row"];
			$sendto = $_POST['sendto'];
			$check_alt = $_POST["check_alt"];
			
			/* 
			questo controllava se una mail era già stata pubblicata nella stessa data, con l'agenda news è obsoleto
			for($i=0;$i<count($card->news_rows);$i++){
				if($card->news_rows[$i]["id"]!=$id_row && $card->news_rows[$i]["data"]==$data){
				  	$json_string ="";
					$json_string = json_encode(array("result"=>1)); 
					echo $json_string;
					return;
				}
			}*/
			
			$card->Evidenza_save_data($id_row,$data,$sendto,$check_alt);
			$card = new Card(NULL,$_POST["Username"]);
			$card->pubblica_news($id_row);
			$json_string = json_encode(array("result"=>0)); 
			echo $json_string;
			return;
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Save_new_news_third_step'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$sendto = $_POST['sendto'];
			$id_row = $_POST["id_row"];
			$check_alt = $_POST["check_alt"];
			$card->Evidenza_save_sendto($id_row,$sendto,$check_alt);
			$card = new Card(NULL,$_POST["Username"]);
			$card->pubblica_news($id_row);
		}else{
			$card->Logout();	
		}	
	}
	if(isset($_POST['Load_evidenza_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_file_in_evidenza($_POST["new_news_id"]);
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST['Load_evidenza_mod_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_file_in_evidenza($_POST["showed_news_id"],1);
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST['Load_evidenza_mod_now_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_file_in_evidenza($_POST["id_news"],2);
		}else{
			$card->Logout();	
		}
	}
	
	
	if(isset($_POST['Move_rows_up'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST['row_num']!=0){
				$card->Move_rows_up($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST['Move_rows_down'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST['row_num']!=$card->user_news_rows_count){
				$card->Move_rows_down($_POST["index"],$_POST["row_num"]);
				$json_string = json_encode(array("result"=>"true")); 
				echo $json_string;
			}else{
				$json_string = json_encode(array("result"=>"false")); 
				echo $json_string;	
			}
		}else{
			$card->Logout();	
		}	
	}
	
	
	if(isset($_POST['Load_mailing_list_groups'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_news_mod_mailing_list_groups();
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST['Load_mod_mailing_list_groups'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_news_mod_mailing_list_groups(1);
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST['Load_mod_saved_mailing_list_groups'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Load_mod_saved_mailing_list_groups($_POST["news_id"]);
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST['Evidenza_delete_post_pubblica'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Evidenza_delete_post_pubblica();
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST['Get_evidenza_desc'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_file_in_evidenza($_POST["news_id"]);	
	}
	if(isset($_POST['Get_evidenza_mod_desc'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_file_in_evidenza($_POST["news_id"],1);	
	}
	if(isset($_POST['Get_evidenza_mod_now_desc'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->Show_file_in_evidenza($_POST["news_id"],2);	
	}
	if(isset($_POST['Delete_evidenza_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->empty_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$_POST["news_id"]."/");
		$card->Show_file_in_evidenza($_POST["news_id"]);
	}
	if(isset($_POST['Delete_evidenza_mod_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->empty_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$_POST["news_id"]."/");
		$card->Show_file_in_evidenza($_POST["news_id"],1);
	}
	if(isset($_POST['Delete_evidenza_mod_now_file'])){
		$card = new Card(NULL,$_POST["Username"]);
		$card->empty_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$_POST["news_id"]."/");
		$card->Show_file_in_evidenza($_POST["news_id"],2);
	}
	if(isset($_POST['Evidenza_delete_all'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Evidenza_delete_all();
			$card->del_file_in_dir("../../".USERS_PATH.$card->username."/download_area/evidenza/");
			$card->Show_file_in_evidenza();
		}else{
			$card->Logout();	
		}
	}
		
	if(isset($_POST['Create_new_news'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$new_news_id = $card->Create_new_news();
			$json_string = json_encode(array("result"=>true,"new_news_id"=>$new_news_id)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}	
	}
	
	if(isset($_POST["Show_news"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$index = $_POST["news_index"];
			$news_id = $card->news_rows[$index]["id"];
			$in_mod_evidenza = $card->news_rows[$index]["titolo"];
			$in_mod_evidenza_subtitle = $card->news_rows[$index]["sottotitolo"];
			$in_mod_evidenza_desc = Eliminabr($card->news_rows[$index]["descrizione"]);
			$json_string = json_encode(array("result"=>true,"showed_news_id"=>$news_id,"in_mod_evidenza"=>$in_mod_evidenza,"in_mod_evidenza_subtitle"=>$in_mod_evidenza_subtitle,"in_mod_evidenza_desc"=>$in_mod_evidenza_desc)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST["Show_news_now"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$news_id = $card->evidenza["id_news"];
			$in_mod_evidenza = $card->evidenza["title"];
			$in_mod_evidenza_subtitle = $card->evidenza["subtitle"];
			$in_mod_evidenza_desc = Eliminabr($card->evidenza["description"]);
			$json_string = json_encode(array("result"=>true,"id_news"=>$news_id,"in_mod_evidenza_now"=>$in_mod_evidenza,"in_mod_evidenza_now_subtitle"=>$in_mod_evidenza_subtitle,"in_mod_evidenza_desc_now"=>$in_mod_evidenza_desc)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	function Eliminabr($string){
		return str_replace("<br/>","\n",$string);
	}
	
	if(isset($_POST["Show_news_second_step"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$news_id = $_POST["news_id"];
			//qui devo trovare l'id
			for($i=0;$i<count($card->news_rows);$i++){
				if($card->news_rows[$i]["id"]==$news_id)
					$index=$i;
			}
			$data =  $card->news_rows[$index]["data"];
			$json_string = json_encode(array("result"=>true,"data"=>$data)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
		if(isset($_POST["Show_news_third_step"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$news_id = $_POST["news_id"];
			
			for($i=0;$i<count($card->news_rows);$i++){
				if($card->news_rows[$i]["id"]==$news_id)
					$index=$i;
			}
			$sendto =  $card->news_rows[$index]["sendto"];
			$json_string = json_encode(array("result"=>true,"sendto"=>$sendto)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST["Refresh_riepilogo_news"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Delete_not_completed_news();
			$card->Refresh_riepilogo_news();
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Refresh_riepilogo_news_now"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Refresh_riepilogo_news_now();
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST['Delete_news'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$index= $_POST['index'];
			for($i=0;$i<$_POST['num_index'];$i++){
				$index_delete= substr($index,0,1);
				$card->Delete_single_news($index_delete);
				$card->delete_news_folder($card->news_rows[$index_delete]["id"]);
				
				$index = substr($index,strpos($index,",")+1);
			}
		}else{
			$card->Logout();
		}
	}
	
		
	if(isset($_POST['Delete_single_news'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$index= $_POST['index'];
			$card->Delete_single_news($index);
			$card->delete_news_folder($card->news_rows[$index]["id"]);
		}else{
			$card->Logout();
		}
	}
	
	
	//sezione newsletter

	if(isset($_POST['Add_newsletter_group'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
				$nome = $_POST['nome'];
				$card->Add_newsletter_group($nome);
				$json_string = json_encode(array("result"=>"true")); 
			echo $json_string;
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Refresh_newsletter_rows'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){ 
			$id_group = $_POST["index"];
			$html="";
			for($i=0;$i<$card->user_newsletter_rows_count;$i++){
				if($card->newsletter_rows[$i]["type"]=="email"){
					if($card->newsletter_rows[$i]["id_group"]==$id_group){
						$html.= "<option value='".$card->newsletter_rows[$i]["id"]."'>".$card->newsletter_rows[$i]["nome"]." ".$card->newsletter_rows[$i]["cognome"]." - ".$card->newsletter_rows[$i]["row_value"]."</option>"; 
					}
				}
			}
			$json_string = json_encode(array("html"=>$html)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Refresh_newsletter_group'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$html="";
			for($i=0;$i<sizeof($card->newsletter_group);$i++){
					$html.= "<option value='".$card->newsletter_group[$i]["id"]."'>".$card->newsletter_group[$i]["nome"]."</option>"; 		
			}
			$json_string = json_encode(array("html"=>$html)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}		
	}
	if(isset($_POST['Show_mailing_group'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_contacts($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Show_mailing_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_contact_row($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Prepare_send_groups_email'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Prepare_send_groups_email($_POST["id_group"]);
		}else{
			$card->Logout();	
		}		
	}
	
	
	if(isset($_POST['Mod_mailing_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Mod_mailing_contact_row($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Add_mailing_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Add_mailing_contact_row($_POST["index"],$_POST["id_group"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Get_newsletter_num'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Get_newsletter_num();
		}else{
			$card->Logout();	
		}
	}
	
	if(isset($_POST['Update_mailing_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
		
			$card->Update_mailing_contact_row($_POST["index"],$_POST["name"],$_POST["middle_name"],$_POST["addon"],$_POST["surname"],$_POST["nickname"],$_POST["tel_home1"],$_POST["tel_home2"],$_POST["tel_work1"],$_POST["tel_work2"],$_POST["cell"],$_POST["tel_work_fax"],$_POST["tel_home_fax"],$_POST["tel_pager"],$_POST["tel_additional"],$_POST["tel_car"],$_POST["home_city"],$_POST["home_region"],$_POST["home_country"],$_POST["home_zip"],$_POST["home_street"],$_POST["url_home"],$_POST["organisation"],$_POST["title"],$_POST["departement"],$_POST["company"],$_POST["work_city"],$_POST["work_region"],$_POST["work_country"],$_POST["work_zip"],$_POST["work_street"],$_POST["url_work"],$_POST["note"]);
			
			$emails = str_replace("\\","",$_POST["emails"]);
			$emails=json_decode($emails);
			$card->Delete_all_mailing_emails($_POST["index"]);
			$i=0;
			foreach($emails as $email){
				if($email!=NULL&&$email!="null"&&$email!=""){
					if($i==0)
						$card->Store_vcard_emails($email,$_POST["index"],1);
					else
						$card->Store_vcard_emails($email,$_POST["index"],0);
					$i++;
				}
			}
			
			$urls = str_replace("\\","",$_POST["urls"]);
			$urls=json_decode($urls);
			$card->Delete_all_mailing_urls($_POST["index"]);
			$i=0;
			foreach($urls as $url){
				if($url!=NULL&&$url!="null"&&$url!=""){
					if($i==0)
						$card->Store_vcard_urls($url,$_POST["index"],1);
					else
						$card->Store_vcard_urls($url,$_POST["index"],0);
					$i++;
				}
			}
			$card = new Card(NULL,$_POST["Username"]);
			$card->Show_mailing_contact_row($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Add_new_mailing_contact_row'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
		
			$new_index = $card->Add_new_mailing_contact_row($_POST["id_group"],$_POST["name"],$_POST["middle_name"],$_POST["addon"],$_POST["surname"],$_POST["nickname"],$_POST["tel_home1"],$_POST["tel_home2"],$_POST["tel_work1"],$_POST["tel_work2"],$_POST["cell"],$_POST["tel_work_fax"],$_POST["tel_home_fax"],$_POST["tel_pager"],$_POST["tel_additional"],$_POST["tel_car"],$_POST["home_city"],$_POST["home_region"],$_POST["home_country"],$_POST["home_zip"],$_POST["home_street"],$_POST["url_home"],$_POST["organisation"],$_POST["title"],$_POST["departement"],$_POST["company"],$_POST["work_city"],$_POST["work_region"],$_POST["work_country"],$_POST["work_zip"],$_POST["work_street"],$_POST["url_work"],$_POST["note"]);
			echo "new index: ".$new_index." id group: ".$_POST["id_group"];
			$emails = str_replace("\\","",$_POST["emails"]);
			$emails=json_decode($emails);
			$i=0;
			foreach($emails as $email){
				if($email!=NULL&&$email!="null"&&$email!=""){
					if($i==0)
						$card->Store_new_vcard_emails($email,$new_index,$_POST["id_group"],1);
					else
						$card->Store_new_vcard_emails($email,$new_index,$_POST["id_group"],0);
					$i++;
				}
			}
			
			$urls = str_replace("\\","",$_POST["urls"]);
			$urls=json_decode($urls);
			$i=0;
			foreach($urls as $url){
				if($url!=NULL&&$url!="null"&&$url!=""){
					if($i==0)
						$card->Store_new_vcard_urls($url,$new_index,$_POST["id_group"],1);
					else
						$card->Store_new_vcard_urls($url,$new_index,$_POST["id_group"],0);
					$i++;
				}
			}
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Show_mailing_groups'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_groups($_POST["selected"]);
		}else{
			$card->Logout();	
		}		
	}
	if(isset($_POST['Show_group_actions'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_groups_action($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Show_contacts_actions'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_contacts_action($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	if(isset($_POST['Show_contact_save_actions'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_contact_save_action($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	if(isset($_POST['Show_contact_actions'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_contact_action($_POST["index"]);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Show_new_contact_save_actions'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_mailing_new_contact_save_actions($_POST["index"]);
		}else{
			$card->Logout();
		}		
	}
	
	if(isset($_POST["Show_send_group_actions"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_send_group_actions();
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST["Send_groups_email"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$subject = str_replace("\n","<br/>",htmlentities($_POST["subject"], ENT_QUOTES,"UTF-8"));
			$body = str_replace("\n","<br/>",htmlentities($_POST["body"], ENT_QUOTES,"UTF-8"));
			$to = str_replace("\\","",$_POST["to"]);
			$emails=json_decode($to);
			/*$i=0;
			foreach($emails as $email){
				if($email!=NULL&&$email!="null"&&$email!=""){
					echo "Inviato email ".$i.":".$email."<br/>";
					$i++;
				}
			}*/
			$card->Send_mailing_group_email($body,$emails,$subject);
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Delete_selected_rows'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){ 
			$selected_index = str_replace("\\","",$_POST["selected_index"]);
			$selected_index=json_decode($selected_index);
			foreach($selected_index as $index){
				$card->Delete_newsletter_row($card->newsletter_rows[$index]["idusernewsletter"]);
			}
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Delete_mailing_contact'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){ 
			$index= $_POST["index"];
				$card->Delete_newsletter_row($card->newsletter_rows[$index]["idusernewsletter"]);
		}else{
			$card->Logout();	
		}		
	}
	if(isset($_POST['Move_selected_rows'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){ 
			$selected_index = str_replace("\\","",$_POST["selected_index"]);
			$selected_index=json_decode($selected_index);
			$id_group=$_POST["id_group"];
			foreach($selected_index as $index){
				$card->Move_newsletter_row($card->newsletter_rows[$index]["idusernewsletter"],$card->newsletter_group[$id_group]["id"]);
			}
		}else{
			$card->Logout();	
		}		
	}
	
	if(isset($_POST['Load_newsletter_group'])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$id_group = $_POST["index"];
			$html="";
			for($i=0;$i<$card->user_newsletter_rows_count;$i++){
				if($card->newsletter_rows[$i]["id_group"]==$id_group){
					$html.= "<option value='".$card->newsletter_rows[$i]["id"]."'>".$card->newsletter_rows[$i]["nome"]." ".$card->newsletter_rows[$i]["cognome"]." - ".$card->newsletter_rows[$i]["row_value"]."</option>";
				}
			}
			for($i=0;$i<count($card->newsletter_group);$i++)
				if($card->newsletter_group[$i]["id"]==$id_group)
					if($card->newsletter_group[$i]["active"]==1){
						$group_active="<input type='checkbox' id='group_active_opt' checked='checked' onchange='Javascript:Change_group_active()'/><span id='group_active_text' style='color:#0F0;'>Questo gruppo<br/> riceve le news</span>";	
					}else{
						$group_active="<input type='checkbox'  id='group_active_opt' onchange='Javascript:Change_group_active()'/><span id='group_active_text' style='color:#F00;'>Questo gruppo<br/> non riceve le news</span>";	
					}
				
			$json_string = json_encode(array("html"=>$html,"group_active"=>$group_active)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Delete_newsletter_group"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$id_group = $_POST["index"];
			$card->Delete_newsletter_group($id_group);
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Rename_newsletter_group"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$name = $_POST["name"];
			$group_id = $_POST["index"];
			$card->Rename_newsletter_group($name,$group_id);
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Change_group_active"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$check = $_POST["check"];
			$group_id = $_POST["group_id"];
			$card->Change_group_active($check,$group_id);
			$json_string = json_encode(array("result"=>$check)); 
			echo $json_string;
		}else{
			$card->Logout();	
		}
	}
	if(isset($_POST["Refresh_move_contact_list"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Refresh_move_contact_list();
		}else{
			$card->Logout();	
		}
	}
	
//-------------------------------------------------------------------------------------------

//-------RECUPERO PASSWORD-------------------------------------------------------------------

if(isset($_POST['Recupero_pass'])){
	$card = new Card(NULL,$_POST["Username"]);
	echo $card->Show_recupero_password_on_card();
}
if(isset($_POST['Invia_recupero'])){
	$card = new Card(NULL,$_POST["Username"]);
	echo $card->Recupero_password();	
}
if(isset($_POST['Torna_login'])){
	$card = new Card(NULL,$_POST["Username"]);
	echo $card->Show_personal_login_on_card();
}

if(isset($_POST['Recupero_pass_error'])){
	$login = new Login();
	echo $login->Show_recupero_password();
}
if(isset($_POST['Invia_recupero_error'])){
	$login = new Login();
	echo $login->Recupero_password($_POST["email"]);	
}
if(isset($_POST['Torna_login_error'])){
	$login = new Login();
	echo $login->Show_login();
}
		

//---------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------

if(isset($_POST['Get_lista_subuser'])){
	$card = new Card(NULL,$_POST["Username"]);
	if($card->is_user_logged()){
		$utenti =  $card->Get_lista_subuser();
		$i=0;
		while($utenti[$i]!=NULL){
			echo "<li><a target='_self' onclick='Javascript:open_card(\"".$utenti[$i]['username']."\")'>".$utenti[$i]['username']."</a> - Iscritto in data ".$utenti[$i]['data']." </li>";
			$i++;
		}
	}else{
		$card->Logout();	
	}	
}
//--------------------------------------------------------------------------------------
//PERSONAL CARD-------------------------------------------------------------------------
if(isset($_POST['personal_card_save_professione'])){
	$card = new Card(NULL,$_POST["Username"]);
	if($card->is_user_logged()){
		$professione= substr($_POST['professione'],0,50);
		$category = $_POST['category'];
		$nameshowed = $_POST['nameshowed'];
		$card->Update_professione($professione,$category,$nameshowed);
	}else{
		$card->Logout();	
	}
}

if(isset($_POST['Personal_card_save_dove_siamo'])){
	$card = new Card(NULL,$_POST["Username"]);
	if($card->is_user_logged()){
		$address_via= $_POST['address_via'];
		$address_citta= $_POST['address_citta'];
		$address_desc = $_POST['address_desc'];
		$address_on = $_POST['address_on'];
		$card->Update_dove_siamo($address_via,$address_citta,$address_desc,$address_on);
	}else{
		$card->Logout();	
	}
}

if(isset($_POST['Refresh_notifica_message'])){
	$card = new Card(NULL,$_POST["Username"]);
	if($card->is_user_logged()){
		$new_emails=0;
		for($i=1;$i<=count($card->email_messages);$i++){
			if($card->email_messages[$i]['visto'] == 0){
				$new_emails++;
			}
		}
		
		$new_contacts=0;
		for($i=0;$i<count($card->newsletter_rows);$i++){
			if($card->newsletter_rows[$i]['is_new'] == 1){
				$new_contacts++;
			}
		}
		
		$json_string = json_encode(array("new_emails"=>$new_emails,"new_contacts"=>$new_contacts));
		echo $json_string;
	}else{
		$card->Logout();	
	}	
}

//--------------------------------------------------------------------------------------
//------FRIEND--------------------------------------------------------------------------
	if(isset($_POST['Add_friend'])){
		$card = new Card(NULL,$_POST["Username"]);
		$nome = $_POST['nome'];
		$cognome = $_POST['cognome'];
		$email = $_POST['email'];
		$cell = $_POST['cell'];
		$friend_note = $_POST['friend_note'];
		$result = $card->Add_friend($nome,$cognome,$email,$cell,$friend_note);
		$json_string = json_encode(array("result"=>$result)); 
		echo $json_string;
	}
	
	if(isset($_POST['Reset_add_friend'])){
		$card = new Card(NULL,$_POST["Username"]);
		echo $card->Show_friend();
	}
		

//--------------------------------------------------------------------------------------

//----------ASSISTENZA------------------------------------------------------------------

	if(isset($_POST['Submit_assistenza'])){
		$card = new Card(NULL,$_POST["Username"]);
		$email = $_POST['email'];
		$textarea = $_POST['textarea'];
		$ip = $_POST['ip'];
		$result = $card->Save_assistenza($email,$textarea,$ip);
		$json_string = json_encode(array("result"=>$result)); 
		echo $json_string;
	}
//--------------------------------------------------------------------------------------
	if(isset($_POST['Submit_abuso'])){
		$card = new Card(NULL,$_POST["Username"]);
		$email = $_POST['email'];
		$textarea = $_POST['textarea'];
		$ip = $_POST['ip'];
		$type = $_POST['type'];
		$result = $card->Save_abuso($email,$type,$textarea,$ip);
		$json_string = json_encode(array("result"=>$result)); 
		echo $json_string;
	}
	
	if(isset($_POST["Set_progress_size_bar"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$value =  $card->Set_progress_size_bar();
			$json_string = json_encode(array("value"=>$value[0],"progressvalue"=>$value[1])); 
			echo $json_string;
		}else{
			$card->Logout();
		}	
	}
	
	if(isset($_POST["Personal_aggiorna_news"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_personal_card_evidenza();
		}else{
			$card->Logout();
		}	
	}
	
	if(isset($_POST["Personal_aggiorna_promoter"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Show_promoter();
		}else{
			$card->Logout();
		}	
	}
	
	if(isset($_POST["Set_mailing_contacts_old"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			$card->Set_mailing_contacts_old();
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_aggiorna_professione"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Professione;
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_aggiorna_nameshowed"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Getnameshowed();
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_aggiorna_main_photo"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_personal_card_main_photo( 147, 220, "../".USERS_PATH.$card->username."/".USER_PHOTO_MAIN_PATH);
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_aggiorna_social"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_personal_card_social();
		}else{
			$card->Logout();
		}	
	}
	
	if(isset($_POST["Personal_aggiorna_slide_photo"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_personal_card_mod_photoslide();
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_card_show_riscuoti"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_form_riscuoti();
		}else{
			$card->Logout();
		}	
	}
	
	if(isset($_POST["Personal_card_show_promoter"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			echo $card->Show_promoter();;
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_card_riscuoti"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($_POST["nomebeneficiario"]!="" && $_POST["iban"]!="" && $_POST["codfis"]!="")
			echo $card->Personal_card_riscuoti($_POST["nomebeneficiario"],$_POST["iban"],$_POST["codfis"],$_POST["swift"]);
		}else{
			$card->Logout();
		}	
	}
	if(isset($_POST["Personal_card_ctrl_riscuoti"])){
		$card = new Card(NULL,$_POST["Username"]);
		if($card->is_user_logged()){
			if($card->Personal_card_ctrl_riscuoti())
				echo 1;
			else
				echo 0;
		}else{
			$card->Logout();
		}	
	}
	
?>