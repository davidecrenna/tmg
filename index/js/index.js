$(document).ready(function() {
$( "#in_go_to_card" ).autocomplete({
 source: 'lista-utenti.php',
 minChars: 2,
 autoFill: true,
 mustMatch:true,
 delay: 0,//0
 cacheLength: 1,
 max:30,
 formatItem: function (row) {
 return row[0] + " (" + row[2] + ", " + row[1] + ")"+" "+row[5];
 },
 formatMatch: function (row) {
 return row[0];
 },
 formatResult: function (row) {
 return row[0];
 },
 select: function( event, ui ) {
 //add(event, ui);
 //utilizzare questo spazio per valorizzare ad esempio dei campi input con altri dati prelevati da db
 //$("#campo_nascosto").val(ui.item.nome_campo_array_settato_in_lista-utenti);
 }
 });
});


function change_scheda(id_scheda){
	if(!($('#scheda1').css('display') == 'none')){
		$("#scheda1").css("display","none");
	}
	if(!($('#scheda2').css('display') == 'none')){
		$("#scheda2").css("display","none");
	}
	if(!($('#scheda3').css('display') == 'none')){
		$("#scheda3").css("display","none");
	}
	if(!($('#scheda4').css('display') == 'none')){
		$("#scheda4").css("display","none");
	}
	if(!($('#scheda5').css('display') == 'none')){
		$("#scheda5").css("display","none");
	}
	if(!($('#scheda6').css('display') == 'none')){
		$("#scheda6").css("display","none");
	}
	if(!($('#scheda_cb_sito').css('display') == 'none')){
		$("#scheda_cb_sito").css("display","none");
	}
	if(!($('#scheda_cb_filebox').css('display') == 'none')){
		$("#scheda_cb_filebox").css("display","none");
	}
	if(!($('#scheda_cb_mailing').css('display') == 'none')){
		$("#scheda_cb_mailing").css("display","none");
	}
	if(!($('#scheda_cb_biglietto').css('display') == 'none')){
		$("#scheda_cb_biglietto").css("display","none");
	}
	if(!($('#scheda_cb_carta').css('display') == 'none')){
		$("#scheda_cb_carta").css("display","none");
	}
	if(!($('#scheda_cb_guadagno').css('display') == 'none')){
		$("#scheda_cb_guadagno").css("display","none");
	}
	if(!($('#scheda_cb_networks').css('display') == 'none')){
		$("#scheda_cb_networks").css("display","none");
	}
	if(!($('#scheda_cb_giovani').css('display') == 'none')){
		$("#scheda_cb_giovani").css("display","none");
	}
	$("#"+id_scheda).fadeIn("slow");
	
	$("#img_scheda1").attr("src","image/homepage/btn/btn_scheda1.png");
	$("#img_scheda2").attr("src","image/homepage/btn/btn_scheda2.png");
	$("#img_scheda3").attr("src","image/homepage/btn/btn_scheda3.png");
	$("#img_scheda4").attr("src","image/homepage/btn/btn_scheda4.png");
	$("#img_scheda5").attr("src","image/homepage/btn/btn_scheda5.png");
	
	if((id_scheda=='scheda1')&&(id_scheda=='scheda2')&&(id_scheda=='scheda3')&&(id_scheda=='scheda4')&&(id_scheda=='scheda5'))
		$("#img_"+id_scheda).attr("src","image/btn_"+id_scheda+"_over.png");
		
	if(id_scheda=='scheda6'){
		$('#div_banner_sx_up').css("display","none");
		$('#div_banner_sx').css("display","none");
	}else{
		$('#div_banner_sx_up').css("display","block");
		$('#div_banner_sx').css("display","block");
		//$("#iscrizione_form").data('validator').reset();
	}
	
	return;	
}
function intercettaPressioneTastoInvio(e) {
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
        Login();
   }
}
function open_esempio(color){
	window.open('melixaroncari/'+color);
}

function go_to_card(){
	$('#info_go_to_card').html("<img src='image/icone/ajax_small.gif' width='13' height='13' />"); 
	var ajaxRequest = create_ajaxRequest();
	
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			
			if(in_go_to_card!="")
			{	
				$('#info_referente').html("<img src='image/icone/loading.gif' width='25' height='25' />"); 
				var res = ajaxRequest.responseText;
			}
			if(res==0||in_go_to_card==""){
				if(in_go_to_card!="")
					$('#info_go_to_card').html("<img src='image/icone/error.png' width='13' height='13' /> Username inesistente."); 
					Show_Setting_Saved('info_go_to_card');
				return 1;
			}
			else{
				location.href=in_go_to_card+'/index.php';
				return 0;
			}
		}
	}
	$("#in_go_to_card").val=$("#in_go_to_card").val().toLowerCase();
	var in_go_to_card= $("#in_go_to_card").val();
	
	var params="referente="+in_go_to_card;
	
	ajaxRequest.open("POST", "getutenti.php" , true);
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
function in_go_to_card_click(){
	$("#in_go_to_card").val("");
	$("#in_go_to_card").attr("onclick","");
	
}

function Update_info_nickname(){
	var name = $("#_nome").val();
	var cognome = $("#_cognome").val();
	var nickname = $("#_nickname").val();
	
	if(nickname!=""){
		$('.info_nickname').html(nickname.toLowerCase());
	}else{	
		$('.info_nickname').html(name.toLowerCase()+cognome.toLowerCase());
	}
}
function username_correction(id,callback){
	
	var fieldvalue = $("#"+id).val();
	var fieldlength = fieldvalue.length;
	
	$.trim(fieldvalue)
	
	var iChars = "!@#$%^&*£()+=-[]\\;/{}|:<>?.";
	
	for (var i = 0; i < fieldlength; i++) {
		if (iChars.indexOf(fieldvalue.charAt(i)) != -1) {
			fieldvalue = fieldvalue.replace(fieldvalue.charAt(i), ' ');
		}
	}
	
	fieldvalue = fieldvalue.replace(/ /g, '');
	$("#"+id).val(fieldvalue);
	
	if(typeof callback == 'function')
		callback();
}

function CercaInvio(e){
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
		  
			username_correction('in_go_to_card',go_to_card);
		
   }
}

function switch_society(){
	ClearPIVACODFIS();
	is_society = $("#is_society").val();
	if(is_society==0){
		$("#labelnickname").html("NOME SOCIET&Agrave;");
		$("#labelcodfis").html("PARTITA IVA");
		$("#info_codfiscale").css("left", "90px");
		$("#is_society").val(1);
		//controllaPIVA();
	}else{
		$("#labelnickname").html("NICKNAME");
		$("#labelcodfis").html("CODICE FISCALE");
		$("#info_codfiscale").css("left", "170px");
		$("#is_society").val(0);
		//CtrlCodFiscale();
	}	
}

