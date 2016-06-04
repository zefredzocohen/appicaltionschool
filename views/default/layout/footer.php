
<footer>
    <div class="container">
        <div class="row">
            <div class="footertop">
                <div class="col-md-3 col-sm-6">
                <div class="footerwidget">
               <?= $ci->core->get_option("address") ?>
        </div>
        </div>
        <div class="col-md-3 col-sm-6">
        <div class="footerwidget">
        <h4 class="footertitle">Khóa học</h4>
                <ul class="widget_course_list no-ajax">     
          <?php $posts_limit_ft = $ci->core->show_all('posts', 'post_type', "school_online", "3,1", 'post_id');  ?>
          <?php
           foreach ($posts_limit_ft as $item): 
            
                $meta_teacher = $ci->core->get_post_meta($item['post_id'],"_teacher");
                
                $info_user = $ci->core->get_info_user( $meta_teacher[0]['meta_value']);
           ?>
             <li><a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>">
             <img src="<?php echo $item['post_image'] ?>" class="attachment-thumbnail wp-post-image" alt="phatamsieutoc-310x147" width="150" height="150">
             <h6><?php echo $item['post_title'] ?><span></span></h6></a>
                </li>
          <?php endforeach; ?>
            </ul>   
        </div>
        </div>    
        <div class="col-md-3 col-sm-6">
       <div class="fb-page" data-href="https://www.facebook.com/atcmedia.vn?__mref=message_bubble" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/atcmedia.vn?__mref=message_bubble"><a href="https://www.facebook.com/atcmedia.vn?__mref=message_bubble">ATC Việt Nam</a></blockquote></div></div>
        </div>    <div class="col-md-3 col-sm-6"><div class="footerwidget">           <div class="textwidget"><img src="<?php echo SITE_DEFAULT ?>images/banner-home.png"></div>
        </div></div>            </div>
        </div>
        <div class="row">
            <div class="footerbottom">
                                            </div>
        </div>
    </div> 
    <div id="scrolltop">
        <a><i class="icon-arrow-1-up"></i><span>top</span></a>
    </div>
</footer>
<div id="footerbottom">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 id="footerlogo"><a href="<?php echo SITE_DIR ?>"><img src="<?= $ci->core->get_option("logo") ?>" alt="Đột phá tiếng anh cùng easyenglish"></a></h2>
                            </div>
            <div class="col-md-9">
                                        <div id="footermenu">
                            <ul id="menu-footer-menu" class="footermenu">

<li id="menu-item-2025" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2025"><a href="<?php echo SITE_DIR ?>142-Gioi-Thieu">Giới thiệu</a></li>
<li id="menu-item-2332" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2332"><a href="<?php echo SITE_DIR ?>main_default/list_school">Khóa học</a></li>
<li id="menu-item-2251" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2251"><a href="<?php echo SITE_DIR ?>main_default/list_blog">Tin tức</a></li>
<li id="menu-item-2333" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2333"><a href="<?php echo SITE_DIR ?>main_default/contact">Liên hệ</a></li>
</ul>                        </div> 
                                    </div>
        </div>
    </div>
</div>
</div><!-- END PUSHER -->
<!-- END MAIN -->
    <!-- SCRIPTS -->



<!-- Generated in 0.879 seconds. (166 q) -->

    <!-- wplc a-n-c --><link rel="stylesheet" id="bp-course-graph-css" href="<?php echo SITE_DEFAULT ?>css/graph.css" type="text/css" media="all">
