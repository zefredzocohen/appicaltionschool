<?php

class Model_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($user,$pass) {
        $this->db->select("*")
                ->from("users")
                ->where("user_name", $user)
                ->where("user_pass", md5($pass));
        $result = $this->db->get();
        return $result->row_array();
    }

}
