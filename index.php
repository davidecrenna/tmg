<?php
    require_once "headerbasic.php";
    include("header.php");
    $login = new Login();
    $basic->sec_session_start();
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Top Manager Group</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="index/css/index.css"/>
<link rel="stylesheet" type="text/css" href="index/css/indexresponsive.css">
<link rel="stylesheet" type="text/css" href="index/css/inizia.css"/>
<link rel="stylesheet" type="text/css" href="common/css/login.css"/>
<link rel="stylesheet" type="text/css" href="common/css/text.css"/>
<link rel="stylesheet" type="text/css" href="common/css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="common/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="basic/css/tmgheader.css">
<!--[if IE]>
<style>
.in_go_to_card{
	padding-top:7px;
    height:22px;
    font-size:12px;
	font-weight:600;
}
.forminput{
	padding-top:7px;
    height:22px;
}
</style>
<![endif]-->

<script>
	/*function overlay() {
		elem = document.getElementById("overlay");
		 elem.style.visibility="hidden";
		 
		elem = document.getElementById("bodydiv");
		 elem.style.visibility="visible"; 
	 }*/
	
 </script>

<script type="text/javascript" src="common/js/all_jquery_and_tools.min.js "></script>
<script type="text/javascript" src="common/js/ajax.inc.js"></script>
<script type="text/javascript" src="common/js/json2.js"></script>
<script type="text/javascript" src="index/js/index.js"></script>
<script type="text/javascript" src="index/js/formvalidator.js"></script> 
<script type="text/javascript" src="index/js/inizia.js"></script>
<script type="text/javascript" src="index/js/slide-show.js"></script>
<script type="text/javascript" src="common/js/md5.js"></script>
<script type="text/javascript" src="common/js/login.js"></script>
<script type="text/javascript" src="common/js/sha512.js"></script>
<script type="text/javascript" src="basic/js/tmgheader.js"></script>
<?php
if(DEVELOPMENT)
	echo '<script type="text/javascript" src="common/js/jquery-ui.min.js"></script>';
else
	echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>';
?>
</head>
<body>
<!--<div id="overlay" class="overlay" align="center" style="top: 0px; left: 0px; bottom: 0px; z-index:14000; text-align:center; " onclick="overlay()">
	<div align="center">
        <div class="start_message_container_popup rounded2 shadow2" align="center">
            <div style="float:right; margin-right:10px; margin-top:30px; width:65px; height:13px; font-size:14px; cursor:pointer;">X CHIUDI</div>
        	<div class="text14px" style="padding-top:30px; padding-left:30px;">
            			Entrando a far parte della TopManagerGroup otterrai:<br/><br/>
                        DARAI VALORE AL TUO NOME<br/>
                        <span style="font-size:12px;">Avrai una mail di FORTE IMPATTO: nickname@topmanagergroup.com<br/>
                        Avrai un sito web dall'INDIRIZZO ALTISONANTE:
                        topmanagergroup.com/nickname<br/>
                        Suscitando interesse nella tua persona unendo il tuo nome al marchio Top Manager Group</span>
                        
                        <br/>
                        <br/>
                        
                        IL TUO SITO WEB PERSONALE<br/>
            			<span style="font-size:12px;">Facile da autogestire, elegante, professionale.</span><br/>
                        <br/>
                        
                        UN GUADAGNO DI ANNO IN ANNO<br/>
                        <span style="font-size:12px"> Ti vengono riconosciute € 25 per ogni persona che si iscrive tramite te al nostro gruppo.<br/>Guadagno riconfermato ad ogni sua reiscrizione annuale!
                        </span>
                        
                        <br/>
                        <br/>
                        L'IDEA<br/>
                        <span style="font-size:12px">
                        L'idea nasce (oltre che voler dare importanza al tuo nome)<br/> nel creare una rete di contatti tra manager, produttori e finanziatori per<br/> far conoscere la tua persona, le tue doti, le tue predisposizioni e dare visibilità alla tua<br/> attività o hobby.
                        </span>
            </div>
    	</div>
   </div>
</div>-->
	<div align="center" >
    	<!--<div style="width:970px; text-align:left; height:89px;" >
        	<div style="float:left">
    			<a href="index.php" ><img src="image/banner/banner_scaled.png" onmouseover="this.style.filter='alpha(opacity=40);'"
    onmouseout="this.style.filter='alpha(opacity=100);'" /></a>
    		</div>
            
            <div style="width:242px; text-align:left; margin-top:0px; height:23px; float:right; font-size:11px; font-weight:700; padding-top:5px; padding-right:10px;" class="rounded" id="div_banner_sx_up">
            
            <span style="font-size:11px; font-weight:700; color:#000;">VOGLIAMO SAPERE CHI SEI<br/>
