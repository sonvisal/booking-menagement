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
$this->lang->load('users', $language);
$this->lang->load('datatable', $language);
$this->lang->load('global', $language);?>

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
    $("#flashbox").alert();
});
</script>
<?php } ?>
        
<h1><?php echo lang('users_index_title');?></h1>

<div class="container">
    <div class="row">
        <div class="col-md-12">

<div id="no-more-tables">

<table cellpadding="0" cellspacing="0" border="0" id="users" width="100%" class="col-md-12 table-bordered table-striped table-condensed cf display">
    <thead class="cf">
        <tr>
            <th><?php echo lang('users_index_thead_id');?></th>
            <th><?php echo lang('users_index_thead_firstname');?></th>
            <th class="numeric"><?php echo lang('users_index_thead_lastname');?></th>
            <th class="numeric"><?php echo lang('users_index_thead_login');?></th>
            <th class="numeric"><?php echo lang('users_index_thead_email');?></th>
            <th class="numeric"><?php echo lang('users_index_thead_role');?></th>
            <th class="numeric"><?php echo lang('users_index_thead_status');?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($users as $users_item): ?>
    <tr>
        <td data-title="ID" data-order="<?php echo $users_item['id']; ?>">
            <a href="<?php echo base_url();?>users/<?php echo $users_item['id'] ?>" title="<?php echo lang('users_index_thead_tip_view');?>"><?php echo $users_item['id'] ?></a>
            &nbsp;
            <div class="pull-right">
                <a href="<?php echo base_url();?>users/<?php echo $users_item['id'] ?>" title="<?php echo lang('users_index_thead_tip_view');?>"><i class="icon-eye-open icon-blue"></i></a>
                &nbsp;
                <a href="<?php echo base_url();?>users/edit/<?php echo $users_item['id'] ?>" title="<?php echo lang('users_index_thead_tip_edit');?>"><i class="icon-edit icon-blue"></i></a>
                &nbsp;
                <a href="#" class="confirm-delete" data-id="<?php echo $users_item['id'];?>" title="<?php echo lang('users_index_thead_tip_delete');?>"><i class="icon-trash icon-red"></i></a>
                &nbsp;
                <a href="<?php echo base_url();?>users/reset/<?php echo $users_item['id'] ?>" title="<?php echo lang('users_index_thead_tip_reset');?>" data-target="#frmResetPwd" data-toggle="modal"><i class="icon-lock icon-blue"></i></a>
            </div>
        </td>
        <td data-title="Firstname"><?php echo $users_item['firstname'] ?></td>
        <td data-title="Lastname" class="numeric"><?php echo $users_item['lastname'] ?></td>
        <td data-title="Login" class="numeric"><?php echo $users_item['login'] ?></td>
        <td data-title="E-mail" class="numeric"><a href="mailto:<?php echo $users_item['email']; ?>"><?php echo $users_item['email']; ?></a></td>
        <td data-title="Role" class="numeric"><?php echo $users_item['role'] ?></td>
        <td data-title="Status" class="numeric"><?php if ( $users_item['free']== true) {?>
            <a href="#" title="free"><i class="icon-ok-sign icon-blue"></i></a>
      <?php  }else {?>
                <a href="#" title="busy"><i class="icon-minus-sign icon-red"></i></a>
           <?php } ?></td>
    </tr>
<?php endforeach ?>
	</tbody>
</table>
    </div>
	</div>
</div>
</div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">&nbsp;</div>
</div>

<div class="row-fluid">
    <div class="span2">
      <a href="<?php echo base_url();?>users/export" class="btn bg btn-primary"><i class="icon-file icon-white"></i>&nbsp;<?php echo lang('users_index_button_export');?></a>
    </div>
    <div class="span2">
      <a href="<?php echo base_url();?>users/create" class="btn bg btn-primary"><i class="icon-plus-sign icon-white"></i>&nbsp;<?php echo lang('users_index_button_create_user');?></a>
    </div>
    <div class="span2">
        &nbsp;
        <!--<a href="<?php echo base_url();?> users/import" class="btn btn-primary" data-target="#frmImportUsers" data-toggle="modal"><i class="icon-arrow-up icon-white"></i>&nbsp;<?php echo lang('users_index_button_import_user');?></a><//-->
    </div>
</div>

<link href="<?php echo base_url();?>assets/datatable/css/jquery.dataTables.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/datatable/js/jquery.dataTables.min.js"></script>

<div id="frmConfirmDelete" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('users_index_popup_delete_title');?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo lang('users_index_popup_delete_message');?></p>
        <p><?php echo lang('users_index_popup_delete_question');?></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" id="lnkDeleteUser"><?php echo lang('users_index_popup_delete_button_yes');?></a>
        <a href="#" onclick="$('#frmConfirmDelete').modal('hide');" class="btn btn-danger"><?php echo lang('users_index_popup_delete_button_no');?></a>
    </div>
</div>

<div id="frmResetPwd" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h3><?php echo lang('users_index_popup_password_title');?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal"><?php echo lang('users_index_popup_password_button_cancel');?></button>
    </div>
</div>

<div id="frmImportUsers" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmImportUsers').modal('hide');" class="close">&times;</a>
         <h3><?php echo lang('users_index_button_export');?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="$('#frmImportUsers').modal('hide');" class="btn secondary"><?php echo lang('users_index_button_export');?></a>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    //Transform the HTML table in a fancy datatable
    $('#users').dataTable({
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
    $("#frmResetPwd").alert();
    $("#frmImportUsers").alert();
	
    //On showing the confirmation pop-up, add the user id at the end of the delete url action
    $('#frmConfirmDelete').on('show', function() {
        var link = "<?php echo base_url();?>users/delete/" + $(this).data('id');
        $("#lnkDeleteUser").attr('href', link);
    });

    //Display a modal pop-up so as to confirm if a user has to be deleted or not
    //We build a complex selector because datatable does horrible things on DOM...
    //a simplier selector doesn't work when the delete is on page >1 
    $("#users tbody").on('click', '.confirm-delete',  function(){
        var id = $(this).data('id');
        $('#frmConfirmDelete').data('id', id).modal('show');
    });
    
    //Prevent to load always the same content (refreshed each time)
    $('#frmConfirmDelete').on('hidden', function() {
        $(this).removeData('modal');
    });
    $('#frmResetPwd').on('hidden', function() {
        $(this).removeData('modal');
    });
    $('#frmImportUsers').on('hidden', function() {
        $(this).removeData('modal');
    });
});
</script>
