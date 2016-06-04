<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
$ci = &get_instance();
include 'layout/header.php';
$ci->load->model('model_core', 'core');

?>

<body class="home-page home page page-id-1427 page-template page-template-notitle page-template-notitle-php wpb-js-composer js-comp-ver-4.3.4 vc_responsive">
<div id="global" class="global">
    <div class="pagesidebar">
        <div class="sidebarcontent">    
            <h2 id="sidelogo">
            <a href="<?php echo SITE_DIR ?>"><img src="<?= $ci->core->get_option("logo") ?>" alt=""></a>
            </h2>
            <p style="padding:20px 0 10px;color:#FFF;text-align:center;">Setup Menus in Admin Panel</p>        </div>
        <a class="sidebarclose"><span></span></a>
    </div>  
    <div class="pusher">
<?php
include 'layout/nav.php';
?>

<section id="title">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="pagetitle">
                    <h1><?php // echo $post_info[0]['post_title'];?></h1>
                           </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <ul class="breadcrumbs"><li itemtype="#" itemscope="">
                <a href="<?php echo SITE_DIR ?>" itemprop="title" property="v:title" rel="v:url">
                <span itemprop="title">Home</span></a></li><li class="current">
                <span itemprop="title"><?php echo $ci->core->catchu($post_info[0]['post_title'],25);?></span></li></ul></div>
        </div>
    </div>
</section>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="no content">
                    <img src='<?php echo $ci->core->get_option("banner_page") ?>'>
                </div>
            </div>
        </div>
        <div class="v_module v_column col-md-8 col-sm-8 v_first">
<div class="v_module v_text_block  nothing_selected">
<div class="tabs tabbable tabs-left " id="vibe-tabs-18">

<div class="tab-content">   

<div class="media">
      <div class="media-left"style="width: 64px;">
        
      </div>
      <div class="media-body">
        <h4 class="media-heading"><?php echo $post_info[0]['post_title'];?></h4>
        <?php echo $post_info[0]['post_content'];?>
           
        <?php
        if($post_info[0]['post_type'] == "school_online"):
          $check_id =  $this->session->userdata('member_id');
           if(isset($check_id) && !empty($check_id)){
              echo '<h2><a style=" margin-left: 30px; color:#333333;" href="'.SITE_DIR.'main_default/readschool?post_id='.$post_info[0]["post_id"].'" ><strong><i style="color:red" class="fa fa-mail-forward"></i> Đăng ký</strong></a></h2>';
           } else{
            echo '<h2><a style=" margin-left: 30px; color:#333333;" href="#" class="dk_school"><strong><i style="color:red" class="fa fa-mail-forward"></i> Đăng ký</strong></a></h2>';
           }
           endif;
          ?>
      </div>
      
    </div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=255578621301919";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-comments" data-href="<?php echo SITE_DIR ?>/main_default/<?php //echo $post_info[0]['post_id'] ?>" data-numposts="5" data-width="700" data-colorscheme="light"></div>
</div></div></div>
</div>
<div class="v_module v_column col-md-4 col-sm-4 ">
<style>.custombanner img{
border:5px solid #FFF;
border-radius:2px;
box-shadow:0 1px 2px #bbb;
}</style>
<div class="v_module v_text_block  custombanner nothing_selected"><p>&nbsp;</p>
<p>
<?php
    $link = $ci->core->show_all("links");
    foreach ($link as $item) :
 ?>
<a href="<?php echo $item['link'] ?>">
<img height="100" width="300" src="<?php echo $item['link_image'] ?>" alt="banner3" class="alignnone size-full wp-image-1442"></a>
</p>
<?php endforeach; ?>
</div>
<script type="text/javascript">
      $(".dk_school").click(function(){
        alert("Bạn cần phải đăng nhập mới có thể đăng ký được khóa học này !")
      });
      </script>
</div>
    </div>

     <?php include 'layout/khoahoc.php' ?>  
</section>
<?php
include 'layout/footer.php';
?>