<?php 
	include("header.php");
	$login = new Login();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accedi per continuare</title>
<link rel="stylesheet" type="text/css" href="card/css/page.css"/>
<link rel="stylesheet" type="text/css" href="common/css/login.css"/>

<script src="common/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="common/js/login.js" type="text/javascript"></script>
<script src="common/js/ajax.inc.js" type="text/javascript"></script>
<script src="common/js/md5.js" type="text/javascript"></script>
</head>

<body>
	<div align="center">
        	<div class="page_up">
              	<a href='index.php'><img src="image/page/banner.png" /></a>
            </div>
         	<div class="cols" id="upload">
                    <div class="col">
                    	<p style="font-size:18px;">Accedi al tuo account per usufruire dei servizi Top Manager Group.</p>
                        <? if(isset($_GET['url']))
                        		echo "<input type='hidden' id='url_di_provenienza' value='".$_GET['url']."'></input>"; ?>
                        <div id="login_area">
                    	<? $login->Show_login();?>
                        
                        </div>
                    </div>
                    <div style="left: 300px;" class="col2">
                    </div>
             </div>
             <div class="page_down"></div>
        </div>
</body>
</html>