LA GENTE VUOLE SAPERE CHI SEI<br/>
PERSONE CHE POSSONO CAMBIARE IL TUO PERCORSO VOGLIONO SAPERE CHI SEI</span>
            </div>
            
    		<div style="width:242px; text-align:center; margin-top:36px; height:23px; float:left; font-size:13px; font-weight:700;  background-color:#623939; padding-top:5px; padding-right:10px;" class="rounded" id="div_banner_sx"><span style="font-size:13px;" id="user_accedi"><a target="_self" onclick="change_scheda('scheda6');" style="cursor:pointer;"><span style="font-size:13px; font-weight:700; color:#F4CE38;">Iscriviti al gruppo</span></a></span>
            </div>
    	</div>-->
        <?php  echo $basic->Show_header(false,""); ?>
    </div>
	<div align="center">
        <div class="cols card_shadowed" id="scheda1">
              <div class="box_col1">
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Carta d'identità web</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Sito e casella e-mail</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Biglietto da visita</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Condivisione file</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Social networks</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Gestione news/eventi</div>
                    <div class="styledbuttonhome text_scheda1" onclick="change_scheda('scheda_cb_carta');">Mappa Google maps</div>
              </div>
              
              <div class="col2_scheda1">
                   <div class="box_search shadow rounded">
                            <div style="font-size:14px; font-weight:700; width:420px; height:20px;">Cerca utente <span id="info_go_to_card"></span></div>
                            
                            <input type="text" id="in_go_to_card" class="in_go_to_card" value="nickname o nomesocietà" onclick="in_go_to_card_click()" onkeydown="CercaInvio(event);" onchange="username_correction('in_go_to_card')" />
                            
                            <img style="vertical-align:middle; cursor:pointer;" src="image/homepage/btn/bg_go_search.png"  onclick="go_to_card();" alt="vai"/> 
                        
                        </div>
                   
                   <div id="gallery" class="box_esempio shadow rounded">
                         <div id="slides" >
                            <div class="slide" >
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_brown.png" style="cursor:pointer;" onclick="open_esempio('brown')"/></div>
                            
                             <div class="slide" >
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_black.png" style="cursor:pointer;" onclick="open_esempio('black')" /> </div>
                            
                            <div class="slide" >
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_green.png" style="cursor:pointer;" onclick="open_esempio('green')" /> </div>
                            
                             <div class="slide">
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_blue.png" style="cursor:pointer;" onclick="open_esempio('blue')"/> </div>
                            
                            <div class="slide" >
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_pink.png" style="cursor:pointer;" onclick="open_esempio('pink')" /> </div>
                            
                            <div class="slide">
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_azzurro.png" style="cursor:pointer;" onclick="open_esempio('azzurro')" /> </div>
                         <div class="slide">
                            <img width="420" height="280" src="image/homepage/btn/btn_esempio_orange.png" style="cursor:pointer;" onclick="open_esempio('orange')" /> </div>
                           
                         </div>
                         <div id="menu" >
                            <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_brown.png' /></a></div>
                           <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_black.png' /></a></div>
                           <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_green.png' /></a></div>
                            <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_blue.png' /></a></div>
                            <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_pink.png' /></a></div>
                            <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_azzurro.png' /></a></div>
                            <div class="menuItem"><a href=""><img class='btn_colore' src='image/card/btn/card_colour/btn_orange.png' /></a></div>
                         </div>
                   </div>
               </div>
              
              <div class="col3_scheda1">
                   <!--<div class="box_8euro">
                   		<a target="_self" onclick="change_scheda('scheda6');" style="cursor:pointer; position:relative; top:45px;" class="text_scheda1" ><img src="image/homepage/btn/btn_guadagna_promuovendoci.png" /></a>
                   </div>-->
                  
            </div>
             
       </div>
       
       
        <div class="cols" id="scheda2">
            <div style="position:absolute; top:23px; left:27px;">
            <img src="image/homepage/chisiamo.png" alt="Chi siamo."/>
            </div>
            <div style="left: 280px;" class="col2">
            </div>
            <div style="left: 760px;" class="col3">
            </div>
       </div>
                     	
        <div class="cols" id="scheda3">
              <div style=" left:0px;" class="col">
                    <img src="image/homepage/btn/btn_costi_benefici1.png" alt="Indirizzo web altisonante" style="cursor:pointer; position:absolute; left:21px; top:23px; " onclick="change_scheda('scheda_cb_carta');" /><img src="image/homepage/btn/btn_costi_benefici2.png" alt="Biglietto da visita" style="cursor:pointer; position:absolute;left:147px; top:23px; " onclick="change_scheda('scheda_cb_sito');" /><img src="image/homepage/btn/btn_costi_benefici3.png" alt="File box" style="cursor:pointer; position:absolute; left:264px; top:23px;" onclick="change_scheda('scheda_cb_guadagno');"/><img src="image/homepage/btn/btn_costi_benefici4.png" alt="Perchè pagare?" style="cursor:pointer; position:absolute; left:382px; top:23px;" onclick="change_scheda('scheda_cb_mailing');"/><img src="image/homepage/btn/btn_costi_benefici5.png" alt="Guadagn" style="cursor:pointer; position:absolute; left:500px; top:23px;" onclick="change_scheda('scheda_cb_biglietto');"/><img src="image/homepage/btn/btn_costi_benefici6.png" alt="News" style="cursor:pointer; position:absolute; left:618px; top:23px;" onclick="change_scheda('scheda_cb_filebox');"/><img src="image/homepage/btn/btn_costi_benefici7.png" alt="News" style="cursor:pointer; position:absolute; left:735px; top:23px;" onclick="change_scheda('scheda_cb_networks');"/><img src="image/homepage/btn/btn_costi_benefici8.png" alt="News" style="cursor:pointer; position:absolute; left:853px; top:23px;" onclick="change_scheda('scheda_cb_giovani');"/>
              </div>
          
              <div style="left: 280px;" class="col2">
               	  
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
       </div>
       
       <div class="cols" id="scheda_cb_carta">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/card.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          	 <div id="omino_answer" style="position:absolute; left:358px; top:93px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:277px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
              <div style=" top:60px;" class="col2_cb_up">
                     <span class="evidenzio">PERCH&Eacute; PAGARE  PER UN SITO</span> QUANDO  ISCRIVENDOTI A TMG  AVRAI LA TUA “CARTA D'IDENTIT&Aacute; WEB” OVVERO UNO SPAZIO WEB CHE POTRAI GESTIRE SENZA CHIEDERE AIUTO AD ALTRI?
               </div>
               <div style=" top:130px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" class="tmgdoit" alt="tmg do it."/>
               </div>
               <div style=" top:195px;" class="col2_cb_down">
                    AL TUO INDIRIZZO topmanagergroup.com/nickname o /nomesociet&aacute;, CHI TI CERCHER&Aacute; TROVER&Aacute; TUTTE LE INFORMAZIONI CHE VORRAI FAR SAPERE DI TE.<br/>
