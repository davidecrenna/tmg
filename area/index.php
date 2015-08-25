<?php 
	include("../area_header.php");
	$area = new Area();
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration Area</title>
<link rel="stylesheet" type="text/css" href="../common/css/common.css"/>
<link rel="stylesheet" type="text/css" href="../common/css/text.css"/>
<link rel="stylesheet" type="text/css" href="../common/css/button.css"/>
<link rel="stylesheet" type="text/css" href="css/login.css"/>
<link rel="stylesheet" type="text/css" href="css/index.css"/>
<script src="../common/js/all_jquery_and_tools.min.js "></script>
<script src="js/login.js" type="text/javascript"></script>
<script src="js/index.js" type="text/javascript"></script>
<script src="../common/js/ajax.inc.js" type="text/javascript"></script>
<script src="../common/js/md5.js" type="text/javascript"></script>
</head>

<body>
    <div align="center">
         	<div class="cols">
                    <div class="col">
                    	<p style="font-size:18px;">Area amministrazione</p>
                        <div id="login_area">
                    	<? $area->Show_area_login();?>
                        
                        </div>
                    </div>
                    <div style="left: 300px;" class="col2">
                    </div>
             </div>
        </div>
</body>
</html>