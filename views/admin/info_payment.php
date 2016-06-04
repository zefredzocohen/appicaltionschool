<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ci = &get_instance();
$ci->load->model('model_core', 'core');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$ci->core->update(array("value"=>addslashes($_POST['pay_tt'])),"setting","name","pay_tt");
	$ci->core->update(array("value"=>addslashes($_POST['pay_qt'])),"setting","name","pay_qt");

}
?>
<div class="matter">
    <div class="container" style="margin-top: 15px;">
        <div class="page-head">
            <h1> <small>Thông Tin Thanh Toán</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
                <li class="active"><i class="fa fa-edit"></i>Thông Tin</li>
            </ol>
            <form action="" method="post">
	            <div class="form-group">
	                <label class="col-md-2 control-label">Thông tin thanh toán trực tiếp<label style='color:red'>(*)</label></label>
	                <div class="col-md-10">
	                    <textarea class="form-control ckeditor" placeholder="Content Product" name="pay_tt"><?php echo $ci->core->get_option("pay_tt"); ?></textarea>
	                </div>
	            </div>  
	            <div class="form-group">
	                <label class="col-md-2 control-label">Thông tin thanh toán qua thẻ<label style='color:red'>(*)</label></label>
	                <div class="col-md-10">
	                    <textarea class="form-control ckeditor" placeholder="Content Product" name="pay_qt"><?php echo $ci->core->get_option("pay_qt"); ?></textarea>
	                </div>
	            </div>  
	            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-success">Save</button>
                    
                </div>
            </div>
	        
            </form>
        </div>  
   	</div>
</div>

<?php include('layout/footer.php'); ?>