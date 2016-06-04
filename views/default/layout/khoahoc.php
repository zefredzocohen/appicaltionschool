<section class="stripe fullhomestripe">
                                      <div class="container">
                                          <!-- Begin Stripe stripe_container fullwidth -->
                                          <div class="v_module v_column stripe_container fullwidth v_first">
<style>
.fullhomestripe.stripe{
  padding:30px 0;
  background:#FFF;
  }

#courses {
    color: black;
    font: 12px Tahoma,Georgia,Arial;
    margin-top: 10px;
    text-align: center;
}
#courses ul {
    background: none repeat scroll 0 0 #f4f4f4;
    border-top: 1px solid #dddddd;
    padding: 15px 0 3px;
}

#courses ul li {
    background: none repeat scroll 0 0 white;
    border: 1px solid #aeaeae;
    border-radius: 7px;
    display: inline-block;
    margin: 0 7px 10px;
    overflow: hidden;
    width: 231px;
}

#courses ul li a.image {
    display: block;
    margin-bottom: 12px;
}
#courses a {
    color: #5d951f;
    font-family: Tahoma;
    font-size: 12px;
    text-decoration: underline;
}
#courses ul li .content-data {
    overflow: hidden;
}
#courses ul li .content-data {
    padding: 10px;
}
#courses img {
    background-position: center center;
    background-repeat: no-repeat;
} 

#courses ul li .content-data .date {
    color: #2a75ab;
    font: italic 12px/20px Tahoma;
}
#courses ul li .content-data .title {
    color: #353535;
    font: bold 13px/20px Tahoma;
    text-align: left;
    white-space: nowrap;
}
#courses ul li .content-data .author {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #eee;
    border-image: none;
    border-style: solid;
    border-width: 1px 0;
    margin: 7px 0;
    padding: 5px 0 6px;
    text-align: left;
}
#courses ul li .content-data .author .name {
    font: bold 12px/20px Arial;
}
#courses ul li .content-data p {
    color: #353535;
}
#courses ul li .content-data p.detail {
    position: relative;
    text-align: right;
}

#courses a {
    color: #5d951f;
    font-family: Tahoma;
    font-size: 12px;
    text-decoration: underline;
}
#courses ul li .content-data .author .avatar {
    float: left;
    margin: 7px 5px 2px 0;
}
#courses  .sub {
    font: italic 12px Arial;
    margin-top: -12px;
}

</style>

<div class="v_module custom_post_carousel " data-class="fullhomestripe">
<div id="Kh__a_h___c"></div>
<h3 class="heading"><span>Khóa học</span></h3> 
<a href="#" class="heading_more">+</a><div id="carousel978" class="vibe_carousel flexslider   more_heading" data-block-width="262" data-block-max="4" data-block-min="2">
                <div style="overflow: hidden; position: relative;" class="flex-viewport">
                 <div id="courses">
                 <ul>
            <?php 
            $list_school = $ci->core->show_all('posts', 'post_type', "school_online", "40,1", 'post_id'); 
              foreach ($list_school as $item) :
                $meta_grsize = $ci->core->get_post_meta($item['post_id'],"_groupsize"); 
                $meta_teacher = $ci->core->get_post_meta($item['post_id'],"_teacher");
                
                $info_user = $ci->core->get_info_user( $meta_teacher[0]['meta_value']);
                 $check_id =  $this->session->userdata('member_id');
            ?>    
                      <li>
                           <a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>" class="image">
                           <img width="231" height="130" alt="<?php echo $item['post_title'] ?>" src="<?php echo SITE_DIR ?>thumb.php?src=<?php echo $item['post_image'] ?>&w=231&h=130">
                           </a>
      
                            <div class="content-data">
                                  <p class="title">Khóa học</p>
                                  <p class="title"><?php echo $item['post_title'] ?></p>
                                  <p class="date">(Học ngay sau khi hoàn tất hồ sơ)</p>
                                  <div class="author">
                                    <img width="24" height="24" alt="<?php echo $info_user[0]['user_name'] ?>" style="background-image:url(<?php echo $info_user[0]['user_avata'] ?>)" src="<?php echo $info_user[0]['user_avata'] ?>" class="avatar">
                                    <a href="<?php echo SITE_DIR.'main_default/info_teacher/'.$info_user[0]['user_id']  ?>"><p class="name"><?php echo $info_user[0]['name'] ?></p></a>
                                    <!-- <p class="sub">CEO &amp; Founder of ZendVN</p> -->
                                    <p><?php echo $info_user[0]["user_work"]; ?></p>
                                  </div>
                                  <p class="detail">
                                    <?php
                   
                                     if(isset($check_id) && !empty($check_id)){
                                        echo '<a href="'.SITE_DIR.'main_default/readschool?post_id='.$item["post_id"].'" ><strong><i class="fa fa-mail-forward" style="color:red ;font-size: 20px; "></i> Đăng ký</strong></a>';
                                     } else{
                                      echo '<a  href="#" class="dk_school"> <strong><i class="fa fa-mail-forward" style="color:red ;font-size: 20px; "></i> Đăng ký</strong></a>';

                                     }                                      
                                      ?>
                                  </p>
                            </div>
                      </li>
                       <?php endforeach; ?>
                  </ul>
             </div>


<script type="text/javascript">
  $(".dk_school").click(function(){
    alert("Bạn cần phải đăng nhập mới có thể đăng ký được khóa học này !")
  });
  </script>

                    </ul></div><ul class="flex-direction-nav"><li><a tabindex="-1" class="flex-prev flex-disabled" href="#"><i class="icon-arrow-1-left"></i></a></li><li><a tabindex="-1" class="flex-next flex-disabled" href="#"><i class="icon-arrow-1-right"></i></a></li></ul></div></div>
</div> 
                                          <!-- End Stripestripe_container fullwidth -->    
                                       </div>
                                    </section>  
      