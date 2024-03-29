<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

class Timeslots extends CI_Controller {
    
    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        //Check if user is connected
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_userdata('last_page', current_url());
            redirect('session/login');
        }
        $this->load->model('timeslots_model');
        $this->fullname = $this->session->userdata('firstname') . ' ' .
                $this->session->userdata('lastname');
        $this->is_admin = $this->session->userdata('is_admin');
        $this->user_id = $this->session->userdata('id');
        $this->language = $this->session->userdata('language');
        $this->language_code = $this->session->userdata('language_code');
        $this->load->helper('language');
        $this->lang->load('global', $this->language);
        $this->lang->load('timeslots', $this->language);
    }
    
    /**
     * Prepare an array containing information about the current user
     * @return array data to be passed to the view
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    private function getUserContext()
    {
        $this->load->model('users_model');
        $user = $this->users_model->get_users($this->user_id);
        $data['free'] = $user['free'];
        $data['fullname'] = $this->fullname;
        $data['is_admin'] = $this->is_admin;
        $data['user_id'] =  $this->user_id;
        $data['language'] = $this->language;
        $data['language_code'] =  $this->language_code;
       return $data;
    }

    /**
     * Display the list of timeslots for a room
     * Status is submitted
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function room($room) {
        $this->auth->check_is_granted('timeslots_list');
        $this->expires_now();
        $data = $this->getUserContext();
        $data['title'] = lang('timeslots_room_title');
        $this->load->model('rooms_model');
        $data['room'] = $this->rooms_model->get_room($room);
        $data['timeslots'] = $this->timeslots_model->get_timeslots($room);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('timeslots/room', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display the list of timeslots booked by the connected user
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function user() {
        $this->auth->check_is_granted('timeslots_list');
        $this->expires_now();
        $data = $this->getUserContext();
        $data['title'] = lang('timeslots_user_title');
        $data['timeslots'] = $this->timeslots_model->get_timeslots_user($this->user_id);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('timeslots/user', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Action : delete a timeslot (from my booking page)
     * @param int $id room identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function delete_booking($timeslot) {
        $this->auth->check_is_granted('timeslots_delete');
        $this->timeslots_model->delete_timeslot($timeslot);
        $this->session->set_flashdata('msg', lang('timeslots_delete_flash_msg'));
        redirect('timeslots/me');
    }
    
    /**
     * Action : delete a timeslot (from the validation page)
     * @param int $id room identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function delete_validation($timeslot) {
        $this->auth->check_is_granted('timeslots_delete');
        $this->timeslots_model->delete_timeslot($timeslot);
        $this->session->set_flashdata('msg', lang('timeslots_delete_flash_msg'));
        redirect('timeslots/validation');
    }
    
    /**
     * Display the list of timeslots to be validated by the connected user
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function validation() {
        $this->auth->check_is_granted('timeslots_list');
        $this->expires_now();
        $data = $this->getUserContext();
        $data['title'] = lang('timeslots_user_title');
        $data['timeslots'] = $this->timeslots_model->get_timeslots_validation($this->user_id);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('timeslots/validation', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display the form that allows to edit a timeslot
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function edit($timeslot) {
        $this->auth->check_is_granted('timeslots_edit');
        $data = $this->getUserContext();
        $data['timeslot'] = $this->timeslots_model->get_timeslot($timeslot);
        $data['title'] = lang('timeslots_edit_title');
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('startdate', lang('timeslots_edit_field_startdate'), 'required|xss_clean');
        $this->form_validation->set_rules('enddate', lang('timeslots_edit_field_enddate'), 'required|xss_clean');
        $this->form_validation->set_rules('status', lang('timeslots_edit_field_status'), 'required|xss_clean');
        $this->form_validation->set_rules('note', lang('timeslots_edit_field_note'), 'xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('timeslots/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $result = $this->timeslots_model->update_timeslots();
            //If the status is requested, send an email to the manager
            if ($this->input->post('status') == 2) {
                $this->sendMail($timeslot);
            }
            $this->session->set_flashdata('msg', lang('timeslots_edit_flash_msg'));
            redirect('rooms/' . $data['timeslot']['room_id'] . '/timeslots');
        }
    }
    
    /**
     * Action : delete a timeslot
     * @param int $id room identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function delete($room, $timeslot) {
        $this->auth->check_is_granted('timeslots_delete');
        $this->timeslots_model->delete_timeslot($timeslot);
        $this->session->set_flashdata('msg', lang('timeslots_delete_flash_msg'));
        redirect('rooms/' . $room . '/timeslots');
    }
    
    /**
     * Accept a booking request
     * @param int $id leave request identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function accept($id) {
        $this->auth->check_is_granted('timeslots_accept');
        $timeslot = $this->timeslots_model->get_timeslot($id);
        if (empty($timeslot)) {
            show_404();
        }
        if (($this->user_id != $timeslot['manager_id']) && ($this->is_admin == FALSE)) {
            log_message('error', 'User #' . $this->user_id . ' illegally tried to accept booking #' . $id);
            $this->session->set_flashdata('msg', lang('requests_accept_flash_msg_error'));
            redirect('locations');
        } else {
            $this->timeslots_model->accept($id);
            $this->sendMail($id);
            $this->session->set_flashdata('msg', lang('timeslots_accept_flash_msg'));
            redirect('timeslots/validation');
        }
    }

    /**
     * Reject a booking request
     * @param int $id leave request identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function reject($id) {
        $this->auth->check_is_granted('timeslots_reject');
        $timeslot = $this->timeslots_model->get_timeslot($id);
        if (empty($timeslot)) {
            show_404();
        }
        if (($this->user_id != $timeslot['manager_id']) && ($this->is_admin == FALSE)) {
            log_message('error', 'User #' . $this->user_id . ' illegally tried to reject booking #' . $id);
            $this->session->set_flashdata('msg', lang('timeslots_reject_flash_msg'));
            redirect('locations');
        } else {
            $this->timeslots_model->reject($id);
            $this->sendMail($id);
            
            $this->session->set_flashdata('msg',  lang('requests_reject_flash_msg_success'));
            redirect('timeslots/validation');
        }
    }

    /**
     * Send a confirmation email to the employee that requested the room
     * The method will check if the booking request wes accepted or rejected 
     * before sending the e-mail
     * @param int $id Leave request identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    private function sendMail($id)
    {
        $timeslot = $this->timeslots_model->get_timeslot($id);
        //Send an e-mail to the employee
         $config = Array(
            		'protocol' => 'smtp',
            		'smtp_host' => 'ssl://smtp.googlemail.com',
            		'smtp_port' => 465,
            		'smtp_user' => 'kimsan.poy@student.passerellesnumeriques.org', // change it to yours
            		'smtp_pass' => '10111996', // change it to yours
            		'mailtype' => 'html',
            		'charset' => 'iso-8859-1',
            		'wordwrap' => TRUE
            );
            
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->load->library('polyglot');
        $usr_lang = $this->polyglot->code2language($timeslot['creator_language']);
        $this->lang->load('email', $usr_lang);

        $this->lang->load('global', $usr_lang);
        $date = new DateTime($timeslot['startdate']);
        $startdate = $date->format(lang('global_datetime_format'));
        $date = new DateTime($timeslot['enddate']);
        $enddate = $date->format(lang('global_datetime_format'));
       

        $this->load->library('parser');
        $data = array(
            'Title' => lang('email_booking_request_validation_title'),
            'CreatorName' => $timeslot['creator_name'],
            'StartDate' => $startdate,
            'EndDate' => $enddate,
            'RoomName' => $timeslot['room_name'],
            'LocationName' => $timeslot['location_name']
        );
        
        $message = "";
        if ($timeslot['status'] == 3) {
            $message = $this->parser->parse('emails/' . $timeslot['creator_language'] . '/request_accepted', $data, TRUE);
            $this->email->subject(lang('email_booking_request_accept_subject'));
        } else {
            $message = $this->parser->parse('emails/' . $timeslot['creator_language'] . '/request_rejected', $data, TRUE);
            $this->email->subject(lang('email_booking_request_reject_subject'));
        }
        if ($this->email->mailer_engine== 'phpmailer') {
            $this->email->phpmailer->Encoding = 'quoted-printable';
        }
        if ($this->config->item('from_mail') != FALSE && $this->config->item('from_name') != FALSE ) {
           $this->email->from($this->config->item('from_mail'), $this->config->item('from_name'));
        } else {
           $this->email->from('do.not@reply.me', 'Darany');
        }
        $this->email->to($timeslot['creator_email']);
        $this->email->message($message);
        $this->email->send();
       // if(!$this->email->send()){
          //     show_error($this->email->print_debugger());
         //   }
    }
        
    /**
     * Internal utility function
     * make sure a resource is reloaded every time
     */
    private function expires_now() {
        // Date in the past
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        // always modified
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        // HTTP/1.1
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        // HTTP/1.0
        header("Pragma: no-cache");
    }
}
