<?php 
$ci = &get_instance();
$ci->load->model('model_core', 'core');
?>
<!DOCTYPE html>
<html id="ls-global" class="js csstransitions" lang="en-US">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<script src="<?php echo SITE_DEFAULT ?>js/jquery-1.11.0.min.js"></script>
<title>
<?php echo $ci->core->get_option("title") ?></title>
</head>
<style type="text/css">
	
	.error {
    background: none repeat scroll 0 0 #f9edbe;
    border: 1px solid #f0c36d;
    border-radius: 2px;
    display: inline-block;
    font-size: 11px;
    font-weight: 600;
    margin: 5px 0;
    padding: 8px 20px;
    text-transform: uppercase;
    width: 93%;
}
div.success {
    background: none repeat scroll 0 0 #70c989;
    color: #fff;
    display: inline-block;
    font-weight: 600;
    padding: 10px;
    text-align: center;
    width: 96.5%;
}
.jdmath-connect.btn-school {
    background: none repeat scroll 0 0 #00aeef;
    border: medium none;
    color: white;
}
</style>
<?php


$ms_error = $this->session->userdata('ms_error');
$ms_success_product = $this->session->userdata('ms_success_product');
$this->load->helper('form');

?>

<link rel="stylesheet" id="theme-css-css" href="<?php echo SITE_DEFAULT ?>css/font-awesome.css" type="text/css" media="all">
<link rel="stylesheet" id="theme-css-css" href="<?php echo SITE_DEFAULT ?>css/styles_school.css" type="text/css" media="all">
<div id="wrapper">
                                     <header id="header-bar">
                                     <?php if(!isset($_GET['school'])):?>
                       <h1 id="page-title">Lớp học online trực tiếp</h1>
                   <?php endif; ?>
       <div class="clr"></div>
        </header>
        <div id="global-promo">
    <p class="content">
        <span>Hệ thống đào tạo lập trình online trực tuyến hàng đầu việt nam</span>
    </p>
</div>

        
        <div id="main-sidebar">
<!--               <a href="<?php //echo SITE_DIR ?>" class="logo" id="jdmath-toolbar-a-logo" title="">
       <img alt="" style=" max-height: 50px;" src="<?php //$ci->core->get_option("logo") ?>"> 
    </a>  -->
    <nav style="display: block;" class="main default">
        <a href="" class="dashboard tab">
            <span style="background-image: url('<?php echo $this->session->userdata('user_avata') ?>');" class="profile-picture"></span>
            <?php 
            $user = $this->session->userdata('member_name');
            if(empty($user)){
            	$link = SITE_DIR;
            	header("location: $link");
            }
            	

            	echo $user;
            ?>
        </a>
        <a href="<?php echo SITE_DIR ?>main_default/readschool?list_register" class="tutoring tab">
            <span>
                <i class="fa fa-user"></i>
            </span>
            Đã đăng ký
        </a>
        <?php if(isset($post_id)){ ?>
        <a href="<?php echo base_url();?>site/login/load_login?post_id=<?php echo $post_id?>">Test online</a>
        <?php } ?>
        </nav>
    
          <div class="clr"></div>   
        </div>

        <?php 
        if(isset($_GET['list_register'])): 
        	$user = $this->session->userdata('member_name');
        	$check_schol = $ci->core->show_all("enrollment","en_name",$user);
        ?>
        	<?php 
        		foreach ($check_schol as $item_sc):  
        		$show_post = $ci->core->show_all("posts","post_id",$item_sc['post_id']);

        		$get_meta_teacher = $ci->core->get_post_meta($item_sc['post_id'],"_teacher");
        		$author = $ci->core->show_all("users","user_id",$get_meta_teacher[0]["meta_value"]);
                if(!empty($show_post)):
        	?>
        		<div id="classes-container" class="classes-container-seminar">
                <div id="classes-pitch-container" style="display: block;">
                <img src="<?= $show_post[0]['post_image'] ?>" >
                <div class="right" style="width: 53%;">
                    <h2><?= $show_post[0]['post_title'] ?></h2>
                    <p>
                       <i>*</i> <b>Chủ đề : </b> <?= $show_post[0]['post_desc'] ?> …</p>
                    <p>
                    <p>
                         <i class="fa fa-user"></i> <b> Nội dung</b> - <?php echo  $author[0]["user_name"] ?>   </p>
                                        <div class="action">
                                        <span id="jdmath-load-hangouts">
                                         </span>
                                
                    
                    <?php
                     if($item_sc['en_status'] == 0){
                     		echo '<div class="error tab_tt">Khóa học này của bạn chưa được duyệt. ( Có thể do bạn chưa thanh toán hoặc đợi một chút để quản lý kiểm duyệt cho bạn !)</div>';
                    	}else{
                    		echo '<a href="'.SITE_DIR.'main_default/readschool?school=list&sc_id='.$show_post[0]['post_id'].'" style="background:#006cf4;" class="main-button-red  login"><i class="fa fa-mail-forward"></i> Bắt đầu vào học</a>';
                    	}
                    ?>
                     
                    </div>
                                     </div>
                <div class="clr"></div>
                </div>
            </div>
        <?php endif ?>
        <?php endforeach; ?>
        <?php endif; ?>




        <?php if(isset($_GET['school']) && $_GET['school'] == "list"):
        	$user = $this->session->userdata('member_name');
        	$check_schol = $ci->core->show_all("posts","post_parrent",$_GET['sc_id']);
        ?>
        	<?php 
        		foreach ($check_schol as $item_sc):  
        		$show_post = $ci->core->show_all("posts","post_id",$item_sc['post_id']);
        		
        	?>
        		<div id="classes-container" class="classes-container-seminar">
                <div id="classes-pitch-container" style="display: block;">
                <img width="200" height="190" class=""  src="<?= $show_post[0]['post_image'] ?>" >
                <div class="right" style="width: 53%;">
                    <h2><?= $show_post[0]['post_title'] ?></h2>
                    <p>
                       <i>*</i> <b>Chủ đề : </b> <?= $show_post[0]['post_desc'] ?> …</p>
                    <p>
                    
                     <div class="action">
                           <span id="jdmath-load-hangouts"></span>
                           <a href="<?php echo SITE_DIR ?>main_default/readschool?school=read&sc_id=<?= $show_post[0]['post_id'] ?>" style="background:#006cf4;" class="main-button-red  login"><i class="fa fa-mail-forward"></i> Xem</a>
                              
                    </div>
                                     </div>
                <div class="clr"></div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
       
