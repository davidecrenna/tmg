// JavaScript Document
function Show_mailing_group(id,index){
	
	$("#mailing_loading").css("display:inline;");
	if(id!=0)
		Select_only_group(id);
	Show_group_actions(index);
	Show_contacts_actions(index);
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			$("#group_selected").val(index);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_mailing_group="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Refresh_move_contact_list(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#move_contact_container").html(ajaxRequest.responseText);
		}
	}
	
	var username = $("#in_username").val()
	var params="Refresh_move_contact_list="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Show_mailing_contact_row(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			Show_contact_actions(index);
			$("#mailing_loading").css("display:none;");
		}
	}
	var username = $("#in_username").val()
	var params="Show_mailing_contact_row="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Update_mailing_contact(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			Show_contact_actions(index);
			$("#mailing_loading").css("display:none;");
		}
	}
	//prendo le informazioni personali
	var name = Ctrltextinput("mod_mailing_contact_nome",45,true);
	var middle_name = Ctrltextinput("mod_mailing_contact_middle_name",45,true);
	var surname = Ctrltextinput("mod_mailing_contact_cognome",45,true);
	var addon = Ctrltextinput("mod_mailing_contact_addon",50,true);
	var nickname = Ctrltextinput("mod_mailing_contact_nickname",500,true);
	
	var tel_home1 = $("#mod_mailing_contact_tel_home1").val();
	var tel_home2 = $("#mod_mailing_contact_tel_home2").val();
	var tel_work1 = $("#mod_mailing_contact_tel_work1").val();
	var tel_work2 = $("#mod_mailing_contact_tel_work2").val();
	var tel_work_fax = $("#mod_mailing_contact_tel_work_fax").val();
	var tel_pager = $("#mod_mailing_contact_tel_pager").val();
	var tel_additional = $("#mod_mailing_contact_tel_additional").val();
	var tel_car = $("#mod_mailing_contact_tel_car").val();
	var tel_home_fax = $("#mod_mailing_contact_tel_home_fax").val();
	var cell = $("#mod_mailing_contact_cell").val();
	
	//prendo le informazioni abitazione
	var home_city = Ctrltextinput("mod_mailing_contact_home_city",50,true);
	var home_region = Ctrltextinput("mod_mailing_contact_home_region",50,true);
	var home_country = Ctrltextinput("mod_mailing_contact_home_country",50,true);
	var home_zip =  Ctrltextinput("mod_mailing_contact_home_zip",20,true);
	var home_street = Ctrltextinput("mod_mailing_contact_home_street",500,true);
	var url_home = Ctrltextinput("mod_mailing_contact_url_home",500,true);
	
	//prendo le informazioni lavoro
	var work_city = Ctrltextinput("mod_mailing_contact_work_city",50,true);
	var work_region = Ctrltextinput("mod_mailing_contact_work_region",50,true);
	var work_country = Ctrltextinput("mod_mailing_contact_work_country",50,true);
	var work_zip =  Ctrltextinput("mod_mailing_contact_work_zip",20,true);
	var work_street = Ctrltextinput("mod_mailing_contact_work_street",500,true);
	var url_work = Ctrltextinput("mod_mailing_contact_url_work",500,true);
	
	var organisation = Ctrltextinput("mod_mailing_contact_organisation",500,true);
	var title = Ctrltextinput("mod_mailing_contact_title",500,true);
	var departement = Ctrltextinput("mod_mailing_contact_departement",500,true);
	var company =  Ctrltextinput("mod_mailing_contact_company",500,true);
	
	var note =  f("mod_mailing_contact_note");
	
	//prendo le email
	var i=0;
	var emails = new Array();
	
	var emails_num = $("#mod_mailing_contact_emails_num").val();
	for(i=0;i<emails_num;i++){
		if($("#mod_mailing_contact_emails_"+i).val()!=""){
			emails.push($("#mod_mailing_contact_emails_"+i).val());
		}
	}
	
	
	//prendo gli url
	i=0;
	var urls = new Array();
	
	var urls_num = $("#mod_mailing_contact_urls_num").val();
	for(i=0;i<urls_num;i++){
		if($("#mod_mailing_contact_urls_"+i).val()!=""){
			urls.push($("#mod_mailing_contact_urls_"+i).val());
		}
	}
	
	var username = $("#in_username").val()
	var params="Update_mailing_contact_row="+true+"&Username="+username+"&index="+index+
	"&name="+name+
	"&middle_name="+middle_name+
	"&surname="+surname+
	"&addon="+addon+
	"&nickname="+nickname+
	"&tel_home1="+tel_home1+
	"&tel_home2="+tel_home2+
	"&tel_work1="+tel_work1+
	"&tel_work2="+tel_work2+
	
	"&tel_work_fax="+tel_work_fax+
	"&tel_home_fax="+tel_home_fax+
	"&tel_pager="+tel_pager+
	"&tel_additional="+tel_additional+
	"&tel_car="+tel_car+
	"&tel_home_fax="+tel_home_fax+
	"&cell="+cell+
	
	"&home_city="+home_city+
	"&home_region="+home_region+
	"&home_country="+home_country+
	"&home_zip="+home_zip+
	"&home_street="+home_street+
	"&url_home="+url_home+
	
	"&organisation="+organisation+
	"&title="+title+
	"&departement="+departement+
	"&company="+company+
	"&work_city="+work_city+
	"&work_region="+work_region+
	"&work_country="+work_country+
	"&work_zip="+work_zip+
	"&work_street="+work_street+
	"&url_work="+url_work+
	"&note="+note+
	"&emails="+ JSON.stringify(emails)+"&urls="+ JSON.stringify(urls);
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Prepare_Mod_mailing_contact(index){
	$("#mailing_loading").css("display:inline;");
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			Show_contact_save_actions(index);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Mod_mailing_contact_row="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Return_mailing_group(){
	var index =$("#group_selected").val();
	Show_mailing_group(0,index);
	Show_contacts_actions(index);
}

