<?php
class Login extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_user','user');
        
    }
    public function load_login()
    {
       $this->load->view('admin/login');
    }
    public function validation_login()
    {
       $param = array(
           array(
            'field' => 'name',
            'rules' =>'trim|required',
            'label' => 'user',
           ),
           array(
            'field' => 'pass',
            'rules' =>'trim|required',
            'label' => 'Password',
           ),     
       );
       $this->form_validation->set_rules($param);
       if($this->form_validation->run() === FALSE){
           $this->load_login();
           $this->session->set_userdata('error_login','Tài khoản hoặc mật khẩu của bạn không được để trống !');
       }else{
           $name = trim($this->input->post('name',TRUE));
           $pass = trim($this->input->post('pass',TRUE));
           $result = $this->user->login($name,$pass);
           if(count($result) > 0)
           {
            if($result['user_leve'] == 1 or $result['user_leve'] == 3){
              $session_param = array(
                   'user_id' => $result['user_id'],
                   'user_name' => $result['user_name'],
                   'user_level' => $result['user_leve'],
                   'user_avata' => $result['user_avata'],
                  'logged_in'=>array('su'=>1,'gid'=>'1','uid'=>$result['user_id']),
               );
               $this->session->set_userdata($session_param);
               redirect('main');
             }else{
               $this->session->set_userdata('error_login','Tài khoản hoặc mật khẩu không đúng !');
                 $this->load_login();
             }
               
           }else{
               $this->session->set_userdata('error_login','Tài khoản hoặc mật khẩu không đúng !');
               $this->load_login();
           }
       }
    }
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        redirect('admincp');
    }
    
}