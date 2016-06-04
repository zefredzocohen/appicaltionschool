<?php
include('layout/header.php');
include('layout/menu_admin.php');
$ses = $this->session->userdata('user_id');
if (empty($ses)) {
    redirect('admincp');
}
?>

<div class="page-head">
    <!-- Page heading -->
    <h2 class="pull-left">Quản lý hệ thống đào tạo trực tuyến
        <!-- page meta -->
        <span class="page-meta">Something Goes Here</span>
    </h2>
    <!-- Breadcrumb -->
    <div class="bread-crumb pull-right">
        <a href="index.html"><i class="fa fa-home"></i> Trang Chủ</a> 
        <!-- Divider -->
        <span class="divider">/</span> 
        <a href="#" class="bread-current">Quản lý hệ thống đào tạo trực tuyến</a>
    </div>
    <div class="clearfix"></div>
</div>



<?php include('layout/footer.php'); ?>