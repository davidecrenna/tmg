<?php 
require_once("../../headerbasic.php");
require_once('../../header.php');

$card= new Card($_GET["u"]);
$id_news = $_GET["id_news"];

for($i=0;$i<count($card->news_rows);$i++){
	if($card->news_rows[$i]["id"]==$id_news){
		$index=$i;
	}
}
$estensione_file = strtolower(pathinfo($card->news_rows[$index]["file"], PATHINFO_EXTENSION));



function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $card->news_rows[$index]["titolo"]." di ".$card->Getnameshowed(); ?></title>
<meta property="og:title" content="<? echo $card->news_rows[$index]["titolo"]." di ".$card->Getnameshowed(); ?>"/>
<meta property="og:url" content="<? echo curPageURL(); ?>"/>
<? 
if($estensione_file == 'jpg' || $estensione_file == 'png' || $estensione_file == 'gif' || $estensione_file == 'jpeg'){
			echo '<meta property="og:image" content="'.PATH_SITO.USERS_PATH.$card->username."/download_area/evidenza/news_".$card->news_rows[$index]["id"]."/".$card->news_rows[$index]["file"].'"/>';
		}else{
			echo '<meta property="og:image" content="'.PATH_SITO.'/image/banner/logo.png"/>';
		}
?>
<meta property="og:site_name" content="Topmanagergroup.com"/>
<meta property="og:description" content="<? echo substr($card->news_rows[$index]["descrizione"], 0, 100)."..."; ?>"/>


<link rel="stylesheet" type="text/css" href="../../common/css/buttons.css"/>
<link rel="stylesheet" type="text/css" href="../css/show_news_file.css"/>
<link rel="stylesheet" type="text/css" href="../css/card_black.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/text.css"/>
<link rel="stylesheet" type="text/css" href="../../common/css/icon.css"/>

<link rel="stylesheet" type="text/css" href="../../common/css/jquery.msgbox.css" />
<link rel="stylesheet" type="text/css" href="../../common/css/jquery.jfe_style.css"/>
<script src="../../common/js/all_jquery_and_tools.min.js "></script>
<!--
<script type="text/javascript" src="../../common/js/jquery.min.for.msgbox.js"></script>-->

<script type="text/javascript" src="../../common/js/jquery.msgbox.min.js"></script>

<script type="text/javascript" src="../../common/js/ZeroClipboard.js"></script>

<script type="text/javascript" src="../js/show_news_file.js"></script>

<script type="text/javascript" src="../../common/js/jquery.jfe-1.0.0.min.js"></script>



<script type="text/javascript">
$(document).ready(function() {
  $("#player").jfe ({ ver:"10,0,0", display:"both" });
});

$(function(){
    $('#p1').click(function(){
        $(this).select();
    });
});

</script>
</head>
<body>

<div class="riga">
<div class="colonna-1">
<header>
<div id="logo">
<a href="<? echo PATH_SITO; ?>"><img src="../../image/banner/banner_scaled.png"></a>
</div>

<nav>
<ul><li>
<?php
	
	$title=urlencode($card->news_rows[$index]["titolo"]." di ".$card->Getnameshowed());

	$url=urlencode(curPageURL());

	$summary=urlencode(substr($card->news_rows[$index]["descrizione"], 0, 100)."...");

	if($estensione_file == 'jpg' || $estensione_file == 'png' || $estensione_file == 'gif' || $estensione_file == 'jpeg'){
			$image=urlencode(PATH_SITO.USERS_PATH.$card->username."/download_area/evidenza/news_".$card->news_rows[$index]["id"]."/".$card->news_rows[$index]["file"]);
		}else{
			$image=urlencode(PATH_SITO."/image/banner/logo.png");
		}
	

	?>
	<a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="../../image/icone/fb-condividi-button.png" title="Condividi su Facebook." /></a>

</li>
<? if(!$card->is_mobile()){ ?>
<li><a id="buttoncondividi" style="cursor:pointer; font-weight:700; " >Condividi il link della pagina</a></li>
<? }else{ ?>
<li>Link della pagina: <textarea rows="2" cols="50" onclick="this.focus();this.select()" readonly="readonly">
  <? echo  curPageURL(); ?>
</textarea></li>
<? } ?>
</ul>
</nav>

</header>	
</div>
</div>


<div class="riga rigacentrale">
<div class="colonna-1">
<h2><? echo $card->news_rows[$index]["titolo"]; ?></h2>
<h3><? echo $card->news_rows[$index]["sottotitolo"]; ?></h3>
<p><? echo $card->news_rows[$index]["descrizione"]; ?></p>	
</div>

