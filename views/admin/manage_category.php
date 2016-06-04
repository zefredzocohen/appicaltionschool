<?php
include('layout/header.php');
include('layout/menu_admin.php');
$mes_success = $this->session->userdata('ms_success');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
?>
<div class="matter">
    <div class="container">
        <div class="page-head">
            <h1> <small>Quản lý danh mục</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Danh mục</a></li>
                <li class="active"><i class="fa fa-edit"></i> Toàn bộ danh mục</li>
            </ol>
        </div>  
        <?php 
             if (!empty($mes_success)) {
               echo "<div class='alert alert-dismissable alert-success'>
                  <button type='button' class='close' data-dismiss='alert'>×</button>
                  " . $mes_success . "</div>";
                      $this->session->unset_userdata('ms_success');
                    }
        ?>
        <hr>   
        <div class="col-md-12">
            <div class="widget wblue">
                <div class="widget-head">
                    <div class="pull-left">Danh mục</div>
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
                            <th>STT</th>
                            <th>Tên danh mục</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if(!empty($dequy_category))
                        foreach ($dequy_category as $data) {
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>                                                
                                <td><?php echo $data['cat_name']; ?></td>
                                <td><?php if($data['cat_status'] == 1){
                               echo "<span class='label label-success pull-right'>Hiển thị</span>";   
                                }else {
                                  echo "<span class='label label-important pull-right'>Ẩn</span>";
                                } ?>
                                    </td>
                                <td>
                                    <button onclick="window.location = '<?php echo SITE_DIR ?>category/category_index/<?php echo $data['cat_id'] ?>';" class="btn btn-xs btn-default pull-right" ><i class="fa fa-pencil-square-o"></i> Sửa</button>
                                    <a onclick="return confirm('Bạn thật sự muốn xóa danh mục <?php echo $data['cat_name']; ?>')" type="submit" href="<?php echo SITE_DIR ?>category/delete_category/<?php echo $data['cat_id'] ?>" class="btn btn-xs btn-danger delete pull-right"><i class="fa fa-trash-o"></i> Xóa</a>
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