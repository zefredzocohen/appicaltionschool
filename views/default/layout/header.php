<?php
$ci = &get_instance();
$ci->load->model('model_core', 'core');
function subvn($str, $is_url = false, $lower = true) {
    $str = strip_tags(trim($str));
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);

    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/i", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/i", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/i", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/i", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/i", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/i", 'y', $str);
    $str = preg_replace("/(đ)/i", 'd', $str);
    $str = preg_replace(array('#(amp;|quot;|;|-)#i', '#[^\w]+#i', '#[\s]+#iU'), '-', $str);
    $str = trim($str, '- ');
    $str = $lower ? strtolower($str) : $str;
    return $str;
}
?>
<!DOCTYPE html>
<html id="ls-global" class="js csstransitions" lang="en-US"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>
<?php echo $ci->core->get_option("title") ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="author" content="VibeThemes">
                <link rel="shortcut icon" href="">
                <link rel="icon" type="image/png" href="<?php echo $ci->load->model('model_core', 'core'); ?>">
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                  <script src="http://easyenglish.edu.vn/wp-content/themes/wplms/js/html5shiv.js"></script>
                  <script src="http://easyenglish.edu.vn/wp-content/themes/wplms/js/respond.js"></script>
                <![endif]-->
    <!-- Bootstrap JS -->
<script src="<?php echo SITE_ADMIN; ?>js/basic.js"></script><div class="fit-vids-style">­
                <style> 
                .fluid-width-video-wrapper { 
                    width: 100%;
                    position: relative;                      
                     padding: 0;                            
                 }                                                                                  
                  .fluid-width-video-wrapper 
                 iframe,        
                 .fluid-width-video-wrapper object,        
                 .fluid-width-video-wrapper embed {          
                  position: absolute;                      
                   top: 0;                                
                     left: 0;                                 
                      width: 100%;                             
                       height: 100%;                          
                   }                                     
                         </style></div><script type="javascript/text">
              NProgress.start();
           </script>

<link rel="stylesheet" id="layerslider-css" href="<?php echo SITE_DEFAULT ?>css/jquery.bxslider.css" type="text/css" media="all">
<link rel="stylesheet" id="layerslider-css" href="<?php echo SITE_DEFAULT ?>css/layerslider.css" type="text/css" media="all">
<link rel="stylesheet" id="bbp-default-css" href="<?php echo SITE_DEFAULT ?>css/bbpress.css" type="text/css" media="screen">
<link rel="stylesheet" id="contact-form-7-css" href="<?php echo SITE_DEFAULT ?>css/styles.css" type="text/css" media="all">
<link rel="stylesheet" id="icons-css-css" href="<?php echo SITE_DEFAULT ?>css/fonticons.css" type="text/css" media="all">
<link rel="stylesheet" id="magnific-css-css" href="<?php echo SITE_DEFAULT ?>css/magnific-popup.css" type="text/css" media="all">
<link rel="stylesheet" id="mejskin-css" href="<?php echo SITE_DEFAULT ?>css/mediaelementplayer.css" type="text/css" media="all">
<link rel="stylesheet" id="animation-css-css" href="<?php echo SITE_DEFAULT ?>css/animation.css" type="text/css" media="all">
<link rel="stylesheet" id="dashicons-css" href="<?php echo SITE_DEFAULT ?>css/dashicons.css" type="text/css" media="all">
<link rel="stylesheet" id="thickbox-css" href="<?php echo SITE_DEFAULT ?>css/thickbox.css" type="text/css" media="all">
<link rel="stylesheet" id="shortcodes-css-css" href="<?php echo SITE_DEFAULT ?>css/shortcodes.css" type="text/css" media="all">
<link rel="stylesheet" id="wplc-font-awesome-css" href="<?php echo SITE_DEFAULT ?>css/font-awesome.css" type="text/css" media="all">
<link rel="stylesheet" id="wplc-style-css" href="<?php echo SITE_DEFAULT ?>css/wplcstyle.css" type="text/css" media="all">
<link rel="stylesheet" id="wplms-assignments-css-css" href="<?php echo SITE_DEFAULT ?>css/wplms-assignments.css" type="text/css" media="all">
<link rel="stylesheet" id="wplms-customizer-css-css" href="<?php echo SITE_DEFAULT ?>css/custom.css" type="text/css" media="all">
<link rel="stylesheet" id="wplms-events-css-css" href="<?php echo SITE_DEFAULT ?>css/wplms-events.css" type="text/css" media="all">
<link rel="stylesheet" id="liveedit-css-css" href="<?php echo SITE_DEFAULT ?>css/jquery-liveedit.css" type="text/css" media="all">
<link rel="stylesheet" id="wplms-front-end-css-css" href="<?php echo SITE_DEFAULT ?>css/wplms_front_end.css" type="text/css" media="all">
<link rel="stylesheet" id="google-webfonts-css" href="<?php echo SITE_DEFAULT ?>css/css.css" type="text/css" media="all">
<link rel="stylesheet" id="twitter_bootstrap-css" href="<?php echo SITE_DEFAULT ?>css/bootstrap.css" type="text/css" media="all">
<link rel="stylesheet" id="fonticons-css-css" href="<?php echo SITE_DEFAULT ?>css/fonticons_002.css" type="text/css" media="all">
<link rel="stylesheet" id="search-css-css" href="<?php echo SITE_DEFAULT ?>css/chosen.css" type="text/css" media="all">
<link rel="stylesheet" id="buddypress-css-css" href="<?php echo SITE_DEFAULT ?>css/buddypress.css" type="text/css" media="all">
<link rel="stylesheet" id="bbpress-css-css" href="<?php echo SITE_DEFAULT ?>css/bbpress_002.css" type="text/css" media="all">
<link rel="stylesheet" id="style-css-css" href="<?php echo SITE_DEFAULT ?>css/style_002.css" type="text/css" media="all">
<link rel="stylesheet" id="woocommerce-css-css" href="<?php echo SITE_DEFAULT ?>css/woocommerce.css" type="text/css" media="all">
<link rel="stylesheet" id="theme-css-css" href="<?php echo SITE_DEFAULT ?>css/style.css" type="text/css" media="all">
<link rel="stylesheet" id="js_composer_custom_css-css" href="<?php echo SITE_DEFAULT ?>css/custom.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_007.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery-migrate.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/morris.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_006.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/greensock.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/layerslider_002.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/layerslider.js"></script>
<script src="<?php echo SITE_DEFAULT ?>js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery.bxslider.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
    $('.bxslider').bxSlider({
      adaptiveHeight: true,
      mode: 'fade',
      auto: true,
    });
});

