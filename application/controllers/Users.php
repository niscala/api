<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_users');
        $this->load->database();
    }

    function register_post() {
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');
        $email = $this->post('email');
        $password = $this->post('password');
    
        if (empty($email)) {
            $this->response(array('errorEmail' => 'Email is empty', 502));
        } else if (empty($password)) {
            $this->response(array('errorPass' => 'Password is empty', 502));
        } else {
            if (empty($first_name)) {
               $first_name = $email;
            } else {
                $first_name = $first_name;
            }
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => sha1($password)
            );
            $insert = $this->db->insert('users', $data);
            if ($insert) {
                $this->response($data, 200);
            } else {
                $this->response(array('status' => 'failed', 502));
            }
        }
    }

    function login_post() {
        $email = $this->post('email');
        $password = sha1($this->post('password'));

        $check = $this->model_users->validate($email,$password);
        $this->response($check);

        if ($check->num_rows() > 0) {
            $d = $check->row_array();
            $data = array(
                'first_name' => $d['first_name'],
                'last_name' => $d['last_name'],
                'email' => $d['email']
            );
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'failed', 502));
        }
    }

    function take_user_get() {
      
        $id = $this->get('id');
        if ($id == NULL) {
            $data = $this->model_users->get_all_users();
        } else {
            $data = $this->model_users->get_users($id);
        }

        if (empty($data)) {
            $this->response(array('status' => 'Not found', 502));
        } else {
            $this->response($data, 200);
        }
    }

    function delete_user_get() {
      
        $id = $this->get('id');
        if ($id <= 0) {
            $this->response(array('status' => 'Something went wrong', 502)); 
        } else {
            $delete = $this->model_users->delete_user($id);
            if ($delete) {
                $this->response($delete, 200);
            }
        }
    }
