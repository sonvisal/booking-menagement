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

class Rooms_model extends CI_Model {

    /**
     * Default constructor
     */
    public function __construct() {
        
    }

    /**
     * Get the list of rooms for a given location
     * @param int $location id of a location
     * @param bool $checkStatus If true, check the availability of the rooms
     * @return array record of rooms
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function get_rooms($location, $checkStatus = FALSE) {
        $this->db->select('rooms.*, CONCAT_WS(\' \', users.firstname, users.lastname) as manager_name', FALSE);
        $this->db->join('users', 'users.id = rooms.manager','left');
        $query = $this->db->get_where('rooms', array('location' => $location));
        $result =  $query->result_array();
        if ($checkStatus) {
            $this->load->model('timeslots_model');
            for ($ii=0; $ii <count($result); $ii++) {
                $enddate = $this->timeslots_model->end_timeslot($result[$ii]['id']);
                if (is_null($enddate))
                    $result[$ii]['free'] = TRUE;
                else
                    $result[$ii]['free'] = FALSE;
            }
        }
        return $result;
    }
    
    /**
     * Get the details of a room
     * @param int $room id of a room
     * @return array record of room
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function get_room($room) {
        $this->db->select('rooms.*, CONCAT_WS(\' \', users.firstname, users.lastname) as manager_name', FALSE);
        $this->db->select('locations.id as location_id');
        $this->db->select('locations.name as location_name');
        $this->db->select('users.email');
        $this->db->join('users', 'users.id = rooms.manager','left');
        $this->db->join('locations', 'locations.id = rooms.location');
        $query = $this->db->get_where('rooms', array('rooms.id' => $room));
        $result =  $query->result_array();
        return $result[0];
    }
    
    /**
     * Get the details of a room form the timeslot ID
     * @param int $timeslot id of a timeslot
     * @return array record of room
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function get_room_from_timeslot($timeslot) {
        $this->db->select('rooms.id');
        $this->db->select('mgr.email as manager_email');
        $this->db->select('mgr.language as manager_language');
        $this->db->select('usr.email as creator_email');
        $this->db->select('CONCAT_WS(\' \', usr.firstname, usr.lastname) as creator_name', FALSE);
        $this->db->select('rooms.name as room_name');
        $this->db->select('locations.name as location_name');
        $this->db->select('timeslots.startdate');
        $this->db->select('timeslots.enddate');
        $this->db->join('users usr', 'timeslots.creator = usr.id');
        $this->db->join('rooms', 'timeslots.room = rooms.id');
        $this->db->join('locations', 'rooms.location = locations.id');
        $this->db->join('users mgr', 'rooms.manager = mgr.id','left');
        $query = $this->db->get_where('timeslots', array('timeslots.id' => $timeslot));
        $result =  $query->result_array();
        return $result[0];
    }
    
    /**
     * Get the list of all rooms whatever the location is
     * @return array record of rooms
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function get_all_rooms() {
        $this->db->select('locations.name as location_name');
        $this->db->select('CONCAT_WS(\' \', users.firstname, users.lastname) as manager_name', FALSE);
        $this->db->select('rooms.*');
        $this->db->join('users', 'users.id = rooms.manager','left');
        $this->db->join('locations', 'locations.id = rooms.location');
        $query = $this->db->get('rooms');
        return $query->result_array();
    }
    
    /**
     * Insert a new room (a meeting room is attached to a location)
     * Inserted data are coming from an HTML form
     * @return type
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function set_rooms($data) {
        
        return $this->db->insert('rooms', $data);
    }
    
    /**
     * Update a room into the database.
     * Update data are coming from a HTML form
     * @return int number of affected rows
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function update_rooms($image) {
        $data = array(
            'manager' => $this->input->post('manager'),
            'name' => $this->input->post('name'),
            'floor' => $this->input->post('floor'),
            'description' => $this->input->post('description'),
            'image_name'=>$image
        );

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('rooms', $data);
    }
    
    public function delete_rooms($id) {
    	$deleted = $this->db->delete('rooms', array('id' => $id));
           $query = $this->db->get('rooms',array('id'=>id));
        return $query->result();
    	
    }
    // select room with id to get manager to validate manager
    public function select_room($room){
         $query= $this->db->get_where('rooms', array('id' => $room));
        $result = $query->result();
        return $result;
    }
//    public function canncel_room_model($id){
//        $this->db->where('id',$id);
//        $this->db->delete();
//        
//    }
    
}
	