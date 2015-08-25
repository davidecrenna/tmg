// JavaScript Document
var is_download;
var is_delete;
var checked_id = new Array();
function Show_folder(path){
	document.getElementById('choose').style.display = "none";
	document.getElementById('file').style.display = "block";
	if(is_delete==null||is_download==null){
		//document.getElementById("esplora").style.display = "none";
		document.getElementById("file").style.display = "block";	
		var ajaxRequest = create_ajaxRequest();
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				document.getElementById("files_content").innerHTML = ajaxRequest.responseText;
				checked_id = [];
			}
		}
		var username=document.getElementById("in_username").value;
		
		var params="Show_file="+true+"&Username="+username;
		params+="&path="+path;
		
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST", "../php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	}else{
		is_delete = null;	
		is_download = null;
	}
}

function delete_folder(parent,id){	
	is_delete =1;
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//document.getElementById(parent+"_subfolders").innerHTML = ajaxRequest.responseText;
			Refresh_subfolder(parent);
		}
	}
	
	var folder_name = document.getElementById(parent+'_dir_name_'+id).value;
	var username=document.getElementById("in_username").value;
	var params="Delete_folder="+true+"&Username="+username;
	
	params+="&folder="+parent;
	params+="&name="+folder_name;
	confirmed = window.confirm("Verrano eliminati tutti i file contenuti nella cartella "+folder_name+". Continuare?");
	if (confirmed)
	{	
		ajaxRequest.open("POST", "../php/card_handler.php" , true);
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
function Rename_folder(parent,id){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.result==0){
				Refresh_subfolder(parent);
				Show_Setting_Saved("folder_renamed");
			}else{
				alert("Esiste già una cartella con il nome scelto!");
			}
		}
	}
	
	var folder_name = document.getElementById(parent+'_dir_name_'+id).value;
	var username=document.getElementById("in_username").value;
	var new_name = prompt("Cambia il nome della cartella \""+folder_name+"\"", folder_name);
	
	if(new_name!=null&&new_name!=""){
		var params="Rename_folder="+true+"&Username="+username;
		params+="&folder="+parent;
		params+="&name="+folder_name;
		params+="&new_name="+new_name;
		
		ajaxRequest.open("POST", "../php/card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	}else{
		alert("Devi specificare il nome della cartella!");
		return false;	
	}
}
function delete_file(id){	
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			checked_id.splice(checked_id.indexOf(id), 1);
			if(folder==""){
				Show_folder(parent);
			}else{
				Show_folder(parent+"/"+folder);
			}
		}
	}
	var parent = document.getElementById('parent').value;
	var folder = document.getElementById('folder').value;
	var file_name = document.getElementById('file_name_'+id).value;
	var username=document.getElementById("in_username").value;
	var params="Delete_file="+true+"&Username="+username;
	if(folder==""){
		params+="&folder="+parent;
	}else{
		params+="&folder="+parent+"/"+folder;
	}
	params+="&name="+file_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function torna_alla_card(){
	var username=document.getElementById("in_username").value;
	location.href = "../../"+username+"/index.php";
}
function torna_root(){
	var username=document.getElementById("in_username").value;
	location.href = "filebox.php?u="+username;
}
function torna_root_from_public(){
	var username=document.getElementById("in_username").value;
	location.href = "filebox_pubblica.php?u="+username;
}
function CuteWebUI_AjaxUploader_OnQueueUI(list)
{
	for (i in list) {
		if(list[i].Status == 'Finish'){
			var folder = document.getElementById('folder').value;
			var parent = document.getElementById('parent').value;
			if(folder!=""){
				Show_folder(parent+"/"+folder);
			}else{
				Show_folder(parent);
			}
		}
		if(list[i].Status == 'Error'){
			//Show_Setting_Saved('div_error_allegati');
		}
	}
	return false;
}
function file_check(index){
	if(index!=is_download){
		if(!document.getElementById('file_check_'+index).checked == ""){
			checked_id.push(index);
			document.getElementById('file_check_'+index).checked = "true";
		}else{
			checked_id.splice(checked_id.indexOf(index), 1);
			document.getElementById('file_check_'+index).checked = "";
		}
	}else{
		is_download=null;	
	}
}
function dir_clicked(index,parent){
	var sub_folder = document.getElementById(parent+'_dir_name_'+index).value;
	Show_folder(parent+"/"+sub_folder);
}
function uncheck(id){ 
	is_download = id;
}
function emptyfolder(){
	var num_files = document.getElementById('num_files').value;
	var folder = document.getElementById('folder').value;
	confirmed = window.confirm("Sei sicuro di voler eliminare tutti i file contenuti nella cartella "+folder+" ?");
	if (confirmed)
	{	
		for(var i=0;i< num_files;i++)
			delete_file(i);
	} 
	else 
	{
		return false;
	}
}
function delete_selected(){
	confirmed = window.confirm("Sei sicuro di voler eliminare tutti i file selezionati?");
	if (confirmed)
	{	
		document.getElementById('delete_loading').style.display = "block";
		for(var i=0;i< checked_id.length;i++){
			delete_file(checked_id[i]);
		}
		document.getElementById('delete_loading').style.display = "none";
		Show_Setting_Saved('delete_file_saved');
	} 
	else 
	{
		return false;
	}	
}
function Refresh_subfolder(folder){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById(folder+"_subfolders").innerHTML = ajaxRequest.responseText;
			//Show_folder('private');
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Refresh_subfolder="+true+"&Username="+username;
	params+="&folder="+folder;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Enter_on_create_private_folder(e) {
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
        create_private_folder()
   }
}
function create_private_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			overlay_create_private_folder.overlay().close();
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("create_private_folder_result").innerHTML = obj.result;
			Show_Setting_Saved("create_private_folder_result")
			Refresh_subfolder("private");
			//Show_folder('private');
		}
	}
	var folder_pass=document.getElementById("private_folder_pass").value;
	var folder_name=document.getElementById("private_folder_name").value;
	if((!ctrl_pass(folder_pass))||(!ctrl_name(folder_name))){
		return false;
	}
	
	var username=document.getElementById("in_username").value;
	var params="Create_private_folder="+true+"&Username="+username;
	
	params+="&folder_pass="+folder_pass;
	params+="&folder_name="+folder_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
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

