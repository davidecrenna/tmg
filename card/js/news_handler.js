// JavaScript Document
function select_news_row(id,index){
	var checkbox = document.getElementById("check_news_"+index);
	if(checkbox.checked==""){
		document.getElementById("news_row_"+index).style.backgroundColor="#A8A8A8";
		document.getElementById("check_news_"+index).checked = "checked";
	}else{
		if((index%2)==0)
			document.getElementById("news_row_"+index).style.backgroundColor="#8b8b8b";
		else
			document.getElementById("news_row_"+index).style.backgroundColor="#838383";
		
		document.getElementById("check_news_"+index).checked = "";
	}
}


function create_new_news(){
	document.getElementById("news_loading").style.display = "block";
	document.getElementById("main").style.display = "none";
	document.getElementById("in_evidenza_subtitle").value="Inserisci qui la data o il periodo dell'evento/news.";
	document.getElementById("in_evidenza").value="Inserisci qui il titolo dell'evento/news.";
	document.getElementById("in_evidenza_desc").value="Inserisci una descrizione dell'evento/news.";
	
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result!="true"){
				document.getElementById("new_news_id").value = obj.new_news_id;
				Load_evidenza_file(obj.new_news_id);
				document.getElementById("new").style.display = "block";
				document.getElementById("news_loading").style.display = "none";
			}else{
				document.getElementById("news_loading").style.display = "none";
				Show_Setting_Saved("error_creating");
			}
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Create_new_news="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Show_news(index){
	document.getElementById("news_loading").style.display = "block";
	document.getElementById("main").style.display = "none";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			$("#showed_news_id").val(obj.showed_news_id);
			Load_evidenza_mod_file(obj.showed_news_id);
			$("#in_mod_evidenza").val(obj.in_mod_evidenza);
			$("#in_mod_evidenza_subtitle").val(obj.in_mod_evidenza_subtitle);
			$("#in_mod_evidenza_desc").val(obj.in_mod_evidenza_desc);
			
			$("#mod").css("display","block");
			$("#news_loading").css("display","none");
		}
	}
	
	var username = $("#in_username").val();
	var params="Show_news="+true+"&Username="+username+"&news_index="+index;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Load_evidenza_file(new_news_id){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#div_evidenza_file").html(ajaxRequest.responseText);
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Load_evidenza_file="+true+"&Username="+username;
	params+="&new_news_id="+new_news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Load_evidenza_mod_file(showed_news_id){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#div_evidenza_mod_file").html(ajaxRequest.responseText);
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Load_evidenza_mod_file="+true+"&Username="+username;
	params+="&showed_news_id="+showed_news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}



function in_evidenza_click(){
	document.getElementById('in_evidenza').value = "";
	document.getElementById('in_evidenza').onclick = "";
}
function in_evidenza_subtitle_click(){
	document.getElementById('in_evidenza_subtitle').value = "";
	document.getElementById('in_evidenza_subtitle').onclick = "";
}
function in_evidenza_desc_click(){
	document.getElementById('in_evidenza_desc').value = "";
	document.getElementById('in_evidenza_desc').onclick = "";
}
function CuteWebUI_AjaxUploader_OnQueueUI(list)
{
	return false;
}

function Aggiorna_evidenza(file_name,news_id){
	document.getElementById('div_evidenza_file').style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#div_evidenza_file").html(ajaxRequest.responseText);
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Get_evidenza_desc="+true+"&Username="+username;
	params+="&file_name="+file_name;
	params+="&news_id="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Aggiorna_evidenza_mod(file_name,news_id){
	document.getElementById('div_evidenza_mod_file').style.display="block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#div_evidenza_mod_file").html(ajaxRequest.responseText);
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Get_evidenza_mod_desc="+true+"&Username="+username;
	params+="&file_name="+file_name;
	params+="&news_id="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Delete_evidenza_file(){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#div_evidenza_file").html(ajaxRequest.responseText);
			document.getElementById("news_loading").style.display = "none";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var news_id = document.getElementById("new_news_id").value;
	var params="Delete_evidenza_file="+true+"&Username="+username+"&news_id="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Delete_evidenza_mod_file(){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById("div_evidenza_mod_file").innerHTML = ajaxRequest.responseText;
			$("#div_evidenza_mod_file").html(ajaxRequest.responseText);
			document.getElementById("news_loading").style.display = "none";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var news_id = document.getElementById("showed_news_id").value;
	var params="Delete_evidenza_mod_file="+true+"&Username="+username+"&news_id="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function go_to_mod_news_second_step(){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved("news_saved");
			document.getElementById("news_loading").style.display = "none"; 
			Show_mod_news_second_step(news_id);
		}
	}
	
	var title = Ctrltextinput("in_mod_evidenza",35,true);
	if(title == 1){
		document.getElementById("news_loading").style.display = "none"; 
		return false;
	}
	
	var subtitle = Ctrltextinput("in_mod_evidenza_subtitle",35,true);
	if(subtitle == 1){
		document.getElementById("news_loading").style.display = "none"; 
		return false;
	}
	
	var desc = Ctrltextinput("in_mod_evidenza_desc",0,true);
	if(desc == 1){
		document.getElementById("news_loading").style.display = "none"; 
		return false;
	}
	
	var username = document.getElementById("in_username").value;
	var file = document.getElementById('in_evidenza_mod_file').value;
	var news_id = document.getElementById("showed_news_id").value;
	
	var params="Save_new_news_first_step="+true+"&Username="+username;
	params+="&title="+title;
	params+="&subtitle="+subtitle;
	params+="&desc="+desc;
	params+="&file="+file;
	params+="&id_row="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function return_to_new_news_first_step(){
	document.getElementById("new2").style.display = "none";
	document.getElementById("calroot").style.display = "none";
	document.getElementById("calendario_div").style.display="none";
	document.getElementById("new").style.display = "block";
}
function return_to_mod_news_first_step(){
	document.getElementById("mod2").style.display = "none";
	document.getElementById("mod_calendario_div").style.display="none";
	document.getElementById("mod").style.display = "block";
}


function return_riepilogo_news(){
	confirmed = window.confirm("Tornando al riepilogo news la news corrente non verrà creata o modificata. Proseguire?");
	if (confirmed)
	{
		document.getElementById("mod").style.display = "none";
		document.getElementById("mod2").style.display = "none";
		document.getElementById("new").style.display = "none";
		document.getElementById("new2").style.display = "none";
		document.getElementById("calendario_div").style.display="none";
		document.getElementById("calroot").style.display = "none";
		document.getElementById("main").style.display = "block";
		Refresh_riepilogo_news();
		Refresh_riepilogo_news_now();
	} 
	else 
	{
		return false;
	}
}
function return_riepilogo_news_from_mod(){
	document.getElementById("mod").style.display = "none";
	document.getElementById("mod2").style.display = "none";
	document.getElementById("calendario_div").style.display="none";
	document.getElementById("calroot").style.display = "none";
	document.getElementById("main").style.display = "block";
	Refresh_riepilogo_news();
	Refresh_riepilogo_news_now();
}


function go_to_new_news_second_step(){
	$("#news_loading").css("display","block");
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			Show_Setting_Saved("news_saved");
			$("#news_loading").css("display","none"); 
			Show_new_news_second_step();
		}
	}
	var title = $("#in_evidenza").val();
	
	if(title == 1){
		$("#news_loading").css("display","none");
	 	return false;
	}
	
	var subtitle = $("#in_evidenza_subtitle").val();
	
	var desc = Ctrltextinput("in_evidenza_desc",0);
	
	var desc = f("in_evidenza_desc");
	if(desc == 1){
		$("#news_loading").css("display","none");
		return false;
	}
	
	var username = $("#in_username").val();
	var file = $('#in_evidenza_file').val();
	var id_row = $("#new_news_id").val();
	
	var params="Save_new_news_first_step="+true+"&Username="+username;
	params+="&title="+title;
	params+="&subtitle="+subtitle;
	params+="&desc="+desc;
	params+="&file="+file;
	params+="&id_row="+id_row;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Show_new_news_second_step(){
	document.getElementById("new").style.display = "none";
	document.getElementById("new2").style.display = "block";
	
	document.getElementById("calendario_div").style.display="block";
	document.getElementById("calroot").style.display = "block";
	$("#table_selected_container").html("");
	Load_mailing_list_groups();
	
	$.tools.dateinput.localize("it", {
	months:'Gennaio,Febbraio,Marzo,Aprile,Maggio,Giugno,Luglio,Agosto,Settembre,Ottobre,Novembre,Dicembre',
	shortMonths:  'Gen,Feb,Mar,Apr,Mag,Giu,Lug,Ago,Set,Ott,Nov,Dic',
	days:        'Domenica,Lunedì,Martedì,Mercoledì,Giovedì,Venerdì,Sabato',
	shortDays:    'Dom,Lun,Mar,Mer,Gio,Ven,Sab'
  });
  $("#data_posticipa").dateinput( {
	  lang: "it",
	  format: 'dd mmmm yyyy',
	  min: -1,
	  
  }).data("dateinput").setValue(0).show();
  
}

function finish_new_return_main(){
	document.getElementById("news_loading").style.display = "block";
	var data = $(":date").data("dateinput").getValue('yyyy-mm-dd');
	var today = new Date();
	var data_today = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();
	if(data==data_today){
		confirmed = window.confirm("Verrà inviata una mail contenente il tuo evento ai contatti selezionati.");
		if (!confirmed){
			return false;
		}
	}
	
	var sendto="";
	$('#table_selected_container').find(".mailing_group_selected_id").each(function() {
		var id_group =$(this).val();
		sendto+=id_group+",";
	});

	
	if(sendto=="")
		sendto="none";
		
	var check_alt=0;
	if($("#check_alternative_address").is(':checked')){
		check_alt = 1;
	}
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				document.getElementById("news_loading").style.display = "none"; 
				Show_Setting_Saved("news_saved");
				document.getElementById("calroot").style.display = "none";
				return_main();
				Refresh_riepilogo_news();
			}
		}
	}
	
	var username = document.getElementById("in_username").value;
	var id_row = document.getElementById("new_news_id").value;
	
	var params="Save_new_news_second_step="+true+"&Username="+username+"&data="+data+"&sendto="+sendto;
	params+="&id_row="+id_row;
	params+="&check_alt="+check_alt;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

