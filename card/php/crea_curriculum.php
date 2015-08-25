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
<link rel="stylesheet" type="text/css" href="../css/crea_curriculum.css"/>

<script type="text/javascript" src="../../common/js/ajax.inc.js"></script>
<script type="text/javascript" src="../../common/js/jquery-pack.js"></script>
<script type="text/javascript" src="../../common/js/card_common.js"></script>
<script type="text/javascript" src="../js/crea_curriculum.js"></script>


</head>
<body>
	 <? $card->Show_input_username(); ?>
     <div id='creacurriculum_loading' class='personal_tab_loading_onpage'><img src='../../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>
     <div id='creacurriculum_saved' class='personal_tab_loading_onpage'><img src='../../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Informazioni salvate<span></div>
		<div align="center">
        	
        	<div class="cols" id="step0">
                    <div class="col">
                    	<p style="font-size:18px; position:absolute; left:0px; top:0px; width:750px;">Creare il tuo curriculum europeo è semplice.Inserisci le informazioni richieste.</p>
                    	<? $card->Show_crea_scritte_step0(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        <div style='position:absolute; top:326px; left:325px; width:200px;'><p>
					<img class='img_button'  src='../../image/btn/btn_indietro.png' alt='Indietro' onclick='Javascript:window.parent.personal_tab_change("curriculum")' />
                    
                    <img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua.' onclick='Javascript:save_step0()' />
                    </p></div>
                   
                    	<? $card->Show_crea_input_step0(); ?>
                    </div>
                    <div style="left: 600px; top: 100px;" class="col2">
                    </div>
              </div>
              
         	<div class="cols" id="step1" style="display:none;">
                <div style='position:absolute; top:330px; left:0px; width:400px;'>
                <? /*if($card->opt_curr==1) echo "<img src='../../image/icone/icona_warning.png' style='width:25px; height:25px; vertical-align:bottom' /><span style='font-size:12px;'>Il curriculum europeo verrà visualizzato nella card. Puoi modificare queata opzione nelle impostazioni della tua personal area.</span>";*/ ?>
               </div>
                    <div class="col">
                    	<p style="font-size:18px; position:absolute; left:0px; top:0px; width:750px;">Creare il tuo curriculum europeo è semplice.Inserisci le informazioni richieste.</p>
                    	<? $card->Show_crea_scritte_step1(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        <div style='position:absolute; top:326px; left:325px; width:200px;'><p>
					<img class='img_button'  src='../../image/btn/btn_indietro.png' alt='Indietro' onclick='Javascript:go_step0_from_step1()' />
                    
                    <img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua.' onclick='Javascript:save_step1()' />
                    </p></div>
                   
                    	<? $card->Show_crea_input_step1(); ?>
                    </div>
                    <div style="left: 600px; top: 100px;" class="col2">
                    </div>
              </div>
          <div class="cols" id="step2" style="display:none;">
                <div style='position:absolute; top:300px; left:0px; width:400px;'>
                <? /*if($card->opt_curr==1) echo "<img src='../../image/icone/icona_warning.png' style='width:25px; height:25px; vertical-align:bottom' /><span style='font-size:12px;'>Il curriculum europeo verrà visualizzato nella card. Puoi modificare queata opzione nelle impostazioni della tua personal area.</span>";*/ ?>
               </div>
                    <div class="col">
                        <p style="font-size:17px; position:absolute; left:0px; top:0px; width:980px;">Step 2 di 5 - Inserisci le informazioni richieste.</p>
                    	<? $card->Show_all_curriculum_europeo_scritte_step2(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        
                        <div style='position:absolute; top:326px;  left:325px;  width:400px;'><p><img class='img_button'  src='../../image/btn/btn_indietro.png' alt='Indietro' onclick='Javascript:go_step1_from_step2()' />
                        
					<img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua.' onclick='Javascript:save_step2()' />
                    	</p></div>
                    	<? $card->Show_all_curriculum_europeo_input_step2(); ?>
                    </div>
                    <div style="left: 600px; top: 100px;" class="col2">
                    </div>
            </div>        
                    
            <div class="cols" id="step3" style="display:none;">
                <div style='position:absolute; top:300px; left:0px; width:400px;'>
                <? /*if($card->opt_curr==1) echo "<img src='../../image/icone/icona_warning.png' style='width:25px; height:25px; vertical-align:bottom' /><span style='font-size:12px;'>Il curriculum europeo verrà visualizzato nella card. Puoi modificare queata opzione nelle impostazioni della tua personal area.</span>";*/ ?>
               </div>
                    <div class="col">
                        <p style="font-size:17px; position:absolute; left:0px; top:0px; width:980px;">Step 3 di 5 - Inserisci le informazioni richieste.</p>
                    	<? $card->Show_all_curriculum_europeo_scritte_step3(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        
                        <div style='position:absolute; top:326px; left:325px;  width:300px;'><p>
                         <img class='img_button' src='../../image/btn/btn_indietro.png' alt='Indietro' onclick='Javascript:go_step2_from_step3()' />
                         <img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua.' onclick='Javascript:save_step3()' />
                    </p></div>
                   
                    	<? $card->Show_all_curriculum_europeo_input_step3(); ?>
                    </div>
            </div>
            <div class="cols" id="step4" style="display:none;">
                <div style='position:absolute; top:300px; left:0px; width:400px;'>
                <? /*if($card->opt_curr==1) echo "<img src='../../image/icone/icona_warning.png' style='width:25px; height:25px; vertical-align:bottom' /><span style='font-size:12px;'>Il curriculum europeo verrà visualizzato nella card. Puoi modificare queata opzione nelle impostazioni della tua personal area.</span>";*/ ?>
               </div>
                    
                    <div class="col">
                        <p style="font-size:17px; position:absolute; left:0px; top:0px; width:980px;">Step 4 di 5 - Inserisci le informazioni richieste.</p>
                    	<? $card->Show_all_curriculum_europeo_scritte_step4(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        
                        <div style='position:absolute; top:326px; left:325px;  width:300px;'><p>
                         <img class='img_button' src='../../image/btn/btn_indietro.png' onclick='Javascript:go_step3_from_step4()' />
					<img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua' onclick='Javascript:save_step4()' />
                    </p></div>
                   
                    	<? $card->Show_all_curriculum_europeo_input_step4(); ?>
                    </div>
             </div>
             <div class="cols" id="step5" style="display:none;">
                <div style='position:absolute; top:300px; left:0px; width:400px;'>
                <? /*if($card->opt_curr==1) echo "<img src='../../image/icone/icona_warning.png' style='width:25px; height:25px; vertical-align:bottom' /><span style='font-size:12px;'>Il curriculum europeo verrà visualizzato nella card. Puoi modificare queata opzione nelle impostazioni della tua personal area.</span>";*/ ?>
               </div>
                   
                   <div class="col">
                        <p style="font-size:17px; position:absolute; left:0px; top:0px; width:980px;">Step 5 di 5 - Inserisci le informazioni richieste.</p>
                    	<? $card->Show_all_curriculum_europeo_scritte_step5(); ?>
                        <div id='curriculum_europeo_saved' style='display:none;'><p><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Informazioni Salvate.</p></div>
                        
                        <div style='position:absolute; top:326px; left:325px;  width:200px;'><p>
                         <img class='img_button' src='../../image/btn/btn_indietro.png' alt='Indietro' onclick='Javascript:go_step4_from_step5()' />
					<img class='img_button' src='../../image/btn/btn_continua.png' alt='Continua.' onclick='Javascript:save_step5()' />
                    </p></div>
                   
                    	<? $card->Show_all_curriculum_europeo_input_step5(); ?>
                    </div>
          </div>
          <div class="cols" id="step6" style="display:none;">
                <div style='position:absolute; top:300px; left:0px; width:400px;'>
               </div>
                   <div class="col">	
                        <div style="font-size:18px; position:absolute; left:0px; top:0px; width:850px;"><img src='../../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' /> Complimenti! Informazioni Salvate.<span id='caricamento_curr' style="font-size:15px; display:none;">( <img src="../../image/icone/ajax_small.gif"  alt="Caricamento" width="18" height="16" /> Caricamento curriculum...)</span></div>
                        
                        <div id='iframe_show_curr'></div>
                        <div style='position:absolute; top:326px; left:325px;  width:200px;'><p>
                         <img class='img_button' src='../../image/btn/btn_indietro.png' alt='Indietro.' onclick='Javascript:go_step5_from_step6()'/>
                         
                         <img class='img_button' src='../../image/btn/btn_fine.png' alt='Indietro.' onclick='Javascript:window.parent.personal_tab_change("interfaccia"); location.href="crea_curriculum.php?u=<?php echo $card->username; ?>"'/>
                    </p></div>
                    </div>
                   
             </div>
        </div>
</body>
</html>