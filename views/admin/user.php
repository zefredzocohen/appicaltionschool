<?php
include('layout/header.php');
include('layout/menu_admin.php');
$error = validation_errors();
$ses = $this->session->userdata('user_id');
$level= $this->session->userdata('user_level');
if (empty($ses)) {
    redirect('admincp');
}
$mes_error = $this->session->userdata('ms_error');
$mes_success = $this->session->userdata('ms_success');
?>
<div class="col-md-12">
    <div class="page-head">
        <h1> <small>Thành viên</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Thành viên</a></li>
            <li class="active"><i class="fa fa-edit"></i> Tạo mới thành viên</li>
        </ol>
        <hr>
        <div class="col-md-8">
            <div class="widget-content" style="display: block;">
                <div class="padd">
                    <?php
                    if (!empty($error)) {
                        echo " <div class='alert alert-danger'>" . $error . "</div>";
                    }
//                    if (!empty($mes_error)) {
//                        echo "<div class='alert alert-danger'><i class='fa fa-times'></i>" . $mes_error . "</div>";
//                        $this->session->unset_userdata('ms_error');
//                    }
                    if (!empty($mes_success)) {
                        echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert'>×</button>
                      " . $mes_success . "</div>";
                        $this->session->unset_userdata('ms_success');
                    }
                    ?>

                    <?php 
                        if($level == 1){
                            ?>
                   
                    <!-- Form starts.  -->
                    <form action="<?php echo SITE_DIR; ?>user/validate_user<?php if(isset($info_user)) echo "/".$id_user; ?>" method="post" class="form-horizontal" role="form">
                      <div class="form-group">
                            <label class="col-md-3 control-label">Tên Thành viên <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" name="name" value="<?php if(isset($info_user)) echo $info_user[0]['user_name']; ?>" class="form-control" placeholder="Tên đăng nhập">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Tên Hiển Thị <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" name="name_show" value="<?php if(isset($info_user)) echo $info_user[0]['name']; ?>" class="form-control" placeholder="Tên  hiển thị">
                            </div>
                        </div>

                       <div class="form-group">
                             <label class="col-md-3 control-label">Mật khẩu <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="password" value="<?php if(isset($info_user)) echo $info_user[0]['user_pass']; ?>" name="pass" class="form-control" placeholder="*********">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nhập lại mật khẩu <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="password" value="<?php if(isset($info_user)) echo $info_user[0]['user_pass']; ?>" name="pass2" class="form-control" placeholder="*********">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label">Email <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="email" value="<?php if(isset($info_user)) echo $info_user[0]['user_email']; ?>" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Birthday <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" value="<?php if(isset($info_user)) echo $info_user[0]['user_birdhday']; ?>" name="bd" class="form-control" placeholder="birthday">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Số điện thoại <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" value="<?php if(isset($info_user)) echo $info_user[0]['user_sdt']; ?>" name="phone" class="form-control" placeholder="phone">
                            </div>
                        </div>
                         
                           <div class="form-group">
                            <label class="col-md-3 control-label">Adress <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                <input type="text" value="<?php if(isset($info_user)) echo $info_user[0]['user_adress']; ?>" name="adress" class="form-control" placeholder="adress">
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="col-md-3 control-label">Work <label style='color:red'>(*)</label></label>
                            <div class="col-md-8">
                                 <textarea class="form-control ckeditor" placeholder="description" name="work"><?php if(isset($info_user)) echo $info_user[0]['user_work']; ?></textarea>
                            </div>
                        </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label no-padding-right">Ảnh đại diện <label style='color:red'>(*)</label></label>
                        <div class="col-md-6">
                            <?php
                            if (isset($info_user)) {
                                $service_image = $info_user[0]['user_avata'];
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
                        <div class="form-group">
                        <label class="control-label col-md-2">&nbsp;</label>
                        <div class="col-md-6">
                            <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="100" /> 
                        </div>
                    </div>

                    </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Phân quyền Thành viên</label>
                            <div class="col-md-8">
                                <select name="level" class="form-control">
                                
                                    <option >Phân quyền</option>
                                    <option <?php if(isset($info_user[0]['user_leve']) && $info_user[0]['user_leve'] == 1){echo "selected='selected'"; } ?> value="1">Supper Admin</option>
                                    <option <?php if(isset($info_user[0]['user_leve']) && $info_user[0]['user_leve'] == 2){echo "selected='selected'"; } ?> value="2">Thành viên quản trị</option>
                                    <option <?php if(isset($info_user[0]['user_leve']) && $info_user[0]['user_leve'] == 3){echo "selected='selected'"; } ?> value="3">Giáo Viên</option>
                                    <option <?php if(isset($info_user[0]['user_leve']) && $info_user[0]['user_leve'] == 4){echo "selected='selected'"; } ?> value="4">Người Dùng</option>
                                </select>
                            </div>

                        </div>
                       


                     <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-success">Tạo thàn viên</button>
                            <a href="<?php echo SITE_DIR ?>post/manage_post" class="btn btn-default ">Tất cả thành viên</a>
                        </div>
                    </div>
                    </form>
                     <?php
                        }else{
                            echo "<div class='alert alert-dismissable alert-success'>
                      <button type='button' class='close' data-dismiss='alert'>×</button>
                      Bạn không có đủ quyền để truy cập vào phần nội dung này !</div>";
                        }
//                    ?>

                </div>
            </div>
        </div>
    </div>  
</div>
<?php include('layout/footer.php'); ?>