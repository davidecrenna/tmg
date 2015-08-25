var checked_id = new Array();
function accedi(folder){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("files_content").innerHTML = ajaxRequest.responseText;
			var num_rows = document.getElementById("num_rows").value;
			if(num_rows!=0){
				num_rows++;
				var height = 70+(num_rows*52);
			}else{
				var height=320;
			}
			document.getElementById('file').style.height = height+"px";
		}
	}
	var folder_pass = document.getElementById('folder_pass').value;
	var username=document.getElementById("in_username").value;
	var params="Accedi="+true+"&Username="+username;
	
	params+="&folder="+folder;
	params+="&folder_pass="+folder_pass;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
/*function file_over(id){
	document.getElementById('div_file_'+id).style.backgroundColor = "#6B6B6B";
	document.getElementById('div_file_'+id).style.opacity = "0.40";
	
	document.getElementById('mod_file_'+id).style.display = "block";
}
function file_out(id){
	var x=0;
	
	for(var i=0;i< checked_id.length ;i++){
		if(id == checked_id[i]){
			x=1;
		}
	}
	if(x!=1){
		document.getElementById('div_file_'+id).style.backgroundColor="#6B6B6B";
		document.getElementById('div_file_'+id).style.opacity="1";
		document.getElementById('mod_file_'+id).style.display = "none";
	}
}*/