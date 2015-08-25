function startUpload(){
      document.getElementById('upload_process').style.display = 'block';
      document.getElementById('upload').style.display = 'hidden';
	  return true;
}

function Upload_success(image_path,image_height){
	var username=document.getElementById("in_username").value;
	window.top.window.location.href="photocrop.php?u="+username+"&image_path="+image_path+"&image_height="+image_height;
	return true;   
}
function Upload_success_slide(image_path,image_height,id){
	var username=document.getElementById("in_username").value;
	window.top.window.location.href="slidecrop.php?u="+username+"&image_path="+image_path+"&image_height="+image_height+"&id="+id;
	return true;   
}
function Upload_success_new_slide(image_path,image_height,id){
	var username=document.getElementById("in_username").value;
	window.top.window.location.href="slidecrop.php?u="+username+"&image_path="+image_path+"&image_height="+image_height+"&id="+id;
	return true;   
}


function crop_main_photo(){
	var x1 = document.getElementById('x1').value;
	var y1 = document.getElementById('y1').value;
	var w = document.getElementById('w').value;
	var h = document.getElementById('h').value;
	
	if(x1=="" || y1=="" || w=="" || h==""){
		alert("Devi prima ritagliare la foto.");
		return false;
	}
	if(w<100||h<200){
		alert("L'area selezionata è troppo piccola.");
		return false;
	}else{
		var ajaxRequest = create_ajaxRequest();
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				$("#crop").remove();
				$(".imgareaselect-outer").remove();
				$(".imgareaselect-selection").remove();
				$(".imgareaselect-border1").remove();
				$(".imgareaselect-border2").remove();
				$('#cropped_image').append(ajaxRequest.responseText);
				document.getElementById('save').style.display = 'block';
			}
		}
		var image_large_path= document.getElementById('image_large_path').value;
		var username=document.getElementById("in_username").value;
		var params="Crop_main_photo="+true+"&Username="+username;
		params+= "&x1="+x1+
		"&y1="+y1+
		"&w="+w+
		"&h="+h+
		"&image_large_path="+image_large_path;
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST","card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);	
	}
}

function Upload_problem(error){
	document.getElementById('upload_process').style.display = 'none';
	document.getElementById('main_upload_form_error').innerHTML = error;
	document.getElementById('main_upload_form').style.visibility = 'visible';
	
}
function torna_upload(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			location.href = "photo.php?u="+username;
		}
	}
	var username=document.getElementById("in_username").value;
	var params="Delete_photo_large="+true+"&Username="+username;

	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function torna_alla_card(){
	var username=document.getElementById("in_username").value;
	location.href = "../../"+username+"/index.php";
}
function Save_main_photo(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			location.href = "photo.php?u="+username;
			window.parent.location.href = "../../"+username+"/index.php?personal_area=true&tab=interfaccia";
		}
	}
	var username=document.getElementById("in_username").value;
	var photo_path = document.getElementById("photo_cropped").src;
	var params="Save_main_photo="+true+"&Username="+username;
	params+="&photo_path="+photo_path;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function CuteWebUI_AjaxUploader_OnQueueUI(list)
{
	return false;
}

function delete_slide_photo(index){
	document.getElementById("slide_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("slide_loading").style.display = "none";
			location.href = "photo.php?u="+username;
		}
	}
	index++;
	confirmed = window.confirm("Sei sicuro di voler eliminare la foto numero "+(index));
	index--;
	if (confirmed)
	{
		var username=document.getElementById("in_username").value;
		var params="Delete_photo_slide="+true+"&Username="+username+"&index="+index;
		//Send the proper header infomation along with the request
		ajaxRequest.open("POST","card_handler.php" , true);
		ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajaxRequest.setRequestHeader("Content-length", params .length);
		ajaxRequest.setRequestHeader("Connection", "close");
		ajaxRequest.send(params);
	} 
	else 
	{
		document.getElementById("slide_loading").style.display = "none";
		return false;
	}
}
function change_foto_slide(index){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('add_photo_slide').style.display = "none";
			document.getElementById('photo_slide_change').style.display = "block";
			document.getElementById('photo_slide_change').innerHTML= ajaxRequest.responseText;
			open_overlaychangefoto();
			
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="change_foto="+true+"&Username="+username;
	params+="&index="+index;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function return_to_the_card(){
	var username=document.getElementById("in_username").value;
	location.href='../../'+username+'/index.php?personal_area=true';
	//window.open('../../'+username+'/index.php?personal_area=true');
}
