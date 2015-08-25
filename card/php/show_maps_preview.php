<?php
	require_once("../../headerbasic.php"); 
	include("../../header.php");
	$username=$_GET['u'];
	if(session_id() == '') {
		session_name(SESSION_NAME);
	   // Now we cat start the session
	   session_start();
	}
	$card= new Card(NULL,$username);
	if(!$card->is_user_logged()){
		header("location: ../../error_page.php");
		exit ("Non hai effettuato l'accesso!" );
	}
 
  	$address = $card->address_via.", ".$card->address_citta;
	$address_desc = addslashes($card->address_desc);
	$response = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true'); 
	$response = json_decode($response);
	
	$latitudine = $response->results[0]->geometry->location->lat;
	$longitudine = $response->results[0]->geometry->location->lng;
  ?>
<!DOCTYPE html>

<html>
  <head>
    <title>Showing pixel and tile coordinates</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../../common/css/text.css"/>
    <meta charset="utf-8">
    <style>
		html, body {
		  height: 100%;
		  margin: 0;
		  padding: 0;
		}
		
		#map-canvas, #map_canvas {
		  height: 247px;
		  width:407px;
		}
		
		@media print {
		  html, body {
			height: auto;
		  }
		
		  #map-canvas, #map_canvas {
			height: 650px;
		  }
		}
		
		#panel {
		  position: absolute;
		  top: 5px;
		  left: 50%;
		  margin-left: -180px;
		  z-index: 5;
		  background-color: #fff;
		  padding: 5px;
		  border: 1px solid #999;
		}
	</style>
    
    <? if($latitudine==""||$latitudine==NULL||$latitudine==0||$longitudine==""||$longitudine==NULL||$longitudine==0){
		echo "<span class='text14px'>L'utente non ha ancora inserito un indirizzo.</span>";		
	}else{?>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

	<? } ?>
        <script>
var map;
var TILE_SIZE = 500;
var position = new google.maps.LatLng(<? echo $latitudine; ?>,<? echo $longitudine; ?>);

function bound(value, opt_min, opt_max) {
  if (opt_min != null) value = Math.max(value, opt_min);
  if (opt_max != null) value = Math.min(value, opt_max);
  return value;
}

function degreesToRadians(deg) {
  return deg * (Math.PI / 180);
}

function radiansToDegrees(rad) {
  return rad / (Math.PI / 180);
}

/** @constructor */
function MercatorProjection() {
  this.pixelOrigin_ = new google.maps.Point(TILE_SIZE / 2,
      TILE_SIZE / 2);
  this.pixelsPerLonDegree_ = TILE_SIZE / 360;
  this.pixelsPerLonRadian_ = TILE_SIZE / (2 * Math.PI);
}

MercatorProjection.prototype.fromLatLngToPoint = function(latLng,
    opt_point) {
  var me = this;
  var point = opt_point || new google.maps.Point(0, 0);
  var origin = me.pixelOrigin_;

  point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;

  // Truncating to 0.9999 effectively limits latitude to 89.189. This is
  // about a third of a tile past the edge of the world tile.
  var siny = bound(Math.sin(degreesToRadians(latLng.lat())), -0.9999,
      0.9999);
  point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) *
      -me.pixelsPerLonRadian_;
  return point;
};

MercatorProjection.prototype.fromPointToLatLng = function(point) {
  var me = this;
  var origin = me.pixelOrigin_;
  var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
  var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
  var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) -
      Math.PI / 2);
  return new google.maps.LatLng(lat, lng);
};

function createInfoWindowContent() {
  var numTiles = 1 << map.getZoom();
  var projection = new MercatorProjection();
  var worldCoordinate = projection.fromLatLngToPoint(position);
  var pixelCoordinate = new google.maps.Point(
      worldCoordinate.x * numTiles,
      worldCoordinate.y * numTiles);
  var tileCoordinate = new google.maps.Point(
      Math.floor(pixelCoordinate.x / TILE_SIZE),
      Math.floor(pixelCoordinate.y / TILE_SIZE));

  return [
    "Ci puoi trovare qui",
    "<? echo $address; ?>",
	"'<? echo $address_desc; ?>"
  ].join("<br>");
}

function initialize() {
  var mapOptions = {
    zoom: 12,
    center: position,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var coordInfoWindow = new google.maps.InfoWindow();
  coordInfoWindow.setContent(createInfoWindowContent());
  coordInfoWindow.setPosition(position);
  coordInfoWindow.open(map);

  google.maps.event.addListener(map, 'zoom_changed', function() {
    coordInfoWindow.setContent(createInfoWindowContent());
    coordInfoWindow.open(map);
  });
  
  var marker = new google.maps.Marker({
      position: position,
      map: map,
      title: "<? echo $address; ?>"
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>
