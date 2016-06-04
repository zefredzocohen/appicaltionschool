<?php
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
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <div class="vibe_editor clearfix"><div class="v_module v_column col-md-6 col-sm-6 v_first">
<div class="v_module v_text_block  nothing_selected"><p></p><h3 class="heading "><span>Contact</span></h3><p></p><div class="form">
             <form data-subject="Contact from WPLMS" data-to="vibethemes@gmail.com" method="post"> <input type="text" data-validate="" class="form_field text" placeholder="Name"> <input type="text" data-validate="email" class="form_field text" placeholder="Email"> <textarea data-validate="" class="form_field  textarea" placeholder="Message"></textarea> <input type="submit" value="Send Message" class="form_submit button primary"> <div class="response"></div></form>
             </div></div>
</div> <!-- end .v_column_col-md-6 col-sm-6 -->
<div class="v_module v_column col-md-6 col-sm-6 ">
<div class="v_module v_text_block  nothing_selected"><p></p><h3 class="heading "><span>Info</span></h3><p></p>
<div class="form">
             <?= $ci->core->get_option("address") ?>
</div>
</div> <!-- end .v_column_col-md-6 col-sm-6 -->
</div>                </div>
                            </div>
        </div>
    </div>
</section>
<?php
include 'layout/footer.php';
?>