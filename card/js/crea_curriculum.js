function Show_Setting_Saved(div){
	$("#"+div).show();
	var t=setTimeout("Hide_Setting_Saved('"+div+"')",3000);
}
function Hide_Setting_Saved(div){
	$("#"+div).hide();
}
function torna_alla_card(){
	var username=document.getElementById("in_username").value;
	location.href = "../../"+username+"/index.php/personal_area";
}
function visualizza_curr(){
	var username=document.getElementById("in_username").value;
	//location.href = "curriculumeuropeo.php?u="+ username;
	window.open("curriculumeuropeo.php?u="+ username);
}
function save_step0(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step0').style.display = "none";
			document.getElementById('step1').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
		}
	}
	
	var username=document.getElementById("in_username").value;
	var sudime= f('ce_in_sudime');
	
	var params="Step0_crea_save="+true+"&Username="+username;
	params+="&sudime="+sudime;
	
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function save_step1(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step1').style.display = "none";
			document.getElementById('step2').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Step1_crea_save="+true+"&Username="+username;
	
	var nomecognome= document.getElementById('ce_in_nome').value;
	var sesso= document.getElementById('ce_in_sesso').value;
	var cittadinanza= document.getElementById('ce_in_cittadinanza').value;
	var dataluogo= document.getElementById('ce_in_dataluogo').value;
	var telefono= document.getElementById('ce_in_telefono').value;
	var email= document.getElementById('ce_in_email').value;
	var indirizzo= document.getElementById('ce_in_indirizzo').value;
	var sudime= f('ce_in_sudime');
	
	params+="&nomecognome="+nomecognome;
	params+="&sesso="+sesso;
	params+="&cittadinanza="+cittadinanza;
	params+="&dataluogo="+dataluogo;
	params+="&telefono="+telefono;
	params+="&email="+email;
	params+="&indirizzo="+indirizzo;
	params+="&sudime="+sudime;
	
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}
function save_step2(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step2').style.display = "none";
			document.getElementById('step3').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Step2_curriculum_save="+true+"&Username="+username;
	
	//istruzformaz= document.getElementById('ce_in_istr').value;
	var istruzformaz= f('ce_in_istr');
	var esplavorativa= f('ce_in_esp');
	
	params+="&istruzformaz="+istruzformaz;
	params+="&esplavorativa="+esplavorativa;

	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
	
}
function f(id) {
var t=document.getElementById(id).value;
var accapo=(t.indexOf("\r\n")!=-1)?"\r\n":
(t.indexOf("\n")!=-1)?"\n":"\r";
var reg = new RegExp(accapo, 'g');
t=t.replace(reg,"<br/>");

return t;
}

function save_step3(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step3').style.display = "none";
			document.getElementById('step4').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Step3_curriculum_save="+true+"&Username="+username;
	
	//istruzformaz= document.getElementById('ce_in_istr').value;
	var linguestraniere = document.getElementById('ce_in_linguestraniere').value;
	var madrelingua = document.getElementById('ce_in_madrelingua').value;
	
	var capacitacompet= f('ce_in_capacitacompet');
	var compinformatiche= f('ce_in_compinformatiche');
	var comprelsoc= f('ce_in_comprelsoc');
	var comporganiz= f('ce_in_comporganiz');
	
	params+="&linguestraniere="+linguestraniere;
	params+="&madrelingua="+madrelingua;
	params+="&capacitacompet="+capacitacompet;
	params+="&compinformatiche="+compinformatiche;
	params+="&comprelsoc="+comprelsoc;
	params+="&comporganiz="+comporganiz;


	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);	
	
}
function save_step4(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step4').style.display = "none";
			document.getElementById('step5').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
		}
	}
	
	var username=document.getElementById("in_username").value;
	var params="Step4_curriculum_save="+true+"&Username="+username;
	
	var compartistiche= f('ce_in_compartistiche');
	var comptecniche= f('ce_in_comptecniche');
	var comprelativeallav= f('ce_in_comprelativeallav');
	var altrecompedinteressi= f('ce_in_altrecompedinteressi');
	
	params+="&compartistiche="+compartistiche;
	params+="&comptecniche="+comptecniche;
	params+="&comprelativeallav="+comprelativeallav;
	params+="&altrecompedinteressi="+altrecompedinteressi;

	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);		
}

function save_step5(){
	document.getElementById("creacurriculum_loading").style.display = "block";
	var username=document.getElementById("in_username").value;
	var ajaxRequest = create_ajaxRequest();
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			//cambio scheda
			document.getElementById('step5').style.display = "none";
			document.getElementById('step6').style.display = "block";
			document.getElementById("creacurriculum_loading").style.display = "none";
			Show_Setting_Saved("creacurriculum_saved");
			/*var result = perform_acrobat_detection();
			  if(result.acrobat==null){
				  document.getElementById("iframe_show_curr").innerHTML= "<p>Adobe Reader non installato.<br/>Per una corretta visualizzazione del Curriculum in formato PDF è necessaria l\'installazione del plugin Adobe Reader.</p><p>Scarica il plugin dal sito di Adobe <a style='color:#000;' href='http://get.adobe.com/it/reader/'>http://get.adobe.com/it/reader/</a></p><br/>oppure<br/><a style='color:#000;' href='download.php?u="+username+"&cv=true'>Scarica il curriculum in formato PDF.</a>";
			  }else{*/
				  document.getElementById('iframe_show_curr').innerHTML = "<iframe src='curriculumeuropeo.php?u="+username+"' width='805' height='300' frameborder='0' style='overflow-y:auto; position:absolute; top:28px;'></iframe>";
			  //}
			
			Show_Setting_Saved('caricamento_curr');
		}
	}
	
	
	var params="Step5_curriculum_save="+true+"&Username="+username;
	
	var patente= document.getElementById('ce_in_patente').value;
	var ulteriori= f('ce_in_ulteriori');
	
	params+="&patente="+patente;
	params+="&ulteriori="+ulteriori;
	
	//Send the proper header infomation along with the request
	ajaxRequest.open("POST", "../php/card_handler.php" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.setRequestHeader("Content-length", params .length);
	ajaxRequest.setRequestHeader("Connection", "close");
	ajaxRequest.send(params);
}

function go_step0_from_step1(){
	document.getElementById('step1').style.display = "none";
	document.getElementById('step0').style.display = "block";	
}
function go_step1_from_step2(){
	document.getElementById('step2').style.display = "none";
	document.getElementById('step1').style.display = "block";	
}
function go_step2_from_step3(){
	document.getElementById('step3').style.display = "none";
	document.getElementById('step2').style.display = "block";	
}
function go_step3_from_step4(){
	document.getElementById('step4').style.display = "none";
	document.getElementById('step3').style.display = "block";	
}
function go_step4_from_step5(){
	document.getElementById('step5').style.display = "none";
	document.getElementById('step4').style.display = "block";
}
function go_step5_from_step6(){
	document.getElementById('step6').style.display = "none";
	document.getElementById('step5').style.display = "block";
	
}
function perform_acrobat_detection()
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
}
