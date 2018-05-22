<?php
include('./includes/config.php');
include('./check_admin.php');

$video_cate_id = isset($_GET['video_cate_id']) ? $_GET['video_cate_id'] : 0;

$sql="SELECT * FROM {$pre_}video_cate WHERE video_cate_id = $video_cate_id";
$videoInfo=getOne($sql);

if(!$video_cate_id || !$videoInfo){
    show_msg("该视频分类不存在，请重新选择","video_cate_list.php");
    exit;
}

if($_POST){
  $arr=array(
    "video_cate_name_ch"=>trim($_POST['video_cate_name_ch']),
    "video_cate_name_en"=>trim($_POST['video_cate_name_en'])
    );
  $affect_id=update("{$pre_}video_cate",$arr,"video_cate_id=$video_cate_id");
  if($affect_id){
    show_msg("视频分类修改成功","video_cate_list.php");
    exit;
  }else{
    show_msg("视频分类修改失败","video_edit.php?video_cate_id=$video_cate_id");
  }


}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>video</title>
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
        editor = K.create('textarea[name="video_content"]', {
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
            <h1 class="page-title">编辑视频</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='video_cate_list.php'"><i class="icon-list"></i> 返回视频列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form class="videoAdd" id="video_add" action="#" method="post" enctype="multipart/form-data">
                            <label>视频中文标题</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="video_cate_name_ch" value="<?php echo $videoInfo['video_cate_name_ch'] ?>" class="input-xxlarge">
                            <label>视频英文标题</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="video_cate_name_en" value="<?php echo $videoInfo['video_cate_name_en'] ?>" class="input-xxlarge">
                            
                            <br>
                            <input id="video_submit" class="btn btn-primary" type="submit" value="提交" />
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
        $('.videoAdd').Validform();
    </script>
    
  </body>
</html>


