<?php
	require_once("../../../headerbasic.php");
	include("../../../header.php");
	$username=$_GET['u'];
	$folder_path=$_GET['folder_path'];
	$card= new Card(NULL,$username);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
        <title><?php echo $card->Show_title(); ?> - Photo Gallery</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/jgallery.min.css?v=1.5.0" />
    <link rel="stylesheet" type="text/css" href="../../../basic/css/tmgheader.css">

    <!--<script src="http://cdn.jquerytools.org/1.2.6/tiny/jquery.tools.min.js"></script>-->
    <!--<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>">-->
    <!--<script src="http://cdn.jquerytools.org/1.2.6/jquery.tools.min.js"></script>-->
    <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="js/jgallery.min.js?v=1.5.0"></script>
    <script type="text/javascript" src="js/touchswipe.min.js"></script>
</head>
<body style="font-size: 14px;">
<?php  echo $basic->Show_header(false,"../../../",true); ?>
<div id="gallery"  style="margin-top:3em; ">
<?php
	$card->Show_jgallery('photo/'.$folder_path,'../../../');
?>
</div>
<script type="text/javascript">
$( function() {
   // $( '#gallery' ).jGallery( { mode: 'full-screen' } );
    $( '#gallery' ).jGallery({ mode: 'full-screen' } );
    $(document).ready(function() {
        $(".jgallery").css("margin-top", "3.9em");
        $(window).resize(function () {
            if (document.documentElement.clientWidth <= 615) {
                $('#tmgheader_logo_img').attr("src", "../../../image/banner/logo_headertmg_mobile.png");
            } else {
                $('#tmgheader_logo_img').attr("src", "../../../image/banner/logo_headertmg.png");
            }
        }).resize();

    });
} );
</script>
</body>
</html>