<style type="text/css">
	
	textarea {
   border: 2px solid #d4d0ba;
    color: #141412;
    font-family: inherit;
    font-size: 100%;
    margin: 0;
    padding: 5px;
    width: 100%;
}
.submit{
	-moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: linear-gradient(to bottom, #e05d22 0%, #d94412 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-color: -moz-use-text-color -moz-use-text-color #b93207;
    border-image: none;
    border-radius: 2px;
    border-style: none none solid;
    border-width: medium medium 3px;
    color: #fff;
    display: inline-block;
    padding: 11px 24px 10px;
    text-decoration: none;
}
#classes-pitch-container img.thumb{
width: 50px;
}
.item-cmt {
    clear: both;
    display: inline-block;
    float: left;
    width: 100%;
    padding-top: 10px;
}
.list-cmt {
    display: inline-block;
    width: 100%;
}
.title {
    font-weight: bold;
}
.avt-cmt {
    display: inline-block;
    float: left;
}
.ct-cmt {
    display: inline-block;
     padding-left: 10px;
}

.item-cmt.sub-comment {
    margin-left: 65px;
}

</style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=255578621301919";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        <?php if(isset($_GET['school']) && $_GET['school'] == "read"):
       	 $show_lesson = $ci->core->show_all("posts","post_id",$_GET['sc_id']);


         ?>
          <div id="classes-container" class="classes-container-seminar">
        	 <div id="classes-pitch-container" style="display: block;">
        	 		<center><h1><strong>Lesson: </strong><?php if(!empty($show_lesson)) echo $show_lesson[0]['post_title'] ?></h1></center> 
        	 		 <div class="content">
        	 			 <?php if(!empty($show_lesson)) echo $show_lesson[0]['post_content'] ?>
        	 		 </div>
        	 		 <br/> <br/> <br/> <br/>
        	 		 <div class="comment">
        	 		 	<!-- <form action="<?php echo SITE_DIR ?>main_default/cmt_post?post_id=<?php echo $_GET['sc_id'] ?>" method="post">
        	 		 		<textarea name="cmt_post"></textarea>
        	 		 		<input class="submit" type="submit" value="Comment" name="submit">
        	 		 	</form> -->
        	 		 	<div class="list-cmt">
                        <div class="fb-comments" data-href="<?php echo SITE_DIR ?>/main_default/readschool?school=read&sc_id=<?php echo $_GET['sc_id'] ?>" data-numposts="5" data-width="1000" data-colorscheme="light"></div>
        	 		 	<?php 
        	 		 		$comment = $ci->core->show_all("commnet","post_id",$_GET['sc_id'],50,"cmt_id");
        	 		 		foreach ($comment as $item_cmt) :
        	 		 			$author = $ci->core->show_all("users","user_id",$item_cmt['user_id']);
        	 		 	 ?>
        	 		 		<!-- <div class="item-cmt">
        	 		 			<div class="avt-cmt"><img class="thumb" src="<?php echo $author[0]['user_avata'] ?>"></div>
        	 		 			<div class="ct-cmt">
        	 		 		         <p><label class="title"><?php echo $item_cmt['user_name'] ?></label></p>
        	 		 			<?php echo $item_cmt['cmt_value'] ?>
                                  <p><a href="">Trả lời</a></p>
        	 		 		</div> -->
                            <!-- <div class="item-cmt sub-comment">
                                <div class="avt-cmt"><img src="/project_svnteam/uploads/images/bootstrap-docs-readme.png" class="thumb"></div>
                                <div class="ct-cmt">
                                     <p><label class="title">trungha</label></p>
                                khóa học này quá hay ý                          
                                </div>
                            </div> -->
        	 		 		</div>
        	 		 	<?php endforeach; ?>
        	 		 	</div>


        	 		 </div>
        	 		
        	 </div>

        </div>
         
        
        <?php endif; ?>

        <?php 
        if(isset($_GET['post_id'])): 
        	$data = $ci->core->show_all("posts","post_id",$_GET['post_id']);
       		 $pid = $data[0]['post_id'];
        	$get_meta_teacher = $ci->core->get_post_meta($pid,"_teacher");
            $get_meta_price = $ci->core->get_post_meta($pid,"_price");
            $get_meta_groupsize = $ci->core->get_post_meta($pid,"_groupsize");
            $get_meta_time= $ci->core->get_post_meta($pid,"_time");

            $author = $ci->core->show_all("users","user_id",$get_meta_teacher[0]["meta_value"]);
        ?>  
        <div id="app">                   
               <div class="classes-container-seminar" id="classes-container">
                <div style="display: block;" id="classes-pitch-container">
                <img alt="<?php echo $data[0]['post_title'] ?>" src="<?php echo $data[0]['post_image'] ?>">
                <div style="width: 53%;" class="right">
                    <h2><?php echo $data[0]['post_title'] ?></h2>
                    <p>
                       <i>*</i> <b>Chủ đề : </b> <?php echo $data[0]['post_desc'] ?></p>
                    <p>
                        <i class="fa fa-calendar"></i> <b>Thời gian</b>:&nbsp;<?php echo  $get_meta_time[0]["meta_value"] ?>  </p>
                    <p>
                         <i class="fa fa-user"></i> <b>Diễn giả</b> - <?php echo  $author[0]["name"] ?>   </p>
                                        <div class="action">
                                        <span id="jdmath-load-hangouts">
                                         
                                         </span>
                                                <a class="main-button-red  login" href="#">HÃY ĐĂNG KÝ ĐỂ THAM GIA</a>
                        
                    </div>
                    
                                     </div>
                <div class="clr"></div>
                </div>
            </div>
        
                                          <div id="classes-container-feature">
