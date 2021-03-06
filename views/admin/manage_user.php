<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ses = $this->session->userdata('user_id');
$level= $this->session->userdata('user_level');
if (empty($ses)) {
    redirect('admincp');
}
$ses = $this->session->userdata('ms_success');
?>
<div class="matter">
    <div class="container" style="margin-top: 15px;">
        <div class="page-head">
            <h1> <small>Thành viên</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Thành Viên</a></li>
                <li class="active"><i class="fa fa-edit"> </i>Quản lý thành viên</li>
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
        <div class="col-md-12">
            <div class="widget wblue">
                <div class="widget-head">
                    <div class="pull-left">Tất cả người dùng đã đăng ký</div>
                    <div class="widget-icons pull-right">
                        <a class="wminimize" href="#"><i class="fa fa-chevron-up"></i></a> 
                        <a class="wclose" href="#"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="widget-content medias">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Ảnh đại diện</th> 
                            <th>Chức danh</th>   
                            <th>Hoạt động</th>   
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($list as $data) {
                            ?>

                            <tr>

                                <td><?php echo $data['user_id']; ?></td>                                                
                                <td style="width: 150px"><?php echo $data['user_name']; ?></td>
                                <td style="width: 300px"><?php echo $data['user_email']; ?></td>
                               
                                <td ><img src="<?php echo $data['user_avata']; ?>"></td>
                                 <td ><?php 
                                    switch ($data['user_leve']) {
                                        case 2:
                                            echo "Thành viên quản trị";
                                            break;
                                         case 1:
                                            echo "<p style='color:red'>Supper Admin</p>"; 
                                            break;
                                        case 3:
                                            echo "<p style='color:blue'>Giảng Viên</p>"; 
                                            break;
                                        
                                    }

                                 ?></td>
                                <td>
                                    <?php if($level == 1){
                                        ?>
                                    <a onclick="return confirm('You sure you want to delete <?php echo $data['user_name']; ?>')" type="submit" href="<?php echo SITE_DIR ?>user/delete_user/<?php echo $data['user_id'] ?>" class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i> Xóa </a>
                                    <button class="btn btn-xs btn-default" onclick="window.location = '<?php echo SITE_DIR ?>user/edit_user/<?php echo $data['user_id'] ?>';"><i class="fa fa-pencil-square-o"></i> Sửa</button>
                                 <?php
                                    } 
                                        ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>    
                </table>
            </div>
        </div>
    </div>  
</div>
<?php include('layout/footer.php'); ?>