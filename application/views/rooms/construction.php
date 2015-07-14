<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2><?php echo lang('rooms_set_book_title') .': <font color="red">'.$room['name'].'</font>';?></h2>

<?php echo validation_errors(); ?>
<div class="span6">
<?php
//$attributes = array('id' => 'target');
echo form_open('rooms/set_construction/' . $room['id']); ?>
    <input type="hidden" name="creator" value="<?php echo $user_id;?>" />
    <input type="hidden" name="room" value="<?php echo $room['id'];?>" />
    <input type="hidden" name="status" value="2" />

    <label for="viz_startdate"><?php echo lang('rooms_book_field_startdate');?></label>
    <input type="text" id="viz_startdate" name="viz_startdate" /><br />
    <input type="hidden" name="startdate" id="startdate" />
    
    <label for="viz_enddate"><?php echo lang('rooms_book_field_enddate');?></label>
    <input type="text" id="viz_enddate" name="viz_enddate" /><br />
    <input type="hidden" name="enddate" id="enddate" />
    
    <label for="note"><?php echo lang('rooms_book_field_note');?></label>
    <textarea type="input" name="note" id="njhnjnote" /></textarea>

    <br /><br />
    <button  id="send" class="btn btn-primary"><i class="icon-ok icon-white"></i>&nbsp;<?php echo lang('rooms_book_button_Construction');?></button>
    &nbsp;
    <a href="<?php echo base_url(); ?>locations/<?php echo $room['location_id']; ?>/rooms" id="#myModal" class="btn btn-danger"><i class="icon-remove icon-white"></i>&nbsp;<?php echo lang('rooms_book_button_cancel');?></a>
</form>
</div>
<div class="span6">
    <?php 
    $this->load->helper('HTML');
    echo img('image/'.$room['image_name']);
        //echo $room['image_name'];
    ?>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/flick/jquery-ui-1.10.4.custom.min.css">
<link href="<?php echo base_url();?>assets/css/jquery-ui-timepicker-addon.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
<?php //Prevent HTTP-404 when localization isn't needed
if ($language_code != 'en') { ?>
<script src="<?php echo base_url();?>assets/js/i18n/jquery.ui.datepicker-<?php echo $language_code;?>.js"></script>
<?php } ?>
<script src="<?php echo base_url();?>assets/js/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript">
    
   $(function () {
        var startDateTextBox = $('#viz_startdate');
        var endDateTextBox = $('#viz_enddate');

        startDateTextBox.datetimepicker({ 
            timeFormat: 'HH:mm',
            altField: "#startdate",
            minDate: 0,
            altFieldTimeOnly: false,
            altFormat: "yy-mm-dd",
            altTimeFormat: "H:m",
            onClose: function(dateText, inst) {
                    if (endDateTextBox.val() != '') {
                            var testStartDate = startDateTextBox.datetimepicker('getDate');
                            var testEndDate = endDateTextBox.datetimepicker('getDate');
                            if (testStartDate > testEndDate)
                                    endDateTextBox.datetimepicker('setDate', testStartDate);
                    }
                    else {
                            endDateTextBox.val(dateText);
                    }
            },
            onSelect: function (selectedDateTime){
                    endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
                    $('#viz_startdate').datepicker('setDate', this.value).show();
                    $('#viz_enddate').datepicker('setDate', this.value).show();
            }
        });
        endDateTextBox.datetimepicker({ 
            timeFormat: 'HH:mm',
            altField: "#enddate",
            altFieldTimeOnly: false,
            minDate: 0,
            altFormat: "yy-mm-dd",
            altTimeFormat: "H:m",
            onClose: function(dateText, inst) {
                    if (startDateTextBox.val() != '') {
                            var testStartDate = startDateTextBox.datetimepicker('getDate');
                            var testEndDate = endDateTextBox.datetimepicker('getDate');
                            if (testStartDate > testEndDate)
                                    startDateTextBox.datetimepicker('setDate', testEndDate);
                    }
                    else {
                            startDateTextBox.val(dateText);
                    }
            },
            onSelect: function (selectedDateTime){
                    startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
                    $('#viz_enddate').datepicker('setDate', this.value).show();
            }
        });
   
    });

</script>


