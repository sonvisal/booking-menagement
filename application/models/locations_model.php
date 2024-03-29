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

class Locations_model extends CI_Model {

    /**
     * Default constructor
     */
    public function __construct() {
        
    }

    /**
     * Get the list of locations or one location
     * @param int $id optional id of a location
     * @return array record of locations
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function get_locations($id = 0) {
        if ($id === 0) {
            $query = $this->db->get('locations');
            return $query->result_array();
        }
        $query = $this->db->get_where('locations', array('id' => $id));
        return $query->row_array();
    }
    public function get_locationmap($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('locations');
        return $query->result_array();
    }
    
    /**
     * Insert a new location
     * Inserted data are coming from an HTML form
     * @return int number of affected rows
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function set_locations() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'address' => $this->input->post('address')
        );
        return $this->db->insert('locations', $data);
    }
    
    /**
     * Delete a location from the database
     * @param int $id identifier of the location
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
   
    public function delete_location($id) {
        $query = $this->db->delete('locations', array('id' => $id));
        //Cascade delete timeslots
        $this->load->model('rooms_model');
        $rooms = $this->rooms_model->get_rooms($id);
        foreach ($rooms as $room) {
            $this->rooms_model->delete_rooms($room['id']);
        }
    }
    
    /**
     * Update a location. Update data are coming from an HTML form
     * @return int number of affected rows
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function update_locations() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'address' => $this->input->post('address')
        );

        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('locations', $data);
    }
     //function update map 
    public function update_map(){
        $datamap=array(
            'lattitude'=>$this->input->post('lattitude'),
            'longitude'=>$this->input->post('longitude')
            );
       $this->db->where('id', $this->input->post('id'));
       return $this->db->update('map',$datamap);
    }
    // function get data map
    public function get_map($id){
         $query = $this->db->get_where('map', array('id' => $id));
         return $query->row_array();
    }
    // insert data map
    public function insert_map(){
        $datamap=array(
            'lattitude'=>$this->input->post('lattitude'),
            'longitude'=>$this->input->post('longitude')
            );
       $this->db->where('id', $this->input->post('id'));
       return $this->db->insert('map',$datamap);
    }
}
