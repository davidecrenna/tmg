function create_ajaxRequest(){	
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	return ajaxRequest;
}
function Show_Setting_Saved(div){
	$("#"+div).show(400);
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",3000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide(400);
}
function torna_alla_card(){
	var username=document.getElementById("in_username").value;
	location.href = "../../"+username+"/index.php/personal_area";
}
function CuteWebUI_AjaxUploader_OnQueueUI(list)
{
	return false;
}
function Aggiorna_evidenza(file_name){
	alert("Eseguo da evidenza.js");
	document.getElementById('div_evidenza_file').style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('div_evidenza_file').innerHTML = ajaxRequest.responseText;
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Get_evidenza_desc="+true+"&Username="+username;
	
	params+="&file_name="+file_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Delete_evidenza_file(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("div_evidenza_file").innerHTML = ajaxRequest.responseText;
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Delete_evidenza_file="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_Setting_Saved(div){
	$("#"+div).show();
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",3000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide();
}
function Gestisci_newsletter(){
	document.getElementById("main").style.display="none";
	document.getElementById("newsletter").style.display="block";
}
function Posticipa_pubblicazione(){
	document.getElementById("main").style.display="none";
	document.getElementById("calendar").style.display="block";
}

function return_evidenza(){
	document.getElementById("main").style.display="block";
	document.getElementById("newsletter").style.display="none";
}
function Add_newsetter_row(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("in_new_newsletter_row").value="";
			document.getElementById("in_new_newsletter_name").value="";
			document.getElementById("in_new_newsletter_surname").value="";
			Refresh_newsletter_rows();
			Show_Setting_Saved("contatto_saved");
		}
	}
	var username = document.getElementById("in_username").value;
	var nome = Ctrltextinput("in_new_newsletter_name",20);
	if(nome == 1) return false;
	var cognome = Ctrltextinput("in_new_newsletter_surname",20);
	if(cognome == 1) return false;
	
	var select_news_mail_group = document.getElementById("select_news_mail_group");
	var id_group = select_news_mail_group.options[select_news_mail_group.selectedIndex].value;
	var in_new_newsletter_row = CtrlEmail("in_new_newsletter_row");
	if(in_new_newsletter_row == 1) return false;
	
	var params="Add_newsletter_row="+true+"&Username="+username+
	"&row_value="+in_new_newsletter_row+
	"&nome="+nome+
	"&cognome="+cognome+
	"&id_group="+id_group;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Ctrltextinput(input_id,max_lenght,empty){
    var input=document.getElementById(input_id);
	if ((input.value==null || input.value=="")&&(empty!=true))
   {
		document.getElementById(input_id).style.border = "1px #F00 solid";
		return 1;
   }
   else if((input.value.length > max_lenght)){
	   alert("Hai inserito troppi caratteri. MAX "+max_lenght+" CAR.");
	   document.getElementById(input_id).style.border = "1px #F00 solid";
	   return 1;
   }else{
		document.getElementById(input_id).style.border = "1px #FFF solid";
		return input.value;		   
   }
   return;
}
function CtrlEmail(input_id){
	var email=document.getElementById(input_id);
	if (email.value==null || email.value=="" || isEmail(email.value)==false)
   {
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
            alert("L'email sembra essere sbagliata: (controlla @ e .)");
            return false;
        }
        var user = matchArray[1];
        var domain = matchArray[2];
        if (user.match(userPat) == null) {
            alert("La parte dell'email prima di '@' non sembra essere valida!");
            return false;
        }
        var IPArray = domain.match(ipDomainPat);
        if (IPArray != null) {
            for (var i = 1; i <= 4; i++) {
                if (IPArray[i] > 255) {
                    alert("L'IP di destinazione non è valido!");
                    return false;
                }
            }
            return true;
        }
        var domainArray = domain.match(domainPat);
        if (domainArray == null) {
            alert("La parte dell'email dopo '@' non sembra essere valida!");
            return false;
        }
        var atomPat = new RegExp(atom, "g");
        var domArr = domain.match(atomPat);
        var len = domArr.length;
        if (domArr[domArr.length - 1].length < 2 ||
            domArr[domArr.length - 1].length > 6) {
            alert("Il dominio di primo livello (es: .com e .it) non sembra essere valido!");
            return false;
        }
        if (len < 2) {
            var errStr = "L'indirizzo manca del dominio!";
            alert(errStr);
            return false;
        }
        return true;
    }
