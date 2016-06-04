<?php
$ci = &get_instance();
include 'layout/header.php';
$ci->load->model('model_core', 'core');
$error = validation_errors();
$mes_error = $this->session->userdata('cf_pass');
$success = $this->session->userdata('ms_success');
$info_user = $this->session->userdata('member_id');

if(!empty($info_user)){
	$title = "Edit an Account";
	$if_user = $ci->core->show_all("users","user_id",$info_user);
}else{
	$title = "Create an Account";
}
?>
<body class="home-page home page page-id-1427 page-template page-template-notitle page-template-notitle-php wpb-js-composer js-comp-ver-4.3.4 vc_responsive">
<div id="global" class="global">
    <div class="pagesidebar">
        <div class="sidebarcontent">    
            <h2 id="sidelogo">
            <a href="#"><img src="<?php echo SITE_DEFAULT ?>images/logo.png" alt="Đột phá  cùng atcVN"></a>
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
                <div class="no content">
                    <img src="<?php echo base_url()?>uploads/files/banner-school.jpg">
                </div>
            </div>
        </div>
<div class="v_module v_column col-md-8 col-sm-8 v_first">
		
		<div class="content padder">		
		<div id="register-page" class="page">
			<form enctype="multipart/form-data" method="post"  action="<?php echo SITE_DIR ?>main_default/validate_register">
				<h2><?= $title ?></h2>
				<!-- <p>Registering for this site is easy, just fill in the fields below and we'll get a new account set up for you in no time.</p> -->
				<?php 
				if(!empty($error)){
			
					echo ' <div class="error">'.$error.'</div>';
				}
				if(!empty($mes_error)){

					echo ' <div class="error">'.$mes_error.'</div>';
				}
				$this->session->unset_userdata('cf_pass');
				if(!empty($success)){
					echo ' <div class="success">'.$success.'</div>'; 
				}
					$this->session->unset_userdata('ms_success');
				 ?>
				

				
				<div id="basic-details-section" class="register-section">
					<label  for="signup_username">Username <label style='color:red'>(*)</label></label>
						<input <?php if(isset($if_user)) echo 'readonly=""'; ?>  value="<?php if(isset($if_user)) echo $if_user[0]['user_name'] ?>" type="text" class="form_field"  name="signup_username">
					<label for="signup_email">Email Address <label style='color:red'>(*)</label></label>
						<input value="<?php if(isset($if_user)) echo $if_user[0]['user_email'] ?>" type="text" class="form_field"  name="signup_email">
					<label for="signup_password">Choose a Password <label style='color:red'>(*)</label></label>
						<input type="password" value="<?php if(isset($if_user)) echo $if_user[0]['user_pass'] ?>"  class="form_field" name="signup_password">
					<label for="signup_password_confirm">Confirm Password <label style='color:red'>(*)</label></label>
						<input type="password" value="<?php if(isset($if_user)) echo $if_user[0]['user_pass'] ?>"  class="form_field" name="cf_pass">			
				</div><!-- #basic-details-section -->	
					<!-- <div id="profile-details-section" class="register-section">
						<h4>Profile Details</h4>
							<div class="editfield">
									<label for="field_1">Name (required)</label>
							<input value="<?php //if(isset($if_user)) echo $if_user[0]['user_name'] ?>" type="text" id="field_1" class="form_field" name="field_1">
								<p id="field-visibility-settings-toggle-1" class="field-visibility-settings-notoggle">
									This field can be seen by:
									<span class="current-visibility-level">Everyone</span>
								</p>
								<p class="description"></p>
							</div>
							
							
	
						<input type="hidden" value="1,2,3" id="signup_profile_field_ids" name="signup_profile_field_ids">

					</div><!-- #profile-details-section -->
				
				<div class="submit">
					<input type="submit" value="Complete Sign Up" id="signup_submit" name="signup_submit">
				</div>

				<input type="hidden" value="ca808d237b" name="_wpnonce" id="_wpnonce"><input type="hidden" value="/register/" name="_wp_http_referer">
			
			
			
			</form>

		</div>

		
		</div><!-- .padder -->
		</div>
		<div class="v_module v_column col-md-4 col-sm-4 ">
<style>.custombanner img{
border:5px solid #FFF;
border-radius:2px;
box-shadow:0 1px 2px #bbb;
}</style><div class="v_module v_text_block  custombanner nothing_selected"><p>&nbsp;</p>
<p><a href="http://vibethemes.com/envato/wplms/course-cat/language/">
<img height="100" width="300" class="alignnone size-full wp-image-1442" alt="banner3" src="<?php echo base_url()?>theme/default/images/banner3.jpg"></a></p><p><a href="http://vibethemes.com/envato/wplms/course-cat/technology/">
<img height="100" width="300" class="alignnone size-full wp-image-1443" alt="banner4" src="<?php echo base_url()?>theme/default/images/banner4.jpg"></a></p></div>
</div>
</div>
</section>

     <?php include 'layout/khoahoc.php' ?>  
</section>
<?php
include 'layout/footer.php';
?>