<link rel="stylesheet" id="bp-course-css-css" href="<?php echo SITE_DEFAULT ?>css/course_template.css" type="text/css" media="all">
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/editor.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_002.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var _wpcf7 = {"loaderUrl":"http:\/\/easyenglish.edu.vn\/wp-content\/plugins\/contact-form-7\/images\/ajax-loader.gif","sending":"Sending ..."};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/scripts.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_005.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_003.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/masonry.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var mejsL10n = {"language":"en-US","strings":{"Close":"Close","Fullscreen":"Fullscreen","Download File":"Download File","Download Video":"Download Video","Play\/Pause":"Play\/Pause","Mute Toggle":"Mute Toggle","None":"None","Turn off Fullscreen":"Turn off Fullscreen","Go Fullscreen":"Go Fullscreen","Unmute":"Unmute","Mute":"Mute","Captions\/Subtitles":"Captions\/Subtitles"}};
var _wpmejsSettings = {"pluginPath":"\/wp-includes\/js\/mediaelement\/"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/mediaelement-and-player.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_004.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var thickboxL10n = {"next":"Next >","prev":"< Prev","image":"Image","of":"of","close":"Close","noiframes":"This feature requires inline frames. You have iframes disabled or your browser does not support them.","loadingAnimation":"http:\/\/easyenglish.edu.vn\/wp-includes\/js\/thickbox\/loadingAnimation.gif"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/thickbox.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var vibe_shortcode_strings = {"sending_mail":"Sending mail","error_string":"Error :","invalid_string":"Invalid ","captcha_mismatch":"Captcha Mismatch"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/shortcodes.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wc_add_to_cart_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","ajax_loader_url":"\/\/easyenglish.edu.vn\/wp-content\/plugins\/woocommerce\/assets\/images\/ajax-loader@2x.gif","i18n_view_cart":"View Cart","cart_url":"http:\/\/easyenglish.edu.vn\/cart\/","is_cart":"","cart_redirect_after_add":"no"};
var wc_add_to_cart_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","ajax_loader_url":"\/\/easyenglish.edu.vn\/wp-content\/plugins\/woocommerce\/assets\/images\/ajax-loader@2x.gif","i18n_view_cart":"View Cart","cart_url":"http:\/\/easyenglish.edu.vn\/cart\/","is_cart":"","cart_redirect_after_add":"no"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/add-to-cart.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_010.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var woocommerce_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","ajax_loader_url":"\/\/easyenglish.edu.vn\/wp-content\/plugins\/woocommerce\/assets\/images\/ajax-loader@2x.gif"};
var woocommerce_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","ajax_loader_url":"\/\/easyenglish.edu.vn\/wp-content\/plugins\/woocommerce\/assets\/images\/ajax-loader@2x.gif"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/woocommerce.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_008.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wc_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","fragment_name":"wc_fragments"};
var wc_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","fragment_name":"wc_fragments"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/cart-fragments.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/draggable.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery-cookie.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wplc_hide_chat = null;
var wplc_plugin_url = "http:\/\/easyenglish.edu.vn\/wp-content\/plugins";
var wplc_display_name = "display";
var wplc_gravatar_image = "<img src='http:\/\/www.gravatar.com\/avatar\/854815c06fede9e57818693354c05cfc?s=20' \/>";
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/wplc_u.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/course-module-js.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/wp-mediaelement.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/droppable.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var vibe_course_module_strings = {"too_fast_answer":"Too Fast or Answer not marked.","answer_saved":"Answer Saved.","processing":"Processing...","saving_answer":"Saving Answer...please wait","remove_user_text":"This step is irreversible. Are you sure you want to remove the User from the course ?","remove_user_button":"Confirm, Remove User from Course","cancel":"Cancel","reset_user_text":"This step is irreversible. All Units, Quiz results would be reset for this user. Are you sure you want to Reset the Course for this User?","reset_user_button":"Confirm, Reset Course for this User","quiz_reset":"This step is irreversible. All Questions answers would be reset for this user. Are you sure you want to Reset the Quiz for this User? ","quiz_reset_button":"Confirm, Reset Quiz for this User","marks_saved":"Marks Saved","quiz_marks_saved":"Quiz Marks Saved","submit_quiz":"Submit Quiz","sending_messages":"Sending Messages ...","adding_students":"Adding Students to Course ...","successfuly_added_students":"Students successfully added to Course","unable_add_students":"Unable to Add students to Course","select_fields":"Please select fields to download","download":"Download","theme_color":"#78c8c9","single_dark_color":"#232b2d","for_course":"for Course"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/course.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_011.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/isotope.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/chosen.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/classie.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/sidebarEffects.js"></script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/jquery_009.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var BP_DTheme = {"accepted":"Accepted","close":"Close","comments":"comments","leave_group_confirm":"Are you sure you want to leave this group?","mark_as_fav":"Favorite","my_favs":"My Favorites","rejected":"Rejected","remove_fav":"Remove Favorite","show_all":"Show all","show_all_comments":"Show all comments for this thread","show_x_comments":"Show all %d comments","unsaved_changes":"Your profile has unsaved changes. If you leave the page, the changes will be lost.","view":"View"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/buddypress.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var wplms_strings = {"wplms_woocommerce_validate":"Please fill in all the required fields (indicated by *)"};
/* ]]> */
</script>
<script type="text/javascript" src="<?php echo SITE_DEFAULT ?>js/custom.js"></script>
    

<div class="live-edit-sidebar" draggable="true"><a href="#" class="save-button">S</a></div><span style="top: -999px; left: -999px;" class="text-options"><button class="url-button">U</button><span class="input-text"><input name="liveedit-url" type="text"></span><button class="bold-button">B</button><button class="italic-button">I</button><button class="strikethrough-button">ABC</button><button class="unorderedlist-button">L</button></span></body></html>
<!--</div><!--container-->
<!--</div><!--wrapper-->
<!--<div class="footer">
<div class="wrapper">
		<div class="ft">
        <p>
 <strong>Trung tâm đào tạo và phát triển Giáo Dục Việt</strong></p>
 <p>Cơ sở 1: Số 109, đường Hồ Tùng Mậu, Mai Dịch, Cầu Giấy, Hà Nội - Điện thoại: 0466850333</p>
 <p>Cơ sở 2: Km14, Quốc lộ 32, Kim Chung, Hoài Đức, Hà Nội - Điện thoại: 0466830555</p>

    </div>
	<div class="clearfix"></div>
</div>
</div><!--End #footer-->

    <!--      <script src="<?php echo SITE_DEFAULT ?>js/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo SITE_DEFAULT ?>js/bootstrap.min.js"></script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53197030-1', 'auto');
  ga('send', 'pageview');

</script>
</body>

</html>