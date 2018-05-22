<?php include('./includes/config.php');
      include('./check_admin.php');


if($_POST){
  $arr=array(
    "video_cate_name_ch"=>trim($_POST['video_cate_name_ch']),
    "video_cate_name_en"=>trim($_POST['video_cate_name_en']),
    );

    $insert_id=insert("{$pre_}video_cate",$arr);
    if($insert_id){
      show_msg('添加视频分类成功',"video_cate_list.php");
        exit;
    }else{
        show_msg('添加视频分类失败',"video_cate_add.php");
        exit;
    }

}


 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>video_cate</title>
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
    
    
<?php include("header.php"); ?>
    
<?php include("menu.php"); ?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">添加视频分类</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='video_cate_list.php'"><i class="icon-list"></i>视频分类列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form id="video_cate_add" action="video_cate_add.php" method="post" enctype="multipart/form-data">
                            <label>视频中文标题</label>
                            <input type="text" name="video_cate_name_ch" value="" class="input-xxlarge">
                            <label>视频英文标题</label>
                            <input type="text" name="video_cate_name_en" value="" class="input-xxlarge">
                            <br>

                            <input id="video_cate_submit" class="btn btn-primary" type="submit"  value="提交" />
                        </form>
                      </div>
                  </div>
                </div>

                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                  </div>
                  <div class="modal-body">
                    
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
                  </div>
                  <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
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
    
  </body>
</html>


