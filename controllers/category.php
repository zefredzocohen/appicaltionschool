<?php
class Category extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_category','Category');
        $this->load->model('model_core','Core');
    }
   
    public function category_index($cat_id = "")
    {
        $cid = $cat_id;
        $parram = array(
          'category' => $this->Category->show_cat_parent(), 
           'cid' => $cid,
          'edit_category' => $this->Core->show_all('category','cat_id',$cid),
          'cat_order' => $this->Core->show_all('category','cat_type',0,1,'cat_order'),
           'cat_order_all' => $this->Core->show_order('category','cat_type',0,'cat_order'),
          'dequy_category' => $this->Category->get_parent_cat(),
        );
        $this->load->view('admin/category',$parram);
    }
    public function validation_category($cat_id = "") {
         $cid = $cat_id;
        $category = array(
            array(
                "field" => "name",
                "label" => "Menu Category Name",
                "rules" => "trim|required"
            ),
            array(
                'field' => 'cat_type',
            ),
            array(
                'field' => 'cat_status',
            ),
            array(
                'field' => 'cat_order',
            )
        );
        $this->form_validation->set_rules($category);

        if ($this->form_validation->run() === FALSE) {
            if(!empty($cid)){
                $this->category_index($cid);
            }else{
                $this->category_index();
            }
            $message_error = " Các trường dữ liệu không được để trống !";
            $this->session->set_userdata('ms_error', $message_error);
            
        } else {
            if(!empty($cid)){
                $add = array(
                'cat_name' => trim($this->input->post('name', TRUE)),
                'cat_type' => $this->input->post('cat_type', TRUE),
                'cat_status' => $this->input->post('cat_status', TRUE),
                'cat_link' => $this->input->post('link'),
                 'cat_order' => $this->input->post('cat_order')
            );
            }else{
              $add = array(
                'cat_name' => trim($this->input->post('name', TRUE)),
                'cat_type' => $this->input->post('cat_type', TRUE),
                'cat_status' => $this->input->post('cat_status', TRUE),
                'cat_link' => null,
                'cat_order' => $this->input->post('cat_order')
            );
            }
  
            if(!empty($cid)){
                if ($this->Category->update_cat($add, $cat_id) <= 0) {
                $this->Category->edit_category($add, $cat_id);
               $message_error = "Sảy ra lỗi khi tạo. F5 để thử lại!";
                $this->session->set_userdata('ms_error', $message_error);
                redirect("category/category_index/".$cid);
                }else {
                    $message_success = "Sửa Thành Công !";
                    $this->session->set_userdata('ms_success', $message_success);
                     redirect("category/category_index/".$cid);
                }
            }else{
            if ($this->Category->add_category($add) <= 0) {
                $this->session->set_userdata('ms_error', $message_error);
                $message_error = "Sảy ra lỗi khi tạo. F5 để thử lại!";
            } else {
                $message_success = "Tạo danh mục <b>" . $this->input->post('name') . "</b> thành công !";

                $this->session->set_userdata('ms_success', $message_success);

                redirect("category/category_index");
            }
            }
        }
    }
    
    public function delete_category($id)
    {
        
     $this->Category->delete_category($id);
         $message_success = "Đã xóa thành công !";
         $this->session->set_userdata('ms_success', $message_success);
        redirect('admin/manage_category');
    }
    public function update_tit($id)
    {
         $param = array(
            array(
                "field" => "tit",
                "label" => "Tit Name Not found",
                "rules" => "trim|required"
            ),
        );
       
         $this->form_validation->set_rules($param);
         if($this->form_validation->run() === FALSE){
             redirect("main/tits_manage/".$id);
         }else{
             $add = array(
               'tit_name' => trim($this->input->post('tit',TRUE)), 
             );
             if($this->Core->update($add,'tits','tit_id',$id) <=0 ){
                  $message_success = "Sửa Thành Công !";
                   $this->session->set_userdata('ms_success', $message_success);
                  redirect("main/tits_manage/".$id);
             }else{
                 $message_success = "Sửa Thành Công !";
                   $this->session->set_userdata('ms_success', $message_success);
                  redirect("main/tits_manage/".$id);
             }
         }
    }
}