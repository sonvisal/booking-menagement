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

class Rooms extends CI_Controller {
    
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
        $this->load->model('rooms_model');
        $this->fullname = $this->session->userdata('firstname') . ' ' .
                $this->session->userdata('lastname');
        $this->is_admin = $this->session->userdata('is_admin');
        $this->is_hr = $this->session->userdata('is_hr');
        $this->user_id = $this->session->userdata('id');
        $this->language = $this->session->userdata('language');
        $this->language_code = $this->session->userdata('language_code');
        $this->load->helper('language');
        $this->lang->load('rooms', $this->language);
        $this->lang->load('global', $this->language);
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
        $data['is_hr'] = $this->is_hr;
        $data['user_id'] =  $this->user_id;
        $data['language'] = $this->language;
        $data['language_code'] =  $this->language_code;
        return $data;
    }

    /**
     * Display list of rooms for a given location
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function index($location) {
        $this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $this->load->model('locations_model');
        $data['location'] = $this->locations_model->get_locations($location);
        $data['rooms'] = $this->rooms_model->get_rooms($location, TRUE);
        $data['title'] = lang('rooms_index_title');
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('rooms/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Display a qrcode containing the URL that allow to check the status of a room
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function qrcode($room) {
        $this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        include APPPATH . "/third_party/phpqrcode/qrlib.php";
        $this->expires_now();
        QRcode::png(base_url() . 'api/rooms/' . $room . '/status');
    }
    
    /**
     * Show the status of a room (free or not and next date of change)
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function status($room) {
        $this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $data['room'] = $this->rooms_model->get_room($room);
        $this->load->model('timeslots_model');
        $data['end_timeslot'] = $this->timeslots_model->end_full_timeslot($room);
        $data['next_timeslot'] = $this->timeslots_model->next_timeslot($room);
        $data['title'] = lang('rooms_status_title');
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('rooms/status', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Display the form that allows to book a room (create a timeslot)
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function book($room) {
        //$this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $data['room'] = $this->rooms_model->get_room($room);
        $data['title'] = lang('rooms_book_title');
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('room', '', 'required|xss_clean');
        $this->form_validation->set_rules('creator', '', 'required|xss_clean');
        $this->form_validation->set_rules('startdate', lang('rooms_book_field_startdate'), 'required|xss_clean');
        $this->form_validation->set_rules('enddate', lang('rooms_book_field_enddate'), 'required|xss_clean');
        $this->form_validation->set_rules('status', lang('rooms_book_field_status'), 'required|xss_clean');
        $this->form_validation->set_rules('note', lang('rooms_book_field_note'), 'xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/book', $data);
            $this->load->view('templates/footer');
        } else {
            
            $this->load->model('timeslots_model');
            $room = $this->input->post('room');
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            $status = $this->input->post('status');
            $creator = $this->input->post('creator');
            $note = $this->input->post('note');
           
            $date = new DateTime($startdate);
            $stdate = $date->format(lang('global_datetime_format'));
            $date = new DateTime($enddate);
            $endate = $date->format(lang('global_datetime_format'));
             $this->load->model('rooms_model');
             // select room's manager
            $manager = $this->rooms_model->select_room($room);
            if($manager){
                foreach($manager as $mg){
                    //print_r($mg->manager);
                    
                    if($mg->manager == 0 ){
                        // if the room doesn't have manager to manage
                        $this->load->model('timeslots_model');
                        // select datetime from timeslots
                        $time = $this->timeslots_model->get_time($room);
                            if($time){
                                // if this room used to book
                            foreach($time as $date){
                                 $dates = new DateTime($date->startdate);
                                 $start = $dates->format(lang('global_datetime_format'));
                                 $dates = new DateTime($date->enddate);
                                 $end = $dates->format(lang('global_datetime_format'));
                             if(($start!=$stdate && $end!=$endate)&&($start>$endate || $end<$stdate)){
                                  // accept  
                                 $status = 3;
                                 }  else {
                                     //reject
                                    $status = 4;
                                  }
                                 }
                             }else{
                                 // accept
                                $status=3;
                             }
                    }else {
                      // if this room has manger to manage
                        //request
                     $status = 2;
                    }
                }
            }
              $timeslot = $this->timeslots_model->book_room($room, $startdate, $enddate, $status, $creator,$note);
           //If the status is requested, send an email to the manager
            if ($status == 2) {
                // send mail to manager
                $this->sendMail($timeslot);
            }
            else if($status == 3){
                // redirect to accept automatically 
                redirect(base_url() . 'timeslots/accept/' . $timeslot);
            }else if($status == 4){
                // redirect to reject automaically
                redirect(base_url() . 'timeslots/reject/' . $timeslot); 
            }
          
            $this->session->set_flashdata('msg', lang('rooms_book_flash_msg'));
            redirect('timeslots/me');
         }
    }
    
    /**
     * Show the status of a room (free or not and next date of change)
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function calendar($room) {
        //$this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $data['room'] = $this->rooms_model->get_room($room);
        $this->lang->load('calendar', $this->language);
        $data['title'] = lang('calendar_room_title');
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('rooms/calendar', $data);
        $this->load->view('templates/footer');
    }
    
    /**
     * Ajax endpoint : Send a list of fullcalendar events
     * @param int $room Identifier of the meeting room
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function calfeed($room) {
        $this->expires_now();
        header("Content-Type: application/json");
        $start = $this->input->get('start', TRUE);
        $end = $this->input->get('end', TRUE);
        $this->load->model('timeslots_model');
        echo $this->timeslots_model->events($room, $start, $end);
    }
    
    /**
     * Display a form that allows adding a meeting room to a location
     * @param int $location Identifier of the location
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function create($location) {
        $this->auth->check_is_granted('rooms_create');
        $data = $this->getUserContext();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('rooms_create_title');
        $data['location'] = $location;

        $this->form_validation->set_rules('name', lang('rooms_create_field_name'), 'required|xss_clean');
        $this->form_validation->set_rules('manager', lang('rooms_create_field_manager'));
        $this->form_validation->set_rules('floor', lang('rooms_create_field_floor'), 'xss_clean');
        $this->form_validation->set_rules('description', lang('rooms_create_field_description'), 'xss_clean');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/create', $data);
            $this->load->view('templates/footer');
        } else {
            $image = $_FILES["profile_picture"]["name"];
            if($image!=''){
               $this->perform_upload($location);

            }  else {
                $data=array(
                    'location' => $location,
                    'name' => $this->input->post('name'),
                    'manager' => $this->input->post('manager'),
                    'floor' => $this->input->post('floor'),
                    'description' => $this->input->post('description'),
                    'image_name'=>''
            );
            
            $this->load->model('rooms_model');
            $this->rooms_model->set_rooms($data);
        }
            
            $this->session->set_flashdata('msg', lang('rooms_create_flash_msg'));
            redirect('locations/' . $location . '/rooms');
      }
    }
    //**** upload image
    public function perform_upload($location){
        $config =  array(
                'upload_path'     => "./image/",
                'allowed_types'   => "gif|jpg|png|jpeg|pdf",
                'overwrite'       => FALSE
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if($this->upload->do_upload('profile_picture'))
        {
            $data =$this->upload->data();
            $image=$data['file_name'];
            $this->resize_image('./image/'.$image);
            $data=array(
                    'location' => $location,
                    'name' => $this->input->post('name'),
                    'manager' => $this->input->post('manager'),
                    'floor' => $this->input->post('floor'),
                    'description' => $this->input->post('description'),
                    'image_name'=>$image
            );
           
            $this->load->model('rooms_model');
            $this->rooms_model->set_rooms($data);
          }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/create', $data);
            $this->load->view('templates/footer');
        }
    }
    public function resize_image($image){
        $config = array(
                'image_library'=>'gd2',
                'source_image'=>$image,
                'maintain_ratio'=>TRUE,
               //'create_thumb' =>TRUE,
                'width'=>300,
                'height'=>250
        );
        $this->load->library('image_lib',$config);
        $this->image_lib->resize();
       
        
    }
    /**
     * Display a form that allows editing a room
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function edit($location, $room) {
        $this->auth->check_is_granted('rooms_edit');
        $data = $this->getUserContext();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = lang('rooms_edit_title');
        $data['room'] = $this->rooms_model->get_room($room);
       
        $this->form_validation->set_rules('name', lang('rooms_create_field_name'), 'required|xss_clean');
        $this->form_validation->set_rules('manager', lang('rooms_create_field_manager'), 'required|xss_clean');
        $this->form_validation->set_rules('floor', lang('rooms_create_field_floor'), 'xss_clean');
        $this->form_validation->set_rules('description', lang('rooms_create_field_description'), 'xss_clean');
        $this->form_validation->set_rules('pro_pic','xss_clean');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/edit', $data);
            $this->load->view('templates/footer');
        } else {
             $image = $_FILES["pro_pic"]["name"];
            
            if($image!=''){
                $config =  array(
                'upload_path'     => "./image/",
                'allowed_types'   => "gif|jpg|png|jpeg|pdf",
                'overwrite'       => FALSE
                );
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('pro_pic'))
                {
                    $data =$this->upload->data();
                    $image=$data['file_name'];
                    $this->resize_image('./image/'.$image);
                  
                 }
            }  else {
                $img = $this->rooms_model->select_room($room);
                foreach ($img as $row){
                    $image= $row->image_name;
                    print_r($image);
                }
            }
            $this->rooms_model->update_rooms($image);
            $this->session->set_flashdata('msg', lang('rooms_edit_flash_msg'));
            redirect('locations/' . $location . '/rooms');
        }
    }
   
    //     // deleted room add more
    public function delete($id) {
    	///////$location = $this->uri->segment(2); can delete but 
    	$this->auth->check_is_granted('rooms_delete');
    	$data = $this->getUserContext();
    	$delet = $this->rooms_model->delete_rooms($id);
        
    	$this->session->set_flashdata('msg', lang('rooms_delete_flash_msg'));// name of model and _flash_smg
    	//redirect('locations/'.$location.'/rooms');
        redirect('locations');
        
    
    }
    /**
     * Send a booking request email to the manager of the meeting room
     * @param int $timeslot timeslot identifier
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    private function sendMail($timeslot) {
        $this->load->model('rooms_model');
        $room = $this->rooms_model->get_room_from_timeslot($timeslot);

        if (empty($room['manager_email'])) {
            $this->session->set_flashdata('msg', lang('rooms_book_flash_msg_error'));
            
        } else {
            $acceptUrl = base_url() . 'timeslots/accept/' . $timeslot;
            $rejectUrl = base_url() . 'timeslots/reject/' . $timeslot;
            $detailUrl = base_url() . 'timeslots/me';

             $config = Array(
            		'protocol' => 'smtp',
            		'smtp_host' => 'ssl://smtp.googlemail.com',
            		'smtp_port' => 465,
            		'smtp_user' => 'vc2015_service@passerellesnumeriques.org', // change it to yours
            		'smtp_pass' => 'vc-Service12', // change it to yours
            		'mailtype' => 'html',
            		'charset' => 'iso-8859-1',
            		'wordwrap' => TRUE
            );
            
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->load->library('polyglot');
            $usr_lang = $this->polyglot->code2language($room['manager_language']);
            $this->lang->load('email', $usr_lang);

            $this->lang->load('global', $usr_lang);
            $date = new DateTime($this->input->post('startdate'));
            $startdate = $date->format(lang('global_datetime_format'));
            $date = new DateTime($this->input->post('enddate'));
            $enddate = $date->format(lang('global_datetime_format'));

            $this->load->library('parser');
            $data = array(
                'Title' => lang('email_booking_request_title'),
                'Creator' => $room['creator_name'],
                'RoomName' => $room['room_name'],
                'LocationName' => $room['location_name'],
                'StartDate' => $startdate,
                'EndDate' => $enddate,
                'Note' => $this->input->post('note'),
                'UrlAccept' => $acceptUrl,
                'UrlReject' => $rejectUrl,
                'UrlDetails' => $detailUrl
            );
            $message = $this->parser->parse('emails/' . $room['manager_language'] . '/request', $data, TRUE);
            if ($this->email->mailer_engine == 'phpmailer') {
                $this->email->phpmailer->Encoding = 'quoted-printable';
            }

            if ($this->config->item('from_mail') != FALSE && $this->config->item('from_name') != FALSE ) {
                $this->email->from($this->config->item('from_mail'), $this->config->item('from_name'));
            } else {
               $this->email->from('do.not@reply.me', 'Darany');
            }
            $this->email->to($room['manager_email']);
            $this->email->subject(lang('email_booking_request_subject'));
            $this->email->message($message);
            if(!$this->email->send()){
                show_error($this->email->print_debugger());
            }
        }
    }
    
    /**
     * Action: export the list of rooms attached to a given location into an Excel file
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function export($location) {
        $this->auth->check_is_granted('rooms_export');
        $this->expires_now();
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle(lang('rooms_export_title'));
        $this->excel->getActiveSheet()->setCellValue('A1', lang('rooms_export_thead_id'));
        $this->excel->getActiveSheet()->setCellValue('B1', lang('rooms_export_thead_name'));
        $this->excel->getActiveSheet()->setCellValue('C1', lang('rooms_export_thead_manager'));
        $this->excel->getActiveSheet()->setCellValue('D1', lang('rooms_export_thead_floor'));
        $this->excel->getActiveSheet()->setCellValue('E1', lang('rooms_export_thead_description'));
        $this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $rooms = $this->rooms_model->get_rooms($location);
        $line = 2;
        foreach ($rooms as $room) {
            $this->excel->getActiveSheet()->setCellValue('A' . $line, $room['id']);
            $this->excel->getActiveSheet()->setCellValue('B' . $line, $room['name']);
            $this->excel->getActiveSheet()->setCellValue('C' . $line, $room['manager']);
            $this->excel->getActiveSheet()->setCellValue('D' . $line, $room['floor']);
            $this->excel->getActiveSheet()->setCellValue('E' . $line, $room['description']);
            $line++;
        }

        $filename = 'rooms.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
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
    // this function for construction room 
     public function construct($room) {
        //$this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $data['room'] = $this->rooms_model->get_room($room);
        $data['title'] = lang('rooms_book_title');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('startdate', lang('rooms_book_field_startdate'), 'required|xss_clean');
        $this->form_validation->set_rules('enddate', lang('rooms_book_field_enddate'), 'required|xss_clean');
        $this->form_validation->set_rules('status', lang('rooms_book_field_status'), 'required|xss_clean');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/construction', $data);
            $this->load->view('templates/footer');
        } 
    }
    
    
    public function set_construction($room) {
        //$this->auth->check_is_granted('rooms_list');
        $data = $this->getUserContext();
        $data['room'] = $this->rooms_model->get_room($room);
        $data['title'] = lang('rooms_book_title');
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('room', '', 'required|xss_clean');
        $this->form_validation->set_rules('creator', '', 'required|xss_clean');
        $this->form_validation->set_rules('startdate', lang('rooms_book_field_startdate'), 'required|xss_clean');
        $this->form_validation->set_rules('enddate', lang('rooms_book_field_enddate'), 'required|xss_clean');
        $this->form_validation->set_rules('status', lang('rooms_book_field_status'), 'required|xss_clean');
        $this->form_validation->set_rules('note', lang('rooms_book_field_note'), 'xss_clean');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('rooms/book', $data);
            $this->load->view('templates/footer');
        } else {
            
            $this->load->model('timeslots_model');
            $room = $this->input->post('room');
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            $status = $this->input->post('status');
            $creator = $this->input->post('creator');
            $note = $this->input->post('note');
           
            $date = new DateTime($startdate);
            $stdate = $date->format(lang('global_datetime_format'));
            $date = new DateTime($enddate);
            $endate = $date->format(lang('global_datetime_format'));
             $this->load->model('rooms_model');
             // select room's manager
            $manager = $this->rooms_model->select_room($room);
            if($manager){
                foreach($manager as $mg){
                    //print_r($mg->manager);
                    
                    if($mg->manager == 0 ){
                        // if the room doesn't have manager to manage
                        $this->load->model('timeslots_model');
                        // select datetime from timeslots
                        $time = $this->timeslots_model->get_time($room);
                            if($time){
                                // if this room used to book
                            foreach($time as $date){
                                 $dates = new DateTime($date->startdate);
                                 $start = $dates->format(lang('global_datetime_format'));
                                 $dates = new DateTime($date->enddate);
                                 $end = $dates->format(lang('global_datetime_format'));
                             if(($start!=$stdate && $end!=$endate)&&($start>$endate || $end<$stdate)){
                                  // accept  
                                 $status = 3;
                                 }  else {
                                     //reject
                                    $status = 4;
                                  }
                                 }
                             }else{
                                 // accept
                                $status=3;
                             }
                    }else {
                      // if this room has manger to manage
                        //request
                     $status = 2;
                    }
                }
            }
              $timeslot = $this->timeslots_model->book_room($room, $startdate, $enddate, $status, $creator,$note);
           //If the status is requested, send an email to the manager
            if ($status == 2) {
                // send mail to manager
                $this->sendMail($timeslot);
            }
            else if($status == 3){
                // redirect to accept automatically 
                redirect(base_url() . 'timeslots/accept/' . $timeslot);
            }else if($status == 4){
                // redirect to reject automaically
                redirect(base_url() . 'timeslots/reject/' . $timeslot); 
            }
          
            $this->session->set_flashdata('msg', lang('rooms_book_flash_msg'));
            redirect('timeslots/me');
         }
    }
    
    
//     //set construction room in construnction
//    public function set_construction($room){
//         $startdate = $this->input->post('startdate');
//         $enddate = $this->input->post('enddate');
//         $date = new DateTime($startdate);
//         $stdate = $date->format(lang('global_datetime_format'));
//         $date = new DateTime($enddate);
//         $endate = $date->format(lang('global_datetime_format'));
//        $this->load->model('timeslots_model');
//        $timeslote=$this->timeslots_model->get_construct($id);
//        $manager = $this->rooms_model->select_room($room);
//        foreach ($manager as $mge){
//            if($mge->manager==0){
//                 $this->load->model('timeslots_model');
//                        // select datetime from timeslots
//                $time = $this->timeslots_model->get_time($room);
//                if($time){
//                    foreach ($time as $date){
//                        $dates = new DateTime($date->startdate);
//                        $start = $dates->format(lang('global_datetime_format'));
//                        $dates = new DateTime($date->enddate);
//                        $end = $dates->format(lang('global_datetime_format'));
//                        if($start<=$startdate && $enddate>=$endate){
//                            
//                            $send_email=$this->sendMail($timeslot);
//                            if($send_email){
//                                $timeslot = $this->timeslots_model->book_room($room, $startdate, $enddate, $status, $creator,$note);
//                                redirect(base_url() . 'timeslots/reject/' . $timeslot);
//                            }else{
//                                $this->load->view('rooms/constuction');
//                            }
//                            
//                        }
//                    }
//                    
//                    
//                }
//            }
//            
//        }
//    }
    
    
}
