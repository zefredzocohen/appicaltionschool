<?php

class User extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_core','Core');
    }
    public function creat_user()
    {
        $this->load->view('admin/user');
    }
    public function edit_user($id)
    {
        $data =  array(
            "info_user" => $this->Core->show_all("users","user_id",$id),
            "id_user" => $id
            );
        $this->load->view('admin/user',$data);
    }
    public function validate_user($id = "") {
        if(!empty($id)){
            $param = array(
           
            array(
                'field' => 'pass',
                'label' => 'Mật khẩu',
                'rules' => 'trim|required|matches[pass2]'
            ),
            array(
                'field' => 'pass2',
                'label' => 'Nhập lại mật khẩu',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ),
              array(
                'field' => 'work',
                'label' => 'work',
                'rules' => 'trim|required'
            )
        );
        }else{
            $param = array(
            array(
                'field' => 'name',
                'label' => 'Tên đăng nhập',
                'rules' => 'trim|required|min_length[4]|max_length[20]|is_unique[users.user_name]'
            ),
              array(
                'field' => 'name_show',
                'label' => 'Tên hiển thị',
                'rules' => 'trim|required|min_length[4]|max_length[20]|is_unique[users.name]'
            ),
            array(
                'field' => 'pass',
                'label' => 'Mật khẩu',
                'rules' => 'trim|required|matches[pass2]'
            ),
            array(
                'field' => 'pass2',
                'label' => 'Nhập lại mật khẩu',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'work',
                'label' => 'work',
                'rules' => 'trim|required'
            ),
        );
        }
        
        
        $this->form_validation->set_rules($param);
        if($this->form_validation->run() === FALSE){
            if(!empty($id)){
                 $this->edit_user($id);
            }else{
                $this->creat_user();
            }
        }else{
            $add = array(
              'user_name' => trim($this->input->post('name')),
              'name' => trim($this->input->post('name_show')),
              'user_email' => trim($this->input->post('email')),
              'user_pass' => md5($this->input->post('pass')),
              'user_avata' => $this->input->post('image'),
              'user_leve' => $this->input->post('level'),
              'user_work' =>$this->input->post('work'),
              'user_adress' =>$this->input->post('adress'),
              'user_sdt' =>$this->input->post('phone'),
              'user_status' => 1
            );
            if(!empty($id)){

                if($this->Core->update($add,'users',"user_id",$id) > 0){
                   $message_success = "Sửa thành viên <b>" . $this->input->post('name') . "</b> thành công !";
                     $this->session->set_userdata('ms_success', $message_success);
                   redirect("user/edit_user/".$id);
                }
            }else{
                if($this->Core->insert($add,'users') > 0){
                $message_success = "Tạo thành viên <b>" . $this->input->post('name') . "</b> thành công !";
                $this->session->set_userdata('ms_success', $message_success);
                redirect('user/creat_user');
                }else{
                    echo "error! F5 reset";
                }
            }
            
            
        }
    }
    
    public function delete_user($id)
    {
        $this->Core->delete('users','user_id',$id);
        redirect('main/manage_user');
    }

    // public function timeline_teacher()
    // {
    //     $id = $_Get['id'];
    //     if(isset($id)){
    //         $param = array(
    //             array(
    //                 'field' => 'name',
    //                 'label' => 'title not emtry ',
    //                 'rules' => 'trim|required'

    //                 ),
    //             array(
    //                 'field' => 'conten',
    //                 'label' => 'conten not emtry',
    //                 'rules' => 'trim|required'
    //                 ),
    //             );
    //         $this->form_validation->set_rules($param);
    //         if ($this->form_validation->run() == FALSE) {
                
              
    //         }
    //     }
    // }
    
}