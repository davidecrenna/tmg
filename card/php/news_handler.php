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
	$card->Delete_not_completed_news();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $card->Show_title()?></title>
<link rel="stylesheet" type="text/css" href="../css/personal_newshandler.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/text.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/icon.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/flight.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/flight-calendar.css"/>

<script type="text/javascript" src="../../common/js/all_jquery_and_tools.min.js"></script>
<script src="../../common/js/ajax.inc.js" type="text/javascript"></script>
<script type="text/javascript" src="../../common/js/json2.js"></script>
<script type="text/javascript" src="../../common/js/card_common.js"></script>
<script type="text/javascript" src="../js/news_handler.js"></script>

</head>
<body>
	 <? $card->Show_input_username(); ?>
	 <div style="display:none">
	 	<? $card->fix_upload(); ?>
     </div>
     <div id='news_loading' class='personal_tab_loading_onpage'><img src='../../image/icone/ajax-loader.gif' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Caricamento in corso..<span></div>
     <div id='news_saved' class='personal_tab_loading_onpage'><img src='../../image/icone/ok.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;'>Informazioni salvate<span></div>
     <div id='error_creating' class='personal_tab_loading_onpage'><img src='../../image/icone/error.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;' id='error_send_text'>Limite news raggiunto.<span></div>
     <div id='error_data_saving' class='personal_tab_loading_onpage'><img src='../../image/icone/error.png' alt='loading' style='width:12px; height:12px; vertical-align:middle;'/> <span style='margin-top:2px;' id='error_send_text'>Errore.<span></div>
     
     <div id="main" style="display:block">
        <p style="position:absolute; top:3px;" class="text16px">Agenda delle news:</p>
         <div style="height:290px; width:870px; border:1px solid #FFF; overflow-y:auto; position:absolute; left:0px; top:40px;">
            <table>
              <thead>
                <tr class="sorterbar">
                  <th class="col-select" id="news-select-header" scope="col">
                        <input type="checkbox" title="seleziona tutte le news." alt="seleziona tutto" onchange="Javascript:Select_all_news_checkbox()"  name="col_news_select" />
                  </th>
                  <th id="data_news_header" class="data_news_header" scope="col">
        Data/periodo
                  </th>
                  <th id="titolo_news_header" class="titolo_news_header" scope="col">
        Titolo news 
                  </th>
                  <th class="descrizione_news_header" scope="col">
        Descrizione
                  </th>
                  <th id="modifica_news_now_header" class="action_news_header" scope="col">
        Modifica
                  </th>
                  <th id="elimina_news_now_header" class="action_news_header" scope="col">
        Elimina
                  </th>
                  <th id="spostasu_news_now_header" class="action_news_header" scope="col">
        
                  </th>
                  <th id="spostagiu_news_now_header" class="action_news_header" scope="col">
        
                  </th>
                </tr>
              </thead>
              <tbody id="riepilogo_news_container">
       <? for($i=0;$i<count($card->news_rows);$i++){
                if(($i%2)==0){
                    $backcolor="#8b8b8b";	
                }else{
                    $backcolor="#838383";
                }
				$descrizione = preg_replace('#<br\s*/?>#i', "\n", $card->news_rows[$i]["descrizione"]);
				if(strlen($descrizione)>45){
					$descrizione = substr($descrizione, 0, 45)."...";
				}
                
                $datacompleta = date('d/m/Y H:m',strtotime($card->news_rows[$i]["data"]));
                $date = $card->getmessagedata($card->news_rows[$i]["data"]);
                
				 echo '<tr class="news_row"  style="background-color:'.$backcolor.';" id="news_row_'.$i.'">
                    	<td class="news_checkbox" scope="row" onclick="Javascript:select_news_row(this,'.$i.')">
                        <input type="checkbox" value="'.$i.'" id="check_news_'.$i.'" class="col-news-select" onclick="Javascript:select_news_row(this,'.$i.')"></input>			
                    </td>
                    <td class="news_data" style="cursor:pointer;">';
                       echo $card->news_rows[$i]["sottotitolo"].'   
					</td>';
                    echo '
                    
                    <td class="news_titolo" style="cursor:pointer;">';
                       echo '<span>'.$card->news_rows[$i]["titolo"].'</span>';
                    echo '
                    </td>
                    
                    <td class="news_descrizione" style="cursor:pointer;">
                        <span>'.$descrizione.'</span>
                    </td>
					<td class="news_action" onclick="Show_news(\''.$i.'\')" style="cursor:pointer;">
                        	    <img src="../../image/icone/pen.png" style="width:15px; height:15px;" alt="modifica news" title="modifica news.">
				   </td>
				   <td class="news_action" onclick="Delete_news(\''.$i.'\')" style="cursor:pointer;">
					  <img src="../../image/icone/edit-delete.png" style="width:15px; height:15px;" alt="elimina news" title="elimina news.">
				   </td>
				   <td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_rows_up(\''.$i.'\',\''.$card->news_rows[$i]["row_num"].'\')"><img src="../../image/icone/icona_arrow_up.png" alt="Sposta contatto su."  title="sposta su." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>  
                    </td>
					
					<td class="news_action" style="cursor:pointer;">
                        <a style="cursor:pointer;" target="_self" onclick="Javascript:Move_rows_down(\''.$i.'\',\''.$card->news_rows[$i]["row_num"].'\')"><img src="../../image/icone/icona_arrow_down.png" alt="Sposta contatto giù." title="sposta giù." style="width:16px; height:16px; vertical-align:middle; cursor:pointer;"/></a>
				   </td>
				   
				   ';
				   
				   echo '
                  </tr>';
            }
				if(count($card->news_rows)==0){
				echo '<tr><td colspan="6">Non sono presenti news/eventi.</td></tr>';
			}?>
				</tbody>
           </table>
      </div>
            
     <div class='personal_button' onclick='Javascript:create_new_news()' style='position:absolute; top:345px; left:340px; width:200px;'>
        <span class='text14px'>CREA NUOVA NEWS</span>
     </div>
     <div class='personal_button' onclick='Javascript:window.top.window.personal_tab_change("interfaccia")' style='position:absolute; top:345px; left:240px; width:100px;'>
        <span class='text14px'>INDIETRO</span>
     </div>
     <div class='personal_button' onclick='Javascript:Delete_selected_news()' style='position:absolute; top:345px; left:719px; width:150px;'>
        <img src="../../image/icone/edit-delete.png" alt="elimina." style='width:20px;' style="position:relative; top:-4px;"/><span class='text14px' style="position:relative; top:-6px;">ELIMINA NEWS</span>
     </div>
   </div>
   
   
   <div id="new" style="display:none">
        <input type='text' class='in_evidenza' id='in_evidenza_subtitle' onclick='in_evidenza_subtitle_click()' value="Inserisci qui la data o il periodo dell'evento/news" onKeyDown="limitText(this,35);" onKeyUp="limitText(this,35);" ><br/>
         
        <input type='text' class='in_evidenza' id='in_evidenza' onclick='in_evidenza_click()' value='Inserisci qui un titolo per la news.' onKeyDown="limitText(this,35);" onKeyUp="limitText(this,35);" ><br/>
         
      	<textarea class='textbox_evidenza' onclick='in_evidenza_desc_click()' id='in_evidenza_desc'>Inserisci qui una breve descrizione.</textarea>
        <br/>
        
        <div id='div_evidenza_file' class='div_evidenza_file'>
       		<img src="../../image/icone/ajax-loader.gif" alt="caricamento in corso" style="width:30px;" />
        </div>
        
        <div class='personal_button' onclick='Javascript:return_riepilogo_news()' style='position:absolute; top:280px; left:10px; width:100px;'>
        	<span class='text14px'>ANNULLA</span>
     	</div>
        <div class='personal_button' onclick='Javascript:go_to_new_news_second_step()' style='position:absolute; top:280px; left:116px; width:100px;'>
        	<span class='text14px'>CONTINUA</span>
     	</div>
   </div>
   
   
   <div id="mod" style="display:none;">
		<p>Modifica la tua news</p>
        <input type='text' class='in_evidenza' id='in_mod_evidenza_subtitle' onclick='in_evidenza_click()' value='' onKeyDown="limitText(this,35);" onKeyUp="limitText(this,35);" ><br/>
        
        <input type='text' class='in_evidenza' id='in_mod_evidenza' value='' onKeyDown="limitText(this,35);" onKeyUp="limitText(this,35);" ><br/>
                 
      	<textarea class='textbox_evidenza' id='in_mod_evidenza_desc'>
		</textarea>
        <br/>
		
        <div id='div_evidenza_mod_file' class='div_evidenza_file'>
       		<img src="../../image/icone/ajax-loader.gif" alt="caricamento in corso" style="width:30px;" />
        </div>
        
        <div class='personal_button' onclick='Javascript:return_riepilogo_news_from_mod()' style='position:absolute; top:280px; left:8px; width:100px;'>
        	<span class='text14px'>ANNULLA</span>
     	</div>
        <div class='personal_button' onclick='Javascript:go_to_mod_news_second_step()' style='position:absolute; top:280px; left:116px; width:120px;'>
        	<span class='text14px'>CONTINUA</span>
     	</div>
   </div>
   
   <div id="new2" style="display:none">
          	<!--<p><input type="checkbox" id="data_no_posticipa" onchange="change_check_no_posticipa(this);" /> Voglio che la news venga pubblicata subito.</p>-->
       <div class="calendario_div" id="calendario_div">
       		  <p>Scegli il giorno e i gruppi della tua mailing list a cui vuoi che sia inviata una notifica e-mail quando la news verrà pubblicata. Se non selezioni nessun gruppo la news non verrà inviata ma solo pubblicata(clicca per aggiungere e cambiare data)</p>
              <input type="date" id="data_posticipa" name="data_posticipa" value="Today" />
      </div>
        <div class="gruppi_div" id="gruppi_div">
                <table >
                  <thead>
                    <tr class="sorterbar">
                      <th id="nomegruppo_mailing_header" class="nomegruppo_mailing_header" scope="col">
            Gruppi mailing list
                      </th>
                      
                    <th id="nomegruppo_mailing_arrow_header" class="nomegruppo_mailing_arrow_header" scope="col">
                      </th>
                      </tr>
                  </thead>
                  <tbody id="mailing_list_groups">
                  <tr>
                  <td>
                	<img src="../../image/icone/ajax-loader.gif" alt="caricamento in corso" style="width:20px;" /></td>
                    </tr>
            	</tbody>
            </table>
            </div>
            <div class="gruppi_select_div" id="gruppi_select_div">
                <table id="table_selected_group">
                  <thead>
                  </tr>
                    
                    <tr class="sorterbar">
                    <th id="nomegruppo_mailing_arrow_header" class="nomegruppo_mailing_arrow_header" scope="col">
                      </th>
                      <th id="nomegruppo_mailing_header" class="nomegruppo_mailing_header" scope="col">
            Gruppi selezionati
                      </th>
                    
                  </thead>
                  
                  <tbody id="table_selected_container">
                    </tbody>
                </table>
            </div>
            <div class="opt_invio_div" id="opt_invio_div">
            	<input type="checkbox" id="check_alternative_address" />Invia la news anche agli indirizzi secondari (Se un contatto possiede più di un indirizzo email)
            </div>
        
        
        
        <div class='personal_button' onclick='Javascript:return_riepilogo_news()' style='position:absolute; top:350px; left:0px; width:100px;'>
        	<span class='text14px'>ANNULLA</span>
     	</div>
        <div class='personal_button' onclick='Javascript:return_to_new_news_first_step()' style='position:absolute; top:350px; left:106px; width:100px;'>
        	<span class='text14px'>INDIETRO</span>
     	</div>
        <div class='personal_button' onclick='Javascript:finish_new_return_main()' style='position:absolute; top:350px; left:212px; width:100px;'>
        	<span class='text14px'>FINE</span>
     	</div>
   </div>
   
   
   <div id="mod2" style="display:none">
       
       <div class="calendario_div" id="mod_calendario_div">
            <p>Scegli il giorno e i gruppi della tua mailing list a cui vuoi che sia inviata una notifica e-mail quando la news verrà pubblicata. Se non selezioni nessun gruppo la news non verrà inviata ma solo pubblicata(clicca per aggiungere e cambiare data)</p>
              <input type="date" id="mod_data_posticipa" name="data_posticipa" value="Today" />
      </div>
                
                <script>
                   $.tools.dateinput.localize("it", {
                      months:'Gennaio,Febbraio,Marzo,Aprile,Maggio,Giugno,Luglio,Agosto,Settembre,Ottobre,Novembre,Dicembre',
                      shortMonths:  'Gen,Feb,Mar,Apr,Mag,Giu,Lug,Ago,Set,Ott,Nov,Dic',
                      days:        'Domenica,Lunedì,Martedì,Mercoledì,Giovedì,Venerdì,Sabato',
                      shortDays:    'Dom,Lun,Mar,Mer,Gio,Ven,Sab'
                    });
					
                    $("#mod_data_posticipa").dateinput( {
                        lang: "it",
                        format: 'dd mmmm yyyy',
                        min: -1,
                    }).data("dateinput").setValue(0);
                    $("#mod_data_posticipa").bind("onShow onHide", function()  {
						$(this).parent().toggleClass("active");
					});
					 
                </script>
                
           <div class="gruppi_mod_div" id="gruppi_div">
                <table >
                  <thead>
                    <tr class="sorterbar">
                      <th id="nomegruppo_mailing_header" class="nomegruppo_mailing_header" scope="col">
            Gruppi mailing list
                      </th>
                    	<th id="nomegruppo_mailing_arrow_header" class="nomegruppo_mailing_arrow_header" scope="col">
                     </th>
                      </tr>
                  </thead>
                  
                  <tbody id="mod_mailing_list_groups">
                  <tr><td>
                	<img src="../../image/icone/ajax-loader.gif" alt="caricamento in corso" style="width:20px;" /></td>
                    </tr>
            	</tbody>
            </table>
            </div>
            <div class="gruppi_mod_select_div" id="mod_gruppi_select_div">
                <table id="table_selected_group">
                  <thead>
                  	</tr>
                    
                    <tr class="sorterbar">
                    <th id="nomegruppo_mailing_arrow_header" class="nomegruppo_mailing_arrow_header" scope="col">
                      </th>
                      <th id="nomegruppo_mailing_header" class="nomegruppo_mailing_header" scope="col">
            Gruppi selezionati
                      </th>
                    </tr>
                  </thead>
                  
                  <tbody id="mod_table_selected_container">
                  <tr><td>
                  	<img src="../../image/icone/ajax-loader.gif" alt="caricamento in corso" style="width:20px;" /></td>
                    </tr>
                  </tbody>
                </table>
            </div>
        
        <div class='personal_button' onclick='Javascript:return_riepilogo_news()' style='position:absolute; top:350px; left:0px; width:100px;'>
        	<span class='text14px'>ANNULLA</span>
     	</div>
        <div class='personal_button' onclick='Javascript:return_to_mod_news_first_step()' style='position:absolute; top:350px; left:106px; width:100px;'>
        	<span class='text14px'>INDIETRO</span>
     	</div>
        <div class='personal_button' onclick='Javascript:Finish_mod_return_main()' style='position:absolute; top:350px; left:212px; width:100px;'>
        	<span class='text14px'>FINE</span>
     	</div>
   </div>
   
    <input type="hidden" id="new_news_id" />
    <input type='hidden' id='showed_news_id'/>
    <input type='hidden' id='id_news_now'/>
</body>
</html>