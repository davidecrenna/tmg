<?php 
	require_once("../../headerbasic.php");
	include("../../header.php");
	if(session_id() == '') {
		session_name(SESSION_NAME);
	   // Now we cat start the session
	   session_start();
	}
	$username=$_GET['u'];
	$card= new Card(NULL,$username);
	if(!$card->is_user_logged()){
		header("location: ../../error_page.php");
		exit ("Non hai effettuato l'accesso!" );
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $card->Show_title()?></title>

<link rel="stylesheet" type="text/css" href="../css/filebox.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/text.css"/>

<script type="text/javascript" src="../../common/js/ajax.inc.js"></script>
<script type="text/javascript" src="../js/filebox.js"></script>
<script src="../../common/js/jquery-1.2.6.tools_min.js"></script>
<script type="text/javascript" src="../../common/js/json2.js"></script>
</head>
<body>
            <div style="display:none;">
            <? $card->fix_upload(); ?>
            </div>
            <div class="cols" id="choose">
                    <div class="col">
                    	
                    	<div style='width:820px; height:220px; text-align:center;'>
                        	<p style="font-size:15px; font-weight:700;">Gestisci le tue CARTELLE SEGRETE CON PASSWORD</p>                        
                            <div style='position:absolute; top:40px; left:5px; width:785px; background-color:#787878; text-align:left; height:280px; border:1px #FFFFFF solid; padding-left:10px;'>
                                <div id="private_subfolders" style="overflow-y:auto; overflow-x:hidden; height:264px;">
                               		 <? $card->show_filebox_subfolder("private"); ?>
                                </div>
                         	</div>
                            
                            <div style='position:absolute; top:321px; left:5px; cursor:pointer; width:795px; text-align:left; height:30px; border:1px #FFFFFF solid;' >
                                 <div id='trigger_overlay_create_private_folder' style="float:left;">
                                    <a target='_self' rel='#overlay_create_private_folder' onclick='Javascript:load_create_private_folder();'>
                                       <div class='personal_button green_button' style='width:150px;'>
                                        <span class='text14px' alt='Salva'>CREA CARTELLA</span>
                                    	</div>
                                    </a>
                                </div>
                        	</div>
                            <div id="create_private_folder_result" style="display:none; position:absolute; top:355px; left:455px; width:300px; height:30px; ">
                            </div>
                            
                         </div>
                         <div class='personal_button social_button' onclick='Javascript:window.parent.personal_tab_change("interfaccia")' style='width:220px; position:absolute; top:385px; left:6px;'>
							<img src='../../image/icone/arrow-left.png' width='12' height='12' />&nbsp;&nbsp;<span class='text14px' alt='Torna a modifica card.'>TORNA A MODIFICA CARD</span>
						</div>
                            
                         </div>
                    </div>
             </div>
             
             <div class="apple_overlay_create_folder" id="overlay_create_public_folder">
               <div id="actions"></div>
                  <div class="scrollable vertical_create_folder">
                      <div class="items">
                          <div>
                              <div class="item" id='item_create_public_folder'>
                              </div>
                          </div>
                      </div>
                  </div>
             </div>
                     
                     
               <div class="apple_overlay_create_folder" id="overlay_create_private_folder">
                   <div id="actions"></div>
                      <div class="scrollable vertical_create_folder">
                          <div class="items">
                              <div>
                                  <div class="item" id='item_create_private_folder'>
                                  </div>
                              </div>
                          </div>
                      </div>
               </div>
 
             <script language="javascript" type="text/javascript"> 
				var overlay_create_public_folder = $("#trigger_overlay_create_public_folder a[rel]").overlay({effect: 'apple',top:100});
				
				var overlay_create_private_folder = $("#trigger_overlay_create_private_folder a[rel]").overlay({effect: 'apple',top:100});
				
				function open_overlay_create_private_folder(){
					overlay_create_private_folder.overlay().load();
				}
				function open_overlay_create_public_folder(){
					overlay_create_public_folder.overlay().load();
				}
			 </script>
             
             <div class="cols" id="file" style="display:none;">
                    <div class="col">
                    	<!--<p style="font-size:18px;">Gestisci la tua FILE BOX <img class='img_button' src='../../image/btn/btn_indietro.png' id='btn/btn_indietro' alt='Torna indietro' onclick='Javascript:torna_root()'/></p>-->
                        <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='file_saved'><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' style='vertical-align:middle;' /> File caricato con successo.</div>
                        <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='file_error'><img src='../../image/icone/error.png' alt='Errore caricamento file.' width='18' height='18' style='vertical-align:middle;' /> Non è stato possibile caricare il file.</div>
                        <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='password_saved'><img src='../../image/icone/ok.png' alt='Password modificata' width='22' height='19' style='vertical-align:middle;' /> Password modificata.</div>
                        <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='folder_renamed'><img src='../../image/icone/ok.png' alt='Password modificata' width='22' height='19' style='vertical-align:middle;' /> Cartella rinominata.</div>
                         <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='delete_file_saved'><img src='../../image/icone/ok.png' alt='File eliminato' width='22' height='19' style='vertical-align:middle;' /> File eliminato.</div>
                         <div style='position:absolute; left:300px; top:315px; width:250px; display:none;' id='delete_loading'><img src='../../image/icone/ajax_small.gif' alt='File eliminato' width='22' height='19' style='vertical-align:middle;' /> Eliminazione in corso...</div>
                         
                        <div id="files_content">
                        </div>
                    </div>
             </div>
        <? $card->Show_input_username(); ?>
</body>
</html>