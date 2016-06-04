<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
?>
<div class="matter">
    <div class="container" style="margin-top: 15px;">
        <div class="page-head">
            <h1> <small>Liên hệ</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Liên hệ</a></li>
                <li class="active"><i class="fa fa-edit"></i>Tất cả liên hệ</li>
            </ol>
        </div>  <hr>   
        <div class="col-md-12">
            <div class="widget wblue">
                <div class="widget-head">
                    <div class="pull-left">Quản lý liên hệ</div>
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
                            <th>Tên người dùng</th>
                            <th>Email</th>
                 
                            <th>Nội dung</th>
                            <th>Thời gian tạo</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($post as $data) {
                            ?>

                            <tr>

                                <td><?php echo $data['post_id']; ?></td>                                                
                                <td style="width: 500px"><?php echo $data['post_title']; ?></td>
                                <td><?php echo $data['post_desc']; ?></td>
                                 <td><?php echo $data['post_content']; ?></td>
                    
                                <td><?php echo date("d/m/Y", strtotime($data['post_date'])); ?></td>

                                <td>
                                    
                                    <a onclick="return confirm('You sure you want to delete <?php echo $data['post_title'] ?>')" type="submit" href="<?php echo SITE_DIR ?>post/delete_post/<?php echo $post_type ?>/<?php echo $data['post_id'] ?>" class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i>Xóa </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>    
                </table>
                <ul class="pagination pull-right">
		<?php
                echo "<li>".$this->pagination->create_links()."</li>";
                ?>						
		</ul>

            </div>
        </div>
    </div>  
</div>
<?php include('layout/footer.php'); ?>