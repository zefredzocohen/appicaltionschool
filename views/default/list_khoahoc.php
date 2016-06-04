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
            <a href="<?php echo SITE_DIR ?>"><img src="<?= $ci->core->get_option("logo") ?>"></a>
            </h2>
            <p style="padding:20px 0 10px;color:#FFF;text-align:center;">Setup Menus in Admin Panel</p>        </div>
        <a class="sidebarclose"><span></span></a>
    </div>  
    <div class="pusher">
    <?php
include 'layout/nav.php';
?>

<section id="content">
	<div id="buddypress">
		<div class="container">
			<div class="padder">
				<div class="row">
			<div class="col-md-12 col-sm-8">
				<form class="dir-form" id="course-directory-form" method="post" action="">

					
					
					<div role="navigation" class="item-list-tabs">
						<ul>
							<li id="course-all" class="loading selected"><a href="#">All Courses <span><?php echo count($list_school) ?></span></a></li>

																				</ul>
					</div><!-- .item-list-tabs -->
					<div role="navigation" id="subnav" class="item-list-tabs">
						<ul>
														<li>
								<div role="search" class="dir-search" id="group-dir-search">
                                                                    <form method="post" action="http://localhost/school_online/main_default/list_school1/">					
		<label><input type="text" placeholder="Search ..." id="groups_search" name="s"></label>
                <input type="submit" value="Search" name="course_search_submit" id="course_search_submit"></form>
									</div><!-- #group-dir-search -->
							</li>
							<li class="switch_view"><a class="active" id="list_view"><i class="icon-list-1"></i></a><a id="grid_view"><i class="icon-grid"></i></a>
							</li>
							<li class="last filter" id="course-order-select">

								<label for="course-order-by">Order By:</label>
								<select id="course-order-by">
																		<option value="" selected="selected">Select Order</option>
									<option value="newest">Newly Published</option>
									<option value="alphabetical">Alphabetical</option>
									<option value="popular">Most Members</option>
									<option value="rated">Highest Rated</option>

																	</select>
							</li>
						</ul>
					</div></form>
					<div class="course dir-list" id="course-dir-list">

							<div class="pagination" id="pag-top">

		<div id="course-dir-count-top" class="pag-count">

			Viewing page 1 of 1
		
		</div>

		<div id="course-dir-pag-top" class="pagination-links">

			
		</div>

	</div>

	
	<ul role="main" class="item-list" id="course-list">

	<?php 
		foreach ($list_school as $item) :
			$meta_grsize = $ci->core->get_post_meta($item['post_id'],"_groupsize"); 
            $meta_teacher = $ci->core->get_post_meta($item['post_id'],"_teacher");
            $info_user = $ci->core->get_info_user( $meta_teacher[0]['meta_value']);
	?>
		<li>
						<div itemprop="photo" class="item-avatar">
				<a title="<?= $item["post_title"] ?>" href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>">
				<img height="170" width="310" class="attachment-full wp-post-image" src="<?= $item["post_image"] ?>"></a>			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>"><?= $item["post_title"] ?></a>
				</div>
				<div class="item-meta">
				<div class="item-desc"><p><?= $item["post_desc"] ?>...</p>
					</div>
				<div class="item-credits">
				<?php
				$check_id =  $this->session->userdata('member_id');
				 if(isset($check_id) && !empty($check_id)){
				 		echo '<a href="'.SITE_DIR.'main_default/readschool?post_id='.$item["post_id"].'" ><strong><i style="color:red" class="fa fa-mail-forward"></i> Đăng ký Tham Gia</strong></a>';
				 } else{
				 	echo '<a href="#" class="dk_school"><strong><i style="color:red" class="fa fa-mail-forward"></i> Đăng ký Tham Gia</strong></a>';
				 }
				 	?>
				
							</div>
				<div class="item-instructor">
					<div class="instructor_course">
					<div class="item-avatar"><img height="150" width="150" alt="Profile Photo" class="avatar user-3-avatar avatar- photo" src="<?php echo $info_user[0]['user_avata'] ?>"></div>
					<h5 class="course_instructor"><a href="<?php echo SITE_DIR .'main_default/info_teacher/'.$info_user[0]['user_id']; ?>"><?php echo $info_user[0]['user_name'] ?></a></h5>
					</div>				</div>
				<div class="item-action"></div>
				
			</div>
						<div class="clear"></div>
		</li>
	<?php endforeach; ?>
	
	</ul>

	<script type="text/javascript">
	$(".dk_school").click(function(){
		alert("Bạn cần phải đăng nhập mới có thể đăng ký được khóa học này !")
	});
	</script>
	<div class="pagination" id="pag-bottom">
		  <ul class="pagination pull-right">
        		      <?php
                        echo "<li>".$this->pagination->create_links()."</li>";
                        ?>						
        		</ul>
		<div id="course-dir-count-bottom" class="pag-count">

			Viewing page 1 of 1
		</div>

		<div id="course-dir-pag-bottom" class="pagination-links">

			
		</div>

	</div>
		</div><!-- #courses-dir-list -->	
					<input type="hidden" value="ebac109ae6" name="_wpnonce-course-filter" id="_wpnonce-course-filter"><input type="hidden" value="/khoa-hoc/" name="_wp_http_referer">
					
				<!-- #course-directory-form -->
			</div>	
		
		</div>
			</div>
		</div>
	</div>
</section>
<?php
include 'layout/footer.php';
?>