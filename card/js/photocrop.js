// JavaScript Document
function Annulla_crop(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			location.href="photo.php?u="+username;
		}
	}
	var image_path= document.getElementById('image_path').value;
	var username=document.getElementById("in_username").value;
	var params="Annulla_crop="+true+"&Username="+username;
	params+="&image_path="+image_path;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Crop_photo(){
	var x1 = document.getElementById('input_top').value;
	var y1 = document.getElementById('input_left').value;
	var w = document.getElementById('input_width').value;
	var h = document.getElementById('input_height').value;
	
	if(x1=="" || y1=="" || w=="" || h==""){
		alert("Devi prima ritagliare la foto.");
		return false;
	}
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			location.href="photo.php?u="+username;
		}
	}
	var image_path= document.getElementById('image_path').value;
	var username=document.getElementById("in_username").value;
	var params="Crop_main_photo="+true+"&Username="+username;
	params+= "&x1="+x1+
	"&y1="+y1+
	"&w="+w+
	"&h="+h+
	"&image_path="+image_path;
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST","card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}