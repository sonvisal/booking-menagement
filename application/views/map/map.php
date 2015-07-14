
<!DOCTYPE html>
<html>
<head>
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize() {
      	/*var lattitude=document.getElementById('lattitude').value();
      	var longitude=document.getElementById('longitude').value();*/
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/lmsimple.css">
</head>

<body>
    <div id="googleMap" >
        
       <div id="map-canvas">
       </div>
       <div>
	       	
	       	<label>lattitude:</label>
	       <input type="text" id="lattitude"/>
	       <label>longitude:</label>
	       <input type="text" id="longitude"/>
	   </div>
    </div><br>
     <a href="<?php echo base_url();?>locations" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i>&nbsp; Back to the locations</a>&nbsp;
     
</body>
</html>