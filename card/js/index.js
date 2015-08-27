$(function() {
	//$("input[title]").tooltip({ effect: 'slide'});
	$(".explainer[title]").tooltip({ effect: 'slide'});
	$("img[rel]").overlay({mask: '#523030', effect: 'apple'});
	
	
/*	$('.show_news_container').jScrollPane(
	{
			verticalDragMinHeight: 50,
			verticalDragMaxHeight: 50,
			horizontalDragMinWidth: 0,
			horizontalDragMaxWidth: 0
		});*/
/*	$('.show_social_container').jScrollPane(
	{
			verticalDragMinHeight: 50,
			verticalDragMaxHeight: 50,
			horizontalDragMinWidth: 0,
			horizontalDragMaxWidth: 0
		});*/
	 
});


//------------------------------------------------------------------------------------------------------------
//PERSONAL TAB IMPOSTAZIONI START
//------------------------------------------------------------------------------------------------------------
function Enter_on_Personal_password_save(e) {
      // IE
      var tasto;
      if(window.event){
        tasto = e.keyCode;
      }
      // Netscape/Firefox/Opera
      else if(e.which){
        tasto = e.which;
      }
      if (tasto == 13) {
        Personal_password_save()
   }
}
function Personal_password_save(){
	var old_pass=$('#input_pass_corrente').val();
	var new_pass= $('#input_nuova_pass').val();
	var confirm_pass=$('#input_confirm_nuova_pass').val();
	var username = $("#in_username").val();
	
	if((!Ctrl_old_pass())|| (!Ctrl_confirm_pass())){
		$('#personal_password_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Devi compilare tutti i campi.');
		return false;
	}else if(!CtrlPass()){
		return false;	
	}else if((!Ctrl_pass_match())){
		$('#personal_password_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Le password devono coincidere.');	
		return false;	
	}
	
	
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Personal_password_save: "true", 
				Username: username,
				old_pass: old_pass,
				new_pass: new_pass
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#personal_password_ajax_panel').html('<img src="../../image/icone/ajax_small.gif"  style="vertical-align:middle; padding-right:4px;" alt="Loading..." /> Attendere. L\' operazione potrebbe richiedere qualche minuto.');
	  },
	  success:function(data){
		  var obj = jQuery.parseJSON(data);
		if(obj.result!="true"){
			$('#personal_password_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Problema nel salvataggio password. Controlla i campi inseriti e riprova');
			
			var t=setTimeout("$('#personal_password_ajax_panel').html('');",5000);
		}else{
			$('#personal_password_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.<br/>Un messaggio di conferma contenente la nuova Password è stata inviata all\'indirizzo: '+obj.email+'.<br/>Puoi accedere alle tue email dal MENU della PERSONAL AREA<br/>LA PAGINA VERRA\' RICARICATA E DOVRAI EFFETTUARE NUOVAMENTE L\'ACCESSO.');
			
			$("#input_pass_corrente").val("");
			$("#input_nuova_pass").val("");
			$('#input_confirm_nuova_pass').val("");
			var t=setTimeout("Logout(); return_to_the_card();",8000);
			
		}
	 },
	  error:function(){
		// failed request; give feedback to user
		$('#personal_password_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}


function Ctrl_old_pass(){
	var pass=$('#input_pass_corrente').val();
	if (pass==null || pass=="")
   {
	    $("#input_pass_corrente").removeClass("personal_input_valid");
	  	$("#input_pass_corrente").addClass("personal_input_invalid");	
		return false;
   }
   else{
	    $("#input_pass_corrente").removeClass("personal_input_invalid");
		$("#input_pass_corrente").addClass("personal_input_valid");
		return true;		   
   }
}
function Ctrl_confirm_pass(){
	var pass=$('#input_confirm_nuova_pass').val();
	if (pass==null || pass=="")
   {
	    $("#input_confirm_nuova_pass").removeClass("personal_input_valid");
		$("#input_confirm_nuova_pass").addClass("personal_input_invalid");
		return false;
   }
   else{
	    $("#input_confirm_nuova_pass").removeClass("personal_input_invalid");
		$("#input_confirm_nuova_pass").addClass("personal_input_valid");
		return true;		   
   }
}
function CtrlPass(){
	var pass=$('#input_nuova_pass').val();
	if (pass==null || pass=="" || (validatePwd()==false))
   {
	   $("#input_nuova_pass").removeClass("personal_input_valid");
	   $("#input_nuova_pass").addClass("personal_input_invalid");
		return false;
   }
   else{
	    $("#input_nuova_pass").removeClass("personal_input_invalid");
	   	$("#input_nuova_pass").addClass("personal_input_valid");
		return true;		   
   }
}
function Ctrl_pass_match(){
	var pass=$('#input_nuova_pass').val();
	var confirm_pass=$('#input_confirm_nuova_pass').val();
	if(pass!=confirm_pass){
	    $("#input_confirm_nuova_pass").removeClass("input_valid");
		$("#input_confirm_nuova_pass").addClass("input_invalid");
		return false;
   }
   else{
	    $("#input_confirm_nuova_pass").removeClass("input_invalid");
		$("#input_confirm_nuova_pass").addClass("input_valid");
		return true;		   
   }
}

function validatePwd() {
	//Initialise variables
	var errorMsg = "";
	var space  = " ";
	var fieldvalue  = $("#input_nuova_pass").val(); 
	var fieldlength = fieldvalue.length; 
	
	//It must not contain a space
	if (fieldvalue.indexOf(space) > -1) {
		 errorMsg += "La password non deve contenere spazi.</br>";
	}     
	//It must contain at least one number character
	if (!(fieldvalue.match(/\d/))) {
		 errorMsg += "La password deve contenere almeno un numero.</br>";
	}
	//It must be at least 7 characters long.
	if ((!(fieldlength >= 6))||(!(fieldlength <= 20))) {
		 errorMsg += "La password deve avere una lunghezza minima di 6 caratteri ed una lunghezza massima di 20.</br>";
	}
	
	
	var not_allowed = "\',.\"";
	var car_not_allowed = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (not_allowed.indexOf(fieldvalue.charAt(i)) != -1) {
			car_not_allowed = 1;
		}
	}
	
	if(car_not_allowed==1){
		errorMsg += "La password contiene caratteri non validi ("+not_allowed+").</br>";
	}

	var uppercase = 0;
	for (var i = 0; i < fieldlength; i++) {
		if(!ctrl_is_num(fieldvalue.charAt(i))){
			if (fieldvalue.charAt(i) == fieldvalue.charAt(i).toUpperCase()) {
				uppercase = 1;
			}
		}
	}
	if(uppercase==0){
		errorMsg += "La password deve contenere una lettera maiuscola.</br>";
	}

	//If there is aproblem with the form then display an error
     if (errorMsg != ""){
		  $('#personal_password_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" />'+errorMsg);
          return false;
     }
     return true;

}

//------------------------------------------------------------------------------------------------------------
//PERSONAL TAB IMPOSTAZIONI END
//------------------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------------------
//PERSONAL TAB DELETE START
//------------------------------------------------------------------------------------------------------------

function Set_account_deleted_now(){
	document.getElementById("impostazioni_loading").style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("impostazioni_loading").style.display="none";
			Show_Setting_Saved('impostazioni_saved');
			document.getElementById("personal_tab_center_delete_content").innerHTML = ajaxRequest.responseText;
		}
	}
	confirmed = window.confirm("Attenzione il tuo account verrà impostato per essere eliminato entro 8 giorni. Procedere?");
	if (confirmed)
	{
		var username = document.getElementById("in_username").value;
		var params="Set_account_deleted_now="+true+"&Username="+username;
		
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		document.getElementById('messaggi_loading').style.display = "none";
		return false;
	}
}

function Set_account_deleted(){
	document.getElementById("delete_loading").style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("delete_loading").style.display="none";
			Show_Setting_Saved('delete_saved');
			document.getElementById("personal_tab_center_delete_content").innerHTML = ajaxRequest.responseText;
		}
	}
	confirmed = window.confirm("Attenzione il tuo account verrà impostato per essere eliminato. Procedere?");
	if (confirmed)
	{
		var username = document.getElementById("in_username").value;
		var params="Set_account_deleted="+true+"&Username="+username;
		
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		document.getElementById('messaggi_loading').style.display = "none";
		return false;
	}
}


function Unset_account_deleted(){
	document.getElementById("delete_loading").style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("delete_loading").style.display="none";
			Show_Setting_Saved('delete_saved');
			document.getElementById("personal_tab_center_delete_content").innerHTML = ajaxRequest.responseText;
		}
	}
	confirmed = window.confirm("Vuoi annullare l'eliminazione del tuo account?");
	if (confirmed)
	{
		var username = document.getElementById("in_username").value;
		var params="Unset_account_deleted="+true+"&Username="+username;
		
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		document.getElementById('messaggi_loading').style.display = "none";
		return false;
	}
}























function PressioneInvioLogin(e) {
      // IE
      var tasto;
      if(window.event){
        tasto = e.keyCode;
      }
      // Netscape/Firefox/Opera
      else if(e.which){
        tasto = e.which;
      }
      if (tasto == 13) {
        Personal_form_submit("../");
   }
}
function PressioneInvioContact(e){
	// IE
	var tasto;
	if(window.event){
	  tasto = e.keyCode;
	}
	// Netscape/Firefox/Opera
	else if(e.which){
	  tasto = e.which;
	}
	if (tasto == 13) {
	  Add_contact_element()	
   }
}
function PressioneInvioRenameContact(e,index){
		// IE
	var tasto;
	if(window.event){
	  tasto = e.keyCode;
	}
	// Netscape/Firefox/Opera
	else if(e.which){
	  tasto = e.which;
	}
	if (tasto == 13) {
	  Rename_contact_row(index)	
   }
}

