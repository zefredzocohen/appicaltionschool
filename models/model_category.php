<?php

class Model_category extends CI_Model {

    protected $table;

    public function __construct() {
        parent::__construct();
        $this->table = "category";
    }

    public function add_category($param = array()) {
        $this->db->insert('category', $param);
        return $this->db->insert_id();
    }

    public function show_cat_parent() {
        $this->db->select('*')
                ->from($this->table)
                ->where('cat_type', 0);
        $result = $this->db->get();
        return $result->result_array();
    }
    
        public function show_cat_parent_default() {
        $this->db->select('*')
                ->from($this->table)
                ->where('cat_type', 0)
                ->where('cat_status',1)
                 ->order_by('cat_order', "ASC");
        $result = $this->db->get();
        return $result->result_array();
    }
     public function show_cat_child_default($cid) {
        $this->db->select('*')
                ->from($this->table)
                ->where('cat_type', $cid)
                ->where('cat_status',1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function list_all_category() {
        $this->db->select("*")
                ->from($this->table);
        $result = $this->db->get();
        $data = $result->result_array();
        return $data;
    }

    public function get_parent_cat() {
        $text = '-- ';
        $parent = $this->list_all_category();
        foreach ($parent as $cat_parent) {
            if ($cat_parent['cat_type'] == 0) {
                $list_cat[] = $cat_parent;
            }
            $this->db->select("*")
                    ->from($this->table)
                    ->where('cat_type', $cat_parent['cat_id']);
            $result = $this->db->get();
            $data = $result->result_array();
            foreach ($data as $childs) {
                $set = array(
                    'cat_name' => $text . $childs['cat_name'],
                    'cat_id' => $childs['cat_id'],
                    'cat_type' => $childs['cat_type'],
                    'cat_status' => $childs['cat_status'],
                    'cat_order' => "-- ".$childs['cat_order'],
                );
                $list_cat[] = $set;
            }
        }
        if(!empty($list_cat)){
             return $list_cat;
         }else{
             return "";
         }
       
    }

    public function update_cat($value = array(), $id) {
        $this->db->update($this->table, $value, array('cat_id' => $id));

        return $this->db->affected_rows();
    }

    public function delete_category($id) {
        $this->db->delete('category', array('cat_id' => $id));
        return $this->db->affected_rows();
    }

}
