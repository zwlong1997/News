<?php
include('./includes/config.php');
include('./check_admin.php');
$sql="SELECT * FROM ${pre_}video_cate";
$cate_list=getAll($sql);

$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : 0;

$sql="SELECT * FROM {$pre_}video as video LEFT JOIN {$pre_}video_cate as video_cate ON video.video_cate_id = video_cate.video_cate_id WHERE video_id = $video_id";
$videoInfo=getOne($sql);

if(!$video_id || !$videoInfo){
    show_msg("该视频不存在，请重新选择","video_list.php");
    exit;
}

if($_POST){
  $arr=array(
    "video_name"=>$_POST['video_name'],
    "video_url"=>$_POST['video_url'],
    "video_cate_id"=>$_POST['video_cate_id'],
    );

  //判断是否有上传图片
    if($_FILES['video_pic']['error']==0){
      $new_file=upload_file("video_pic","../static/uploads/video");
      if($new_file){
        $arr['video_pic']="uploads/video/".$new_file;
      }
    }

  $affect_id=update("{$pre_}video",$arr,"video_id=$video_id");
  if($affect_id){
    show_msg("视频修改成功","video_list.php");
    exit;
  }else{
    show_msg("视频修改失败","video_edit.php?video_id=$video_id");
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
        editor = K.create('textarea[name="video_url"]', {
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
                    <button class="btn btn-primary" onClick="location='video_list.php'"><i class="icon-list"></i> 返回视频列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form class="videoAdd" id="video_add" action="#" method="post" enctype="multipart/form-data">
                            <label>视频标题</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="video_name" value="<?php echo $videoInfo['video_name'] ?>" class="input-xxlarge">
                            <label>视频URL</label>
                            <input datatype="*" errormsg="输入有误" type="text" name="video_url" value="<?php echo $videoInfo['video_url'] ?>" class="input-xxlarge">
                            <label>封面</label>
                            <?php if(!empty($videoInfo['video_pic'])){ ?>
                            <img src="../static/<?php echo $videoInfo['video_pic'] ?>" alt="" style="width:150px;height: 150px;">
                            <?php } ?>
                            <input type="file" name="video_pic" value="" class="input-xxlarge">
                            <label>视频分类</label>
                            <select name="video_cate_id" id="">
                            
                                <option value="">请选择</option>
                                <?php foreach ($cate_list as $key => $item){ ?>
                                  <option <?php echo $videoInfo['video_cate_id']==$item['video_cate_id'] ? "selected" : "" ?> value="<?php echo $item['video_cate_id'] ?>"><?php echo $item['video_cate_name_ch'] ?></option>
                                <?php } ?>
                            </select>
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