function Select_all_email_mailing_contact(){
	var ck = document.getElementsByClassName("col-mailing-contact-select");
	for(var i = 0; i < ck.length; i++)
		if((ck[i].type == 'checkbox')){
			if(ck[i].checked != ""){
  				ck[i].checked="";
			}else{
				ck[i].checked = "true";
			}
	}
}
function Select_only_group(id){
	var ck = document.getElementsByClassName("mailing_group_row");
	for(var i = 0; i < ck.length; i++){
		if((i%2)==0)
			ck[i].style.backgroundColor="#8b8b8b";
		else
			ck[i].style.backgroundColor="#838383";
	}
	id.style.backgroundColor="#A8A8A8";
	id.style.border = "1px solid #000";
}
function Show_mailing_groups(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_loading").css("display:none;");
			$("#mailing_groups_container").html(ajaxRequest.responseText);
			 Show_mailing_group(0,index);
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_mailing_groups="+true+"&Username="+username+"&selected="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_group_actions(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_groups_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_group_actions="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_contact_save_actions(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_contact_save_actions="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_new_contact_save_actions(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_new_contact_save_actions="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_contacts_actions(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_contacts_actions="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_contact_actions(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_contact_actions="+true+"&Username="+username+"&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_send_group_actions(){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_action_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var username = $("#in_username").val()
	var params="Show_send_group_actions="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Delete_group(index){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_loading").css("display:none;");
			Show_mailing_groups(0);
		}
	}
	confirmed = window.confirm("Verranno eliminati tutti i contatti contenuti nel gruppo.Proseguire?");
	if (confirmed)
	{
		var username = $("#in_username").val()
		var params="Delete_newsletter_group="+true+"&Username="+username+
		"&index="+index;
		
		ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		$("#mailing_loading").css("display:none;");
		return false;
	}
	
}
function Rename_group(index,group_name,selected){
	$("#mailing_loading").css("display:inline;");
	var name = prompt("Rinomina il gruppo \""+group_name+"\"", group_name);
	if((name.length > 20)){
	   alert("Hai inserito troppi caratteri. MAX 20 CAR.");
	   $("#mailing_loading").css("display:none;");
	   return false;
	}
	if(name==""){
		$("#mailing_loading").css("display:none;");
		return false;
	}
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_loading").css("display:none;");
			Show_mailing_groups(selected);
		}
	}
	var username = $("#in_username").val()
	var params="Rename_newsletter_group="+true+"&Username="+username+
	"&name="+name+"&index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Add_group(){
	$("#add_new_group").html("<input type='text' id='in_new_newsletter_group_name'  onkeydown='Invio_on_addgroup(event);'>&nbsp;<div class='personal_button' id='submit_friend' onclick='Add_newsetter_group();' style='margin-top: 0px; width:25px; height:13px;'><span class='text14px' style='color:#FFF; position:relative; top:-3px;'>OK</a></div>");
}

