<?php

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_category', 'Category');
        $this->load->model('model_core', 'Core');
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index() {


        $this->load->view('admin/index');
    }

    
    public function tits_manage($id = "") {
        $parram = array(
            'tits' => $this->Core->show_all('tits'),
            'tid' => $id,
        );
        $this->load->view('admin/tits_manage', $parram);
    }

    public function manage_category() {

        $parram = array(
            'dequy_category' => $this->Category->get_parent_cat(),
        );
        $this->load->view('admin/manage_category', $parram);
    }

    public function manage_register() {
        $parram = array(
            'list_register' => $this->Core->show_all('enrollment'),
        );
        $this->load->view('admin/manage_register', $parram);
    }

    public function link() {
        
         $parram = array(
            'list' => $this->Core->show_all('links'),
             'count' => count($this->Core->show_all('links'))
        );
        $this->load->view('admin/link',$parram);
    }

    public function validate_link() {
        $param = array(
            array(
                'field' => 'name',
                'label' => 'link name',
                'rules' => 'trim|required'
            ),
            array(
                'feild' => 'link',
                'label' => 'name',
                'rules' => 'trim|required'
            ),
            array(
                'feild' => 'image',
                'label' => 'image',
                'rules' => 'trim|required'
            )
        );
        
        $this->form_validation->set_rules($param);
        if($this->form_validation->run() === FALSE){
           
            $message_error = " Các trường dữ liệu không được để trống !";
            $this->session->set_userdata('ms_error', $message_error);
             redirect('main/link');
        }else{
            $add = array(
                'link_name' => trim($this->input->post('name')),
                'link' => $this->input->post('link'),
                'link_image' => $this->input->post('image'),
            );
            if($this->Core->insert($add,'links') > 0){
                $message_success = "Tạo liên kết tới <b>" . $this->input->post('name') . "</b> thành công !";
                $this->session->set_userdata('ms_success', $message_success);
                redirect('main/link');
            }else{
                echo "error! F5 reset";
            }
            
        }
    }
    public function delete_link($id)
    {
        $this->Core->delete('links','link_id',$id);
        redirect('main/link');
    }
    
    public function manage_user()
    {
        $parram = array(
            'list' => $this->Core->show_all('users'),
        );
         $this->load->view('admin/manage_user',$parram);
    }
    public function slide()
    { 
        $parram = array(
            'list' => $this->Core->show_all('slides'),
            'count' => count($this->Core->show_all('slides')),
        );
        $this->load->view('admin/manage_slide',$parram);
    }
    public function validation_slide()
    {
         $param = array(
            array(
                'field' => 'slide',
                'label' => 'Image',
                'rules' => 'trim|required'
            ),
        );
        
        $this->form_validation->set_rules($param);
        if($this->form_validation->run() === FALSE){
           
            $message_error = "Bạn phải chọn ảnh trước thi tạo !";
            $this->session->set_userdata('ms_error', $message_error);
             $this->slide();
        }else{
            $add = array(
              's_link' => trim($this->input->post('slide')),
            );
            if($this->Core->insert($add,'slides') > 0){
                $message_success = "Tạo thành công !";
                $this->session->set_userdata('ms_success', $message_success);
                redirect('main/slide');
            }else{
                echo "error! F5 reset";
            }
            
        }
    }
     public function delete_image($id)
    {
        
     $this->Core->delete('slides','s_id',$id);
        redirect('main/slide');
    }
        public function album($page = "")
    {      
       $count =  count($this->Core->show_all('gallery'));
       $perpage = 8;
        $config['base_url'] = SITE_DIR."main/album";
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']	= 5;
        $config['cur_tag_open'] = '<a class="ui-state-default ui-state-highlight ui-state-active">'; 
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
       
       
        $parram = array(
            'list' => $this->Core->select_limit('gallery',$perpage,$page,'ga_id'),
        );
        $this->load->view('admin/manage_album',$parram);
    }
    
    public function validation_album()
    {
         $param = array(
            array(
                'field' => 'image',
                'label' => 'Image',
                'rules' => 'trim|required'
            ),
        );
        
        $this->form_validation->set_rules($param);
        if($this->form_validation->run() === FALSE){
           
            $message_error = "Bạn phải chọn ảnh trước thi tạo !";
            $this->session->set_userdata('ms_error', $message_error);
             $this->album();
        }else{
            $add = array(
              'ga_link' => trim($this->input->post('image')),
            );
            if($this->Core->insert($add,'gallery') > 0){
                $message_success = "Tạo thành công !";
                $this->session->set_userdata('ms_success', $message_success);
                redirect('main/album');
            }else{
                echo "error! F5 reset";
            }
            
        }
    }
    public function delete_image_album($id)
    {
         $message_success = "Xóa thành công !";
         $this->session->set_userdata('ms_success', $message_success);
        $this->Core->delete('gallery','ga_id',$id);
        redirect('main/album');
    }
    public function set_image_index($id,$type)
    {

      $add = array(
            'ga_type' => $type
        );
        $this->Core->update($add,'gallery','ga_id',$id);
        redirect('main/album');
        
    }
    public function info_payment(){
        $this->load->view("admin/info_payment");
    }
    public function setting(){
        $this->load->view("admin/setting");
    }


}