</div>
<div class="riga rigacentrale">
<div class="colonna-1">
<h2>File Allegato alla News/Evento:

<? if($card->news_rows[$index]["file"]!=""){
		 echo '<p><a href="download.php?u='.$card->username.'&evidenza=true&name='.$card->news_rows[$index]["file"].'&id='.$card->news_rows[$index]["id"].'" class="text14px" style=" height:20px; text-align:left; vertical-align:middle;"><img src="../../image/filebox/icona_download.png"  style="width:20px; height:20px; vertical-align:middle;" />&nbsp;&nbsp;SCARICA ALLEGATO ('.$card->news_rows[$index]["file"].')</span></p>'; ?>
		</h2>
		<?php
		
		if($estensione_file == 'pdf'){
			if(!$card->is_mobile()){
		   echo "<iframe src='"."../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$card->news_rows[$index]["id"]."/".$card->news_rows[$index]["file"]."' allowTransparency frameborder='0' width='100%' style='overflow:hidden; height: 700px; '></iframe>";
			}else{
				?>
                <h2>Anteprima PDF:</h2>
         <iframe src='photoswipegallery.php?dirpath=<? echo "../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$card->news_rows[$index]["id"]."/pdfconverted/"; ?>' width='100%' height='700' frameborder='0' style='overflow-y:auto;'></iframe>
                <?	
			}
		   
		}else if($estensione_file == 'jpg' || $estensione_file == 'png' || $estensione_file == 'gif' || $estensione_file == 'jpeg'){
			echo '<p><img src="'."../../".USERS_PATH.$card->username."/download_area/evidenza/news_".$card->news_rows[$index]["id"]."/".$card->news_rows[$index]["file"].'" class="scala" alt=""></p>';
		}
	}
	else{
		echo "<h3>Non è presente nessun allegato.</h3>";	
	}
?>

</div>
</div>

<!--<div class="riga rigacentralesmartphone">

<div class="colonna-1">
<h2>File Allegato alla News/Evento:</h2>
	<? if($card->news_rows[$index]["file"]!=""){
		 echo '<p><a href="download.php?u='.$card->username.'&evidenza=true&name='.$card->news_rows[$index]["file"].'&id='.$card->news_rows[$index]["id"].'" class="text14px" style=" height:20px; text-align:left; vertical-align:middle;"><img src="../../image/filebox/icona_download.png"  style="width:20px; height:20px; vertical-align:middle;" />&nbsp;&nbsp;SCARICA ALLEGATO ('.$card->news_rows[$index]["file"].')</span></a></p>'; 
		 
	}?>

</div>


</div>-->
<div class="riga">
<div class="colonna-1">
<footer>
<p><a href="../../index.php" style="cursor:pointer; font-size:12px; font-weight:700; color:#000;">TopManagerGroup website version <? echo date("Y"); ?> - </a>
					<?php echo '<span style="font-weight:700;" ><a href="../../index.php?tab=iscrizione&u='.$card->username.'" >ENTRA NEL GRUPPO</a></span> - ';
					?>
                    <span id="triggers_assistenza"><a style="cursor:pointer; font-weight:700; " rel="#assistenza">Assistenza</a></span> - 
<span id="triggers_abuso"><a style="cursor:pointer; font-weight:700; " rel="#abuso">Segnala abuso</a></span> - <span id="triggers_informazioni"><a style="cursor:pointer; font-weight:700; " rel="#informazioni">Informazioni</a></span></p>
</footer>
</div>
</div>


<script type="text/javascript">
ZeroClipboard.setMoviePath('../../card/php/ZeroClipboard.swf');
var clip = new ZeroClipboard.Client();
clip.addEventListener('mousedown',function() {
  clip.setText("<? echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>");
});
clip.addEventListener('complete',function(client,text) {
	  $.msgbox("Il link della pagina di questa pagina: "+"<? echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>"+" è stato copiato nei tuoi appunti, puoi utilizzare incolla per copiarlo dove preferisci.", {
	  type: "confirm",
	  buttons: [
		{type: "submit", value: "Chiudi"}
	  ]
	});
});

clip.glue('buttoncondividi');
</script>

<? 
$card->Show_overlay_assistenza();
$card->Show_overlay_informazioni(true);
$card->Show_overlay_abuso();
?>
<script type="text/javascript" src="../js/show_news_file_overlay.js"></script>
</body>
</html>