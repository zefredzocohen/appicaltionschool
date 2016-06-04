<?php
Class model_post extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
   public function add_post($value = array())
	{
		$this->db->insert('posts', $value);
		return $this->db->insert_id();
	
	}
	 public function add_post_meta($value = array())
	{
		$this->db->insert('post_meta', $value);
		return $this->db->insert_id();
	
	}
        public function add_category($value = array()){
                $this->db->insert('category', $value);
		return $this->db->insert_id();
        }
        public function manage_post($perpage,$offset)
	{
		$this->db->select("*")->from('posts')->limit($perpage, $offset);
		$result = $this->db->get();
		return $result->result_array();
	}


	public function get_post($perpage,$offset,$type)
	{
		$this->db->select("*")
                        ->from('posts')
                        ->where('post_type',$type)
                        //->where('author',$ses)
                        ->limit($perpage, $offset);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function get_new_id()
	{
		$this->db->select("*")->from('posts')->order_by("post_id", "DESC")->limit(1);
		$result = $this->db->get();
		return $result->result_array();
	}
	public function view_set_id_post($p_id)
	{
		$this->db->select("*")
			->from('posts')
			->where('post_id',$p_id);
			$result = $this->db->get();
			return $result->result_array();
	}
	public function update_post($value = array(), $id)
	{
		$this->db->update('posts',$value, array('post_id'=>$id));
		return $this->db->affected_rows();
	}
	public function update_post_meta($value = array(), $id,$meta)
	{
		$this->db->update('post_meta',$value, array('post_id'=>$id,"meta_name"=>$meta));
		return $this->db->affected_rows();
	}
        public function update_category($value = array(), $id)
	{
		$this->db->update('category',$value, array('cat_id'=>$id));
		return $this->db->affected_rows();
	}
}