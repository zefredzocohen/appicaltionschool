<div class="boxr pull-right">
<div class="pro_box">
        <div class="tit"><a href="" title="">Chia sẻ</a></div>
       	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		<g:plusone  data-size="medium"></g:plusone>
    </div><!--pro-box-->
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
<script type="text/javascript">
       function redirect(dropDownValue) {
          window.location.href = '@Url.Action("Action", "Controller")/' + '?id=' + dropDownValue;
       }
</script>
    </div><!--pro-box-->
    <div class="pro_box">
        <div class="tit"><a href="" title="">Liên kết website</a></div>
        <select class="form-control">

           <?php 
                    foreach ($list as $link){
                        ?>
                        <option onclick="window.open('<?php echo $link['link'] ?>','_blank')" class='lienket'> <?php echo $link['link_name'] ?></option>
                <?php
                    }
            ?>
        </select>
    </div><!--pro-box-->
	  <div class="pro_box">
        <div class="tit"><a href="" title="">Thống kê</a></div>
		<p>Đang truy cập:
				<script id="_wauwcl">var _wau = _wau || []; _wau.push(["small", "e6kn9byaxjz6", "wcl"]);
		(function() {var s=document.createElement("script"); s.async=true;
		s.src="http://widgets.amung.us/small.js";
		document.getElementsByTagName("head")[0].appendChild(s);
		})();</script></p>
		<p>Lượt truy cập: <!-- GoStats Simple HTML Based Code -->
		<a target="_blank" title="website counter" href="http://gostats.com"><img alt="website counter" 
		src="https://ssl.gostats.com/bin/count/a_390147/t_4/i_1/z_0/show_hits/ssl_c3.gostats.com/counter.png" 
		style="border-width:0" /></a>
		<!-- End GoStats Simple HTML Based Code --></p>
	
	</div><!--pro-box-->
    <div class="clearfix"></div>
</div><!--boxr-->