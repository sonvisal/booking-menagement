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

/*CI_Controller::get_instance()->load->helper('language');
$this->lang->load('datatable', $language);*/?>
<head>
    
    <style>
        
        #upload_image_room{
            float: right;
            width:600px;
        }
    </style>
</head>
<div id="upload_image_room">
    <img id="myImg" src="<?php echo base_url().'image/b22.jpg'?>" alt="your image"  style="margin-top: 58px; width:300px;"/>
</div>
<div>
<h2><?php echo lang('rooms_create_title');?></h2>

<?php echo validation_errors(); ?>

<?php
$attributes = array('id' => 'target');
echo form_open_multipart('locations/' . $location . '/rooms/create', $attributes); ?>

    <label for="name"><?php echo lang('rooms_create_field_name');?></label>
    <input type="text" name="name" id="name" autofocus required /><br />

    <input type="hidden" name="manager" id="manager" /><br />
    <label for="txtManager"><?php echo lang('rooms_create_field_manager');?></label>
    <div class="input-append">
        <input type="text" id="txtManager" name="txtManager" required readonly />
        <a id="cmdSelectManager" class="btn btn-primary"><?php echo lang('rooms_create_button_select');?></a>
    </div><br />
    
    <label for="floor"><?php echo lang('rooms_create_field_floor');?></label>
    <input type="text" name="floor" id="floor" /><br />
    
    <label for="description"><?php echo lang('rooms_create_field_description');?></label>
    <textarea type="input" name="description" id="description" /></textarea><br/>
         
<br/>
    <?php echo form_upload(array('name' =>'profile_picture','id'=>'file_name')); ?>
    <button id="send" class="btn btn-primary"><i class="icon-ok icon-white"></i>&nbsp;<?php echo lang('rooms_create_button_create');?></button>
    &nbsp;
    <a href="<?php echo base_url();?>locations/<?php echo $location; ?>/rooms" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;<?php echo lang('rooms_create_button_cancel');?></a>
</form>

</div>
<div id="frmSelectManager" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmSelectManager').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('rooms_create_popup_manager_title');?></h3>
    </div>
    <div class="modal-body" id="frmSelectManagerBody">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="select_manager();" class="btn btn-primary"><?php echo lang('rooms_create_popup_manager_button_ok');?></a>
        <a href="#" onclick="$('#frmSelectManager').modal('hide');" class="btn btn-danger"><?php echo lang('rooms_create_popup_manager_button_cancel');?></a><br/>
    </div>
    </div>

<script type="text/javascript">
    function select_manager() {
        var manager = $('#employees .row_selected td:first').text();
        var text = $('#employees .row_selected td:eq(1)').text();
        text += ' ' + $('#employees .row_selected td:eq(2)').text();
        $('#manager').val(manager);
        $('#txtManager').val(text);
        $("#frmSelectManager").modal('hide');
    }
   $(function () {
        //Popup select manager
        $("#cmdSelectManager").click(function() {
            $("#frmSelectManager").modal('show');
            $("#frmSelectManagerBody").load('<?php echo base_url(); ?>users/employees');
        });
    });
   // function for display image when user click browse to image 
//   $("#file_name").click(function(){
//      var newPreview = document.getElementById("file_name");
//      alert(newPreview);
////      if(newPreview!=''){
////          $('#imag_upload').attr('src',newPreview);
////      }else{
////           $('#imag_upload').html('no did not upload image');
////      }
//   });
// upload and display image didn't load page
   $(function () {
    $("#file_name").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});
function imageIsLoaded(e) {
    $('#myImg').attr('src', e.target.result);
};

</script>
