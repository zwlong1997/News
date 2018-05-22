<?php 
  include('./includes/config.php');
  @session_start();
  $logout=isset($_GET['action']) ? $_GET['action'] : false;
  if($logout == "logout"){
    session_destroy();
    header("Location:login.php");
    exit;
  }


  if($_POST){
    
    if($_POST['imgcode'] != $_SESSION['imgcode']){
      show_msg("验证码错误","login.php");
      exit;
    }

    $admin_name=trim($_POST['admin_name']);
    $admin_pwd=md5($_POST['admin_pwd']);

    $sql="SELECT * FROM {$pre_}admin WHERE admin_name='$admin_name' AND admin_pwd = '$admin_pwd'";
    $admin_info=getOne($sql);
    if($admin_info){
      $_SESSION['admin_id'] =$admin_info['admin_id'];
      $_SESSION['admin_name'] =$admin_info['admin_pwd'];
      show_msg("登录成功","index.php");
      exit;
    }else{
      show_msg("登录失败","login.php");
      exit;
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>login</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="index.html"><span class="second">Admin</span></a>
        </div>
    </div>

    <div class="row-fluid">
        <div class="dialog">
            <div class="block">
                <p class="block-heading">登录</p>
                <div class="block-body">
                    <form action="#" method="post">
                        <label>用户名</label>
                        <input type="text" class="span12" name="admin_name">
                        <label>密码</label>
                        <input type="password" class="span12" name="admin_pwd">
                        <label>输入验证码</label>
                        <input type="text" class="span12" name="imgcode">
                        <img src="imgcode.php" alt="" onclick="this.src='imgcode.php';">
                        <button class="btn btn-primary pull-right">登录</button>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