function Enter_on_create_public_folder(e) {
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
        create_public_folder()
   }
}
function create_public_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			overlay_create_public_folder.overlay().close();
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("create_public_folder_result").innerHTML = obj.result;
			Show_Setting_Saved("create_public_folder_result")
			Refresh_subfolder("public");
			//Show_folder('private');
		}
	}
	var folder_name=document.getElementById("public_folder_name").value;
	if((!ctrl_name(folder_name))){
		return false;
	}
	
	var username=document.getElementById("in_username").value;
	var params="Create_public_folder="+true+"&Username="+username;
	params+="&folder_name="+folder_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function Enter_on_create_photo_folder(e) {
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
        create_photo_folder()
   }
}
function create_photo_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			overlay_create_photo_folder.overlay().close();
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("create_photo_folder_result").innerHTML = obj.result;
			Show_Setting_Saved("create_photo_folder_result");
			Refresh_subfolder("photo");
			//Show_folder('private');
		}
	}
	var folder_name=document.getElementById("photo_folder_name").value;
	if((!ctrl_name(folder_name))){
		return false;
	}
	
	var username=document.getElementById("in_username").value;
	var params="Create_photo_folder="+true+"&Username="+username;
	params+="&folder_name="+folder_name;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function ctrl_name(folder_name){
	if (folder_name==null || folder_name=="" || folder_name.length<4 || folder_name.length>18)
   {
		return false;
   }
   else{
		return true;		   
   }
   return;
}
function ctrl_pass(new_pass){
	
	if (new_pass==null || new_pass=="" || validatePwd(new_pass)==false)
   {
	   return false;
   }
   else{
		return true;		   
   }
   return;
}

function validatePwd(new_pass) {

	//Initialise variables
	var errorMsg = "";
	var space  = " ";
	var fieldvalue  = new_pass; 
	var fieldlength = new_pass.length; 
	
	//It must not contain a space
	if (fieldvalue.indexOf(space) > -1) {
		 errorMsg += "\nLa password non deve contenere spazi.\n";
	}
	
	//It must be at least 7 characters long.
	if ((!(fieldlength >= 4))||(!(fieldlength <= 10))) {
		 errorMsg += "\nLa password deve avere una lunghezza minima di 4 caratteri ed una lunghezza massima di 10.\n";
	}
	
	var iChars = "!@#$%^&*()+=-[]\\;/{}|:<>?\',.\"";
	
	var car_speciale = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			car_speciale = 1;
		}
	}
	if(car_speciale==1){
		errorMsg += "\nLa password non deve contenere caratteri speciali ("+iChars+").\n";
	}
	
	//If there is aproblem with the form then display an error
     if (errorMsg != ""){
          errorMsg += alert( errorMsg + "\n\n");
          return false;
     }
     return true;
}
function change_password(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			document.getElementById("folder_pass").value = obj.password;
			Show_Setting_Saved("password_saved");
		}
	}
	var folder_name = document.getElementById('folder').value;
	var folder_pass = document.getElementById('folder_pass').value;
	var new_pass = prompt("Cambia la password della cartella \""+folder_name+"\"", folder_pass);
	if(!ctrl_pass(new_pass)){
	   return false;
	}
	
	var username=document.getElementById("in_username").value;
	var params="Change_folder_password="+true+"&Username="+username;
	
	params+="&folder_name="+folder_name;
	params+="&folder_pass="+new_pass;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
}
function Show_Setting_Saved(div){
	$("#"+div).show(400);
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",3000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide(400);
}

function load_create_public_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('item_create_public_folder').innerHTML= ajaxRequest.responseText;
		}
	}
	
	var username=document.getElementById("in_username").value;
	
	var params="Load_create_public_folder="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params.length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function load_create_photo_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('item_create_photo_folder').innerHTML= ajaxRequest.responseText;
		}
	}
	
	var username=document.getElementById("in_username").value;
	
	var params="Load_create_photo_folder="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params.length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function load_create_private_folder(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('item_create_private_folder').innerHTML= ajaxRequest.responseText;
		}
	}
	
	var username=document.getElementById("in_username").value;
	
	var params="load_create_private_folder="+true+"&Username="+username;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params.length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function check_all_files(){
	var num_files = document.getElementById('num_files').value;
	var folder = document.getElementById('folder').value;
	for(var i=0;i< num_files;i++){
		if(i!=is_download){
			if(document.getElementById('file_check_'+i).checked == ""){
				checked_id.push(i);
				document.getElementById('file_check_'+i).checked = "true";
			}else{
				checked_id.splice(checked_id.indexOf(i), 1);
				document.getElementById('file_check_'+i).checked = "";
			}
		}else{
			is_download=null;	
		}
		file_check(i);
	}
}