String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}
function email_pressione_invio(e){
	  // IE
      var tasto;
      if(window.event){
        tasto = e.keyCode;
      }
      // Netscape/Firefox/Opera
      else if(e.which){
        tasto = e.which;
      }
      if (tasto == 13) {
       	submit_email_login()
   }
}
String.prototype.trim = function () {
    return this.replace(/^\s*/, "").replace(/\s*$/, "");
}
//PERSONAL AREA
function personal_tab_change(tab){
	if(tab=="interfaccia"){
		Set_progress_size_bar();
		Aggiorna_news();
		Aggiorna_professione();	
		Aggiorna_main_foto();
		Aggiorna_slide_foto();
		Aggiorna_nameshowed();
		Aggiorna_social();
	}
	if(tab=="promoter"){
		Aggiorna_promoter();	
	}
	if(tab=="messaggi"){
		Show_msg_page();	
	}
	if(tab=="contatti"){
		Refresh_contact_rows(false);	
	}
	if(tab=="social"){
		Refresh_social_rows(false);	
	}
	if(tab=="mailing"){
		Set_mailing_contacts_old();
	}
	
	var prev_tab = document.getElementById("personal_tab_showed").value;
	
	document.getElementById("tabdiv_btn_card_personal_"+prev_tab).style.display ="none";
	//document.getElementById("tabdiv_"+tab).style.display ="block";
	
	$("#tabdiv_btn_card_personal_"+tab).fadeIn(450);
	var username=document.getElementById("in_username").value;
	
	$("#personal_tab_down").fadeIn(400);
	
	document.getElementById("personal_tab_showed").value= tab;
	document.getElementById('menu_link_impostazioni').style.background ="#6B6B6B";
	document.getElementById('menu_link_promoter').style.background ="#6B6B6B";
	document.getElementById('menu_link_mailing').style.background ="#6B6B6B";
	document.getElementById('menu_link_email').style.background ="#6B6B6B";
	if(('menu_link_'+tab=='menu_link_interfaccia')||('menu_link_'+tab=='menu_link_promoter')||('menu_link_'+tab=='menu_link_impostazioni')||('menu_link_'+tab=='menu_link_mailing')||('menu_link_'+tab=='menu_link_email')){
		document.getElementById('menu_link_interfaccia').style.background ="#6B6B6B"
		document.getElementById('menu_link_'+tab).style.background ="#A8A8A8";
	}
}
function show_submenu(id){
	document.getElementById("sub_riepilogo").style.display = "none";
	if(id!=null)
		document.getElementById("sub_"+id).style.display = "block";	
}
function personal_photo_tab_change(tab){
	var prev_tab = document.getElementById("personal_photo_tab_showed").value;
	document.getElementById(prev_tab).style.display ="none";
	document.getElementById('btn_card_personal_'+tab).style.display ="block";
	document.getElementById("personal_photo_tab_showed").value="btn_card_personal_"+tab;
}
function GeneratePersonalMenu(){
	(function($){
		//cache nav
		var nav = $("#topNav");
		//add indicator and hovers to submenu parents
		nav.find("li").each(function() {
			if ($(this).find("ul").length > 0) {
				$("<span>").appendTo($(this).children(":first"));
				//show subnav on hover
				$(this).mouseenter(function() {
					$(this).find("ul").stop(true, true).slideDown();
				});
				//hide submenus on exit
				$(this).mouseleave(function() {
					$(this).find("ul").stop(true, true).slideUp();
				});
			}
		});
	})(jQuery);
	
}


