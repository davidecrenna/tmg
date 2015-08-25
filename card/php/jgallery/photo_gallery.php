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
    <script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="js/jgallery.min.js?v=1.5.0"></script>
    <script type="text/javascript" src="js/touchswipe.min.js"></script>
</head>
<body style="width: 900px; margin: 100px auto; height: auto;">
<div id="gallery">
<?php
	$card->Show_jgallery('photo/'.$folder_path,'../../../');
?>
</div>
<script type="text/javascript">
$( function() {
    $( '#gallery' ).jGallery( { mode: 'full-screen' } );
} );
</script>
</body>
</html>