CON UNA INTERFACCIA FACILE ALL'UTILIZZO POTRAI GESTIRE LA TUA “CARTA D'IDENTIT&Aacute; WEB” CON FACILIT&Aacute; EVITANDO INUTILI PERDITE DI TEMPO.
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
            <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
       
        <div class="cols" id="scheda_cb_sito">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/www.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
              <div id="omino_answer" style="position:absolute; left:358px; top:129px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:279px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="risposta" />
              </div>
              
              <div style=" top:80px;" class="col2_cb_up">
                    PERCH&Eacute; NON AVERE UN SITO INTERNET CON <span class="evidenzio">UN INDIRIZZO WEB ALTISONANTE</span> DANDO IMPORTANZA E VALORE AL TUO NOME E <span class="evidenzio">UN INDIRIZZO E-MAIL DI FORTE IMPATTO</span> SUSCITANDO INTERESSE VERSO LA TUA PERSONA?
               </div>
               <div style=" top:165px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png"  class="tmgdoit" alt="tmg do it."/>
               </div>
               <div style=" top:230px;" class="col2_cb_down">
                   	IL TUO SITO SAR&Aacute;:<br/> www.topmanagergroup.com/nickname o /nomesociet&aacute;<br/>
LA TUA MAIL SAR&Aacute;:<br/> nickname o nomesocieta’@topmanagergroup.com
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
            
       </div>
       
        <div class="cols" id="scheda_cb_guadagno">
              <div class="col_cb">
                    <img src="image/costi_benefici_symbols/sold.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          	  <div id="omino_answer" style="position:absolute; left:358px; top:66px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:288px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
               <div style="top:63px;" class="col2_cb_up">
                    <span class="evidenzio">PERCH&Eacute; NON CREARSI UNA POSSIBILE FONTE DI GUADAGNO ?</span>
               </div>
               <div style="top:100px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it."  class="tmgdoit"/>
               </div>
               <div style="top:166px;" class="col2_cb_down">
                    TUTTI I MEMBRI "TOP MANAGER GROUP" ENTRANO A FAR PARTE DELLA “FORMULA DI PROMOTER A PROVVIGIONE AUTOMATICA”.<br/>
