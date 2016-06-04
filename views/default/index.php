
<body class="home-page home page page-id-1427 page-template page-template-notitle page-template-notitle-php wpb-js-composer js-comp-ver-4.3.4 vc_responsive">
<div id="global" class="global">
    <div class="pagesidebar">
        <div class="sidebarcontent">    
            <h2 id="sidelogo">
            <a href="http://easyenglish.edu.vn/"><img src="<?php echo SITE_DEFAULT ?>images/logo.png" alt="Đột phá tiếng anh cùng easyenglish"></a>
            </h2>
            <p style="padding:20px 0 10px;color:#FFF;text-align:center;">Setup Menus in Admin Panel</p>        </div>
        <a class="sidebarclose"><span></span></a>
    </div>  
    <div class="pusher">

<?php
include 'layout/nav.php';
include 'layout/slide.php';

$posts_limit_highlights = $ci->core->show_all('posts', 'tit_id', 1, "4,1", 'post_id');
?>

    <section class="main">
                            <div class="container">
                                <div class="full-width">
                                    <div class="vibe_editor clearfix">

<style>.custom_block img{
max-width:80px;
padding:30px 0;
}
.custom_block h3{font-weight: 600;
text-transform: uppercase;
font-size: 17px;margin-bottom:0;}
.custom_block h3+p{color:#bbb;margin-top:0;font-size:11px;font-weight:600;text-transform:uppercase;}</style>


<?php foreach ($posts_limit_highlights as $item):  ?>
 <!-- end .v_column_col-md-3 col-sm-3 -->
<div class="v_module v_column col-md-3 col-sm-3 ">
  <div class="v_module v_text_block  custom_block nothing_selected">
    <p style="text-align: center;">
      <img class="alignnone size-full wp-image-1428" src="<?= $item['post_image'] ?>" alt="1" width="140" height="140">
    </p><a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>"><h3 style="text-align: center;"><?= $item['post_title'] ?></h3></a>
    <p style="text-align: center;"><?= $item['post_desc'] ?></p>
    <p style="text-align: center;"><?= $ci->core->catchu($item['post_content'],100) ?></p>
    <p style="text-align: center;"><a class="link" href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>">more</a></p>
  </div>
</div> <!-- end .v_column_col-md-3 col-sm-3 -->
<?php endforeach; ?>

</div>
</div>
                                    </div></section>
                                    <?php include 'layout/khoahoc.php' ?>        
                                      
</div> 
<?php
include 'layout/footer.php';
?>