function Invio_on_addgroup(e){
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
        Add_newsetter_group();
   }
}
function Invio_on_addcontact(e){
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
        Add_newsletter_row();
   }
}
function Invio_on_modcontact(e,id){
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
        Mod_newsletter_row(id);
   }
}
function Add_newsetter_group(){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result == "true"){
				Refresh_move_contact_list();
				$("#add_new_group").html("");
				Show_mailing_groups(0);
				$("#mailing_loading").css("display:none;");
				Show_Setting_Saved("mailing_add_group_success");
				
			}else{
				$("#mailing_loading").css("display:none;");
				Show_Setting_Saved("mailing_add_group_error");
			}
		}
	}
	var username = $("#in_username").val()
	var nome = Ctrltextinput("in_new_newsletter_group_name",20);
	if(nome==1){
		$("#mailing_loading").css("display:none;");
		return false;
	}
	var params="Add_newsletter_group="+true+"&Username="+username+
	"&nome="+nome;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Add_contact(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			 Prepare_Add_new_mailing_contact(ajaxRequest.responseText);
			 var group_selected = $("#group_selected").val();
			 Show_new_contact_save_actions(group_selected);
		}
	}
	var username = $("#in_username").val();
	var params="Get_newsletter_num="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Prepare_Add_new_mailing_contact(index){
	$("#mailing_loading").css("display:inline;");
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var group_selected = $("#group_selected").val();
	var username = $("#in_username").val();
	var params="Add_mailing_contact_row="+true+"&Username="+username+"&index="+index+"&id_group="+group_selected;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Prepare_send_groups_email(){
	$("#mailing_loading").css("display:inline;");
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mailing_contacts_container").html(ajaxRequest.responseText);
			Show_send_group_actions();
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var group_selected = $("#group_selected").val();
	var username = $("#in_username").val();
	var params="Prepare_send_groups_email="+true+"&Username="+username+"&id_group="+group_selected;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Send_groups_email(){
	$("#mailing_loading").css("display:inline;");
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved("mailing_send_group_mail_success");	
			Return_mailing_group();	
			$("#mailing_loading").css("display:none;");
		}
	}
	
	var subject = $("#mailing_send_groups_email_subject").val();
	var email_body = Ctrltextinput("mailing_send_groups_email_body",1500,true);
	var i=0;
	var emails = new Array();
	
	var emails_num = $("#mailing_send_groups_emails_num").val();
	for(i=0;i<emails_num;i++){
		if($("#mailing_send_groups_email_emails_"+i).val()!=""){
			if($("#mailing_send_groups_email_emails_check_"+i).is(':checked'))
				emails.push($("#mailing_send_groups_email_emails_"+i).val());
		}
	}
	
	var group_selected = $("#group_selected").val();
	var username = $("#in_username").val();
	var params="Send_groups_email="+true+"&Username="+username+
	"&subject="+subject+
	"&body="+email_body+
	"&to="+ JSON.stringify(emails);
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Add_new_mailing_contact(id_group){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved("mailing_add_contact_success");			
			Return_mailing_group();		
			$("#mailing_loading").css("display:none;");
		}
	}
	//prendo le informazioni personali
	var name = Ctrltextinput("mod_mailing_contact_nome",45,true);
	var middle_name = Ctrltextinput("mod_mailing_contact_middle_name",45,true);
	var surname = Ctrltextinput("mod_mailing_contact_cognome",45,true);
	var addon = Ctrltextinput("mod_mailing_contact_addon",50,true);
	var nickname = Ctrltextinput("mod_mailing_contact_nickname",500,true);
	
	//prendo i telefoni
	/* 
	var tel_home1 = $("#mod_mailing_contact_tel_home1").val();
	if(is_num(tel_home1)){
		return false;	
	}
	*/
	var tel_home1 = $("#mod_mailing_contact_tel_home1").val();
	var tel_home2 = $("#mod_mailing_contact_tel_home2").val();
	var tel_work1 = $("#mod_mailing_contact_tel_work1").val();
	var tel_work2 = $("#mod_mailing_contact_tel_work2").val();
	var tel_work_fax = $("#mod_mailing_contact_tel_work_fax").val();
	var tel_pager = $("#mod_mailing_contact_tel_pager").val();
	var tel_additional = $("#mod_mailing_contact_tel_additional").val();
	var tel_car = $("#mod_mailing_contact_tel_car").val();
	var tel_home_fax = $("#mod_mailing_contact_tel_home_fax").val();
	var cell = $("#mod_mailing_contact_cell").val();
	
	//prendo le informazioni abitazione
	var home_city = Ctrltextinput("mod_mailing_contact_home_city",50,true);
	var home_region = Ctrltextinput("mod_mailing_contact_home_region",50,true);
	var home_country = Ctrltextinput("mod_mailing_contact_home_country",50,true);
	var home_zip =  Ctrltextinput("mod_mailing_contact_home_zip",20,true);
	var home_street = Ctrltextinput("mod_mailing_contact_home_street",500,true);
	var url_home = Ctrltextinput("mod_mailing_contact_url_home",500,true);
	
	//prendo le informazioni lavoro
	var work_city = Ctrltextinput("mod_mailing_contact_work_city",50,true);
	var work_region = Ctrltextinput("mod_mailing_contact_work_region",50,true);
	var work_country = Ctrltextinput("mod_mailing_contact_work_country",50,true);
	var work_zip =  Ctrltextinput("mod_mailing_contact_work_zip",20,true);
	var work_street = Ctrltextinput("mod_mailing_contact_work_street",500,true);
	var url_work = Ctrltextinput("mod_mailing_contact_url_work",500,true);
	
	var organisation = Ctrltextinput("mod_mailing_contact_organisation",500,true);
	var title = Ctrltextinput("mod_mailing_contact_title",500,true);
	var departement = Ctrltextinput("mod_mailing_contact_departement",500,true);
	var company =  Ctrltextinput("mod_mailing_contact_company",500,true);
	var group_selected = $("#group_selected").val();
	
	var note =  f("mod_mailing_contact_note");
	
	//prendo le email
	var i=0;
	var emails = new Array();
	
	var emails_num = $("#mod_mailing_contact_emails_num").val();
	for(i=0;i<emails_num;i++){
		if($("#mod_mailing_contact_emails_"+i).val()!=""){
			emails.push($("#mod_mailing_contact_emails_"+i).val());
		}
	}
	
	
	//prendo gli url
	i=0;
	var urls = new Array();
	
	var urls_num = $("#mod_mailing_contact_urls_num").val();
	for(i=0;i<urls_num;i++){
		if($("#mod_mailing_contact_urls_"+i).val()!=""){
			urls.push($("#mod_mailing_contact_urls_"+i).val());
		}
	}
	
	var username = $("#in_username").val()
	var params="Add_new_mailing_contact_row="+true+"&Username="+username+
	"&name="+name+
	"&middle_name="+middle_name+
	"&surname="+surname+
	"&addon="+addon+
	"&nickname="+nickname+
	"&tel_home1="+tel_home1+
	"&tel_home2="+tel_home2+
	"&tel_work1="+tel_work1+
	"&tel_work2="+tel_work2+
	
	"&tel_work_fax="+tel_work_fax+
	"&tel_home_fax="+tel_home_fax+
	"&tel_pager="+tel_pager+
	"&tel_additional="+tel_additional+
	"&tel_car="+tel_car+
	"&tel_home_fax="+tel_home_fax+
	"&cell="+cell+
	
	"&home_city="+home_city+
	"&home_region="+home_region+
	"&home_country="+home_country+
	"&home_zip="+home_zip+
	"&home_street="+home_street+
	"&url_home="+url_home+
	
	"&organisation="+organisation+
	"&title="+title+
	"&departement="+departement+
	"&company="+company+
	"&work_city="+work_city+
	"&work_region="+work_region+
	"&work_country="+work_country+
	"&work_zip="+work_zip+
	"&work_street="+work_street+
	"&url_work="+url_work+
	"&note="+note+
	"&emails="+ JSON.stringify(emails)+"&urls="+ JSON.stringify(urls)+"&id_group="+group_selected;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Mod_contact(){
	var group_selected = $("#group_selected").val();
	if(group_selected==0){
		alert("Non puoi modificare il gruppo \"richieste di contatto\". Puoi creare o spostare i contatti in un altro gruppo per effettuare modifiche.");
		$("#mailing_loading").css("display:none;");
		return false;
	}
	var arSelected = new Array(); 
	var ck = document.getElementsByClassName("col-mailing-contact-select");
	for(var i = 0; i < ck.length; i++){
		if((ck[i].type == 'checkbox')){
			if(ck[i].checked != ""){
  				arSelected.push(ck[i].value);
			}
		}
	}
	if(arSelected[0]==null){
		alert("Non hai selezionato nessun contatto.");
		$("#mailing_loading").css("display:none;");
		return false;
	}
	if(arSelected.length>1){
		alert("Puoi modificare un solo contatto alla volta.");
		$("#mailing_loading").css("display:none;");
		return false;
	}
	
	var index =arSelected[0];
	
	Prepare_Mod_mailing_contact(index);
}
function Add_newsletter_row(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("in_new_newsletter_row").value="";
			document.getElementById("in_new_newsletter_name").value="";
			document.getElementById("in_new_newsletter_surname").value="";
			document.getElementById("in_new_newsletter_cell").value="";
			 Show_mailing_groups(id_group);
			Show_Setting_Saved("mailing_add_contact_success");
		}
	}
	var username = $("#in_username").val()
	var nome = Ctrltextinput("in_new_newsletter_name",20);
	if(nome == 1) return false;
	var cognome = Ctrltextinput("in_new_newsletter_surname",20);
	if(cognome == 1) return false;
	
	var id_group = document.getElementById("group_selected").value;
	var in_new_newsletter_row = CtrlEmail("in_new_newsletter_row");
	if(in_new_newsletter_row == 1) 
		return false;
		
	var cell = document.getElementById("in_new_newsletter_cell").value;
	
	var params="Add_newsletter_row="+true+"&Username="+username+
	"&row_value="+in_new_newsletter_row+
	"&nome="+nome+
	"&cognome="+cognome+
	"&cell="+cell+
	"&id_group="+id_group;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Delete_mailing_selected_contact(){
	$("#mailing_loading").css("display:inline;");
	
	/*var group_selected = document.getElementById("group_selected").value;
	if(group_selected==0){
		alert("Non puoi modificare il gruppo \"richieste di contatto\". Puoi creare o spostare i contatti in un altro gruppo per effettuare modifiche.");
		document.getElementById('mailing_loading').style.display = "none";
		return false;
	}*/
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_mailing_groups(id_group);
			Show_Setting_Saved("mailing_del_contact_success");
		}
	}
	var arSelected = new Array(); 
	var ck = document.getElementsByClassName("col-mailing-contact-select");
	for(var i = 0; i < ck.length; i++){
		if((ck[i].type == 'checkbox')){
			if(ck[i].checked != ""){
  				arSelected.push(ck[i].value);
			}
		}
	}
	if(arSelected[0]==null){
		alert("Non hai selezionato nessun contatto.");
		$("#mailing_loading").css("display:none;");
		return false;
	}
	var id_group = $("#group_selected").val();
	var selected_index = JSON.stringify(arSelected);
	var username = $("#in_username").val()
	var params="Delete_selected_rows="+true+"&Username="+username+
	"&selected_index="+selected_index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Delete_mailing_contact(index){
	$("#mailing_loading").css("display:inline;");
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			var id_group = $("#group_selected").val();
			Show_mailing_groups(id_group);
			Show_Setting_Saved("mailing_del_contact_success");
		}
	}
	
	var username = $("#in_username").val()
	var params="Delete_mailing_contact="+true+"&Username="+username+
	"&index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Move_selected_mailing_contact(){
	$("#mailing_loading").css("display:inline;");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Refresh_move_contact_list();
			var id_group = $("#group_selected").val();
			Show_mailing_groups(id_group);
			Show_Setting_Saved("mailing_move_contact_success");
		}
	}
	var arSelected = new Array(); 
	var ck = document.getElementsByClassName("col-mailing-contact-select");
	for(var i = 0; i < ck.length; i++){
		if((ck[i].type == 'checkbox')){
			if(ck[i].checked != ""){
  				arSelected.push(ck[i].value);
			}
		}
	}
	if(arSelected[0]==null){
		$("#mailing_loading").css("display:none;");
		alert("Devi selezionare uno o più contatti prima!");
		Refresh_move_contact_list();
		return false;
	}
	
	var e = document.getElementById("move_contact");
	var id_group = e.options[e.selectedIndex].value;
	var selected_index = JSON.stringify(arSelected);
	var username = $("#in_username").val()
	var params="Move_selected_rows="+true+"&Username="+username+
	"&selected_index="+selected_index+"&id_group="+id_group;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Invio_om_Add_mailing_contacts_email(e){
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
	  Add_mailing_contacts_email()	
   }
}
function Add_mailing_contacts_email(){
	var new_email =$("#mod_mailing_contact_emails_new_row").val();
	if(isEmail(new_email)==false){
		return;
	}
	if(new_email == ""&& new_email == null){
		alert("Devi inserire un contatto email valido");
		return;
	}
	var new_email_index = $("#mod_mailing_contact_emails_num").val();
	
	$('#mailing_contacts_emails_div').append('<div id="mailing_contact_emails_div_'+new_email_index+'"><input type="text" value="'+new_email+'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_emails_'+new_email_index+'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>');
	new_email_index++;
	$("#mod_mailing_contact_emails_new_row").val("");
	$("#mod_mailing_contact_emails_num").val(new_email_index);
	Show_Setting_Saved("mailing_add_contact_success");
}

function Invio_om_Add_mailing_contacts_url(e){
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
	  Add_mailing_contacts_url()	
   }
}
function Add_mailing_contacts_url(){
	var new_url =$("#mod_mailing_contact_urls_new_row").val();
	
	if(new_url == ""&& new_url == null){
		alert("Devi inserire un url valido");
		return;
	}
	var new_url_index = $("#mod_mailing_contact_urls_num").val();
	
	$('#mailing_contacts_urls_div').append('<div id="mailing_contact_urls_div_'+new_url_index+'"><input type="text" value="'+new_url+'" class="personal_area_mod_mailing_contact" id="mod_mailing_contact_urls_'+new_url_index+'" style="width: 190px;"></input> <a target="self" onclick="Javascript: Hide_emails_contact(this)">Elimina</a></div>');
	new_url_index++;
	$("#mod_mailing_contact_urls_new_row").val("");
	$("#mod_mailing_contact_urls_num").val(new_url_index);
	Show_Setting_Saved("mailing_add_contact_success");
}


function Hide_emails_contact(id){
	$(id).parent().remove();
}