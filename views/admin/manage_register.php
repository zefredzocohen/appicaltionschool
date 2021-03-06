<?php
$ci = &get_instance();
include('layout/header.php');
include('layout/menu_admin.php');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
$ses = $this->session->userdata('ms_success');
$ci->load->model('model_core', 'core');
?>
<div class="matter">
    <div class="container">
        <div class="page-head">
            <h1> <small>Mục đăng ký học</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Đăng ký</a></li>
                <li class="active"><i class="fa fa-edit"></i>Tất cả người dùng đăng ký</li>
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
                            <th>Thành viên</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>     
                            <th>Khóa học</th>   
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($list_register as $data) {
                            ?>

                            <tr>

                                <td><?php echo $data['en_id']; ?></td>                                                
                                <td style="width: 150px"><?php echo $data['en_name']; ?></td>
                                <td style="width: 300px"><?php echo $data['en_address']; ?></td>
                                <td ><?php echo $data['en_email']; ?></td>
                                <td><?php echo $data['en_date']; ?></td>
                                
                                <td> 
                                <?php 
                                $post = $ci->core->show_all("posts","post_id",$data['post_id']);
                                echo $post[0]['post_title']; 
                                ?>
                                </td>
                                <td ><?php if($data['en_pay_type'] == "pay_tt"){echo "Trực tiếp."; }else{echo "Thẻ Thanh toán."; } ?></td>
                                <td><?php  if($data['en_status'] == 0){ echo "<a class='btn-success' href='".SITE_DIR."register/check_shool/".$data['en_id']."/".$data['en_name']."'><span class='label label-success pull-right'>Duyệt</span</a>"; }else{ echo "<a class='btn-success' href='".SITE_DIR."register/check_shool/".$data['en_id']."/".$data['en_name']."'><span class='label btn-danger pull-right'>Từ Chối</span</a>";; } ?></td>
                                <td>
                                    <a onclick="return confirm('You sure you want to delete <?php echo $data['en_name']; ?>')" type="submit" href="<?php echo SITE_DIR ?>register/delete_user/<?php echo $data['en_id'] ?>" class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i> Xóa </a>
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