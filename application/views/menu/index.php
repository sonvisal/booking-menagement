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
CI_Controller::get_instance()->load->helper('url');
CI_Controller::get_instance()->load->helper('language');
$this->lang->load('menu', $language);?>
<!--rothan header style-->
<div class="row-fluid header_style">
    <div class="span6">
        <h3><a href="<?php echo base_url();?>" style="text-decoration:none; color:white;"><img src="<?php echo base_url();?>assets/images/logo.png" class="logo">&nbsp;<?php echo lang('menu_banner_slogan');?></a>
    </div>
    <div class="span6 pull-right">
        <a href="<?php echo base_url();?>users/reset/<?php echo $user_id; ?>" title="<?php echo lang('menu_banner_tip_reset');?>" data-target="#frmChangeMyPwd" data-toggle="modal"><i class="icon-lock icon-white"></i></a>
        &nbsp;
<span class="header_welcome"><?php echo lang('menu_banner_welcome');?>&nbsp;&nbsp;<?php echo $fullname;?>,&nbsp;&nbsp;</span><a href="<?php echo base_url();?>session/logout"><span class="logout_style"><?php echo lang('menu_banner_logout');?></span></a>       
 <?php $source = urlencode(current_url());
        if ($free == TRUE) { ?>
          <a href="<?php echo base_url();?>users/<?php echo $user_id; ?>/availability/busy?source=<?php echo $source;?>" title="<?php echo lang('menu_banner_tip_set_busy');?>"><i class="icon-ok-sign icon-white"></i></a>
        <?php } else { ?>
          <a href="<?php echo base_url();?>users/<?php echo $user_id; ?>/availability/free?source=<?php echo $source;?>" title="<?php echo lang('menu_banner_tip_set_free');?>"><i class="icon-minus-sign icon-white"></i></a>
        <?php } ?>
        &nbsp;
    </div>
    <!--add an entry in the menu-->
    
</div>


<div id="frmChangeMyPwd" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h3><?php echo lang('menu_password_popup_title');?></h3>
    </div>
    <div class="modal-body">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><?php echo lang('menu_password_popup_button_cancel');?></button>
    </div>
</div>

<div class="navbar navbar-inverse">
  <!--rothna style menu-->
      <div class="row color_menu">
  <!--the end of rothna style menu-->
        <div class="container">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
            <div class="nav-collapse">
              <?php if ($is_admin == TRUE) { ?>
              <ul class="nav">			  
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_admin_title');?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>users"><?php echo lang('menu_admin_list_users');?></a></li>
                    <li><a href="<?php echo base_url();?>users/create"><?php echo lang('menu_admin_add_user');?></a></li>
                    
                  </ul>
                </li>
              </ul>
              <?php } ?>
              <ul class="nav">			  
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_assets_title');?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>locations"><?php echo lang('menu_assets_locations');?></a></li>
                  </ul>
                </li>
              </ul>
             <ul class="nav">			  
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_validation_title');?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>timeslots/validation"><?php echo lang('menu_validation_booking');?></a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav">			  
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('menu_booking_title');?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url();?>timeslots/me"><?php echo lang('menu_booking_requests');?></a></li>
                  </ul>
                </li>
              </ul>
                <ul class="nav">        
                <li class="dropdown">
                  <li><a href="<?php echo base_url();?>users/availability"><?php echo lang('menu_availability_title');?></a></li>
                </li>
              </ul>
            </div>		   
        </div>
      </div>
    </div><!-- /.navbar -->

    <script type="text/javascript">
        $(function () {
            $('#frmChangeMyPwd').alert();
        });
        
    </script>
