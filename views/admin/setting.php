<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ci = &get_instance();
$ci->load->model('model_core', 'core');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$ci->core->update(array("value"=>addslashes($_POST['address'])),"setting","name","address");
	$ci->core->update(array("value"=>addslashes($_POST['logo'])),"setting","name","logo");
	$ci->core->update(array("value"=>addslashes($_POST['banner_page'])),"setting","name","banner_page");
    $ci->core->update(array("value"=>addslashes($_POST['title'])),"setting","name","title");

}
?>
<div class="matter">
    <div class="container">
        <div class="page-head">
            <h1> <small>Thông Tin</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
                <li class="active"><i class="fa fa-edit"></i>Thông Tin</li>
            </ol
            
            <form action="" method="post" class="form-horizontal">
	            <div class="form-group">
	                <label class="col-md-2 control-label">Thông tin liên hệ <label style='color:red'>(*)</label></label>
	                <div class="col-md-10">
	                    <textarea class="form-control ckeditor" placeholder="Content Product" name="address"><?php echo $ci->core->get_option("address"); ?></textarea>
	                </div>
	            </div>  

	             <div class="form-group">
                <label class="col-md-2 control-label no-padding-right">Logo <label style='color:red'>(*)</label></label>
                <div class="col-md-6">
                    <?php
                    if (!empty($ci->core->get_option("logo"))) {
                        $service_image = $ci->core->get_option("logo");
                    } else {
                        $service_image = SITE_DIR . "theme/admin/img/noimages.jpg";
                    }
                    ?>
                    <input type="text" id="xFilePath" value="<?php
                    if (isset($_POST['logo']))
                        echo $_POST['logo'];
                    else
                        echo $service_image;
                    ?>" readonly="readonly" name="logo" size="60" class="form-control" style="width: 200px; float: left; margin-right: 10px;" />
                    <input width="100px;float: left;" class="btn btn-success"  type="button" value="Thêm ảnh" onclick="BrowseServer();">
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">&nbsp;</label>
                <div class="col-md-10">
                    <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="110"/> 

                </div>
                </div>


                <!-- banner page -->
                <div class="form-group">
                <label class="col-md-2 control-label no-padding-right">Banner Page <label style='color:red'>(*)</label></label>
                <div class="col-md-6">
                    <?php
                    if (!empty($ci->core->get_option("banner_page"))) {
                        $service_image = $ci->core->get_option("banner_page");
                    } else {
                        $service_image = SITE_DIR . "theme/admin/img/noimages.jpg";
                    }
                    ?>
                    <input type="text" id="xFilePath2" value="<?php
                    if (isset($_POST['banner_page']))
                        echo $_POST['banner_page'];
                    else
                        echo $service_image;
                    ?>" readonly="readonly" name="banner_page" size="60" class="form-control" style="width: 200px; float: left; margin-right: 10px;" />
                    <input width="100px;float: left;" class="btn btn-success"  type="button" value="Thêm ảnh" onclick="BrowseServer2();">
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">&nbsp;</label>
                <div class="col-md-10">
                    <img  src="<?php echo $service_image; ?>" id="previewxFilePath2" width="110"/> 

                </div>
                </div>
                <!--  end banner page-->
	          <div class="form-group">
                <label class="col-md-2 control-label">Tiêu Đề Web</label>
                <div class="col-md-8">
                    <input type="text" value="<?= $ci->core->get_option("title") ?>" placeholder="Title" class="form-control" name="title">
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