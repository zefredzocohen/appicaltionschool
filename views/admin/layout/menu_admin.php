<?php 
$userlv = $this->session->userdata('user_level');
?>
<div class="sidebar">
    <div class="sidebar-dropdown"><a href="#">Navigation</a></div>
    <div class="sidebar-inner">

        <!--- Sidebar navigation -->
        <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
        <ul class="navi" style="margin-top: 15px;">
            <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->

            
           
           <?php 
            if($userlv == 1){
           ?> <!-- Menu with sub menu -->
          
           <li class="nred current"><a href="<?php echo SITE_DIR?>admin"><i class="fa fa-desktop"></i> Đào Tạo Trực Tuyến</a></li>
             <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Khóa học
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view?post_type=school_online">Tạo Khóa Học</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>post/manage_post/school_online">Quản lý Khóa Học</a></li>
                    
                </ul>
            </li>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Bài Giảng
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view?post_type=lesson">Tạo Bài Giảng</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>post/manage_post/lesson">Quản lý Bài Giảng </a></li>
                    
                </ul>
            </li>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Thi Trực Tuyến
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    
                    <li class="sub_menu_customize">
                    <a href="#">
                        <!-- Menu name with icon -->
                       <i class="fa fa-file-o"></i> Quản lý Câu hỏi
                        <!-- Icon for dropdown -->
                        <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                    </a>
                        <li><a href="<?php echo SITE_DIR; ?>qbank/pre_new_question">Thêm câu hỏi</a></li>
                        <li><a href="<?php echo SITE_DIR; ?>qbank/">Danh sách câu hỏi </a></li>

                </li>
                    <li><a href="<?php echo SITE_DIR; ?>quiz/add_new">Thêm đề thi</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>quiz/">Danh sách đề thi</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>result/">Kết quả</a></li>
                    
                </ul>
            </li>
            <?php 
           ?>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Tin tức
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view?post_type=blog">Tạo Tin tức</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>post/manage_post/blog">Quản lý Tin Tức  </a></li>
                    
                </ul>
            </li>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Trang
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view?post_type=page">Tạo Trang</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>post/manage_post/page">Quản Lý Trang</a></li> 
                </ul>
            </li>
            <!--<li class="has_submenu nlightblue">
                <a href="#">
                    
                   <i class="fa fa-file-o"></i> Bài Viết
                    
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view">Tạo bài viết</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>post/manage_post/all">Quản lý bài viết</a></li>
                    
                </ul>
            </li>-->
       
             <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý thành viên
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR;  ?>user/creat_user">Tạo thành viên</a></li>   
                    <li><a href="<?php echo SITE_DIR;  ?>main/manage_user">Quản lý thành viên</a></li>  
                </ul>
            </li>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i>Đăng ký trực tuyến
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>main/manage_register">Quản lý dăng ký trực tuyến</a></li>   
                </ul>
            </li>
          <!--   <li class="has_submenu nlightblue">
                <a href="#">
                    
                   <i class="fa fa-file-o"></i> Thư viện ảnh
                 
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php //echo SITE_DIR; ?>main/album">Quản lý thư viện ảnh</a></li>
                    
                </ul>
            </li> -->
             <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Cài đặt
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>
                    <li><a href="<?php echo SITE_DIR; ?>post/post_view/142?post_type=about">Trang giới thiệu</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>main/slide">Quản lý slide</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>main/link">Quản lý liên kết</a></li>
                     <li><a href="<?php echo SITE_DIR; ?>post/manage_contact">Quản Lý Liên Hệ</a></li> 
                    <li><a href="<?php echo SITE_DIR; ?>main/info_payment">Thông tin thanh toán</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>main/setting">Cài đặt chung</a></li>
                    
                </ul>
            </li>
            <?php } elseif($userlv == 4){ ?>
            <li class="has_submenu nlightblue">
                <a href="#">
                    <!-- Menu name with icon -->
                   <i class="fa fa-file-o"></i> Quản lý Thi Trực Tuyến
                    <!-- Icon for dropdown -->
                    <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                </a>
                <ul>    
                    <li><a href="<?php echo SITE_DIR; ?>quiz/">Danh sách đề thi</a></li>
                    <li><a href="<?php echo SITE_DIR; ?>result/">Kết quả</a></li>
                </ul>
            </li>
            <?php }?>
        </ul>
        <!--/ Sidebar navigation -->

        <!-- Date -->
        <div class="sidebar-widget">
            <div id="todaydate"></div>
        </div>
    </div>
</div>
<!-- Sidebar ends -->

<!-- Main bar -->
<div class="mainbar">
    <script>
        $(document).ready(function(){
            $( ".sub_menu_customize" ).toggle(
                function() {
                  $( this ).addClass( "selected" );
                }, function() {
                  $( this ).removeClass( "selected" );
                }
              );
        })
        </script>