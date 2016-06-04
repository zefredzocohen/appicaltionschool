<?php
$ci = &get_instance();
?>
<div class="boxl pull-left">
    <?php
     $str = $_SERVER['REQUEST_URI'];
           $dum = explode("/", $str);
        $ci->load->model('model_core','core');
      $title_nav =   $ci->core->show_all('category','cat_id',$dum[1]);
      foreach ($title_nav as $tit_menu)
      {
        $name =  $tit_menu['cat_name'];
      } 
    ?>

    <div class="tit"><a href="" title=""><?php echo $name; ?> </a></div>
    <div class="box_media">
        <ul class="media-list">
            <?php
            foreach ($post_info as $post) {
                if($post['post_status'] == 1){
                    
                ?>
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?php echo $post['post_image'] ?>" alt="...">
                    </a>
                    <div class="media-body">
                        <a class="pull-left" href="<?php echo SITE_DIR . khongdau($name) ?>/<?php echo $post['post_id'] . "-" . khongdau($post['post_title']); ?>.html"><h2 class="media-heading"><?php echo $post['post_title'] ?></h2></a>
                        <div class="clearfix"></div>
                        <div class="time"><?php echo $post['post_date'] ?></div>
                        <p class="led"><?php echo $post['post_desc'] ?></p>
                    </div>
                </li>
                <?php
                }
            }
            ?>
        </ul>
    </div>	
     
    <div class="navigation">
        <?php
          echo "<span class='page_item'><a href=''>".$pagination."</a></span>";
       ?>

    </div>
    <div class="clearfix"></div>
</div><!--boxl-->
<?php
include 'layout/right.php';
?>
<div class="clearfix"></div>	
<?php
include 'layout/footer.php';
?>