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
            <a href="<?php echo SITE_DIR ?>"><img src="<?= $ci->core->get_option("logo") ?>" alt="Đột phá tiếng anh cùng easyenglish"></a>
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
							<li id="course-all" class="loading selected"><a href="#">All Courses <span><?php echo count($list_blog) ?></span></a></li>

																				</ul>
					</div><!-- .item-list-tabs -->
					<div role="navigation" id="subnav" class="item-list-tabs">
						<ul>
														<li>
								<div role="search" class="dir-search" id="group-dir-search">
									
		<label><input type="text" placeholder="Search ..." id="groups_search" name="s"></label>
		<input type="submit" value="Search" name="course_search_submit" id="course_search_submit">
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
		foreach ($list_blog as $item) :
			
	?>
		<li>
						<div itemprop="photo" class="item-avatar">
				<a title="<?= $item["post_title"] ?>" href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>">
				<img height="170" width="310" class="attachment-full wp-post-image" src="<?= $item["post_image"] ?>"></a>			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>"><?= $item["post_title"] ?></a>
				</div>
				
				<div class="item-desc"><p><?= $item["post_desc"] ?>...</p>
					</div>
				
				<div class="item-credits">
				<a href="<?php echo  $item['post_id']."-".subvn($item['post_title']) ?>"><strong><i class="fa fa-arrow-circle-right"></i> ReadMore</strong></a>				
							</div>
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