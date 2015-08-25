// JavaScript Document


function CtrlReferente(){
	username_correction("_id_referente");
	var ajaxRequest = create_ajaxRequest();
	document.getElementById('info_referente').innerHTML = "<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/ajax_small.gif' />"; 
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			if(referente!="")
			{	
				var res = ajaxRequest.responseText;
			}
			if(res==0||referente==""){
				if(referente!="")
					document.getElementById('info_referente').innerHTML = "<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' />"; 
				document.getElementById("_id_referente").style.border = "1px #F00 solid";
				return 1;
			}
			else{
				document.getElementById('info_referente').innerHTML ="<img style='vertical_align:middle;  width:15px; height:13px;' src='image/icone/ok.png' />"; 
				 document.getElementById("_id_referente").style.border = "1px #FFF solid";
				return 0;
			}
			//var utenti = ajaxRequest.responseText;
		}
	}
	document.getElementById("_id_referente").value=document.getElementById("_id_referente").value.toLowerCase();
	var referente= document.getElementById("_id_referente").value;
	
	var params="referente="+referente;
	
	ajaxRequest.open("POST", "getutenti.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}


function CtrlName(){
	var fieldvalue=$("#_nome").val();
	var fieldlength = fieldvalue.length;
	
	if (fieldvalue==null || fieldvalue=="")
   {
		$("#_nome").css("border","1px #F00 solid");
		return false;
   }
   else{
	   $("#_nome").css("border","1px #FFF solid");
   }
   
   var iChars = "!@#$%^&£*()+=-[]\\;/{}|:<>?.";
	var car_speciale = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			car_speciale = 1;
		}
	}
	if(car_speciale!=0){
		alert("Il nome non può contenere caratteri speciali! ("+iChars+")");
		return false;
	}
   return true;
}

function CtrlSurname(){
	var fieldvalue = $("#_cognome").val();
	var fieldlength = fieldvalue.length;
	
	if (fieldvalue==null || fieldvalue=="")
   {
		$("#_cognome").css("border","1px #F00 solid");
		return false;
   }
   else{
	   $("#_cognome").css("border","1px #FFF solid");
   }
   
   var iChars = "!@#$%^&*£()+=-[]\\;/{}|:<>?.";
	var car_speciale = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			car_speciale = 1;
		}
	}
	if(car_speciale!=0){
		alert("Il cognome non può contenere caratteri speciali! ("+iChars+")");
		return false;	
	}
   return true;
}