//--------------------------------------------------------------------------------------------------------
//PERSONAL TAB CONTACT START
//--------------------------------------------------------------------------------------------------------
function contact_link_type_change(type){
	switch(type){
		case 'tel':	
			$("#in_contact_value").val("Inserisci il numero di telefono.");
			return;
		break;
		case 'cell':	
			$("#in_contact_value").val("Inserisci il numero di cellulare.");
			return;
		break;
		case 'fax':	
			$("#in_contact_value").val("Inserisci il numero di fax.)");
			return;
		break;
		case 'mail':	
			$("#in_contact_value").val("Inserisci l'indirizzo e-mail.");
			return;
		break;
		case 'indirizzo':
			$("#in_contact_value").val("Inserisci l'indirizzo.");
			return;
		break;
	}
}
function Delete_contact_element(index){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Delete_contact_row: "true", 
				Username: username, 
				index: index 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#contact_show_div').html(data);
		$('#contact_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
		$("#in_contact_value").val("");
		var t=setTimeout("$('#contact_ajax_panel').html('');",3000);
		Refresh_contact_rows(false);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}
function Refresh_contact_rows(fromadd){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Refresh_contact_row: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#personal_contact_save_rename_container').html('');
		$('#contact_show_div').html(data);
		$('#contact_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
		var t=setTimeout("$('#contact_ajax_panel').html('');",3000);
		if(fromadd){
			var $t = $('#contact_show_div');
			$t.animate({"scrollTop": $('#contact_show_div')[0].scrollHeight}, "slow");
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}
function Rename_contact_row(index){
	var value = $("#in_mod_contact_value").val();
	var type = $("#in_mod_contact_link_type").val();
	var error= 0;
	switch(type){
		case "tel": case "cell": case "fax":
			if(value!= ""){
				if(!is_num(value)){
					$("#in_mod_contact_value").addClass("social_error_class");
					$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Inserisci un numero.');
					error = 1;
				}else{
					$("#in_mod_contact_value").removeClass("social_error_class");	
				}
			}else{
				$("#in_mod_contact_value").addClass("social_error_class");
				$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
				error = 1;	
			}
			break;
		case "mail":
		if(value!= ""){
				if(!isEmail(value)){
					$("#in_mod_contact_value").addClass("social_error_class");
					$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Inserisci un indirizzo e-mail valido.');
					error = 1;
				}else{
					$("#in_mod_contact_value").removeClass("social_error_class");	
				}
			}else{
				$("#in_mod_contact_value").addClass("social_error_class");
				$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
				error = 1;	
			}
			break;
		
		default:
			if(value!= ""){
				$("#in_mod_contact_value").removeClass("social_error_class");
			}else{
				$("#in_mod_contact_value").addClass("social_error_class");
				$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
				return false;	
			}
			
			break;	
	}
	
	if(error==1){
		return false;
	}
	
	var value = $("#in_mod_contact_value").val();
	var type = $("#in_mod_contact_link_type").val();
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Update_contact_element: "true", 
				Username: username, 
				value: value ,
				type: type,
				index: index },
	  dataType: "html",
	  beforeSend:function(){
		$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#personal_contact_save_rename_container').html('');
		Refresh_contact_rows(false);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Load_rename_contact_row(value,type,index){
	
	var contact_elem_num = $('#contact_element_num').val();
	var i=0;
	for(i=0;i<contact_elem_num;i++){
		$('#contact_value_container_'+i).prop("onclick", null);
		$('#contact_modifica_img_'+i).prop("onclick", null);
	}
	
	var html='<select name="in_mod_contact_link_type" id="in_mod_contact_link_type" class="mod_select_social_link_type"><option value="tel" selected="selected">Tel</option><option value="cell">Cell</option><option value="fax">Fax</option><option value="mail">E-mail</option><option value="indirizzo">Indirizzo</option><input type="text" class="input_social" id="in_mod_contact_value" name="in_mod_contact_value" value="'+value+'"  onkeydown="PressioneInvioRenameContact(event,'+index+');  limitText(this,60);" required/>';
	
	
	$('#contact_value_container_'+index).html(html);
	$('#in_mod_contact_link_type').val(type);
	
	
	$('#personal_contact_save_rename_container').html("<div class='personal_button social_button green_button' onclick='Rename_contact_row("+index+")'><span class='text14px'>SALVA</span></div><div class='personal_button social_button' onclick='Refresh_contact_rows(false)'><span class='text14px'>ANNULLA</span></div>");
	
	$('#contact_modifica_'+index).html('<img src="../image/icone/save.png" alt="Salva elemento." title="Salva elemento." style="width:16px; height:16px; vertical-align:middle;cursor:pointer;" onclick="Rename_contact_row()" />');
}

function Add_contact_element(){
	var form = $("#contact_form");
	jQuery.validator.addMethod("contactnum", function(value, element) {
	  return this.optional(element) || is_num(value);
	}, "Devi inserire un numero.");
	form.validate({
		rules: {
			in_contact_value: {
			  required: true,
			   contactnum: {
				depends: function(element) {
				  return $("#contact_link_type option:selected").val()=="tel"|| $("#contact_link_type option:selected").val()=="cell"|| $("#contact_link_type option:selected").val()=="fax";
				}
			  },
			  email: {
				depends: function(element) {
				  return $("#contact_link_type option:selected").val()=="mail";
				}
			  }
			}
		  },
		
		errorClass: "social_error_class",
		messages: {
			in_contact_value: {
      			required: "Campo obbligatorio.",
				email: "Inserisci email valida."
   			}
		}
	  });
	var type = $("#contact_link_type").val();
	var value = $("#in_contact_value").val();
		
	if(form.valid()){
		var value = $("#in_contact_value").val();
		var username = $("#in_username").val();
		$.ajax({
		  type: 'POST',
		  url: "../card/php/card_handler.php",
		  data: { Add_contact_element: "true", 
					Username: username, 
					value: value ,
					type: type },
		  dataType: "html",
		  beforeSend:function(){
			$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
		  },
		  success:function(data){
			var obj = jQuery.parseJSON(data);
			if(obj.result!="true"){
				$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile inserire più di 10 elementi.');
				
				var t=setTimeout("$('#contact_ajax_panel').html('');",5000);
			}else{
				$('#contact_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
				$("#in_contact_value").val("");
				Refresh_contact_rows(true);
			}
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
	
}



//--------------------------------------------------------------------------------------------------------
//PERSONAL TAB CONTACT START
//--------------------------------------------------------------------------------------------------------



function Move_contact_up(index,row_num){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Move_contact_up: "true", 
				Username: username, 
				index: index,
				row_num: row_num
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		var obj = jQuery.parseJSON(data);
		if(obj.result!="true"){
			$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile spostare il contatto.');
			var t=setTimeout("$('#contact_ajax_panel').html('');",5000);
		}else{
			$('#contact_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
			Refresh_contact_rows(false);
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Move_contact_down(index,row_num){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Move_contact_down: "true", 
				Username: username, 
				index: index,
				row_num: row_num
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#contact_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		var obj = jQuery.parseJSON(data);
		if(obj.result!="true"){
			$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile spostare il contatto.');
			var t=setTimeout("$('#contact_ajax_panel').html('');",5000);
		}else{
			$('#contact_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
			Refresh_contact_rows(false);
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#contact_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function social_link_type_change(type){
	switch(type){
		case 'web':	
			$("#in_social_value").val("Inserisci l'indirizzo del sito internet.");
			return;
		break;
		case 'vidyt':	
			$("#in_social_value").val("Inserisci l'indirizzo del video youtube.");
			return;
		break;
		case 'accfb':	
			$("#in_social_value").val("es: mariorossi (trova NOME UTENTE nelle impostazioni.)");
			return;
		break;
		case 'accsk':	
			$("#in_social_value").val("Nome skype che usi per connetterti.");
			return;
		break;
		case 'acctw':
			$("#in_social_value").val("es: mariorossi (trova NOME UTENTE nelle impostazioni.)");
			return;
		break;
		case 'accyt':	
			$("#in_social_value").val("es: mariorossi (trova NOME UTENTE nelle impostazioni.)");
			return;
		break;
	}
}


function PressioneInvioSocial(e) {
      // IE
      var tasto;
      if(window.event){
        tasto = e.keyCode;
      }
      // Netscape/Firefox/Opera
      else if(e.which){
        tasto = e.which;
      }
      if (tasto == 13) {
        Add_social_element()
   }
}

function Add_social_element(){
	var form = $("#social_form");
	form.validate({
		rules: {
			in_social_value: {
			  required: true,
			  url: {
				depends: function(element) {
				  return $("#social_link_type option:selected").val()=="web"|| $("#social_link_type option:selected").val()=="vidyt";
				}
			  }
			},
			in_social_title: {
			  required: true,
			  minlength: 3,
			  maxlength: 35
			}
		  },
		
		errorClass: "social_error_class",
		messages: {
			in_social_value: {
      			required: "Campo obbligatorio.",
				url: "Inserisci un'indirizzo valido."
   			},
			in_social_title: {
      			required: "Campo obbligatorio.",
      			minlength: "Minimo {0} caratteri.",
				maxlength: "Massimo {0} caratteri."
   			}
		}
	  });
		var type = $("#social_link_type").val();
		var value = $("#in_social_value").val();
		switch(type){
			case "web":
				if(value.indexOf("http://") == -1 && value.indexOf("https://") == -1){	
					$("#in_social_value").val("http://"+value);
				}
			break;	
		}
	if(form.valid()){
		switch(type){
			case "accfb":
				 $("#in_social_value").val("https://www.facebook.com/"+value);
			break;
			case "accsk":
				 $("#in_social_value").val("skype:"+value+"?call");
			break;
			case "acctw":
				 $("#in_social_value").val("https://twitter.com/#!/"+value);
			break;	
			case "accyt":
				 $("#in_social_value").val("http://www.youtube.com/user/"+value);
			break;	
		}
		var value = $("#in_social_value").val();
		var title = $("#in_social_title").val();
		var username = $("#in_username").val();
		$.ajax({
		  type: 'POST',
		  url: "../card/php/card_handler.php",
		  data: { Add_social_element: "true", 
					Username: username, 
					value: value ,
					type: type,
					title: title },
		  dataType: "html",
		  beforeSend:function(){
			$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
		  },
		  success:function(data){
			var obj = jQuery.parseJSON(data);
			if(obj.result!="true"){
				$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile inserire più di 10 elementi.');
				
				var t=setTimeout("$('#social_ajax_panel').html('');",5000);
			}else{
				$('#social_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
				$("#in_social_value").val("");
				$("#in_social_title").val("");
				Refresh_social_rows(true);
			}
		  },
		  error:function(){
			// failed request; give feedback to user
			$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		  }
		});
	}
}

function Delete_social_element(index){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Delete_social_element: "true", 
				Username: username, 
				index: index 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#social_show_div').html(data);
		$('#social_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
		$("#in_social_value").val("");
		$("#in_social_title").val("");
		var t=setTimeout("$('#social_ajax_panel').html('');",3000);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Move_social_up(index,row_num){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Move_social_up: "true", 
				Username: username, 
				index: index,
				row_num: row_num
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		var obj = jQuery.parseJSON(data);
		if(obj.result!="true"){
			$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile spostare il contatto.');
			var t=setTimeout("$('#social_ajax_panel').html('');",5000);
		}else{
			$('#social_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
			Refresh_social_rows(false);
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Move_social_down(index,row_num){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Move_social_down: "true", 
				Username: username, 
				index: index,
				row_num: row_num
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		var obj = jQuery.parseJSON(data);
		if(obj.result!="true"){
			$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Non è possibile spostare il contatto.');
			var t=setTimeout("$('#social_ajax_panel').html('');",5000);
		}else{
			$('#social_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
			Refresh_social_rows(false);
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Load_rename_social_row(title,value,type,index){
	
	var social_elem_num = $('#social_element_num').val();
	var i=0;
	for(i=0;i<social_elem_num;i++){
		$('#social_title_container_'+i).prop("onclick", null);
		$('#social_modifica_img_'+i).prop("onclick", null);
	}
	
	var html='<select name="in_mod_social_link_type" id="in_mod_social_link_type" class="mod_select_social_link_type"><option value="web" selected="selected">Sito</option><option value="vidyt">Vid. Yt</option><option value="accfb">Acc. Fb</option><option value="accsk">Acc. Sk</option><option value="acctw">Acc. Tw</option><option value="accyt">Acc. Yt</option></select>';
	
	html+='<input type="text" id="in_mod_social_title" name="in_mod_social_title" class="personal_area_mod_social" value="'+title+'" onkeydown="PressioneInvioRenameSocial(event,'+index+'); limitText(this,35);" required/>';
	
	$('#social_title_container_'+index).html(html);
	$('#in_mod_social_link_type').val(type);
	
	$('#social_value_container_'+index).prop("onclick", null);
	
	$('#social_value_container_'+index).html('<input type="text" class="personal_area_mod_social" id="in_mod_social_value" name="in_mod_social_value" value="'+value+'"  onkeydown="PressioneInvioRenameSocial(event,'+index+')"  required/>');
	
	$('#personal_social_save_rename_container').html("<div class='personal_button social_button green_button' onclick='Rename_social_row("+index+")'><span class='text14px'>SALVA</span></div><div class='personal_button social_button' onclick='Refresh_social_rows(false)'><span class='text14px'>ANNULLA</span></div>");
	
	$('#social_modifica_'+index).html('<img src="../image/icone/save.png" alt="Salva elemento." title="Salva elemento." style="width:16px; height:16px; vertical-align:middle;cursor:pointer;" onclick="Rename_social_row()" />');
}

function Rename_social_row(index){
	var value = $("#in_mod_social_value").val();
	var title = $("#in_mod_social_title").val();
	var type = $("#in_mod_social_link_type").val();
	var error= 0;
	switch(type){
		case "web": case "vidyt":
			if(value!= ""){
				if(value.indexOf("http://") == -1 && value.indexOf("https://") == -1){	
					$("#in_mod_social_value").val("http://"+value);
				}
				if(!isUrlValid(value)){
					$("#in_mod_social_value").addClass("social_error_class");
					$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Inserisci un indirizzo valido.');
					error = 1;
				}else{
					$("#in_mod_social_value").removeClass("social_error_class");	
				}
			}else{
				$("#in_mod_social_value").addClass("social_error_class");
				$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
				error = 1;	
			}
			break;
		
		default:
			if(value!= ""){
				$("#in_mod_social_value").removeClass("social_error_class");
			}else{
				$("#in_mod_social_value").addClass("social_error_class");
				$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
				return false;	
			}
			
			break;	
	}
	
	if(title!=""){
		$("#in_mod_social_title").removeClass("social_error_class");
	}else{
		$("#in_mod_social_title").addClass("social_error_class");
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Campi obbligatori.');
		error = 1;	
	}
	
	if(error==1){
		return false;
	}else{
		$('#social_ajax_panel').html('');
		switch(type){
			case "accfb":
				 if(value.indexOf("https://www.facebook.com/") == -1){	
				 	$("#in_mod_social_value").val("https://www.facebook.com/"+value);
				}
			break;
			case "accsk":
				if(value.indexOf("skype:") == -1){	
					$("#in_mod_social_value").val("skype:"+value+"?call");
				}
			break;
			case "acctw":
				if(value.indexOf("https://twitter.com/#!/") == -1){	
				 	$("#in_mod_social_value").val("https://twitter.com/#!/"+value);
				}
			break;	
			case "accyt":
				if(value.indexOf("http://www.youtube.com/user/") == -1){
				 	$("#in_mod_social_value").val("http://www.youtube.com/user/"+value);
				}
			break;	
		}	
	}
	var value = $("#in_mod_social_value").val();
	var title = $("#in_mod_social_title").val();
	var type = $("#in_mod_social_link_type").val();
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Update_social_element: "true", 
				Username: username, 
				value: value ,
				type: type,
				title: title,
				index: index },
	  dataType: "html",
	  beforeSend:function(){
		$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#personal_social_save_rename_container').html('');
		Refresh_social_rows(false);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}


function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}


function PressioneInvioRenameSocial(e,index){
	// IE
	var tasto;
	if(window.event){
	  tasto = e.keyCode;
	}
	// Netscape/Firefox/Opera
	else if(e.which){
	  tasto = e.which;
	}
	if (tasto == 13) {
	  Rename_social_row(index)	
   }
}

function Refresh_social_rows(fromadd){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Refresh_social_rows: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#social_ajax_panel').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#personal_social_save_rename_container').html('');
		$('#social_show_div').html(data);
		$('#social_ajax_panel').html('<img src="../../image/icone/ok.png" style="width: 23px; height:18px;" alt="Informazioni salvate." /> Informazioni Salvate.');
		var t=setTimeout("$('#social_ajax_panel').html('');",3000);
		if(fromadd){
			var $t = $('#social_show_div');
			$t.animate({"scrollTop": $('#social_show_div')[0].scrollHeight}, "slow");
		}
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Personal_login_request_sfida(prepath){
	var personal_login_user = $("#personal_login_user").val();
	$.ajax({
	  type: 'POST',
	  url: prepath+"card/php/card_handler.php",
	  data: { __user: "true", 
				user: personal_login_user
			 },
	  dataType: "html",
	  beforeSend:function(){
		//$('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		  $('#copia_sfida').val(data.trim());
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}

function Personal_form_submit(prepath){
    var sfida = $("#copia_sfida").val();
    var pwd = $("#personal_login_pwd").val();
    var pwd = hex_sha512(pwd);
    var login_user = $("#personal_login_user").val();

    $('#personal_login_pwd').val("");
    $("#personal_login_user").val("");
    $.ajax({
        type: 'POST',
        url: prepath+"card/php/card_handler.php",
        data: { __submit: "true",
            user: login_user,
            pwd: pwd,
            copia_sfida: sfida
        },
        dataType: "html",
        beforeSend:function(){
            $('#ajax_login').html('<img src="'+prepath+'image/icone/ajax_small.gif" alt="Loading..." />');
        },
        success:function(data){
            var obj = jQuery.parseJSON(data);
            if(obj.result=="true"){
                var username=$("#in_username").val();
                if(obj.user == username){
                    Load_personal_area("interfaccia");
                    Aggiorna_menu_avatar();

                }else{
                    location.href=prepath+obj.user+'/index.php/personal_area';
                }
            }else{
                $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Ricontrolla i tuoi dati.<br/> <a target="_self" onclick="Javascript:show_recupero_password()" style="cursor:pointer;">Hai dimenticato la password?</a>');
            }
        },
        error:function(){
            // failed request; give feedback to user
            $('#ajax_login').html('<img src="'+prepath+'image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
        }
    });

/*
	var copia_sfida = $("#copia_sfida").val();
	codifica_password();
	var pwd = $("#personal_login_pwd").val();
	var personal_login_user = $("#personal_login_user").val();
	
	
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { __submit: "true", 
				user: personal_login_user,
				pwd: pwd,
				copia_sfida: copia_sfida
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(data){
		  var obj = jQuery.parseJSON(data);
		  if(obj.result=="true"){
			  var username=$("#in_username").val();
			  if(obj.user == username){
				  Load_personal_area();
				  Aggiorna_menu_avatar();
				  
			  }else{
				  location.href='../'+obj.user+'/index.php?personal_area=true';
			  }
		  }else{
			 $('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Ricontrolla i tuoi dati.<br/> <a target="_self" onclick="Javascript:show_recupero_password()" style="cursor:pointer;">Hai dimenticato la password?</a>');
			  
		  }
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});*/
}
function Logout(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Aggiorna_menu_avatar();
			location.href='../'+username;
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Logout="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Aggiorna_menu_avatar(){
	var username = $("#in_username").val();
	$.ajax({
		type: 'POST',
		url: "../card/php/card_handler.php",
		data: { Aggiorna_menu_avatar: "true", 
				  Username: username
			   },
		dataType: "html",
		beforeSend:function(){
		    $('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
		},
		success:function(data){
			$("#menu_avatar_container").html(data);
		},
		error:function(){
		  // failed request; give feedback to user
		  $('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
		}
	 });
}
function Load_personal_area(tab){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Check_user_logged: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		//$('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
	  },
	  success:function(checklogged){
		  	  $.ajax({
				  type: 'POST',
				  url: "../card/php/card_handler.php",
				  data: { load_personal_area: "true", 
							Username: username
						 },
				  dataType: "html",
				  beforeSend:function(){
					//$('#ajax_login').html('<img src="../../image/icone/ajax_small.gif" alt="Loading..." />');
				  },
				  success:function(data){
					  $("#personal_area_login").html(data);
					  var obj = jQuery.parseJSON(checklogged);
		  			  if(obj.result=="true"){
						  document.getElementById("biglietto_preview").innerHTML="<iframe src='../card/php/bigliettovisita_preview.php?u="+username+"' width='407' height='247' frameborder='0'></iframe>";
						  document.getElementById("dove_siamo_preview").innerHTML="<iframe src='../card/php/show_maps_preview.php?u="+username+"' width='407' height='247' frameborder='0'></iframe>";
						  GeneratePersonalMenu();
						  Refresh_notifica_message();
						  Set_progress_size_bar();
                          if(tab!="interfaccia"){
                              personal_tab_change(tab);
                          }
					  }
				  },
				  error:function(){
					// failed request; give feedback to user
					$('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
				  }
			   });

	  },
	  error:function(){
		// failed request; give feedback to user
		$('#ajax_login').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
	
	
}


function Load_create_bigliettovisita(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Load_create_bigliettovisita: "true", 
				Username: username 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#overlay_biglietto_container').html('<img src="../../image/icone/spinner-big.gif" alt="Loading..." />');
	  },
	  success:function(data){
		$('#overlay_biglietto_container').html(data);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#social_ajax_panel').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
	
}
function Load_filebox_public_photo(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Load_filebox_public_photo: "true", 
				Username: username 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#filebox_photo_content').html('<img src="../../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
	  },
	  success:function(data){
		$('#filebox_photo_content').html(data);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#filebox_photo_content').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
	
}
function Load_filebox_public_document(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Load_filebox_public_document: "true", 
				Username: username 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#filebox_document_content').html('<img src="../../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
	  },
	  success:function(data){
		$('#filebox_document_content').html(data);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#filebox_document_content').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
	
}
function Load_dove_siamo(){
	var username = $("#in_username").val();
	$('#overlay_dove_siamo').html('<img src="../../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
	$('#overlay_dove_siamo').html("<iframe src='../card/php/show-maps.php?u="+username+"' width='750' height='400' frameborder='0'></iframe>");
			
}
function Load_filebox_private(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Load_filebox_private: "true", 
				Username: username 
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#filebox_private_content').html('<img src="../../image/icone/spinner-big.gif" style="width:10%" alt="Loading..." />');
	  },
	  success:function(data){
		$('#filebox_private_content').html(data);
	  },
	  error:function(){
		// failed request; give feedback to user
		$('#filebox_private_content').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di connessione. Riprova o ricarica la pagina.');
	  }
	});
}
function Load_photoslide(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Load_photoslide: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		$('#card_slideshow_container').html('<img src="../../image/icone/spinner-big.gif" style="width:60%;" alt="Loading..." />');
	  },
	  success:function(data){
		$('#card_slideshow_container').html(data);
		Carica_photoslide();
	 },
	  error:function(){
		// failed request; give feedback to user
		$('#card_slideshow_container').html('<img src="../../image/icone/error.png" style="vertical-align:middle; padding-right:4px;" alt="Errore" /> Errore di caricamento Slideshow.');
	  }
	});
}

function Open_photo_manager(){
	var username=document.getElementById("in_username").value;
	location.href='../card/php/photo.php?u='+username;
}
function return_to_the_card(){
	var username=document.getElementById("in_username").value;
	location.href='../'+username;
}
//SHOW CURRICULUM PDF
function Open_pdf_curriculum(){
	var username=document.getElementById("in_username").value;
	//location.href='../card/php/pdf_curriculum.php?u='+username;
	window.open('../card/php/pdf_curriculum.php?u='+username);
}

//CURRICULUM EUROPEO
function europeo_curriculum_redirect(){
	var username=document.getElementById("in_username").value;
	location.href='../card/php/curriculum_europeo_edit.php?u='+username;
}
//CREA CURRICULUM
function crea_curriculum_redirect(){
	var username=document.getElementById("in_username").value;
	location.href='../card/php/crea_curriculum.php?u='+username;
}
//BV
function visualizza_bv(){
	var username=document.getElementById("in_username").value;
	window.open('../card/php/bigliettovisita.php?u='+username);	
}



function CuteWebUI_AjaxUploader_OnQueueUI(list)
{
	for (i in list) {
		if(list[i].Status == 'Finish'){
		}
		if(list[i].Status == 'Error'){
			Show_Setting_Saved('div_error_allegati');
		}
	}
	return false;
}

function Aggiorna_evidenza(file_name){
	document.getElementById('div_evidenza_file').style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$('#div_evidenza_file').append(ajaxRequest.responseText);
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Get_evidenza_desc="+true+"&Username="+username;
	
	params+="&file_name="+file_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}



function ctrl_mod_bv_adobe(){
	var username = document.getElementById("in_username").value;
	document.getElementById("biglietto_preview").innerHTML= "<iframe src='../card/php/bigliettovisita.php?u="+username+"' width='407' height='247' frameborder='0' id='personal_biglietto_iframe'></iframe>";
}
function bv_save(){
	var username = document.getElementById("in_username").value;
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved('biglietto_saved');
			document.getElementById('biglietto_preview').innerHTML="<iframe src='../card/php/bigliettovisita_preview.php?u="+username+"' width='407' height='247' frameborder='0'></iframe>";
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("personal_in_bv_professione").value = obj.professione;
		}
	}
	document.getElementById('biglietto_preview').innerHTML="<img style='position:relative; top:100px; left:180px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>";
	var bv_check_cellulare = document.getElementById('personal_check_bv_cellulare').checked;
	var bv_check_professione = document.getElementById('personal_check_bv_professione').checked;
	
	var bv_check_email = document.getElementById('personal_check_bv_email').checked;
	
	var bv_check_tmg_email = document.getElementById('personal_check_bv_tmg_email').checked;
	
	var bv_cellulare = document.getElementById('personal_in_bv_cellulare').value;
	var bv_email = document.getElementById('personal_in_bv_email').value;
	var bv_professione = document.getElementById('personal_in_bv_professione').value;
	
	
	var selected = $("input[type='radio'][name='personal_in_bv_web']:checked");
	if (selected.length > 0) {
		var personal_in_bv_web = selected.val();
	}
	
	var params="Bv_save="+true+"&Username="+username;
	
	params+="&bv_cellulare="+bv_cellulare;
	params+="&bv_professione="+bv_professione;
	params+="&bv_email="+bv_email;
	
	params+="&bv_check_cellulare="+bv_check_cellulare;
	params+="&bv_check_professione="+bv_check_professione;
	params+="&bv_check_email="+bv_check_email;
	params+="&bv_check_tmg_email="+bv_check_tmg_email;
	
	params+="&personal_in_bv_web="+personal_in_bv_web;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}




function curr_save(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved('opt_curr_saved');
		}
	}
	
	var change_opt_curr = document.getElementById("change_opt_curr").checked;
	var username = document.getElementById("in_username").value;
	
	var params="impostazioni_curr_save="+true+"&Username="+username;
	params+="&change_opt_curr="+change_opt_curr;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function show_curr_europ(){
	var username = document.getElementById("in_username").value;
	window.open('../card/php/curriculumeuropeo.php?u='+username);
}
function show_story(){
	var username = document.getElementById("in_username").value;
	window.open('../card/php/storia.php?u='+username);
}

function move(id,spd){
	var obj=document.getElementById(id),max=-obj.offsetHeight+obj.parentNode.offsetHeight,top=parseInt(obj.style.top);
	
	if ((spd>0&&top<=0)||(spd<0&&top>=max)){
		obj.style.top=top+spd+"px";
	 	move.to=setTimeout(function(){ move(id,spd); },20);
	}
	else{
	 	obj.style.top=(spd>0?0:max)+"px";
	}
}

/*function show_scarica_foto(){
	$("#foto_download").fadeIn("fast");	
}
function hide_scarica_foto(){
	document.getElementById('foto_download').style.display = "none";	
}
function show_scarica_foto_on(){
	document.getElementById('foto_download').style.display = "block";
	document.getElementById('foto_download').style.opacity = "1";
}
function show_scarica_foto_off(){
	document.getElementById('foto_download').style.opacity = "0.65";
	document.getElementById('foto_download').style.display = "none";
}*/

function show_scarica_slide(){
	$("#slide_download").fadeIn("fast");	
}
function hide_scarica_slide(){
	document.getElementById('slide_download').style.display = "none";	
}
function show_scarica_slide_on(){
	document.getElementById('slide_download').style.display = "block";
	document.getElementById('slide_download').style.opacity = "1";
}
function show_scarica_slide_off(){
	document.getElementById('slide_download').style.opacity = "0.65";
	document.getElementById('slide_download').style.display = "none";
}

var is_download;
var checked_id = new Array();
function file_check(id){
	
}
function private_dir_over(id){
	document.getElementById('private_div_dir_'+id).style.opacity = "0.40";
}
function private_dir_out(id){
	document.getElementById('private_div_dir_'+id).style.opacity="1";
}
function public_dir_over(id){
	document.getElementById('public_div_dir_'+id).style.opacity = "0.40";
}
function public_dir_out(id){
	document.getElementById('public_div_dir_'+id).style.opacity="1";
}
function photo_dir_over(id){
	document.getElementById('photo_div_dir_'+id).style.opacity = "0.40";
}
function photo_dir_out(id){
	document.getElementById('photo_div_dir_'+id).style.opacity="1";
}
function uncheck(id){ 
	is_download = id;
}
function Show_public_folder(index){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("file_box_public_main").style.display = "none";
			document.getElementById("file_box_folder_file").innerHTML = ajaxRequest.responseText;
			document.getElementById("file_box_folder").style.display = "block";
			
		}
	}
	
	var folder = document.getElementById('public_dir_name_'+index).value;
	var username=document.getElementById("in_username").value;
	
	var params="Show_public_folder="+true+"&Username="+username;
	
	params+="&folder_name="+folder;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
		
}
function Show_photo_folder(index){
	/*if(isIE){*/
		var folder = document.getElementById('photo_dir_name_'+index).value;
		var username=document.getElementById("in_username").value;
		window.open('../card/php/jgallery/photo_gallery.php?u='+username+'&folder_path='+folder);
	
}
function invio_filebox(e,folder) {
      // IE
      var tasto;
      if(window.event){
        tasto = e.keyCode;
      }
      // Netscape/Firefox/Opera
      else if(e.which){
        tasto = e.which;
      }
      if (tasto == 13) {
        accedi(folder)
   }
}
function accedi(folder){
	document.getElementById("file_box_accedi_loading").style.display = "inline";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("file_box_private_files_content").innerHTML = ajaxRequest.responseText;
		}
	}
	
	var folder_pass = document.getElementById('private_folder_pass').value;
	var username = document.getElementById("in_username").value;
	var params = "Accedi="+true+"&Username="+username;

	params+="&folder="+folder;
	params+="&folder_pass="+folder_pass;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Load_accedi(index){
	document.getElementById("file_box_private_loading").style.display = "inline";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("file_box_main").style.display = "none";
			document.getElementById("file_box_private_loading").style.display = "none";
			document.getElementById("file_box_private_files_content").innerHTML = ajaxRequest.responseText;
			document.getElementById("file_box_private_folder").style.display = "block";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var folder = document.getElementById('private_dir_name_'+index).value;
	var params = "Load_accedi="+true+"&Username="+username;
	params+="&folder="+folder;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function torna_filebox_main(){
	document.getElementById("file_box_private_folder").style.display = "none";
	document.getElementById("file_box_main").style.display = "block";
}
function torna_filebox_public_main(){
	document.getElementById("file_box_folder").style.display = "none";
	document.getElementById("file_box_public_main").style.display = "block";
}


function show_recupero_password(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('personal_login_container').innerHTML = ajaxRequest.responseText;
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Recupero_pass="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function invia_recupero(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			alert(ajaxRequest.responseText);/*
			if($.trim(ajaxRequest.responseText)=="1")
				Show_Setting_Saved('recupero_saved');
			else
				Show_Setting_Saved('recupero_error');
			*/
		}
	}
	var username = document.getElementById("in_username").value;
	
	var params="Invia_recupero="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function torna_login(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('personal_login_container').innerHTML = ajaxRequest.responseText;
		}
	}

	var username = document.getElementById("in_username").value;
	var params="Torna_login="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}

function forminput_login_click(){
	document.getElementById('user').value = "";
	document.getElementById('user').onclick = "";
}

function personal_main_photo_open(){
	var username = document.getElementById("in_username").value;
	window.open('../card/php/photo.php?u='+username);
}
function personal_slide_open(){
	var username = document.getElementById("in_username").value;
	window.open('../card/php/slide.php?u='+username);
}

function change_card_colour(colour){
	document.getElementById("colour_loading").style.display = "inline";
	document.getElementById("colore_card").value = colour;
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved('colour_saved');
			$("#btn_colore_brown").removeClass("btn_colore_over");
			$("#btn_colore_black").removeClass("btn_colore_over");
			$("#btn_colore_green").removeClass("btn_colore_over");
			$("#btn_colore_blue").removeClass("btn_colore_over");
			$("#btn_colore_pink").removeClass("btn_colore_over");
			$("#btn_colore_azzurro").removeClass("btn_colore_over");
			$("#btn_colore_orange").removeClass("btn_colore_over");
			
			$("#btn_colore_brown").addClass("btn_colore");
			$("#btn_colore_black").addClass("btn_colore");
			$("#btn_colore_green").addClass("btn_colore");
			$("#btn_colore_blue").addClass("btn_colore");
			$("#btn_colore_pink").addClass("btn_colore");
			$("#btn_colore_azzurro").addClass("btn_colore");
			$("#btn_colore_orange").addClass("btn_colore");
			
			$("#btn_colore_"+colour).addClass("btn_colore_over");
			
			document.getElementById("colour_loading").style.display = "none";
		}
	}
	
	var username = document.getElementById("in_username").value;
	
	var params="Change_card_colour="+true+"&Username="+username;
	params+="&colore_card="+colour;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
	
}

/*PEROSNAL CARD---------------------------------------------------------------------*/
function personal_card_mod_professione(){
	var in_professione = document.getElementById('in_personal_card_professione_utente').value;
	document.getElementById('personal_card_mod_professione').innerHTML="<input class='personal_card_in_professione' type='text' value='"+in_professione+"' id='in_personal_card_mod_professione' /><br/><span style='font-size:13px; color:#F4CE38; font-weight:700; cursor:pointer;' onclick='Javascript:personal_card_save_professione();' style='cursor:pointer;'>Salva</span>";
	//document.getElementById('personal_card_mod_professione').innerHTML="";	
}
function personal_card_scarica_biglietto(username){
	window.open("../card/php/bvpdfdownload.php?u="+username);
}
function personal_card_save_professione(){
	document.getElementById("impostazioni_professione_loading").style.display = "inline";			
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("impostazioni_professione_loading").style.display = "none";
			Show_Setting_Saved('impostazioni_professione_saved');
			personal_tab_change("interfaccia");
		}
	}
	if($("input[type='radio'].personal_check_show_radio").is(':checked')) {
    var nameshowed = $("input[type='radio'].personal_check_show_radio:checked").val();
	}
	
	
	var professione = document.getElementById("in_personal_card_mod_professione").value;
	var category = $('#in_personal_card_mod_professione_category').val();
	if(category==""||category==-1){
		alert("Devi selezionare una categoria per il tuo lavoro!");
		document.getElementById("impostazioni_professione_loading").style.display = "none";
		return;
	}
	var username = document.getElementById("in_username").value;
	var params="personal_card_save_professione="+true+"&Username="+username+"&professione="+professione+"&category="+category+"&nameshowed="+nameshowed;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function personal_card_scarica_biglietto(username){
	window.open("../card/php/bvpdfdownload.php?u="+username);
}
function personal_card_save_dove_siamo(){
	document.getElementById("impostazioni_dove_siamo_loading").style.display = "inline";			
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("impostazioni_dove_siamo_loading").style.display = "none";
			document.getElementById('dove_siamo_preview').innerHTML="<iframe src='../card/php/show_maps_preview.php?u="+username+"' width='407' height='247' frameborder='0'></iframe>";
			Show_Setting_Saved('impostazioni_dove_siamo_saved');
		}
	}
	var address_via = f("in_personal_card_mod_address_via");
	var address_citta = f("in_personal_card_mod_address_citta");
	var address_desc = f("in_personal_card_mod_address_desc");
	var address_on = document.getElementById("in_personal_card_mod_address_on").checked;
	var username = document.getElementById("in_username").value;
	var params="Personal_card_save_dove_siamo="+true+"&Username="+username+"&address_via="+address_via+"&address_citta="+address_citta+"&address_desc="+address_desc+"&address_on="+address_on;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}

function personal_card_ctrl_riscuoti(){
	document.getElementById("impostazioni_promoter_loading").style.display = "inline";			
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("impostazioni_promoter_loading").style.display = "none";
			if(ajaxRequest.responseText==1){
				Show_personal_riscuoti();
			}else{
				alert("Potrai richiedere la riscossione del tuo Saldo disponibile quando verrà raggiunta la soglia di €100. Se hai già effettuato la riscossione controlla la tua mail @topmanagergroup.com, ti abbiamo inviato un messaggio con la procedura per la riscossione del saldo disponibile.");	
			}
			//Show_Setting_Saved('impostazioni_professione_saved');
		}
	}
	var username = document.getElementById("in_username").value;
	var params="Personal_card_ctrl_riscuoti="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Show_personal_riscuoti(){
	$("#impostazioni_promoter_loading").css("display","inline");			
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#impostazioni_promoter_loading").css("display","none");
			$("#personal_card_div_promoter").html(ajaxRequest.responseText);
			//Show_Setting_Saved('impostazioni_professione_saved');
		}
	}
	var username = $("#in_username").val();
	var params="Personal_card_show_riscuoti="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}

	/*
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	DECOMMENTARE IL FILE <script type="text/javascript" src="../card/js/checkiban.js"></script>
	COMMENTATO PER MOTIVI DI PRESTAZIONI
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	*/
function personal_card_riscuoti(){
	
	/*
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	DECOMMENTARE IL FILE <script type="text/javascript" src="../card/js/checkiban.js"></script>
	COMMENTATO PER MOTIVI DI PRESTAZIONI
	!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	*/
	$("#impostazioni_promoter_loading").css("display","inline");			
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#impostazioni_promoter_loading").css("display","none");
			alert(ajaxRequest.responseText);
			Show_Setting_Saved('richiesta_promoter_done');
			Personal_card_show_promoter();
			
		}
	}
	if($("#personal_card_riscuoti_nomebeneficiario").val()!=""){
		var nomebeneficiario = $("#personal_card_riscuoti_nomebeneficiario").val();
	}else{
		alert("Devi inserire un nome beneficiario valido.");
		$("#impostazioni_promoter_loading").css("display","none");
		return false;
	}
	
	
	if(checkiban($("#personal_card_riscuoti_iban").val())){
		var iban = $("#personal_card_riscuoti_iban").val();
	}else{
		$("#impostazioni_promoter_loading").css("display","none");
		return false;	
	}
	
	if( CtrlCodFiscale($("#personal_card_riscuoti_codfis").val(),"personal_card_riscuoti_codfis") ){
		var codfis = $("#personal_card_riscuoti_codfis").val();
	}else{
		$("#impostazioni_promoter_loading").css("display","none");
		return false;	
	}
	
	var swift = $("#personal_card_riscuoti_swift").val();
	
	var username = $("#in_username").val();
	var params="Personal_card_riscuoti="+true+"&Username="+username+"&nomebeneficiario="+nomebeneficiario+"&iban="+iban+"&swift="+swift+"&codfis="+codfis;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}



/**************************************
    Controllo del Codice Fiscale
    Linguaggio: JavaScript
***************************************/
function CtrlCodFiscale(cf,id)
{
	//$("#_codfiscale").val($("#_codfiscale").val().toUpperCase());
    var validi, i, s, set1, set2, setpari, setdisp;
    if( cf == '' ){  
		alert("Devi inserire il codice fiscale!");
		$("#"+id).css("border","1px #F00 solid");
		return false;
	}
    cf = cf.toUpperCase();
    if( cf.length != 16 ){
		alert("Il codice fiscale deve essere lungo 16 caratteri.");
		$("#"+id).css("border","1px #F00 solid");
		return false;
	}
    validi = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for( i = 0; i < 16; i++ ){
        if( validi.indexOf( cf.charAt(i) ) == -1 ){
			alert("Il codice fiscale contiene un carattere non valido: "+cf.charAt(i));
			$("#"+id).css("border","1px #F00 solid");
			return false;
		}
    }
    set1 = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    set2 = "ABCDEFGHIJABCDEFGHIJKLMNOPQRSTUVWXYZ";
    setpari = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    setdisp = "BAKPLCQDREVOSFTGUHMINJWZYX";
    s = 0;
    for( i = 1; i <= 13; i += 2 )
        s += setpari.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
    for( i = 0; i <= 14; i += 2 )
        s += setdisp.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
    if( s%26 != cf.charCodeAt(15)-'A'.charCodeAt(0) ){		
		alert("Il codice fiscale non è corretto!");
		$("#"+id).css("border","1px #F00 solid");
		return false;
	}
	
	
	var anno = cf.substr(6,2);
	
	if(anno<15){
		anno = "20"+anno;	
	}else{
		anno = "19"+anno;	
	}
	var mese = cf.substr(8,1);
	switch(mese){
		case "A":
			mese = "1";
		break;
		case "B":
			mese = "2";
		break;
		case "C":
			mese = "3";
		break;
		case "D":
			mese = "4";
		break;
		case "E":
			mese = "5";
		break;
		case "H":
			mese = "6";
		break;
		case "L":
			mese = "7";
		break;
		case "M":
			mese = "8";
		break;
		case "P":
			mese = "9";
		break;
		case "R":
			mese = "10";
		break;
		case "S":
			mese = "11";
		break;
		case "T":
			mese = "12";
		break;
	}
	var giorno = cf.substr(9,2);
	if(giorno>40){
		giorno = giorno-40;	
	}
	
	var eta = displayage(anno,mese,giorno,"years",true,true);
	if(eta<18){	
		alert("Devi essere maggiorenne per richiedere la riscossione a TopManagerGroup.com"); 
		$("#"+id).css("border","1px #F00 solid");
	
		return false;	
	}
	
	$("#"+id).css("border","1px #FFF solid");
	
    return true;
}

function displayage( yr, mon, day, countunit, decimals, rounding ) {
 
	// Starter Variables
	today = new Date();
	yr = parseInt(yr);
	mon = parseInt(mon);
	day = parseInt(day);
	var one_day = 1000*60*60*24;
	var one_month = 1000*60*60*24*30;
	var one_year = 1000*60*60*24*30*12;
	var pastdate = new Date(yr, mon-1, day);
	var return_value = 0;
 
	finalunit = ( countunit == "days" ) ? one_day : ( countunit == "months" ) ? one_month : one_year;
	decimals = ( decimals <= 0 ) ? 1 : decimals * 10;
 
	if ( countunit != "years" ) {
		if ( rounding == "rounddown" )
			return_value = Math.floor ( ( today.getTime() - pastdate.getTime() ) / ( finalunit ) * decimals ) / decimals;
		else
			return_value = Math.ceil ( ( today.getTime() - pastdate.getTime() ) / ( finalunit ) * decimals ) / decimals;
	} else {
		yearspast = today.getFullYear()-yr-1;
		tail = ( today.getMonth() > mon - 1 || today.getMonth() == mon - 1 && today.getDate() >= day ) ? 1 : 0;
		return_value = yearspast + tail;
	}
 
	return return_value;
 
}

function Personal_card_show_promoter(){
	$("#impostazioni_promoter_loading").css("display", "inline");		
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#impostazioni_promoter_loading").css("display", "none");	
			$("#personal_card_div_promoter").html(ajaxRequest.responseText);
			
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_card_show_promoter="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
/*END PERSONAL CARD-----------------------------------------------------------------*/
/*function perform_acrobat_detection()
{ 
  //
  // The returned object
  // 
  var browser_info = {
    name: null,
    acrobat : null,
    acrobat_ver : null
  };

  if(navigator && (navigator.userAgent.toLowerCase()).indexOf("chrome") > -1) browser_info.name = "chrome";
  else if(navigator && (navigator.userAgent.toLowerCase()).indexOf("msie") > -1) browser_info.name = "ie";
  else if(navigator && (navigator.userAgent.toLowerCase()).indexOf("firefox") > -1) browser_info.name = "firefox";
  else if(navigator && (navigator.userAgent.toLowerCase()).indexOf("msie") > -1) browser_info.name = "other";


 try
 {
  if(browser_info.name == "ie")
  {          
   var control = null;

   //
   // load the activeX control
   //                
   try
   {
    // AcroPDF.PDF is used by version 7 and later
    control = new ActiveXObject("AcroPDF.PDF");
   }
   catch (e){}

   if (!control)
   {
    try
    {
     // PDF.PdfCtrl is used by version 6 and earlier
     control = new ActiveXObject("PDF.PdfCtrl");
    }
    catch (e) {}
   }

   if(!control)
   {     
    browser_info.acrobat == null;
    return browser_info;  
   }

   version = control.GetVersions().split(",");
   version = version[0].split("=");
   browser_info.acrobat = "installed";
   browser_info.acrobat_ver = parseFloat(version[1]);                
  }
  else if(browser_info.name == "chrome")
  {
   for(key in navigator.plugins)
   {
    if(navigator.plugins[key].name == "Chrome PDF Viewer" || navigator.plugins[key].name == "Adobe Acrobat")
    {
     browser_info.acrobat = "installed";
     browser_info.acrobat_ver = parseInt(navigator.plugins[key].version) || "Chome PDF Viewer";
    }
   } 
  }
  //
  // NS3+, Opera3+, IE5+ Mac, Safari (support plugin array):  check for Acrobat plugin in plugin array
  //    
  else if(navigator.plugins != null)
  {      
   var acrobat = navigator.plugins["Adobe Acrobat"];
   if(acrobat == null)
   {           
    browser_info.acrobat = null;
    return browser_info;
   }
   browser_info.acrobat = "installed";
   browser_info.acrobat_ver = parseInt(acrobat.version[0]);                   
  }


 }
 catch(e)
 {
  browser_info.acrobat_ver = null;
 }

  return browser_info;
}*/
function submit_friend(){
	Verified_submit_friend();	
	/*var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result!=0&&obj.result!=3){
				document.getElementById("friend_results").innerHTML = "<span class='text14px' style='color:#000;'>Clicca sul link che troverai nel messaggio e-mail che ti abbiamo inviato per verificare la tua identit&aacute;. <br/> Una volta verificato il tuo indirizzo e-mail non dovrai pi&ugrave; ripetere questa procedura.</span>";
				document.getElementById("overlay_friend").style.display="none";
				document.getElementById("friend_results").style.display="block";
				Insert_not_verified_friend(obj.result);
			}else if(obj.result==0){
				Verified_submit_friend();
			}else if(obj.result==3){
				False_submit_friend();
			}
		}
	}
	
	var nome = document.getElementById("friend_email").value;
	var username = document.getElementById("in_username").value;
	
	var params="Verify_mail="+true+"&Username="+username;
	params+='&email='+nome;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);*/
}
function Submit_assistenza(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				document.getElementById("assistenza_results").innerHTML = "<span class='text14px' style='color:#000;'>La tua richiesta di assistenza è stata inviata e verrà processata entro 72 ore lavorative. Verrai contattato all'indirizzo e-mail indicato.</span><div class='button' style='position:absolute; left:232px; top:40px; z-index:9000;' alt='Cancel' onclick='Javascript:location.href = \"index.php\"'><span class='text14px'>AGGIORNA</a></div>";
				document.getElementById("overlay_assistenza_container").style.display="none";
				document.getElementById("assistenza_results").style.display="block";
			}
		}
	}
	
	var email = CtrlEmail("assistenza_email");
	if(email==1)
		return false;
	
	var username = document.getElementById("in_username").value;
	var textarea_assistenza = f("textarea_assistenza");
	if(textarea_assistenza==""){
		document.getElementById("textarea_assistenza").style.border = "1px #F00 solid";
		alert("Devi specificare il tuo problema");	
		return false;
	}
	var ip = document.getElementById("assitenza_in_ip").value;
	var params="Submit_assistenza="+true+"&Username="+username;
	params+='&email='+email;
	params+='&textarea='+textarea_assistenza;
	params+='&ip='+ip;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
	
}
function Submit_abuso(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				document.getElementById("abuso_results").innerHTML = "<span class='text14px' style='color:#000;'>La segnalazione è stata effettuata con successo. Grazie della collaborazione.</span><div class='button' style='position:absolute; left:232px; top:40px; z-index:9000;' alt='Cancel' onclick='Javascript:location.href = \"index.php\"'><span class='text14px'>AGGIORNA</a></div>";
				document.getElementById("overlay_abuso_container").style.display="none";
				document.getElementById("abuso_results").style.display="block";
			}
		}
	}
	
	var email = CtrlEmail("abuso_email");
	if(email==1)
		return false;
		
	var radioabuso = document.getElementsByName("radioabuso");
	var radiovalue = "";
	var radioLength = radioabuso.length;
	if(radioLength == undefined)
		if(radioabuso.checked)
			radiovalue = radioabuso.value;

	for(var i = 0; i < radioLength; i++) {
		if(radioabuso[i].checked) {
			radiovalue =  radioabuso[i].value;
		}
	}
	if(radiovalue == ""){
		alert("Devi selezionare un tipo di abuso");
		return false;	
	}else{
		var textarea_abuso="";
		if(radiovalue=="altro"){
			textarea_abuso = f("textarea_abuso");
			if(textarea_abuso==""){
				document.getElementById("textarea_abuso").style.border = "1px #F00 solid";
				alert("Devi specificare il tipo di abuso.");	
				return false;
			}
		}
	}
	
	var username = document.getElementById("in_username").value;
	
	var ip = document.getElementById("abuso_in_ip").value;
	var params="Submit_abuso="+true+"&Username="+username;
	params+='&email='+email;
	params+='&type='+radiovalue;
	params+='&textarea='+textarea_abuso;
	params+='&ip='+ip;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}


function CtrlEmail(input_id){
	var email=document.getElementById(input_id);
	if (email.value==null || email.value=="" || isEmail(email.value)==false)
   {
	   if(email.value==null || email.value==""){
			alert("Inserisci l'indirizzo email!");   
		}
		document.getElementById(input_id).style.border = "1px #F00 solid";
		return 1;
   }
   else{
		document.getElementById(input_id).style.border = "1px #FFF solid";
		return email.value;		   
   }
   return;
}
function isEmail(emailStr) {
        var emailPat = /^(.+)@(.+)$/;
        var specialChars = "\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
        var validChars = "[^\\s" + specialChars + "]";
        var quotedUser = "(\"[^\"]*\")";
        var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
        var atom = validChars + "+";
        var word = "(" + atom + "|" + quotedUser + ")";
        var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
        var domainPat = new RegExp("^" + atom + "(\\." + atom + ")*$");
        var matchArray = emailStr.match(emailPat);
        if (matchArray == null) {
            return false;
        }
        var user = matchArray[1];
        var domain = matchArray[2];
        if (user.match(userPat) == null) {
            return false;
        }
        var IPArray = domain.match(ipDomainPat);
        if (IPArray != null) {
            for (var i = 1; i <= 4; i++) {
                if (IPArray[i] > 255) {
                    return false;
                }
            }
            return true;
        }
        var domainArray = domain.match(domainPat);
        if (domainArray == null) {
            return false;
        }
        var atomPat = new RegExp(atom, "g");
        var domArr = domain.match(atomPat);
        var len = domArr.length;
        if (domArr[domArr.length - 1].length < 2 ||
            domArr[domArr.length - 1].length > 6) {
            return false;
        }
        if (len < 2) {
            return false;
        }
        return true;
    }

function Verified_submit_friend(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				$("#friend_results").html("<p class='text14px'><img src='../image/icone/ok.png' alt='Informazioni salvate' width='22' height='19' />&nbsp;<span style='position:relative; top:-3px;'>Hai lasciato il tuo contatto</span></p>");
			}else{
				$("#friend_results").html("<p class='text14px'><img src='../image/icone/error.png' alt='Errore' width='22' height='19' />&nbsp;<span style='position:relative; top:-4px;'>Hai già lasciato il tuo contatto!</span></p>");
			}
			
			/*$("#overlay_friend").css("display:none;");
			$("#friend_results").css("display:block;");*/
			document.getElementById('overlay_friend').style.display = "none";
			document.getElementById('friend_results').style.display = "block";
			
			$("#friend_name").val("");
			$("#friend_surname").val("");
			$("#friend_email").val("");
			$("#friend_note").html("");
			var t=setTimeout("Reset_add_friend()",3000);
		}
	}
	var nome=$("#friend_name").val();
	var cognome=$("#friend_surname").val();
	var email=$("#friend_email").val();
	var cell=$("#friend_cell").val();
	var username=$("#in_username").val();
	var friend_note = f("friend_note");
	
	var params="Add_friend="+true+"&Username="+username;
	params+="&nome="+nome;
	params+="&cognome="+cognome;
	params+="&email="+email;
	params+="&cell="+cell
	params+="&friend_note="+friend_note
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Reset_add_friend(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#item_add_friend").html(ajaxRequest.responseText);
			$("#friend_results").css("display:none;");
			$("#overlay_friend").css("display:block;");
		}
	}
	
	var username = $("#in_username").val();
	var params="Reset_add_friend="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function open_contact_click(url){
	window.open(url);
}
function Delete_allegato(path){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Refresh_allegati();
		}
	}
	confirmed = window.confirm("Vuoi eliminare questo allegato?.");
	if (confirmed)
	{
		var username = document.getElementById("in_username").value;
		var params="Delete_allegato="+true+"&Username="+username;
		params+="&path="+path;
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);	
	} 
	else 
	{
		return false;
	}
}


