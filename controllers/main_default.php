<?php
Class Main_default extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('model_category','Category');
        $this->load->model('model_core','Core');
        $this->load->library('pagination');
        $this->load->library('form_validation');
         $this->load->model('model_user','user');
    }
    public function index()
    {
       $parram = array(
          'tits' => $this->Core->show_all('tits'),
        );
        $this->load->view('default/layout/header');
        $this->load->view('default/index',$parram);
    }
    public function archive($id)
    {
        $post_single = array(
            'post_info' => $this->Core->show_all('posts','post_id',$id),
             'list' => $this->Core->show_all('links'),
             'price'=> $this->Core->show_all('post_meta','post_id',$id),
        );

        $this->load->view('default/archive',$post_single);
    }
     public function register_user()
    {
        $this->load->view('default/register_user');
    }
    public function about(){

    }
    public function page($id,$page,$_page = "")
    {
         $perpage = 5;
        $count = count($this->Core->show_all('posts','cat_id',$id));
        $config['base_url'] = SITE_DIR.$id."/".$page;
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = "<span class='current_page_item'>";
        $config['cur_tag_close'] = "</span>";
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']	= 5;
       $this->pagination->initialize($config);
        
        
         $param = array(
            'post_info' => $this->Core->select_limit_id('posts','cat_id',$id,$perpage,$_page,'post_id'),
             'page' => $_page,
             'pagination' => $pagination = $this->pagination->create_links(),
             'list' => $this->Core->show_all('links'),
        );
        $this->load->view('default/layout/header');
        $this->load->view('default/page',$param);
    }
    public function contact()
    {

        $this->load->view('default/contact');
    }
    public function register()
    {

        $this->load->view('default/layout/header');
        $this->load->view('default/register');
    }
    public function list_school($page = ""){
        $count =  count($this->Core->show_all('posts',"post_type","school_online"));
        $perpage = 6;
        $config['base_url'] = SITE_DIR."main_default/list_school";
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']  = 5;
        $config['cur_tag_open'] = '<a class="ui-state-default ui-state-highlight ui-state-active">'; 
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if($page == ""){
          $_page = 0;
        }else{
          $_page = $page;
        }
        
        $data = array(
            "list_school" =>$this->Core->query("select * from posts where post_type = 'school_online'  order by post_id DESC limit  $_page,$perpage"),
            );
         $this->load->view('default/list_khoahoc',$data);
    }
    public function list_school1($page = ""){
        $count =  count($this->Core->show_all('posts',"post_type","school_online"));
        $perpage = 6;
        $config['base_url'] = SITE_DIR."main_default/list_school";
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']  = 5;
        $config['cur_tag_open'] = '<a class="ui-state-default ui-state-highlight ui-state-active">'; 
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if($page == ""){
          $_page = 0;
        }else{
          $_page = $page;
        }
        $search=$this->input->post('s');
        $data = array(
            "list_school" =>$this->Core->query("select * from posts where post_type = 'school_online' and post_title like'%$search%' order by post_id DESC limit  $_page,$perpage"),
            );
         $this->load->view('default/list_khoahoc',$data);
    }
    public function list_blog(){
        $data = array(
            "list_blog" =>$this->Core->show_all('posts',"post_type","blog"),
            );
         $this->load->view('default/blog',$data);
    }
    public function album($page = "")
    {
        $count =  count($this->Core->show_all('gallery'));
        $perpage = 6;
        $config['base_url'] = SITE_DIR."main_default/album";
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = "<span class='current_page_item'>";
        $config['cur_tag_close'] = "</span>";
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']	= 5;
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
       
       
        $parram = array(
            'list' => $this->Core->select_limit('gallery',$perpage,$page,'ga_id'),
        );
        $this->load->view('default/layout/header');
        $this->load->view('default/album',$parram);
    }
    public function validate_register(){
        $info_user = $this->session->userdata('member_id');
        $param = array(
           array(
            'field' => 'signup_username',
            'rules' =>'trim|required',
            'label' => 'Signup Username',
           ),
           array(
            'field' => 'signup_email',
            'rules' =>'trim|required',
            'label' => 'Signup Email',
           ), 
            array(
            'field' => 'signup_password',
            'rules' =>'trim|required',
            'label' => 'Signup Password',
           ), 
            array(
            'field' => 'cf_pass',
            'rules' =>'trim|required',
            'label' => 'Confirm Password',
           ),    
           //  array(
           //  'field' => 'field_1',
           //  'rules' =>'trim|required',
           //  'label' => 'Name',
           // ), 
       );
        $this->form_validation->set_rules($param);
         if($this->form_validation->run() === FALSE){
            $this->register_user();
         }else{

            if($_POST['signup_password'] == $_POST['cf_pass']){
                if(!empty($info_user)){
                    $add = array(
                      'user_name' => trim($this->input->post('signup_username')),
                      'user_email' => trim($this->input->post('signup_email')),
                      'user_pass' => md5($this->input->post('signup_password')),
                      'user_avata' => SITE_DIR."theme/admin/img/noimages.jpg",
                      'user_leve' => 4,
                      'user_status' => 1
                    );
                      $this->Core->update($add,"users","user_id",$info_user);
                        $this->session->set_userdata('ms_success', "Update Profile User Success !");
                        $this->register_user();
                }else{
                    $check_register = $this->Core->show_all('users', 'user_name', $_POST['signup_username']);
                if(empty($check_register)){
                      $add = array(
                      'user_name' => trim($this->input->post('signup_username')),
                      'user_email' => trim($this->input->post('signup_email')),
                      'user_pass' => md5($this->input->post('signup_password')),
                      'user_avata' => SITE_DIR."theme/admin/img/noimages.jpg",
                      'user_leve' => 4,
                      'user_status' => 1
                    );
                    if($this->Core->insert($add,'users') > 0){
                        $this->session->set_userdata('ms_success', "Create User ".$this->input->post('signup_username')." Success !");
                        $this->register_user();
                    }
                 }else{
                     $this->session->set_userdata('cf_pass', "User Not Register !");
                      $this->register_user();
                  } 
                }   

            }else{
                 $this->session->set_userdata('cf_pass', "ConFirm Password Error !");
                   $this->register_user();
            }
         }
    }
    public function readschool(){
        if(isset($_GET['sc_id']))$data['post_id'] = $this->input->get('sc_id');
        $this->load->view("default/readschool",  isset($data)?$data:null);
    }
    public function login_user(){
    
        $result = $this->user->login($_POST['user'],$_POST['pass']);
        if(!empty($result)){
                 $session_param = array(
                   'member_id' => $result['user_id'],
                   'member_name' => $result['user_name'],
                   'user_level' => $result['user_leve'],
                   'user_avata' => $result['user_avata'],
               );
               $this->session->set_userdata($session_param);
             echo "Yes";
        }else{
            echo "No";
        }
    }
    public function logout(){
        $this->session->unset_userdata('member_id');
        $this->session->unset_userdata('member_name');
        redirect('main_default'); 
    }

    public function cmt_post(){
        $user = $this->session->userdata('member_name');
        $user_id = $this->session->userdata('member_id');
            $add = array(
              'cmt_value' => trim($this->input->post('cmt_post')),
              'cmt_date' => date("Y-m-d"),
              'user_name' => $user,
              'user_id' => $user_id,
              'post_id' => $_GET['post_id'],
            );
           $this->Core->insert($add,'commnet');
        redirect('main_default/readschool?school=read&sc_id='.$_GET['post_id']); 

    }
    public function add_contact(){

      $this->Core->insert(array(
        "post_title"=> $_POST['name'],
        "post_desc"=> $_POST['email'],
        "post_content"=> $_POST['ms'],
        "post_type"=> "contact"
        ),"posts");
    }

      public function info_teacher($user_id){
      

           if( isset($_SERVER['REQUEST_METHOD']) == "POST"){
            if(isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['content']) && $_POST['content'] != ""){
              $add = array(
                'time_user_id' => $user_id,
                'time_title' => $_POST['name'],
                'time_conten' => $_POST['content']
              );
            
             $inser_teacher_stt = $this->Core->insert($add,'timeline_teacher');
             redirect("main_default/info_teacher/".$user_id);
             
            }
             
           }


          $data = array(
            "info_teacher" => $this->Core->get_info_user($user_id),
            'user_id' => $user_id,
            "list_hoc" => $this->Core->show_list_order("posts","post_type","school_online","author",$user_id,"post_id") 
            );
        
           $this->load->view('default/info_teacher',$data);

         }
    
    
}