/*function finish_return_main(){
	document.getElementById("news_loading").style.display = "block";
	
	var sendto="";
	$('#table_selected_container').find(".mailing_group_selected_id").each(function() {
		var id_group =$(this).val();
		sendto+=id_group+",";
	});
	
	
	
	
	if(sendto=="")
		sendto="none";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("news_loading").style.display = "none"; 
			return_main();
			Refresh_riepilogo_news();
		}
	}
	var check_alt=0;
	if($("#check_alternative_address").is(':checked')){
		check_alt = 1;
	}
	
	var username = document.getElementById("in_username").value;
	var id_row = document.getElementById("new_news_id").value;
	
	var params="Save_new_news_third_step="+true+"&Username="+username+"&sendto="+sendto;
	params+="&id_row="+id_row;
	params+="&check_alt="+check_alt;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}*/


function Show_mod_news_second_step(news_id){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			$("#mod_data_posticipa").data("dateinput").setValue(obj.data);
			
			document.getElementById("mod").style.display = "none";
			document.getElementById("mod2").style.display = "block";
			//document.getElementById("callroot").style.display = "block";
			document.getElementById("mod_calendario_div").style.display = "block";
			document.getElementById("news_loading").style.display = "none";
			Load_mod_mailing_list_groups();
			Load_mod_saved_mailing_list_groups();
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Show_news_second_step="+true+"&Username="+username+"&news_id="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}



function change_check_no_posticipa(id){
	if(id.checked==""){
		document.getElementById("calendario_div").style.display="block";
		document.getElementById("calroot").style.display = "block";
	}else{
		document.getElementById("calendario_div").style.display="none";
		document.getElementById("calroot").style.display = "none";
	}
}


function Finish_mod_return_main(){
	document.getElementById("news_loading").style.display = "block";
	
	var data = $("#mod_data_posticipa").data("dateinput").getValue('yyyy-mm-dd');
	var sendto="";
	$('#mod_table_selected_container').find(".mailing_group_selected_id").each(function() {
		var id_group =$(this).val();
		sendto+=id_group+",";
	});

	
	if(sendto=="")
		sendto="none";
	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				document.getElementById("news_loading").style.display = "none"; 
				Show_Setting_Saved("news_saved");
				document.getElementById("calroot").style.display = "none";
				document.getElementById("mod_calendario_div").style.display = "none";
				document.getElementById("news_loading").style.display = "none"; 
				return_main();
				Refresh_riepilogo_news();
			}else{
				document.getElementById("news_loading").style.display = "none";
				alert("Nella data selezionata è già presente una news. Seleziona un altra data.");
				Show_Setting_Saved("error_saving_data");
			}
		}
	}
	
	var username = document.getElementById("in_username").value;
	var news_id = document.getElementById("showed_news_id").value;
	
	var params="Save_new_news_second_step="+true+"&Username="+username+"&data="+data+"&sendto="+sendto;
	params+="&id_row="+news_id;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Show_new_news_third_step(){
	document.getElementById("new2").style.display = "none";
	//document.getElementById("table_selected_container").innerHTML="";
	$("#table_selected_container").html("");
	document.getElementById("new3").style.display = "block";
	Load_mailing_list_groups();
}