<div style="display: block;" id="classes-pitch-container">
    <h2>Bài học online trực tiếp sẽ được diễn ra hàng giờ trong ngày ở dưới đây. Các bạn hãy theo dõi nhé và tham gia đầy đủ nhé</h2>
    <div class="class-listing-container">
    <div style="display: block;" class="live-now-container">
    <!-- 1 -->
        <div class="jdmath-box-p2">
        <div id="jdmath-form-data">
         <form class="form-horizontal" role="form" action="<?php echo SITE_DIR ?>register/register_online?post_id=<?php echo $_GET['post_id'] ?>" method="post">
        <div class="jdmath-register-website"><h2 style="font-size: 16pt;color:#ff8a00">Thông Tin Đăng Ký</h2></div>
        <div class="jd-itm-s">
        <?php 
        	$id_user = $this->session->userdata('member_id');
        	$user = $ci->core->show_all("users","user_id",$id_user);
        ?>
         <?php
        if(!empty($ms_error))
        {
            echo "<div class='error'>".$ms_error."</div>";
             $this->session->unset_userdata('ms_error');
        }   
       if(!empty($ms_success_product))
        {
            echo "<div class='success'>".$ms_success_product." </div>";
             $this->session->unset_userdata('ms_success_product');
        } 
        
            ?>
         
               
                <div id="jdmath-error"></div>       
                 <div class="form-box">
                     <span id="jdmath-error-fullname"></span>
                      <div style="padding:0px;margin: 0px 0px 15px 0px;" class="row">
                        <i style=" padding:7px 5px 16px 5px !important;" class="fa fa-user">
                        <span class="red">*</span></i>
                        <input type="text" name="name" readonly="" style="margin: 0px;width:88%" value="<?php echo $user[0]['user_name'] ?>" class="fullname">
                        
                    </div>
                    <span id="jdmath-error-email"></span>
                     <div style="padding:0px;margin: 0px 0px 15px 0px;" class="row">
                        <i style=" padding:7px 5px 16px 5px !important;" class="fa fa-envelope">
                        <span class="red">*</span></i>
                        <input type="text" name="email" readonly="" style="margin: 0px;width:88%" value="<?php echo $user[0]['user_email'] ?>" class="email">  
                    </div>

                    <span id="jdmath-error-phone"></span>

                    <div style="padding:0px;margin: 0px 0px 15px 0px;" class="row">
                        <i style=" padding:7px 5px 16px 5px !important;" class="fa fa-mobile"><span class="red">*</span></i>
                        <input type="text" placeholder="Nhập số điện thoại của bạn" name="phone" style="margin: 0px;width:88%"  id="phone" class="password">                    
                    </div>
                    <div style="padding:0px;margin: 0px 0px 15px 0px;" class="row">
                        <i style=" padding:7px 5px 16px 5px !important;" class="fa fa-map-marker"><span class="red">*</span></i>
                        <input type="text" placeholder="Nhập địa chỉ của bạn" name="address" style="margin: 0px;width:88%"  id="phone" class="password">                    
                    </div>
                   <div style="padding:0px;margin: 0px 0px 15px 0px;" class="row">
                        <i class="fa fa-money"></i>
                        <input type="text" readonly="" value="<?php echo number_format($get_meta_price[0]['meta_value']) ?>" style="margin: 0px;width:88%" class="password">                    
                    </div>
                   
                       Thanh Toán Trực Tiếp: <input id="pay_tt" value="pay_tt" type="radio" name="pay"> 
                       Thanh Toán Qua Thẻ: <input id="pay_qt" value="pay_qt" type="radio" name="pay">               
                  
                </div><a name="testimonials" href="#"></a>
                <div class="error tab_tt">
                	<?php echo $ci->core->get_option("pay_tt"); ?>
                </div>
                <div class="error tab_qt" style="display:none;">
                	<?php echo $ci->core->get_option("pay_qt"); ?>
                </div>
                <div style="padding:0px;margin: 0px auto;" class="social-logins">                  
                    <a  class="jdmath-site-login" href="javascript:void(0);" style="width: 110px;padding:0px 0px 0px 10px;">
                        <input type="submit" class="jdmath-connect btn-school" style="font-size: 11pt;padding:8px 10px 8px 10px;" value="Đăng Ký">
                    </a>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>            
        </div>
        </form>
      
        </div>
        </div>
    <div id="jdmath-load-class-time_out"> </div>
    <!--<span id="jdmath-load-class-time_out-loading"><img src="http://easyenglish.edu.vn/classes/media/icons/gui-loading.gif"></span>-->
    </div>
