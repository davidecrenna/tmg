<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<!-- Core CSS file -->
<link rel="stylesheet" type="text/css" href="../../common/css/photoswipe.css"/>
<!-- Skin CSS file (styling of UI - buttons, caption, etc.)
     In the folder of skin CSS file there are also:
     - .png and .svg icons sprite, 
     - preloader.gif (for browsers that do not support CSS animations) -->
<link rel="stylesheet" type="text/css" href="../../common/css/default-skin/default-skin.css"/>
<!-- Core JS file -->
<script type="text/javascript" src="../../common/js/photoswipe.min.js"></script>
<!-- UI JS file -->
<script type="text/javascript" src="../../common/js/photoswipe-ui-default.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Photoswipe Gallery</title>
</head>

<body>
<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" >

    <!-- Background of PhotoSwipe. 
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <div class="pswp__container">
            <!-- don't modify these 3 pswp__item elements, data is added later on -->
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>


                <!--<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
-->
                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

          </div>

        </div>

</div>
<script type="text/javascript">
	var pswpElement = document.querySelectorAll('.pswp')[0];
	
	var items = [
        {
	<?
		$path =$_GET["dirpath"];
		
		$filecount = 0;
		$files = glob($path . "*");
		if ($files){
		 $filecount = count($files);
		}
		$conta=0;
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) != false) {
					if($file!= "." && $file!= ".."){
						$conta++;
						$filename = $file;
						$image_size = getimagesize ( $path.$filename );
						$width = $image_size[0];
						$height = $image_size[1];
							echo "src: '".$path.$filename."',
							 w: ".$width.",
							 h: ".$height;
						if($conta<$filecount)	
							echo "},{ ";
						else
							echo "}";
					}
				}
				closedir($dh);
			}
		}
	
	?>
	
	];

    // define options (if needed)
    var options = {
             // history & focus options are disabled on CodePen        
        history: false,
		closeOnScroll: false,
		closeOnVerticalDrag: false,
		pinchToClose: false,
		escKey: false,
		tapToClose: false,
        focus: false,
		maxSpreadZoom: 4,

        showAnimationDuration: 0,
        hideAnimationDuration: 0
        
    };
    
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
</script>

</body>
</html>