function CtrlNickname(){
	var fieldvalue = document.getElementById("_nickname").value;
	var fieldlength = fieldvalue.length;
	var is_society = $("#is_society").val();
	if(is_society==1){
		if (fieldvalue==null || fieldvalue=="")
	   {
			document.getElementById("_nickname").style.border = "1px #F00 solid";
			return false;
	   }
	   else{
		   document.getElementById("_nickname").style.border = "1px #FFF solid";
	   }
	}
   
   var iChars = "!@#$%^&£*()+=-[]\\;/{}|:<>?.";
	var car_speciale = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			car_speciale = 1;
		}
	}
	if(car_speciale!=0){
		alert("Il nickname non può contenere caratteri speciali! ("+iChars+")");
		return false;	
	}
   return true;
}
function CtrlEmail(){
	var email=document.getElementById("_email");
	var confirm_email=document.getElementById("_confirm_email");
	if (email.value==null || email.value=="" || isEmail(email.value)==false ||(email.value!=confirm_email.value))
   {
	   	if((email.value!=confirm_email.value))
			document.getElementById("_confirm_email").style.border = "1px #F00 solid";
		else
			document.getElementById("_email").style.border = "1px #F00 solid";
		return 1;
   }
   else{
		document.getElementById("_email").style.border = "1px #FFF solid";
		document.getElementById("_confirm_email").style.border = "1px #FFF solid";
		return 0;		   
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

function submit_the_form(){

	/*VALIDAZIONE FORM*/
	var err_nome=0;
	var err_cognome=0;
	var err_email=0;
	var err_check1=0;
	var err_check2=0;
	var err_check3=0;
	var err_referente=0;
	var err_pass=0;
	var err_nickname=0;
	var err_codfiscale=0;
	var err_alternative_url=0;
	
	
	var name=document.getElementById("_nome");
	var cognome=document.getElementById("_cognome");
	var check1=document.getElementById("_terms");
	var check2=document.getElementById("_terms2");
	var check3=document.getElementById("_terms3");
	var is_society = document.getElementById("is_society").value;
	var is_giovane = document.getElementById("is_giovane").value;
	
	//nome
	if(CtrlName()==false)
		err_nome =1;
	//cognome
	if(CtrlSurname()==false)
		err_cognome=1;
	
	if(CtrlNickname()==false)
		err_nickname = 1;
	
	if(CtrlCodFisPiva()==false)
		err_codfiscale = 1;
	
	if(CtrlEmail()==1)
		err_email=1;
		
	if(CtrlPass()==1)
		err_pass=1;

	//check box
	if(check1.checked==false)
		err_check1=1;
	if(check2.checked==false)
		err_check2=1;
	if(check3.checked==false)
		err_check3=1;
		
	var selected = $("input[type='radio'][name='_alternative_url']:checked");
	if (selected.length > 0) {
		var alternative_url = selected.val();
	}else{
		err_alternative_url=1;
	}
	
	if((err_nome ==1) || (err_cognome==1) ||(err_email==1) ||(err_check1==1)||(err_check2==1)||(err_check3==1) || (err_pass==1)|| (err_nickname==1) || (err_codfiscale==1)|| (err_alternative_url==1)){
		if(err_nome==1){
			$("#_nome").css("border","1px #F00 solid");
		}
		else
			$("#_nome").css("border","1px #FFF solid");
			
		if(err_cognome ==1){
			$("#_cognome").css("border","1px #F00 solid");
		}
		else
			$("#_cognome").css("border","1px #FFF solid");
		
		if(err_referente==1){
			$("#_id_referente").css("border","1px #F00 solid");
		}
		else
			$("#_id_referente").css("border","1px #FFF solid");
			
		if(err_email==1){
			$("#_email").css("border","1px #F00 solid");
			alert("controlla che le email coincidano");
		}
		else
			$("#_email").css("border","1px #FFF solid");
		
		if(err_check1==1){
			$("#check1").css("color","#F00");
		}
		else
			$("#check1").css("color","#FFF");
			
		if(err_check2==1){
			$("#check2").css("color","#F00");
		}
		else
			$("#check2").css("color","#FFF");
			
		if(err_check3==1){
			$("#check3").css("color","#F00");
		}
		else
			$("#check3").css("color","#FFF");
			
		
		if(err_alternative_url==1){
			$("#div_alternative_url").css("color","#F00");
		}
		else
			$("#div_alternative_url").css("color","#FFF");
			
		if((err_check1==1)||(err_check2==1)||(err_check3==1)){
			alert("Devi leggere accettare le condizioni generali di contratto.");	
		}
		
		if(err_pass==1){
			$("#_password").css("color","#F00");
		}
		else
			$("#_password").css("color","#FFF");
		
		if(err_nickname==1){
			$("#_nickname").css("color","#F00");
		}
		else
			$("#_nickname").css("color","#FFF");
		return;
	}
	else{
		final_and_CtrlReferente();
		
	}

}
function final_and_CtrlReferente(){
	var ajaxRequest = create_ajaxRequest();
	
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			if(referente!="")
			{	
				document.getElementById('info_referente').innerHTML = "<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/ajax_small.gif' />"; 
				var res = ajaxRequest.responseText;
			}
			if(res==0||referente==""){
				document.getElementById('info_referente').innerHTML = "<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' />"; 
				document.getElementById("_id_referente").style.border = "1px #F00 solid";
				
				if(referente=="")
					alert("Devi inserire un referente Top Manager Group. Il tuo referente deve essere una persona già iscritta al gruppo. Se non conosci nessun membro Top Manager Group, inserisci \"TMG\".");
				else
					alert("Non Esistono Membri Top Manager Group con Username: "+referente);
				return 1;
			}
			else{				 
				$("#_id_referente").css("border","1px #FFF solid");
				$("#nickname").val($("#_nickname").val());
				$("#nome").val($("#_nome").val());
				$("#cognome").val($("#_cognome").val());
				$("#email").val($("#_email").val().toLowerCase());
				$("#username_referente").val($("#_id_referente").val());
				$('#pass').val($("#_password").val());
				$("#codfiscale").val($("#_codfiscale").val());
				/*alert($("input[type='radio'][name='_alternative_url']:checked").val())*/
				$("#alternative_url").val($("input[type='radio'][name='_alternative_url']:checked").val());
				document.frm.submit();
			}
		}
	}
	document.getElementById("_id_referente").value=document.getElementById("_id_referente").value.toLowerCase();
	var referente= document.getElementById("_id_referente").value;
	
	var params="referente="+referente;
	
	ajaxRequest.open("POST", "getutenti.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function CtrlPass(){
	var pass=document.getElementById("_password");
	if (pass.value==null || pass.value=="" || (validatePwd()==false))
   {
		document.getElementById("_password").style.border = "1px #F00 solid";
		return 1;
   }
   else{
		document.getElementById("_password").style.border = "1px #FFF solid";
		return 0;		   
   }
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
function validatePwd() {

	//Initialise variables
	var errorMsg = "";
	var space  = " ";
	var fieldname   = document.getElementById("_password");
	var fieldvalue  = fieldname.value; 
	var fieldlength = fieldvalue.length; 
	
	//It must not contain a space
	if (fieldvalue.indexOf(space) > -1) {
		 errorMsg += "\nLa password non deve contenere spazi.\n";
	}     
	//It must contain at least one number character
	if (!(fieldvalue.match(/\d/))) {
		 errorMsg += "\nLa password deve contenere almeno un numero.\n";
	}
	//It must be at least 7 characters long.
	if ((!(fieldlength >= 6))||(!(fieldlength <= 20))) {
		 errorMsg += "\nLa password deve avere una lunghezza minima di 6 caratteri ed una lunghezza massima di 20.\n";
	}
	
	/*var iChars = "!@#$%^&*()+=-[]\\;/{}|:<>?";
	
	
	var car_speciale = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			car_speciale = 1;
		}
	}
	if(car_speciale==0){
		errorMsg += "\nLa password deve contenere almeno un carattere speciale ("+iChars+").\n";
	}*/
	
	var not_allowed = "\',.\"";
	var car_not_allowed = 0;
	for (var i = 0; i < fieldlength; i++) {
		if (not_allowed.indexOf(fieldvalue.charAt(i)) != -1) {
			car_not_allowed = 1;
		}
	}
	
	if(car_not_allowed==1){
		errorMsg += "\nLa password contiene caratteri non validi ("+not_allowed+").\n";
	}

	var uppercase = 0;
	for (var i = 0; i < fieldlength; i++) {
		if(!is_num(fieldvalue.charAt(i))){
			if (fieldvalue.charAt(i) == fieldvalue.charAt(i).toUpperCase()) {
				uppercase = 1;
			}
		}
	}
	if(uppercase==0){
		errorMsg += "\nLa password deve contenere una lettera maiuscola.\n";
	}

	//If there is aproblem with the form then display an error
     if (errorMsg != ""){
          errorMsg += alert( errorMsg + "\n\n");
          return false;
     }
     return true;

}


function CtrlConfirmPass(){
	var pass=document.getElementById("_password");
	var passconfirm=document.getElementById("_confirm_password");
	if(pass.value==passconfirm.value){
		document.getElementById("_confirm_password").style.border = "1px #FFF solid";
		return 0;		 
	}
	else{
		document.getElementById("_confirm_password").style.border = "1px #F00 solid";
		return 1;
	}
	
}
function CtrlCodFisPiva(){
	var is_society= document.getElementById("is_society").value;
	if(is_society==0){
		return CtrlCodFiscale();
	}else{
		return controllaPIVA();
	}
}


/**************************************
    Controllo del Codice Fiscale
    Linguaggio: JavaScript
***************************************/
function CtrlCodFiscale()
{
	$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/ajax_small.gif' />");
	cf = $("#_codfiscale").val()
	$("#_codfiscale").val($("#_codfiscale").val().toUpperCase());
    var validi, i, s, set1, set2, setpari, setdisp;
    if( cf == '' ){  
		$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> Devi inserire il codice fiscale!");
		$("#_codfiscale").css("border","1px #F00 solid");
		return false;
	}
    cf = cf.toUpperCase();
    if( cf.length != 16 ){
		$('#info_codfiscale').html( "<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> Il codice fiscale deve essere lungo 16 caratteri.");
		$("#_codfiscale").css("border","1px #F00 solid");
		return false;
	}
    validi = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for( i = 0; i < 16; i++ ){
        if( validi.indexOf( cf.charAt(i) ) == -1 ){
			$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> Il codice fiscale contiene un carattere non valido: "+cf.charAt(i));
			$("#_codfiscale").css("border","1px #F00 solid");
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
		$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> Il codice fiscale non è corretto!");
		$("#_codfiscale").css("border","1px #F00 solid");
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
		$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> Devi essere maggiorenne per iscriverti a TopManagerGroup.com"); 
		$("#_codfiscale").css("border","1px #F00 solid");
	
		return false;	
	}
	if(eta>18&&eta<25){	
		document.getElementById('is_giovane').value = "1";
	}
	
	$('#info_codfiscale').html("<img style='vertical_align:middle;  width:15px; height:13px;' src='image/icone/ok.png' />"); 
	
	$("#_codfiscale").css("border","1px #FFF solid");
	
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

function ClearPIVACODFIS(){
	$('#info_codfiscale').html("");
	$("#_codfiscale").css("border","1px #FFF solid");
}
function controllaPIVA()
{
	$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/ajax_small.gif' />");
	var piva =$("#_codfiscale").val();
    if ( piva.length == 11 )
    {
        var codiceUFFICIOiva = parseInt( piva.substr( 0, 3 ) ) ;
        if ( codiceUFFICIOiva <= 0 || codiceUFFICIOiva > 121 ){
			$('#info_codfiscale').html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> La partita iva non è corretta!");
			$("#_codfiscale").css("border","1px #F00 solid");
			return false;
		}
    
        var X = 0 ;
        var Y = 0 ;
        var Z = 0 ;
    
        // cifre posto dispari ... ma per un array indicizzato a zero, la prima cifra ha indice zero ... appunto !
        X += parseInt( piva.charAt(0) ) ;
        X += parseInt( piva.charAt(2) ) ;
        X += parseInt( piva.charAt(4) ) ;
        X += parseInt( piva.charAt(6) ) ;
        X += parseInt( piva.charAt(8) ) ;

        // cifre posto pari ... ma per un array indicizzato a zero, la prima cifra ha indice uno ...
        Y += 2 * parseInt( piva.charAt(1) ) ;    if ( parseInt( piva.charAt(1) ) >= 5 ) Z++ ;
        Y += 2 * parseInt( piva.charAt(3) ) ;    if ( parseInt( piva.charAt(3) ) >= 5 ) Z++ ;
        Y += 2 * parseInt( piva.charAt(5) ) ;    if ( parseInt( piva.charAt(5) ) >= 5 ) Z++ ;
        Y += 2 * parseInt( piva.charAt(7) ) ;    if ( parseInt( piva.charAt(7) ) >= 5 ) Z++ ;
        Y += 2 * parseInt( piva.charAt(9) ) ;    if ( parseInt( piva.charAt(9) ) >= 5 ) Z++ ;
        
        var T = ( X + Y + Z ) % 10 ;

        var C = ( 10 - T ) % 10 ;

        if( piva.charAt( piva.length - 1 ) == C ){
			$("#_codfiscale").css("border","1px #FFF solid");
			$("#info_codfiscale").html("<img style='vertical_align:middle;  width:15px; height:13px;' src='image/icone/ok.png' />");
			return true;
		}else{
			$("#info_codfiscale").html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> La partita iva non è corretta!");
			$("#_codfiscale").css("border","1px #F00 solid");
			return false;
		}
    }
    else{ 
		$("#info_codfiscale").html("<img style='vertical_align:middle;  width:13px; height:13px;' src='image/icone/error.png' width='13' height='13' /> La partita iva non è corretta!");
		$("#_codfiscale").css("border","1px #F00 solid");
		return false;
	}
}
