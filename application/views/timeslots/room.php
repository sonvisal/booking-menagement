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

CI_Controller::get_instance()->load->helper('language');
$this->lang->load('datatable', $language);?>

<div class="row-fluid">
    <div class="span12">
<?php if($this->session->flashdata('msg')){ ?>
<div class="alert fade in" id="flashbox">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $this->session->flashdata('msg'); ?>
 
</div>
 
<script type="text/javascript">
//Flash message
$(document).ready(function() {
    $(".alert").alert();
});
</script>
<?php } ?>

<h1><?php echo lang('timeslots_room_title');?>&nbsp;<span class="muted">(<?php echo $room['name']; ?>)</span></h1>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="timeslots" width="100%" id="tbl">
    <thead>
        <tr>
            <th><?php echo lang('timeslots_room_thead_id');?></th>
            <th><?php echo lang('timeslots_room_thead_startdate');?></th>
            <th><?php echo lang('timeslots_room_thead_enddate');?></th>
            <th><?php echo lang('timeslots_room_thead_status');?></th>
            <th><?php echo lang('timeslots_room_thead_creator');?></th>
            <th><?php echo lang('timeslots_room_thead_note');?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($timeslots as $timeslot): 
    $date = new DateTime($timeslot['startdate']);
    $tmpStartDate = $date->getTimestamp();
    $startdate = $date->format(lang('global_datetime_format'));
    $date = new DateTime($timeslot['enddate']);
    $tmpEndDate = $date->getTimestamp();
    $enddate = $date->format(lang('global_datetime_format'));?>
    <tr>
        <td data-order="<?php echo $timeslot['id']; ?>">
            <?php echo $timeslot['id']; ?>
            <?php if ($is_admin == TRUE) { ?>
            <div class="pull-right">
                <a href="<?php echo base_url();?>timeslots/edit/<?php echo $timeslot['id']; ?>" title="<?php echo lang('timeslots_room_tooltip_edit');?>"><i class="icon-edit icon-blue"></i></a>
                &nbsp;
                <a href="#" class="confirm-delete" data-id="<?php echo $timeslot['id'];?>" title="<?php echo lang('timeslots_room_tooltip_delete');?>"><i class="icon-trash icon-red"></i></a>
            </div>
            <?php } ?>
        </td>
        <td data-order="<?php echo $tmpStartDate; ?>"><?php echo $startdate; ?></td>
        <td data-order="<?php echo $tmpEndDate; ?>"><?php echo $enddate; ?></td>
        <td><?php echo lang($timeslot['status_name']); ?></td>
        <td><?php echo $timeslot['creator_name']; ?></td>
        <td><?php echo $timeslot['note']; ?></td>
    </tr>
<?php endforeach ?>
    </tbody>
</table>
	</div>
</div>

<div class="row-fluid"><div class="span12">&nbsp;</div></div>

<div class="row-fluid">
    <div class="span12">
      <a href="<?php echo base_url();?>locations/<?php echo $room['location_id']; ?>/rooms" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i>&nbsp; <?php echo lang('timeslots_room_button_back');?></a>
      &nbsp;
      <a href="<?php echo base_url();?>rooms/book/<?php echo $room['id']; ?>" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp; <?php echo lang('timeslots_room_button_create');?></a>
    </div>
</div>
<div id="frmDeleteBooking" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmDeleteBooking').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('timeslots_room_popup_delete_title');?></h3>
         
    </div>
    <div class="modal-body">
        <p><?php echo lang('timeslots_room_popup_delete_message');?></p>
        <p><?php echo lang('timeslots_room_popup_delete_question');?></p>
    </div>
    <div class="modal-footer">
        <a href="#" id="lnkDeleteBooking" class="btn danger"><?php echo lang('timeslots_room_popup_delete_button_yes');?></a>
        <a href="#" onclick="$('#frmDeleteBooking').modal('hide');" class="btn secondary"><?php echo lang('timeslots_room_popup_delete_button_no');?></a>
    </div>
</div>

</div><div class="row-fluid"><div class="span12">&nbsp;</div></div>

<link href="<?php echo base_url();?>assets/datatable/css/jquery.dataTables.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#frmDeleteBooking').alert();
    
    //Transform the HTML table in a fancy datatable
    $('#timeslots').dataTable({
                  "order": [[ 1, "desc" ]],
	"oLanguage": {
                    "sEmptyTable":     "<?php echo lang('datatable_sEmptyTable');?>",
                    "sInfo":           "<?php echo lang('datatable_sInfo');?>",
                    "sInfoEmpty":      "<?php echo lang('datatable_sInfoEmpty');?>",
                    "sInfoFiltered":   "<?php echo lang('datatable_sInfoFiltered');?>",
                    "sInfoPostFix":    "<?php echo lang('datatable_sInfoPostFix');?>",
                    "sInfoThousands":  "<?php echo lang('datatable_sInfoThousands');?>",
                    "sLengthMenu":     "<?php echo lang('datatable_sLengthMenu');?>",
                    "sLoadingRecords": "<?php echo lang('datatable_sLoadingRecords');?>",
                    "sProcessing":     "<?php echo lang('datatable_sProcessing');?>",
                    "sSearch":         "<?php echo lang('datatable_sSearch');?>",
                    "sZeroRecords":    "<?php echo lang('datatable_sZeroRecords');?>",
                    "oPaginate": {
                        "sFirst":    "<?php echo lang('datatable_sFirst');?>",
                        "sLast":     "<?php echo lang('datatable_sLast');?>",
                        "sNext":     "<i class='icon-forward icon-blue'></i>",
                        "sPrevious": "<i class='icon-backward icon-blue'></i>"
                    },
                    "oAria": {
                        "sSortAscending":  "<?php echo lang('datatable_sSortAscending');?>",
                        "sSortDescending": "<?php echo lang('datatable_sSortDescending');?>"
                    }
                }
            });
      
    //On showing the confirmation pop-up, add the user id at the end of the delete url action
    $('#frmDeleteBooking').on('show', function() {
        var link = "<?php echo base_url();?>rooms/<?php echo $room['id']; ?>/timeslots/" + $(this).data('id') + "/delete";
        $("#lnkDeleteBooking").attr('href', link);
    });
    
    //Display a modal pop-up so as to confirm if a room has to be deleted or not
    //We build a complex selector because datatable does horrible things on DOM...
    //a simplier selector doesn't work when the delete is on page >1 
    $("#timeslots tbody").on('click', '.confirm-delete',  function(){
        var id = $(this).data('id');
        $('#frmDeleteBooking').data('id', id).modal('show');
    });
    
    //Prevent to load always the same content (refreshed each time)
    $('#frmDeleteBooking').on('hidden', function() {
        $(this).removeData('modal');
    });
    
      
});
  $('table tr td:nth-child(4)').each(function(){
          var texts = $(this).text();
          if(texts=='Accepted'){
              $(this).css({"color":"#468847",
                            "font-weight":'bold'});
          }else if(texts=='Requested'){
              $(this).css({'color':'#F89406',
                           "font-weight":'bold'
                       });
          }else if(texts=='Rejected'){
              $(this).css({
                  'color':'#0073CC',
                  "font-weight":'bold'
              });
          }
    });


</script>