function Select_mailing_group(id,index){
	var selected_group_id = document.getElementById("mailing_group_id_"+index).value;
	var selected_group_name = document.getElementById("mailing_group_name_"+index).value;
	var ctrl=0;
	var conta=0;
	$('#table_selected_container tr').each(function() {
    	var id_group = $(this).find(".mailing_group_selected_id").val();
		if(selected_group_id==id_group){
			ctrl=1;
		}
		conta++;
 	});
	conta++;
	if(ctrl!=1){
		var backcolor;
		if((conta%2)!=0)
			backcolor="#8b8b8b";
		else
			backcolor="#838383";
		$("#table_selected_container").append("<tr style='background-color:"+backcolor+"; cursor:pointer;'; onclick='Deselect_mailing_group(this,\""+index+"\")' id='selected_tr_"+index+"'><td><img src='../../image/icone/arrow-left.png' style='width:15px; height:15px;'></td><td class='mailing_group_selected_cell'>"+selected_group_name+"<input type='hidden' class='mailing_group_selected_id' value='"+selected_group_id+"'><input type='hidden' class='mailing_group_selected_name' value='"+selected_group_name+"'></td></tr>");
	}
}
function Select_mailing_group_mod(id,index){
	var selected_group_id = document.getElementById("mailing_group_id_"+index).value;
	var selected_group_name = document.getElementById("mailing_group_name_"+index).value;
	var ctrl=0;
	var conta=0;
	$('#mod_table_selected_container').each(function() {
    	var id_group = $(this).find(".mailing_group_selected_id").val();
		if(selected_group_id==id_group){
			ctrl=1;
		}
		conta++;
 	});
	conta++;
	if(ctrl!=1){
		var backcolor;
		if((conta%2)!=0)
			backcolor="#8b8b8b";
		else
			backcolor="#838383";
		$("#mod_table_selected_container").append("<tr style='background-color:"+backcolor+"; cursor:pointer;'; onclick='Deselect_mailing_group(this,\""+index+"\")' id='selected_tr_"+index+"'><td><img src='../../image/icone/arrow-left.png' style='width:15px; height:15px;'></td><td class='mailing_group_selected_cell'>"+selected_group_name+"<input type='hidden' class='mailing_group_selected_id' value='"+selected_group_id+"'><input type='hidden' class='mailing_group_selected_name' value='"+selected_group_name+"'></td></tr>");
	}
}
function Deselect_mailing_group(id,index){
	$(id).remove();
}
function change_check_nosendto(id){
	if(id.checked==""){
		document.getElementById("gruppi_select_main_container").style.display="block";
	}else{
		document.getElementById("gruppi_select_main_container").style.display="none";
	}
}
function change_check_nosendto_mod(id){
	if(id.checked==""){
		document.getElementById("gruppi_select_main_container_mod").style.display="block";
	}else{
		document.getElementById("gruppi_select_main_container_mod").style.display="none";
	}
}





