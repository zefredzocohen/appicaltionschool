<?php

class Model_core extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
 public function query($query){
        $query = $this->db->query($query);
        if ($query->num_rows() > 0)
        {
           return $query->result_array();
        }else{
            return array();
        }
    }
    public function show_all($table, $where = "", $value_where = "" ,$limit = "",$cols  = "") {
        if ($where == "" && $value_where == "" && $limit == "") {
            $this->db->select("*")
                    ->from($table);
            $result = $this->db->get();
        } 
        else if($limit == "" && $cols == "")
        {
           $this->db->select("*")
                    ->from($table)
                    ->where($where, $value_where);
              $result = $this->db->get(); 
        }else{
            $this->db->select("*")
                    ->from($table)
                    ->where($where, $value_where)
                    ->limit($limit)
                    ->order_by($cols, "DESC");
              $result = $this->db->get();
        }
   
        
        return $result->result_array();
    }
    public function _select_and_where($table,$array_where){
            $this->db->select("*")
                    ->from($table)
                    ->where($array_where);
              $result = $this->db->get();
         return $result->result_array();
    }
    public function get_post_meta($post_id,$name){

         $this->db->select("*")
                    ->from("post_meta")
                    ->where( array("post_id"=>$post_id, "meta_name"=>$name));
              $result = $this->db->get();
         return $result->result_array();
    }
     public function get_option($name){
         $this->db->select("*")
                    ->from("setting")
                    ->where( 'name',$name);
              $result = $this->db->get();
         $data = $result->result_array();
         return $data[0]["value"];
    }
    function get_inforpay($value){
        $this->db->select('*');
        $this->db->where('name',$value);
       $query= $this->db->get('setting');
       $data['data']=$query->result_array();
       return $data;
        
    }

    public function get_info_user($user_id){

         $this->db->select("*")
                    ->from("users")
                    ->where( array("user_id"=>$user_id));
              $result = $this->db->get();
         return $result->result_array();
    }
    public function show_order($table, $where = "", $value_where = "" ,$cols  = "")
    {
      
             $this->db->select("*")
                    ->from($table)
                    ->where($where, $value_where)
                    ->order_by($cols, "DESC");
              $result = $this->db->get();
         return $result->result_array();
    }

    public function show_list_order($table, $where = "", $value_where = "",$and_where ="", $value_and_where = "" ,$cols  = "")
    {
      
             $this->db->select("*")
                    ->from($table)
                    ->where($where, $value_where)
                    ->where($and_where,$value_and_where)
                    ->order_by($cols, "DESC");
              $result = $this->db->get();
         return $result->result_array();
    }
    
    public function select_limit($table,$limit,$offset)
    {
        $this->db->select("*")->from($table)->limit($limit,$offset);
        $result = $this->db->get();
        return $result->result_array();
    }
    public function select_limit_id($table,$cols,$id,$limit,$offset,$order = "")
    {   
        if($order == ""){
             $this->db->select("*")->from($table)->where($cols,$id)->limit($limit,$offset);
             $result = $this->db->get();
        }else{
             $this->db->select("*")->from($table)->where($cols,$id)->order_by($order, "DESC")->limit($limit,$offset);
             $result = $this->db->get();
        }
       
        return $result->result_array();
    }


    public function insert($param = array(),$table) {
        $this->db->insert($table, $param);
        return $this->db->insert_id();
    }
    public function update($value = array(),$table,$cols, $id) {
        $this->db->update($table, $value, array($cols => $id));

        return $this->db->affected_rows();
    }
    public function delete($table,$cols,$id)
    {
        $this->db->delete($table,array($cols =>$id));
        return $this->db->affected_rows();
    }
    
    public function select_random($table,$cols,$limit)
    {
        $this->db->select("*")->from($table)->order_by($cols, 'RANDOM')->limit($limit);
        $result = $this->db->get();
        return $result->result_array();
    }
    public function catchu($value, $length) {
    $value = stripslashes($value);
    $value = preg_replace('/(\[CODE\]|\[QUOTE\]|\[HTML\]|\[\/CODE\]|\[\/HTML\]|\[\/QUOTE\])/i', '', $value);
    $value = strip_tags($value);
    if ($value != '') {

        if (is_array($value))
            list($string, $match_to) = $value;

        else {
            $string = $value;
            $match_to = $value{0};
        }



        $match_start = stristr($string, $match_to);

        $match_compute = strlen($string) - strlen($match_start);



        if (strlen($string) > $length) {

            if ($match_compute < ($length - strlen($match_to))) {

                $pre_string = substr($string, 0, $length);

                $pos_end = strrpos($pre_string, " ");

                if ($pos_end === false)
                    $string = $pre_string . "...";

                else
                    $string = substr($pre_string, 0, $pos_end) . "...";
            }

            else if ($match_compute > (strlen($string) - ($length - strlen($match_to)))) {

                $pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));

                $pos_start = strpos($pre_string, " ");

                $string = "..." . substr($pre_string, $pos_start);

                if ($pos_start === false)
                    $string = "..." . $pre_string;

                else
                    $string = "..." . substr($pre_string, $pos_start);
            }

            else {

                $pre_string = substr($string, ($match_compute - round(($length / 3))), $length);

                $pos_start = strpos($pre_string, " ");
                $pos_end = strrpos($pre_string, " ");

                $string = "..." . substr($pre_string, $pos_start, $pos_end) . "...";

                if ($pos_start === false && $pos_end === false)
                    $string = "..." . $pre_string . "...";

                else
                    $string = "..." . substr($pre_string, $pos_start, $pos_end) . "...";
            }



            $match_start = stristr($string, $match_to);

            $match_compute = strlen($string) - strlen($match_start);
        }



        return $string;
    }else {

        return $string = '';
    }
}
function search($name){
    $this->db->where('post_title',$name);
    $query=$this->db->get('posts');
    return $query->result_array();
    
}
    

}
