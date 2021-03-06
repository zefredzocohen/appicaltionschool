<?php
Class Register extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->model('model_core','Core');
         require 'mail/PHPMailerAutoload.php';
    }
    public function index(){

    }
    public function register_online()
    {
	
        $param = array(
            array(
                'field' => "name",
                'label' => "Post name",
                'rules' => "trim|required"
            ),
            array(
                'field' => 'address',
                'label' => 'Post address',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'email',
                'label' => 'Post email',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'phone',
                'label' => 'Post phone',
                'rules' => 'trim|required'
            ),
             array(
                'field' => 'pay',
                'label' => 'Post payment',
                'rules' => 'trim|required'
            ),
            
        );

        $this->form_validation->set_rules($param);

        if ($this->form_validation->run() === false) {
             $message_error = "Bạn phải điền đầy đủ thông tin để có thể đăng ký !";
            $this->session->set_userdata('ms_error', $message_error);
            $site_dir = SITE_DIR.'main_default/readschool?post_id='.$_GET['post_id'];
            redirect($site_dir); 
               
        } else {
           $check_register = $this->Core->_select_and_where("enrollment",array("en_name"=>$this->input->post('name', true),"post_id"=>$_GET['post_id']));
           if(empty($check_register)){
            $add = array(
                'en_name' => trim($this->input->post('name', true)),
                'en_address' => trim($this->input->post('address', true)),
                'en_email' => trim($this->input->post('email',TRUE)),
                'en_phone' => trim($this->input->post('phone', true)),
                'en_pay_type' => $_POST['pay'],
                'post_id' => $_GET['post_id'],
                'en_status' => 0,
                'en_date' => date("Y-m-d")
            );
            $mail = new PHPMailer();
            $mail->isSMTP();


            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;

            $mail->Username = "phongtuyensinhso2@gmail.com";
            //Password cua email
            $mail->Password = "hoangngoclinh";
            /*Het phan cau hinh*/

            /*Cau hinh header*/
            //Nguoi gui
            $mail->setFrom('phongtuyensinhso2@gmail.com', 'GDV');
            //Nguoi nhan
            $mail->addAddress('phongtuyensinhso2@gmail.com', 'GDV');

            /*End noi dung can chinh sua*/

            /*Noi dung email*/
            //Tieu de
            $mail->Subject = 'Noi Dung Mail Dang Ky Hoc Cua Thanh Vien';

            //Noi dung
            $mail->Body    = "Họ và tên:".$this->input->post('name')." |  "
                             ."Địa chỉ:".$this->input->post('address')." | "
                              ."Email:".$this->input->post('email')." | "
                               ."Điện thoại:".$this->input->post('phone')." | "
                               ."Thuộc đối tượng :".$this->input->post('object')." | "
                                 ."Đăng ký hệ:".$this->input->post('system')." | ";

            //Gui mail va tra ve thong bao
            if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                    echo "Message sent!";
            }

                if ($this->Core->insert($add,"enrollment") <= 0) {
                    $message_error = "Tạo bài viết lỗi. F5 để thử lại !";
                    $this->session->set_userdata('ms_error', $message_error);
                } else {
                    $message_success = "Bạn đã đăng ký thành công. bạn có thể thực hiện khóa học ngay đăng ký được kiểm duyệt!";
                    $this->session->set_userdata('ms_success_product', $message_success);
                    $site_dir = SITE_DIR.'main_default/readschool?post_id='.$_GET['post_id'];
                    redirect($site_dir);
                }
            }else{
                 $message_error = "Bạn đã đăng ký khóa học này rồi!";
                 $this->session->set_userdata('ms_error', $message_error);
                $site_dir = SITE_DIR.'main_default/readschool?post_id='.$_GET['post_id'];
                redirect($site_dir);
            }
        }
    }
    public function delete_user($id)
    {
        $this->Core->delete('enrollment','en_id',$id);
        $message_success = "Đã xóa thành công !";
         $this->session->set_userdata('ms_success', $message_success);
        redirect('main/manage_register');
    }
    public function check_shool($rg_id,$name){
        $check = $this->Core->_select_and_where("enrollment",array("en_id"=>$rg_id,"en_name"=>$name));

       if($check[0]['en_status']  == 0){
            $this->Core->update(array("en_status"=>1),"enrollment","en_id", $rg_id);
       }
       if($check[0]['en_status']  == 1){
            $this->Core->update(array("en_status"=>0),"enrollment","en_id", $rg_id);
       }
       redirect("main/manage_register");

    }
}