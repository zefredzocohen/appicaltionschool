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
        <div class="col-md-8">
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
                    <form action="<?php echo SITE_DIR; ?>main/validate_link" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tên Liên Kết <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" placeholder="Title">
                            </div>
                        </div>
           
                            <div class="form-group">
                                <label class="col-md-3 control-label">Gán link</label>
                                <div class="col-md-8">
                                    <input type="text" name="link" class="form-control" placeholder="https://www.google.com.vn/" >
                                </div>
                            </div>

                            <div class="form-group">
                            <label class="col-md-3 control-label no-padding-right">Ảnh mô tả <label style='color:red'>(*)</label></label>
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
                                ?>" readonly="readonly" name="image" size="60" class="form-control" style="width: 200px; float: left; margin-right: 10px;" />
                                <input width="100px;float: left;" class="btn btn-success"  type="button" value="Thêm ảnh" onclick="BrowseServer();">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-6">
                                <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="200" /> 

                            </div>
                        </div>
         
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-8">
                                <button type="submit" class="btn btn-success">Tạo liên kết</button>
                                
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

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Widget -->
            <div class="widget wblue">
                <!-- Widget title -->
                <div class="widget-head">
                    <div class="pull-left">Chi tiết Liên kết đã tạo</div>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                    <div class="padd">
                        <hr>
                        <?php
                        foreach ($list as $cats) {
                            echo "<div class='check-box'>
                                            <label><input type='checkbox' value='check1'> ";
                            if ($cats['link_name']) {
                                echo $cats['link_name']."<br/>";
                                echo "|----" . $cats['link']."</label>";
                                echo "<img src='" . $cats['link_image']."' width='100'>";
                            }
                            echo "<a onclick='return confirm('Bạn thật sự muốn xóa danh mục ')' href='".SITE_DIR."main/delete_link/".$cats['link_id']."' class='pull-right btn btn-xs btn-danger delete'>Xóa</a>";
                           echo "</div>";
                              ?>
                 
                        <?php
                        }
                        ?>
                        <hr>
                    </div>
                    <div class="padd">
                    </div>
                </div>
            </div> 
        </div>
    </div>  
</div>
<?php include('layout/footer.php'); ?>