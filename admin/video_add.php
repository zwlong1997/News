<?php include('./includes/config.php');
      include('./check_admin.php');

$sql="SELECT * FROM ${pre_}video_cate";
$cate_list=getAll($sql);


if($_POST){
  $arr=array(
    "video_name"=>trim($_POST['video_name']),
    "video_url"=>$_POST['video_url'],
    "video_cate_id"=>$_POST['video_cate_id'],
    "video_time"=>time()
    );

    if($_FILES['video_pic']['error']==0){
      $new_file=upload_file("video_pic","../static/uploads/video");
      if($new_file){
        $arr['video_pic']="uploads/video/".$new_file;
      }
    }

    $insert_id=insert("{$pre_}video",$arr);
    if($insert_id){
      show_msg('视频添加成功',"video_list.php");
        exit;
    }else{
        show_msg('视频添加失败',"video_add.php");
        exit;
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
            <h1 class="page-title">添加视频</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='video_list.php'"><i class="icon-list"></i>视频列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form id="video_add" action="video_add.php" method="post" enctype="multipart/form-data">
                            <label>视频标题</label>
                            <input type="text" name="video_name" value="" class="input-xxlarge">
                            <label>视频URL</label>
                            <input type="password" value="" class="input-xxlarge" name="video_url">
                            <label>封面</label>
                            <input type="file" name="video_pic" value="" class="input-xxlarge">
                            <label>视频分类</label>
                            <select name="video_cate_id" id="">
                                <option value="">请选择</option>
                                <?php foreach ($cate_list as $key => $item){ ?>
                                  <option value="<?php echo $item['video_cate_id'] ?>"><?php echo $item['video_cate_name_ch'] ?></option>
                                <?php } ?>
                            </select>
                            <br>

                            <input id="video_submit" class="btn btn-primary" type="submit"  value="提交" />
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


