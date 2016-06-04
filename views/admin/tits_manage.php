<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
$success = $this->session->userdata('ms_success');
?>
<div class="matter">
    <div class="container">
        <div class="page-head">
            <h1> <small>Quản lý danh mục</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Danh mục</a></li>
                <li class="active"><i class="fa fa-edit"></i> Tin nổi bật</li>
            </ol>
        </div>  
        <hr>  
        <div class="col-md-12">
            <div class="widget wblue">
                <?php 
                    if(!empty($success)){
                        echo $success;
                    }
                ?>
                <div class="widget-head">
                    <div class="pull-left">Danh sách tin nổi bật</div>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                               
                                <th>Trạng thái</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php 
                            foreach ($tits as $tit)
                            {
                                ?>
                            <tr>
                                <td><?php echo $tit['tit_id'] ?></td>
                            <form action="<?php echo SITE_DIR ?>category/update_tit/<?php echo $tit['tit_id']?>" method="post">
                                <td><?php if(!empty($tid)) echo "<div class='col-md-8'>
                                <input type='text' name='tit' class='form-control' placeholder='Tiêu đề muốn thay đổi' value=''>
                            </div><button type='submit' class='btn btn-default'>Sửa</button>"; ?> <?php echo $tit['tit_name'] ?> 
                                </td>
                         </form>
                               
                              <td><span class="label label-success">Active</span></td>
                              <td>
                                    <button onclick="window.location = '<?php echo SITE_DIR ?>main/tits_manage/<?php echo $tit['tit_id'] ?>';" class="btn btn-xs btn-default " ><i class="fa fa-pencil-square-o"></i> Sửa tên</button>
                                   
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
</div>

<?php
include('layout/footer.php');
?>