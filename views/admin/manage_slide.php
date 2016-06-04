<?php
include('layout/header.php');
include('layout/menu_admin.php');
//$error = validation_errors();
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
$mes_error = $this->session->userdata('ms_error');
$mes_success = $this->session->userdata('ms_success');
?>
<div class="col-md-12">
    <div class="page-head">
        <h1> <small>Cài đặt</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Cài đặt</a></li>
            <li class="active"><i class="fa fa-edit"></i>Tạo liên kết</li>
        </ol>
        <hr>
        <div class="col-md-10">
            <div class="widget-content" style="display: block;">
                <div class="padd">
                    <?php
//                    if (!empty($error)) {
//                        echo " <div class='alert alert-danger'>" . $error . "</div>";
//                    }
                    if (!empty($mes_error)) {
                        echo "<div class='alert alert-danger'><i class='fa fa-times'></i>" . $mes_error . "</div>";
                        $this->session->unset_userdata('ms_error');
                    }
                    if (!empty($mes_success)) {
                        echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert'>×</button>
                      " . $mes_success . "</div>";
                        $this->session->unset_userdata('ms_success');
                    }
                    ?>

         <?php 
                        if($count <= 5){
                            ?>
                    <!-- Form starts.  -->
                    <form action="<?php echo SITE_DIR; ?>main/validation_slide" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-2 control-label no-padding-right">Ảnh mô tả <label style='color:red'>(*)</label></label>
                            <div class="col-md-6">
                                <?php
                                if (isset($p_image)) {
                                    $service_image = $p_image;
                                } else {
                                    $service_image = SITE_DIR . "theme/admin/img/noimages.jpg";
                                }
                                ?>
                                <input type="text" id="xFilePath" value="<?php
                                if (isset($_POST['image']))
                                    echo $_POST['image'];
                                else
                                    echo $service_image;
                                ?>" readonly="readonly" name="slide" size="60" class="form-control" style="width: 200px; float: left; margin-right: 10px;" />
                                <input width="100px;float: left;" class="btn btn-success"  type="button" value="Thêm ảnh" onclick="BrowseServer();">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">&nbsp;</label>
                            <div class="col-md-10">
                                <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="300" height="100px" /> 

                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-8">
                                    <button type="submit" class="btn btn-success">Thêm ảnh banner</button>
                                </div>
                            </div>
            
                    </form>
                     <?php
                        }else{
                            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert'>×</button>
                      Bạn không thể tạo nhiều hơn 6 link liên kết. hãy xóa bớt link để có thể thêm link khác !</div>";
                        }
                    ?>
                                      <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <?php
                                    foreach ($list as $image) {
                                        ?>
                                        <p><img  src="<?php echo $image['s_link'] ?>" id="previewxFilePath" width="300" height="100" /></p>
                                        <a onclick="return confirm('Bạn thật sự muốn xóa ảnh này đi')" type="submit" href="<?php echo SITE_DIR ?>main/delete_image/<?php echo $image['s_id'] ?>" class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i> Xóa</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>   
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include('layout/footer.php'); ?>