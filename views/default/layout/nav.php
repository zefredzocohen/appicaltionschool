<?php
$ci = &get_instance();
$ci->load->model('model_category', 'category');  

?>
<script type="text/javascript">
  $(document).ready(function(){
      $(".vbplogin").click(function(){
          $("#vibe_bp_login").toggle();
      });
    
       $("#searchicon").click(function(){
          $("#searchdiv").toggle();
      });
  });
</script>

<div id="headertop" class="fix fixed">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-3" style="color: #FFFFFF ;text-transform:lowercase ; text-decoration: none;box-sizing: border-box;font-size: 12px;font-family: Arial, Helvetica, sans-serif;
    font-weight: 400;">
                        Call Us: +84 (08) 66.837626<span> | </span>
                        <a href="mailto:info@zend.vn" style="color: #FFFFFF;text-decoration: none; box-sizing: border-box;font-family: Arial, Helvetica, sans-serif; font-size: 12px;">info@school.vn</a>
                    </div>
                    <div class="col-md-8 col-sm-9">
                    <?php 
                     $check_id =  $this->session->userdata('member_id');

                    ?>
                    <?php 
                        if(!isset($check_id) or empty($check_id)){
                          ?>
                          <ul class="topmenu">
                            <li><a href="#login" class="smallimg vbplogin"><i class="fa fa-sign-in"></i> Login</a></li>
                            <li><a href="<?php echo SITE_DIR ?>main_default/validate_register" class="vbpregister" title="Create an account"><i class="fa fa-users"></i> Sign Up</a>                             </li>
                        </ul>
                          <?php
                        }else{
                           $user_name =  $this->session->userdata('member_name');
                          ?>
                          <ul class="topmenu">
                            <li><a href="#<?php echo $user_name ?>" class="smallimg"><i class="fa fa-user"></i> <?php echo $user_name ?></a></li>
                            <li><a href="<?php echo SITE_DIR ?>main_default/validate_register" class="smallimg"><i class="fa fa-bookmark"></i> Profile</a></li>
                            <li><a href="<?php echo SITE_DIR ?>main_default/logout" class="vbpregister" title="Create an account"> <i class="fa fa-sign-out"></i> Logout</a>                             </li>
                        </ul>
                          <?php
                        }
                    ?>
                        
                        <ul id="menu-top-menu" class="topmenu"><li id="menu-item-2086" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2086"><a href="<?php echo SITE_DIR ?>142-Gioi-Thieu">Giới thiệu</a></li>
                            <li id="menu-item-2083" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2083"><a href="<?php base_url();?>/main_default/list_blog/">Tin tức</a></li>
                       </ul>                   
                   </div>
                    <div style="display: none;" id="vibe_bp_login">
                    <div class="widget vibe-bp-login">              
                
                <form name="login-form" id="vbp-login-form" class="standard-form"  >
                    <label>Username<br>
                    <input name="log" id="side-user-login" class="input" tabindex="1" type="text"></label>
                    
                    <label>Password <a data-original-title="Forgot Password" href="" tabindex="5" class="tip" title=""><i class="icon-question"></i></a><br>
                    <input tabindex="2" name="pwd" id="sidebar-user-pass" class="input" value="" type="password"></label>
                    
                    <p class=""><label><input name="rememberme" tabindex="3" id="sidebar-rememberme" value="forever" type="checkbox">Remember Me</label></p>
                        
                        <a id="sidebar-wp-submit" type="buttom" class="login-form">Log In</a>
                    <input name="testcookie" value="1" type="hidden">
                    <a href="<?php echo SITE_DIR ?>main_default/validate_register" class="vbpregister" title="Create an account" tabindex="5">Sign Up</a>                        </form>
                
                
                </div>  
                                 </div>
                </div>
            </div>
        </div>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <h2 id="logo">                        
                            <a href="<?php echo SITE_DIR ?>"><img src="<?= $ci->core->get_option("logo") ?>" alt="Đột phá  cùng ATCVN"></a>
                        </h2>                    </div>
                    <div class="col-md-9 col-sm-9">
                        
                        <nav class="menu-main-menu-container"><ul id="menu-main-menu" class="menu"><li id="main-menu-item-2286" class="menu-item menu-item-type-post_type menu-item-object-page">
                        <a href="<?php echo SITE_DIR ?>142-Gioi-Thieu"><strong>Giới thiệu</strong></a></li>
                        <?php
                            if(!empty($check_id)){
                                ?>
                                <li id="main-menu-item-2289" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="<?php echo SITE_DIR ?>main_default/readschool?list_register"><strong>Lớp Học</strong></a></li>
                                <?php
                            }else{
                              ?>
                              <li id="main-menu-item-2289" class="menu-item menu-item-type-custom menu-item-object-custom"><a href="#" onclick="return confirm('Bạn phải đăng nhập thì mới có thể vào lớp học !')"><strong>Lớp Học</strong></a></li>
                           <?php
                            }
                         ?>
                  

                  <li id="main-menu-item-2287" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo SITE_DIR ?>main_default/list_school1"><strong>Khóa học</strong></a></li>
                  <li id="main-menu-item-2284" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo SITE_DIR ?>main_default/list_blog"><strong>Tin tức</strong></a></li>
                  <li id="main-menu-item-2288" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo SITE_DIR ?>main_default/contact"><strong>Liên hệ</strong></a></li>
                  </ul>
              </nav> 
                    </div>
                    <a id="trigger">
                        <span class="lines"></span>
                    </a>
                </div>
            </div>
        </header>

        
                      <section id="content">
                          <div class="container">
                                   <script> var opcarousel978 = {
                                 "directionNav" : true,
                                 "animationLoop" : true,
                                 "slideshow" : true
                              };</script><script> var opcarousel880 = {
                                 "directionNav" : true,
                                 "animationLoop" : true,
                                 "slideshow" : true
                              };</script><script> var opcarousel471 = {
                                 "directionNav" : true,
                                 "animationLoop" : true,
                                 "slideshow" : true
                              };</script><div class="vibe_editor clearfix"></div>
                          </div>
                          </section>

          <script type="text/javascript">
              $(document).ready(function(){
                  $("#sidebar-wp-submit").click(function(){
                    var user =  $("#side-user-login").val();
                    var pass =  $("#sidebar-user-pass").val();
                    if(user.length  != 0 && pass.length != 0){
                      $.ajax({
                        url: "<?php echo SITE_DIR ?>main_default/login_user",
                        type: 'POST',
                        data: {user: user,pass:pass},
                        success: function(login){
                          if(login == "No"){
                            alert("User Or Password error !");
                          }
                           if(login == "Yes"){
                            window.location = "";
                          }
                        }
                    });
                    }else{
                      alert("Field cannot blank__ !");
                    }
                    

                  });
              });
          </script>

                       