</div>
</div>

</div>
</div> 
<script type="text/javascript">
 $(document).ready(function(){
	$("#pay_tt").click(function(){
			$(".tab_tt").show();
			$(".tab_qt").hide();
	});
	$("#pay_qt").click(function(){
			$(".tab_qt").show();
			$(".tab_tt").hide();
	});
});
	
</script>
<?php endif; ?>
          <div class="clr"></div>
           <footer id="main-footer">
                 <div class="in jdmath-f">
    <div class="intro">
        <a href="<?php echo SITE_DIR ?>">
            <img title="Easyenglish" src="<?= $ci->core->get_option("logo") ?>">
        </a>
    </div>
    <nav>
        <a href="<?php echo SITE_DIR ?>/142-Gioi-Thieu" class="title">Về chúng tôi</a>
        <a href="<?php echo SITE_DIR ?>/142-Gioi-Thieu" target="_blank">Trợ giúp</a>
        <a href="#" target="<?php echo SITE_DIR ?>main_default/list_blog">Blog</a>
        <a href="#teachers">Giảng viên</a>
        <a href="#privacy" style="display: none;">Bảo mật</a>
        <a href="#terms" style="display: none;">Điều khoản</a>
    </nav>
    <nav>
        <a href="#" class="title">Lớp học trực tiếp</a>
        <a href="<?php echo SITE_DIR ?>main_default/readschool?list_register">Lớp học tiếng anh</a>
        <a href="<?php echo SITE_DIR ?>main_default/list_school">Lớp học khác</a>
    </nav>
        <nav class="social">
        <a class="title">Social</a>
        <a href="https://www.facebook.com/easyenglish.edu.vn?fref=ts" target="_blank">
        <span class="icon icon-facebook"></span>
        Facebook
        </a>
        <a href="https://www.twitter.com/easyenglish" target="_blank">
        <span class="icon icon-twitter"></span>
        Twitter
        </a>
        <a href="https://plus.google.com/+easyenglish" target="_blank">
        <span class="icon icon-google-plus"></span>
        Google+
        </a>
    </nav>
    <div class="bottom">
        
    </div>
</div>

                
                </footer>
                <div id="satusbar"><div id="jdmath-article-footer"><address>&copy;Copyright by easyenglish.edu.vn 2015</address></div></div>
   

                         </div>