function return_main(){
	document.getElementById("new2").style.display = "none";
	document.getElementById("mod2").style.display = "none";
	document.getElementById("main").style.display = "block";
	Show_Setting_Saved("news_saved");
}
function Refresh_riepilogo_news(){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById("riepilogo_news_container").innerHTML = ajaxRequest.responseText;
			$("#riepilogo_news_container").html(ajaxRequest.responseText);
			document.getElementById("news_loading").style.display = "none";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Refresh_riepilogo_news="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Refresh_riepilogo_news_now(){
	document.getElementById("news_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById("riepilogo_news_now_container").innerHTML = ajaxRequest.responseText;
			$("#riepilogo_news_now_container").html(ajaxRequest.responseText);
			document.getElementById("news_loading").style.display = "none";
		}
	}
	
	var username = document.getElementById("in_username").value;
	var params="Refresh_riepilogo_news_now="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Delete_selected_news(){
	document.getElementById('news_loading').style.display = "inline";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('news_loading').style.display = "none";
			Refresh_riepilogo_news();
		}
	}
	var ck = document.getElementsByClassName("col-news-select");
	var index = new Array();
	var j=0;
	for(var i = 0; i < ck.length; i++)
		if((ck[i].type == 'checkbox') && ck[i].checked ) {
			index[j]= ck[i].value;
			j++;
	}
	if(index==""){
		alert("Non hai selezionato messaggi!");
		document.getElementById('news_loading').style.display = "none";
		return false;
	}else{
		confirmed = window.confirm("Sei sicuro di voler eliminare le news selezionate?");
		if (confirmed)
		{
			var num_index = j;
			var username = document.getElementById("in_username").value;
			var params="Delete_news="+true+"&Username="+username+"&index="+index+"&num_index="+num_index;
			//Send the proper header infomation along with the request
			ajaxRequest.open("POST", "card_handler.php" , true);
			ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajaxRequest.setRequestHeader("Content-length", params .length);
			ajaxRequest.setRequestHeader("Connection", "close");
			ajaxRequest.send(params);
		} 
		else 
		{
			document.getElementById('news_loading').style.display = "none";
			return false;
		}
	}
}
function Delete_news(index){
	document.getElementById('news_loading').style.display = "inline";

	confirmed = window.confirm("Sei sicuro di voler eliminare la news?");
	if (confirmed)
	{
		var ajaxRequest = create_ajaxRequest();
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				document.getElementById('news_loading').style.display = "none";
				Refresh_riepilogo_news();
			}
		}
		var username = document.getElementById("in_username").value;
		var params="Delete_single_news="+true+"&Username="+username+"&index="+index;
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		document.getElementById('news_loading').style.display = "none";
		return false;
	}
}

