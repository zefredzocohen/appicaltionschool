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
                  	<div class="col-md-3">	
                  	<div class="row">
						<?php  ?>
					    <div class="thumbnail">
					      <img src="<?php echo $info_teacher[0]['user_avata']; ?>" alt="...">
					      <div class="caption">
					        <p>
						        <span aria-hidden="true" class="glyphicon glyphicon-user"></span>
						        <strong>Họ tên: </strong><?php echo $info_teacher[0]['name']; ?>
					        </p>
					        <p>
					        <span aria-hidden="true" class="glyphicon glyphicon-map-marker"></span>
					        <strong>Địa chỉ: </strong><?php echo $info_teacher[0]['user_adress']; ?>
					        <p>
					        <p>
					        <span aria-hidden="true" class="glyphicon glyphicon-calendar"></span>
					        <strong>Ngày sinh: </strong><?php echo $info_teacher[0]['user_birdhday']; ?>
					        <p>

					       <p>
					       <span aria-hidden="true" class="glyphicon glyphicon-phone"></span>
					       <strong>Số điện thoại: </strong><?php echo $info_teacher[0]['user_sdt']; ?>
					       <p>
					       <p>
					       <span aria-hidden="true" class="glyphicon glyphicon-bookmark"></span>
					       <strong>Chuyên ngành: </strong><?php echo $info_teacher[0]['user_work']; ?>
					       <p>
					       <p>
					       <span aria-hidden="true" class="glyphicon glyphicon-book"></span>
					       <strong>Tổng số khóa học: </strong>..............
					       <p>
					       <p>
					       <span aria-hidden="true" class="glyphicon glyphicon-star-empty"></span>
					       <strong>Điểm đánh giá: </strong>
					       	<span aria-hidden="true" class="glyphicon glyphicon-star"></span>
					       	<span aria-hidden="true" class="glyphicon glyphicon-star"></span>
					       	<span aria-hidden="true" class="glyphicon glyphicon-star"></span>
					       	<span aria-hidden="true" class="glyphicon glyphicon-star"></span>
					       	<span aria-hidden="true" class="glyphicon glyphicon-star"></span>
					       <p>
					      </div>
					    </div>
					
					</div>
                  	</div>
                  	<div class="col-md-8">	
                  	<div>
                 		<script type="text/javascript">
					

						$(document).ready(function(){
					   	$(".at_timeline").click(function(){
					   		$(".list").slideUp();
					   		$(".time_line").slideDown();
					   	});
					   	$(".at_oject").click(function(){
					   		$(".list").slideDown();
					   		$(".time_line").slideUp();
					   		$(".form_teacher").hide();

					   	});
					});

						 </script>
						<style type="text/css">
						.blog{
							display: none;
						}
						.body{
							display: block;
						}
						</style>
                  		<ul class="nav nav-tabs">
							  <li role="presentation" ><a class="at_timeline" href="#">Trang cá nhân</a></li>
							  <li role="presentation"><a  class="at_oject" href="#">Các khóa học</a></li>

						</ul>
                  	</div>
                  	<style>
                  	.form-stt {
						    margin-left: 64px;
						    margin-top: 30px;
						    width: 100%;
						}
						.media-body	fieldset{
								border: 1px solid #c0c0c0;
								padding: 10px;
							}
                  	</style>
                 <?php if($user_id == $this->session->userdata('member_id')): ?>
                 	<div class="form_teacher">
                <form class="form-horizontal" role="form" action="" method="post">
							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Title</label>
							<div class="col-sm-10">
							  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="title">
							</div>
							</div>

							<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Conten</label>
							<div class="col-sm-10">
							  	<textarea name="content"></textarea>
							</div>
							</div>
                  		
                  			<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
							  	<input class="btn btn-success" name="dang" type="submit" value="Đăng" >
							</div>
							</div>
                  			
                  	</form>
                  	</div>
                  <?php endif; ?>
						<div class="time_line">
						<div class="media">
						
						<?php
							//echo $info_teacher[0]['user_id'];
$teacher_stt = $ci->core->show_all('timeline_teacher','time_user_id',$info_teacher[0]['user_id'],4,'time_id');

						  // echo"<pre>";
							 // var_dump($teacher_stt);
							 // echo"<pre/>";
						?>

						  <div class="media-body">
						  <?php
						  		foreach($teacher_stt as $stt) :
						   ?>
						  <fieldset>
						  	<legend><?php echo $stt["time_title"]; ?></legend>
						  	<?php echo $stt["time_conten"]; ?>
						  </fieldset>
						  <?php endforeach; ?>
						  </div>


						</div>

						</div>
						<?php //var_dump($list_hoc) ?>
						<div class="list" style="display:none; padding-top:10px">
				<ul role="main" class="item-list" id="course-list">

					<?php 
						foreach ($list_hoc as $item) :
							
					?>
				<li style="list-style:none;">
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
				 		echo '<a href="'.SITE_DIR.'main_default/readschool?post_id='.$item["post_id"].'" ><strong><i class="fa fa-mail-forward"></i> Đăng ký Tham Gia</strong></a>';
				 } else{
				 	echo '<a href="#" class="dk_school"><strong><i class="fa fa-mail-forward"></i> Đăng ký Tham Gia</strong></a>';
				 }
				 	?>
				
							</div>
				<div class="item-instructor">
					<div class="instructor_course">
					
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
							</div>
                  	</div>
                </div>
        </div>
    </div>
</section>
<?php
include 'layout/footer.php';
?>