VERRANNO CORRISPOSTE €25 PER OGNI PERSONA (DAI 25 ANNI IN SU) CHE SI ISCRIVER&Aacute; TRAMITE LA TUA CARD O INDICANDOTI COME PROMOTER.<br/>
QUESTO SUCCEDERA’ NON SOLO IL PRIMO ANNO MA SI RIPETER&Aacute; FIN QUANDO LA MEDESIMA PERSONA RIMARR&Aacute; NELLA “TOP MANAGER GROUP”.
               </div>
              
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
       <div class="cols" id="scheda_cb_biglietto">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/fot.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
              
              <div id="omino_answer" style="position:absolute; left:358px; top:131px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:253px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
          
            	<div style="top:115px;" class="col2_cb_up">
                    PERCH&Eacute; NON POTER STAMPARE IL PROPRIO <span class="evidenzio">BIGLIETTO DA VISITA</span> DIRETTAMENTE DA CASA TUA?
               </div>
               <div style="top:168px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it." class="tmgdoit"/>
               </div>
               <div style="top:230px;" class="col2_cb_down">
                   	A TUTTI I MEMBRI "TOP MANAGER GROUP" &Eacute; FORNITA LA GRAFICA DEL BIGLIETTO DA VISITA CARTACEO
(SCARICABILE IN FORMATO PDF <img src="image/filebox/icona_pdf.png" alt="formato pdf." style="vertical-align:middle; height:22px; width:21px;"/>).
               </div>
              
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
      
       
       <div class="cols" id="scheda_cb_mailing">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/mailing.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          	<div id="omino_answer" style="position:absolute; left:358px; top:92px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:271px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
             <div style="top:75px;" class="col2_cb_up">
                    PERCH&Eacute; NON POTER MANDARE CON UN CLICK <span class="evidenzio">LA TUA NEWS PI&Uacute; IMPORTANTE DECIDENDO</span> ANCHE IL GIORNO DI INVIO?
               </div>
               <div style="top:128px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it."  class="tmgdoit"/>
               </div>
               <div style="top:190px;" class="col2_cb_down">
                    NELLA “CARTA D'IDENTIT&Aacute; WEB” &Eacute; VISIBILE LA TUA NEWS PI&Uacute; IMPORTANTE.
OGNI VOLTA CHE LA CAMBIERAI SAR&Aacute;
 VISIBILE A TUTTI E SAR&Aacute; INVIATA UNA E-MAIL  AI GRUPPI DI PERSONE GESTITE NELLA TUA MAILING LIST. <br/>