//  End -->
function Add_newsetter_group(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result == "true"){
				document.getElementById("in_new_newsletter_group_name").value = "";
				Refresh_newsletter_group();
				Refresh_newsletter_rows();
				Show_Setting_Saved("gruppo_saved");
			}else{
				Show_Setting_Saved("gruppo_error");
			}
		}
	}
	var username = document.getElementById("in_username").value;
	var nome = document.getElementById("in_new_newsletter_group_name").value;
	var params="Add_newsletter_group="+true+"&Username="+username+
	"&nome="+nome;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Refresh_newsletter_rows(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("select_news_mail_group").selectedIndex = sel_index;
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("select_news_mail").innerHTML = obj.html;
		}
	}
	var sel_index = document.getElementById("select_news_mail_group").selectedIndex;
	var index = document.getElementById("select_news_mail_group").options[sel_index].value;
	var username = document.getElementById("in_username").value;
	var params="Refresh_newsletter_rows="+true+"&Username="+username+"&index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Refresh_newsletter_group(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("select_news_mail_group").innerHTML = obj.html;
			if( obj.html!=""){
				document.getElementById("select_news_mail_group").selectedIndex = 0;
			}
		}
	}

	var username = document.getElementById("in_username").value;
	
	var params="Refresh_newsletter_group="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function in_new_newsletter_row_click(){
	document.getElementById('in_new_newsletter_row').value="";
	document.getElementById('in_new_newsletter_row').onclick="";	
}
function Delete_selected_rows(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("select_news_mail_group").selectedIndex=0;
			Refresh_newsletter_rows();
		}
	}
	var arSelected = new Array(); 
	var ob = document.getElementById("select_news_mail");
	while (ob.selectedIndex != -1) { 
		arSelected.push(ob.options[ob.selectedIndex].value); 
		ob.options[ob.selectedIndex].selected = false; 
	} 
	if(arSelected[0]==null)
		return false;
	var selected_index = JSON.stringify(arSelected);
	var username = document.getElementById("in_username").value;
	var params="Delete_selected_rows="+true+"&Username="+username+
	"&selected_index="+selected_index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Load_newsletter_group(sel_index){
	show_loading();
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("select_news_mail").innerHTML = obj.html;
			document.getElementById("group_active").innerHTML = obj.group_active;
			hide_loading();
		}
	}
	var username = document.getElementById("in_username").value;
	var index = document.getElementById("select_news_mail_group").options[sel_index].value;
	var params="Load_newsletter_group="+true+"&Username="+username+
	"&index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Delete_group(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("select_news_mail_group").selectedIndex = 0;
			Refresh_newsletter_group();
			Refresh_newsletter_rows();
		}
	}
	confirmed = window.confirm("Verranno eliminati tutti i contatti contenuti nel gruppo.Proseguire?");
	if (confirmed)
	{
		var username = document.getElementById("in_username").value;
		var sel_index = document.getElementById("select_news_mail_group").selectedIndex;
		var index = document.getElementById("select_news_mail_group").options[sel_index].value;
		var params="Delete_newsletter_group="+true+"&Username="+username+
		"&index="+index;
		
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "card_handler.php" , true);
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
function Rename_group(){
	var sel_index = document.getElementById("select_news_mail_group").selectedIndex;
	var group_name = document.getElementById("select_news_mail_group").options[sel_index].text;
	var name = prompt("Rinomina il gruppo \""+group_name+"\"", group_name);
	if((name.length > 20)){
	   alert("Hai inserito troppi caratteri. MAX 20 CAR.");
	   return false;
	}
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Refresh_newsletter_group();
			Refresh_newsletter_rows();
		}
	}
	var username = document.getElementById("in_username").value;
	var index = document.getElementById("select_news_mail_group").options[sel_index].value;
	var params="Rename_newsletter_group="+true+"&Username="+username+
	"&name="+name+"&index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function show_loading(){
	document.getElementById("loading_contact").style.display = "inline";	
}
function hide_loading(){
	document.getElementById("loading_contact").style.display = "none";	
}
function Change_group_active(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result=="true"){
				document.getElementById("group_active_opt").checked = "checked";
				document.getElementById('group_active_text').style.color = "#0F0";
				document.getElementById('group_active_text').innerHTML = "Questo gruppo<br/>  riceve le news";	
			}else{
				document.getElementById("group_active_opt").checked = "";
				document.getElementById('group_active_text').style.color = "#F00";
				document.getElementById('group_active_text').innerHTML = "Questo gruppo<br/> non riceve le news";	
			}
			Show_Setting_Saved("group_active_saved");
		}
	}
	var username = document.getElementById("in_username").value;
	var sel_index = document.getElementById("select_news_mail_group").selectedIndex;
	var index = document.getElementById("select_news_mail_group").options[sel_index].value;
	var check = document.getElementById("group_active_opt").checked;
	var params="Change_group_active="+true+"&Username="+username+
	"&check="+check+"&group_id="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function delete_post_pubblica(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("picker_result").innerHTML = "<span <span style='color:#FFF;' class='text12px'>Scegli il giorno in cui verrà pubblicata e inviata la news</span>";
			var api = $(":date").data("dateinput").today();
			Show_Setting_Saved("picker_saved");
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Evidenza_delete_post_pubblica="+true+"&Username="+username;
	
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }	
}
function in_evidenza_click(){
	document.getElementById('in_evidenza').value = "";
	document.getElementById('in_evidenza').onclick = "";
}
function in_evidenza_desc_click(){
	document.getElementById('in_evidenza_desc').value = "";
	document.getElementById('in_evidenza_desc').onclick = "";
}

function crea_nuova(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved("evidenza_new");
			document.getElementById('in_evidenza').value = "Inserisci qui il titolo della tua news...";
			document.getElementById('in_evidenza').onclick = in_evidenza_click;
			document.getElementById('in_evidenza_desc').innerHTML = "Inserisci qui una breve descrizione...";
			document.getElementById('in_evidenza_desc').onclick = in_evidenza_desc_click;
			document.getElementById('div_evidenza_file').innerHTML = ajaxRequest.responseText;
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Evidenza_delete_all="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