function Load_mailing_list_groups(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById("mod_mailing_list_groups").innerHTML = ajaxRequest.responseText;
			//document.getElementById("mailing_list_groups").innerHTML = ajaxRequest.responseText;
			$("#mod_mailing_list_groups").html(ajaxRequest.responseText);
			$("#mailing_list_groups").html(ajaxRequest.responseText);
			
		}
	}
	var username=document.getElementById("in_username").value;
	var params="Load_mailing_list_groups="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Load_mod_mailing_list_groups(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			$("#mod_mailing_list_groups").html(ajaxRequest.responseText);
			$("#mailing_list_groups").html(ajaxRequest.responseText);
		}
	}
	var username=document.getElementById("in_username").value;
	var params="Load_mod_mailing_list_groups="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Load_mod_saved_mailing_list_groups(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById("mod_table_selected_container").innerHTML = ajaxRequest.responseText;
			$("#mod_table_selected_container").html(ajaxRequest.responseText);
		}
	}
	var username=document.getElementById("in_username").value;
	var news_id = document.getElementById("showed_news_id").value;
	
	var params="Load_mod_saved_mailing_list_groups="+true+"&Username="+username;
	params+="&news_id="+news_id;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Select_all_news_checkbox(){
	var ck = document.getElementsByClassName("col-news-select");
	for(var i = 0; i < ck.length; i++)
		if((ck[i].type == 'checkbox')){
			if(ck[i].checked != ""){
  				ck[i].checked="";
			}else{
				ck[i].checked = "true";
			}
	}
	
}

function Move_rows_up(index,row_num){
	document.getElementById('news_loading').style.display = "inline";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result!="true"){
				Show_Setting_Saved('move_contact_error');
			}
			Refresh_riepilogo_news();
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Move_rows_up="+true+"&Username="+username;
	
	params+="&index="+index;
	params+="&row_num="+row_num;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Move_rows_down(index,row_num){
	document.getElementById('news_loading').style.display = "inline";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result!="true"){
				Show_Setting_Saved('move_contact_error');
			}
			Refresh_riepilogo_news();
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Move_rows_down="+true+"&Username="+username;
	
	params+="&index="+index;
	params+="&row_num="+row_num;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}