POTRAI ANCHE PROGRAMMARE  LA GIORNATA DELLA PUBBLICAZIONE E  INVIO DEL MESSAGGIO CHE POTR&Aacute; CONTENERE ANCHE UN ALLEGATO. <br/>
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
       <div class="cols" id="scheda_cb_filebox">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/keylock.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
               <div id="omino_answer" style="position:absolute; left:358px; top:103px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:281px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
          
              <div style="top:85px;" class="col2_cb_up">
                    PERCH&Eacute; NON POTER CREARE <span class="evidenzio">CARTELLE RESE SEGRETE DA PASSWORD</span> PER POTER CONDIVIDERE FILE SOLO CON CHI VUOI?
               </div>
               <div style="top:137px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it."  class="tmgdoit"/>
               </div>
               <div style=" top:215px;" class="col2_cb_down">
                    AVRAI A DISPOSIZIONE CARTELLE PRIVATE PROTETTE DA PASSWORD<br/>
                    E<br/>
                    UNA SEZIONE PUBBLICA PER CARICARE FILE VISIBILI A TUTTI<br/>
                    <span class="evidenzio">FINO A 2 GB</span> DI SPAZIO DISPONIBILE (500MB PER I GIOVANI)!
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
            
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks')" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
       <div class="cols" id="scheda_cb_giovani">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/giovani.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          	<div id="omino_answer" style="position:absolute; left:358px; top:103px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:271px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
             <div style="top:85px;" class="col2_cb_up">
                 PERCH&Eacute; NON AVERE LA TUA "CARTA D'IDENTIT&Aacute; WEB" <span class="evidenzio">IN MANIERA GRATUITA</span>?
               </div>
               <div style="top:150px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it."  class="tmgdoit"/>
               </div>
               <div style="top:222px;" class="col2_cb_down">
                    SE HAI DAI 18 AI 24 ANNI LA TMG OFFRE GRATUITAMENTE:  <span class="evidenzio">ISCRIZIONE, CARD E SERVIZI ANNESSI AL GRUPPO.</span><br/>
                    ENTRA NEL MONDO LAVORATIVO PRESENTANDOTI IN MANIERA PROFESSIONALE ED APPROPRIATA.<br/>
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks');" ><img src="image/homepage/btn/btn_cb_7.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8_over.png" alt="" /></a></div>
       </div>
       
       <div class="cols" id="scheda_cb_networks">
              <div class="col_cb">
              		<img src="image/costi_benefici_symbols/social.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          	<div id="omino_answer" style="position:absolute; left:358px; top:103px; z-index:90000;">
              		<img src="image/homepage/omino_question.png" alt="domanda" />
              </div>
              
               <div id="omino_answer" style="position:absolute; left:358px; top:238px; z-index:90000;">
              		<img src="image/homepage/omino_answer.png" alt="domanda" />
              </div>
             <div style="top:85px;" class="col2_cb_up">
                 PERCH&Eacute; NON AVERE TUTTI I TUOI SOCIAL NETWORKS IN UN TUO UNICO SPAZIO WEB?
               </div>
               <div style="top:140px;" class="col2_cb_center">
                    <img src="image/homepage/tmg_doit.png" alt="tmg do it."  class="tmgdoit"/>
               </div>
               <div style="top:205px;" class="col2_cb_down">
                    LE PERSONE ALLE QUALI DARAI L'INDIRIZZO DELLA TUA "CARTA D'IDENTIT&Aacute; WEB" TROVERANNO, CON DEI TASTI MESSI IN EVIDENZA, TUTTI I TUOI CONTATTI E SOCIAL NETWORKS.<br/>
               </div>
              <div style="left: 760px;" class="col3">
            </div>
             <div class='menu_cb_container'><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_carta');" ><img src="image/homepage/btn/btn_cb_1.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_sito');" ><img src="image/homepage/btn/btn_cb_2.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_guadagno');" ><img src="image/homepage/btn/btn_cb_3.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_mailing');" ><img src="image/homepage/btn/btn_cb_4.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_biglietto');" ><img src="image/homepage/btn/btn_cb_5.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_filebox');" ><img src="image/homepage/btn/btn_cb_6.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_networks');" ><img src="image/homepage/btn/btn_cb_7_over.png" alt="" /></a><a class='torna_cb' target='_self' onclick="change_scheda('scheda_cb_giovani');" ><img src="image/homepage/btn/btn_cb_8.png" alt="" /></a></div>
       </div>
       
       
        <div class="cols" id="scheda4">
              <div style="" class="col_promoter">
                    <img src="image/homepage/slide_promoter.png" alt="promoter manager."/>
              </div>
          
              <div style="left: 390px;" class="col2_promoter">
               	<p>LA TOP MANAGER GROUP SI AVVALE DEL SISTEMA DI PROMOZIONE 
A PROVVIGIONE AUTOMATICA <br/>
IN MODO TALE CHE QUESTA ATTIVITA' DIVENTI UNA VOSTRA FONTE DI REDDITO:<br/>
<br/>
Ti verranno corrisposte €25 per ogni persona che si iscriverà<br/>
                     indicandoti come promoter (entrando direttamente dalla tua card il riconoscimento del tuo passaparola sarà automatico).
<br/>
<br/>