function select_message_row(index){
	var checkbox = document.getElementById("check_msg_"+index);
	if(checkbox.checked==""){
		//id.style.backgroundColor="#A8A8A8";
		document.getElementById("message_row_"+index).style.backgroundColor="#A8A8A8";
		document.getElementById("check_msg_"+index).checked = "checked";
	}else{
		if((index%2)==0){
			//id.style.backgroundColor="#8b8b8b";
			document.getElementById("message_row_"+index).style.backgroundColor="#8b8b8b";
		}
		else{
			//id.style.backgroundColor="#838383";
			document.getElementById("message_row_"+index).style.backgroundColor="#838383";
		}
		document.getElementById("check_msg_"+index).checked = "";
	}
}

function Set_progress_size_bar(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			var bar = $('.personal_size_progressbar span');
    		bar.css('width', obj.progressvalue + '%');
			$("#size_left_value").html(obj.value);
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Set_progress_size_bar="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Aggiorna_news(){
	$("#personal_card_evidenza").html("<img style='position:relative; top:20px; left:90px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#personal_card_evidenza").html(ajaxRequest.responseText);
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_aggiorna_news="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Set_mailing_contacts_old(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
		Refresh_notifica_message();
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Set_mailing_contacts_old="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Aggiorna_professione(){
	$("#personal_professione_text").html("<img style='position:relative; top:5px; left:50px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#personal_professione_text").html(ajaxRequest.responseText);
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_aggiorna_professione="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Aggiorna_nameshowed(){
	$("#personal_nameshowed_text").html("<img style='position:relative; top:5px; left:50px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#personal_nameshowed_text").html(ajaxRequest.responseText);
			document.getElementById("biglietto_preview").innerHTML="<iframe src='../card/php/bigliettovisita_preview.php?u="+username+"' width='407' height='247' frameborder='0'></iframe>";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_aggiorna_nameshowed="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}


function Aggiorna_promoter(){
	$("#personal_card_div_promoter").html("<img style='position:relative; top:5px; left:50px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#personal_card_div_promoter").html(ajaxRequest.responseText);
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_aggiorna_promoter="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}


function Aggiorna_main_foto(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Personal_aggiorna_main_photo: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		$("#personal_card_photo").html("<img style='position:relative; top:110px; left:73px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	  },
	  success:function(data){
		$("#personal_card_photo").html(data);
	  }
	});
}
function Aggiorna_social(){
	var username = $("#in_username").val();
	$.ajax({
	  type: 'POST',
	  url: "../card/php/card_handler.php",
	  data: { Personal_aggiorna_social: "true", 
				Username: username
			 },
	  dataType: "html",
	  beforeSend:function(){
		$("#personal_card_social").html("<img style='position:relative; top:80px; left:13px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	  },
	  success:function(data){
		$("#personal_card_social").html(data);
	  }
	});
}

function Aggiorna_slide_foto(){
	$("#personal_card_photo_slide").html("<img style='position:relative; top:20px; left:90px;' src='../image/icone/ajax_small.gif' alt='Caricamento..'/>");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#personal_card_photo_slide").html(ajaxRequest.responseText);
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Personal_aggiorna_slide_photo="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function get_lista_subuser(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('subuser').innerHTML="";
			$("#subuser").append(ajaxRequest.responseText);
		}
	}
	var username=document.getElementById("in_username").value;
	var params="Get_lista_subuser="+true+"&Username="+username;

	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function open_card(username){
	window.open('../../'+username);
}
function go_to_webmail(){
	window.open('../roundcube/');
}





//------------------------------------------------------------------------------------------------------------
//OTHER STUFF START
//------------------------------------------------------------------------------------------------------------

function ctrl_is_num(value){
	var iChars = "1234567890+#";
	var errorMsg="";
	
	var flag = 0;
	for (var i = 0; i < value.length; i++) {
		if (iChars.indexOf(value.charAt(i)) == -1) {
			flag = 1;
		}
	}
	
	if(flag==1){
		errorMsg = "\nHai inserito caratteri non validi. Caratteri consentiti ("+iChars+").\n";
	}
	
	//If there is aproblem with the form then display an error
     if (errorMsg != ""){
          return false;
     }
     return true;

}
function is_num(value){
	var iChars = "1234567890+#";
	var errorMsg="";
	
	var flag = 0;
	for (var i = 0; i < value.length; i++) {
		if (iChars.indexOf(value.charAt(i)) == -1) {
			flag = 1;
		}
	}
	
	if(flag==1){
		errorMsg = "\nHai inserito caratteri non validi. Caratteri consentiti ("+iChars+").\n";
	}
	
	//If there is aproblem with the form then display an error
     if (errorMsg != ""){
          return false;
     }
     return true;

}

//------------------------------------------------------------------------------------------------------------
//OTHER STUFF END
//------------------------------------------------------------------------------------------------------------



//OLD JS...
/*function Personal_form_submit_old(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var results = ajaxRequest.responseText;
			document.getElementById('personal_area_login').innerHTML = results;
			GeneratePersonalMenu();
		}
	}
	
	var login_attempt_num=document.getElementById("login_attempt_num").value;
	var login = document.getElementById("personal_login").value;
	var password = document.getElementById("personal_password").value;
	var username=document.getElementById("in_username").value;
	var params="login="+login+
	"&password="+password+
	"&login_attempt="+login_attempt_num+
	"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params.length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
	
	
}*/

/*function check_mod_on_off(){
	var check_mod=document.getElementById("check_mod");
	if(check_mod.checked==true){
		mod_general_on();
	}else{
		mod_general_off()
	}
}
function button_mod_on_off(){
	var check_mod=document.getElementById("mod_button");
	if(check_mod.value=='Modifica'){
		mod_general_on();
	}else{
		mod_general_off()
	}
}
function button_contact_mod_on_off(){
	var check_mod=document.getElementById("mod_button");
	if(check_mod.value=='Modifica'){
		mod_contact_on();
	}else{
		mod_contact_off()
	}
}

function mod_general_on(){
	
	//Visualizzo gli input per la modifica di nome e professione
	var Nome=document.getElementById("in_nome_utente").value;
	var Professione=document.getElementById("in_professione_utente").value;
	 
	document.getElementById("nome_professione").innerHTML = "<p><input class='mod_nome_in' type='text' id='in_nome_utente' name='in_nome_utente' value='"+Nome+"'/><br/><input class='mod_nome_in' type='text' id='in_professione_utente' name='in_professione_utente' value='"+Professione+"'/></p>";
	
	document.getElementById("div_mod_links").style.display = "block";
	document.getElementById("check_mod").checked = true;
	document.getElementById("mod_button").value = "Salva";
	Ajax_card_handler("mod=on");
}
function mod_general_off(){
	//prelevo i dati attuali
	var in_nome_utente=document.getElementById("in_nome_utente").value;
	var in_professione_utente=document.getElementById("in_professione_utente").value;
	var username=document.getElementById("in_username").value;
		
	//effettuo l'update nel DB che mi restituirà l'html con i dati aggiornati
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			document.getElementById("nome_professione").innerHTML = ajaxRequest.responseText;
		}
	}
	ajaxRequest.open("GET", "../card/php/card_handler.php?mod=off&Nome="+in_nome_utente
	+"&Professione="+in_professione_utente
	+"&Username="+username, true);
	ajaxRequest.send(null);	
	
	
	//checkbox.cheched= false
	document.getElementById("check_mod").checked = false;
	//bottone in modalità modifica
	document.getElementById("mod_button").value = "Modifica";
	document.getElementById("div_mod_links").style.display = "none";
}*/