</script>
<script type="text/javascript">
/* <![CDATA[ */
var BP_Confirm = {"are_you_sure":"Are you sure?"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/confirm.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wplms_assignment_messages = {"assignment_reset":"This step is irreversible. All Assignment subsmissions would be reset for this user. Are you sure you want to Reset the Assignment for this User? ","assignment_reset_button":"Confirm, Assignment reset for this User","marks_saved":"Marks Saved","assignment_marks_saved":"Assignment Marks Saved","cancel":"Cancel"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/wplms-assignments.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/custom.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/wplms-events.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery-liveedit.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/core.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/widget.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/mouse.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/sortable.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/slider.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/datepicker.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wplms_front_end_messages = {"course_title":"Please change the course title","create_course_confrim":"This will create a new course in the site, do you want to continue ?","create_course_confrim_button":"Yes, create a new course","save_course_confrim":"This will overwrite the previous course settings, do you want to continue ?","save_course_confrim_button":"Save course","create_unit_confrim":"This will create a new unit in the site, do you want to continue ?","create_unit_confrim_button":"Yes, create a new unit","save_unit_confrim":"This will overwrite the existing unit settings, do you want to continue ?","saveunit_confrim_button":"Yes, save unit settings","create_question_confrim":"This will create a new question in the site, do you want to continue ?","create_question_confrim_button":"Yes, create a new question","create_quiz_confrim":"This will create a new quiz in the site, do you want to continue ?","create_quiz_confrim_button":"Yes, create a new quiz","save_quiz_confrim":"This will overwrite the existing quiz settings, do you want to continue ?","save_quiz_confrim_button":"Yes, save quiz settings","delete_confrim":"This will delete the unit\/quiz from your site, do you want to continue ?","delete_confrim_button":"Continue","save_confrim":"This will overwrite the previous settings, do you want to continue ?","save_confrim_button":"Save","create_assignment_confrim":"This will create a new assignment in the site, do you want to continue ?","create_assignment_confrim_button":"Yes, create a new assignment"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/wplms_front_end.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/nprogress.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<style></style><meta name="generator" content="Powered by Visual Composer - drag and drop page builder for WordPress.">
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="http://easyenglish.edu.vn/wp-content/plugins/js_composer/assets/css/vc-ie8.css" media="screen"><![endif]-->
<style type="text/css">
    .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
<link rel="stylesheet" href="<?php echo SITE_DEFAULT?>css/skin.css" type="text/css">
</head>
<style type="text/css">
  .box-support {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #ffffff;
    border-color: #dddddd #dddddd -moz-use-text-color;
    border-image: none;
    border-style: solid solid none;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    border-width: 3px 3px medium;
    bottom: 0;
      max-height: 204px;
    padding: 2px;
    position: fixed;
    right: 5px;
    width: 350px;
    z-index: 9999;
  }
.detail .glyphicon.glyphicon-share-alt {
    font-size: 15px;
}
.box-notice {
    background-color: #ffffff;
    height: 100%;
    width: 100%;
}
.box-notice .head {
    background-color: #2a75ab;
    color: #ffffff;
    font-size: 18px;
    font-weight: bold;
    height: 32px;
}
.box-notice .head h3 {
        color: white;
    display: inline-block;
    float: left;
    height: 32px;
    line-height: 32px;
    margin-top: 0;
    text-align: center;
    width: 265px;
}
.supporter {
    background-color: #f2f7fa;
    float: left;
}
.clr {
    clear: both;
} 

.chat {
    background-color: #3084c0;
    border: 1px solid #15527e;
    display: block;
    height: 26px;
    margin: 5px auto;
    padding: 1px 0;
    width: 240px;
}

.chat a {
    background-color: #2a75ab;
    color: #ffffff;
    display: block;
    font-size: 14px;
    font-weight: bold;
    line-height: 26px;
    text-align: center;
    cursor: pointer;
}
.supporter img {
    border: 1px solid #cccccc;
    display: block;
    float: left;
    margin: 5px;
    padding: 2px;
}

.box-notice .head img {
    cursor: pointer;
    float: left;
}

.supporter p{
  font-size: 10px;
}

</style>
<div class="box-support">
    <div class="box-notice">
      <div class="head">
          <img src="<?php echo base_url();?>uploads/files/ic_msg.png" class="sp_msg">
        <h3>Hỗ trợ trực tuyến</h3>
        <img src="<?php echo base_url();?>uploads/files/ic_hidden.png" class="sp_hidden">
        <div class="clr"></div>
      </div>
      <div class="sp_toggle" style="display: none;">
          <div class="supporter">
            <img title="ZendVN" alt="ZendVN" src="<?php echo base_url();?>uploads/files/support.png" class="sp_icon">
            <p>
              <strong>Thân chào bạn!</strong>
            </p>
            <p class="notice-title">Hiện nay ATCVN đang Offline.</p>
            <p class="notice-content">Nếu bạn có vấn đề gì xin hãy nhấn nút 
            <strong style="color:#2a75ab">Gửi tin nhắn</strong>.
             Sau đó nhập nội dung như: Tên của bạn, số điện thoại, email và vấn đề của bạn. ATCVN sẽ liên lạc với bạn lại trong thời gian sớm nhất.</p>
           </div>
           <div class="clr"></div>
           <span class="chat"><a id="btnBoxSupport"  data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" >Gửi tin nhắn</a></span>
       </div>
     </div>
 </div>
<!-- Large modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
      <div role="alert" style="display: none;" class="alert alert-success">
      <strong>Notice ! </strong> You successfully read this important alert message.
    </div>
        <form>
        <div class="form-group g-name">
            <label for="recipient-name" class="control-label">Name:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group g-email">
            <label for="recipient-name" class="control-label">Email:</label>
            <input type="email" class="form-control" id="recipient-email">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="send btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      var x = true;
        $(".sp_hidden").click(function(){
           $(".alert").hide();
          x = !x;
          if(x == false){ 
            $(".sp_toggle").show();
          }else{
             $(".sp_toggle").hide();
          }
        });

        $(".send").click(function(){
          $(".alert").hide();
          var name = $("#recipient-name").val();
           var email = $("#recipient-email").val();
           var ms = $("#message-text").val();
   
           if(name.length <= 0 ){
               $(".g-name").addClass("has-error");
           }else{
            $(".g-name").removeClass("has-error");
           }
           if(email.length <= 0 ){
               $(".g-email").addClass("has-error");
           }else{
            $(".g-email").removeClass("has-error");
           }
           if(name.length > 0 && email.length > 0){

              $.ajax({
                    type: "post",
                    url: '<?php echo SITE_DIR ?>main_default/add_contact',
                    data: {
                      name: name,
                      email: email,
                      ms : ms
                    },
                    success: function(){
                      document.getElementById("recipient-name").value = "";
                      document.getElementById("recipient-email").value = "";
                      document.getElementById("message-text").value = "";
                      
                        $(".alert").show();

                         
                    }
              });

           }

        });
    });
</script