// *************************************************************************************************************************************************
// AJAX PER LOGIN
// *************************************************************************************************************************************************

// Crea l'oggetto-browser XHR e ne gestisce invio e risposta di dati asincorna verso il webserver.

function comunicazione_ajax(server_page,var_nome,var_valore){
	ajax = create_ajaxRequest();
    ajax.open("POST",server_page,true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    ajax.setRequestHeader("Connection","close");
    ajax.onreadystatechange = function(){
        if (ajax.readyState==4) 
			handler_risposta_server(ajax.responseText);
    }
	
    var risorsa = escape(var_nome)+ "=" +escape(var_valore);
    ajax.send(risorsa);
    return true;
}

function handler_risposta_server(risposta)
{
	document.getElementById('copia_sfida').value = risposta.trim();
    return true;
}

function codifica_password()
{
    var sfida = document.getElementById('copia_sfida').value;
    var password_in_chiaro = document.getElementById("pwd").value;
	
	document.getElementById("pwd_codified").value = MD5(sfida+MD5(password_in_chiaro));
    return true;
}

function Login(){
	document.getElementById('log_in_button').onclick = "";
	//creo variabile ajax
	var ajaxRequest = create_ajaxRequest();
	//gestisco risposta ajax
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var results = ajaxRequest.responseText;
			document.getElementById('login_area').innerHTML = results;
		}
	}
	
	codifica_password();
	var copia_sfida = document.getElementById('copia_sfida').value;
	var email = document.getElementById("email").value;
	var pwd = document.getElementById("pwd_codified").value;
	
	var params="email="+email+
	"&pwd="+pwd+
	"&copia_sfida="+copia_sfida;
	
	ajaxRequest.open("POST", "php/area_handler.php?__submit" , true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(params);
}
function forminput_login_click(){
	document.getElementById('email').value = "";
	document.getElementById('email').onclick = "";
}