<?php 
/*
 * This file is part of darany.
 *
 * darany is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * darany is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with darany. If not, see <http://www.gnu.org/licenses/>.
 */
?>

<script src="https://maps.googleapis.com/maps/api/js"></script>
<head>
    <link href="<?php echo base_url();?>assets/css/lmsimple.css" rel="stylesheet">
    
</head>
<h2><?php echo lang('locations_create_title');?></h2>

<?php echo validation_errors(); ?>

<?php
$attributes = array('id' => 'target');
echo form_open('locations/create', $attributes); ?>

    <label for="name"><?php echo lang('locations_create_field_name');?></label>
    <input type="text" name="name" id="name" autofocus required /><br />

    <label for="description"><?php echo lang('locations_create_field_description');?></label>
    <textarea type="input" name="description" id="description" /></textarea>

    <label for="address"><?php echo lang('locations_create_field_address');?></label>
    <textarea type="input" name="address" id="address" /></textarea>
    <br /><br />
    <!--rotna style icon key white-->
    <button id="send" class="btn btn-primary"><i class="icon-ok icon-white"></i>&nbsp;<?php echo lang('locations_create_button_create');?></button>
    &nbsp;
    <a href="<?php echo base_url(); ?>locations" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;<?php echo lang('locations_create_button_cancel');?></a>
    <div id="mapvalue">
    <div class="input-group" >
     <div id="map-canvas"></div><br/><br/><br/><br/>
     <div id="tb_none">
      <table id="tb_map">
             <tr>
               <td>
                 <label class="input-group-addon">Lattitude</label>
               </td>
               <td>
                 <input type="text" name="lattitude"   id="lattitude"  onkeyup="initialize()" />
               </td>
             
                 <td>
                   <label class="input-group-addon">Longitude</label>
                 </td>
                 <td>
                    <input type="text" name="longitude"  id="longitude"  onkeyup="initialize()" />
                 </td>
               </tr>
        </table>
    </div> 
  </div>
</form>
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