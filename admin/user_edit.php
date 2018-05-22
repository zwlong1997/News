<?php
include('./includes/config.php');
include('./check_admin.php');

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

$sql="SELECT * FROM {$pre_}user  WHERE user_id = $user_id";
$userInfo=getOne($sql);

if(!$user_id || !$userInfo){
    show_msg("该用户不存在，请重新选择","user_list.php");
    exit;
}

if($_POST){
  $arr=array(
    "user_name"=>trim($_POST['user_name']),
    "user_email"=>$_POST['user_email'],
    "user_phone"=>$_POST['user_phone'],
    "user_desc"=>$_POST['user_desc'],
    "user_time"=>time()
    );
  $affect_id=update("{$pre_}user",$arr,"user_id=$user_id");
  if($affect_id){
    show_msg("用户修改成功","user_list.php");
    exit;
  }else{
    show_msg("用户修改失败","user_edit.php?user_id=$user_id");
  }


}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>user</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- 表单验证 -->
    <link rel="stylesheet" href="../public/Validform/style.css" />

    <!-- 网页编辑器 -->
    <link rel="stylesheet" href="../public/kindeditor/themes/default/default.css" />
    <script src="../public/kindeditor/kindeditor.js"></script>
    <script src="../public/kindeditor/lang/zh_CN.js"></script>
    <script>
      var editor;
      KindEditor.ready(function(K) {
        editor = K.create('textarea[name="user_content"]', {
          allowFileManager : true
        });
      });
    </script>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    
    <?php include('header.php');?>

    <?php include('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">编辑用户</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='user_list.php'"><i class="icon-list"></i> 返回用户列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form class="userAdd" id="user_add" action="#" method="post" enctype="multipart/form-data">
                            <label>用户姓名</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="user_name" value="<?php echo $userInfo['user_name'] ?>" class="input-xxlarge">
                            <label>用户邮箱</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="user_email" value="<?php echo $userInfo['user_email'] ?>" class="input-xxlarge">
                            <label>用户手机</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="user_phone" value="<?php echo $userInfo['user_phone'] ?>" class="input-xxlarge">
                            <label>用户内容</label>
                            <!-- <textarea name="user_content" value="" rows="3" class="input-xxlarge"><?php echo $userInfo['user_content'] ?></textarea> -->
                            <textarea name="user_desc" value="" rows="3" class="input-xxlarge"><?php echo $userInfo['user_desc'] ?></textarea>
                            <br/>
                            <input id="user_submit" class="btn btn-primary" type="submit" value="提交" />
                        </form>
                      </div>
                  </div>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer>
                    
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

    <script src="../public/Validform/jquery-1.6.2.min.js"></script>
    <script src="../public/Validform/Validform_v5.3.2_min.js"></script>
    <script>
        $('.userAdd').Validform();
    </script>
    
  </body>
</html>


