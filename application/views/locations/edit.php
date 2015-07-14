<html>
<head><title>The joker was here</title>
    
    <script src="https://maps.googleapis.com/maps/api/js"></script>
</head>
<body >
  
<h2><?php echo lang('locations_edit_title');?><?php echo $location['id']; ?></h2>
<?php echo validation_errors(); ?>
<?php echo form_open('locations/edit/' . $location['id']) ?>
    <input type="hidden" name="id" value="<?php echo $location['id']; ?>" /><br />
    <label for="name"><?php echo lang('locations_edit_field_name');?></label>
    <input type="text" name="name" id="name" value="<?php echo $location['name']; ?>" autofocus required /><br />

    <label for="description"><?php echo lang('locations_edit_field_description');?></label>
    <textarea type="input" name="description" id="description" /><?php echo $location['description']; ?></textarea><br />

    <label for="address"><?php echo lang('locations_edit_field_address');?></label>
    <textarea type="input" name="address" id="address" /><?php echo $location['address']; ?></textarea>

    <br /><br />
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i>&nbsp;<?php echo lang('locations_edit_button_update');?></button>
    &nbsp;
    <a href="<?php echo base_url();?>locations" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;<?php echo lang('locations_edit_button_cancel');?></a>
    <div id="mapvalue" >
    <div class="input-group" >
     <div id="map-canvas"></div><br/><br/><br/><br/>
      <table  class="table-responsive">
             <tr>
               <td>
                 <label class="input-group-addon">Lattitude</label>
               </td>
               <td>
                 <input type="text" name="lattitude"   id="lattitude"  value="<?php echo $map['lattitude']; ?>" onkeyup="initialize()" />
               </td>
             
                 <td>
                   <label class="input-group-addon">Longitude</label>
                 </td>
                 <td>
                    <input type="text" name="longitude"  id="longitude"  value="<?php echo $map['longitude']; ?>" onkeyup="initialize()" />
                 </td>
               </tr>
        </table>
    </div> 
  </div>
<?php echo form_close() ?>
   <script>
      function initialize() {
     var lat = document.getElementById("lattitude").value;
      var lng = document.getElementById("longitude").value;
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(lat, lng),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script> 
</body>
</html>