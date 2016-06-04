<?php
$validation = validation_errors();
$message_login = $this->session->userdata('error_login');
//$ses = $this->session->userdata('user_id');
if (!empty($ses)) {
//    var_dump($ses);die;
//    redirect('main');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- Title here -->
        <title>Login Test</title>
        <!-- Description, Keywords and Author -->
        <meta name="description" content="Your description">
        <meta name="keywords" content="Your,Keywords">
        <meta name="author" content="ResponsiveWebInc">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Styles -->
        <!-- Bootstrap CSS -->
        <link href="<?php echo SITE_ADMIN ?>css/bootstrap.min.css" rel="stylesheet">
        <!-- Font awesome CSS -->
        <link href="<?php echo SITE_ADMIN ?>css/font-awesome.min.css" rel="stylesheet">		
        <!-- Custom CSS -->
        <link href="<?php echo SITE_ADMIN ?>css/style.css" rel="stylesheet">

        <!-- Favicon -->
        <link rel="shortcut icon" href="#">
    </head>

    <body>

        <!-- Form area -->
        <div class="admin-form">
            <!-- Widget starts -->
            <div class="widget worange">
                <!-- Widget head -->
                <div class="widget-head">
                    <i class="fa fa-lock"></i> Đăng Nhập Thi
                </div>
                <?php
//                if (!empty($validation)) {
//                    echo "<div class='alert alert-warning'>" . $validation . "</div>";
//                }
                if ($message_login) {
                    echo "<div class='alert alert-warning'>" . $message_login . "</div>";
                    $this->session->unset_userdata('error_login');
                }
                ?>
                <div class="widget-content">
                    <div class="padd">
                        <!-- Login form -->
                        <form class="form-group" action="<?php echo SITE_DIR; ?>site/login/validation_login" method="post">
                            <!-- Email -->
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="inputEmail">Tài Khoản</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control" id="inputEmail" placeholder="Tài Khoản">
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="form-group">
                                <label class="control-label col-lg-3" for="inputPassword">Mật Khẩu</label>
                                <div class="col-lg-9">
                                    <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Mật Khẩu">
                                </div>
                            </div>
                            <!-- Remember me checkbox and sign in button -->
                            <div class="form-group">
                                <div class="col-lg-9 col-lg-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Ghi Nhớ Đăng Nhập
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-lg-offset-3">
                                    <button type="submit" class="btn btn-danger">Đăng Nhập</button>
                                    <button type="reset" class="btn btn-default">Quên Mật Khẩu</button>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="widget-foot">
                     <a href="#">SVNTEAM 2014</a>
                </div>
            </div>  
        </div>


        <!-- Javascript files -->
        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Respond JS for IE8 -->
        <script src="js/respond.min.js"></script>
        <!-- HTML5 Support for IE -->
        <script src="js/html5shiv.js"></script>
    </body>	
</html>