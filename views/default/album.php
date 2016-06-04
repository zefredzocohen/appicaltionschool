<?php
$ci = &get_instance();
?>
<div class="containerz">
	<div class="boxl pull-left">
		<div class="tit"><a href="" title="">Thư viện ảnh</a></div>
	<div class="img_ab">
            
             <?php 
             foreach ($list as $ga){
                 ?>
            <div class="imgg pull-left">
                <a class="fancybox-buttons" data-fancybox-group="button" href="<?php echo $ga['ga_link'] ?>"><img src="<?php echo $ga['ga_link'] ?>" alt="" width='220' height="150">	</a>	
                </div>
                    <?php
             }
             ?>
          
			
		

	<div class="clearfix"></div>
		    <div class="navigation">
        <?php
       echo $this->pagination->create_links();
       ?>

    </div>
        </div><!--img_ab-->
	</div><!--boxl-->
	<div class="boxr pull-right">
    <div class="pro_box">
        <div class="tit"><a href="" title="">Tin tức nổi bật</a></div>
        <?php
         $ci->load->model('model_core','Core');
        $datas = $ci->Core->select_random('posts', 'post_id', 5);
        foreach ($datas as $da) {
            ?>
            <ul class="media-list clearfix">
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?php echo $da['post_image'] ?>" alt="...">
                    </a>
                    <div class="media-body">
                        <a class="pull-left" <?php echo "href='" . SITE_DIR . "" . $da['post_id'] . "-" . khongdau($da['post_title']) . ".html'" ?>><h5 class="media-heading"><?php echo $da['post_title'] ?></h5></a>
                    </div>
                </li>
            </ul>
    <?php
}
?>
    </div>
		<div class="pro_box">
		<div class="tit"><a href="" title="">Liên kết website</a></div>
			<select class="form-control" onchange="redirect(this.value,'_blank')">
			  <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
			  <option value="http://www.moet.gov.vn/">Trường Đại Học Thành Đô</option>
			  <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
			  <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
			  <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
			</select>
		</div><!--pro-box-->
	<div class="clearfix"></div>
	</div><!--boxr-->
	<div class="clearfix"></div>	
</div>
<?php
include 'layout/footer.php';
?>