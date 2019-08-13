<?php
class Model_users extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function validate($email,$password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $result = $this->db->get('users',1);
        return $result;
    }

    function get_all_users(){
        $result = $this->db->get('users');
        return $result->result_array();
    }

    function get_users($id){
        $result = $this->db->get_where('users', array('id' => $id));
        return $result->result_array();
    }

    function delete_user($id){
        $result = $this->db->delete('users', array('id' => $id));
        return $result;
    }
 
}