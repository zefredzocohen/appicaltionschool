<?php
$get_session = $this->session->userdata('user_name');
$avata = $this->session->userdata('user_avata');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <!-- Title here -->
        <title>Quản Lý Đào Tạo Trực Tuyến</title>
        <!-- Description, Keywords and Author -->
        <meta name="description" content="Your description">
        <meta name="keywords" content="Your,Keywords">
        <meta name="author" content="ResponsiveWebInc">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Styles -->
        <!-- Bootstrap CSS -->
        <link href="<?php echo SITE_ADMIN; ?>css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery UI -->
        <link rel="stylesheet" href="<?php echo SITE_ADMIN; ?>css/jquery-ui.css"> 
        <!-- jQuery Gritter -->
        <link rel="stylesheet" href="<?php echo SITE_ADMIN; ?>css/jquery.gritter.css">
        <link href="<?php echo SITE_ADMIN;?>css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo SITE_ADMIN;?>css/style-quiz.css" rel="stylesheet">
        <!-- Font awesome CSS -->
        <link href="<?php echo SITE_ADMIN; ?>css/font-awesome.min.css" rel="stylesheet">		
        <!-- Custom CSS -->
        <link href="<?php echo SITE_ADMIN; ?>css/style.css" rel="stylesheet">
        <!-- Widgets stylesheet -->
        <link href="<?php echo SITE_ADMIN; ?>css/widgets.css" rel="stylesheet"> 
        <script src="<?php echo SITE_ADMIN; ?>js/jquery.js"></script>
        <script src="<?php echo SITE_ADMIN; ?>js/jquery.js">
        var base_url = '<?php echo base_url();?>';
        </script>
        <script src="<?php echo SITE_ADMIN; ?>js/basic.js"></script>
        <script src="<?php echo SITE_DIR; ?>client_script/ckeditor/ckeditor.js"></script>
        <script src="<?php echo SITE_DIR; ?>client_script/ckfinder/ckfinder.js"></script>
        <script type="text/javascript">
        function BrowseServer()
        {
        
            var finder = new CKFinder();
           // The path for the installation of CKFinder (default = "/ckfinder/").
           // finder.basePath = 'ckeditor/'; 
            finder.selectActionFunction = SetFileField;
            finder.popup();
            
        }
        function SetFileField( fileUrl )
        {
           document.getElementById( 'xFilePath' ).value = fileUrl;
         
          $("#previewxFilePath").attr("src", fileUrl);
        }
         function BrowseServer2()
        {
        
            var finder = new CKFinder();
           // The path for the installation of CKFinder (default = "/ckfinder/").
           // finder.basePath = 'ckeditor/'; 
            finder.selectActionFunction = SetFileField2;
            finder.popup();
            
        }
         function SetFileField2( fileUrl )
        {
           document.getElementById( 'xFilePath2' ).value = fileUrl;
         
          $("#previewxFilePath2").attr("src", fileUrl);
        }
        
       
    </script>

        <!-- Favicon -->
        <link rel="shortcut icon" href="#">
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
            <div class="container">
                <!-- Menu button for smallar screens -->
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.html" class="navbar-brand">Hệ thống quản lý <span class="bold">Đào Tạo Trực Tuyến</span></a>
                </div>
                <!-- Site name for smallar screens -->
                <!-- Navigation starts -->
                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">     
                    <!-- Links -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">            
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img src="<?php echo $avata ?>" alt="" class="nav-user-pic img-responsive" /><?php echo $get_session; ?> <b class="caret"></b>  
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                                <li><a href="#"><i class="fa fa-cogs"></i> Settings</a></li>
                                <li><a href="<?php echo SITE_DIR ?>login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main content starts -->
        <div class="content">
            