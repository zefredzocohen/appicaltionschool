<?php
$ms_error = $this->session->userdata('ms_error');
$ms_success_product = $this->session->userdata('ms_success_product');
$this->load->helper('form');
?>
<div class="containerz">
    <div class="boxl pull-left">

        <div class="tit"><a href="" title="">đăng kí trực tuyến</a></div>
                <?php
        if(!empty($ms_error))
        {
            echo "<p class='bg-danger'>".$ms_error." </p>";
             $this->session->unset_userdata('ms_error');
        }   
       if(!empty($ms_success_product))
        {
            echo "<p class='bg-success'>".$ms_success_product." </p>";
             $this->session->unset_userdata('ms_success_product');
        } 
        
            ?>
       
        <form class="form-horizontal" role="form" action="<?php echo SITE_DIR ?>register/register_online" method="post">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Họ và tên <span>*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="name"  class="form-control" id="inputEmail3" placeholder="Họ và tên">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Địa chỉ</label>
                <div class="col-sm-6">
                    <input type="text" name="address" class="form-control" id="inputEmail3" placeholder="Địa chỉ">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Email <span>*</span></label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Điện thoại <span>*</span></label>
                <div class="col-sm-6">
                    <input type="text" name="phone" class="form-control" id="inputEmail3" placeholder="Điện thoại">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Ngày sinh </label>
                <div class="col-sm-6">
                    <input type="date" name="date" class="form-control" id="inputEmail3" placeholder="Ngày tháng năm sinh">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Đối tượng </label>
                <div class="col-sm-6">
                    <select class="form-control" name="object">
                        <option value="THCS">Đã tốt nghiệp THCS</option>
                        <option value="THPT">Đã tốt nghiệp THPT</option>
                        <option value="TCCN">Đã tốt nghiệp TCCN</option>
                        <option value="CĐ">Đã tốt nghiệp CĐ</option>
                        <option value="ĐH">Đã tốt nghiệp ĐH</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Đăng ký hệ</label>
                <div class="col-sm-6">
                    <select class="form-control" name="system">
                        <option value="Chính quy">Chính quy</option>
                        <option value="Liên thông">Liên thông</option>
                        <option value="Tại chức">Tại chức</option>
                        <option value="Từ xa">Từ xa</option>
                    </select>
                </div>
            </div>
            <label class="control-label"><strong><span>(*)</span></strong>: không được để trống.</label> 
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary btn-sm">Đăng ký</button>
                    <button type="submit" class="btn btn-default btn-sm">Hủy</button>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div><!--boxl-->
    <div class="boxr pull-right">
        <div class="pro_box">
            <div class="tit"><a href="" title="">Tin tức nổi bật</a></div>
            <ul class="media-list clearfix">
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://ytp.edu.vn/uploads/images/2014/07/09/thumb_200x0_14048780262255.jpg" alt="...">
                    </a>
                    <div class="media-body">
                        <a class="pull-left" href="#"><h5 class="media-heading">Thông báo Tuyển sinh Liên thông Cao đẳng 2014</h5></a>
                    </div>
                </li>
            </ul>
            <ul class="media-list clearfix">
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://ytp.edu.vn/uploads/images/2014/07/09/thumb_200x0_14048780262255.jpg" alt="...">
                    </a>
                    <div class="media-body">
                        <a class="pull-left" href="#"><h5 class="media-heading">Thông báo Tuyển sinh Liên thông Cao đẳng 2014</h5></a>
                    </div>
                </li>
            </ul>
            <ul class="media-list clearfix">
                <li class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://ytp.edu.vn/uploads/images/2014/07/09/thumb_200x0_14048780262255.jpg" alt="...">
                    </a>
                    <div class="media-body">
                        <a class="pull-left" href="#"><h5 class="media-heading">Thông báo Tuyển sinh Liên thông Cao đẳng 2014</h5></a>
                    </div>
                </li>
            </ul>
        </div><!--pro-box-->
        <div class="pro_box">
            <div class="tit"><a href="" title="">Liên kết website</a></div>
            <select class="form-control" onchange="redirect(this.value, '_blank')">
                <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
                <option value="http://www.moet.gov.vn/">Trường Đại Học Thành Đô</option>
                <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
                <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
                <option value="http://www.moet.gov.vn/">Bộ Giáo Dục Và Đào Tạo</option>
            </select>
        </div><!--pro-box-->
        <div class="clearfix"></div>
    </div><!--boxr-->
    <div class="clearfix"></div>	
</div>
<?php
include 'layout/footer.php';
?>