Il pagamento delle tue provvigioni avviene tramite bonifico bancario<br/>
e verrà effettuato al superamento della soglia minima di 100 euro guadagnati.<br/>
               </div>
              
              
              <div style="left: 760px;" class="col3">
            </div>
           
       </div>
       
        <div class="cols" id="scheda5">
               <div style="position: absolute;left:90px; top:95px;">
              		<img src="image/costi_benefici_symbols/sold.png" alt="benefici" class="costi_benefici_main_icon" />
              </div>
          
              <div style="left: 380px; top:33px;" class="col2_cb">
                   GUADAGNO:<br/>
                    <span class='testo1'>Tutti i membri "Top Manager Group" entrano a far parte della<br/>
                     formula di promoter a provvigione automatica in modo che questa<br/>
                      attività diventi una possibile fonte di reddito.</span><br/>
                    <span class='testo_verde'>Ti verranno corrisposte €25 per ogni persona che si iscriverà<br/>
                     indicandoti come promoter (entrando direttamente dalla tua card il riconoscimento del tuo passaparola sarà automatico).</span><br/>
                    <br/>
                    COSTI:<br/>
                    <span class='testo1'>Il costo dell'iscrizione annuale a top manager group &eacute; di </span><span class='testo_verde'>€8<br/>
                     al mese (pagate in un'unica tranche annuale di € 96 incluso i.v.a.).</span><br/>
                     <span class='testo1'>Sistemi di pagamento accettati: </span><br/>
                     <img src="image/icone/paypal.png" alt="paypal" style="height:50px; with:120px;"/>
                     <img src="image/icone/bonifico.png" alt="paypal" style="height:50px; with:120px;"/><br/><br/>
					 <b>Dati per effettuare il bonifico:</b><br/>
					 NOME COGNOME INTESTATARIO: Exporeclam sas<br/>
					 IBAN: IT96W0200850110000041182842<br/>
					 CAUSALE: Iscrizione TopManagerGroup di ............. (indicare al posto<br/> dei puntini nome e cognome utilizzati nell'iscrizione al gruppo)<br/><br/>
                     
                    
               </div>
       </div>
       
       
       <div class="cols" id="scheda6" >
       	<div class="col" style="margin-top:30px;">
             		 <form name="iscrizione_form" id="iscrizione_form" action="pagamento.php" method="post" enctype="multipart/form-data">
                
                <div style="position:absolute; top:0px; left:0px;">
                    <label id="lblnome">NOME</label><br/>
                    <input type="text" required class="forminput" name="_nome" id="_nome" maxlength="17" tabindex="1" value="" onchange="Update_info_nickname()"/>
                </div>
                <div style="position:absolute; top:0px; left:230px;">
                    <label id="lblcognome">COGNOME</label><br/>
                    <input type="text" required class="forminput" name="_cognome" id="_cognome" maxlength="20" tabindex="2" onchange="Update_info_nickname()"/>
                </div>
                <div style="position:absolute; top:0px; left:460px; text-align:left;" id="input_society">     
                	<!--<span style="position:absolute; top:17px; width:140px; " class="text14px"><a target="_self" onclick="switch_society()" style="text-decoration:underline;" >Clicca qui</a> se<br/> sei una società</span>-->
                    <label><span id="labelnickname">NICKNAME</span></label><br/><input type="text" class="forminput" name="_nickname" id="_nickname" maxlength="35" tabindex="2" onchange="Update_info_nickname()"/>
                </div> 
                <div style="width: 700px; position:absolute; top:50px; left:0px;">
                    <p class="text14px">Il tuo indirizzo sarà: www.topmanagergroup.com/<span class="info_nickname">nomecognome</span></p>
                </div>
                <div style=" position:absolute; top:73px; left:460px;" id="referente_container">
                     <? if(isset($_GET['u'])){ ?>
                   	<label>REFERENTE</label>&nbsp;&nbsp;<span id="info_referente"></span> <br/>
                    <input type="text" class="forminput" value="<? echo $_GET['u']; ?>" name="_id_referente" id="_id_referente" title="<? echo TOOLTIP_REFERENTE; ?>" tabindex="5" onChange="Javascript: CtrlReferente();"  disabled/>
                <? }else{ ?>
                	<label>REFERENTE</label>&nbsp;&nbsp;<span id="info_referente"></span> <br/>
                    <input class="forminput" name="_id_referente" id="_id_referente" title="<? echo TOOLTIP_REFERENTE; ?>" tabindex="4" onChange="Javascript:CtrlReferente()" />
                 <? } ?>
                </div>
                <div style=" position: absolute; top: 73px; left: 0px;" id="codfiscale_container">
                <label><span id="labelcodfis">CODICE FISCALE</span></label>&nbsp;&nbsp;<span id="info_codfiscale" style="position: absolute; top: 0px; height: 20px; left: 125px; width: 320px;"></span><br/>
                    <input type="text" class="forminput" value="" name="_codfiscale" id="_codfiscale" title="<? echo TOOLTIP_CODICE_FISCALE; ?>" tabindex="4" onchange="Javascript: CtrlCodFisPiva();" />
                </div>
                <div style="position: absolute; top:95px; left:230px;"><input type="checkbox" id="_is_society" onChange="switch_society()"> Sono una societ&agrave;</div>
                <div style=" position:absolute; top:130px; left:0px;">
                    <label>EMAIL</label> <br/>
                    <input type="email" class="forminput" name="_email" id="_email" required tabindex="5" />
                </div>
                
                <div style=" position:absolute; top:182px; left:0px;">
                    <label>CONFERMA EMAIL</label> <br/>
                    <input type="email" class="forminput" name="_confirm_email" id="_confirm_email" required tabindex="6" />
                </div>
                
                <div style="position:absolute; top:130px; left:380px;">
                    <label>PASSWORD</label> <br/>
                    <input type="password" class="forminput" name="_password" id="_password" tabindex="7" maxlength="20" required />
                </div>
                
                <div style="width: 300px; position:absolute; top:340px; left:320px; height:80px; ">
                	
                     <button class="subscribe" name="iscrizione_submit" id="iscrizione_submit" type="button" value="clicca" alt="PayPal - The safer, easier way to pay online!" style="z-index:9000;" onClick="submit_the_form()"></button>
                     </form>
                     <form name="frm" action="pagamento.php" method="post" enctype="multipart/form-data">
                          <input name="nome" id="nome" type="hidden"/>
                          <input name="cognome" id="cognome" type="hidden"/>
                          <input name="username" id="username" type="hidden"/>
                          <input name="email" id="email" type="hidden" />
                          <input name="username_referente" id="username_referente" type="hidden"/>
                          <input name="pass" id="pass" type="hidden"/>
                          <input name="is_society" id="is_society" type="hidden" value="0" />
                          <input name="is_giovane" id="is_giovane" type="hidden" value="0"/>
                          <input name="nickname" id="nickname" type="hidden" />
                          <input name="codfiscale" id="codfiscale" type="hidden" />
                          <input name="alternative_url" id="alternative_url" type="hidden" />
                     </form>
                </div>
                <div style="position:absolute; left:370px; top:185px; width: 300px; text-align:left;">
                    
                        <div id="triggers_termini"><p class="condizioni" id="check1"><input id="_terms" name="_terms" type="checkbox" tabindex="8" required/>
                        Dichiaro di aver letto <a href="#" rel="#termini">(leggi)</a>  e di accettare le condizioni generali di contratto.</p></div>
                    
                        <div id="triggers_privacy"><p class="condizioni" id="check2"><input id="_terms2" name="_terms2" type="checkbox" tabindex="9"/>
                        Dichiaro di aver letto <a href="#" rel="#privacy">(leggi)</a> l'Informativa privacy e di esprimere il seguente consenso al trattamento dei dati personali per le finalità di cui al punto 15 dell'informativa.</span></p></div>
                    
                    
                        <p class="condizioni" id="check3"><input  id="_terms3" name="_terms3"type="checkbox" tabindex="10" />
                        Dichiaro di aver letto l'Informativa privacy e di esprimere il seguente consenso al trattamento dei dati personali per le finalità di cui al punto 15.4 dell'informativa</p>
                    
                </div> 
                
                
              	<div style="position:absolute; left:0px; top:235px; width: 350px; text-align:left; font-weight:700;" id="div_alternative_url">               
                        <p title="Scegli un indirizzo alternativo al quale sarai trovato, sceglilo con attenzione. NON potra essere modificato in seguito.">Un ulteriore vantaggio per te. Un secondo indirizzo web più specifico: </p>
                        <input type="radio" name="_alternative_url" value="www.federcard.com">www.federcard.com/<span class="info_nickname">nomecognome</span><br>
                        <input type="radio" name="_alternative_url" value="www.federartist.com">www.federartist.com/<span class="info_nickname">nomecognome</span><br>
                        <input type="radio" name="_alternative_url" value="www.federsport.com">www.federsport.com/<span class="info_nickname">nomecognome</span><br>
                        <input type="radio" name="_alternative_url" value="www.federdance.com">www.federdance.com/<span class="info_nickname">nomecognome</span><br>
                        <input type="radio" name="_alternative_url" value="www.federfashion.com">www.federfashion.com/<span class="info_nickname">nomecognome</span><br>
                        <input type="radio" name="_alternative_url" value="www.federmusic.com">www.federmusic.com/<span class="info_nickname">nomecognome</span><br>
                        
                </div>    
            </div>
      
            <div style="left: 260px; margin-top:30px;" class="col2">
                
               
            </div>
            
            <div style="left: 400px; font-size:11px" class="col3">                
                <div class="col3_iscrizione">
                        Entrando a far parte della TopManagerGroup otterrai:<br/><br/>
                        <span style="font-weight:700; color:#F4CE38;">DARAI VALORE AL TUO NOME</span><br/>
                        <span style="font-size:10px;">Avrai una mail di FORTE IMPATTO: nickname@topmanagergroup.com<br/>
                        Avrai un sito web dall'INDIRIZZO ALTISONANTE:
                        topmanagergroup.com/nickname<br/>
                        Suscitando interesse nella tua persona unendo il tuo nome al marchio Top Manager Group.</span>
                        
                        <br/>
                        <br/>
                        
                        <span style="font-weight:700; color:#F4CE38;">IL TUO SITO WEB PERSONALE</span><br/>
            			<span style="font-size:10px;">Facile da autogestire, elegante, professionale.</span><br/>
                        <br/>
                        
                        <span style="font-weight:700; color:#F4CE38;">UN GUADAGNO DI ANNO IN ANNO</span><br/>
                        <span style="font-size:10px"> Ti vengono riconosciute € 25 per ogni persona che si iscrive tramite te al nostro gruppo.<br/>Guadagno riconfermato ad ogni sua reiscrizione annuale!
                        </span>
                        
                        <br/>
                        <br/>
                        <span style="font-weight:700; color:#F4CE38;">L'IDEA</span><br/>
                        <span style="font-size:10px">
                        L'idea nasce (oltre che voler dare importanza al tuo nome) nel creare una rete di contatti tra manager, produttori e finanziatori per far conoscere la tua persona, le tue doti, le tue predisposizioni e dare visibilità alla tua<br/> attività o hobby.
                        </span>
                </div>
           </div>
           
            <div class="simple_overlay" id="termini">
              <div style="height:400px;">
              	<textarea name="textfield" id="textfield" class="textinput" cols="96" style="height:394px; text-align:left;"><? echo INFORMATIVA; ?> </textarea>
              </div>
            </div>
            <div class="simple_overlay" id="privacy">
              <div style="height:400px;">
              	<textarea name="textfield" id="textfield" class="textinput" cols="96" style="height:394px; text-align:left;"><? echo INFORMATIVA_PRIVACY; ?> </textarea>
              </div>
            </div>
            
            <script type="text/javascript">
				$("#triggers_termini a[rel]").overlay({top: 30,
					left: 80,
					speed: 500,
					fixed: false,
					closeOnClick: true,
					closeOnEsc: true,
					oneInstance: true,
					mask: {
						color: '#000'
					}
				});
				$("#triggers_privacy a[rel]").overlay({top: 30,
					left: 80,
					speed: 500,
					fixed: false,
					closeOnClick: true,
					closeOnEsc: true,
					oneInstance: true,
					mask: {
						color: '#000'
					}
				});
            </script>
       </div>
    
             
                
       <div id="card_down">
       	  <div class="nav_buttons">
        	<a class="a2" id="btn_scheda1" onclick="change_scheda('scheda1');"><img id="img_scheda1" src="image/homepage/btn/btn_scheda1_over.png" width="183" height="94" />
			</a>
			<a class="a2" id="btn_scheda2" onclick="change_scheda('scheda2');"><img id="img_scheda2" src="image/homepage/btn/btn_scheda2.png" width="186" height="94" />
			</a>
            
			<a class="a2" id="btn_scheda3" onclick="change_scheda('scheda3');"><img id="img_scheda3" src="image/homepage/btn/btn_scheda3.png" width="186" height="94"  />
			</a>
        	
            <a class="a2" id="btn_scheda4" onclick="change_scheda('scheda4');"><img id="img_scheda4" src="image/homepage/btn/btn_scheda4.png" width="186" height="94" />
			</a>
            
        	<a class="a2" id="btn_scheda5" onclick="change_scheda('scheda5');"><img id="img_scheda5" src="image/homepage/btn/btn_scheda5.png" width="183" height="94" />
			</a>
            
          </div>	
       </div>
<br clear="all" />

<div style="clear:both;" />
</body>
</html>
<? if(isset($_GET['tab'])){
		if($_GET['tab']=="iscrizione"){
		?>
        <script>
			document.getElementById("scheda1").style.display = "none";
			document.getElementById("scheda2").style.display = "none";
			document.getElementById("scheda3").style.display = "none";
			document.getElementById("scheda4").style.display = "none";
			document.getElementById("scheda5").style.display = "none";
			document.getElementById("scheda6").style.display = "block";
			overlay();
			
		document.getElementById('div_banner_sx_up').style.display="none";
		document.getElementById('div_banner_sx').style.display="none";
		</script>
        <?		
		}
	}
	if(isset($_GET['tab'])){
		if($_GET['tab']=="provaiscrizione"){
		?>
        <script>
			document.getElementById("scheda1").style.display = "none";
			document.getElementById("scheda2").style.display = "none";
			document.getElementById("scheda3").style.display = "none";
			document.getElementById("scheda4").style.display = "none";
			document.getElementById("scheda5").style.display = "none";
			document.getElementById("scheda7").style.display = "block";
		</script>
        <?		
		}	
	}
    if(isset($_GET['show_login'])){
            ?>
            <script>
                $(document).ready(function() {
                    Open_overlay_login();
                });
            </script>
            <?
    }

	
?>