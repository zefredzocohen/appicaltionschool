<?php

class Post extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_category', 'Category');
        $this->load->model('model_post', 'Post');
        $this->load->model('model_core', 'Core');
        $this->load->library('pagination');
    }

    public function post_view($p_id = "") {
        $parram = array(
            'dequy_category' => $this->Category->get_parent_cat(),
            'pid' => $p_id,
            'new_id_post' => $this->Post->get_new_id(),
            'teacher' => $this->Core->show_all("users","user_leve",3),
            'view_set_id_post' => $this->Post->view_set_id_post($p_id),
            'tits' => $this->Core->show_all("tits"),
        );
        $this->load->view('admin/post', $parram);
    }

    public function add_post($p_id = "") {
//        var_dump($p_id);die;
        $pid = $p_id;
        $product = array(
            array(
                'field' => "title",
                'label' => "Post name",
                'rules' => "trim|required"
            ),
    
        );

        if(isset($_GET['post_type'])){
            $post_type = $_GET['post_type'];

        }else{
            $post_type = "all";
        }
        $this->form_validation->set_rules($product);

        if ($this->form_validation->run() === false) {
            if (!empty($pid)) {
                $this->post_view($pid);
            } else {
                $this->post_view();
            }
        } else {
            if($_GET["post_type"] == "lesson"){
                $lesson = $this->input->post('lesson', true);
            }else{
                $lesson = "";
            }
            $add_category=array(
                'category_name'=>trim($this->input->post('title', true)),
            );
            $add = array(
                'post_title' => trim($this->input->post('title', true)),
                'post_desc' => trim($this->input->post('desc', true)),
                'post_content' => $this->input->post('content'),
                'cat_id' => trim($this->input->post('category', true)),
                'post_image' => trim($this->input->post('image', true)),
                'post_status' =>1,
                'tit_id' => trim($this->input->post('tit', true)),
                'post_type' => $post_type,
                'author' => $this->session->userdata('user_id'),
                'post_parrent' => $lesson
            );
        

            if($post_type == "school_online"){
                if(!empty($p_id)){
                    $new_id = $p_id;
                }else{
                    $new_id = trim($this->input->post('new_id_for_meta', true));
                }
                $add_teacher = array(
                    'post_id' => $new_id,
                    'meta_name' => "_teacher",
                    'meta_value' => $this->input->post('teacher'),
                );
                $add_price = array(
                    'post_id' => $new_id,
                    'meta_name' => "_price",
                    'meta_value' => $this->input->post('price'),
                );
  
                $add_time = array(
                    'post_id' => $new_id,
                    'meta_name' => "_time",
                    'meta_value' => $this->input->post('time'),
                );
            }

            if (!empty($pid)) {
                if ($this->Post->update_post($add_category, $pid) > 0) {
                if ($this->Post->update_post($add, $pid) > 0) {
                    $message_success = "Sửa bài viết thành công !";
                    $this->session->set_userdata('ms_success_product', $message_success);  
                    if($post_type == "school_online"){
                        $this->Post->update_post_meta($add_teacher,$p_id,"_teacher");
                        $this->Post->update_post_meta($add_price,$p_id,"_price");
                
                        $this->Post->update_post_meta($add_time,$p_id,"_time");
                        redirect('post/post_view/' . $pid.'?post_type=school_online'); 
                      }else
                      if($post_type == "page"){
                         redirect('post/post_view/' . $pid.'?post_type=page'); 
                      }else{
                          redirect('post/post_view/' . $pid.'?post_type='.$post_type); 
                      }
                       
                } else {
                    $message_success = "Sửa bài viết thành công !";
                    $this->session->set_userdata('ms_success_product', $message_success);
                    if($post_type == "school_online"){
                        $this->Post->update_post_meta($add_teacher,$p_id,"_teacher");
                        $this->Post->update_post_meta($add_price,$p_id,"_price");
       
                        $this->Post->update_post_meta($add_time,$p_id,"_time");
                        redirect('post/post_view/' . $pid.'?post_type=school_online'); 
                      }else
                    if($post_type == "page"){
                         redirect('post/post_view/' . $pid.'?post_type=page'); 
                      }else{
                         redirect('post/post_view/' . $pid.'?post_type='.$post_type); 
                      }
                  
                }
                }
                
            } else {
                if($post_type == "school_online"){
                        $this->Post->add_post_meta($add_teacher);
                        $this->Post->add_post_meta($add_price);
                 
                        $this->Post->add_post_meta($add_time);
                      }
                      $cat_id = $this->Post->add_category($add_category);
                if($cat_id>0){
                    $add['cat_id'] = $cat_id;
                    if ($this->Post->add_post($add) <= 0) {

                        $message_error = "Tạo bài viết lỗi. F5 để thử lại !";
                        $this->session->set_userdata('ms_error', $message_error);
                    } 
                    else {
                        $message_success = "Tạo bài viết thành công !";
                        $this->session->set_userdata('ms_success_product', $message_success);
                        redirect("post/post_view?post_type=$post_type");
                    }
                }
            }
        }
    }

    public function manage_post( $post_type = "",$page = "") {
        $ses = $this->session->userdata('user_id');
        if($post_type == "all" or $post_type == ""){
             $count =  count($this->Core->show_all('posts'));
         }else{
              $count =  count($this->Core->show_all('posts',"post_type",$post_type));
         }
       
        $perpage = 10;
        $config['base_url'] = SITE_DIR."post/manage_post/$post_type";
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

        if(isset($post_type) && $post_type != "all"){
            $post_type = $post_type;
            $list_post = $this->Post->get_post($perpage,$page,$post_type,$ses);
        }else{
            $post_type = "";
            $list_post =  $this->Post->manage_post($perpage,$page);
        }

        $post = array(
            "post_type"=>$post_type,
            "post" => $list_post,
            "category" => $this->Core->show_all("category"),
             "tits" => $this->Core->show_all("tits"),
        );
        $this->load->view('admin/manage_post', $post);
    }
    public function manage_contact( $post_type = "contact",$page = "") {
        if($post_type == "all" or $post_type == ""){
             $count =  count($this->Core->show_all('posts'));
         }else{
              $count =  count($this->Core->show_all('posts',"post_type",$post_type));
         }
       
        $perpage = 10;
        $config['base_url'] = SITE_DIR."post/manage_post/$post_type";
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage; 
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['next_link'] = 'Next »';
        $config['prev_link'] = '« Prev';
        $config['num_links']    = 5;
        $config['cur_tag_open'] = '<a class="ui-state-default ui-state-highlight ui-state-active">'; 
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();

        if(isset($post_type) && $post_type != "all"){
            $post_type = $post_type;
            $list_post = $this->Post->get_post($perpage,$page,$post_type);
        }else{
            $post_type = "";
            $list_post =  $this->Post->manage_post($perpage,$page);
        }

        $post = array(
            "post_type"=>$post_type,
            "post" => $list_post,
            "category" => $this->Core->show_all("category"),
             "tits" => $this->Core->show_all("tits"),
        );
        $this->load->view('admin/manage_contact', $post);
    }
    public function delete_post($post_type,$id)
    {
        $this->Core->delete('posts','post_id',$id);
         $message_success = "Đã xóa thành công !";
         $this->session->set_userdata('ms_success', $message_success);
        redirect('post/manage_post/'.$post_type);
    }

}
