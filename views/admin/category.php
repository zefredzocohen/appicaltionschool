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

if (!empty($cid)) {
    $title = "Sửa Danh Mục";
    foreach ($edit_category as $cat) {
        $cat_id = $cat['cat_id'];
        $cat_name = $cat['cat_name'];
        $cat_type = $cat['cat_type'];
        $cat_link = $cat['cat_link'];
        $cat_orderby = $cat['cat_order'];
    }
} else {
    $title = "Tạo Danh Mục";
}
?>
<div class="col-md-12">
    <div class="page-head">
        <h1> <small><?php echo $title; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Danh mục</a></li>
            <li class="active"><i class="fa fa-edit"></i><?php echo $title; ?></li>
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


                    <!-- Form starts.  -->
                    <form action="<?php echo SITE_DIR; ?>category/validation_category<?php if (!empty($cid)) echo "/" . $cid; ?>" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tên Danh Mục <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" placeholder="Title" value="<?php if (isset($cat_name)) echo $cat_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Tạo danh mục con</label>
                            <div class="col-md-8">
                                <select name="cat_type" class="form-control">
                                    <option value="0">--Menu Root--</option>
                                    <?php
                                    foreach ($category as $cat) {
                                        echo "<option ";
                                        if (isset($cat_type) && $cat_type == $cat['cat_id']) {
                                            echo "selected='selected'";
                                        }
                                        echo " value='" . $cat['cat_id'] . "'>" . $cat['cat_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="alert alert-info">
                                    Nếu muốn tạo danh mục cha thì chọn --Menu Root-- .<br/>
                                    Nếu muốn tạo danh mục con thì chọn danh mục cha.
                                </div>
                            </div>

                        </div>
                        <?php
                        if (!empty($cid)) {
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Gán link</label>
                                <div class="col-md-8">
                                    <input type="text" name="link" class="form-control" placeholder="https://www.google.com.vn/" value='<?php if (isset($cat_link)) echo $cat_link; ?>'>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Trạng thái</label>
                            <div class="col-md-8">
                                <select name="cat_status" class="form-control">
                                    <option value="1">Hiện thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Số thứ tự</label>
                            <div class="col-md-8">
                                <select name="cat_order" class="form-control">
                                <?php 
                                if(!empty($cid)){
                                      foreach ($cat_order as $cat) {
                                         $count = count($cat,COUNT_RECURSIVE);
                                         for ($i=0; $i <= $count; $i++) {                
                                       ?>
                                        <option <?php if(isset($cat_order) && $cat_orderby == $i) { echo "selected='selected'"; }  ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                       <?php
                                         }
                                        }
                                }else{

                                    foreach ($cat_order as $cat) {
                                        $count = count($cat,COUNT_RECURSIVE);
                                       ?>
                                        <option value="<?php echo $count+1; ?>"><?php echo $count+1; ?></option>
                                       <?php
                                        }
                                    }
                                ?> 
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-8">
                                <button type="submit" class="btn btn-success"><?php if (!empty($cid)) echo $title;
                        else echo "Tạo danh mục"; ?></button>
                                <a href="<?php echo SITE_DIR; ?>admin/manage_category" class="btn btn-default ">Xem toàn bộ danh mục</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Widget -->
            <div class="widget wblue">
                <!-- Widget title -->
                <div class="widget-head">
                    <div class="pull-left">Chi tiết danh mục đã tạo</div>
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
                        if(!empty($dequy_category))
                        foreach ($dequy_category as $cats) {
                            echo "<div class='check-box'>
                                            <label><input type='checkbox' value='check1'> ";
                            if ($cats['cat_type'] == 0) {
                                echo $cats['cat_name'];
                            } else {
                                echo "|----" . $cats['cat_name'];
                            }
                            if ($cats['cat_status'] == 1) {
                                echo "</label><span class='pull-right label label-success right'>Hiển thị</span></div>";
                            } else {
                                echo "</label><span class='pull-right label label-important right'>Ẩn</span></div>";
                            }
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