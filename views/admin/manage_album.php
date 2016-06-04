<?php
$ci = &get_instance();
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
        <h1> <small>Thư viện ảnh</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Thư viện</a></li>
            <li class="active"><i class="fa fa-edit"></i> Tất cả album</li>
        </ol>
        <hr>
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
        <form action="<?php echo SITE_DIR; ?>main/validation_album" method="post" class="form-horizontal" role="form">
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
                    <img  src="<?php echo $service_image; ?>" id="previewxFilePath" width="190" height="190" /> 

                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-8">
                        <button type="submit" class="btn btn-success">Thêm ảnh banner</button>
                    </div>
                </div>

        </form>
        <div class="col-md-12">

            <div class="widget wblue">
                <div class="widget-head">
                    <div class="pull-left">Thư viện ảnh</div>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                    <div class="padd">

                        <div class="gallery">
                            <?php
                            foreach ($list as $image){
                                ?>
                            
                            <!-- Full size image link in anchor tag. Thumbnail link in image tag. -->
                           
                            <a href="<?php echo $image['ga_link'] ?>" class="prettyPhoto[pp_gal]"><img src="<?php echo $image['ga_link'] ?>" alt=""></a>
                        <a onclick="return confirm('Bạn thật sự muốn xóa ảnh này đi')" type="submit" href="<?php echo SITE_DIR ?>main/delete_image_album/<?php echo $image['ga_id'] ?>" class="btn btn-sm btn-default" ><i class="fa fa-trash-o"></i></a> |

                                 <?php
                                if($image['ga_type'] > 0){
                                    echo "<a type='submit' href='".SITE_DIR."main/set_image_index/".$image['ga_id']."/0'><i class='fa fa-arrow-up green'></i></a>";
                                }else{
    
                                     echo "<a type='submit' href='".SITE_DIR."main/set_image_index/".$image['ga_id']."/1'><i class='fa fa-arrow-down red'></i></a>";
                                }
                             ?>
                            <?php
                            }
                            ?>
                           
                        </div>

                    </div>
                </div>
                					
		</ul>

            </div>  
             <ul class="pagination pull-right">
		<?php
                echo "<li>".$this->pagination->create_links()."</li>";
                ?>	
        </div>
    </div>
    <?php include('layout/footer.php'); ?>