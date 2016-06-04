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
            <h1> <small>Bài viết</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Bài viết</a></li>
                <li class="active"><i class="fa fa-edit"></i>Tất cả bài viết</li>
            </ol>
        </div>  <hr>   
        <div class="col-md-12">
            <div class="widget wblue">
                <div class="widget-head">
                    <div class="pull-left">Quản lý bài viết</div>
                    <div class="widget-icons pull-right">
                        <a class="wminimize" href="#"><i class="fa fa-chevron-up"></i></a> 
                        <a class="wclose" href="#"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="search">
                    <ul>
                        <li class="col-sm-6">
                            <label class="col-md-4  control-label" for="">Lọc theo danh mục:</label>
                            <div class="col-md-8">
                                <select onchange="document.adminForm.submit();" name="category" class="form-control">   
                                    <option value="0">Tất cả</option>  
                                    <?php
                                    foreach ($category as $cat) {
                                        ?>
                                        <option value="<?php echo $cat['cat_id'] ?>"><?php echo $cat['category_name'] ?></option>  
                                        <?php
                                    }
                                    ?>                                                 
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <br />
            <div class="widget-content medias">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>tiêu đề</th>
                            <th>Ảnh đại diện</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
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
                                <td><img src="<?php echo $data['post_image']; ?>" width="150" height="150px"></td>
                                
                                <td>
                                    <?php
                                    foreach ($category as $cat) {
                                        if ($cat['cat_id'] == $data['cat_id']) {
                                            echo $cat['category_name'];
                                        }
                                    }
                                    ?> 
                                    <br/>
                                     <?php
                                    foreach ($tits as $tit) {
                                        if ($tit['tit_id'] == $data['tit_id']) {
                                            echo $tit['tit_name'];
                                        }
                                    }
                                    ?> 
                                <td><?php if($data['post_status'] == 1){
                                        echo "<span class='label label-success pull-right'>Hiển thị</span>";   
                                         }else {
                                           echo "<span class='label label-important pull-right'>Ẩn</span>";
                                         } ?>
                                    </td>
                                </td>
                                <td><?php echo date("d/m/Y", strtotime($data['post_date'])); ?></td>

                                <td>
                                    <button onclick="window.location = '<?php echo SITE_DIR ?>post/post_view/<?php echo $data['post_id'] ?>?post_type=<?php if(!empty($post_type)) echo $post_type; ?>';" class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Sửa</button>
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