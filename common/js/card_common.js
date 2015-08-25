function Show_Setting_Saved(div){
	$("#"+div).show(400);
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",4000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide(400);
}
function Ctrltextinput(input_id,max_lenght,empty){
   var input=document.getElementById(input_id);
   if ((input.value==null || input.value=="")&&(empty!=true))
   {
		document.getElementById(input_id).style.border = "1px #F00 solid";
		return 1;
   }else if((max_lenght!=0)&&(input.value.length > max_lenght)){
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
function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }	
}
function f(id) {
	var t=document.getElementById(id).value;
	var accapo=(t.indexOf("\r\n")!=-1)?"\r\n":
	(t.indexOf("\n")!=-1)?"\n":"\r";
	var reg = new RegExp(accapo, 'g');
	t=t.replace(reg,"<br/>");
	
	return t;
}

function Refresh_notifica_message(){
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			var obj = jQuery.parseJSON(ajaxRequest.responseText);
			if(obj.new_contacts>0){
				document.getElementById('new_contact_notification').innerHTML="<div style='background-image:url(../image/icone/number_icon_mex.png); width:27px; height:22px; padding-top:1px;' ><span id='new_contact_num'>"+obj.new_contacts+"</span></div>";
			}else{
				if(document.getElementById('new_contact_notification')!=null)
					document.getElementById('new_contact_notification').innerHTML="";
			}
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Refresh_notifica_message="+true+"&Username="+username;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../card/php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function Delete_value(id){
	$(id).val("");	
}