<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ci = &get_instance();
$ci->load->model('model_core', 'core');
$error = validation_errors();
$mes_error = $this->session->userdata('ms_error');
$mes_success = $this->session->userdata('ms_success_product');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
if (!empty($pid)) {
    $title = "Sửa bài viết";
    foreach ($view_set_id_post as $post) {
        $p_name = $post['post_title'];
        $p_desc = $post['post_desc'];
        $p_text = $post['post_content'];
        $p_image = $post['post_image'];
        $p_cat = $post['cat_id'];
        $p_status = $post['post_status'];
        $p_parent = $post['post_parrent'];
    }
} else {
    $view_set_id_post[0]['tit_id'] = "";
    $title = "Tạo bài viết";
}
$ses = $this->session->userdata('ms_success');

?>
<div class="matter">
    <div class="container" style="margin-top: 15px;">
        <div class="page-head">
            <h1> <small>Bài Viết</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Bài viết</a></li>
                <li class="active"><i class="fa fa-edit"></i><?php echo $title; ?></li>
            </ol>
            
        </div>  
        <?php 
             if (!empty($ses)) {
               echo "<div class='alert alert-dismissable alert-success'>
                  <button type='button' class='close' data-dismiss='alert'>×</button>
                  " . $ses . "</div>";
                      $this->session->unset_userdata('ms_success');
                    }
        ?>
        <hr>   
        <?php
        if (!empty($error)) {
            echo " <div class='alert alert-danger'>" . $error . "</div>";
        }
        if (!empty($mes_error)) {
            echo "<div class='alert alert-danger'><i class='fa fa-times'></i>" . $mes_error . "</div>";
            $this->session->unset_userdata('ms_error');
        }
        if (!empty($mes_success)) {
            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert'>×</button>
                      " . $mes_success . "</div>";
            $this->session->unset_userdata('ms_success_product');
        }
        ?>

        <!-- Form starts.  -->
        <form action="<?php echo SITE_DIR; ?>post/add_post<?php if (!empty($pid)) echo "/" . $pid; ?><?php if(isset($_GET['post_type'])) echo "?post_type=".$_GET['post_type'] ?>" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-md-2 control-label">Tiêu Đề <label style='color:red'>(*)</label></label>
                <div class="col-md-8">
                    <input type="text" name="title" class="form-control" placeholder="Title" value='<?php if (isset($p_name)) echo $p_name; ?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Mô tả ngắn <label style='color:red'>(*)</label></label>
                <div class="col-md-8">
                    <textarea class="form-control" placeholder="description" name="desc" ><?php if (isset($p_desc)) echo $p_desc; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Nội dung <label style='color:red'>(*)</label></label>
                <div class="col-md-8">
                    <textarea class="form-control ckeditor" placeholder="Content Product" name="content"><?php if (isset($p_text)) echo $p_text; ?></textarea>
                </div>
            </div>  

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
                    ?>" readonly="readonly" name="image" size="60" class="form-control" style="width: 200px; float: left; margin-right: 10px;" />
                    <input width="100px;float: left;" class="btn btn-success"  type="button" value="Thêm ảnh" onclick="BrowseServer();">
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">&nbsp;</label>
                <div class="col-md-10">
                    <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="100" /> 
                </div>
            </div>
            <?php if(isset($_GET['post_type']) && $_GET['post_type']=="school_online"){
                    if(!empty($pid)){
                        $get_meta_teacher = $ci->core->get_post_meta($pid,"_teacher");
                        $get_meta_price = $ci->core->get_post_meta($pid,"_price");
                        $get_meta_groupsize = $ci->core->get_post_meta($pid,"_groupsize");
                        $get_meta_time= $ci->core->get_post_meta($pid,"_time");
                    }
                    ?>
                    <input type="hidden" name="new_id_for_meta" value="<?= $new_id_post[0]["post_id"]+1; ?>">
                    <div class="form-group">
                <label class="col-md-2 control-label">Giáo viên <label style='color:red'>(*)</label></label>
                <div class="col-md-8">
                    <select name="teacher" class="form-control">
                        <option value="">Chọn Giáo Viên</option>
                        <?php
                        foreach ($teacher as $name) {
                           ?>
                           <option <?php if(isset($get_meta_teacher) && $get_meta_teacher[0]['meta_value'] == $name['user_id']) echo 'selected="selected"'; ?> value="<?php echo $name['user_id'] ?>">
                           <?php echo $name['user_name'] ?>
                           </option>
                           <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
                     <div class="form-group">
                        <label class="col-md-2 control-label">Giá Khóa Học</label></label>
                        <div class="col-md-8">
                             <input type="text" name="price"  class="form-control" placeholder="Giá Khóa Học" value='<?php if (isset($get_meta_price)) echo $get_meta_price[0]["meta_value"]; ?>'>
                        </div>
                    </div>  
            
          
                    <?php
                }else if($_GET['post_type']=="page"){
                    ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tin nổi bật </label>
                        <div class="col-md-8">
                            <select name="tit" class="form-control">
                                <option value="">Chọn mục tin</option>
                                <?php

                                foreach ($tits as $tit) {
                                    ?>
                                    <option <?php if($view_set_id_post[0]['tit_id'] == $tit['tit_id'] ) echo "selected='selected'";  ?> value="<?= $tit['tit_id']  ?>"><?= $tit['tit_name']  ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                }else if($_GET['post_type'] != "about"){
                    if($_GET["post_type"] == "lesson"){
                        $list_scholl =   $ci->core->show_all("posts","post_type","school_online");
                        ?>
                        <div class="form-group">
                        <label class="col-md-2 control-label">Khóa Học <label style='color:red'>(*)</label></label>
                             <div class="col-md-8">
                                <select name="lesson" class="form-control">
                                    <option value="">-- Bài Giảng Cho khóa học --</option>
                                    <?php
                                    foreach ($list_scholl as $item) {
                                       ?>
                                       <option <?php if(isset($p_parent) && $p_parent == $item['post_id']){ echo 'selected="selected"'; } ?>  value="<?php echo $item['post_id'] ?>">
                                              <?php echo $item['post_title'] ?>
                                       </option>
                                       <?php
                                    }
                                    ?>
                                </select>   
                        </div>
                        </div>
                       
                        <?php
                    }else{
                ?>

            <div class="form-group">
                <label class="col-md-2 control-label">Danh Mục <label style='color:red'>(*)</label></label>
                <div class="col-md-8">
                    <select name="category" class="form-control">
                        <option value="">Chọn danh mục</option>
                        <?php
                        foreach ($dequy_category as $cat) {
                            echo "<option  ";
                            if (isset($p_cat)) {
                                if ($cat['cat_id'] == $p_cat)
                                    echo "selected='selected'";
                            }
                            echo "value='" . $cat['cat_id'] . "'>" . $cat['cat_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php if($_GET['post_type'] != "blog"): ?>
            <div class="form-group">
                <label class="col-md-2 control-label">Tin nổi bật </label>
                <div class="col-md-8">
                    <select name="tit" class="form-control">
                        <option value="">Chọn mục tin</option>
                        <?php
                        foreach ($tits as $tit) {
                            echo "<option  ";
                            if (isset($pid)) {
                                if ($tit['tit_id'] == $pid)
                                    echo "selected='selected'";
                            }
                            echo "value='" . $tit['tit_id'] . "'>" . $tit['tit_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
              <?php
                     }
                    } ?>
  

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-success"><?php echo $title; ?></button>
                    <a href="<?php echo SITE_DIR ?>post/manage_post" class="btn btn-default ">Tất cả bài viết</a>
                </div>
            </div>
        </form>
    </div>  
</div>
<?php include('layout/footer.php'); ?>